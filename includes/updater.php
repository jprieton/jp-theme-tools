<?php

if (!defined('JPTT_PLUGIN_PATH')) return;

class JP_Theme_Tools
{

	public static function plugin_setup()
	{
		add_filter('upgrader_source_selection', array('JP_Theme_Tools', 'rename_github_zip'), 1);

		require JPTT_PLUGIN_PATH . '/plugin-updates/plugin-update-checker.php';
		$update_checker = PucFactory::buildUpdateChecker('https://raw.github.com/jprieton/jp-theme-tools/master/includes/update.json', __FILE__, 'jp-theme-tools-master');
	}

	public static function rename_github_zip($source)
	{
		if (FALSE === strpos($source, 'jp-theme-tools')) return $source;

		$path_parts = pathinfo($source);
		$newsource = trailingslashit($path_parts['dirname']) .
						trailingslashit('jp-theme-tools');
		rename($source, $newsource);

		return $newsource;
	}

}

add_action('plugins_loaded', array('JP_Theme_Tools', 'plugin_setup'));
