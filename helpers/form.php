<?php

defined('ABSPATH') or die("No script kiddies please!");

/**
 * Returns nonce field value
 * @deprecated since version 0.8.3
 * @param srting $name
 * @return srting
 */
function get_nonce_value($name = '_wpnonce') {
	$nonce = filter_input(INPUT_POST, $name, FILTER_SANITIZE_STRING)? : filter_input(INPUT_GET, $name, FILTER_SANITIZE_STRING);
	return $nonce;
}

/**
 * Returns an Bootstrap checkbox element
 * @param string $identifier
 * @param string $label
 * @param string $value
 * @param bool $checked
 * @return string
 */
function get_boostrap_checkbox($identifier, $label, $value = 1, $checked = FALSE) {

	$checked = checked((bool) $checked, TRUE, FALSE);

	$checkbox = '<div class="checkbox">';
	$checkbox .= sprintf('<label for="%s">', $identifier);
	$checkbox .= sprintf('<input type="checkbox" name="%s" id="%s" value="%s" %s>', $identifier, $identifier, $value, $checked);
	$checkbox .= $label;
	$checkbox .= '</label>';
	$checkbox .= '</div>';

	return $checkbox;
}
