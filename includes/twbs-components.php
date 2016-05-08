<?php

/**
 * Shows a Boostrap alert block
 * 
 * @see http://getbootstrap.com/components/#alerts
 * 
 * @param string $content
 * @param string $type
 * @param array $args
 */
function twbs_alert( $content, $args = array() ) {
	$defaults = array(
			'dismissible' => false,
			'class' => 'alert alert-info',
	);
	$args = wp_parse_args( $args, $defaults );

	if ( $args['dismissible'] ) {
		$args['class'] .= ' alert-dismissible';
	}
	?>
	<div class="<?php echo $args['class'] ?>" role="alert">
		<button type="button" class="close" data-dismiss="alert" aria-label="<?php _e( 'Close', JPTT_TEXTDOMAIN ) ?>"><span aria-hidden="true">&times;</span></button>
		<?php echo $content ?>
	</div>
	<?php
}

/**
 * Shows a Boostrap progress bar block
 * 
 * @see http://getbootstrap.com/components/#progress
 * 
 * @staticvar int $id
 * @param array $args
 */
function twbs_progress_bar( $args = array() ) {

	$defaults = array(
			'class' => 'progress-bar',
			'min' => 0,
			'max' => 100,
			'value' => '0',
			'label' => __( '%d Complete', JPTT_TEXTDOMAIN ),
			'id' => '',
	);

	$args = wp_parse_args( $args, $defaults );

	static $id;
	if ( !$id ) {
		$id = 0;
	}

	if ( $args['id'] ) {
		$progress_id = $args['id'];
	} else {
		$id ++;
		$progress_id = 'progress-bar-' . $id;
	}
	?>
	<div class="progress" id="<?php echo $progress_id ?>">
		<div class="<?php echo $args['class'] ?>" role="progressbar" aria-valuenow="<?php echo $args['value'] ?>" aria-valuemin="<?php echo $args['min'] ?>" aria-valuemax="<?php echo $args['max'] ?>" style="width: 40%">
			<span class="sr-only"><?php printf( $args['label'], $args['value'] ) ?></span>
		</div>
	</div>
	<?php
}
