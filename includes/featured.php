<?php

/** Block direct access */
defined( 'ABSPATH' ) or die( 'No direct script access allowed' );

$featured_enabled = (bool) jptt_get_option( 'module_featured' );

/** If module is disabled or isn't admin area omit filter & actions */
if ( !$featured_enabled || !is_admin() ) {
	return;
}

/** Filter to add featured column to admin posts */
add_filter( 'manage_posts_columns', function( $posts_columns, $post_type = null) {
	$new = array(
			'cb' => $posts_columns['cb'],
			'featured' => '<span class="dashicons dashicons-star-filled" title="' . __( 'Featured', JPTT_TEXTDOMAIN ) . '"><span class="screen-reader-text">' . __( 'Featured', JPTT_TEXTDOMAIN ) . '</span></span>'
	);

	$posts_columns = array_merge( $new, $posts_columns );
	return $posts_columns;
}, 10, 2 );

/** Filter to add featured column to admin pages */
add_filter( 'manage_pages_columns', function( $posts_columns, $post_type = null) {
	$new = array(
			'cb' => $posts_columns['cb'],
			'featured' => '<span class="dashicons dashicons-star-filled" title="' . __( 'Featured', JPTT_TEXTDOMAIN ) . '"><span class="screen-reader-text">' . __( 'Featured', JPTT_TEXTDOMAIN ) . '</span></span>'
	);

	$posts_columns = array_merge( $new, $posts_columns );
	return $posts_columns;
}, 10, 2 );

/** Action to show featured value to admin posts */
add_action( 'manage_posts_custom_column', function($column_name, $post_id) {
	if ( 'featured' != $column_name ) {
		return;
	}

	$featured = (bool) get_post_meta( $post_id, '_featured', true );
	if ( $featured ) {
		echo '<a href="#" class="dashicons dashicons-star-filled toggle-featured" data-id="' . $post_id . '"></a>';
	} else {
		echo '<a href="#" class="dashicons dashicons-star-empty toggle-featured" data-id="' . $post_id . '"></a>';
	}
}, 10, 2 );

/** Action to show featured value to admin pages */
add_action( 'manage_pages_custom_column', function($column_name, $post_id) {
	if ( 'featured' != $column_name ) {
		return;
	}

	$featured = (bool) get_post_meta( $post_id, '_featured', true );
	if ( $featured ) {
		echo '<a href="#" class="dashicons dashicons-star-filled toggle-featured" data-id="' . $post_id . '"></a>';
	} else {
		echo '<a href="#" class="dashicons dashicons-star-empty toggle-featured" data-id="' . $post_id . '"></a>';
	}
}, 10, 2 );

add_action( 'wp_ajax_toggle_featured_post', function() {
	if ( !is_admin() ) {
		$error = new WP_Error( 'action_disabled', __( 'Action disabled' ) );
		wp_send_json_error( $error );
	}

	$post_id = (int) (filter_input( INPUT_POST, 'post_id', FILTER_SANITIZE_NUMBER_INT ) ? : filter_input( INPUT_GET, 'post_id', FILTER_SANITIZE_NUMBER_INT ));

	if ( empty( get_post( $post_id ) ) ) {
		$error = new WP_Error( 'action_disabled', __( 'Action disabled' ) );
		wp_send_json_error( $error );
	}

	$featured = (int) get_post_meta( $post_id, '_featured', true );

	update_post_meta( $post_id, '_featured', (int) !$featured );

	wp_send_json_success( (bool) !$featured  );
} );
