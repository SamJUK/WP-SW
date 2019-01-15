<?php

/**
 * /wp-admin/admin-ajax.php?action=bed_build_sw
 */
add_action( 'wp_ajax_bed_build_sw', 'build_service_worker' );
function build_service_worker() {
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);

    require_once 'build.php';
    $buildScript = new Build_Script();
    $buildScript->build();
    wp_die();
}



function bed_sw_action_admin_notice() {
    $cookieName = 'sw_build_notice';
    
    if(!isset($_COOKIE[$cookieName]))
        return;

    $data = $_COOKIE[$cookieName];
    $data = str_replace('\\"', '"', $data);
    $data = json_decode($data, true);

    $class = 'notice ' . ($data['success'] === true ? 'updated' : 'error');
    $message = __($data['message']);

    printf( '<div class="%1$s"><p>%2$s</p></div>', esc_attr( $class ), esc_html( $message ) );

    setcookie($cookieName, null, -1, COOKIEPATH);
    unset($_COOKIE[$cookieName]);
}
add_action( 'admin_notices', 'bed_sw_action_admin_notice' );