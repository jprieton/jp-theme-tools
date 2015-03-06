<?php
/**
 * Include Open Graph metadata in <head> of the web page
 */
add_action('wp_head', function() {

	$meta['og:type'] = 'website';
	$meta['og:site_name'] = get_bloginfo('name');

	if (is_page() or is_singular()) {
		$current_post = get_post();
		$meta['og:title'] = esc_attr($current_post->post_title);
		$meta['og:description'] = esc_attr($current_post->post_excerpt);
		$meta['og:url'] = get_permalink($current_post->ID);

		$attachment_id = get_post_thumbnail_id($current_post->ID);

		if ($attachment_id) {
			$wp_attachmet_image = wp_get_attachment_image_src($attachment_id, 'full');
			$meta['og:image'] = $wp_attachmet_image[0];
			$meta['og:image:width'] = $wp_attachmet_image[1];
			$meta['og:image:height'] = $wp_attachmet_image[2];
		}

		if (!is_front_page()) {
			$meta['og:type'] = 'article';
			$meta['article:published_time'] = mysql2date('c', $current_post->post_date);
			$meta['article:modified_time'] = mysql2date('c', $current_post->post_modified);
		}
	}

	$meta = (array) apply_filters('og_meta_tags', $meta);

	foreach ($meta as $key => $value) {
		if (!empty($value)) {
			printf('<meta property="%s" content="%s" />'."\n", $key, $value);
		}
	}
}, 1);
