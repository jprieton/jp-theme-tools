<?php

/**
 * Plugin Name: JP WordPress Theme Tools
 * Plugin URI: https://github.com/jprieton/jp-theme-tools/
 * Description: Extends WordPress functionality for themes
 * Version: 0.6.2
 * Author: Javier Prieto
 * Author URI: https://github.com/jprieton/
 * License: GPL2
 */
defined('ABSPATH') or die("No script kiddies please!");

define('JPTT_PLUGIN_PATH', plugin_dir_path(__FILE__));
define('JPTT_PLUGIN_URI', plugin_dir_url(__FILE__));

require_once __DIR__ . '/functions/common-functions.php';
require_once __DIR__ . '/ajax/contact.php';
require_once __DIR__ . '/filters/common-filters.php';
require_once __DIR__ . '/includes/actions.php';

if (is_admin()) {

	// Updater
	require_once __DIR__ . '/includes/updater.php';

	add_action('admin_menu', 'theme_tools_admin_menu');

	function theme_tools_admin_menu()
	{
		add_menu_page('JP Theme Tools Plugin Settings', 'JP Theme Tools', 'administrator', __DIR__ . '/admin-options.php', '', 'dashicons-admin-generic');
		add_submenu_page(__DIR__ . '/admin-options.php', 'JP Theme Tools Plugin Settings - Generales', 'Generales', 'administrator', __DIR__ . '/admin-options.php');
		add_submenu_page(__DIR__ . '/admin-options.php', 'JP Theme Tools Plugin Settings - Contacto', 'Contacto', 'administrator', __DIR__ . '/settings-contact.php');
		add_submenu_page(__DIR__ . '/admin-options.php', 'JP Theme Tools Plugin Settings - Social', 'Social', 'administrator', __DIR__ . '/settings-social.php');
		add_submenu_page(__DIR__ . '/admin-options.php', 'JP Theme Tools Plugin Settings - CDN', 'CDN', 'administrator', __DIR__ . '/settings-cdn.php');
		add_submenu_page(__DIR__ . '/admin-options.php', 'JP Theme Tools Plugin Settings - Misceláneas', 'Misceláneas', 'administrator', __DIR__ . '/settings-misc.php');
		add_submenu_page(__DIR__ . '/admin-options.php', 'JP Theme Tools Plugin Settings - TimThumb', 'TimThumb', 'administrator', __DIR__ . '/settings-timthumb.php');
	}

	add_action('admin_init', 'jptt_admin_settings');

	function jptt_admin_settings()
	{
		// General
		register_setting('jptt-settings-group', 'google-analytics');
		// Contacto
		register_setting('jptt-contact-group', 'contact-form-email', 'sanitize_email');
		register_setting('jptt-contact-group', 'contact-email', 'sanitize_email');
		register_setting('jptt-contact-group', 'contact-phone', 'sanitize_text_field');
		register_setting('jptt-contact-group', 'google-maps');
		// Social
		register_setting('jptt-social-group', 'social-facebook', 'jptt_valid_url');
		register_setting('jptt-social-group', 'social-googleplus', 'jptt_valid_url');
		register_setting('jptt-social-group', 'social-instagram', 'jptt_valid_url');
		register_setting('jptt-social-group', 'social-pinterest', 'jptt_valid_url');
		register_setting('jptt-social-group', 'social-twitter', 'jptt_valid_url');
		// CDN
		register_setting('jptt-cdn-group', 'cdn-jquery', 'jptt_valid_url');
		register_setting('jptt-cdn-group', 'cdn-jquery-migrate', 'jptt_valid_url');
		// Misc
		register_setting('jptt-misc-group', 'remove-generator', 'boolval');
		// TimThumb
		register_setting('jptt-timthumb-group', 'timthumb_htaccess', 'boolval');
		register_setting('jptt-timthumb-group', 'timthumb_debug_on', 'boolval');
		register_setting('jptt-timthumb-group', 'timthumb_block_external_leechers', 'boolval');
		register_setting('jptt-timthumb-group', 'timthumb_display_error_messages', 'boolval');
		register_setting('jptt-timthumb-group', 'timthumb_allow_external', 'boolval');
		register_setting('jptt-timthumb-group', 'timthumb_allow_all_external_sites', 'boolval');
		register_setting('jptt-timthumb-group', 'timthumb_file_cache_enabled', 'boolval');
		register_setting('jptt-timthumb-group', 'timthumb_file_cache_time_between_cleans', 'intval');
		register_setting('jptt-timthumb-group', 'timthumb_file_cache_directory');
		register_setting('jptt-timthumb-group', 'timthumb_browser_cache_disable', 'boolval');
		register_setting('jptt-timthumb-group', 'timthumb_max_width', 'intval');
		register_setting('jptt-timthumb-group', 'timthumb_max_height', 'intval');
		register_setting('jptt-timthumb-group', 'timthumb_not_found_image');
		register_setting('jptt-timthumb-group', 'timthumb_error_image');
		register_setting('jptt-timthumb-group', 'timthumb_png_is_transparent', 'boolval');
		register_setting('jptt-timthumb-group', 'timthumb_default_zc', 'intval');
		register_setting('jptt-timthumb-group', 'timthumb_default_width', 'intval');
		register_setting('jptt-timthumb-group', 'timthumb_default_height', 'intval');
	}

	add_action('admin_enqueue_scripts', 'jptt_admin_style');

	function jptt_admin_style()
	{
		wp_register_style('jptt_admin_style', JPTT_PLUGIN_URI . 'assets/css/jp-theme-tools-admin.css', false, '1.0.0');
		wp_enqueue_style('jptt_admin_style');
	}

} else {
	// Overrides WordPress scripts
	require_once __DIR__ . '/includes/override-cdn.php';
	require_once __DIR__ . '/includes/removes.php';
}
