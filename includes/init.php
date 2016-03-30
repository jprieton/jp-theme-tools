<?php

/** Constants */
define( 'JPTT_BASEPATH', realpath( __DIR__ . '/..' ) );
define( 'JPTT_SYSTEM', realpath( JPTT_BASEPATH . '/includes' ) );
define( 'JPTT_LIBRARIES', realpath( JPTT_BASEPATH . '/libraries' ) );
define( 'JPTT_TEXTDOMAIN', 'jptt' );

/** Required files */
require_once JPTT_SYSTEM . DIRECTORY_SEPARATOR . 'class-jptt.php';
require_once JPTT_SYSTEM . DIRECTORY_SEPARATOR . 'class-config.php';
//require_once JPTT_SYSTEM . DIRECTORY_SEPARATOR . 'class-input.php';
require_once JPTT_SYSTEM . DIRECTORY_SEPARATOR . 'class-jptt_instagram.php';
//require_once JPTT_SYSTEM . DIRECTORY_SEPARATOR . 'class-post-stats.php';

if ( is_admin() && !class_exists( 'Parsedown' ) ) {
	/** Required libraries */
	require_once JPTT_BASEPATH . '/libraries/parsedown.php';
}

/** Helpers */
require realpath( JPTT_BASEPATH . '/helpers/bootstrap.php' );

global $jptt;
$jptt = new \jptt\jptt();
$jptt instanceof \jptt\jptt;

/** Loads the plugin's translated strings */
add_action( 'plugins_loaded', function() {
	load_plugin_textdomain( 'jptt', false, JPTT_BASEPATH . DIRECTORY_SEPARATOR . 'languages' );
} );

/** Widgets */
require_once realpath( JPTT_BASEPATH . '/widgets/bs-sidebar-search.php' );
require_once realpath( JPTT_BASEPATH . '/widgets/bs-navbar-menu.php' );
require_once realpath( JPTT_BASEPATH . '/widgets/bs-navbar-search.php' );
require_once realpath( JPTT_BASEPATH . '/widgets/bs-navbar-subscribe.php' );
