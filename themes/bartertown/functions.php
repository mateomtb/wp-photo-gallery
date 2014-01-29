<?php

	add_theme_support('post-formats');
	add_theme_support('post-thumbnails');
	add_theme_support('menus');

	add_filter('get_twig', 'add_to_twig');
	add_filter('timber_context', 'add_to_context');

	add_action('wp_enqueue_scripts', 'load_scripts');

	define('THEME_URL', get_template_directory_uri());
	function add_to_context($data){
		/* this is where you can add your own data to Timber's context object */
		$data['qux'] = '';
		$data['menu'] = new TimberMenu();
		return $data;
	}

	function add_to_twig($twig){
		/* this is where you can add your own fuctions to twig */
		$twig->addExtension(new Twig_Extension_StringLoader());
		$twig->addFilter('myfoo', new Twig_Filter_Function('myfoo'));
		return $twig;
	}

	function myfoo($text){
    	$text .= ' bar!';
    	return $text;
	}

	function load_scripts(){
		wp_enqueue_script('jquery');
	}

register_nav_menus(array('hot-topics' => __( 'Hot Topics' )));

add_filter('timber_context', 'global_context');
function global_context($data){
    // Rudimentary domain chunk. 
    // Works for domains in the style of "www.domain.com" -- as in, 
    // it takes the chunk after the first '.' in the string.
    $domain_bits = explode('.', $_SERVER['HTTP_HOST']);
	$data['domain'] = $domain_bits[1];
	$data['mode'] = 'article';
	$data['section'] = '';
    $data['sidebar'] = Timber::get_sidebar('sidebar.php');


    // Now, in similar fashion, you add a Timber menu and send it along to the context.
    $data['menu'] = new TimberMenu(); // This is where you can also send a Wordpress menu slug or ID
    return $data;
}

/*
class boilerplate_widget extends WP_Widget
{
    public function __construct()
    {
            parent::__construct(
                'boilerplate_widget',
                __('boilerplate Widget', 'boilerplate_widget'),
                array('description' => __('DESC', 'boilerplate_widget'), )
            );
    }

    public function widget($args, $instance)
    {
        // DESC
        echo 'MARKUP';
        }
}
function register_boilerplate_widget() { register_widget('boilerplate_widget'); }
add_action('widgits_init', 'register_boilerplate_widget');
*/
