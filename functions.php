<?php
require_once('functions/base.php');   			# Base theme functions
require_once('functions/feeds.php');			# Where functions related to feed data live
require_once('custom-taxonomies.php');  		# Where per theme taxonomies are defined
require_once('custom-post-types.php');  		# Where per theme post types are defined
require_once('functions/admin.php');  			# Admin/login functions
require_once('functions/config.php');			# Where per theme settings are registered
require_once('shortcodes.php');         		# Per theme shortcodes
require_once('third-party/truncate-html.php');  # Includes truncateHtml function

//Add theme-specific functions here.

/**
 * Generate page/post breadcrumbs based on a passed post id.
 * Outputs bootstrap-ready HTML.
 * @return string
 * @author Jo Greybill
 **/
function get_breadcrumbs($post_id) {
	// If this is the home page, don't return anything
	if (is_home() || is_front_page()) {
		return '';
	}

	$ancestors = get_post_ancestors($post_id);

	$output = '<ul class="breadcrumb">';
	$output .= '<li><a href="'.get_site_url().'">Home</a> <span class="divider">/</span></li>';
	if ($ancestors) {
		// Ancestor IDs return from being the most direct parent first,
		// to the most distant last.  krsort returns the IDs in the order
		// we need:
		krsort($ancestors);
		foreach ($ancestors as $id) {
			$output .= '<li><a href="'.get_permalink($id).'">'.get_the_title($id).'</a> <span class="divider">/</span></li>';
		}
	}
	$output .= '<li class="active"><a href="'.get_permalink($post_id).'">'.get_the_title($post_id).'</a></li>';
	$output .= '</ul>';

	return $output;
}


/**
 * Hide unused admin tools (Links, Comments, etc)
**/
function hide_admin_links() {
	remove_menu_page('link-manager.php');
	remove_menu_page('edit-comments.php');
}
add_action( 'admin_menu', 'hide_admin_links' );


/**
 * Eliminate redundancy with ResourceLinks pointing to pages/anchors
 * and actual pages in Relevanssi search results
**/
function separate_result_types($hits) {

    // For each hit (post), check to see if it is a resourcelink.
	// If it is not a resourcelink, push it to $filtered.
	// If it is a resourcelink, check if it is a link to a page or page anchor.
	// If it does not (it links to a file), push it to $filtered.
	$filtered_hits = array();
    if (!empty($hits)) {
        foreach ($hits[0] as $hit) {
            if ($hit->post_type == 'resourcelink') {
            	if (get_post_meta($hit->ID, 'resourcelink_url', true) == '' && get_post_meta($hit->ID, 'resourcelink_page', true) == '') {
					array_push($filtered_hits, $hit);
				}
			}
			else {
				array_push($filtered_hits, $hit);
			}
        }
    }
	$hits[0] = $filtered_hits;

    return $hits;
}
include_once( ABSPATH . 'wp-admin/includes/plugin.php' );
if (is_plugin_active('relevanssi/relevanssi.php') == true) {
	add_filter('relevanssi_hits_filter', 'separate_result_types');
}


/**
 * Retrieve protocol-relative assets via wp_get_attachment_url
 **/
function protocol_relative_attachment_url($url) {
    if (is_ssl()) {
        $url = str_replace('http://', 'https://', $url);
    }
    return $url;
}
add_filter('wp_get_attachment_url', 'protocol_relative_attachment_url');


/**
 * Force 'edit_attachment' to be fired whenever an attachment's metadata is
 * updated (for Enable Media Replace compatibility with Varnish plugins.)
 **/
function trigger_edit_attachment( $meta_id, $post_id, $meta_key, $meta_value ) {
    // Only $meta_id tends to be available at this point, so fill in the blanks:
    $meta = get_post_meta_by_id( $meta_id );
    $post_obj = get_post( intval( $meta->post_id ) );
    if ( $post_obj && $post_obj->post_type == 'attachment' ) {
        do_action( 'edit_attachment', intval( $post_obj->ID ) );
    }
}
add_action( 'updated_post_meta', 'trigger_edit_attachment', 10, 4 );

?>
