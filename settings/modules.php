<div class="wrap">
	<h2>JP Theme Tools - <?php _e('Modules', 'jptt') ?></h2>
	<?php if (isset($_GET['settings-updated'])) { ?>
		<div id="message" class="updated">
			<p><strong><?php _e('Settings saved.') ?></strong></p>
		</div>
	<?php } ?>
	<form method="post" action="options.php">
			<?php
			settings_fields('jptt-modules-group');
			do_settings_sections('jptt-modules-group');
			$option = (array) get_option('jptt_modules');
			?>

		<table class="form-table">

			<tr valign="top">
				<th scope="row">USER_FAVORITE_POST</th>
				<td>
					<input type="checkbox" value="1" id="user_favorite_post" name="jptt_modules[user_favorite_post]" <?php checked($option['user_favorite_post']) ?>>
					<p class="description">Permite al usuario marcar un post como favorito.</p>
				</td>
			</tr>

			<tr valign="top">
				<th scope="row">USER_VOTE_POST</th>
				<td>
					<input type="checkbox" value="1" id="user_vote_post" name="jptt_modules[user_vote_post]" <?php checked($option['user_vote_post']) ?>>
					<p class="description">Permite al usuario votar por un post.</p>
				</td>
			</tr>

			<tr valign="top">
				<th scope="row">USER_SUBSCRIBE</th>
				<td>
					<input type="checkbox" value="1" id="user_vote_post" name="jptt_modules[user_subscribe]" <?php checked($option['user_subscribe']) ?>>
					<p class="description">Permite al usuario añadirse a una lista de suscripción.</p>
				</td>
			</tr>

		</table>
		<?php submit_button() ?>
	</form>
</div>
