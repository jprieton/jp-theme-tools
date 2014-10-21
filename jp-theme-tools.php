<?php

/**
 * Plugin Name: JP WordPress Theme Tools
 * Plugin URI: https://github.com/jprieton/jp-theme-tools/
 * Description: Extends WordPress functionality for themes
 * Version: 0.5
 * Author: Javier Prieto
 * Author URI: https://github.com/jprieton/
 * License: GPL2
 */
defined('ABSPATH') or die("No script kiddies please!");

define('JPTT_PLUGIN_PATH', plugin_dir_path(__FILE__));
define('JPTT_PLUGIN_URI', plugin_dir_url(__FILE__));

require_once __DIR__ . '/functions/common-functions.php';
require_once __DIR__ . '/ajax/contact.php';

class JP_Theme_Tools
{

	public static function plugin_setup()
	{
		add_filter('upgrader_source_selection', array('JP_Theme_Tools', 'rename_github_zip'), 1);

		require JPTT_PLUGIN_PATH . '/plugin-updates/plugin-update-checker.php';
		$update_checker = PucFactory::buildUpdateChecker('https://raw.github.com/jprieton/jp-theme-tools/master/includes/update.json', __FILE__, 'jp-theme-tools-master');
	}

	public static function rename_github_zip($source)
	{
		if (FALSE === strpos($source, 'jp-theme-tools')) return $source;

		$path_parts = pathinfo($source);
		$newsource = trailingslashit($path_parts['dirname']) .
						trailingslashit('jp-theme-tools');
		rename($source, $newsource);

		return $newsource;
	}

}

if (is_admin()) {

	add_action('plugins_loaded', array('JP_Theme_Tools', 'plugin_setup'));

	add_action('admin_menu', 'theme_tools_admin_menu');

	function theme_tools_admin_menu()
	{
		add_menu_page('JP Theme Tools Plugin Settings', 'JP Theme Tools', 'administrator', __DIR__ . '/admin-options.php', '', 'dashicons-admin-generic');
		add_submenu_page(__DIR__ . '/admin-options.php', 'JP Theme Tools Plugin Settings - Generales', 'Generales', 'administrator', __DIR__ . '/admin-options.php');
		add_submenu_page(__DIR__ . '/admin-options.php', 'JP Theme Tools Plugin Settings - Contacto', 'Contacto', 'administrator', __DIR__ . '/settings-contact.php');
		add_submenu_page(__DIR__ . '/admin-options.php', 'JP Theme Tools Plugin Settings - Social', 'Social', 'administrator', __DIR__ . '/settings-social.php');
		add_submenu_page(__DIR__ . '/admin-options.php', 'JP Theme Tools Plugin Settings - CDN', 'CDN', 'administrator', __DIR__ . '/settings-cdn.php');
		add_submenu_page(__DIR__ . '/admin-options.php', 'JP Theme Tools Plugin Settings - Misceláneas', 'Misceláneas', 'administrator', __DIR__ . '/settings-misc.php');
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
		register_setting('jptt-misc-group', 'remove-generator', 'jptt_valid_url');
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
