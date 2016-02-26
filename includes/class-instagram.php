<?php

namespace jptt;

/** Block direct access */
defined( 'ABSPATH' ) or die( 'No direct script access allowed' );

/**
 *
 * @since 1.0.0
 *
 */
class Instagram {

	private $client_id;
	private $access_token;
	private $api_url = 'https://api.instagram.com/v1';

	/**
	 *
	 * @since 1.0.0
	 *
	 * @param array $args
	 */
	public function __construct( $args = array() ) {
		if ( !empty( $args['client_id'] ) ) $this->set_client_id( $args['client_id'] );
		if ( !empty( $args['access_token'] ) ) $this->set_client_id( $args['access_token'] );
	}

	/**
	 *
	 * @since 1.0.0
	 *
	 * @param string $client_id
	 */
	public function set_client_id( $client_id ) {
		$this->client_id = trim( $client_id );
	}

	/**
	 *
	 * @since 1.0.0
	 *
	 * @param string $access_token
	 */
	public function set_access_token( $access_token ) {
		$this->access_token = trim( $access_token );
	}

	/**
	 *
	 * @since 1.0.0
	 *
	 * @param string $endpoint
	 * @param array $args
	 * @return object|boolean
	 */
	function get_endpoint_response( $endpoint, $args = array() ) {
		if ( empty( $this->access_token ) ) {
			return false;
		}
		$url = $this->_get_endpoint_url( $endpoint, $args );

		$response = wp_remote_retrieve_body( wp_remote_get( $url ) );
		$json = json_decode( $response );
		return $json ? $json : false;
	}

	/**
	 *
	 * @since 1.0.0
	 *
	 * @param string $endpoint
	 * @param array $args
	 * @param int $expiration
	 * @return object|boolean
	 */
	function get_endpoint_transient( $endpoint, $args = array(), $expiration = NULL ) {

		if ( empty( $expiration ) ) {
			$expiration = 12 * HOUR_IN_SECONDS;
		}

		$transient = 'ig_' . md5( $this->_get_endpoint_url( $endpoint, $args ) );

		$response = get_transient( $transient );

		if ( !$response ) {
			$response = $this->get_endpoint( $endpoint, $args );
			set_transient( $transient, $response, $expiration );
		}

		return $response;
	}

	/**
	 *
	 * @since 1.0.0
	 *
	 * @return boolean|string
	 */
	function get_authorize_url() {

		if ( empty( $this->client_id ) ) {
			return false;
		}

		$url = 'https://instagram.com/oauth/authorize/?client_id=' . $this->client_id . '&redirect_uri=' . get_site_url() . '&response_type=token';
		return $url;
	}

	/**
	 *
	 * @since 1.0.0
	 *
	 * @param string $endpoint
	 * @param array $args
	 * @return boolean|string
	 */
	private function _get_endpoint_url( $endpoint, $args = array() ) {

		if ( empty( $this->access_token ) ) {
			return false;
		}

		$defaults = array(
				'access_token' => $this->access_token,
		);

		$args = wp_parse_args( $args, $defaults );

		$query = build_query( $args );
		$url = "{$this->api_url}/{$endpoint}/?{$query}";

		return $url;
	}

}
