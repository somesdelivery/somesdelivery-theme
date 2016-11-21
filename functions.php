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

	const POSTS_PER_ARCHIVE_PAGE = 12;

	function __construct() {
		add_theme_support( 'post-formats' );
		add_theme_support( 'post-thumbnails' );
		add_theme_support( 'menus' );
		add_filter( 'timber_context', array( $this, 'add_to_context' ) );
		add_filter( 'get_twig', array( $this, 'add_to_twig' ) );

		// Configure number of posts per page
		add_filter( 'pre_get_posts', array( $this, 'posts_per_page' ) );

		add_action( 'init', array( $this, 'register_post_types' ) );
		add_action( 'init', array( $this, 'register_taxonomies' ) );
		add_action('acf/init', array( $this, 'advanced_custom_fields_init'));
		parent::__construct();
	}

	function register_post_types() {
		$this->register_post_type_proiect();
		$this->register_post_type_editie();
	}

	function register_taxonomies() {
		$this->register_taxonomy_categorie_proiect();
	}

	function advanced_custom_fields_init() {
		// register Google API key to be able to use the Google Map custom field
		acf_update_setting('google_api_key', 'AIzaSyDhQhOG5CLH0Ccn7H4EdJCkwMyggfkOePo');
	}

	function posts_per_page() {
		// For custom post type based archives, configure the number of posts per page
		if (is_post_type_archive()) {
			set_query_var('posts_per_archive_page', self::POSTS_PER_ARCHIVE_PAGE);
		}
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

	/*
		Custom post types
		--------------------------------------------------------
	*/

	/* 
		Post type: Proiect
	*/
	function register_post_type_proiect() {
		register_post_type('proiect', array(
			'labels' => array(
				'name' => 'Proiecte',
				'singular_name' => 'Proiect'
			),
			'description' => 'Pentru proiecte din concurs, proiecte proprii sau ale partenerilor.',
			'rewrite' => array(
				'slug' => 'proiecte'
			),
			'supports' => array(
				'title', 
				'editor', 
				'thumbnail', 
				'excerpt', 
				'custom-fields', 
				'page-attributes'
			),
			'taxonomies' => array(
				'categorie_proiect'
			),
			'public' => true,
			'has_archive' => true,
			'hierarchical' => true,
			'menu_icon' => 'dashicons-format-gallery'
		));
	}

	/* 
		Post type: Ediție
	*/
	function register_post_type_editie() {
		register_post_type('editie', array(
			'labels' => array(
				'name' => 'Ediții',
				'singular_name' => 'Ediție'
			),
			'description' => 'Pentru edițiile anuale Someș Delivery.',
			'rewrite' => array(
				'slug' => 'editii'
			),
			'supports' => array(
				'title', 
				'editor', 
				'thumbnail', 
				'excerpt', 
				'custom-fields', 
				'page-attributes'
			),
			'public' => true,
			'has_archive' => true,
			'hierarchical' => true,
			'menu_icon' => 'dashicons-carrot'
		));
	}

	/* 
		Custom taxonomies
		--------------------------------------
	*/

	/*
		Taxonomy: Categorie proiect
	*/
	function register_taxonomy_categorie_proiect() {
		register_taxonomy('categorie_proiect', 'proiect', array(
			'labels' => array(
				'name' => 'Categorii proiect',
				'singular_name' => 'Categorie proiect'
			),
			'hierarchical' => false,
			'public' => true,
			'rewrite' => array(
				'slug' => 'categorii'
			)
		));
	}
}

new StarterSite();
