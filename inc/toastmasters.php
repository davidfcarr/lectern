<?php

function set_tm_icon () {
	$wp_upload_dir = wp_upload_dir();
		$basename = "toastmasters-logo.png";
		$url = "http://toastmost.org/tmbranding/toastmasters-logo.png";
		$file_path = $wp_upload_dir["path"].'/'.$basename;
		$newurl = $wp_upload_dir['url'] . '/' . $basename;
		$myhttp = new WP_Http();
		$result = $myhttp->get($url, array('filename' => $file_path, 'stream' => true));
		print_r($result);
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

add_action('wp_footer','toastfooter');
function toastfooter() {
/* If this site has been configured with Toastmasters branding, display the required disclaimer */
$site_icon = get_site_icon_url();
$header = get_header_image();
if(!strpos($header,'toastmasters') )
	return;
if(!strpos($site_icon,'toastmasters'))
	set_tm_icon ();
?>
<div id="toastmasters-disclaimer">
<h3>Learn more about <a href="http://www.toastmasters.org">Toastmasters International</a> at <a href="http://www.toastmasters.org">www.toastmasters.org</a></h3>
<p>The information on this website is for the sole use of Toastmasters' members, for Toastmasters business only. It is not to be used for solicitation and distribution of non-Toastmasters material or information. All rights reserved. Toastmasters International, the Toastmasters International logo and all other Toastmasters International trademarks and copyrights are the sole property of Toastmasters International and may be used only by permission.</p>
</div>
<?php
}

function get_tm_images() {
	return array("toastmasters.jpg" => "http://toastmost.org/tmbranding/toastmasters.jpg",
	"toastmasters2.jpg" => "http://toastmost.org/tmbranding/toastmasters2.jpg",
	"toastmasters3.jpg" => "http://toastmost.org/tmbranding/toastmasters3.jpg",
	"toastmasters4.jpg" => "http://toastmost.org/tmbranding/toastmasters4.jpg",
	"toastmasters5.jpg" => "http://toastmost.org/tmbranding/toastmasters5.jpg",
	"toastmasters6.jpg" => "http://toastmost.org/tmbranding/toastmasters6.jpg",
	"toastmasters7.png" => "http://toastmost.org/tmbranding/toastmasters7.png",
	"toastmasters8.png" => "http://toastmost.org/tmbranding/toastmasters8.png",
	"toastmasters9.png" => "http://toastmost.org/tmbranding/toastmasters9.png",
	"toastmasters10.png" => "http://toastmost.org/tmbranding/toastmasters10.png",
	"toastmasters11.png" => "http://toastmost.org/tmbranding/toastmasters11.png",
	"toastmasters12.png" => "http://toastmost.org/tmbranding/toastmasters12.png",
	"toastmasters13.png" => "http://toastmost.org/tmbranding/toastmasters13.png",
	"toastmasters14.png" => "http://toastmost.org/tmbranding/toastmasters14.png",
	"toastmasters15.png" => "http://toastmost.org/tmbranding/toastmasters15.png",
	);
	}
	
function grab_tm_images ($basename) {
	
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
	$url = $tm_images[$basename];	
	if(!empty($url)) {
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
			$args = get_theme_support( 'custom-header' );
			if ( $args[0]['wp-head-callback'] )
				add_action( 'wp_head', $args[0]['wp-head-callback'] );
		
			//if ( is_admin() ) {
				require_once( ABSPATH . 'wp-admin/includes/class-custom-image-header.php' );
				$myheader = new Custom_Image_Header( $args[0]['admin-head-callback'], $args[0]['admin-preview-callback'] );
			//}
			
			if($myheader)
			$myheader->set_header_image($choice);	
	}
	return (empty($newurl)) ? 'error' : $newurl;
}

class Lectern_Toastmasters_Branding extends WP_REST_Controller {
	public function register_routes() {
	  $namespace = 'lectern/v1';
	  $path = 'getbranding/(?P<basename>[a-z0-9\.]+)';
  
	  register_rest_route( $namespace, '/' . $path, [
		array(
		  'methods'             => 'GET',
		  'callback'            => array( $this, 'get_items' ),
		  'permission_callback' => array( $this, 'get_items_permissions_check' )
			  ),
		  ]);     
	  }
  
	public function get_items_permissions_check($request) {
	  return true;
	}
  
  public function get_items($request) {
	  $downloaded = grab_tm_images($request["basename"]);
	  return new WP_REST_Response($downloaded, 200);
	}
}

add_action('rest_api_init', function () {
	$lectern_branding = new Lectern_Toastmasters_Branding();
	$lectern_branding->register_routes();
} );  
?>