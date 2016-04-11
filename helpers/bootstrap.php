<?php

/**
 * Display the Bootstrap modal
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
 * Display the Bootstrap pagination
 *
 * @global wpdb $wp_query
 * @param array() $args
 * @return void
 * @see https://codex.wordpress.org/Function_Reference/paginate_links
 * @see http://getbootstrap.com/components/#pagination
 */
function bootstrap_pagination( $args = array() ) {
	global $wp_query;
	$defaults = array(
			'id' => '',
			'class' => '',
			'prev_text' => '<span aria-hidden="true">&laquo;</span>',
			'next_text' => '<span aria-hidden="true">&raquo;</span>',
	);
	$args = wp_parse_args( (array) $args, $defaults );
	$args['type'] = 'list';

	if ( $wp_query->max_num_pages <= 1 ) {
		return;
	}
	?>
	<nav itemscope itemtype="http://schema.org/SiteNavigationElement">
			<?php
			$paginate = paginate_links( $args );
			$search = array(
					"<ul class='page-numbers'>",
					"<li><span class='page-numbers current'>"
			);
			$replace = array(
					"<ul class='page-numbers pagination {$args['class']}' id='{$args['id']}'>",
					"<li class='active'><span class='page-numbers current'>"
			);
			echo str_replace( $search, $replace, $paginate )
			?>
	</nav>
	<?php
}
