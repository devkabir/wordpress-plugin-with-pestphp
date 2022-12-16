<?php
/**
 *
 *
 * @package    wordpress-slideshow
 * @subpackage slides.php
 * @since      1.0.0
 */
?>
<?php if ( ! empty( $images ) ) : ?>
	<ol id="wordpress-slides-sort" class="wrap">
		<?php foreach ( $images as $key => $image ) : ?>
			<li class="hndle" id="item-<?php echo esc_html( $image ); ?>">
				<img src="<?php echo esc_url( wp_get_attachment_url( $image ) ); ?>"
					 alt="Slider image no. <?php echo esc_html( $image ); ?>"/>
				<span class="dashicons dashicons-trash delete-slide"
					  data-image="<?php echo esc_html( $image ); ?>"></span>
			</li>
		<?php endforeach; ?>

	</ol>
	<input type="hidden" id="slide-nonce-1" name="slide_nonce_1"
		   value="<?php echo esc_html( wp_create_nonce( 'slide-order-update' ) ); ?>"/>
	<input type="hidden" id="slide-nonce-2" name="slide_nonce_2"
		   value="<?php echo esc_html( wp_create_nonce( 'slide-delete' ) ); ?>"/>
<?php else : ?>
	<?php esc_html_e( 'No slide available', 'wordpress-slideshow' ); ?>
<?php endif; ?>
