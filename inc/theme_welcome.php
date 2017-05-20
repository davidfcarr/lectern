<?php
/**
 * Theme Welcome
 *
 * @description: Adds a welcome message pointer when the user activates the theme
 * @sources:
 * https://wordimpress.com/create-wordpress-theme-activation-popup-message/
 * http://www.wpexplorer.com/making-themes-plugins-more-usable/
 */
 
function lectern_enqueue_pointer_script_style( $hook_suffix ) {

$headers = array("toastmasters.jpg",
"toastmasters2.jpg",
"toastmasters3.jpg",
"toastmasters4.jpg",
"toastmasters5.jpg",
"toastmasters6.jpg");

$header = get_header_image();
foreach($headers as $h)
	if(strpos($header, $h))
		return; // no need for this if Toastmasters header already set
 
 // Assume pointer shouldn't be shown
 $enqueue_pointer_script_style = false;
 
 // Get array list of dismissed pointers for current user and convert it to array
 $dismissed_pointers = explode( ',', get_user_meta( get_current_user_id(), 'dismissed_wp_pointers', true ) );
 
 // Check if our pointer is not among dismissed ones
 if( !in_array( 'lectern_settings_pointer', $dismissed_pointers ) ) {
 $enqueue_pointer_script_style = true;
 
 // Add footer scripts using callback function
 add_action( 'admin_print_footer_scripts', 'lectern_pointer_print_scripts' );
 }
 
 // Enqueue pointer CSS and JS files, if needed
 if( $enqueue_pointer_script_style ) {
 wp_enqueue_style( 'wp-pointer' );
 wp_enqueue_script( 'wp-pointer' );
 }
 
}
add_action( 'admin_enqueue_scripts', 'lectern_enqueue_pointer_script_style' );
 
function lectern_pointer_print_scripts() {
 
 $pointer_content  = "<h3>Want to add Toastmasters branding?</h3>";
 $pointer_content .= "<p>See the Toastmasters Branding section of the theme Customizer to add a standard Toastmasters banner, with the required disclaimer about use of trademarks in the footer of your site.</p>";
 ?>
 
 <script type="text/javascript">
 //<![CDATA[
 jQuery(document).ready( function($) {
 $('#menu-appearance').pointer({
 content: '<?php echo $pointer_content; ?>',
 position: {
 edge: 'left', // arrow direction
 align: 'center' // vertical alignment
 },
 pointerWidth: 350,
 close: function() {
 $.post( ajaxurl, {
 pointer: 'lectern_settings_pointer', // pointer ID
 action: 'dismiss-wp-pointer'
 });
 }
 }).pointer('open');
 });
 //]]>
 </script>
 
<?php
}