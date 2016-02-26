<?php

/** Constants */
define( 'JPTT_BASEPATH', realpath( __DIR__ . '/..' ) );
define( 'JPTT_SYSTEM', realpath( JPTT_BASEPATH . DIRECTORY_SEPARATOR . 'includes' ) );
define( 'JPTT_TEXTDOMAIN', 'jptt' );

/** Required files */
require_once JPTT_SYSTEM . DIRECTORY_SEPARATOR . 'core' . DIRECTORY_SEPARATOR . 'class-jptt.php';
require_once JPTT_SYSTEM . DIRECTORY_SEPARATOR . 'core' . DIRECTORY_SEPARATOR . 'class-config.php';
require_once JPTT_SYSTEM . DIRECTORY_SEPARATOR . 'core' . DIRECTORY_SEPARATOR . 'class-input.php';

global $jptt;
$jptt = new \jptt\jptt();

/** Loads the plugin's translated strings */
add_action( 'plugins_loaded', function() {
	load_plugin_textdomain( 'jptt', false, JPTT_BASEPATH . DIRECTORY_SEPARATOR . 'languages' );
} );
