<?php /* Template Name: Interviu */ ?>

<?php

$context = Timber::get_context();
$post = new TimberPost();
$context['post'] = $post;
Timber::render( array('template-interviu.twig' ), $context );

?>