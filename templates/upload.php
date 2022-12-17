<?php
/**
 * upload.php
 *
 * @package    wordpress-slideshow
 * @subpackage upload.php
 * @since      1.0.0
 */
?>
<table class="form-table">
	<tr>
		<td>
			<form method="post" action="options.php">
				<?php settings_errors(); ?>
				<?php settings_fields( 'wordpress_slideshow_settings' ); ?>
				<a class="slide-upload button" href="#"><?php esc_html_e( 'Add image(s)', 'wordpress-slideshow' ); ?></a>
				<ol id="selected-slides" class="wrap"></ol>
				<?php submit_button(); ?>
			</form>

		</td>
	</tr>
</table>
