<?php

namespace jptt\core;

/**
 * @since 0.9.0
 */
class Input {

	/**
	 *
	 * @var string
	 */
	public $request_method;

	public function get_method() {
		if (empty($this->request_method)) {
			return filter_var($_SERVER['REQUEST_METHOD']);
		} else {
			return $this->request_method;
		}
	}

	public function set_method($method) {
		switch (strtoupper($method)) {
			case 'GET':
			case 'POST':
				$this->request_method = strtoupper($method);
				break;
			default:
				$this->request_method = NULL;
				break;
		}
	}

	public function get($field, $args = array()) {
		$defaults = array(
				'filter' => FILTER_DEFAULT,
				'default' => FALSE,
				'method' => $this->get_method(),
				'callback' => NULL
		);
		$options = wp_parse_args($args, $defaults);

		switch (strtoupper($options['method'])) {
			case 'GET':
				$type = INPUT_GET;
				break;

			case 'POST':
				$type = INPUT_POST;
				break;

			default:
				break;
		}

		$value = filter_input($type, $field, $options['filter']);
		return empty($value) ? $options['default'] : $value;
	}

}
