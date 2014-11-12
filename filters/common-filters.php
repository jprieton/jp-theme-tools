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

add_filter('mod_rewrite_rules', function($rule) {

	if (get_option('use-timthumb-htaccess', false)) {

		$home_root = parse_url(JPTT_PLUGIN_URI . 'libraries/timthumb/timthumb.php', PHP_URL_PATH);
		$rule .= "\n";
		$rule .= "<IfModule mod_rewrite.c>\n";
		$rule .= "RewriteCond %{REQUEST_FILENAME} -f\n";
		$rule .= "RewriteCond %{REQUEST_URI} (?i)(jpg|jpeg|png|gif)$ \n";
		$rule .= "RewriteCond %{QUERY_STRING} h=([1-9]) [OR]\n";
		$rule .= "RewriteCond %{QUERY_STRING} w=([1-9])\n";
		$rule .= "RewriteRule (.*) {$home_root}?%{QUERY_STRING}&src=%{REQUEST_URI}\n";
		$rule .= "</IfModule>\n";
	}

	return $rule;
});
