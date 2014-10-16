<div class="wrap">
		<h2>JP Theme Tools - Contacto</h2>
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
						<tr valign="top">
								<th scope="row">Email</th>
								<td>
										<input type="text" class="regular-text" name="contact-form-email" value="<?php echo esc_attr(get_option('contact-form-email')); ?>" />
										<p class="description">Email de destino del formulario de contacto.</p>
								</td>
						</tr>
						<tr valign="top">
								<th scope="row">Email</th>
								<td>
										<input type="text" class="regular-text" name="contact-email" value="<?php echo esc_attr(get_option('contact-email')); ?>" />
								</td>
						</tr>
						<tr valign="top">
								<th scope="row">Tel&eacute;fono</th>
								<td>
										<input type="text" class="regular-text" name="contact-phone" value="<?php echo esc_attr(get_option('contact-phone')); ?>" />
								</td>
						</tr>
				</table>
				<?php submit_button(); ?>
		</form>
</div>
