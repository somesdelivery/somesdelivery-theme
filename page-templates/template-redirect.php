<?php 
	/* 
		Template Name: Redirect to URL 
		Template Post Type: post, page, editie, proiect
	*/ 

	$post = Timber::query_post();
	$url = $post->redirect_to;
	if ($url) {
		wp_redirect($url);
		exit();
	}
?>