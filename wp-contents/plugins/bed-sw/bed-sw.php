<?php
/*
Plugin Name: BED Service Worker
Plugin URI: https://www.bigeyedeers.co.uk/
Description: 🦄
Version: 1
Author: BED
Text Domain: bed-sw
*/

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

define('BED_SW_PLUGIN_ROOT_PATH', plugin_dir_path( __FILE__ ));
define('BED_SW_PLUGIN_ROOT_DIR', plugin_dir_url( __FILE__ ));

require_once 'build/setup.php';
require_once 'settings/setup.php';
require_once 'core/setup.php';