<?php

add_action('wp_head', function() {

	if (is_page())
	{
		$current_post = get_post();
		$meta['og:title'] = esc_attr($current_post->post_title);
		$meta['og:description'] = esc_attr($current_post->post_excerpt);
		$meta['og:site_name'] = get_bloginfo('name');
		$meta['og:url'] = get_permalink($current_post->ID);
		$meta['og:image'] = wp_get_attachment_url(get_post_thumbnail_id($current_post->ID));

		foreach ($meta as $key => $value) {
			if (!empty($value))
			{
				printf('<meta name="%s" content="%s" />', $key, $value);
				echo "\n";
			}
		}
	}
}, 1);
