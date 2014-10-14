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
						<tr valign="top">
								<th scope="row">Google Analytics</th>
								<td>
										<textarea rows="6" class="large-text code" name="google-analytics"><?php echo get_option('google-analytics') ?></textarea>
										<p class="description">Código de seguimiento de Universal Analytics</p>
								</td>
						</tr>
				</table>
				<?php submit_button(); ?>
		</form>
</div>