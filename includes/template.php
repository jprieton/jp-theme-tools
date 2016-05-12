<?php

/**
 * Custom get template part.
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
	if ( !$template && $name && file_exists( JPTT_PLUGIN_PATH . "/templates/{$slug}-{$name}.php" ) ) {
		$template = JPTT_PLUGIN_PATH . "/templates/{$slug}-{$name}.php";
	}

	// If template file doesn't exist, look in yourtheme/jptt/slug.php
	if ( !$template ) {
		$template = locate_template( array( "jptt/{$slug}.php" ) );
	}

	// If template file doesn't existGet default slug.php
	if ( !$template && file_exists( JPTT_PLUGIN_PATH . "/templates/{$slug}.php" ) ) {
		$template = JPTT_PLUGIN_PATH . "/templates/{$slug}.php";
	}

	if ( $template ) {
		$template = realpath( $template );
	}

	// Allow 3rd party plugins to filter template file from their plugin.
	$template = apply_filters( 'jptt_get_template_part', $template, $slug, $name );

	if ( $template ) {
		load_template( $template, false );
	}
}

/**
 * Shows the pagination component
 *
 * @since 0.18.2
 *
 * @see https://github.com/jprieton/jp-theme-tools/wiki/Pagination
 * @see http://getbootstrap.com/components/#pagination
 */
function jptt_pagination( $type = 'default' ) {
	$type = in_array( $type, array( 'default', 'pager' ) ) ? $type : 'default';
	jptt_get_template_part( "global/pagination-{$type}" );
}

/**
 * Aliases for jptt_pagination()
 * Shows the pagination component
 *
 * @since 0.18.2
 *
 * @see https://github.com/jprieton/jp-theme-tools/wiki/Pagination
 * @see http://getbootstrap.com/components/#pagination
 */
function bootstrap_pagination( $type = 'default' ) {
	jptt_pagination( $type );
}

/**
 * Get the bradcrumb item list
 *
 * @return array()
 */
function jptt_get_breadcrumb_items() {

	$current_item_have_link = (bool) apply_filters( 'jptt_breadcrumb_current_item_have_link', false );

	$items = array();

	$_home = (int) get_option( 'page_on_front' );
	$home_label = ( $_home ) ? get_the_title( $_home ) : __( 'Home Page', JPTT_TEXTDOMAIN );

	$home_label = apply_filters( 'jptt_breadcrumb_home_label', $home_label );

	$items[$home_label] = (is_front_page() && !$current_item_have_link) ? '' : home_url();

	if ( (is_singular() || is_home()) && !is_front_page() ) {

		/** Post and Pages */
		$post_ancestors = array_reverse( (array) get_post_ancestors( get_the_ID() ) );

		$post_type = get_post_type( get_the_ID() );
		$post_type_object = get_post_type_object( $post_type );

		if ( $post_type_object->has_archive ) {
			$items[$post_type_object->labels->name] = get_post_type_archive_link( $post_type );
		} elseif ( 'post' == $post_type ) {
			$_posts = (int) get_option( 'page_for_posts' );
			$_posts_label = ($_posts) ? get_the_title( $_posts ) : $post_type_object->labels->name;
			$items[$_posts_label] = (!$current_item_have_link) ? '' : get_post_type_archive_link( $post_type );
		}

		foreach ( $post_ancestors as $ancestor_id ) {
			$post_ancestor = get_post( $ancestor_id );
			$items[$post_ancestor->post_title] = get_permalink( $post_ancestor->ID );
		}
		$active = get_the_title();
	} elseif ( is_post_type_archive() ) {

		/** Post type archive */
		$post_type = get_post_type();
		$post_type_object = get_post_type_object( $post_type );
		$active = $post_type_object->labels->name;
	} elseif ( is_category() ) {

		$term_object = get_term_by( 'slug', get_query_var( 'category_name' ), 'category' );
		$active = $term_object->name;
		$hierarchy_terms = array( $term_object );
		$term_ancestor_id = (int) $term_object->parent;
		while ( $term_ancestor_id != 0 ) {
			$_term = get_term( $term_ancestor_id, 'category' );
			$hierarchy_terms[] = $_term;
			$term_ancestor_id = (int) $_term->parent;
		}
		$hierarchy_terms = array_reverse( (array) $hierarchy_terms );

		$count = count( $hierarchy_terms );

		foreach ( $hierarchy_terms as $term ) {
			$count--;
			$items[$term->name] = (!$current_item_have_link && !$count) ? '' : get_term_link( $term );
		}
	} elseif ( is_tax() ) {

		if ( !is_taxonomy_hierarchical( get_query_var( 'taxonomy' ) ) ) {
			$term_object = get_term_by( 'slug', get_query_var( 'term' ), get_query_var( 'taxonomy' ) );
			$active = $term_object->name;
		} else {
			$taxonomy = get_query_var( 'taxonomy' );
			$term_object = get_term_by( 'slug', get_query_var( 'term' ), $taxonomy );
			$active = $term_object->name;

			$hierarchy_terms = array();
			$term_ancestor_id = (int) $term_object->parent;
			while ( $term_ancestor_id != 0 ) {
				$_term = get_term( $term_ancestor_id, $taxonomy );
				$hierarchy_terms[] = $_term;
				$term_ancestor_id = (int) $_term->parent;
			}
			$hierarchy_terms = array_reverse( (array) $hierarchy_terms );

			foreach ( $hierarchy_terms as $term ) {
				$items[$term->name] = get_term_link( $term );
			}
		}
	}

	if ( !is_front_page() && is_singular() ) {
		$items[get_the_title()] = (!$current_item_have_link) ? '' : get_the_permalink();
	}

	$items = apply_filters( 'jptt_breadcrumb_items', $items );

	return $items;
}

/**
 * Shows the breadcrumb component
 *
 * @since 0.19.2
 *
 * @see https://github.com/jprieton/jp-theme-tools/wiki/Breadcrumb
 * @see http://getbootstrap.com/components/#breadcrumbs
 */
function jptt_breadcrumb() {
	jptt_get_template_part( "global/breadcrumb" );
}

/**
 * Aliases for jptt_breadcrumb()
 * Shows the breadcrumb component
 *
 * @since 0.19.2
 *
 * @see https://github.com/jprieton/jp-theme-tools/wiki/Breadcrumb
 * @see http://getbootstrap.com/components/#pagination
 */
function bootstrap_breadcrumb() {
	jptt_breadcrumb();
}

/**
 * Shows the Bootstrap modal
 *
 * @since 0.19.2
 *
 * @staticvar int $id
 * @param array $args
 */
function bootstrap_modal( $args ) {
	static $id;

	if ( empty( $id ) ) {
		$id = 0;
	}

	$id++;

	$defaults = array(
			'id' => "bs-modal-{$id}",
			'class' => '',
			'title' => '',
			'body' => '',
			'footer' => ''
	);

	$args = wp_parse_args( (array) $args, $defaults );
	?>
	<div class="modal fade <?php echo $args['class'] ?>" tabindex="-1" role="dialog">
		<div class="modal-dialog">
			<div class="modal-content">

				<?php if ( !empty( $args['title'] ) ) : ?>
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
						<h4 class="modal-title"><?php echo $args['title'] ?></h4>
					</div>
				<?php endif ?>

				<div class="modal-body">
						<?php echo $args['body'] ?>
				</div>

				<?php if ( !empty( $args['footer'] ) ) : ?>
					<div class="modal-footer">
						<?php echo $args['footer'] ?>
					</div>
				<?php endif ?>

			</div><!-- /.modal-content -->
		</div><!-- /.modal-dialog -->
	</div><!-- /.modal -->
	<?php
}

/**
 * Shows a default image when the post don't have featured image
 *
 * @since 0.20.0
 */
add_filter( 'post_thumbnail_html', function($html, $post_id, $post_thumbnail_id, $size, $attr) {
	if ( !empty( $html ) ) {
		return $html;
	}

	static $not_found_image;

	if ( empty( $not_found_image ) ) {
		$locale = substr( get_locale(), 0, 2 );
		if ( empty( $locale ) || !file_exists( JPTT_PLUGIN_PATH . 'images/not-available-' . $locale . '.png' ) ) {
			$not_found_image = JPTT_PLUGIN_URI . 'images/not-available-en.png';
		} else {
			$not_found_image = JPTT_PLUGIN_URI . 'images/not-available-' . $locale . '.png';
		}

		$not_found_image = jptt_get_option( 'not-found-image', $not_found_image );
	}

	$img_attr = array(
			'alt = "' . __( 'Image not available', TEXT_DOMAIN ) . '"',
			'src = "' . $not_found_image . '"'
	);
	foreach ( (array) $attr as $key => $value ) {
		$img_attr[] = $key . ' = "' . ((is_array( $value )) ? implode( ' ', $value ) : $value) . ' ' . "attachment-$size size-$size" . '"';
	}

	return '<img ' . implode( ' ', $img_attr ) . '>  ';
}, 10, 5 );
