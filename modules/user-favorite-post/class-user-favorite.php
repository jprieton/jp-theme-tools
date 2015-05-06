<?php

namespace jptt\modules;

defined('ABSPATH') or die('No direct script access allowed');

/**
 * @since 0.9.0
 */
class User_favorite {

	public function __construct() {
		global $wpdb;
		$wpdb instanceof wpdb;

		$charset = !empty($wpdb->charset) ?
						"DEFAULT CHARACTER SET {$wpdb->charset}" :
						'';

		$collate = !empty($wpdb->collate) ?
						"COLLATE {$wpdb->collate}" :
						'';

		$query = "CREATE TABLE IF NOT EXISTS `{$wpdb->prefix}favorites` ("
						. "`post_id` bigint(20) NOT NULL,"
						. "`user_id` bigint(20) NOT NULL,"
						. "KEY `post_id` (`post_id`),"
						. "KEY `user_id` (`user_id`)"
						. ") ENGINE=InnoDB {$charset} {$collate} AUTO_INCREMENT=1";
		$wpdb->query($query);
	}

	/**
	 * Adds a post to user favorites
	 * @global \wpdb $wpdb
	 * @param int $post_id
	 * @param int $user_id
	 * @since 0.9.0
	 */
	public function add_post_to_favorites($post_id, $user_id = NULL) {
		if (!is_numeric($user_id) || $user_id == 0) {
			$user_id = get_current_user_id();
		}
		
		if ($user_id == 0) {
			return;
		}

		if (!$this->is_favorite_post($post_id)) {
			global $wpdb;
			$wpdb instanceof \wpdb;

			$wpdb->insert("{$wpdb->prefix}favorites", compact('post_id', 'user_id'));
		}
	}

	/**
	 * Remove a post from user favorites
	 * @global \wpdb $wpdb
	 * @param type $post_id
	 * @param type $user_id
	 * @return boolean
	 * @since 0.9.0
	 */
	public function remove_post_from_favorites($post_id, $user_id = NULL) {
		if (!is_numeric($user_id) || $user_id == 0) {
			$user_id = get_current_user_id();
		}

		if ($user_id == 0) {
			return;
		}

		global $wpdb;
		$wpdb instanceof wpdb;

		$wpdb->delete("{$wpdb->prefix}favorites", compact('post_id', 'user_id'));

		return TRUE;
	}

	/**
	 * Toggles add/remove favorite post
	 * @param type $post_id
	 * @param type $user_id
	 * @return boolean
	 * @since 0.9.0
	 */
	public function toggle_favorite_post($post_id, $user_id = NULL) {
		if (!is_numeric($user_id) || $user_id == 0) {
			$user_id = get_current_user_id();
		}

		if ($this->is_favorite_post($post_id)) {
			$this->remove_post_from_favorites($post_id, $user_id);
			return FALSE;
		} else {
			$this->add_post_to_favorites($post_id, $user_id);
			return TRUE;
		}
	}

	/**
	 * 
	 * @global \wpdb $wpdb
	 * @param int $post_id
	 * @param int $user_id
	 * @return bool
	 * @since 0.9.0
	 */
	public function is_favorite_post($post_id, $user_id = NULL) {

		if (!is_numeric($user_id) || $user_id == 0) {
			$user_id = get_current_user_id();
		}

		if ($user_id == 0) {
			return FALSE;
		}

		global $wpdb;
		$wpdb instanceof \wpdb;

		$query = "SELECT * FROM `{$wpdb->prefix}favorites` "
						. "WHERE `post_id` = " . (int) $post_id . " "
						. "AND `user_id` = " . (int) $user_id . " "
						. "LIMIT 1";

		$result = $wpdb->get_row($query);
		return !empty($result);
	}

}
