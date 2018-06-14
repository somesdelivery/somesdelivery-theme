<?php 
	/* 
		Template Name: Redirect to URL 
		Template Post Type: post, page, editie, proiect
	*/

	$url = get_post_meta($post->ID, 'redirect_to', true);
	if ($url) {
		wp_redirect($url);
		exit();
	}
?>