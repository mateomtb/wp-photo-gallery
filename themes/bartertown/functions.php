<?php

	add_theme_support('post-formats', array('aside', 'gallery', 'image', 'video', 'audio', 'link'));
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

if ( function_exists('register_sidebar') ) register_sidebar();

register_nav_menus(array('hot-topics' => __( 'Hot Topics' )), array('take-action' => __( 'Take Action' )));

add_filter('timber_context', 'global_context');
function global_context($data){
    // Rudimentary domain chunk. 
    // Works for domains in the style of "www.domain.com" -- as in, 
    // it takes the chunk after the first '.' in the string.
    $domain_bits = explode('.', $_SERVER['HTTP_HOST']);
	$data = array(
        // WP conditionals
        'is_home' => is_home(),
        'is_front_page' => is_front_page(),
        'is_admin' => is_admin(),
        'is_single' => is_single(),
        'is_sticky' => is_sticky(),
        'get_post_type' => get_post_type(),
        'is_singular' => is_singular(),
        'is_post_type_archive' => is_post_type_archive(),
        'comments_open' => comments_open(),
        'is_page' => is_page(),
        'is_page_template' => is_page_template(),
        'is_category' => is_category(),
        'is_tag' => is_tag(),
        'has_tag' => has_tag(),
        'is_tax' => is_tax(),
        'has_term' => has_term(),
        'is_author' => is_author(),
        'is_date' => is_date(),
        'is_year' => is_year(),
        'is_month' => is_month(),
        'is_day' => is_day(),
        'is_time' => is_time(),
        'is_archive' => is_archive(),
        'is_search' => is_search(),
        'is_404' => is_404(),
        'is_paged' => is_paged(),
        'is_attachment' => is_attachment(),
        'is_singular' => is_singular(),
        'template_uri' => get_template_directory_uri(),

        // Environment vars
        'domain' => $domain_bits[1],
	    'mode' => 'section',
	    'section' => '',

        // Content vars
        'single_cat_title' => single_cat_title(),
        'sidebar' => Timber::get_sidebar('sidebar.php'),
        'menu_main' => new TimberMenu('Main'),
        'menu_hot' => new TimberMenu('Hot Topics'),
        'menu_action' => new TimberMenu('Take Action'),
    );
    
    // Data provided here:
    /*
    [site_name] => Silver City Sun News
    [url] => www.scsun-news.com/
    [wp_site_name] => scsun-news
    [domain] => scsun-news
    [company] => MNG
    [platform] => NGPS
    [geo] => NEW MEXICO
    [city] => Silver City, NM
    [zip_code] => 88026
    [coords] => n/a
    [facebook_page] => http://www.facebook.com/SilverCitySunNews
    [facebook_page_id] => 187899791275353
    [facebook_app_id] => n/a
    [fb_secret] => n/a
    [yahoo_pub_id] => 21641094265
    [yahoo_site_name] => www.scsun-news.com
    [ad_server_on_mc] => dfp
    [omniture_account] => midslv
    [twitter_page] => https://twitter.com/SCSunNews
    [twitter_short_name] => SCSunNews
    [disqus_api_key] => n/a
    [disqus_user_api_key] => n/a
    [mycapture_url] => n/a
    [media_center_url] => http://photos.scsun-news.com/
    [smug_api_key] => n/a
    [smug_secret] => n/a
    [smug_token] => n/a
    [smug_url] => n/a
    [nav_json_file_url] => http://local.scsun-news.com/assets/header-footer.json
    [favicon_url] => http://extras.mnginteractive.com/live/media/favIcon/scsun-news/favicon.png
    [akamai_large] => http://local.scsun-news.com/assets/logo-large.png
    [akamai_small] => http://local.scsun-news.com/assets/logo-small.png
    [events_url] => http://events.scsun-news.com
    [events_api] => 890fda44c68da704e968b4b18ad71ca3
    [brightcove_api] => n/a
    [powerlinks] => yes
    [google_analytics] => UA-42534117-6
    [bc_player_id] => N/A
    [bc_player_key] => N/A
    [addthis] => N/A
    [tout_id] => N/A
    [ngps_site_id] => 558
    [google_] => N/A
    [quant_id] => p-4ctCQwtnNBNs2
    [quant_label] => ElPasoRegional
    */
    if ( class_exists('DFMDataForWP') )
        $data['dfm'] = DFMDataForWP::retrieveRowFromMasterData('domain', $data['domain']);

    if ( is_singular() ) $data['mode'] = 'article';
    //if ( is_single() ):
    //endif;

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
                        'sidebar_title' => array('label'=>'Sidebar Title'),
                        'sidebar_markup' => array('label'=>'Sidebar Content',
                                        'type'=>'textarea'),
                ),
        ),
);


if ( !class_exists( "Easy_CF_Field_Textarea" ) ) {
    class Easy_CF_Field_Textarea extends Easy_CF_Field {
        public function print_form() {
            $class = ( empty( $this->_field_data['class'] ) ) ? $this->_field_data['id'] . '_class' :  $this->_field_data['class'];
            $input_class = ( empty( $this->_field_data['input_class'] ) ) ? $this->_field_data['id'] . '_input_class' :  $this->_field_data['input_class'];

            $id = ( empty( $this->_field_data['id'] ) ) ? $this->_field_data['id'] :  $this->_field_data['id'];
            $label = ( empty( $this->_field_data['label'] ) ) ? $this->_field_data['id'] :  $this->_field_data['label'];
            $value = $this->get();
            $hint = ( empty( $this->_field_data['hint'] ) ) ? '' :  '<p><em>' . $this->_field_data['hint'] . '</em></p>';

            $label_format =
                '<div class="%s">'.
                '<p><label for="%s"><strong>%s</strong></label></p>'.
                '<p><textarea class="%s" style="width: 100%%;" type="text" name="%s">%s</textarea></p>'.
                '%s'.
                '</div>';
            printf( $label_format, $class, $id, $label, $input_class, $id, $value, $hint );
        }
    }
}
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

function createWPQueryArray($array) {
    return array(
        'category' => ($array[1] ? get_category_by_slug($array[1])->term_id : null),
        'posts_per_page' => ($array[2] ? $array[2] : null),
        'meta_key' => ($array[3] ? $array[3] : null),
        'meta_value' => ($array[4] ? $array[4] : null)
    );
}
