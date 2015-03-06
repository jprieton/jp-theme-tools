<?php

defined('ABSPATH') or die("No script kiddies please!");

if (!function_exists('get_short_permalink') && !function_exists('get_the_short_permalink')) {

	/**
	 * Retrieve shortened google permalink for current post or post ID.
	 *
	 * @since 0.7.0
	 *
	 * @param int|WP_Post $id        Optional. Post ID or post object. Default is the current post.
	 * @return string|bool The shortened Google permalink URL or false if post does not exist.
	 */
	function get_short_permalink($id = 0) {
		if (is_a($id, 'WP_Post')) {
			$id = (int) $id->ID;
		} elseif ((int) $id == 0) {
			$id = (int) get_the_ID();
		}

		if ($id == 0) {
			return FALSE;
		}

		$short_permalink = get_post_meta($id, 'google_short_permalink', true);

		if (!$short_permalink) {
			$permalink = get_permalink($id);
			$short_permalink = generate_google_short_permalink($permalink);
			if (!empty($short_permalink)) {
				add_post_meta($id, 'google_short_permalink', $short_permalink, true);
			}
		}

		return (empty($short_permalink)) ? FALSE : $short_permalink;
	}

	/**
	 * Retrieve shortened Google permalink for current post or post ID.
	 *
	 * This function is an alias for get_short_permalink().
	 *
	 * @since 0.7.0
	 *
	 * @see get_short_permalink()
	 *
	 * @param int|WP_Post $id        Optional. Post ID or post object. Default is the current post.
	 * @return string|bool The shortened Google permalink URL or false if post does not exist.
	 */
	function get_the_short_permalink($id = 0) {
		return get_short_permalink($id);
	}

}
if (!function_exists('the_short_permalink')) {

	/**
	 * Display the shortened Google permalink for the current post.
	 *
	 * @since 0.7.0
	 */
	function the_short_permalink() {
		echo esc_url(apply_filters('the_permalink', get_short_permalink()));
	}

}
if (!function_exists('get_google_short_permalink')) {

	/**
	 * Retrieve shortened permalink from Google URL Shortener API.
	 *
	 * @since 0.7.0
	 *
	 * @see https://developers.google.com/url-shortener/
	 *
	 * @param string $permalink        Permalink URL.
	 * @return string|bool The shortened Google permalink URL or false if post does not exist.
	 */
	function generate_google_short_permalink($permalink = '') {

		if (empty($permalink)) return FALSE;

		$apiKey = get_option('google-url-shortener-api-key', '');

		$postData = array('longUrl' => $permalink, 'key' => $apiKey);
		$jsonData = json_encode($postData);

		$curlObj = curl_init();

		curl_setopt($curlObj, CURLOPT_URL, 'https://www.googleapis.com/urlshortener/v1/url');
		curl_setopt($curlObj, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($curlObj, CURLOPT_SSL_VERIFYPEER, 0);
		curl_setopt($curlObj, CURLOPT_HEADER, 0);
		curl_setopt($curlObj, CURLOPT_HTTPHEADER, array('Content-type:application/json'));
		curl_setopt($curlObj, CURLOPT_POST, 1);
		curl_setopt($curlObj, CURLOPT_POSTFIELDS, $jsonData);

		$response = curl_exec($curlObj);

		// Change the response json string to object
		$json = json_decode($response);

		curl_close($curlObj);

		return $json->id;
	}

}