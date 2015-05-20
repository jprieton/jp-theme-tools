<?php

if (is_admin()) {

	add_action('admin_action_update', function() {
		$submit = wp_parse_args($_POST);
		if (!empty($submit['option_page']) && $submit['option_page'] != 'jptt-timthumb-group') return;

		global $wpdb;
		$wpdb instanceof wpdb;

		$options = $wpdb->get_results("SELECT option_name, option_value FROM $wpdb->options WHERE option_name LIKE 'timthumb_%'");

		$content = "<?php \n";
		foreach ($options as $option) {
			$item = str_replace('TIMTHUMB_', '', strtoupper($option->option_name));
			$value = is_numeric($option->option_value) ? (int) $option->option_value : "'{$option->option_value}'";
			$content.= "define('{$item}', {$value});\n";
		}

		$filename = JPTT_PLUGIN_PATH . 'libraries/timthumb/timthumb-config.php';

		if (file_exists($filename)) {
			unlink($filename);
		}

		$config_file = fopen($filename, "w") or die("Unable to open file!");
		fwrite($config_file, $content);
		fclose($config_file);

		return;
	});
}

if (!is_admin()) {
	add_action('defer_script', function($script) {
		global $defer_scripts;
		if (empty($defer_scripts) && !is_array($script)) {
			$defer_scripts = array($script);
		} elseif (empty($defer_scripts) && is_array($script)) {
			$defer_scripts = $script;
		} elseif (is_array($script)) {
			$defer_scripts = array_merge($defer_scripts, $script);
		} else {
			$defer_scripts[] = $script;
		}
		$defer_scripts = array_unique($defer_scripts);
	});
	add_action('async_script', function($script) {
		global $async_scripts;
		if (empty($async_scripts) && !is_array($script)) {
			$async_scripts = array($script);
		} elseif (empty($async_scripts) && is_array($script)) {
			$async_scripts = $script;
		} elseif (is_array($script)) {
			$async_scripts = array_merge($async_scripts, $script);
		} else {
			$async_scripts[] = $script;
		}
		$async_scripts = array_unique($async_scripts);
	});
	add_filter('script_loader_tag', function ( $tag, $handle ) {
		global $defer_scripts;
		if (empty($defer_scripts) or ! is_array($defer_scripts) or ! in_array($handle, $defer_scripts)) {
			return $tag;
		} else {
			return str_replace(' src', " defer='defer' src", $tag);
		}
	}, 10, 2);
	add_filter('script_loader_tag', function ( $tag, $handle ) {
		global $async_scripts;
		if (empty($async_scripts) or ! is_array($async_scripts) or ! in_array($handle, $async_scripts)) {
			return $tag;
		} else {
			return str_replace(' src', " async='async' src", $tag);
		}
	}, 10, 2);
}
