<?php
/**
 * Lectern functions and definitions
 *
 * @package Lectern
 */

if ( ! isset( $content_width ) ) {
        $content_width = 614; /* pixels */
}

function lectern_editor_setup() {
	add_editor_style();
}
add_action('admin_init','lectern_editor_setup');

add_filter('tiny_mce_before_init','lectern_full_width_editor_styles');
function lectern_full_width_editor_styles( $mceInit ) {
global $post;
if(empty($post) || empty($post->ID))
	return;
$t = get_page_template_slug($post->ID);
if($t == 'full-width-page.php')
    $mceInit['content_css'] = ','.get_stylesheet_directory_uri().'/editor-style-full-width.css';
elseif($t == 'landing-page.php')
    $mceInit['content_css'] .= ','.get_stylesheet_directory_uri().'/style-landing.css';

    return $mceInit;
}

function landing_page_stylesheet () {
	if(is_page_template('landing-page.php'))
		wp_enqueue_style( 'landing-page', get_stylesheet_directory_uri().'/style-landing.css');
}

add_action( 'wp_enqueue_scripts', 'landing_page_stylesheet',99 );

if ( ! function_exists( 'lectern_setup' ) ) :
/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which
 * runs before the init hook. The init hook is too late for some features, such
 * as indicating support for post thumbnails.
 */
function lectern_setup() {
	/*
	 * Make theme available for translation.
	 * Translations can be filed in the /languages/ directory.
	 * If you're building a theme based on Lectern, use a find and replace
	 * to change 'lectern' to the name of your theme in all the template files
	 */
	load_theme_textdomain( 'lectern', get_template_directory() . '/languages' );

	// Add default posts and comments RSS feed links to head.
	add_theme_support( 'automatic-feed-links' );

	/*
	 * Let WordPress manage the document title.
	 * By adding theme support, we declare that this theme does not use a
	 * hard-coded <title> tag in the document head, and expect WordPress to
	 * provide it for us.
	 */
	add_theme_support( 'title-tag' );

	/*
	 * Enable support for Post Thumbnails on posts and pages.
	 *
	 * @link http://codex.wordpress.org/Function_Reference/add_theme_support#Post_Thumbnails
	 */
	add_theme_support( 'post-thumbnails' );

	// This theme uses wp_nav_menu() in one location.
	register_nav_menus( array(
		'primary' => esc_html__( 'Primary Menu', 'lectern' ),
	) );

	/*
	 * Switch default core markup for search form, comment form, and comments
	 * to output valid HTML5.
	 */
	add_theme_support( 'html5', array(
		'search-form',
		'comment-form',
		'comment-list',
		'gallery',
		'caption',
	) );

	/*
	 * Enable support for Post Formats.
	 * See http://codex.wordpress.org/Post_Formats
	 */
	add_theme_support( 'post-formats', array(
		'aside',
		'image',
		'video',
		'quote',
		'link',
	) );

	// Set up the WordPress core custom background feature.
	add_theme_support( 'custom-background', apply_filters( 'lectern_custom_background_args', array(
		'default-color' => 'ffffff',
		'default-image' => '',
	) ) );

	register_default_headers( array(
		'toastmasters.jpg' => array(
			'url'           => 'http://toastmost.org/tmbranding/toastmasters.jpg',
			'thumbnail_url' => 'http://toastmost.org/tmbranding/toastmasters.jpg',
			'description'   => 'Toastmasters toastmasters.jpg'
		),
	'toastmasters2.jpg' => array(
			'url'           => 'http://toastmost.org/tmbranding/toastmasters2.jpg',
			'thumbnail_url' => 'http://toastmost.org/tmbranding/toastmasters2.jpg',
			'description'   => 'Toastmasters toastmasters2.jpg'
		),
	'toastmasters3.jpg' => array(
			'url'           => 'http://toastmost.org/tmbranding/toastmasters3.jpg',
			'thumbnail_url' => 'http://toastmost.org/tmbranding/toastmasters3.jpg',
			'description'   => 'Toastmasters toastmasters3.jpg'
		),
	'toastmasters4.jpg' => array(
			'url'           => 'http://toastmost.org/tmbranding/toastmasters4.jpg',
			'thumbnail_url' => 'http://toastmost.org/tmbranding/toastmasters4.jpg',
			'description'   => 'Toastmasters toastmasters4.jpg'
		),
	'toastmasters5.jpg' => array(
			'url'           => 'http://toastmost.org/tmbranding/toastmasters5.jpg',
			'thumbnail_url' => 'http://toastmost.org/tmbranding/toastmasters5.jpg',
			'description'   => 'Toastmasters toastmasters5.jpg'
		),
	'toastmasters6.jpg' => array(
			'url'           => 'http://toastmost.org/tmbranding/toastmasters6.jpg',
			'thumbnail_url' => 'http://toastmost.org/tmbranding/toastmasters6.jpg',
			'description'   => 'Toastmasters toastmasters6.jpg'
		),
	'toastmasters7.png' => array(
			'url'           => 'http://toastmost.org/tmbranding/toastmasters7.png',
			'thumbnail_url' => 'http://toastmost.org/tmbranding/toastmasters7.png',
			'description'   => 'Toastmasters toastmasters7.png'
		),
	'toastmasters8.png' => array(
			'url'           => 'http://toastmost.org/tmbranding/toastmasters8.png',
			'thumbnail_url' => 'http://toastmost.org/tmbranding/toastmasters8.png',
			'description'   => 'Toastmasters toastmasters8.png'
		),
	'toastmasters9.png' => array(
			'url'           => 'http://toastmost.org/tmbranding/toastmasters9.png',
			'thumbnail_url' => 'http://toastmost.org/tmbranding/toastmasters9.png',
			'description'   => 'Toastmasters toastmasters9.png'
		),
	'toastmasters10.png' => array(
			'url'           => 'http://toastmost.org/tmbranding/toastmasters10.png',
			'thumbnail_url' => 'http://toastmost.org/tmbranding/toastmasters10.png',
			'description'   => 'Toastmasters toastmasters10.png'
		),
	'toastmasters11.png' => array(
			'url'           => 'http://toastmost.org/tmbranding/toastmasters11.png',
			'thumbnail_url' => 'http://toastmost.org/tmbranding/toastmasters11.png',
			'description'   => 'Toastmasters toastmasters11.png'
		),
	'toastmasters12.png' => array(
			'url'           => 'http://toastmost.org/tmbranding/toastmasters12.png',
			'thumbnail_url' => 'http://toastmost.org/tmbranding/toastmasters12.png',
			'description'   => 'Toastmasters toastmasters12.png'
		),
	'toastmasters13.png' => array(
			'url'           => 'http://toastmost.org/tmbranding/toastmasters13.png',
			'thumbnail_url' => 'http://toastmost.org/tmbranding/toastmasters13.png',
			'description'   => 'Toastmasters toastmasters13.png'
		),
	'toastmasters14.png' => array(
			'url'           => 'http://toastmost.org/tmbranding/toastmasters14.png',
			'thumbnail_url' => 'http://toastmost.org/tmbranding/toastmasters14.png',
			'description'   => 'Toastmasters toastmasters14.png'
		),
	'toastmasters15.png' => array(
			'url'           => 'http://toastmost.org/tmbranding/toastmasters15.png',
			'thumbnail_url' => 'http://toastmost.org/tmbranding/toastmasters15.png',
			'description'   => 'Toastmasters toastmasters15.png'
		),
) );

}
endif; // lectern_setup
add_action( 'after_setup_theme', 'lectern_setup' );

/**
 * Register widget area.
 *
 * @link http://codex.wordpress.org/Function_Reference/register_sidebar
 */
function lectern_widgets_init() {
	register_sidebar( array(
		'name'          => esc_html__( 'Sidebar', 'lectern' ),
		'id'            => 'sidebar-1',
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h1 class="widget-title">',
		'after_title'   => '</h1>',
	) );
}
add_action( 'widgets_init', 'lectern_widgets_init' );

/**
 * Enqueue scripts and styles.
 */
function lectern_scripts() {
	wp_enqueue_style( 'lectern-style', get_stylesheet_uri() );

	wp_enqueue_script( 'lectern-navigation', get_template_directory_uri() . '/js/navigation.js', array(), '20120206', true );

	wp_enqueue_script( 'lectern-skip-link-focus-fix', get_template_directory_uri() . '/js/skip-link-focus-fix.js', array(), '20130115', true );

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
}
add_action( 'wp_enqueue_scripts', 'lectern_scripts' );

/**
 * Implement the Custom Header feature.
 */
require get_template_directory() . '/inc/custom-header.php';

/**
 * Welcome message
 */

require get_template_directory() . '/inc/theme_welcome.php';

/**
 * Custom template tags for this theme.
 */
require get_template_directory() . '/inc/template-tags.php';

/**
 * Custom functions that act independently of the theme templates.
 */
require get_template_directory() . '/inc/extras.php';

/**
 * Customizer additions.
 */
require get_template_directory() . '/inc/customizer.php';

/**
 * Load Jetpack compatibility file.
 */
require get_template_directory() . '/inc/jetpack.php';
/**
 * Allow admins to add Toastmasters branding
 */
require get_template_directory() . '/inc/toastmasters.php';
/**
 * For Gutenberg
 */
add_theme_support( 'align-wide' );

