<div class="wrap">
	<form method="post" action="options.php">

		<?php
		settings_errors();
		settings_fields( 'jptt-general-group' );
		do_settings_sections( 'jptt-general-group' );
		?>

		<div>
			<h2 class="nav-tab-wrapper">
				<a href="#" class="nav-tab nav-tab-active" data-target="#settings-develop">Development</a>
				<a href="#" class="nav-tab" data-target="#settings-security">Security</a>
			</h2>
		</div>

		<div class="data-tab" id="settings-develop">
			<table class="form-table">
				<tr valign="top">
					<th scope="row"><h2 class="no-margin-top">Theming</h2></th>
					<td>
						<label for="theming_helper">
								<?php $checked = ((bool) jptt_get_option( 'theming_helper' )) ? 'checked' : '' ?>
							<input type="hidden" name="jptt_options[theming_helper]" value="0">
							<input type="checkbox" value="1" id="theming_helper" name="jptt_options[theming_helper]" <?php echo $checked ?>>
							<b><?php _e( 'Show theming helper', 'jptt' ) ?></b>
						</label>
						<p class="description">Shows a box with info about current Bootstrap breakpoint, resolution and modernizr features.</p>
					</td>
				</tr>
			</table>
			<?php submit_button(); ?>
		</div>

		<div class="data-tab" id="settings-security">

			<table class="form-table">
				<tr valign="top">
					<th scope="row"><h2 class="no-margin-top">Header</h2></th>
					<td>
						<label for="remove_version">
							<input type="hidden" name="jptt_options[remove_version]" value="0">
							<input type="checkbox" value="1" id="remove_version" name="jptt_options[remove_version]" <?php checked( jptt_get_option( 'remove_version' ) ) ?>>
							<b><?php _e( 'Remove WordPress version number', 'jptt' ) ?></b>
						</label>
						<p class="description">Remove WordPress version number from header and feed.</p>
						<br>
						<label for="remove_rsd_link">
							<input type="hidden" name="jptt_options[remove_rsd_link]" value="0">
							<input type="checkbox" value="1" id="remove_rsd_link" name="jptt_options[remove_rsd_link]" <?php checked( jptt_get_option( 'remove_rsd_link' ) ) ?>>
							<b><?php _e( 'Remove EditURI link', 'jptt' ) ?></b>
						</label>
						<p class="description">Remove the EditURI/RSD link from your header. This option also removes the <b>Windows Live Writer</b> manifest link.</p>
					</td>
				</tr>
				<tr valign="top">
					<th scope="row"><h2 class="no-margin-top">XML-RPC</h2></th>
					<td>
						<label for="xmlrpc_pingback_disabled">
							<input type="hidden" name="jptt_options[xmlrpc_pingback_disabled]" value="0">
							<input type="checkbox" value="1" id="xmlrpc_pingback_disabled" name="jptt_options[xmlrpc_pingback_disabled]" <?php checked( jptt_get_option( 'xmlrpc_pingback_disabled' ) ) ?>>
							<b><?php _e( 'Disable XML-RPC Pingback', 'jptt' ) ?></b>
						</label>
						<p class="description">If you uses XML-RPC in your theme/plugins check this for disable only pingback method.</p>
						<br>
						<label for="xmlrpc_all_disabled">
							<input type="hidden" name="jptt_options[xmlrpc_all_disabled]" value="0">
							<input type="checkbox" value="1" id="xmlrpc_all_disabled" name="jptt_options[xmlrpc_all_disabled]" <?php checked( jptt_get_option( 'xmlrpc_all_disabled' ) ) ?>>
							<b><?php _e( 'Completely disable XML-RPC', 'jptt' ) ?></b>
						</label>
						<br>
						<p class="description">Disable XML-RPC completely. This setting implies the <b>Disable XML-RPC Pingback</b> and <b>Remove EditURI link</b>. <a href="https://www.littlebizzy.com/blog/disable-xml-rpc" target="_blank">More info</a></p>
					</td>
				</tr>
			</table>
			<?php submit_button(); ?>
		</div>
	</form>
</div>

<script>
  jQuery(function () {
      jQuery('.nav-tab-wrapper a').click(function (e) {
          e.preventDefault();
          jQuery('.data-tab').hide();
          jQuery('.nav-tab-wrapper a').removeClass('nav-tab-active');
          var tabContent = jQuery(this).data('target');
          jQuery(tabContent).stop().show();
          jQuery(this).addClass('nav-tab-active');
      });

      jQuery('a.nav-tab-active').trigger('click');
  });
</script>
