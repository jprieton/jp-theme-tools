<?php

defined('ABSPATH') or die("No script kiddies please!");

/**
 * Returns nonce field value
 * @param srting $name
 * @return srting
 */
function get_nonce_value($name = '_wpnonce') {
	$nonce = filter_input(INPUT_POST, $name, FILTER_SANITIZE_STRING)? : filter_input(INPUT_GET, $name, FILTER_SANITIZE_STRING);
	return $nonce;
}
