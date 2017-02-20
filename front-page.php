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
$context['post'] = $post;
$context['posts'] = Timber::get_posts();
$templates = array( 'front-page.twig', 'index.twig' );

Timber::render( $templates, $context );
