<?php disallow_direct_load('single-document.php');?>
<?php 
the_post();

$link_url 		= get_post_meta($post->ID, 'resourcelink_url', TRUE);
$existing_page  = get_post_meta($post->ID, 'resourcelink_page', TRUE);
$attachment_id  = get_post_meta($post->ID, 'resourcelink_file', TRUE);

if ($attachment_id) {
	$attachment_url = wp_get_attachment_url($attachment_id);
	$url = $attachment_url;
}

// Fallback link redirects
// (see ResourceLinks::get_url() in custom-post-types.php)
elseif ($link_url) {
	// If it's a page anchor, set up the URL accordingly
	if (substr($link_url, 0) == '#') {
		$url = $existing_page.$link_url;
	}
	else {
		$url = $link_url;
	}
}
elseif ($link_url == '' && $existing_page !== '') {
	$url = get_permalink($existing_page);
}
// Absolute fallback to home page
else {
	$url = get_site_url();
}


header('Location: '.$url);
?>