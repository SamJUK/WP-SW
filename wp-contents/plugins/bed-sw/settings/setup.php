<?php
add_action('admin_menu', 'bed_sw_create_menu');

function bed_sw_create_menu() {

    //create new top-level menu
    add_menu_page('BED Service Worker', 'BED SW', 'administrator', 'bed_service_worker_settings' , 'bed_sw_settings_page');

    //call register settings function
    add_action( 'admin_init', 'register_bed_sw_settings' );
}


function register_bed_sw_settings() {
    //register our settings
    register_setting( 'bed-sw-settings-group', 'bed-sw-isEnabled' );
    register_setting( 'bed-sw-settings-group', 'bed-sw-swVersion' );
    register_setting( 'bed-sw-settings-group', 'bed-sw-cachePages' );
    register_setting( 'bed-sw-settings-group', 'bed-sw-cachePosts' );
    register_setting( 'bed-sw-settings-group', 'bed-sw-cacheJS' );
    register_setting( 'bed-sw-settings-group', 'bed-sw-cacheCSS' );
}

function bed_sw_settings_page()
{
    require_once BED_SW_PLUGIN_ROOT_PATH .'build/helper.php';
    $buildHelper = new Build_Helper();
    include 'page.phtml';
}

function select_boolean($name, $value)
{
    include 'yes_no.phtml';
}