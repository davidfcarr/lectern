<?php
/**
 /* Template Name: Landing Page 
 *
 * The template for displaying full-width pages, no menu, larger fonts.
 *
 * @package Lectern
 */

get_header('landing'); ?>

	<div id="primary" class="full-width-content-area">
	<?php do_action('full_width_top'); ?>
		<main id="main" class="site-main" role="main">

			<?php while ( have_posts() ) : the_post(); ?>

				<?php get_template_part( 'template-parts/content', 'page' ); ?>

			<?php endwhile; // End of the loop. ?>

		</main><!-- #main -->
	<?php do_action('full_width_bottom'); ?>
	</div><!-- #primary -->

<?php get_footer(); ?>
