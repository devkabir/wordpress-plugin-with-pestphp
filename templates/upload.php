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
			<a class="gallery-add button" href="#" data-uploader-title="Add image(s) to gallery"
			   data-uploader-button-text="Add image(s)">Add image(s)</a>

			<ol id="wordpress-slides-selection-sort" class="wrap">
				<?php foreach ( $images as $key => $id ) : ?>
					<li class="hndle" id="item-<?php echo esc_html( $id ); ?>">
						<input type="hidden" name="wordpress_slideshow_slides[<?php echo esc_html( $id ); ?>]" value="<?php echo esc_html( $id ); ?>">
						<img src="<?php echo esc_url( wp_get_attachment_url( $id ) ); ?>"
							 alt="Slider image no. <?php echo esc_html( $id ); ?>"/>
						<span class="dashicons dashicons-trash delete-selected-slide"
							  data-image="<?php echo esc_html( $id ); ?>"></span>
					</li>
				<?php endforeach; ?>

			</ol>

		</td>
	</tr>
</table>
