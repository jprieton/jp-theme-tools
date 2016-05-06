<?php

/** Block direct access */
defined( 'ABSPATH' ) or die( 'No direct script access allowed' );

/** Constants */
define( 'JPTT_LIBRARIES', realpath( JPTT_PLUGIN_PATH . '/libraries' ) );
define( 'JPTT_TEXTDOMAIN', 'jptt' );

/** Required files */
require_once realpath( JPTT_PLUGIN_PATH . '/includes/class-jptt.php' );
require_once realpath( JPTT_PLUGIN_PATH . '/includes/functions.php' );
require_once realpath( JPTT_PLUGIN_PATH . '/includes/class-jptt-favorite.php' );
require_once realpath( JPTT_PLUGIN_PATH . '/includes/class-jptt-subscriber.php' );
require_once realpath( JPTT_PLUGIN_PATH . '/includes/class-jptt-user.php' );
require_once realpath( JPTT_PLUGIN_PATH . '/includes/featured.php' );
require_once realpath( JPTT_PLUGIN_PATH . '/includes/core.php' );
require_once realpath( JPTT_PLUGIN_PATH . '/includes/template.php' );
require_once realpath( JPTT_PLUGIN_PATH . '/includes/template-hooks.php' );

/** Admin menu */
add_action( 'admin_menu', function () {
	$parent_slug = 'jptt';

	/** Menu item */
	add_menu_page( 'JP Theme Tools Plugin Settings', 'JP Theme Tools', 'administrator', $parent_slug, function() {
		include_once JPTT_PLUGIN_PATH . '/_includes/admin/general-options.php';
	}, 'dashicons-admin-generic' );

	/** Submenu items */
	add_submenu_page( $parent_slug, 'JP Theme Tools - ' . __( 'General', JPTT_TEXTDOMAIN ), __( 'General', JPTT_TEXTDOMAIN ), 'administrator', $parent_slug, function() {
		include_once JPTT_PLUGIN_PATH . '/_includes/admin/general-options.php';
	} );

	add_submenu_page( $parent_slug, 'JP Theme Tools Plugin Settings - Anal&iacute;tica y SEO', ' Anal&iacute;tica y SEO', 'administrator', JPTT_PLUGIN_PATH . '/settings/seo.php' );
	add_submenu_page( $parent_slug, 'JP Theme Tools Plugin Settings - Contacto', 'Contacto', 'administrator', JPTT_PLUGIN_PATH . '/settings-contact.php' );
	add_submenu_page( $parent_slug, 'JP Theme Tools Plugin Settings - Social', 'Social', 'administrator', JPTT_PLUGIN_PATH . '/settings/social.php' );
	add_submenu_page( $parent_slug, 'JP Theme Tools Plugin Settings - CDN', 'CDN', 'administrator', JPTT_PLUGIN_PATH . '/settings/cdn.php' );
	add_submenu_page( $parent_slug, 'JP Theme Tools Plugin Settings - TimThumb', 'TimThumb', 'administrator', JPTT_PLUGIN_PATH . '/settings/timthumb.php' );

	add_submenu_page( $parent_slug, __( 'Settings' ), __( 'Settings' ), 'administrator', $parent_slug . '-settings', function() {
		include_once realpath( JPTT_PLUGIN_PATH . '/admin/general-settings.php' );
	} );
} );

require_once JPTT_PLUGIN_PATH . DIRECTORY_SEPARATOR . 'includes/class-jptt_instagram.php';
//require_once JPTT_PLUGIN_PATH . DIRECTORY_SEPARATOR . 'class-post-stats.php';

if ( is_admin() && !class_exists( 'Parsedown' ) ) {
	/** Required libraries */
	require_once JPTT_PLUGIN_PATH . '/libraries/parsedown.php';
}

/** Widgets */
require_once realpath( JPTT_PLUGIN_PATH . '/widgets/bs-sidebar-search.php' );
require_once realpath( JPTT_PLUGIN_PATH . '/widgets/bs-navbar-menu.php' );
require_once realpath( JPTT_PLUGIN_PATH . '/widgets/bs-navbar-search.php' );
require_once realpath( JPTT_PLUGIN_PATH . '/widgets/bs-navbar-subscribe.php' );

/** Enqueue plugin scripts */
add_action( 'admin_enqueue_scripts', function() {
	wp_enqueue_script( 'jp-theme-tools', JPTT_PLUGIN_URI . 'js/jp-theme-tools.js', array('jquery'), '1.0.0', true );
} );
