<?php

defined('ABSPATH') or die('No direct script access allowed');

class JPTT_Loader {

	public function model($model, $var = NULL) {
		global $jptt;

		if (!empty($jptt->$var)) {
			return;
		}

		if (file_exists(JPTT_PLUGIN_PATH . 'models/' . $model . '.php')) {
			require_once JPTT_PLUGIN_PATH . 'models/' . $model . '.php';
			if (empty($var)) {
				$var = $model;
			}
			$jptt->$var = new $model();
		}
	}

	public function module($module) {
		if (file_exists(JPTT_THEME_PATH . 'modules/' . $module . '.php')) {
			require_once JPTT_THEME_PATH . 'modules/' . $module . '.php';
		} elseif (file_exists(JPTT_PLUGIN_PATH . 'modules/' . $module . '.php')) {
			require_once JPTT_PLUGIN_PATH . 'modules/' . $module . '.php';
		}
	}

	public function taxonomy($taxonomy) {
		if (file_exists(JPTT_THEME_PATH . 'taxonomies/' . $taxonomy . '.php')) {
			require_once JPTT_THEME_PATH . 'taxonomies/' . $taxonomy . '.php';
		} elseif (file_exists(JPTT_PLUGIN_PATH . 'taxonomies/' . $taxonomy . '.php')) {
			require_once JPTT_PLUGIN_PATH . 'taxonomies/' . $taxonomy . '.php';
		}
	}

	public function post_type($post_type) {
		if (file_exists(JPTT_THEME_PATH . 'post_types/' . $post_type . '.php')) {
			require_once JPTT_THEME_PATH . 'post_types/' . $post_type . '.php';
		} elseif (file_exists(JPTT_PLUGIN_PATH . 'post_types/' . $post_type . '.php')) {
			require_once JPTT_PLUGIN_PATH . 'post_types/' . $post_type . '.php';
		}
	}

}
