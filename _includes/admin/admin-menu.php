<?php

defined( 'ABSPATH' ) or die( 'No direct script access allowed' );

// if ( !is_admin() ) return;

add_action( 'admin_menu', function () {
	$parent_slug = 'jptt-settings';

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
	add_submenu_page( $parent_slug, 'JP Theme Tools Plugin Settings - Modules', __( 'Modules', 'jptt' ), 'administrator', JPTT_PLUGIN_PATH . '/settings/modules.php' );
} );
