<?php

/** Block direct access */
defined( 'ABSPATH' ) or die( 'No direct script access allowed' );

/** Constants */
define( 'JPTT_LIBRARIES', realpath( JPTT_BASEPATH . '/libraries' ) );
define( 'JPTT_TEXTDOMAIN', 'jptt' );

/** Required files */
require_once realpath( JPTT_BASEPATH . '/includes/class-jptt.php' );
require_once realpath( JPTT_BASEPATH . '/includes/functions.php' );
/** Favorite post module */
if ( jptt_get_option( 'module_favorite' ) ) {
	require_once realpath( JPTT_BASEPATH . '/includes/class-jptt-favorite.php' );
}
require_once realpath( JPTT_BASEPATH . '/includes/core.php' );

/** Admin menu */
add_action( 'admin_menu', function () {
	$parent_slug = 'jptt';

	/** Menu item */
	add_menu_page( 'JP Theme Tools Plugin Settings', 'JP Theme Tools', 'administrator', $parent_slug, function() {
		include_once JPTT_BASEPATH . '/_includes/admin/general-options.php';
	}, 'dashicons-admin-generic' );

	/** Submenu items */
	add_submenu_page( $parent_slug, 'JP Theme Tools - ' . __( 'General', JPTT_TEXTDOMAIN ), __( 'General', JPTT_TEXTDOMAIN ), 'administrator', $parent_slug, function() {
		include_once JPTT_BASEPATH . '/_includes/admin/general-options.php';
	} );

	add_submenu_page( $parent_slug, 'JP Theme Tools Plugin Settings - Anal&iacute;tica y SEO', ' Anal&iacute;tica y SEO', 'administrator', JPTT_BASEPATH . '/settings/seo.php' );
	add_submenu_page( $parent_slug, 'JP Theme Tools Plugin Settings - Contacto', 'Contacto', 'administrator', JPTT_BASEPATH . '/settings-contact.php' );
	add_submenu_page( $parent_slug, 'JP Theme Tools Plugin Settings - Social', 'Social', 'administrator', JPTT_BASEPATH . '/settings/social.php' );
	add_submenu_page( $parent_slug, 'JP Theme Tools Plugin Settings - CDN', 'CDN', 'administrator', JPTT_BASEPATH . '/settings/cdn.php' );
	add_submenu_page( $parent_slug, 'JP Theme Tools Plugin Settings - TimThumb', 'TimThumb', 'administrator', JPTT_BASEPATH . '/settings/timthumb.php' );
	add_submenu_page( $parent_slug, 'JP Theme Tools Plugin Settings - Modules', __( 'Modules', 'jptt' ), 'administrator', JPTT_BASEPATH . '/settings/modules.php' );

	add_submenu_page( $parent_slug, 'JP Theme Tools - ' . __( 'Settings', JPTT_TEXTDOMAIN ), __( 'Settings', JPTT_TEXTDOMAIN ), 'administrator', $parent_slug . '-settings', function() {
		include_once realpath( JPTT_BASEPATH . '/admin/general-settings.php' );
	} );
} );

require_once JPTT_BASEPATH . DIRECTORY_SEPARATOR . 'includes/class-jptt_instagram.php';
//require_once JPTT_BASEPATH . DIRECTORY_SEPARATOR . 'class-post-stats.php';

if ( is_admin() && !class_exists( 'Parsedown' ) ) {
	/** Required libraries */
	require_once JPTT_BASEPATH . '/libraries/parsedown.php';
}

/** Helpers */
require realpath( JPTT_BASEPATH . '/helpers/bootstrap.php' );

/** Loads the plugin's translated strings */
add_action( 'plugins_loaded', function() {
	load_plugin_textdomain( 'jptt', false, JPTT_BASEPATH . DIRECTORY_SEPARATOR . 'languages' );
} );

/** Widgets */
require_once realpath( JPTT_BASEPATH . '/widgets/bs-sidebar-search.php' );
require_once realpath( JPTT_BASEPATH . '/widgets/bs-navbar-menu.php' );
require_once realpath( JPTT_BASEPATH . '/widgets/bs-navbar-search.php' );
require_once realpath( JPTT_BASEPATH . '/widgets/bs-navbar-subscribe.php' );
