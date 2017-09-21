<?php
/**
 * The Template for displaying all single posts
 *
 * Methods for TimberHelper can be found in the /lib sub-directory
 *
 * @package  WordPress
 * @subpackage  Timber
 * @since    Timber 0.1
 */

$context = Timber::get_context();
$post = Timber::query_post();
$context['post'] = $post;

$templates = array('single-' . $post->ID . '.twig');

if ($post->post_parent) {
	array_push($templates, 'single-' . $post->post_type . '-subpage.twig');
}

array_push($templates, 'single-' . $post->post_type . '.twig', 'single.twig');

if ( post_password_required( $post->ID ) ) {
	Timber::render( 'single-password.twig', $context );
} else {
	Timber::render( $templates , $context );
}
