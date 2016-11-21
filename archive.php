<?php
/**
 * The template for displaying Archive pages.
 *
 * Used to display archive-type pages if nothing more specific matches a query.
 * For example, puts together date-based pages if no date.php file exists.
 *
 * Learn more: http://codex.wordpress.org/Template_Hierarchy
 *
 * Methods for TimberHelper can be found in the /lib sub-directory
 *
 * @package  WordPress
 * @subpackage  Timber
 * @since   Timber 0.2
 */

$templates = array( 'archive.twig', 'index.twig' );

$context = Timber::get_context();

$context['title'] = 'Arhiva';
if ( is_day() ) {
	$context['title'] = 'Arhiva: '.get_the_date( 'D M Y' );
} else if ( is_month() ) {
	$context['title'] = 'Arhiva: '.get_the_date( 'M Y' );
} else if ( is_year() ) {
	$context['title'] = 'Arhiva: '.get_the_date( 'Y' );
} else if ( is_tag() ) {
	$context['title'] = single_tag_title( '', false );
} else if ( is_category() ) {
	$context['title'] = single_cat_title( '', false );
	array_unshift( $templates, 'archive-' . get_query_var( 'cat' ) . '.twig' );
} else if ( is_post_type_archive() ) {
	
	$context['title'] = 'Arhiva ' . post_type_archive_title( '', false );
	array_unshift( $templates, 'archive-' . get_post_type() . '.twig' );
} else if ( is_tax() ) {
	$queried_obj = get_queried_object();
	$context['title'] = 'Arhiva ' . single_term_title( '', false );
	array_unshift( $templates, 'archive-' . $queried_obj->taxonomy . '.twig');
}

$context['posts'] = Timber::get_posts();

if (is_post_type_archive()) {
	$queried_obj = get_queried_object();
	if ($queried_obj->name === 'editie' || $queried_obj->name === 'proiect') {
		$context['posts'] = array_filter($context['posts'], function($post) {
			return !$post->parent;
		});
	}
}

$context['pagination'] = Timber::get_pagination();

Timber::render( $templates, $context );
