<?php 
	/* Template Name: Interviu */ 
		
	$context = Timber::get_context();
	$post = new TimberPost();
	$context['post'] = $post;
	Timber::render( array('template-interviu.twig' ), $context );

?>