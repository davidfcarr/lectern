<?php
/**
 * The sidebar containing the main widget area.
 *
 * @package Lectern
 */

if ( ! is_active_sidebar( 'sidebar-1' ) ) {
	return;
}
?>

<div id="secondary" class="widget-area" role="complementary">
<?php do_action('before_sidebar'); ?>
	<?php dynamic_sidebar( 'sidebar-1' ); ?>
<?php do_action('after_sidebar'); ?>
</div><!-- #secondary -->
