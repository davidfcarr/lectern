<?php
/**
 /* Template Name: Full Width 
 *
 * The template for displaying full-width pages.
 *
 * @package Lectern
 */

get_header(); ?>

	<div id="primary" class="full-width-content-area">
		<main id="main" class="site-main" role="main">

			<?php while ( have_posts() ) : the_post(); ?>

				<?php get_template_part( 'template-parts/content', 'page' ); ?>

			<?php endwhile; // End of the loop. ?>

		</main><!-- #main -->
	</div><!-- #primary -->

<?php get_footer(); ?>
