<div class="wrap">
		<h2>JP Theme Tools - Misceláneas</h2>
		<?php if (isset($_GET['settings-updated'])) { ?>
			<div id="message" class="updated">
					<p><strong><?php _e('Settings saved.') ?></strong></p>
			</div>
		<?php } ?>
		<form method="post" action="options.php">
				<?php
				settings_fields('jptt-misc-group');
				do_settings_sections('jptt-misc-group');
				?>
				<table class="form-table">
						<tr valign="top">
								<th scope="row">Ocultar versión de WordPress</th>
								<td>
										<?php $checked = ((bool) get_option('remove-generator')) ? 'checked' : '' ?>
										<input type="checkbox" value="1" id="remove-generator" name="remove-generator" <?php echo $checked ?>>
										<p class="description">Elimina la etiqueta meta generator que indica la versión de WordPress.</p>
								</td>
						</tr>
				</table>
				<?php submit_button(); ?>
		</form>
</div>
