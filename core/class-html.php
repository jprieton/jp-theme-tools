<?php

namespace jptt\core;

defined('ABSPATH') or die('No direct script access allowed');

class Html {

	public function options($data = array(), $options = array()) {
		$format = '<option value="%s" %s>%s</option>';

		$defaults = array(
				'value' => 'value',
				'text' => 'text',
				'selected' => '',
				'echo' => FALSE,
		);

		$options = (object) wp_parse_args($options, $defaults);

		$html = '';
		foreach ($data as $item) {
			$html .= sprintf($format, $item->{$options->value}, selected($item->{$options->value}, $options->selected, FALSE), $item->{$options->text});
		}

		if ($options->echo) {
			echo $html;
		}
		return $html;
	}

}
