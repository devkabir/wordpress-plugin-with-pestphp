<?php
/**
 * It will provide a nice interface for setting page.
 *
 * @package    wordpress-slideshow
 * @subpackage page.php
 * @since      1.0.0
 */
?>
<h1><?php esc_html_e( 'WordPress Slideshow', 'wordpress-slideshow' ); ?></h1>
<div id="dashboard-widgets" class="metabox-holder<?php echo esc_attr( $columns_css ); ?>">
	<div id="postbox-container-1" class="postbox-container">
		<?php do_meta_boxes( $screen->id, 'normal', '' ); ?>
	</div>
	<div id="postbox-container-2" class="postbox-container">
		<?php do_meta_boxes( $screen->id, 'side', '' ); ?>
	</div>

</div>
