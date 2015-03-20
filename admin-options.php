<div class="wrap">
	<h2>JP Theme Tools - Opciones Generales</h2>
	<?php if (isset($_GET['settings-updated'])) { ?>
		<div id="message" class="updated">
			<p><strong><?php _e('Settings saved.') ?></strong></p>
		</div>
	<?php } ?>
	<form method="post" action="options.php">
			<?php
			settings_fields('jptt-settings-group');
			do_settings_sections('jptt-settings-group');
			?>
		<table class="form-table">
			
		</table>
		<?php //submit_button(); ?>
	</form>
</div>
