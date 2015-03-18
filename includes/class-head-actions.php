<?php

defined('ABSPATH') or die("No script kiddies please!");

class Head_Actions {

	private $current_post;
	private $attachmet_image = false;

	private function get_post_data() {
		if (empty($this->current_post)) {
			$this->current_post = get_post();
			$attachment_id = get_post_thumbnail_id($this->current_post->ID);
			if ($attachment_id) {
				$this->attachmet_image = wp_get_attachment_image_src($attachment_id, 'full');
			}
		}
	}

	function open_graph_meta() {
		$has_open_graph_meta = (bool) get_option('has_open_graph_meta', TRUE);

		if (!$has_open_graph_meta) return;

		$meta['og:type'] = 'website';
		$meta['og:site_name'] = get_bloginfo('name');

		if (is_page() || is_singular()) {

			$this->get_post_data();

			$meta['og:title'] = esc_attr($this->current_post->post_title);
			$meta['og:description'] = esc_attr($this->current_post->post_excerpt);
			$meta['og:url'] = get_permalink($this->current_post->ID);


			if ($this->attachmet_image) {
				$meta['og:image'] = $this->attachmet_image[0];
				$meta['og:image:width'] = $this->attachmet_image[1];
				$meta['og:image:height'] = $this->attachmet_image[2];
			}

			if (!is_front_page()) {
				$meta['og:type'] = 'article';
				$meta['article:published_time'] = mysql2date('c', $this->current_post->post_date);
				$meta['article:modified_time'] = mysql2date('c', $this->current_post->post_modified);
			}

			$meta = (array) apply_filters('open_graph_meta', $meta);
		}

		echo "<!-- Open Graph -->\n";
		foreach ($meta as $key => $value) {
			if (!empty($value)) {
				printf('<meta property="%s" content="%s" />' . "\n", $key, $value);
			}
		}
	}

	function twitter_card_meta() {
		$has_twitter_card_meta = (bool) get_option('has_twitter_card_meta', TRUE);

		if (!$has_twitter_card_meta) return;

		$meta['twitter:card'] = 'summary';

		if (is_page() or is_singular()) {

			$this->get_post_data();

			$meta['twitter:title'] = esc_attr($this->current_post->post_title);
			$meta['twitter:description'] = esc_attr($this->current_post->post_excerpt);
			$meta['twitter:url'] = get_permalink($this->current_post->ID);

			if ($this->attachmet_image) {
				$meta['twitter:image:src'] = $this->attachmet_image[0];
				$meta['twitter:image:width'] = $this->attachmet_image[1];
				$meta['twitter:image:height'] = $this->attachmet_image[2];
			}
		}

		$meta = (array) apply_filters('twitter_card_meta', $meta);

		echo "<!-- Twitter Card -->\n";
		foreach ($meta as $key => $value) {
			if (!empty($value)) {
				printf('<meta name="%s" content="%s" />' . "\n", $key, $value);
			}
		}
	}

	function admin_ajax() {
		$admin_ajax = admin_url('admin-ajax.php');
		printf("<script>var admin_url = '%s';</script>\n", $admin_ajax);
	}

	function google_analytics_tracking_code() {
		$google_analytics = get_option('google-analytics', '');
		if (!empty($google_analitics)) {
			printf("<script>\n%s\n</script>\n", $google_analytics);
		}
	}

	function google_site_verification() {
		$google_site_verification = esc_attr(get_option('google-site-verification', ''));
		if (!empty($google_site_verification)) {
			printf('<meta name="google-site-verification" content="%s" />' . "\n", $google_site_verification);
		}
	}

	function bing_site_verification() {
		$bing_site_verification = esc_attr(get_option('bing-site-verification', ''));
		if (!empty($bing_site_verification)) {
			printf('<meta name="msvalidate.01" content="%s" />' . "\n", $bing_site_verification);
		}
	}

}

$Head_Actions = new Head_Actions();
add_action('wp_head', array($Head_Actions, 'open_graph_meta'), 1);
add_action('wp_head', array($Head_Actions, 'twitter_card_meta'), 1);
add_action('wp_head', array($Head_Actions, 'google_site_verification'), 1);
add_action('wp_head', array($Head_Actions, 'bing_site_verification'), 1);
add_action('wp_head', array($Head_Actions, 'google_analytics_tracking_code'), 99);
add_action('wp_head', array($Head_Actions, 'admin_ajax'), 99);
