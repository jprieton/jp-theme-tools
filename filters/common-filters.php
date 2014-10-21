<?php

add_filter('mailto', function($str) {

	if (!is_string($str)) {
		return '';
	}

	$mail = sanitize_text_field($str);

	if (is_email($mail)) {
		$mail = sprintf('<a href="mailto:%s">%s</a>', $mail, $mail);
	}

	return $mail;
});
