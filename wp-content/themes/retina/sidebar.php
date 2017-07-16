<?php
/**
 * The Sidebar containing the main widget areas.
 *
 * @package Retina
 */

if ( ! retina_has_sidebar() ) {
	return;
}
?>
<div id="site-sidebar" class="sidebar-area <?php retina_layout_class( 'sidebar' ); ?>">
	<div id="secondary" class="sidebar widget-area" role="complementary">
		<?php do_action( 'before_sidebar' ); ?>
		<?php dynamic_sidebar( 'sidebar-1' ); ?>
	</div><!-- .sidebar -->
</div><!-- .col-* columns of main sidebar -->
