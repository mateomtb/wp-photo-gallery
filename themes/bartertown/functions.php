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


class hot_topic_widget extends WP_Widget
{
    public function __construct()
    {
            parent::__construct(
                'hot_topic_widget',
                __('Hot Topic Widget', 'hot_topic_widget'),
                array('description' => __('For managing the Hot Topics bar.', 'hot_topic_widget'), )
            );
    }

    public function widget($args, $instance)
    {
        // It's a Tout widget, tweaked to be semi-responsive.
        echo '<div id="hot-topics-original" style="display:none;">
    <div class="container-fluid">
        <ul class="inline-list">
            <li>
                <h6>Hot Topics:</h6>
            </li>
' . $insert_the_items . '
                    </ul>
    </div> <!-- .container-fluid -->
</div>
<script type="text/javascript">
// Move the hot topics to the right place. 
// We can\'t put them in the right place in the first place because
// of region portlet limits in NGPS.
$("#dfmHeader".after("<div id=\"hot-topics\">" + $("#hot-topics-original").html() + "</div>");
</script>
';
        }
}
function register_hot_topics_widget() { register_widget('hot_topics_widget'); }
add_action('widgits_init', 'register_hot_topics_widget');

