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

    //polls!
    if ( function_exists('get_poll') ):
        ob_start();
        get_poll();
        $poll = ob_get_contents();
        ob_end_clean();
        $poll_title = $poll_answers = $poll_options = $poll_vote = '';
        $pollDOM = new DOMDocument;
        $pollDOM -> loadHTML($poll);
        $pollTitle = $pollDOM -> getElementsByTagName('strong');
        $pollAns = $pollDOM -> getElementsByTagName('li');
        $pollVote = $pollDOM -> getElementsByTagName('button');
        if (count($pollTitle) > 0):
            foreach($pollTitle as $pollTitle1):
                $poll_title .= $pollTitle1->nodeValue;
            endforeach;
        endif;
        if(count($pollAns) > 0) {
            foreach($pollAns as $pollAns1) {
                $poll_answers .= $pollAns1->nodeValue;
                $poll_options .= '<input type="radio" name="optionsRadios" id="optionsRadios1" value="'.$poll_answers.'">'.$poll_answers.'</input><br />';
                $poll_answers = '';
            }
        }
        foreach($pollVote as $pollVotes){
            $polleVptes1 .= $pollVotes->nodeValue;
            $poll_vote .= 'vote button'.$pollVotes1;
        }
    endif;
    $domain_bits = explode('.', $_SERVER['HTTP_HOST']);
    $data = array(
        // WP conditionals
        'is_home' => is_home(),
        'is_front_page' => is_front_page(),
        'is_admin' => is_admin(),
        'is_single' => is_single(),
        'is_sticky' => is_sticky(),
        'get_post_type' => get_post_type(),
        'is_single' => is_single(),
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
        // Ads might be buggy so control with query var for now
        'all_ads' => $_REQUEST['ads'] !== null ? true : false,

        // Environment vars
        'domain' => $domain_bits[1],
        'poll' => $poll,
        'poll_title' => $poll_title,
        'poll_options' => $poll_options,
        'poll_vote' => $poll_vote,
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
    if ( class_exists('DFMDataForWP') ) {
        // Add to session var and Timber context
        // Probably move later session var assignment later
        $data['dfm'] = $_SESSION['dfm'] = DFMDataForWP::retrieveRowFromMasterData('domain', $data['domain']);
    }


    if ( is_singular() ) $data['mode'] = 'article';

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

function createWPQueryArray($array) {
    return array(
        'category' => ($array[1] ? get_category_by_slug($array[1])->term_id : null),
        'posts_per_page' => ($array[2] ? $array[2] : null),
        'meta_key' => ($array[3] ? $array[3] : null),
        'meta_value' => ($array[4] ? $array[4] : null)
    );
}

function getMediaCenterFeed() {
    if ($s = $_SESSION['dfm']) {
        $url = $s['media_center_url'];
        $cat = get_category(get_query_var('cat'))->slug;
        if (!$cat) {
            $cat = 'mc_rotator_home___';
        }
        return $url . "rotator?size=responsive&cat=$cat";
    }
}

//declare vars
$isMetric = false;
$apiUrl = 'http://apidev.accuweather.com'; 
$apiKey = '230548dfe5d54776aaaf5a1f2a19b3f5';
$wLanguage = 'en';  
$locationKey = '';

function getCurrentConditions($apiUrl, $locationKey, $wLanguage, $apiKey){
    $currentConditionsUrl = $apiUrl . '/currentconditions/v1/' . $locationKey . '.json?language=' . $wLanguage . '&apikey=' . $apiKey;
    return $currentConditionsUrl;
}

function getForecasts($apiUrl, $locationKey, $wLanguage, $apiKey) {
    $forecastUrl = $apiUrl . '/forecasts/v1/daily/10day/' . $locationKey . '.json?language=' . $wLanguage . '&apikey=' . $apiKey;
    return $forecastUrl;
}

function getWeather($apiUrl, $z, $apiKey){
    $locationUrl = $apiUrl . '/locations/v1/US/search?q=' . $z . '&apiKey=' . $apiKey;
    $locationUrl = file_get_contents($locationUrl);
    $locationUrl = json_decode($locationUrl, true);
    $locationKey = $locationUrl[0]['Key'];
    if($locationKey != null){
        return $locationKey;
    }
}

function getMarket($domain){
    $mUrl = 'http://markets.financialcontent.com/'.$domain.'/widget:tickerbar1?Output=JS';
    $fp = fopen($mUrl, 'w');
    $fwrite = ($fp);
    fclose($fp);

}


/*DFM TAXONOMY FIELD MANAGER TESTING */
add_action( 'init', function() {

  $fm = new Fieldmanager_Group( array(
        'name' => 'localcategories',
        'children' => array(
                'localcats' => new Fieldmanager_Select( 'Local Categories', array(
                    'limit' => 0,
                    'one_label_per_item' => False,
                    'add_more_label' => 'Add another category',
                    'datasource' => new Fieldmanager_Datasource_Term( array(
                    'taxonomy' => 'localcategories'
                ) ),
            ) ),
        ),
    ) );
    $fm->add_meta_box( 'Categories', array( 'post' ) );
    } );

/**
 * Add custom taxonomies
 *
 * Additional custom taxonomies can be defined here
 * http://codex.wordpress.org/Function_Reference/register_taxonomy
 */
function add_custom_taxonomies() {
    // Add new "Locations" taxonomy to Posts
    register_taxonomy('localcategories', 'post', array(
        // Hierarchical taxonomy (like categories)
        'hierarchical' => true,
        // This array of options controls the labels displayed in the WordPress Admin UI
        'labels' => array(
            'name' => _x( 'Local Categories', 'taxonomy general name' ),
            'singular_name' => _x( 'Category', 'taxonomy singular name' ),
            'search_items' =>  __( 'Search Categories' ),
            'all_items' => __( 'All Categories' ),
            'parent_item' => __( 'Parent Category' ),
            'parent_item_colon' => __( 'Parent Category:' ),
            'edit_item' => __( 'Edit Category' ),
            'update_item' => __( 'Update Category' ),
            'add_new_item' => __( 'Add New Category' ),
            'new_item_name' => __( 'New Category Name' ),
            'menu_name' => __( 'Local Categories' ),
        ),
        // Control the slugs used for this taxonomy
        'rewrite' => array(
            'slug' => 'localcategories', // This controls the base slug that will display before each term
            'with_front' => false, // Don't display the category base before "/locations/"
            'hierarchical' => true // This will allow URL's like "/locations/boston/cambridge/"
        ),
    ));
}
add_action( 'init', 'add_custom_taxonomies', 0 );





/*DFM TAXONOMY FIELD MANAGER TESTING */


