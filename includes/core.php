<?php

defined( 'ABSPATH' ) or die( 'No direct script access allowed' );

function jptt_get_option( $option, $default = false ) {
	global $jptt_options;

	$option = trim( $option );
	if ( empty( $option ) ) {
		return false;
	}

	if ( empty( $jptt_options ) ) {
		$jptt_options = get_option( 'jptt_options', array() );
	}

	$result = !empty( $jptt_options[$option] ) ? $jptt_options[$option] : $default;

	return $result;
}

function jptt_update_option( $option, $value, $autoload = null ) {
	global $jptt_options;

	$option = trim( $option );
	if ( empty( $option ) ) {
		return false;
	}

	if ( empty( $jptt_options ) ) {
		$jptt_options = get_option( 'jptt_options', array() );
	}

	$jptt_options[$option] = $value;

	return update_option( 'jptt_options', $jptt_options, $autoload );
}
