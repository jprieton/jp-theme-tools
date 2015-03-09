<?php

defined('ABSPATH') or die("No script kiddies please!");

/**
 * Adds <meta name="google-site-verification" content="{verification-code}" /> in <head> of the web page
 */
add_action('wp_head', function() {
	$google_site_verification = get_option('google-site-verification', FALSE);
	if (!empty($google_site_verification)) {
		printf('<meta name="google-site-verification" content="%s" />' . "\n", $google_site_verification);
	}
});
