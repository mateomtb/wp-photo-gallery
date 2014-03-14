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
        'section' => get_category(get_query_var('cat'))->slug,

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

/* Query functions */

// Can move these to a class if more additions are required
function excludeFilter($posts, &$excludeArray){
    if ($posts) {
        foreach ($posts as $post) {
            $excludeArray[] = $post->ID;
        }
    }
    return $posts;
}

function createWPQueryArray($array, $excludeArray = array()) {
    /* $array is structured like this
    array(
        string heading, 
        string category-slug, 
        int number-of-posts, 
        string custom-field, 
        string custom-field-value, 
        string tag
    );  
    */
    return array(
        'category' => ($array[1] ? get_category_by_slug($array[1])->term_id : 0),
        'posts_per_page' => ($array[2] ? $array[2] : null),
        'meta_key' => ($array[3] ? $array[3] : null),
        'meta_value' => ($array[4] ? $array[4] : null),
        'tag' => ($array[5] ? $array[5] : null),
        'post__not_in' => $excludeArray
    );
}

function unboltQuery($method, $query, &$excludeArray){
    // Basically this function returns posts while adding to an array
    // of IDs of posts that should be excluded from future get_post(s)() returns
    // without any global declarations
    // Had no luck filtering Timber's get_post(s)() methods
    // Still need to verify if this is performant
    if (is_array($query)) {
        // The query passed should be a specific array
        // based on the json config files
        $query = createWPQueryArray($query, $excludeArray);
    }
    return excludeFilter(
        call_user_func(array(Timber, $method), $query), 
        $excludeArray
    );
}

/* End Query functions */

function getMediaCenterFeed($section) {
    if ($s = $_SESSION['dfm']) {
        $url = $s['media_center_url'];
        $cat = $section;
        if (!$cat) {
            $cat = 'mc_rotator_home___';
        }
        return $url . "rotator?size=responsive&cat=$cat";
    }
}

function getContentConfigFeed($domain, $section){
    $dir = get_template_directory() . '/home_section_json/';
    $section = $section ? $section : 'home';

    if ($file = file_get_contents($dir . $domain . '/' . $section . '.json')) {
        return json_decode($file, true);
    }
    else {
        return json_decode($dir . 'default.json', true);
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
    if(!$mktUrl){
        $mUrl = 'http://markets.financialcontent.com/'.$domain.'/widget:tickerbar1?Output=JS';
        return $mktUrl;
    }
}

function getTraffic($zip_code) {
    if(!isset($coordsUrl)){
        $url = 'http://maps.googleapis.com/maps/api/geocode/json?address=' . $zip_code . '&sensor=false';
        $url = file_get_contents($url);
        $coordsUrl = json_decode($url, true);
        if($coordsUrl !== null){
            return $coordsUrl;
        }         
    }
    /*$latUrl = wp_remote_get( $url );
    if(isset($latUrl['body'])) {
        $lat = $latUrl['body'];
        return $lat;
    } */     
}

// Used for weather to determine to use day or night icons
function getTimeZone(){
    $timeZone = get_option('gmt_offset');
    $tzArr = array('New_York' => -4, 'Chicago' => -5, 'Denver' => -6, 'Los_Angeles' => -7);
    foreach ($tzArr as $key => $value){
        if($timeZone == $value){
            return $key;
        }
    }
    return 'Denver';
}


if (class_exists('Fieldmanager_Group')) {
    add_action('init', function() {
  		/*$fm = new Fieldmanager_Group( array(
			'name' => 'lead_story',
			'children' => array(
				'centerpiece' => new  Fieldmanager_Checkboxes('centerpiece'),
				),
		));
	$fm->add_meta_box('Centerpiece', array( 'post' ) );*/
	});

	add_action( 'init', function() {
	  /*$fm = new Fieldmanager_Group( array(
			'name' => 'contact_information',
			'children' => array(
				'name' => new Fieldmanager_Textfield( 'Name' ),
				'phone_number' => new Fieldmanager_Textfield( 'Phone Number' ),
				'website' => new Fieldmanager_Link( 'Website' ),
			),
		) );
		$fm->add_meta_box( 'Contact Information', array( 'post' ) );*/
	
		// Account for centerpiece on all section fronts by default (if there's no json config for it)?
		$fm = new Fieldmanager_Checkbox( 'Click here if you want this post to show as the centerpiece', array(
			'name' => 'lead_story',
			//'options' => 'Yes',
			'checked_value' => 'Yes'
		));
		$fm->add_meta_box('Centerpiece', array('post'));
	});
}
