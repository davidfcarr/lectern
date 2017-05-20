<?php
/**
 * The template for displaying the footer.
 *
 * Contains the closing of the #content div and all content after
 *
 * @package Lectern
 */

?>

	</div><!-- #content -->

	<footer id="colophon" class="site-footer" role="contentinfo">
		<div class="site-info">
			<a href="<?php echo esc_url( __( 'http://wordpress.org/', 'lectern' ) ); ?>"><?php printf( esc_html__( 'Proudly powered by %s', 'lectern' ), 'WordPress' ); ?></a>
			<span class="sep"> | </span>
			<?php printf( esc_html__( 'Theme: %1$s by %2$s.', 'lectern' ), 'Lectern', '<a href="http://www.carrcommunications.com" rel="designer">Carr Communications Inc.</a>' ); ?>
		</div><!-- .site-info -->
	</footer><!-- #colophon -->
</div><!-- #page -->

<?php wp_footer(); ?>
<div id="overlay"></div>
<script>
jQuery(document).ready(function($) {
	$('#menu-toggle-on').click(function() {
		$('.main-navigation').addClass('slide-in');
		$('html').css("overflow", "hidden");
		$('#overlay').show();
		return false;
	});
 
	// Navigation Slide Out
	$('#overlay,  #menu-toggle-off').click(function() {
		$('.main-navigation').removeClass('slide-in');
		$('html').css("overflow", "auto");
		$('#overlay').hide();
		return false;
	});
});
</script>
</body>
</html>
