<?php

/**
 * Class Build_Helper
 *
 * Helper class for our build script and related functions
 */

class Build_Helper
{

    public $SERVICE_WORKER_TEMPLATE_PATH;
    public $SERVICE_WORKER_BUILT_PATH;
    public $SERVICE_WORKER_BUILT_DIR;

    private $SITE_BASE_URL;


    public function __construct()
    {
        $this->SERVICE_WORKER_TEMPLATE_PATH = plugin_dir_path(__FILE__) . 'sw-template.js';
        $this->SERVICE_WORKER_BUILT_PATH = plugin_dir_path(__DIR__) . 'service-worker.js';
        $this->SERVICE_WORKER_BUILT_DIR = plugin_dir_url(__DIR__) . 'service-worker.js';
    }


    public function getCacheName() : string
    {
        $sitename = get_bloginfo('name');
        $enviroment = '';
        $version = get_option('bed-sw-swVersion');

        $cacheName = sprintf(
            '%s-%s-v%s',
            $sitename,
            $enviroment,
            $version
        );

        $cacheName = preg_replace('/[^\w\-]/', '-', $cacheName);
        $cacheName = preg_replace('/\-{2,}/', '-', $cacheName);

        return strtolower($cacheName);
    }


    public function getFilesToCache() : array
    {
        $files = array();
        $files = $this->getPagesToCache($files);
        $files = $this->getPostsToCache($files);
        $files = $this->getStylesToCache($files);
        $files = $this->getScriptsToCache($files);
        $files = apply_filters( 'after_bed_get_files_to_cache', $files);
        return $files;
    }


    // @TODO: Fix this; Not including Scripts site wide only on the admin page at the time of executing
    public function getScriptsToCache(array $files) : array
    {
        // We don' t want to cache pages so dont do anything
        if(get_option('cacheJS') !== '1') {
            return $files;
        }

        global $wp_scripts;
        $queue = $wp_scripts->queue;
        foreach ($queue as $handle) {
            $files[] = $wp_scripts->registered[$handle]->src;
        }

        return $files;
    }


    // @TODO: Fix this; Not including Styles site wide only on the admin page at the time of executing
    public function getStylesToCache(array $files) : array
    {
        // We don' t want to cache pages so dont do anything
        if(get_option('cacheCSS') !== '1') {
            return $files;
        }

        global $wp_styles;
        if(isset($wp_styles->queue)) {
            $queue = $wp_styles->queue;
            foreach ($queue as $handle) {
                $files[] = $wp_styles->registered[$handle]->src;
            }
        }

        return $files;
    }


    public function getPagesToCache(array $files) : array
    {
        // We don' t want to cache pages so dont do anything
        if(get_option('cachePages') !== '1') {
            return $files;
        }

        // @TODO: More Efficient way to do this?
        $pages = get_pages();
        foreach ($pages as $page) {
            $pageUrl = get_page_link($page->ID);
            $files[] = $this->convertAbsoluteUrlToRelative($pageUrl);
        }

        return $files;
    }


    public function getPostsToCache(array $files) : array
    {
        // We don't want to cache post so don't do anything
        if(get_option('cachePosts') !== '1') {
            return $files;
        }

        // @TODO: More Efficient way to do this?
        $posts = get_posts();
        foreach ($posts as $post) {
            $postUrl = get_post_permalink($post->ID);
            $files[] = $this->convertAbsoluteUrlToRelative($postUrl);
        }

        return $files;
    }


    private function convertAbsoluteUrlToRelative(String $url) : string
    {
        return str_replace(
            $this->getSiteBaseUrl(),
            '',
            $url
        );
    }


    // @TODO: Can we guarantee the home url is always going to be the base? And not /home etc
    private function getSiteBaseUrl() : string
    {
        if($this->SITE_BASE_URL === null) {
            $this->SITE_BASE_URL = get_home_url();
        }

        return $this->SITE_BASE_URL;
    }
}