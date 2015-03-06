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
					<p class="description">C&oacute;digo de seguimiento de Universal Analytics</p>
				</td>
			</tr>
			<tr valign="top">
				<th scope="row">Google Site Verification code</th>
				<td>
					<input type="text" class="regular-text" name="google-site-verification" value="<?php echo esc_attr(get_option('google-site-verification')); ?>" />
					<p class="description">C&oacute;digo de verificaci&oacute;n de Google Analytics</p>
					<p class="description"><code>&lt;meta name="google-site-verification" content="<b>{codigo-de-verificaci&oacute;n}</b>" /&gt;</code></p>
				</td>
			</tr>
			<tr valign="top">
				<th scope="row">Bing Site Verification code </th>
				<td>
					<input type="text" class="regular-text" name="bing-site-verification" value="<?php echo esc_attr(get_option('bing-site-verification')); ?>" />
					<p class="description">C&oacute;digo de verificaci&oacute;n de Bing</p>
				</td>
			</tr>
		</table>
		<?php submit_button(); ?>
	</form>
</div>
