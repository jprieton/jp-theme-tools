<?php

namespace jptt\core;

defined('ABSPATH') or die('No direct script access allowed');

/**
 * @since  0.9.0
 * @author jprieton
 */
class Error extends \WP_Error {

	public function __construct($code = '', $message = '', $data = '') {
		parent::__construct($code, $message, $data);
	}

	/**
	 * Shortcut fot <i>method not support</i> error
	 * @since v0.9.0
	 * @author jprieton
	 * @param string $method
	 */
	public function method_not_supported($method = null) {
		$code = 'method_not_supported';
		$message = __('Method not supported', 'jptt');
		$this->add($code, $message);
		$this->add('action', $method);
	}

	/**
	 * Shortcut fot <i>user not logged</i> error
	 * @since v0.9.0
	 * @param string $method
	 * @author jprieton
	 */
	public function user_not_logged($method = null) {
		$code = 'user_not_logged';
		$message = __('User not logged yet', 'jptt');
		$this->add($code, $message);
		$this->add('action', $method);
	}

	/**
	 * Shortcut fot <i>user logged in</i> error
	 * @since v0.9.0
	 * @param string $method
	 * @author jprieton
	 */
	public function user_logged_in($method = null) {
		$code = 'user_logged_in';
		$message = __('User logged in yet', 'jptt');
		$this->add($code, $message);
		$this->add('action', $method);
	}

	/**
	 * Shortcut fot <i>user logged in</i> error
	 * @since v0.9.0
	 * @param string $method
	 * @author jprieton
	 */
	public function incorrect_data($method = null) {
		$code = 'incorrect_data';
		$message = __('Incorrect data', 'jptt');
		$this->add($code, $message);
		$this->add('action', $method);
	}

}
