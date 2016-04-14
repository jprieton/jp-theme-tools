<?php

/** Block direct access */
defined( 'ABSPATH' ) or die( 'No direct script access allowed' );

/**
 *
 * @since 1.0.0
 *
 */
class JPTT_Security {

	/** Refers to a single instance of this class. */
	private static $instance = null;
	private static $table_exists = null;

	/**
	 * Creates or returns an instance of this class.
	 *
	 * @since 1.0.0
	 *
	 * @return JPTT_Security A single instance of this class.
	 */
	public static function get_instance() {

		if ( self::$instance == null ) {
			self::$instance = new self;
		}

		return self::$instance;
	}

	private function __construct() {
		
	}

}

add_filter( 'x_manage_posts_columns', function( $posts_columns, $post_type) {
	$i = 0;
	$_post_columns = array();
	foreach ( $posts_columns as $key => $value ) {
		if ( 5 == $i ) {
			$_posts_columns['featured'] = __( 'Featured', JPTT_TEXTDOMAIN );
		}
		$_posts_columns[$key] = $value;
		$i++;
	}
	return $_posts_columns;
}, 10, 2 );

add_action( 'x_manage_posts_custom_column', function($column_name, $post_ID) {
	if ( 'featured' == $column_name ) {
		echo 'aa';
	}
}, 10, 2 );
