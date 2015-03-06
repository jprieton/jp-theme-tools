<?php

function short_url($longUrl)
{
	/**
	 * https://developers.google.com/url-shortener/
	 */

	$apiKey = 'MyAPIKey';

	$postData = array('longUrl' => $longUrl, 'key' => $apiKey);
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

function get_post_short_url($post_id)
{
	$post_id = (int) $post_id;
	if ($post_id > 0) {
		$short_url = get_post_meta($post_id, 'google_short_url', true);
		if (!$short_url) {
			$permalink = get_permalink($post_id);
			$short_url = short_url($permalink);
			if (!empty($short_url)) {
				add_post_meta($post_id, 'google_short_url', $short_url, true);
			}
		}
		return $short_url;
	}
}
