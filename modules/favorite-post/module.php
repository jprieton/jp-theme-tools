<?php

defined('ABSPATH') or die('No direct script access allowed');

require_once __DIR__ . '/class-user-favorite.php';
require_once JPTT_PLUGIN_PATH . 'core/class-input.php';

/**
 * Check if post is favorite of current user
 * @param int $post_id
 * @return bool
 */
function is_favorite_post($post_id = NULL) {
	$user_favorite = new jptt\modules\User_favorite();

	if ($post_id == NULL) {
		$post_id = get_the_ID();
	}
	return $user_favorite->is_favorite_post($post_id);
}

add_action('wp_ajax_add_favorite_post', function() {

	$Input = new \jptt\core\Input();
	$post_id = (int) $Input->get('post_id', array('filter' => FILTER_SANITIZE_NUMBER_INT));

	if ($post_id == 0) {
		wp_send_json_error();
	}

	$user_favorite = new jptt\modules\User_favorite();

	$user_favorite->add_post_to_favorites($post_id);

	wp_send_json_success();
});

add_action('wp_ajax_remove_favorite_post', function() {

	$Input = new \jptt\core\Input();
	$post_id = (int) $Input->get('post_id', array('filter' => FILTER_SANITIZE_NUMBER_INT));

	if ($post_id == 0) {
		wp_send_json_error();
	}

	$user_favorite = new jptt\modules\User_favorite();

	$user_favorite->remove_post_from_favorites($post_id);

	wp_send_json_success();
});

add_action('wp_ajax_toggle_favorite_post', function() {

	$Input = new \jptt\core\Input();
	$post_id = (int) $Input->get('post_id', array('filter' => FILTER_SANITIZE_NUMBER_INT));

	if ($post_id == 0) {
		wp_send_json_error();
	}

	$user_favorite = new jptt\modules\User_favorite();

	$is_favorite = $user_favorite->toggle_favorite_post($post_id);

	wp_send_json_success(compact('is_favorite'));
});

