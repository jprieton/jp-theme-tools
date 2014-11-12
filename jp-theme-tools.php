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
require_once __DIR__ . '/filters/common-filters.php';

//debug(WP_CONTENT_DIR);

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

// Register Custom Post Type
function aacustom_post_type()
{

	$labels = array(
			'name' => _x('Post Types', 'Post Type General Name', 'text_domain'),
			'singular_name' => _x('Post Type', 'Post Type Singular Name', 'text_domain'),
			'menu_name' => __('Post Type', 'text_domain'),
			'parent_item_colon' => __('Parent Item:', 'text_domain'),
			'all_items' => __('All Items', 'text_domain'),
			'view_item' => __('View Item', 'text_domain'),
			'add_new_item' => __('Add New Item', 'text_domain'),
			'add_new' => __('Add New', 'text_domain'),
			'edit_item' => __('Edit Item', 'text_domain'),
			'update_item' => __('Update Item', 'text_domain'),
			'search_items' => __('Search Item', 'text_domain'),
			'not_found' => __('Not found', 'text_domain'),
			'not_found_in_trash' => __('Not found in Trash', 'text_domain'),
	);
	$args = array(
			'label' => __('post_type', 'text_domain'),
			'description' => __('Post Type Description', 'text_domain'),
			'labels' => $labels,
			'supports' => array(),
			'taxonomies' => array('category', 'post_tag'),
			'hierarchical' => false,
			'public' => true,
			'show_ui' => true,
			'show_in_menu' => true,
			'show_in_nav_menus' => true,
			'show_in_admin_bar' => true,
			'menu_position' => 5,
			'can_export' => true,
			'has_archive' => true,
			'exclude_from_search' => false,
			'publicly_queryable' => true,
			'capability_type' => 'page',
	);
	register_post_type('aapost_type', $args);
}

// Hook into the 'init' action
add_action('init', 'aacustom_post_type', 0);

//Hook on to the filter for the (custom) main menu
// 'wp_list_pages' filter is a fallback, when a custom menu isn't being used
add_filter('wp_list_pages', 'new_nav_menu_items');
add_filter('wp_nav_menu_items', 'new_nav_menu_items');
/*
  //Can also hook into a specific menu...
  //add_filter( 'wp_nav_menu_{$menu->slug}_items', 'new_nav_menu_items' );

  function new_nav_menu_items($items)
  {
  global $wp_query;
  $class = '';


  //Checks if we are viewing CPT 'myposttype', if so give it the 'active' class.
  if (isset($wp_query->query_vars['post_type']) && $wp_query->query_vars['post_type'] == 'aapost_type') $class = 'current_page_item';

  //This generates the url of the CPT archive page
  $url = add_query_arg('post_type', 'aapost_type', site_url());
  //	debug($items);

  $myitem = '<li class="' . $class . '"><a href="' . $url . '">My Custom Post Type</a></li>';

  $items = $items . $myitem;
  return $items;
  }

  add_action('admin_head-nav-menus.php', 'inject_cpt_archives_menu_meta_box');

  function inject_cpt_archives_menu_meta_box()
  {
  /* isn't this much better? * /
  add_meta_box('add-cpt', __('CPT Archives'), 'wp_nav_menu_cpt_archives_meta_box', 'nav-menus', 'side', 'default');
  }

  /* render custom post type archives meta box * /

  function wp_nav_menu_cpt_archives_meta_box()
  {

  /* get custom post types with archive support * /
  $post_types = get_post_types(array('show_in_nav_menus' => true, 'has_archive' => true), 'object');

  /* hydrate the necessary properties for identification in the walker *  /
  foreach ($post_types as &$post_type) {
  $post_type->classes = array();
  $post_type->type = $post_type->name;
  $post_type->object_id = $post_type->name;
  $post_type->title = $post_type->labels->name . ' Archive';
  $post_type->object = 'cpt-archive';

  $post_type->menu_item_parent = null;
  $post_type->nav_menu_selected_id = null;
  $post_type->url = null;
  $post_type->xfn = null;
  $post_type->db_id = null;
  $post_type->target = null;
  $post_type->attr_title = null;
  }

  /* the native menu checklist * /
  $walker = new Walker_Nav_Menu_Checklist(array());
  ?>
  <div id="cpt-archive" class="posttypediv">
  <div id="tabs-panel-cpt-archive" class="tabs-panel tabs-panel-active">
  <ul id="ctp-archive-checklist" class="categorychecklist form-no-clear">
  <?php
  echo walk_nav_menu_tree(array_map('wp_setup_nav_menu_item', $post_types), 0, (object) array('walker' => $walker));
  ?>
  </ul>
  </div><!-- /.tabs-panel -->
  </div>

  <p class="button-controls">
  <span class="list-controls">
  <a href="/wp/fiestacity/wp-admin/nav-menus.php?page-tab=all&selectall=1#cpt-archive" class="select-all">Seleccionar todos</a>
  </span>

  <span class="add-to-menu">
  <input type="submit" class="button-secondary submit-add-to-menu right" value="<?php esc_attr_e('Add to Menu'); ?>" name="add-ctp-archive-menu-item" id="submit-cpt-archive" />
  <span class="spinner"></span>
  </span>
  </p>

  <p class="button-controls">
  <span class="add-to-menu">
  <img class="waiting" src="<?php echo esc_url(admin_url('images/wpspin_light.gif')); ?>" alt="" />
  <input type="submit" <?php // disabled($nav_menu_selected_id, 0); ?> class="button-secondary submit-add-to-menu" value="<?php esc_attr_e('Add to Menu'); ?>" name="add-ctp-archive-menu-item" id="submit-cpt-archive" />
  </span>
  </p>
  <?php
  }
 */
add_action('init', function(){

});

