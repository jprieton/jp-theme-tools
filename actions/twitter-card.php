<?php

defined('ABSPATH') or die("No script kiddies please!");

/**
 * Include Twitter card metadata in <head> of the web page
 */
add_action('wp_head', function() {

	$meta['twitter:card'] = 'summary';

	if (is_page() or is_singular()) {
		$current_post = get_post();
		$meta['twitter:title'] = esc_attr($current_post->post_title);
		$meta['twitter:description'] = esc_attr($current_post->post_excerpt);
		$meta['twitter:url'] = get_permalink($current_post->ID);

		$attachment_id = get_post_thumbnail_id($current_post->ID);

		if ($attachment_id) {
			$wp_attachmet_image = wp_get_attachment_image_src($attachment_id, 'full');
			$meta['twitter:image'] = $wp_attachmet_image[0];
		}
	}

	$meta = (array) apply_filters('twitter_meta_tags', $meta);

	echo "<!-- Twitter Card -->\n";
	foreach ($meta as $key => $value) {
		if (!empty($value)) {
			printf('<meta name="%s" content="%s" />' . "\n", $key, $value);
		}
	}
}, 1);
