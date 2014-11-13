<?php

if (!function_exists('debug')) {

	/**
	 * Dumps information about the variable wrapped in &lt;pre&gt; tag and, optionally, terminate the current script.
	 *
	 * @param mixed $var The variable you want to dump.
	 * @param bool $stop If true terminate the current script.
	 * @return void
	 */
	function debug($var, $stop = false)
	{
		echo '<pre>';
		var_dump($var);
		echo '</pre>';

		if ($stop) {
			die();
		}
	}

}

function jptt_get_template($template_file)
{
	if ($overridden_template = locate_template('theme-tools/' . $template_file)) {
		// locate_template() returns path to file
		// if either the child theme or the parent theme have overridden the template
		load_template($overridden_template);
	} else {
		// If neither the child nor parent theme have overridden the template,
		// we load the template from the 'templates' sub-directory of the directory this file is in
		load_template(JPTT_PLUGIN_PATH . '/templates/' . $template_file);
	}
}

function jptt_valid_url($url)
{
	return esc_url_raw($url, array('http', 'https'));
}

if (!function_exists('boolval')) {

	function boolval($var)
	{
		return (bool) $var;
	}

}