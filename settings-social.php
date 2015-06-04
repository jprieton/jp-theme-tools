<div class="wrap">
		<h2>JP Theme Tools - Social</h2>
		<?php if (isset($_GET['settings-updated'])) { ?>
	    <div id="message" class="updated">
	        <p><strong><?php _e('Settings saved.') ?></strong></p>
	    </div>
		<?php } ?>
		<form method="post" action="options.php">
				<?php
				settings_fields('jptt-social-group');
				do_settings_sections('jptt-social-group');
				?>
				<table class="form-table">
						<tr valign="top">
								<th scope="row">Facebook</th>
								<td>
										<input type="text" class="regular-text" name="social-facebook" value="<?php echo esc_attr(get_option('social-facebook')); ?>" />
								</td>
						</tr>
						<tr valign="top">
								<th scope="row">Google+</th>
								<td>
										<input type="text" class="regular-text" name="social-googleplus" value="<?php echo esc_attr(get_option('social-googleplus')); ?>" />
								</td>
						</tr>
						<tr valign="top">
								<th scope="row">Instagram</th>
								<td>
										<input type="text" class="regular-text" name="social-instagram" value="<?php echo esc_attr(get_option('social-instagram')); ?>" />
								</td>
						</tr>
						<tr valign="top">
								<th scope="row">Pinterest</th>
								<td>
										<input type="text" class="regular-text" name="social-pinterest" value="<?php echo esc_attr(get_option('social-pinterest')); ?>" />
								</td>
						</tr>
						<tr valign="top">
								<th scope="row">Twitter</th>
								<td>
										<input type="text" class="regular-text" name="social-twitter" value="<?php echo esc_attr(get_option('social-twitter')); ?>" />
								</td>
						</tr>
						<tr valign="top">
								<th scope="row">YouTube</th>
								<td>
										<input type="text" class="regular-text" name="social-youtube" value="<?php echo esc_attr(get_option('social-youtube')); ?>" />
								</td>
						</tr>
				</table>
				<?php submit_button(); ?>
		</form>
</div>