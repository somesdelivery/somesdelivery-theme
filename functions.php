<?php

if ( ! class_exists( 'Timber' ) ) {
	add_action( 'admin_notices', function() {
		echo '<div class="error"><p>Timber not activated. Make sure you activate the plugin in <a href="' . esc_url( admin_url( 'plugins.php#timber' ) ) . '">' . esc_url( admin_url( 'plugins.php') ) . '</a></p></div>';
	});
	
	add_filter('template_include', function($template) {
		return get_stylesheet_directory() . '/static/no-timber.html';
	});
	
	return;
}

Timber::$dirname = array('templates', 'views');

class StarterSite extends TimberSite {

	function __construct() {
		add_theme_support( 'post-formats' );
		add_theme_support( 'post-thumbnails' );
		add_theme_support( 'menus' );
		add_filter( 'timber_context', array( $this, 'add_to_context' ) );
		add_filter( 'get_twig', array( $this, 'add_to_twig' ) );
		add_action( 'init', array( $this, 'register_post_types' ) );
		add_action( 'init', array( $this, 'register_taxonomies' ) );
		parent::__construct();
	}

	function register_post_types() {
		register_post_type('proiecte', array(
			'labels' => array(
				'name' => __('Proiecte'),
				'singular_name' => __('Proiect')
			),
			'public' => true,
			'has_archive' => true,
			'hierarchical' => true,
			'supports' => array( 'title', 'editor', 'thumbnail', 'excerpt', 'custom-fields', 'page-attributes')
		));

		// flush_rewrite_rules();
	}

	function register_taxonomies() {
		 // $labels = [
	  //       'name'              => _x('Ediții', 'taxonomy general name'),
	  //       'singular_name'     => _x('Ediție', 'taxonomy singular name'),
	  //       'search_items'      => __('Caută ediții'),
	  //       'all_items'         => __('Toate edițiile'),
	  //       'parent_item'       => __('Ediție părinte'),
	  //       'parent_item_colon' => __('Ediție părinte:'),
	  //       'edit_item'         => __('Editează ediție'),
	  //       'update_item'       => __('Actualizează ediție'),
	  //       'add_new_item'      => __('Adaugă ediție nouă'),
	  //       'new_item_name'     => __('Nume nou ediție'),
	  //       'menu_name'         => __('Ediție'),
	  //   ];
	  //   $args = [
	  //       'hierarchical'      => false,
	  //       'labels'            => $labels,
	  //       'show_ui'           => true,
	  //       'show_admin_column' => true,
	  //       'query_var'         => true,
	  //       'rewrite'           => ['slug' => 'editie'],
	  //   ];
   //  	register_taxonomy('editie', ['proiecte'], $args);
	}

	function add_to_context( $context ) {
		$context['foo'] = 'bar';
		$context['stuff'] = 'I am a value set in your functions.php file';
		$context['notes'] = 'These values are available everytime you call Timber::get_context();';
		$context['menu'] = new TimberMenu();
		$context['site'] = $this;
		return $context;
	}

	function myfoo( $text ) {
		$text .= ' bar!';
		return $text;
	}

	function add_to_twig( $twig ) {
		/* this is where you can add your own functions to twig */
		$twig->addExtension( new Twig_Extension_StringLoader() );
		$twig->addFilter('myfoo', new Twig_SimpleFilter('myfoo', array($this, 'myfoo')));
		return $twig;
	}

}

new StarterSite();
