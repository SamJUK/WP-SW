<?php
require_once BED_SW_PLUGIN_ROOT_PATH.'/build/helper.php';

add_action('wp_footer', 'bed_sw_footer');
function bed_sw_footer() {
    if(get_option('bed-sw-isEnabled') !== '1') {
        return;
    }

    // Render phtml file
    $helper = new Build_Helper();
    $serviceWorkerUrl = $helper->SERVICE_WORKER_BUILT_DIR;
    ob_start();
    include (BED_SW_PLUGIN_ROOT_PATH.'/views/register.phtml');
    echo ob_get_clean();
}


function bed_sw_register_offline_files_route() {
    register_rest_route('bed-sw', '/offlinefiles', [
        'methods' => WP_REST_Server::READABLE,
        'callback' => 'bed_sw_ajax_search'
    ]);
}

add_action( 'rest_api_init', 'bed_sw_register_offline_files_route');


function bed_sw_ajax_search() {
    $helper = new Build_Helper();
    $files = $helper->getFilesToCache();
    return rest_ensure_response($files);
}
