<?php
/**
 * Implement an optional custom header for Lectern
 *
 * See https://codex.wordpress.org/Custom_Headers
 *
 * @package WordPress
 * @subpackage Extra_Toasty
 * @since Lectern 1.0
 */

/**
 * Set up the WordPress core custom header arguments and settings.
 *
 * @uses add_theme_support() to register support for 3.4 and up.
 * @uses lectern_header_style() to style front-end.
 * @uses lectern_admin_header_style() to style wp-admin form.
 * @uses lectern_admin_header_image() to add custom markup to wp-admin form.
 *
 * @since Lectern 1.0
 */
function lectern_custom_header_setup() {
	$args = array(
		// Text color and image (empty to use none).
		'default-text-color'     => '#FFF',
		'default-image'          => apply_filters('lectern_default_header',get_template_directory_uri() . '/images/lectern-banner.png'),

		// Set height and width, with a maximum value for the width.
		'height'                 => 194,
		'width'                  => 1094,
		'max-width'              => 1094,

		// Support flexible height and width.
		'flex-height'            => true,
		'flex-width'             => true,

		// Random image rotation off by default.
		'random-default'         => false,

		// Callbacks for styling the header and the admin preview.
		'wp-head-callback'       => 'lectern_header_style',
		'admin-head-callback'    => 'lectern_admin_header_style',
		'admin-preview-callback' => 'lectern_admin_header_image',
	);

	add_theme_support( 'custom-header', $args );
}
add_action( 'after_setup_theme', 'lectern_custom_header_setup' );

/**
 * Load our special font CSS file.
 *
 * @since Lectern 1.2
 */
function lectern_custom_header_fonts() {
	$font_url = lectern_get_font_url();
	if ( ! empty( $font_url ) )
		wp_enqueue_style( 'lectern-fonts', esc_url_raw( $font_url ), array(), null );
}
add_action( 'admin_print_styles-appearance_page_custom-header', 'lectern_custom_header_fonts' );

/**
 * Style the header text displayed on the blog.
 *
 * get_header_textcolor() options: 515151 is default, hide text (returns 'blank'), or any hex value.
 *
 * @since Lectern 1.0
 */
function lectern_header_style() {
	$text_color = get_header_textcolor();

	?>
	<style type="text/css" id="lectern-header-css">
	<?php

	printf('
	div#toastmastersheader {
	background-image:url(%s);
	background-repeat: no-repeat;
	}
',get_header_image());
	
	if(! display_header_text() ) :
	?>
			div#toastmastersheader a,
			div#toastmastersheader h1,
			div#toastmastersheader h2 {
			display: none;
			}
<?php	
	elseif($text_color) :
	?>
			div#toastmastersheader a,
			div#toastmastersheader h1,
			div#toastmastersheader h2 {
			color: #<?php echo $text_color; ?>;
		}

@media all and (max-width: 550px) {
	div#toastmastersheader a,
	div#toastmastersheader h1,
	div#toastmastersheader h2 {
	color: #<?php echo $text_color; ?>;
	}
}
<?php endif; ?>
	</style>
	<?php
}

/**
 * Style the header image displayed on the Appearance > Header admin panel.
 *
 * @since Lectern 1.0
 */
function lectern_admin_header_style() {
?>
	<style type="text/css" id="lectern-admin-header-css">
	.appearance_page_custom-header #headimg {
		border: none;
		font-family: "Open Sans", Helvetica, Arial, sans-serif;
	}
	#headimg h1,
	#headimg h2 {
		line-height: 1.84615;
		margin: 0;
		padding: 0;
	}
	#headimg h1 {
		font-size: 26px;
	}
	#headimg h1 a {
		color: #515151;
		text-decoration: none;
	}
	#headimg h1 a:hover {
		color: #21759b !important; /* Has to override custom inline style. */
	}
	#headimg h2 {
		color: #757575;
		font-size: 13px;
		margin-bottom: 24px;
	}
	#headimg img {
		max-width: <?php echo get_theme_support( 'custom-header', 'max-width' ); ?>px;
	}
	</style>
<?php
}

/**
 * Output markup to be displayed on the Appearance > Header admin panel.
 *
 * This callback overrides the default markup displayed there.
 *
 * @since Lectern 1.0
 */
function lectern_admin_header_image() {
	$style = 'color: #' . get_header_textcolor() . ';';
	?>
	<div id="headimg">

		<h1 class="displaying-header-text"><a id="name" style="<?php echo esc_attr( $style ); ?>" onclick="return false;" href="<?php echo esc_url( home_url( '/' ) ); ?>"><?php bloginfo( 'name' ); ?></a></h1>
		<h2 id="desc" class="displaying-header-text" style="<?php echo esc_attr( $style ); ?>"><?php bloginfo( 'description' ); ?></h2>
		<?php $header_image = get_header_image();
		if ( ! empty( $header_image ) ) : ?>
			<img src="<?php echo esc_url( $header_image ); ?>" class="header-image" width="<?php echo esc_attr( get_custom_header()->width ); ?>" height="<?php echo esc_attr( get_custom_header()->height ); ?>" alt="" />
		<?php endif; ?>
	</div>
<?php }
