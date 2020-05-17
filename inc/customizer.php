<?php
/**
 * Lectern Theme Customizer
 *
 * @package Lectern
 */

/**
 * Add postMessage support for site title and description for the Theme Customizer.
 *
 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
 */
function lectern_customize_register( $wp_customize ) {

class Lectern_Customize_Branding_Control extends WP_Customize_Control {
    public $type = 'banner_choice';

    public function render_content() {
        ?>
<p>A series of standard Toastmasters-branded banners for the top of the page are loaded into the <strong>Header Image</strong> panel below for use by clubs and districts.</p>
<p>When you add one of these banners (or any image with the word "toastmasters" in the file name), Lectern automatically adds the disclaimers required by Toastmasters International to the page footer.</p><p>In addition, the Toastmasters logo will also be set as the <strong>Site Icon</strong> displayed in browser tabs.</p>
    <?php
    if(strpos($_SERVER['SERVER_NAME'],'oastmost.org'))
        return;
    echo '<p>Click on one of the images shown below to download a copy of the banner to your own server. Otherwise, the images will be served from toastmost.org. The new header will be installed on your site, but the preview will not automatically refresh.</p>';
    $images = get_tm_images();
    foreach($images as $basename => $url)
        printf('<p><a class="tmbanner" basename="%s" ><img src="%s"></a></p>',$basename,$url,$basename);
    }
}

	$wp_customize->add_setting( 'branding_setting', array('sanitize_callback' => 'sanitize_branding') );

	$wp_customize->get_setting( 'blogname' )->transport         = 'postMessage';
	$wp_customize->get_setting( 'blogdescription' )->transport  = 'postMessage';
	$wp_customize->get_setting( 'header_textcolor' )->transport = 'postMessage';
	$wp_customize->get_setting( 'branding_setting' )->transport = 'refresh';

	$wp_customize->add_section( 'toastmasters_branding_settings', array(
        'title'          => 'Toastmasters Branding',
        'priority'       => 1,
    ) );

 
$wp_customize->add_control( new Lectern_Customize_Branding_Control( $wp_customize, 'branding_setting', array(
    'label'   => 'Toastmasters Banner',
    'section' => 'toastmasters_branding_settings',
    'settings'   => 'branding_setting',
) ) );

}

add_action( 'customize_register', 'lectern_customize_register' );

/**
 * Binds JS handlers to make Theme Customizer preview reload changes asynchronously.
 */
function lectern_customize_preview_js() {
	wp_enqueue_script( 'lectern_customizer', get_template_directory_uri() . '/js/customizer.js', array( 'customize-preview' ), '20130508', true );
}
add_action( 'customize_preview_init', 'lectern_customize_preview_js' );

function lectern_customize_control_js() {
	wp_enqueue_script( 'lectern_customizer_control', get_template_directory_uri() . '/js/customizer_control.js', array( 'customize-preview' ), time(), true );
}

add_action( 'customize_controls_enqueue_scripts', 'lectern_customize_control_js' );

function sanitize_branding ($setting) {
	if(!strpos($setting,'wp4toastmasters') ) // only accept urls from recognized source
		return '';
return $setting;	
}