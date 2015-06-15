<?php

/**
 * Plugin Name: JP WordPress Theme Tools
 * Plugin URI: https://github.com/jprieton/jp-theme-tools/
 * Description: Extends WordPress functionality for themes
 * Version: 0.9.2
 * Author: Javier Prieto
 * Text Domain: jptt
 * Domain Path: /languages
 * Author URI: https://github.com/jprieton/
 * License: GPL2
 */
defined('ABSPATH') or die("No script kiddies please!");

// Updates
if (is_admin()) {

	if (!class_exists('BFIGitHubPluginUpdater')) {
		require_once __DIR__ . '/updater/BFIGitHubPluginUpdater.php';
	}
	if (!class_exists('Parsedown')) {
		// We're going to parse the GitHub markdown release notes, include the parser
		require_once __DIR__ . '/updater/Parsedown.php';
	}
	new BFIGitHubPluginUpdater(__FILE__, 'jprieton', 'jp-theme-tools');
}

define('JPTT_PLUGIN_PATH', plugin_dir_path(__FILE__));
define('JPTT_PLUGIN_URI', plugin_dir_url(__FILE__));

define('JPTT_THEME_PATH', get_stylesheet_directory());
define('JPTT_THEME_URI', get_stylesheet_directory_uri());

include_once JPTT_PLUGIN_PATH . 'includes/taxonomy.php';

//Helpers
include_once JPTT_PLUGIN_PATH . 'helpers/debug.php';
include_once JPTT_PLUGIN_PATH . 'helpers/url.php';
include_once JPTT_PLUGIN_PATH . 'helpers/form.php';
include_once JPTT_PLUGIN_PATH . 'helpers/user.php';

//Frontend
//include_once JPTT_PLUGIN_PATH . 'frontend/attachments.php';
//include_once JPTT_PLUGIN_PATH . 'frontend/galleries.php';
//include_once JPTT_PLUGIN_PATH . 'frontend/posts.php';
//include_once JPTT_PLUGIN_PATH . 'frontend/users.php';
// Action hooks
include_once JPTT_PLUGIN_PATH . 'includes/class-head-actions.php';
include_once JPTT_PLUGIN_PATH . 'includes/class-user-actions.php';
include_once JPTT_PLUGIN_PATH . 'includes/contact.php';
include_once JPTT_PLUGIN_PATH . 'actions/profile-image.php';

global $defer_scripts, $async_scripts;
require_once JPTT_PLUGIN_PATH . '/functions/common-functions.php';
require_once JPTT_PLUGIN_PATH . '/filters/common-filters.php';
require_once JPTT_PLUGIN_PATH . '/includes/actions.php';

require_once __DIR__ . '/core/class-error.php';
require_once __DIR__ . '/core/class-input.php';

// Autoload modules
$jptt_modules = (array) get_option('jptt_modules', array());
foreach ($jptt_modules as $key => $value) {
	if (file_exists(JPTT_PLUGIN_PATH . "modules/{$key}/module.php")) {
		include_once JPTT_PLUGIN_PATH . "modules/{$key}/module.php";
	}
}

if (is_admin()) {

	add_action('admin_menu', 'theme_tools_admin_menu');

	function theme_tools_admin_menu() {
		add_menu_page('JP Theme Tools Plugin Settings', 'JP Theme Tools', 'administrator', __DIR__ . '/admin-options.php', '', 'dashicons-admin-generic');
		add_submenu_page(__DIR__ . '/admin-options.php', 'JP Theme Tools Plugin Settings - Generales', 'Generales', 'administrator', __DIR__ . '/admin-options.php');
		add_submenu_page(__DIR__ . '/admin-options.php', 'JP Theme Tools Plugin Settings - Anal&iacute;tica y SEO', ' Anal&iacute;tica y SEO', 'administrator', __DIR__ . '/settings/seo.php');
		add_submenu_page(__DIR__ . '/admin-options.php', 'JP Theme Tools Plugin Settings - Contacto', 'Contacto', 'administrator', __DIR__ . '/settings-contact.php');
		add_submenu_page(__DIR__ . '/admin-options.php', 'JP Theme Tools Plugin Settings - Social', 'Social', 'administrator', __DIR__ . '/settings-social.php');
		add_submenu_page(__DIR__ . '/admin-options.php', 'JP Theme Tools Plugin Settings - CDN', 'CDN', 'administrator', __DIR__ . '/settings/cdn.php');
		add_submenu_page(__DIR__ . '/admin-options.php', 'JP Theme Tools Plugin Settings - TimThumb', 'TimThumb', 'administrator', __DIR__ . '/settings/timthumb.php');
		add_submenu_page(__DIR__ . '/admin-options.php', 'JP Theme Tools Plugin Settings - Modules', __('Modules', 'jptt'), 'administrator', __DIR__ . '/settings/modules.php');
	}

	add_action('admin_init', 'jptt_admin_settings');

	function jptt_admin_settings() {
		// Opciones generales
		register_setting('jptt-general-group', 'remove-generator', 'boolval');
		register_setting('jptt-general-group', 'remove-feed-links-extra', 'boolval');
		register_setting('jptt-general-group', 'remove-feed-links', 'boolval');
		register_setting('jptt-general-group', 'remove-rsd-link', 'boolval');
		register_setting('jptt-general-group', 'remove-wlwmanifest-link', 'boolval');
		register_setting('jptt-general-group', 'remove-index-rel-link', 'boolval');
		register_setting('jptt-general-group', 'remove-parent-post-rel-link', 'boolval');
		register_setting('jptt-general-group', 'remove-start_post-rel-link', 'boolval');
		register_setting('jptt-general-group', 'remove-adjacent_posts-rel-link-wp_head', 'boolval');
		// Analitica y SEO
		register_setting('jptt-seo-group', 'google-analytics');
		register_setting('jptt-seo-group', 'google-site-verification');
		register_setting('jptt-seo-group', 'bing-site-verification');
		register_setting('jptt-seo-group', 'open-graph-meta', 'boolval');
		register_setting('jptt-seo-group', 'twitter-card-meta', 'boolval');
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
		register_setting('jptt-social-group', 'social-youtube', 'jptt_valid_url');
		// CDN
		register_setting('jptt-cdn-group', 'cdn-jquery', 'jptt_valid_url');
		register_setting('jptt-cdn-group', 'cdn-jquery-migrate', 'jptt_valid_url');
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
		// Modules
		register_setting('jptt-modules-group', 'jptt_modules');
	}

	add_action('admin_enqueue_scripts', 'jptt_admin_style');

	function jptt_admin_style() {
		wp_register_style('jptt_admin_style', JPTT_PLUGIN_URI . 'assets/css/jp-theme-tools-admin.css', false, '1.0.0');
		wp_enqueue_style('jptt_admin_style');
	}

} else {
	// Overrides WordPress scripts
	require_once __DIR__ . '/includes/override-cdn.php';
}

add_action('plugins_loaded', function() {
	load_plugin_textdomain('jptt', false, dirname(plugin_basename(__FILE__)) . '/languages/');
});


register_activation_hook(__FILE__, function() {
	require_once JPTT_PLUGIN_PATH . 'core/class-schema.php';
	jptt\core\Schema::create_termmeta_table();
});
