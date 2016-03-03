<?php

namespace jptt;

/** Block direct access */
defined( 'ABSPATH' ) or die( 'No direct script access allowed' );

/**
 * 
 * @since 1.0.0
 * 
 */
class Input {

	/**
	 * 
	 * Get value of nonce field
	 * 
	 * @since 1.0.0
	 * 
	 * @param type $field
	 * @param type $type
	 * @return string
	 */
	public function get_wpnonce( $field = '_wpnonce', $type = INPUT_POST ) {
		if ( !in_array( $type, array(INPUT_POST, INPUT_GET) ) ) {
			return '';
		}
		return $value = filter_input( $type, $field, FILTER_SANITIZE_STRIPPED );
	}

	/**
	 * 
	 * Wrapper to verify that correct nonce was used with time limit.
	 * 
	 * @param string $action
	 * @param string $field
	 * @param string $type
	 * @return false|int
	 * @since 0.9.0
	 * @author jprieton
	 */
	public function verify_wpnonce( $action, $field = '_wpnonce', $type = INPUT_POST ) {
		$nonce = $this->get_wpnonce( $field, $type );
		return wp_verify_nonce( $nonce, $action );
	}

}
