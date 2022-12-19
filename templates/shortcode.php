<?php
/**
 * It will provide a nice interface for shortcode.
 *
 * @package    WP_Slideshow
 * @subpackage templates\shortcode
 * @since      1.0.0
 */
?>
<div class="swiffy-slider slider-item-show2-sm slider-item-ratio slider-item-ratio-21x9 slider-item-nogap slider-item-nosnap slider-item-nosnap-touch slider-nav-touch slider-nav-autohide slider-item-first-visible slider-nav-autoplay slider-indicators-highlight slider-indicators-sm slider-nav-animation slider-nav-animation-appear slider-nav-mousedrag">
	<ul class="slider-container">
		<?php foreach ( $images as $image ) : ?>
			<li><img src="<?php echo esc_url( wp_get_attachment_image_url( $image, '300px' ) ); ?>" width="300"/></li>
		<?php endforeach; ?>
	</ul>

	<button type="button" class="slider-nav"></button>
	<button type="button" class="slider-nav slider-nav-next"></button>

	<div class="slider-indicators">
		<button class="active"></button>
		<button></button>
		<button></button>
	</div>
</div>
