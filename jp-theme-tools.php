<?php

/**
 * Plugin Name: JP Theme Tools
 * Plugin URI: https://github.com/jprieton/jp-theme-tools/
 * Description: A brief description of the Plugin.
 * Version:  0.2
 * Author: Javier Prieto
 * Author URI: https://github.com/jprieton/
 * License: GPL2
 */
defined('ABSPATH') or die("No script kiddies please!");


define('JPTT_PLUGIN_PATH', plugin_dir_path(__FILE__));
define('JPTT_PLUGIN_URI', plugin_dir_url(__FILE__));

require_once __DIR__ . '/functions/common-functions.php';
require_once __DIR__ . '/ajax/contact.php';

include_once __DIR__ . './includes/updater.php';

//https://github.com/jprieton/jp-theme-tools

if (is_admin()) { // note the use of is_admin() to double check that this is happening in the admin
    $config = array(
        'slug' => plugin_basename(__FILE__), // this is the slug of your plugin
        'proper_folder_name' => 'jp-theme-tools', // this is the name of the folder your plugin lives in
        'api_url' => 'https://api.github.com/repos/jprieton/jp-theme-tools', // the github API url of your github repo
        'raw_url' => 'https://raw.github.com/jprieton/jp-theme-tools/master', // the github raw url of your github repo
        'github_url' => 'https://github.com/jprieton/jp-theme-tools', // the github url of your github repo
        'zip_url' => 'https://github.com/jprieton/jp-theme-tools/zipball/master', // the zip url of the github repo
        'sslverify' => true, // wether WP should check the validity of the SSL cert when getting an update, see https://github.com/jkudish/WordPress-GitHub-Plugin-Updater/issues/2 and https://github.com/jkudish/WordPress-GitHub-Plugin-Updater/issues/4 for details
        'requires' => '4.0', // which version of WordPress does your plugin require?
        'tested' => '4.0', // which version of WordPress is your plugin tested up to?
        'readme' => 'README.md', // which file to use as the readme for the version number
        'access_token' => '', // Access private repositories by authorizing under Appearance > Github Updates when this example plugin is installed
    );
    new WP_GitHub_Updater($config);
}

if (is_admin()) {

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
		register_setting('jptt-settings-group', 'contact-form-email', 'sanitize_email');
		register_setting('jptt-settings-group', 'contact-email', 'sanitize_email');
		register_setting('jptt-settings-group', 'contact-phone', 'sanitize_text_field');
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
