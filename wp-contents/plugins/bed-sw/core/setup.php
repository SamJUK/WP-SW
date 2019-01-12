<?php

add_action( 'wp_enqueue_scripts', 'bed_sw_enqueue_script' );
function bed_sw_enqueue_script() {
    if(get_option('bed-sw-isEnabled') !== '1') {
        return;
    }

    require_once BED_SW_PLUGIN_ROOT_PATH . '/build/helper.php';
    $buildHelper = new Build_Helper();
    wp_enqueue_script( 'bed-sw', $buildHelper->SERVICE_WORKER_BUILT_DIR);
}

