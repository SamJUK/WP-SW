<?php
require_once 'helper.php';

class Build_Script
{
    const BED_SYNTAX_VARIABLE_REPLACEMENT_REGEX = '/\/\*\s*BEDSW--VAR{(\w+)}\s*\*\//';
    const BED_SYNTAX_IF_STATEMENT_REPLACEMENT_REGEX = '/\/\*\s*BEDSW--IF{(\w+)}.+\*\/((?:.|\s)+?)\/\*\s*BEDSW--ENDIF{\1}\s*\*\//';

    private $helper;

    public function __construct()
    {
        $this->helper = new Build_Helper();
    }

    public function build()
    {
        $response = array('success' => true, 'message' => 'Service Worker Rebuilt Successfully');

        $this->updateVersionNumber();

        $templateContents = $this->getTemplateContents();
        $compiledContents = $this->compileServiceWorker($templateContents);
        $this->saveNewServiceWorker($compiledContents);

        echo json_encode($response);
        die;
    }

    private function updateVersionNumber ()
    {
        $oldServiceWorkerVersion = (int)get_option('bed-sw-swVersion');
        update_option('bed-sw-swVersion', (string)($oldServiceWorkerVersion+1));
    }

    private function fetchTemplateData()
    {
        return array(
            'cacheName' => $this->helper->getCacheName(),
            'filesToCache' => $this->helper->getFilesToCache(),
            'isDisabled' => get_option('bed-sw-isEnabled') !== '1'
        );
    }

    private function compileServiceWorker($template)
    {
        $templateData = $this->fetchTemplateData();
        $contents = $this->replaceBEDVariables($template, $templateData);
        $contents = $this->replaceBEDIFStatements($contents, $templateData);
        return $contents;
    }

    private function replaceBEDVariables($template, $templateData)
    {
        return preg_replace_callback(
            self::BED_SYNTAX_VARIABLE_REPLACEMENT_REGEX,
            function ($m) use ($templateData) {
                return json_encode($templateData[$m[1]]);
            },
            $template
        );
    }

    private function replaceBEDIFStatements($template, $templateData)
    {
        return preg_replace_callback(
            self::BED_SYNTAX_IF_STATEMENT_REPLACEMENT_REGEX,
            function ($m) use ($templateData) {
                return $templateData[$m[1]] ? $m[2] : '';
            },
            $template
        );
    }

    // @TODO: Is Opening with file() better performance?
    private function getTemplateContents()
    {
        return file_get_contents($this->helper->SERVICE_WORKER_TEMPLATE_PATH);
    }


    // @TODO: File methods may have better performance?
    private function saveNewServiceWorker($content)
    {
        unlink($this->helper->SERVICE_WORKER_BUILT_PATH);
        file_put_contents($this->helper->SERVICE_WORKER_BUILT_PATH, $content);
    }

}