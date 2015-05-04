<?php

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

	public function add_post_to_favorites($post_id, $user_id = NULL) {
		if (!is_numeric($user_id) || $user_id == 0) {
			$user_id = get_current_user_id();
		}

		if ($this->is_favorite_post($post_id)) {
			return TRUE;
		}

		global $wpdb;
		$wpdb instanceof wpdb;

		$wpdb->insert("{$wpdb->prefix}favorites", compact('post_id', 'user_id'));

		return TRUE;
	}

	public function remove_post_from_favorites($post_id, $user_id = NULL) {
		if (!is_numeric($user_id) || $user_id == 0) {
			$user_id = get_current_user_id();
		}

		global $wpdb;
		$wpdb instanceof wpdb;

		$wpdb->delete("{$wpdb->prefix}favorites", compact('post_id', 'user_id'));

		return TRUE;
	}

	public function toggle_favorite_post($post_id, $user_id = NULL) {
		if (!is_numeric($user_id) || $user_id == 0) {
			$user_id = get_current_user_id();
		}

		if ($this->is_favorite_post($post_id)) {
			$this->remove_post_from_favorites($post_id, $user_id);
		} else {
			$this->add_post_to_favorites($post_id, $user_id);
		}
	}

	public function is_favorite_post($post_id, $user_id = NULL) {
		if (!is_numeric($user_id) || $user_id == 0) {
			$user_id = get_current_user_id();
		}

		global $wpdb;
		$wpdb instanceof wpdb;

		$result = $wpdb->get_row("SELECT * FROM {$wpdb->prefix}favorites WHERE `post_id` = " . (int) $post_id . " `user_id` = " . (int) $user_id ." LIMIT 1");
		return empty($result);
	}

}
