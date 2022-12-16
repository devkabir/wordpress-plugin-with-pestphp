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
<div id="dashboard-widgets" class="metabox-holder<?php echo $columns_css; ?>">
	<div id="postbox-container-1" class="postbox-container">
		<?php do_meta_boxes( $screen->id, 'normal', '' ); ?>
	</div>
	<div id="postbox-container-2" class="postbox-container">
		<?php do_meta_boxes( $screen->id, 'side', '' ); ?>
	</div>
	<div id="postbox-container-3" class="postbox-container">
		<?php do_meta_boxes( $screen->id, 'column3', '' ); ?>
	</div>
	<div id="postbox-container-4" class="postbox-container">
		<?php do_meta_boxes( $screen->id, 'column4', '' ); ?>
	</div>
</div>
