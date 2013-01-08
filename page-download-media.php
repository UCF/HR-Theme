<?php
$filename 		= $_GET['file'];
$uploads_dir 	= wp_upload_dir();
$file 			= $uploads_dir['basedir'].'/'.$filename;

// Disallow direct load
if (!$filename) {
	die('No');
}

// Check for relative paths; this shouldn't work but
// we're checking just to be safe
if (strstr($filename, '../') !== false) {
	die('No');
}

// If the file exists in the uploads directory, update headers
// to prevent local file caching, then read the file
if (file_exists($file)) {
	
	// Grab the filetype, basename
	$filetype = filetype($file);
	$basename = basename($file);
	
    header('Content-Type: application/octet-stream');
	header('Content-Disposition: attachment; filename='.$basename);
    header('Expires: 0');
    header('Cache-Control: no-cache, must-revalidate');
    header('Pragma: public');
    header('Content-Length: ' . filesize($file));
    ob_clean();
    flush();
    readfile($file);
    exit;
}
else {
	die($file.' does not exist.');
}
?>
