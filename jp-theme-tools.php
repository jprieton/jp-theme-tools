<?php

/**
 * Plugin Name: JP Theme Tools
 * Plugin URI: https://github.com/jprieton/jp-theme-tools/
 * Description: A brief description of the Plugin.
 * Version:  0.0.1
 * Author: Javier Prieto
 * Author URI: https://github.com/jprieton/
 * License: GPL2
 */
defined('ABSPATH') or die("No script kiddies please!");


define('JPTT_PLUGIN_PATH', plugin_dir_path(__FILE__));
define('JPTT_PLUGIN_URI', plugin_dir_url(__FILE__));

require_once __DIR__ . '/functions/common-functions.php';
require_once __DIR__ . '/ajax/contact.php';

if (is_admin()) {

	add_action('admin_menu', 'theme_tools_admin_menu');

	function theme_tools_admin_menu()
	{
		add_menu_page('JP Theme Tools Plugin Settings', 'JP Theme Tools', 'administrator', __DIR__ . '/admin-options.php', '', 'dashicons-admin-generic');
		add_submenu_page(__DIR__ . '/admin-options.php', 'JP Theme Tools Plugin Settings', 'Generales', 'administrator', __DIR__ . '/admin-options.php');
		add_submenu_page(__DIR__ . '/admin-options.php', 'JP Theme Tools Plugin Settings', 'Contacto', 'administrator', __DIR__ . '/contact-options.php');
		add_submenu_page(__DIR__ . '/admin-options.php', 'JP Theme Tools Plugin Settings', 'Social', 'administrator', __DIR__ . '/social-options.php');
	}

	add_action('admin_init', 'jptt_admin_settings');

	function jptt_admin_settings()
	{
		register_setting('jptt-settings-group', 'contact-form-email', 'sanitize_email');
		register_setting('jptt-settings-group', 'social-facebook', 'jptt_valid_url');
		register_setting('jptt-settings-group', 'social-googleplus', 'jptt_valid_url');
		register_setting('jptt-settings-group', 'social-instagram', 'jptt_valid_url');
		register_setting('jptt-settings-group', 'google-analytics');
	}

}
