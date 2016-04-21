<?php

/**
 * Get template part.
 *
 * @access public
 * @param mixed $slug
 * @param string $name (default: '')
 */
function jptt_get_template_part( $slug, $name = null ) {

	$template = '';

	// Look in yourtheme/jptt/slug-name.php
	if ( $name ) {
		$template = locate_template( array( "jptt/{$slug}-{$name}.php" ) );
	}

	// Get default slug-name.php
	if ( !$template && $name && file_exists( JPTT_TEMPLATE_PATH . "/{$slug}-{$name}.php" ) ) {
		$template = JPTT_TEMPLATE_PATH . "/{$slug}-{$name}.php";
	}

	// If template file doesn't exist, look in yourtheme/jptt/slug.php
	if ( !$template ) {
		$template = locate_template( array( "jptt/{$slug}.php" ) );
	}

	// If template file doesn't existGet default slug.php
	if ( !$template && file_exists( JPTT_TEMPLATE_PATH . "/{$slug}.php" ) ) {
		$template = JPTT_TEMPLATE_PATH . "/{$slug}.php";
	}

	$template = realpath( $template );

	// Allow 3rd party plugins to filter template file from their plugin.
	$template = apply_filters( 'jptt_get_template_part', $template, $slug, $name );

	if ( $template ) {
		load_template( $template, false );
	}
}

/**
 * Shows the pagination block
 *
 * @since 1.0.0
 *
 * @param string $type Optional. Either 'default' or 'pager'
 *
 * @see http://getbootstrap.com/components/#pagination
 */
function jptt_paginate() {
	jptt_get_template_part( 'global', 'paginate' );
}
