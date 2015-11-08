<?php

if ( !function_exists( 'is_url' ) ) {

	/**
	 * Verifies that an url is valid.
	 * @since 0.12.3
	 * @param string $url Email address to verify.
	 * @return string|bool Either false or the valid url address.
	 */
	function is_url( $url ) {
		return filter_var( $url, FILTER_VALIDATE_URL );
	}

}
