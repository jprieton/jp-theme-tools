<?php

defined('ABSPATH') or die('No direct script access allowed');

/**
 * @since v0.9.0
 * @author jprieton
 */
class Frontend_Posts {

	public function __construct() {
		$this->error = new Frontend_Errors();
	}

	/**
	 * @since v0.9.0
	 * @author jprieton
	 * @global array $frontend_post_meta
	 * @param int $post_id
	 */
	public function update_post_meta($post_id) {
		global $frontend_post_meta;

		foreach ($frontend_post_meta as $meta_key => $filter) {
			$post_meta = wp_kses(filter_input(INPUT_POST, $meta_key, $filter), array());
			if (!empty($post_meta)) {
				update_post_meta($post_id, $meta_key, $post_meta);
			} else {
				delete_post_meta($post_id, $meta_key);
			}
		}
	}

}
