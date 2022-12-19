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
				<?php settings_fields( 'wordpress_slideshow_settings' ); ?>
				<a class="slide-upload button" href="#"><?php esc_html_e( 'Add image(s)', 'wordpress-slideshow' ); ?></a>
				<ol id="selected-slides" class="wrap"></ol>
				<input id="submit" type="submit" value="<?php esc_html_e('Save Changes', 'wordpress-slideshow') ?>" style="display: none;" class="button button-primary" />
			</form>

		</td>
	</tr>
</table>
