<?php

	add_theme_support('post-formats');
	add_theme_support('post-thumbnails');
	add_theme_support('menus');

	add_filter('get_twig', 'add_to_twig');

	add_action('wp_enqueue_scripts', 'load_scripts');

	define('THEME_URL', get_template_directory_uri());
	function add_to_twig($twig){
		/* this is where you can add your own fuctions to twig */
		$twig->addExtension(new Twig_Extension_StringLoader());
		$twig->addFilter('myfoo', new Twig_Filter_Function('myfoo'));
		return $twig;
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
	$data['mode'] = 'section';
    if ( is_singular() ) $data['mode'] = 'article';
    //if ( is_single() ):
    //endif;

	$data['section'] = '';
    $data['sidebar'] = Timber::get_sidebar('sidebar.php');
    $data['menu_hot'] = new TimberMenu('Hot Topics');
    $data['menu_main'] = new TimberMenu('Main');
    return $data;
}

/**
 *  remove_widows()
 *  filter the_title() to remove any chance of a typographic widow
 *  typographic widows
 *  @param string $title
 *  @return string $title;
 */
function remove_widows($title)
{
 
        $title_length = strlen($title);

        if ( strpos($title, 'a href=') > 0 )
        {
                // this is a link so
                // work out where the anchor text starts and ends
                $start_of_text = strpos($link, '">');
                $end_of_text = strpos($link, '</a>');
                $end_of_text = ($title_length -  $end_of_text);
                $anchor_text = substr($title, $start_of_text, $end_of_text);
        } 
        else
        {
                $start_of_text = 0;
                $end_of_text = $title_length;
                $anchor_text = $title;
        }

        // convert the title into an array of words
        $anchor_array = explode(' ', $anchor_text);

        // Provided there's multiple words in the anchor text
        // then join all words (except the last two) together by a space.
        // Join the last two with an &nbsp; which is where the
        // magic happens
        if ( sizeof($anchor_array) > 1 )
        {
                $last_word = array_pop($anchor_array);
                $title_new = join(' ', $anchor_array) . '&nbsp;' . $last_word;
                $title = substr_replace($title, $title_new, $start_of_text, $end_of_text);
        }
        return $title;
 
} 
add_filter('the_title', 'remove_widows');

// We do this for all the custom posts we need to make this site run.
if ( file_exists(WP_PLUGIN_DIR . '/easy-custom-fields/easy-custom-fields.php') ):

require_once( WP_PLUGIN_DIR . '/easy-custom-fields/easy-custom-fields.php' );
$field_data = array (
        'BylineOverride' => array (             // unique group id
                'fields' => array(             // array "fields" with field definitions
                        'Name'  => array(),      // globally unique field id
                        'Publication'  => array(),
                ),
        ),
        'Sidebar' => array (
                'fields' => array (
                        'Title' => array(),
                        'Markup' => array(),
                ),
        ),
);
$easy_cf = new Easy_CF($field_data);
endif;

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
