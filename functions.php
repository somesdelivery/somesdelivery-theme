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

class SomesDeliverySite extends TimberSite {

	const POSTS_PER_ARCHIVE_PAGE = 12;

	function __construct() {

		// Theme configuration
		add_theme_support('post-formats');
		add_theme_support('post-thumbnails');
		add_theme_support('menus');
		add_theme_support('html5', array('search-form', 'comment-form', 'comment-list', 'gallery', 'caption'));
		
		add_filter( 'timber_context', array( $this, 'add_to_context' ) );
		add_filter( 'get_twig', array( $this, 'add_to_twig' ) );

		/* 
			Remove WordPress' auto-paragraph filter that messes up
			the shortcodes, and add it back _after_ the shortcodes
			have had the chance to run. This means we need to call
			`wpautop` manually in all our shortcodes.

			Not sure about the side-effects this can introduce,
			but fingers crossed.

			Reference: https://wp-mix.com/wordpress-disable-extra-p-tags-shortcodes/
		*/
		remove_filter( 'the_content', 'wpautop' );
		remove_filter( 'the_excerpt', 'wpautop' );
		add_filter('the_content', 'wpautop', 11);
		add_filter('the_excerpt', 'wpautop', 11);

		
		add_action( 'pre_get_posts', array( $this, 'configure_get_posts' ) );

		// Support for uploading SVGs into Wordpress
		add_filter( 'upload_mimes', array( $this, 'custom_mime_types' ) );

		add_action('init', array( $this, 'register_post_types' ));
		add_action('init', array( $this, 'register_taxonomies' ));
		add_action('init', array( $this, 'register_shortcodes' ));
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

	function register_shortcodes() {
		add_shortcode('rand', array($this, 'shortcode_rand'));
		add_shortcode('coloana', array($this, 'shortcode_coloana'));
		add_shortcode('buton', array($this, 'shortcode_buton'));
	}

	function configure_get_posts($query) {

		// Don't alter queries in the admin interface
		// and don't alter any query that's not the main one
		if (is_admin() || !$query->is_main_query()) {
			return;
		} 

		// For custom post type based archives
		if ($query->is_post_type_archive() || $query->is_tax()) {

			// Configure number of posts per page
			$query->set('posts_per_archive_page', self::POSTS_PER_ARCHIVE_PAGE);
			
			// Only show top-level posts
			if ($query->query_vars['post_parent'] == false) {
				$query->set('post_parent', 0);
			}
		}
	}

	function custom_mime_types( $types ) {
	    $types['svg'] = 'image/svg+xml';
	    $types['svgz'] = 'image/svg+xml';
	    return $types;
	}

	function add_to_context( $context ) {
		$context['menu'] = new TimberMenu();
		$context['site'] = $this;
		$context['default_thumbnail'] = get_stylesheet_directory_uri() . '/static/img/default-thumbnail.png';
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

	/* 
		Shortcodes
		---------------------------------------
	*/

	function shortcode_rand($atts, $content = '') {
		$context = array();
		$context['content'] = do_shortcode(wpautop(trim($content)));
		$context['atts'] = $atts;
		return Timber::compile('shortcodes/rand.twig', $context);
	}

	function shortcode_coloana($atts, $content = '') {
		$context = array();
		$context['content'] = do_shortcode(wpautop(trim($content)));
		$context['atts'] = $atts;
		return Timber::compile('shortcodes/coloana.twig', $context);
	}

	function shortcode_buton($atts, $content = '') {
		$context = array();
		$context['atts'] = $atts;
		return Timber::compile('shortcodes/buton.twig', $context);
	}
}

new SomesDeliverySite();
