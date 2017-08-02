<?php
/**
 *
 * Methods for TimberHelper can be found in the /lib sub-directory
 *
 * @package  WordPress
 * @subpackage  Timber
 * @since   Timber 0.1
 */

$context = Timber::get_context();
$post = new TimberPost();

// redirect to another page if we have the redirect_to custom field
$url = $post->redirect_to;
if ($url) {
	wp_redirect($url);
	exit();
}

$context['post'] = $post;
$context['posts'] = Timber::get_posts();
$templates = array( 'front-page.twig', 'index.twig' );

Timber::render( $templates, $context );
