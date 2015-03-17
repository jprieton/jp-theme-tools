<?php

defined('ABSPATH') or die("No script kiddies please!");

class User_Actions {

	/**
	 * Maximum login attempts
	 * @var int
	 */
	private $max_login_attempts;

	public function __construct() {
		$this->max_login_attempts = (int) get_option('max-login-attemps', -1);
	}

	public function user_signon() {
		$nonce        = filter_input(INPUT_POST, '_wpnonce', FILTER_SANITIZE_STRING);
		$verify_nonce = (bool) wp_verify_nonce($nonce, 'user_signon');
		$user_blocked = false;

		if ($verify_nonce) {
			$submit = array(
					'user_login'    => filter_input(INPUT_POST, 'user_login', FILTER_SANITIZE_STRING),
					'user_password' => filter_input(INPUT_POST, 'user_password', FILTER_SANITIZE_STRING),
					'remember'      => filter_input(INPUT_POST, 'remember', FILTER_SANITIZE_STRING)
			);

			$user_id      = username_exists($submit['user_login']);
			$user_blocked = ($user_id > 0) ? $this->is_user_blocked(user_id) : FALSE;

			if (!$user_blocked) {
				$user = wp_signon($submit, false);
			}
			if (is_wp_error($user) or $user_blocked) {
				$this->add_user_attempt($user_id);
			} else {
				$this->clear_user_attempt($user_id);
			}
		}

		header('Content-Type: application/json');
		(is_wp_error($user) || $user_blocked) ? die('false') : die('true');
	}

	public function user_register() {
		$nonce        = filter_input(INPUT_POST, '_wpnonce', FILTER_SANITIZE_STRING);
		$verify_nonce = (bool) wp_verify_nonce($nonce, 'user_register');

		do_action('pre_user_register');

		(($verify_nonce || !is_user_logged_in()) || die('false'));

		$userdata = array(
				'user_pass'  => filter_input(INPUT_POST, 'user_pass'),
				'user_login' => filter_input(INPUT_POST, 'user_email'),
				'user_email' => filter_input(INPUT_POST, 'user_email')
		);

		$user_id = wp_insert_user($userdata);

		do_action('post_user_register', $user_id);

		header('Content-Type: application/json');
		is_wp_error($user_id) ? die('false') : die('true');
	}

	/**
	 *
	 * @param int $user_id
	 * @return boolean
	 */
	private function is_user_blocked($user_id) {
		$user_blocked = (bool) get_user_meta($user_id, 'user_blocked', TRUE);

		if (!$user_blocked && $this->max_login_attempts > 0) {

			$user_attemps = (int) get_user_meta($user_id, 'login_attemps', TRUE);

			if ($user_attemps > $this->max_login_attempts) {
				$this->block_user($user_id);
				$user_blocked = TRUE;
			}
		}
		return $user_blocked;
	}

	/**
	 *
	 * @param int $user_id
	 */
	private function block_user($user_id) {
		add_user_meta($user_id, 'user_blocked', TRUE, TRUE);
	}

	/**
	 *
	 * @param int $user_id
	 */
	private function add_user_attempt($user_id) {
		$login_attempts = (int) get_user_meta($user_id, 'login_attempts', TRUE);
		$login_attempts++;
		update_user_meta($user_id, 'login_attempts', $login_attempts);
	}

	/**
	 *
	 * @param int $user_id
	 */
	private function clear_user_attempt($user_id) {
		update_user_meta($user_id, 'login_attempts', 0);
	}

}

$User_Actions = new User_Actions();
add_action('wp_ajax_nopriv_user_signon', array($User_Actions, 'user_signon'));
add_action('wp_ajax_nopriv_user_register', array($User_Actions, 'user_register'));
