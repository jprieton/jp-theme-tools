<?php

/** Block direct access */
defined( 'ABSPATH' ) or die( 'No direct script access allowed' );

/**
 *
 * @since 1.0.0
 *
 */
class JPTT_Favorite {

	/** Refers to a single instance of this class. */
	private static $instance = null;

	/**
	 * Creates or returns an instance of this class.
	 *
	 * @since 1.0.0
	 *
	 * @return JPTT_Favorite A single instance of this class.
	 */
	public static function get_instance() {

		if ( self::$instance == null ) {
			self::$instance = new self;
		}

		return self::$instance;
	}

	private function __construct() {
		$this->userdata = get_userdata( get_current_user_id() );
	}

	/**
	 * Creates favorite table
	 *
	 * @since 1.0.0
	 *
	 * @global wpdb $wpdb
	 */
	public function create_table() {
		global $wpdb;
		$wpdb instanceof wpdb;
		$charset = !empty( $wpdb->charset ) ?
						"DEFAULT CHARACTER SET {$wpdb->charset}" :
						'';
		$collate = !empty( $wpdb->collate ) ?
						"COLLATE {$wpdb->collate}" :
						'';
		$query = "CREATE TABLE IF NOT EXISTS `{$wpdb->prefix}favorites` ("
						. "`post_id` bigint(20) unsigned NOT NULL, "
						. "`user_id` bigint(20) unsigned NOT NULL, "
						. "KEY `post_id` (`post_id`), "
						. "KEY `user_id` (`user_id`)"
						. ") ENGINE=InnoDB {$charset} {$collate}";
		$wpdb->query( $query );
	}

	/**
	 * @var WP_User
	 */
	private $userdata;

	/**
	 * Add post to user favorites
	 *
	 * @since 1.0.0
	 *
	 * @global wpdb $wpdb
	 * @param int|WP_Post $post Optional. Post ID or WP_Post object. Default is global `$post`.
	 * @param int|string|WP_User $user Optional. User ID, user login or  WP_User object. Defaults to current user.
	 * @return boolean
	 */
	public function add_favorite( $post = null, $user = null ) {
		global $wpdb;

		$post = get_post( $post );
		if ( !$post ) {
			return false;
		}

		if ( is_int( $user ) && $user > 0 ) {
			$_userdata = get_userdata( $user );
		} elseif ( is_string( $_userdata ) ) {
			$_userdata = get_user_by( 'login', $user );
		} elseif ( $user instanceof WP_User ) {
			$_userdata = $user;
		} else {
			$_userdata = $this->userdata;
		}

		$data = array(
				'post_id' => (int) $post->ID,
				'user_id' => (int) $_userdata->ID
		);

		$wpdb->insert( "{$wpdb->prefix}favorites", $data );
	}

	/**
	 * Remove post from user favorites
	 *
	 * @since 1.0.0
	 *
	 * @global wpdb $wpdb
	 * @param int|WP_Post $post Optional. Post ID or WP_Post object. Default is global `$post`.
	 * @param int|string|WP_User $user Optional. User ID, user login or  WP_User object. Defaults to current user.
	 * @return boolean
	 */
	public function remove_favorite( $post = null, $user = null ) {
		global $wpdb;

		$post = get_post( $post );
		if ( !$post ) {
			return false;
		}

		if ( is_int( $user ) && $user > 0 ) {
			$_userdata = get_userdata( $user );
		} elseif ( is_string( $_userdata ) ) {
			$_userdata = get_user_by( 'login', $user );
		} elseif ( $user instanceof WP_User ) {
			$_userdata = $user;
		} else {
			$_userdata = $this->userdata;
		}

		$where = array(
				'post_id' => (int) $post->ID,
				'user_id' => (int) $_userdata->ID
		);

		$wpdb->delete( "{$wpdb->prefix}favorites", $where );
	}

	/**
	 * Toggle favorite status
	 *
	 * @since 1.0.0
	 *
	 * @global wpdb $wpdb
	 * @param int|WP_Post $post Optional. Post ID or WP_Post object. Default is global `$post`.
	 * @param int|string|WP_User $user Optional. User ID, user login or  WP_User object. Defaults to current user.
	 * @return boolean
	 */
	public function toggle_favorite( $post = null, $user = null ) {
		$is_favorite = $this->is_favorite( $post, $user );

		if ( $is_favorite ) {
			$this->remove_favorite( $post, $user );
			return false;
		} else {
			$this->add_favorite( $post, $user );
			return true;
		}
	}

	/**
	 * Is favorite post?
	 *
	 * @since 1.0.0
	 *
	 * @global wpdb $wpdb
	 * @param int|WP_Post $post Optional. Post ID or WP_Post object. Default is global `$post`.
	 * @param int|string|WP_User $user Optional. User ID, user login or WP_User object. Defaults to current user.
	 * @return boolean
	 */
	public function is_favorite( $post = null, $user = null ) {
		global $wpdb;

		$post = get_post( $post );
		if ( !$post ) {
			return false;
		}

		if ( is_int( $user ) ) {
			$_userdata = get_userdata( $user );
		} elseif ( is_string( $_userdata ) ) {
			$_userdata = get_user_by( 'login', $user );
		} elseif ( $user instanceof WP_User ) {
			$_userdata = $user;
		} else {
			$_userdata = $this->userdata;
		}

		$is_favorite = (bool) $wpdb->get_var( "SELECT post_id "
										. "FROM {$wpdb->prefix}favorites "
										. "WHERE post_id = '{$post->ID}' "
										. "AND user_id = '{$_userdata->ID}' "
										. "LIMIT 1" );

		return $is_favorite;
	}

	/**
	 * Delete all favorites by post
	 *
	 * @since 1.0.0
	 *
	 * @global wpdb $wpdb
	 * @param @param int|WP_Post $post Post ID or WP_Post object.
	 */
	public function delete_favorites_by_post( $post ) {
		global $wpdb;

		$post = get_post( $post );
		if ( $post ) {
			$wpdb->delete( "{$wpdb->prefix}favorites", array( 'post_id' => "{$post->ID}" ) );
		}
	}

	/**
	 * Delete all favorites by user
	 *
	 * @since 1.0.0
	 *
	 * @global wpdb $wpdb
	 * @param int|string|WP_User $user User ID, user login or WP_User object.
	 */
	public function delete_favorites_by_user( $user ) {
		global $wpdb;

		if ( is_int( $user ) ) {
			$_userdata = get_userdata( $user );
		} elseif ( is_string( $_userdata ) ) {
			$_userdata = get_user_by( 'login', $user );
		} elseif ( $user instanceof WP_User ) {
			$_userdata = $user;
		} else {
			return;
		}

		$wpdb->delete( "{$wpdb->prefix}favorites", array( 'user_id' => "{$_userdata->ID}" ) );
	}

}

add_action( 'wp_ajax_user_toogle_favorite', function() {
	$post_id = (int) (filter_input( INPUT_POST, 'post_id', FILTER_SANITIZE_NUMBER_INT ) ? : filter_input( INPUT_GET, 'post_id', FILTER_SANITIZE_NUMBER_INT ));
	$user_id = (int) get_current_user_id();

	$favorite = JPTT_Favorite::get_instance();
	$is_favorite = (bool) $favorite->toggle_favorite( $post_id, $user_id );

	$is_favorite ? wp_send_json_success() : wp_send_json_error();
} );

add_action( 'wp_ajax_user_remove_favorite', function() {
	$post_id = (int) (filter_input( INPUT_POST, 'post_id', FILTER_SANITIZE_NUMBER_INT ) ? : filter_input( INPUT_GET, 'post_id', FILTER_SANITIZE_NUMBER_INT ));
	$user_id = (int) get_current_user_id();

	$favorite = JPTT_Favorite::get_instance();
	$favorite->remove_favorite( $post_id, $user_id );

	wp_send_json_error();
} );

add_action( 'wp_ajax_user_add_favorite', function() {
	$post_id = (int) (filter_input( INPUT_POST, 'post_id', FILTER_SANITIZE_NUMBER_INT ) ? : filter_input( INPUT_GET, 'post_id', FILTER_SANITIZE_NUMBER_INT ));
	$user_id = (int) get_current_user_id();

	$favorite = JPTT_Favorite::get_instance();
	$favorite->add_favorite( $post_id, $user_id );

	wp_send_json_success();
} );

add_action( 'before_delete_post', function ($post_id) {
	$favorite = JPTT_Favorite::get_instance();
	$favorite->delete_favorites_by_post( $post_id );
} );

add_action( 'delete_user', function ($user_id) {
	$favorite = JPTT_Favorite::get_instance();
	$favorite->delete_favorites_by_user( $user_id );
} );
