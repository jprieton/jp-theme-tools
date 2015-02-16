<?php

add_action('wp_head', function() {

	$meta = array();
	$meta['og:type'] = 'website';
	$meta['og:site_name'] = get_bloginfo('name');

	if (is_page() or is_singular()) {
		$current_post = get_post();
		$meta['og:title'] = esc_attr($current_post->post_title);
		$meta['og:description'] = esc_attr($current_post->post_excerpt);
		$meta['og:url'] = get_permalink($current_post->ID);
		$meta['og:image'] = wp_get_attachment_url(get_post_thumbnail_id($current_post->ID));
		if (!is_front_page()) {
			$meta['og:type'] = 'article';
			$meta['article:published_time'] = mysql2date('c', $current_post->post_date);
			$meta['article:modified_time'] = mysql2date('c', $current_post->post_modified);
		}
	}

	$meta = (array) apply_filters('og_meta_tags', $meta);

	foreach ($meta as $key => $value) {
		if (!empty($value)) {
			printf('<meta name="%s" content="%s" />', $key, $value);
			echo "\n";
		}
	}
}, 1);
