<?php 
	/* 
		Template Name: Ediție (Subpagină)
		Template Post Type: editie
	*/ 

	$context = Timber::get_context();
	$post = new TimberPost();
	$context['post'] = $post;
	Timber::render( array('template-editie-subpage.twig' ), $context );
?>