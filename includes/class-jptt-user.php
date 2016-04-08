<?php

/** Block direct access */
defined( 'ABSPATH' ) or die( 'No direct script access allowed' );

/**
 *
 * @since 1.0.0
 *
 */
class JPTT_User {

	/** Refers to a single instance of this class. */
	private static $instance = null;

	/**
	 * Creates or returns an instance of this class.
	 *
	 * @since 1.0.0
	 *
	 * @return JPTT_User A single instance of this class.
	 */
	public static function get_instance() {

		if ( self::$instance == null ) {
			self::$instance = new self;
		}

		return self::$instance;
	}

	private function __construct() {

	}

	/**
	 * Insert a user into the database with minimun fields.
	 *
	 * @since 1.0.0
	 *
	 * @param string $user_email
	 * @param string $user_pass
	 * @return int|WP_Error The newly created user's ID or a WP_Error object if the user could not be created.
	 */
	public function quick_register( $user_email, $user_pass ) {

		$user_email = trim( $user_email );
		$user_login = $user_pass = trim( $user_pass );

		if ( !filter_var( $user_email, FILTER_VALIDATE_EMAIL ) ) {
			return new WP_Error( 'invalid_email', __( 'Invalid email' ) );
		}

		if ( empty( $user_email ) || empty( $user_pass ) ) {
			return new WP_Error( 'invalid_data', __( 'Empty request' ) );
		}

		$userdata = compact( 'user_login', 'user_email', 'user_pass' );

		$userdata = apply_filters( 'pre_user_quick_register', $userdata );

		if ( is_wp_error( $userdata ) ) {
			return $userdata;
		}

		$user_id = wp_insert_user( $userdata );

		return $user_id;
	}

}

add_action( 'wp_ajax_nopriv_user_quick_register', function() {
	$nonce = filter_input( INPUT_POST, '_wpnonce', FILTER_SANITIZE_STRING );
	$verify_nonce = (bool) wp_verify_nonce( $nonce, 'user_quick_register' );

	if ( !$verify_nonce ) {
		$error = new WP_Error( 'action_disabled', __( 'Action disabled' ) );
		wp_send_json_error( $error );
	}

	$user_email = trim( filter_input( INPUT_POST, 'user_email', FILTER_SANITIZE_EMAIL ) );
	$user_pass = filter_input( INPUT_POST, 'user_password', FILTER_SANITIZE_STRING );

	do_action( 'pre_user_quick_register', $user_email, $user_pass );

	$user = JPTT_User::get_instance();
	$user_id = $user->quick_register( $user_email, $user_pass );

	do_action( 'post_user_quick_register', $user_id );

	if ( is_wp_error( $user_id ) ) {
		wp_send_json_error( $user_id );
	} else {
		add_user_meta( $user_id, 'show_admin_bar_front', 'false' );
		$response[] = array(
				'code' => 'register_success',
				'message' => __( 'Register success' ),
		);
		wp_send_json_success( $response );
	}
} );
