<?php

function get_tm_images() {
return array("toastmasters.jpg" => "http://wp4toastmasters.com/tmbranding/toastmasters.jpg",
"toastmasters2.jpg" => "http://wp4toastmasters.com/tmbranding/toastmasters2.jpg",
"toastmasters3.jpg" => "http://wp4toastmasters.com/tmbranding/toastmasters3.jpg",
"toastmasters4.jpg" => "http://wp4toastmasters.com/tmbranding/toastmasters4.jpg",
"toastmasters5.jpg" => "http://wp4toastmasters.com/tmbranding/toastmasters5.jpg",
"toastmasters6.jpg" => "http://wp4toastmasters.com/tmbranding/toastmasters6.jpg");
}

function grab_tm_images () {

$tm_images = get_tm_images();

// Get the path to the upload directory.
$wp_upload_dir = wp_upload_dir();

/**
 * Perform a HTTP HEAD or GET request.
 *
 * If $file_path is a writable filename, this will do a GET request and write
 * the file to that path.
 *
 * @since 2.5.0
 *
 * @param string      $url       URL to fetch.
 * @param string|bool $file_path Optional. File path to write request to. Default false.
 * @param int         $red       Optional. The number of Redirects followed, Upon 5 being hit,
 *                               returns false. Default 1.
 * @return bool|string False on failure and string of headers if HEAD request.
 */

if(!isset($_POST["banner"]))
	return;
$basename = $_POST["banner"];
$url = $tm_images[$basename];

if(!empty($url))
	{
	$file_path = $wp_upload_dir["path"].'/'.$basename;
	$newurl = $wp_upload_dir['url'] . '/' . $basename;
	$myhttp = new WP_Http();
	$result = $myhttp->get($url, array('filename' => $file_path, 'stream' => true));
	if(is_wp_error($result))
		{
			printf('<div class="error">%s: %s</div>',__('Error retrieving','lectern'),$url);
			return;
		}
	
	// Make sure that this file is included, as wp_generate_attachment_metadata() depends on it.
	require_once( ABSPATH . 'wp-admin/includes/image.php' );
	
	$parent_post_id = 0;
	
	// Check the type of file. We'll use this as the 'post_mime_type'.
	$filetype = wp_check_filetype( basename( $file_path ), null );
	
	// Prepare an array of post data for the attachment.
	$attachment = array(
		'guid'           => $newurl, 
		'post_mime_type' => $filetype['type'],
		'post_title'     => preg_replace( '/\.[^.]+$/', '', $basename ),
		'post_content'   => '',
		'post_status'    => 'inherit'
	);
	
	// Insert the attachment.
	$attach_id = wp_insert_attachment( $attachment, $file_path, $parent_post_id );
	
	// Generate the metadata for the attachment, and update the database record.
	$attach_data = wp_generate_attachment_metadata( $attach_id, $file_path );
	wp_update_attachment_metadata( $attach_id, $attach_data );
	$choice["url"] = $newurl;
	$choice["attachment_id"] = $attach_id;
	$choice["width"] = $attach_data["width"];
	$choice["height"] = $attach_data["height"];
	Custom_Image_Header::set_header_image($choice);
	
$version = get_bloginfo('version');
if ($version < 4.3)
		return;
			
$site_icon = get_site_icon_url();
if(!strpos($site_icon,'toastmasters'))
	{
	$basename = "toastmasters-logo.png";
	$url = "http://wp4toastmasters.com/tmbranding/toastmasters-logo.png";
	$file_path = $wp_upload_dir["path"].'/'.$basename;
	$newurl = $wp_upload_dir['url'] . '/' . $basename;
	$myhttp = new WP_Http();
	$result = $myhttp->get($url, array('filename' => $file_path, 'stream' => true));
	if(is_wp_error($result))
		{
			printf('<div class="error">%s: %s</div>',__('Error retrieving','lectern'),$url);
			return;
		}
	$parent_post_id = 0;
	
	// Check the type of file. We'll use this as the 'post_mime_type'.
	$filetype = wp_check_filetype( basename( $file_path ), null );
	
	// Prepare an array of post data for the attachment.
	$attachment = array(
		'guid'           => $newurl, 
		'post_mime_type' => $filetype['type'],
		'post_title'     => preg_replace( '/\.[^.]+$/', '', $basename ),
		'post_content'   => '',
		'post_status'    => 'inherit'
	);
	
	// Insert the attachment.
	$attach_id = wp_insert_attachment( $attachment, $file_path, $parent_post_id );
	update_option('site_icon',$attach_id);
	
	// Generate the metadata for the attachment, and update the database record.
	$attach_data = wp_generate_attachment_metadata( $attach_id, $file_path );
	$iconlog .= 'attach_data:'.var_export($attach_data,true)."\n";
	wp_update_attachment_metadata( $attach_id, $attach_data );
	$choice["url"] = $newurl;
	$choice["attachment_id"] = $attach_id;
	$choice["width"] = $attach_data["width"];
	$choice["height"] = $attach_data["height"];

	require_once ABSPATH . '/wp-admin/includes/class-wp-site-icon.php';
	global $wp_site_icon;

	// Skip creating a new attachment if the attachment is a Site Icon.
	if ( get_post_meta( $attachment_id, '_wp_attachment_context', true ) == $context ) {

		// Delete the temporary cropped file, we don't need it.
		wp_delete_file( $cropped );

		// Additional sizes in wp_prepare_attachment_for_js().
		add_filter( 'image_size_names_choose', array( $wp_site_icon, 'additional_sizes' ) );
	}
	else
	{
	/** This filter is documented in wp-admin/custom-header.php */
	$cropped = apply_filters( 'wp_create_file_in_uploads', $cropped, $attachment_id ); // For replication.
	$object  = $wp_site_icon->create_attachment_object( $cropped, $attachment_id );
	unset( $object['ID'] );

	// Update the attachment.
	add_filter( 'intermediate_image_sizes_advanced', array( $wp_site_icon, 'additional_sizes' ) );
	$attachment_id = $wp_site_icon->insert_attachment( $object, $cropped );
	remove_filter( 'intermediate_image_sizes_advanced', array( $wp_site_icon, 'additional_sizes' ) );

	// Additional sizes in wp_prepare_attachment_for_js().
	add_filter( 'image_size_names_choose', array( $wp_site_icon, 'additional_sizes' ) );
	}
	
	}
	}

}

add_action('wp_footer','toastfooter');
function toastfooter() {
/* If this site has been configured with Toastmasters branding, display the required disclaimer */
$site_icon = get_site_icon_url();
$header = get_header_image();
if(!strpos($site_icon,'toastmasters') && !strpos($header,'toastmasters'))
	return;
?>
<div id="toastmasters-disclaimer">
<h3>We are part of <a href="http://www.toastmasters.org">Toastmasters International</a></h3>
<p>The information on this website is for the sole use of Toastmasters' members, for Toastmasters business only. It is not to be used for solicitation and distribution of non-Toastmasters material or information. All rights reserved. Toastmasters International, the Toastmasters International logo and all other Toastmasters International trademarks and copyrights are the sole property of Toastmasters International and may be used only by permission.</p>
</div>
<?php
}
?>