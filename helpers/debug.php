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