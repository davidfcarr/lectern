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

if(isset($_POST["banner"]))
	grab_tm_images ();

class Lectern_Customize_Branding_Control extends WP_Customize_Control {
    public $type = 'radio';

    public function render_content() {

        ?>
<style>
.imgchoice {
border: thin dotted red;
margin-bottom: 5px;
}
</style>
<p><?php _e('Use this control to add a Toastmasters-branded banner image to include in the site header. (To add any other image, use the Header Image customizer control).','lectern'); ?></p>
        <label id="tm_banner_choices">
        <span class="customize-control-title"><?php echo esc_html( $this->label ); ?></span>
<form action="<?php echo admin_url('customize.php'); ?>" method="post">
<?php
$tm_images = get_tm_images();
foreach($tm_images as $img => $url)
{
	printf('<div class="imgchoice"><input type="radio" name="banner" value="%s" > %s<br /><img src="%s" /></div>',$img,$img,$url);
}
?>
</label>
<button><?php _e('Get Banner','lectern'); ?></button>
</form>
<p><?php _e('If you are running WordPress 4.3 or higher, this control will also attempt to add the Toastmasters logo as the site icon. The site icon can also be modified with the Site Identity customizer control.','lectern'); ?></p>
        <?php
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

function sanitize_branding ($setting) {
	if(!strpos($setting,'wp4toastmasters') ) // only accept urls from recognized source
		return '';
return $setting;	
}