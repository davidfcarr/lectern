<?php
/**
 * The header for our theme.
 *
 * Displays all of the <head> section and everything up till <div id="content">
 *
 * @package Lectern
 */

?><!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="profile" href="http://gmpg.org/xfn/11">
<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">

<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
<div id="page" class="hfeed site">
	<a class="skip-link screen-reader-text" href="#content"><?php esc_html_e( 'Skip to content', 'lectern' ); ?></a>

	<header id="masthead" class="site-header" role="banner">
<div id="toastmastersheader" class="site-branding">
<a id="logolink" href="<?php echo home_url( '/' ); ?>" title="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>" rel="home"></a>
<a href="<?php echo home_url( '/' ); ?>" title="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>" rel="home" class="site-title"><h1  class="site-title"><?php bloginfo( 'name' ); ?></h1></a>
<h2 class="site-description"><?php bloginfo( 'description' ); ?></h2>
</div><!-- .site-branding -->

		<button class="menu-toggle" id="menu-toggle-on"><?php esc_html_e( 'Menu', 'lectern' ); ?></button>
		<nav id="site-navigation" class="main-navigation" role="navigation">
			<?php wp_nav_menu( array( 'theme_location' => 'primary', 'menu_id' => 'primary-menu', 'fallback_cb' => 'wp_page_menu' ) ); ?>
			<button class="menu-toggle" id="menu-toggle-off"><?php esc_html_e( 'Close Menu', 'lectern' ); ?></button>
		</nav><!-- #site-navigation -->
	</header><!-- #masthead -->

	<div id="content" class="site-content">
