<?php
/**
 * @package WordPress
 * @subpackage DFM-Media-Center
 * @since DFM-Media-Center 0.1
 */

//include_once('ChromePhp.php');
if ( function_exists('getSiteValues')) getSiteValues($_SESSION['siteconfig']);
//you can get any value about a site like this echo ($_SESSION['siteconfig']);
//take a look at what you can get var_dump($_SESSION['siteconfig']);


$lib = get_template_directory() . '/lib';

// Get Theme Options Page
if ( is_admin() ):
    include_once($lib . '/functions/theme-options.php');
endif;

// Menu and Submenu Creation (if it doesn't exist)
$menu_name = 'Main';
if ( wp_get_nav_menu_object($menu_name) == FALSE ):
    $menu_id = wp_create_nav_menu($menu_name);

    // These top-level menu items are hard-coded because these top-levels apply to 95%
    // of the properties using them.
    $taxonomy = array(
        'News' => array('Conflict', 'Historic', 'Offbeat', 'Politics', 'Science and Technology', 'Severe Weather', 'State and Regional', 'U.S. National', 'Weird News'),
        'Sports' => array('College Sports', 'MLB', 'Motor Sports', 'NBA', 'NFL', 'NHL', 'Outdoors', 'PGA', 'Prep Sports', 'Soccer'),
        'Entertainment' => array('Art', 'Hollywood', 'Movies', 'Music', 'Style', 'Television', 'Travel', 'Visual Arts'),
        'Lifestyles' => array('Food and Wine', 'Home and Garden', 'Pets and Animals'),
        'Images Of The Day' => array()
    );
    $i = 0;
    foreach ( $taxonomy as $parent => $subs ):
        // Look up the category ID. Get the category. Get the cat url.
        // Associate it with the new menu item.
        $cat_id = get_cat_ID($parent);
        if ( $cat_id == 0 ) continue;
        $i ++;
        $cat_url = get_category_link($cat_id);

        $item_data = array(
            'menu-item-title' => $parent,
            'menu-item-object-id' => $cat_id,
            'menu-item-parent-id' => 0,
            'menu-item-position' => $i,
            'menu-item-object' => 'category',
            'menu-item-type' => 'taxonomy',
            'menu-item-status' => 'publish'
        );
        $parent_id = wp_update_nav_menu_item($menu_id, 0, $item_data);
        unset($item_data);

        // Submenu Creation
        if ( count($subs) > 0 ):
            $j = 0;
            foreach ( $subs as $item ):
                $cat_id = get_cat_ID($item);
                if ( $cat_id == 0 ) continue;
                $j ++;
                $item_data = array(
                'menu-item-title' => $item,
                'menu-item-object-id' => $cat_id,
                'menu-item-parent-id' => $parent_id,
                'menu-item-position' => $j,
                'menu-item-object' => 'category',
                'menu-item-type' => 'taxonomy',
                'menu-item-status' => 'publish'
                );
                $sub_id = wp_update_nav_menu_item($menu_id, 0, $item_data);
            endforeach;
        endif;

    endforeach;
endif;

// Theme Setup (based on twentythirteen: http://make.wordpress.org/core/tag/twentythirteen/)
function html5reset_setup() {
    load_theme_textdomain( 'html5reset', get_template_directory() . '/languages' );
    add_theme_support( 'automatic-feed-links' );
    add_theme_support( 'structured-post-formats', array( 'link', 'video' ) );
    add_theme_support( 'post-formats', array( 'aside', 'audio', 'chat', 'gallery', 'image', 'quote', 'status' ) );
    register_nav_menu( 'primary', __( 'Navigation Menu', 'html5reset' ) );
    add_theme_support( 'post-thumbnails' );
}
add_action( 'after_setup_theme', 'html5reset_setup' );

// Scripts & Styles (based on twentythirteen: http://make.wordpress.org/core/tag/twentythirteen/)
function html5reset_scripts_styles() {
    global $wp_styles;

    // Load Comments
    if ( is_singular() && comments_open() && get_option( 'thread_comments' ) )
        wp_enqueue_script( 'comment-reply' );

}
add_action( 'wp_enqueue_scripts', 'html5reset_scripts_styles' );

// WP Title (based on twentythirteen: http://make.wordpress.org/core/tag/twentythirteen/)
function html5reset_wp_title( $title, $sep ) {
    global $paged, $page;

    if ( is_feed() )
        return $title;

//   Add the site name.
    $title .= get_bloginfo( 'name' );

//   Add the site description for the home/front page.
    $site_description = get_bloginfo( 'description', 'display' );
    if ( $site_description && ( is_home() || is_front_page() ) )
        $title = "$title $sep $site_description";

//   Add a page number if necessary.
    if ( $paged >= 2 || $page >= 2 )
        $title = "$title $sep " . sprintf( __( 'Page %s', 'html5reset' ), max( $paged, $page ) );

    return $title;
}
//add_filter( 'wp_title', 'html5reset_wp_title', 10, 2 );




// Load jQuery
if ( !function_exists( 'core_mods' ) ) {
    function core_mods() {
        if ( !is_admin() ) {
            wp_deregister_script( 'jquery' );
            wp_register_script( 'jquery', ( "http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js" ), false);
            wp_enqueue_script( 'jquery' );
        }
    }
    add_action( 'wp_enqueue_scripts', 'core_mods' );
}



/* Media Center */

// QA currently includes all of the old MC plugins
// This class is already in sharedfunctions.php
if (!class_exists('phpSmug')) {
    include $lib . '/classes/smugmug/phpSmug.php';
}
include $lib . '/classes/custom/use-smugmug.php';
include $lib . '/classes/custom/utils.php';

// Home Page featured thumbnail size
add_image_size('featured-thumbnail', 833, 500, true);
add_image_size('related-thumbnail', 300, 300, true);
add_image_size('archive-thumbnail', 320, 240, true);


if( !class_exists( 'UseSmug' )){
    // Verify this class exists, site is useless without it.
    die('Unable to connect to site');
}

// Automatically grab a featured image
function getSmugFeat($postID) {
    if (!has_post_thumbnail()) {
        if ( !function_exists('curl_fetch_image') ):
        function curl_fetch_image($url) {
                $ch = curl_init($url);
                curl_setopt($ch, CURLOPT_HEADER, 0);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
                $image = curl_exec($ch);
                curl_close($ch);
                return $image;
        }
        endif;

        $posttags = get_the_tags();
        $mytag = getmy_tag($posttags);
        if ( strtolower($mytag) == "photo" || strtolower($mytag)  == "photos" ) {
            $postmeta = get_post_meta($postID, 'smugdata', true);
            $i = new UseSmug(get_post_meta($postID, 'smugdata', true));
            $smugimage = $i->smugImage("800x533");
            $smugThumb = $smugimage;
            if ( $smugThumb != NULL ) {
                $smugThumb = preg_replace('/\?.*$/', '', $smugThumb);
                $wp_filetype = wp_check_filetype($smugThumb, null);
                $attachment = array(
                    'post_mime_type' => $wp_filetype['type'],
                    'post_title' => $smugThumb,
                    'post_content' => '',
                    'post_status' => 'inherit'
                );
            }
            $postStill = file_get_contents($smugThumb);
        }
        if ($mytag  == 'video') {
            $url = get_post_meta($postID, brightcove, true);
            $cr = curl_init($url);
            curl_setopt($cr, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($cr, CURLOPT_FOLLOWLOCATION, 1);
            curl_exec($cr);
            $info = curl_getinfo($cr);
            $sites_html = file_get_contents($info["url"]);
            $patt = '/og\:image[\'\"]\s*content=[\'\"](http:\/\/.+)[\'\"]/';
            $matches = array();
            preg_match($patt, $sites_html, $matches);
            $videoThumb = $matches[1]; // get the og:image image
            if ($videoThumb) {
                $videoThumb = preg_replace('/\?.*$/', '', $videoThumb); // image url can include a query string that messes up  the file name
                $wp_filetype = wp_check_filetype($videoThumb, null);
                $attachment = array(
                    'post_mime_type' => $wp_filetype['type'],
                    'post_title' => $videoThumb,
                    'post_content' => '',
                    'post_status' => 'inherit'
            );
            }
            $postStill = curl_fetch_image($videoThumb);
        }
        $post_id = get_the_ID();
        $uploads = wp_upload_dir();
        $filename = wp_unique_filename( $uploads['path'], basename($smugThumb ), $unique_filename_callback = null );
        $fullpathfilename = $uploads['path'] . "/" . $filename;
        $fileSaved = file_put_contents($fullpathfilename, $postStill);
        if ( !$fileSaved ) {
            // NOTE: If the post doesn't have a tag, none of the logic cases above
            // that populate the $postStill var will have been met, and this error will happen.
            throw new Exception("file_put_contents() error in functions.php uploading to $fullpathfilename. The file cannot be saved.");
        }
        $attach_id = wp_insert_attachment( $attachment, $fullpathfilename, $post_id );
        // you must first include the image.php file
        // for the function wp_generate_attachment_metadata() to work
        require_once(ABSPATH . 'wp-admin/includes/image.php');
        $attach_data = wp_generate_attachment_metadata( $attach_id, $fullpathfilename);
        wp_update_attachment_metadata( $attach_id, $attach_data );
        // add featured image to post
        add_post_meta($post_id, '_thumbnail_id', $attach_id);
    }
}

//add_filter( 'the_content', 'onlyDisplayShortcode');
function onlyDisplayShortcode($content) {
    // Move to utils?
    // For now, remove everything that is before the <!--more--> comment
    // Use to address excerpt vs content issue
    if (is_single()) {
        $content = preg_replace('/^.+\<\!\-more\-\-\>/s', '', $content);
    }
    return $content;
}


// QA currently includes all of the old MC plugins
// This function is already in shared_functions.php
if (!function_exists('getmy_tag')) {
    function getmy_tag($posttags){
        // Moved from functions.php so it wasn't in both themes
        $count=0;
        if ($posttags) {
            foreach($posttags as $tag) {
                $count++;
                if (1 == $count) {
                    $this_tag = str_replace(' ', '_',$tag->name);
                    return $this_tag;
                }
            }
        }
        return NULL;
    }
}


/* End Media Center */

    function wp_infinitepaginate(){
        $loopFile        = $_POST['loop_file'];
        $paged           = $_POST['paged'];
        $posts_per_page  = get_option('posts_per_page');

        # Load the posts
        $archivequery= http_build_query($_POST);
        $context = Timber::get_context();
        $context['posts'] = Timber::get_posts($archivequery);
        Timber::render('archive-item.twig', $context);
        die();
    }
    add_action('wp_ajax_infinite_scroll','wp_infinitepaginate');           // for logged in user
    add_action('wp_ajax_nopriv_infinite_scroll','wp_infinitepaginate');    // if user not logged in





function getCategoryHierarchy($isHome = false){
    if ($isHome) {
        return array("Home");
   }
   if ($cat = get_the_category()) {
       $cats = explode('/', trim(get_category_parents($cat[0]->cat_ID), '/'));
       return $cats;
   }
   return array();
}


add_filter('timber_context', 'global_context');
function global_context($data){
    global $mobile_current_template;
    $taxonomy = getCategoryHierarchy(is_home());
    // Top Categories are defined in wp-admin via the theme-options.php file
    $topcategories = get_option('topcategories');
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
        'getBreakingArticles' => getBreakingArticles(),

'topcategory1' => get_category($topcategories[0]),
'topcategory2' => get_category($topcategories[1]),
'topcategory3' => get_category($topcategories[2]),
'topcategory4' => get_category($topcategories[3]),
'topcategory5' => get_category($topcategories[4]),
'topcategory6' => get_category($topcategories[5]),
'menu_main' => new TimberMenu('Main'),
'copyright_year' => date('Y'),
'charset' => get_bloginfo('charset'),
'wpurl' => get_bloginfo('wpurl'),
'pingback_url' => get_bloginfo('pingback_url'),
'description' => get_bloginfo('description'),
        'pagetitle' => "ADD TITLE HERE",
        'section' => $cat->slug,
        'sectionName' => $cat->name,
        'taxonomy1' => $taxonomy[0] ? $taxonomy[0] : '',
        'taxonomy2' => $taxonomy[1] ? $taxonomy[1] : '',
        'taxonomy3' => $taxonomy[2] ? $taxonomy[2] : '',
        'taxonomy4' => $taxonomy[3] ? $taxonomy[3] : '',
        'is_video' => preg_match('/\[insert[^BCvideo|Vid]/', $post->post_content),
        'omni_page_tag' => omniTag(),
        'omni_parent_cat' => omniCat(),
        'omni_page_title' => omniTitle(),
        'domain_short' => $_SESSION['siteconfig']['domain'],
        'domain_with_tld' => getDomain($_SESSION['siteconfig']['url']),
        'omni_url' => 'http://local.' . getDomain(TRUE) . '/assets/s_code.js',
        'is_mobile' => $mobile_current_template,
        'is_mobile_string' => ($mobile_current_template) ? "Mobile - " : '',

// we already have a way to do this in the old media center, not sure if we need to use options framework.
// It's been removed for now
/*'meta_headid' => of_get_option("meta_headid"),
'meta_author' => of_get_option("meta_author"),
'meta_google' => of_get_option("meta_google"),
'meta_viewport' => of_get_option("meta_viewport"),
'head_favicon' => of_get_option('head_favicon'),
'head_apple_touch_icon' => of_get_option('head_apple_touch_icon'),
'meta_app_win_name' => of_get_option('meta_app_win_name'),
'meta_app_win_color' =>of_get_option("meta_app_win_color"),
'meta_app_win_image' =>of_get_option("meta_app_win_image"),
'meta_app_twt_card' =>of_get_option('meta_app_twt_card'),
'meta_app_twt_site' =>of_get_option("meta_app_twt_site"),
'meta_app_twt_title' =>of_get_option("meta_app_twt_title"),
'meta_app_twt_description' =>of_get_option("meta_app_twt_description"),
'meta_app_twt_url' =>of_get_option("meta_app_twt_url"),
'meta_app_fb_title' =>of_get_option('meta_app_fb_title'),
'meta_app_fb_description' =>of_get_option("meta_app_fb_description"),
'meta_app_fb_url' =>of_get_option("meta_app_fb_url"),
'meta_app_fb_image' =>of_get_option("meta_app_fb_image"),*/

);

//putting the site variables in to timber context, dont' know if we really need to though
//as far as i can tell it's only being used for infinite scroll below ^^^
if ( function_exists('getSiteValues')) {
  //if (!$data['dfm'] = getSiteValues($_SESSION['siteconfig'])) {
    //$data['dfm'] = $_SESSION['siteconfig'];
    //var_dump($data['dfm']);
  //}
}


//infinite scroll related, i think? ^^^
$data['domain'] = $data['dfm']['domain'];
//$data['dfm'] = DFMDataForWP::retrieveRowFromMasterData('domain', $data['domain']);
    if ( is_singular() ) $data['mode'] = 'article';
    if ( is_archive() ) $data['archivequery'] = $wp_query->query . "&posts_per_page=5";
return $data;

}
//////////////////////////////////////////////
//this is where the global context ends FFS! because it was fucking me up!//

//var_dump($_SESSION['siteconfig']);

//this kicks off the process 
function getSiteNameFromWp() {
  // Get the site name as it was entered into the WordPress admin for the multinetwork setup
  $siteInfo = get_blog_details($GLOBALS['blog_id']);
  return str_replace('/', '', $siteInfo->path);
}


function getSiteValues($existingconfig) {
    $siteName = getSiteNameFromWp();
        if (!$siteName) {
            $siteName = 'mercurynews';
        }
    //var_dump($siteName);
    //check if site array config passed to the function is valid for the site we are currently on. If it's different swictch to the proper array confi 9-20-12 -mateo
    if ($existingconfig['wp_site_name'] === $siteName) {
        return false;
    }
    else {
        $config = DFMDataForWP::retrieveRowFromMasterData('wp_site_name', $siteName); // Row of all data for this site
        //var_dump($config);
        $company = strtolower($config['company']);
        $company = ($company === 'mng') ? 'mngi' : $company; // Currently the company is "MNG" in the site data file, but we need "mngi"
        $_SESSION['siteconfig'] = $config;//the master var that is an array of all the config values a site may need, including the above which we should update someday 9-19-12 - mateo
        //var_dump($config);
        return $config;
    }
}

if (class_exists('Fieldmanager_Field')){
    manage_top_categories();
}

function manage_top_categories() {
    if ( !current_user_can( 'manage_options' ) )  {
        wp_die( __( 'You do not have sufficient permissions to access this page.' ) );
    }
    $fm = new Fieldmanager_Autocomplete( array(
        'name' => 'topcategories',
        'limit' => 6,
        'starting_count' => 6,
        'required' => true,
        'one_label_per_item' => False,
        'datasource' => new Fieldmanager_Datasource_Term( array(
            'taxonomy' => 'category',
            ) ),
    ) );
    $fm->add_submenu_page( 'options-general.php', 'Manage Category Menu');
}


$check24filter = strstr($_SERVER['QUERY_STRING'], 'last24hours');
if ($check24filter == 'last24hours'){
function filter_where($where = '') {
$where .= " AND post_date > '" . date('Y-m-d H:i:s', strtotime('-24 hours')) . "'";
return $where;
}
add_filter('posts_where', 'filter_where');
//query_posts($query_string);
}

function getDomain($fullurl)
{
    // Return the dot.name version of the domain, i.e. 'mercurynews.com' from 'www.mercurynews.com'
    // Assumes a two-dot string will be passed, i.e. 'www.mercurynews.com'
    // if you just need 'mercurynews' you can use this sted without a function $_SESSION['siteconfig']['domain']
    //used for dfp tag declarations and ?
    $domain_pieces = explode(".", $fullurl);
    $domain = $domain_pieces[1] . '.' . str_replace("/", "", $domain_pieces[2]);
    
    return $domain;
}

//this runs the ticker at the bottom of the page with breaking news!
function getBreakingArticles( $xmlfeed='' ){
    $storageArray = array();

    // Reassign vars from session for simplicity
    if( isset($_SESSION['siteconfig']) ){
        $xmlfeed = trim($_SESSION['siteconfig']['dfm_breaking_url']);
        $domain = trim($_SESSION['siteconfig']['domain']);
    } elseif( $xmlfeed === 'N/A' || $xmlfeed === 'n/a' ) {
        $xmlfeed = trim($_SESSION['siteconfig']['dfm_news_url']);
    }

    // Making sure vars above aren't null ^^^
    if( $domain === null ){
        $domain = getDomain();
    }
    if( $xmlfeed === '' || $xmlfeed === 'N/A' || $xmlfeed === 'n/a'){
        // Loads DP national news feed if not set
        $xmlfeed = 'http://rss.denverpost.com/mngi/rss/CustomRssServlet/36/207705.xml';
    }
    // What if cache dir doesn't exist?
    // Right now, return false.
    $cached_dir = dirname(__FILE__) . '/cache/';
    $cached_file = $cached_dir . $domain;
    if ( file_exists($cached_dir) === FALSE ):
        // Will have to take this out in Prod and create each dir manually with the proper permisssions.
        mkdir($cached_dir, 0777, true);
        error_log($cached_dir . ' does not exist. Without it, the headlines in the footer cannot write. Please create this directory and make it writeable by the webserver processes.');
        return false;
    endif; 
    $cached_xml = $cached_file . '.xml.cache';
    $timestamp = $cached_file . '.timestamp.txt';
    $time_int = 0;

    if( file_exists( $timestamp ) ){
        // Logic to check Unix timestamp
        $time_int = file_get_contents( $timestamp );
        $time_int = intval($time_int);
    } 

    if( $time_int >= time() - 60 * 10 ) {
        // File is not older than 10 minutes. Use cached version instead
        $xml = file_get_contents( $cached_xml );
        
    } else {
        // File is older than 10 minutes, grab new version from Server. Also write new timestamp.
        $xml = file_get_contents( $xmlfeed );
        copy( $xmlfeed, $cached_xml );
        $unix_timestamp = file_put_contents( $timestamp , time() );
    }

    $xml = preg_replace('~\s*(<([^>]*)>[^<]*</\2>|<[^>]*>)\s*~','$1',$xml);
    $xml = simplexml_load_string($xml,'SimpleXMLElement', LIBXML_NOCDATA);
    $json = json_encode( $xml );
    $array = json_decode($json,true);

    if ( $array != NULL ):
        foreach (array_slice($array['channel']['item'], 0 , 5) as $items ) {
            array_push($storageArray, $items);
        }
    endif;

    return $storageArray;
}

/*
// This was the start on the work to auto-populate the sub-nav of menus that didn't already have sub-navs defined.
class ExtraCategory extends TimberTerm
{
    function whatever()
    {
        echo 'whatever';
    }

}
*/

function build_thumbs($post_id)
{
    // This function was occasionally generating a fatal error on QA
    // Need to look at each piece
    try {
        getSmugFeat($post_id);
    }
    catch (Exception $e) {
        error_log($e->getTraceAsString());
    }
}

// Thumbnail generation
if ( function_exists('add_action') && class_exists('DFMGallery') ):
    //add_action( 'publish_post', 'build_thumbs' );
    add_action('post_updated', 'build_thumbs');
endif;

function slash_cats($category){
  $space_holder = "";
  $cat_string = "";
  foreach ($category as $categorysingle) {
    $cat_string .= $space_holder . strtolower(str_replace(' ', '_',$categorysingle->name));
    $space_holder = "/";
  }
  return $cat_string;
}
// DEBUGGING STUFF
// Add these lines to wp-config.php
/*
define('WP_DEBUG', true);
define('WP_DEBUG_LOG', true);
define('WP_DEBUG_DISPLAY', false);
*/

// You can do things with write_log() such as this
// write_log($awesomearray) the write_log will suss the type you're passing and var_dump out the array to the debug log
// at webroot/wp-content/debug.log
// write_log also takes a second, optional parameter: title.
// If you want a prefix on the log entry pass it a string and that will prefix your log entry.
// This is a good way to check your log file -> tail -f /path/to/wp-content/debug.log
if (!function_exists('write_log'))
{
    function write_log ($log, $title = '')
    {
        if ( true === WP_DEBUG )
        {
            if ( is_array( $log ) || is_object( $log ) ):
                error_log($title . ': ' . print_r( $log, true ) );
            else:
                error_log($title . ': ' . $log);
            endif;
        }
    }
}
?>
