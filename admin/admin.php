<?php

add_action( 'customize_register', function($wp_customize) {
	$locale = substr( get_locale(), 0, 2 );

	if ( empty( $locale ) || !file_exists( JPTT_PLUGIN_PATH . 'images/not-available-' . $locale . '.png' ) ) {
		$not_found_image = JPTT_PLUGIN_URI . 'images/not-available-en.png';
	} else {
		$not_found_image = JPTT_PLUGIN_URI . 'images/not-available-' . $locale . '.png';
	}

	/**
	 * Add default not found image to theme customizer
	 *
	 * @since 0.20.0
	 */
	$wp_customize->add_setting( 'jptt_options[not-found-image]', array(
			'default' => $not_found_image,
			'capability' => 'edit_theme_options',
			'type' => 'option',
	) );
	$wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize, 'not_found_image', array(
			'settings' => 'jptt_options[not-found-image]',
			'label' => __( 'Not found image', JPTT_TEXTDOMAIN ),
			'section' => 'title_tagline',
			'priority' => 99
	) ) );
} );
