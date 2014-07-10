<?php

//print_r($_SERVER);



// Define path constants
define('THEME', get_bloginfo('template_url'), true);
define('THEME_JS', THEME . '/js/', true);
define('THEMELIB', TEMPLATEPATH . '/library');

// Get Theme Options Page
if(is_admin()) :
require_once (THEMELIB . '/functions/theme-options.php');
endif;
    # Include DirectorAPI class file -- mateo 6-14-2012
require_once(THEMELIB . '/classes/DirectorPHP.php');

// Get Post Thumbnails and Images
include(THEMELIB . '/functions/post-images.php');

// Get Video
include(THEMELIB . '/apps/video-embed/video-post.php');

// Filter Comments
include(THEMELIB . '/functions/comments-filter.php');

// Load widgets
include(THEMELIB . '/functions/widgets.php');

// Produces an avatar image with the hCard-compliant photo class for author info
include(THEMELIB . '/functions/author-info-avatar.php');

// Remove the WordPress generator
function gpp_remove_generators() { return ''; }  
add_filter('the_generator','gpp_remove_generators');

function theme_wp_head() { ?><link href="<?php bloginfo('template_directory'); ?>/library/functions/style.php" rel="stylesheet" type="text/css" /><?php } 
if(get_option('T_css')) {
add_action('wp_head', 'theme_wp_head'); }

// thumbnail support for non photo gallery content, you upload a thumbnail to these posts so there is something to show on the homepage, recent, archive etc.
add_theme_support( 'post-thumbnails' );
set_post_thumbnail_size( 50, 50, true ); // Normal post thumbnails
add_image_size( 'featured-thumbnail', 590, 9999, true ); // Home Page featured thumbnail size
add_image_size( 'thefive-thumbnail', 165, 150, true ); // Home Page the five thumbnail size
add_image_size( 'previous-thumbnail', 114, 114, true ); // Home Page the five thumbnail size
add_image_size( 'project-menu', 65, 65, true ); //Special project menu
add_image_size( 'project-about', 135, 135, true ); //Special project about image
add_image_size( 'facebook-thumb', 150, 150, true ); //Facebook og thumb image
add_image_size( 'rotator-thumb', 400, 200, true); //Image for Rotator for news.com
add_image_size( 'rotator-large-thumb', 471, 283, true); //Image for Large Rotator for news.com (top image)
add_image_size( 'rotator-large-thumb-small', 152, 90, true); //Image for Large Rotator for news.com (small images in slider)
add_image_size( 'olympics-rotator', 590, 400, true); //Olympics home page rotator
add_image_size( 'tablet_index_image', 300, 300, true );	//cj MOBILE tablet thumbs
add_image_size( 'mobile_index_image', 80, 80, true );	//cj MOBILE phone thumbs

/*---------------Syndicated Content----------------*/
// Syndicated Content dashboard widget - Jason Armour 1.30.12
function recent_syndicated_content() {
	$syndicated_query = new WP_Query( array(
		'post_type' => 'post',
		'category_name' => 'syndicated',
		'post_status' => 'draft',
		'posts_per_page' => 150,
		'orderby' => 'modified',
		'order' => 'DESC'
	) );
	$syndicated =& $syndicated_query->posts;

	if ( $syndicated && is_array( $syndicated )) {
		$list = array();
		foreach ( $syndicated as $broadcast ) {
			$url = get_edit_post_link( $broadcast->ID );
			$title = _draft_or_post_title( $broadcast->ID );
			$last_id = get_post_meta( $broadcast->ID, '_edit_last', true );
			$last_user = get_userdata($last_id);
			$last_modified = '<i>' . esc_html( $last_user->display_name ) . '</i>';
			$item = '<b>' . esc_html($title) . '</b> ' . '<span style="font-family:sans-serif;font-size:10px;font-style:italic;">[' . $broadcast->post_status . ']</span>' . '<abbr style="display:block;margin-left:0;">' . sprintf(__('Last edited by %1$s on %2$s at %3$s'), $last_modified, mysql2date(get_option('date_format'), $broadcast->post_modified), mysql2date(get_option('time_format'), $broadcast->post_modified)) . '</abbr><br /><a href="' . $url . '" title="' . sprintf( __( 'Edit “%s”' ), esc_attr( $title ) ) . '">Edit</a>';
			// if ( $the_content = preg_split( '#\s#', strip_tags( $draft->post_content ), 11, PREG_SPLIT_NO_EMPTY ) )
			// 				$item .= '<p>' . join( ' ', array_slice( $the_content, 0, 10 ) ) . ( 10 < count( $the_content ) ? '&hellip;' : '' ) . '</p>';
			$list[] = $item;
		}
?>
<ul>
	<li><?php echo join( '<hr style="background-color:#DFDFDF;border:0 none;color:#DFDFDF;height:1px;" /></li><li>', $list ); ?></li>
</ul>
<?php
	} else {
		_e('There is no syndicated content at the moment');
	}
}

/* Adds column to order curated rotator items and allow them to be edited with Quick Edit */

add_filter( 'manage_edit-post_columns', 'rotator_order_column', 10, 1);
add_action( 'manage_posts_custom_column', 'rotator_order_column_display', 10, 2);

function rotator_order_column($columns){
	if (!isset($columns['rotator_order'])){
		$columns['rotator_order'] = "Rotator Order";
		return $columns;
	}
}

function rotator_order_column_display($column_name, $post_id){
	if($column_name == 'rotator_order'){
		$order_meta = get_post_meta($post_id, 'rotator-order', true);
		if ($order_meta) {
			echo $order_meta;
		}
	}
}

add_action( 'quick_edit_custom_box', 'manage_rotator_order', 10, 2 );

function manage_rotator_order($column_name, $post_type) {
	static $printNonce = TRUE;
	if ($printNonce) {
		$printNonce = FALSE;
		wp_nonce_field(-1 , 'rotator_order_edit_nonce');
	}
	if ($column_name === 'rotator_order') {
	?>
		<fieldset class="inline-edit-col-right">
			<div class="inline-edit-col column-rotator_order">
				<label>
					<span class="title">Rotator Order</span>
				</label>
				<span class="input-text-wrap"><input type="text" name="rotator_order" value="" style="width: 50px;"></span>
			</div>
		</fieldset>
		<?php
	}
}

add_action('save_post', 'save_rotator_order_meta');

function save_rotator_order_meta($post_id) {
	if (!current_user_can( 'edit_post', $post_id)) {
		return;
	}
	$_POST += array("rotator_order_edit_nonce" => '');
	if ( !wp_verify_nonce( $_POST["rotator_order_edit_nonce"]) ){
		return;
	}
	if (isset( $_REQUEST['rotator_order'])) {
		update_post_meta( $post_id, 'rotator-order', $_REQUEST['rotator_order'] );
	}
}

add_action('admin_footer-edit.php', 'admin_edit_rotator_order_foot', 11);

/* load scripts in the footer */
function admin_edit_rotator_order_foot() {
	echo '<script type="text/javascript" src="'. get_template_directory_uri() . '/js/rotator_order_admin_edit.js"></script>';
}

add_action('rotator_order_column_display' , 'admin_edit_rotator_order', 10, 2);
function admin_edit_rotator_order($column, $post_id) {
	echo get_post_meta($post_id , 'rotator-order' , true);
}

/* End column addition */

function add_custom_dashboard_widget() {
	wp_add_dashboard_widget('recent_syndicated_content', 'DFM Syndicated Content', 'recent_syndicated_content');
}

global $current_blog;
$currentID = 0;
if ( is_object($current_blog) ):
    $currentID = $current_blog->blog_id;
endif;
if ($currentID == 1) 
	add_action('wp_dashboard_setup', 'add_custom_dashboard_widget');
/*---------------Syndicated Content----------------*/


function get_category_id($cat_name){
	$term = get_term_by('name', $cat_name, 'category');
	return $term->term_id;
}

function generate_thumb($thumb){ 
//var_dump($thumb);
 if ($thumb != "")
      {
        // Separate our comma separated list $thumb into an array
        $thumbnaildata = explode(",", $thumb);
		//var_dump($thumbnaildata[0]);
		//var_dump($thumbnaildata[1]);
		$api = $thumbnaildata[1];
     
}	

if (isset($api)) {
		//include(THEMELIB . '/director_keys/sspcodes.php');
		$director = setSSPcodes( $api );			//mu-plugins Shared function
}
	    else //because there are a lot of posts without thunbnaildata[1] set, they will all be this director install 
	   $director = new Director('hosted-ec5968d1bc7bc366d67ef8a87fd69909', 'dpphoto.slideshowpro.com');
	   //var_dump($director);
     // Director config
/*---------------Start Director Setup ------------------------*/
	
	//$director = new Director('hosted-ec5968d1bc7bc366d67ef8a87fd69909', 'dpphoto.slideshowpro.com');
	
	# When your application is live, it is a good idea to enable caching.
	# You need to provide a string specific to this page and a time limit 
	# for the cache. Note that in most cases, Director will be able to ping
	# back to clear the cache for you after a change is made, so don't be 
	# afraid to set the time limit to a high number.
	//$director->cache->set('thisisTCthumbs', '+10 minutes');
	# We can also request the album preview at a certain size
	#$director->format->preview(array('width' => "0", 'height' => '0', 'crop' => 0, 'quality' => 85, 'sharpening' => 1));
	$mypreview = array('name' => 'mypreview', 'width' => "590", 'height' => '2000', 'crop' => 0, 'quality' => 70, 'sharpening' => 1);
	$previous = array('name' => 'previous', 'width' => "114", 'height' => '114', 'crop' => 1, 'quality' => 45, 'sharpening' => 1);
	$thefive = array('name' => 'thefive', 'width' => "165", 'height' => '150', 'crop' => 1, 'quality' => 45, 'sharpening' => 1);
	$fbook = array('name' => 'fbook', 'width' => "150", 'height' => '150', 'crop' => 1, 'quality' => 45, 'sharpening' => 1);
	$director->format->add($previous);
	$director->format->add($fbook);
	$director->format->add($thefive);
	$director->format->add($mypreview);
	//$director->format->preview($previous)
    /*-----------End Director Setup -----------------------------*/	 
      

    $album = $director->album->get($thumbnaildata[0]);
	$album_name = $album->name;
	//var_dump($album->contents[0]->previous->url);
	//$preview_url = $album->preview->url;
	//print_r($preview_url);
	/*my array of formats*/
	$imginfo = Array (
		'previous_url' => $album->contents[0]->previous->url ."\" width=\"" . $album->contents[0]->previous->width . "\" height=\"" . $album->contents[0]->previous->height . "\" alt=\"" . $album_name . "\" />",
		'fbook_url' =>  $album->contents[0]->fbook->url,
		'thefive_url' =>  $album->contents[0]->thefive->url ."\" width=\"" . $album->contents[0]->thefive->width . "\" height=\"" . $album->contents[0]->thefive->height . "\" alt=\"" . $album_name . "\" />",
		'mypreview_url' =>  $album->contents[0]->mypreview->url ."\" width=\"" . $album->contents[0]->mypreview->width . "\" height=\"" . $album->contents[0]->mypreview->height . "\" alt=\"" . $album_name . "\" />");

//print_r($album);
    return $imginfo;
}

//A varation of generate_thumb() that allows you to customize the height/width of the return.
//The array key to access for the image returned is simply 'image'

function generateSSPImage($meta,$width,$height){
					if ($meta != ''){	
						$metadata = explode(',',$meta);	
					 $api = $metadata[1]; 
					}
					if (isset($api)) {
						//include(THEMELIB . '/director_keys/sspcodes.php');
						$director = setSSPcodes( $api );			//mu-plugins Shared function
					}
					else {
						return false;	
					}
					$highlights = array('name' => 'highlights', 'width' => $width, 'height' => $height, 'crop' => 1, 'quality' => 100, 'sharpening' => 0);
					$director->format->add($highlights);
					$album = $director->album->get($metadata[0]);	
					$album_name = $album->name;
					$imginfo = array (
						'image' => $album->contents[0]->highlights->url
					);
					return $imginfo;
				}

// comma seperated category list in quotes for ad tags in the header
function deeez_cats($category){
$comma_holder = "";
$cat_string = "";
	foreach ($category as $categorysingle) {
	$cat_string .= $comma_holder . '"mc_' . strtolower(str_replace(' ', '_',$categorysingle->name)) . '"';
	$comma_holder = ",";
	}
	return $cat_string;
}

// m dash seperated category list, 2 word categories have underscores for spaces, this is for omniture tags
//using this to send to add iframes too to populate tags because can't send quotes in the querey string.
function deeez_cats2($category){
$space_holder = "";
$cat_string = "";
	foreach ($category as $categorysingle) {
	$cat_string .= $space_holder . 'mc_' . strtolower(str_replace(' ', '_',$categorysingle->name));
	$space_holder = "-";
	}
	return $cat_string;
}
//for recent posts at bottom of each page
function deeez_cats3($category){
$space_holder = "";
$cat_string = "";
	foreach ($category as $categorysingle) {
	$cat_string .= $space_holder . strtolower(str_replace(' ', '_',$categorysingle->cat_ID));
	$space_holder = ",";
	}
	return $cat_string;
}

function slash_cats($category){
$space_holder = "";
$cat_string = "";
	foreach ($category as $categorysingle) {
	$cat_string .= $space_holder . strtolower(str_replace(' ', '_',$categorysingle->name));
	$space_holder = "/";
	}
	return $cat_string;
}

// Load javascripts
function theme_load_js() {
    if (is_admin()) return;
    wp_enqueue_script('jquery');   
    wp_enqueue_script('jqueryui', THEME_JS .'jquery-ui-1.7.2.custom.min.js', array('jquery'));

    //wp_enqueue_script('swfobject');
    wp_enqueue_script('search', THEME_JS .'search.js','');
    wp_enqueue_script('hooverintent', THEME .'/library/nav/js/hoverIntent.js', '', '1.0');
	wp_enqueue_script('bgi', THEME .'/library/nav/js/jquery.bgiframe.min.js', '', '2.1');
	wp_enqueue_script('superfish', THEME .'/library/nav/js/superfish.js', 'jquery', '1.4.8'); 
	
} 


add_action('init', 'theme_load_js');

/*
add_action('wp_print_scripts', 'enqueueMyScripts');

function enqueueMyScripts(){

if ( is_singular() ) {
	wp_enqueue_script('galleriffic', THEME_JS .'jquery.galleriffic.js', array('jquery'), '', true);
	wp_enqueue_script('history', THEME_JS .'jquery.history.js', array('jquery'), '', true);
	wp_enqueue_script('opaicty', THEME_JS .'jquery.opacityrollover.js', array('jquery'), '', true);
	wp_enqueue_script('gallerifficinit', THEME_JS .'init_slideshow.js', array('galleriffic'), '', true);
	}

}
*/

//custom nav support -- mateo 3.23.12
if ( function_exists( 'register_nav_menus' ) ) {
	register_nav_menus(
		array(
		  'custom-top-right' => 'Custom Top Right'
		)
	);
}
//end nav support

function custom_login() { 
echo '<link rel="stylesheet" type="text/css" href="' . get_bloginfo('template_directory') . '/custom-login/custom-login.css" />'; 
}
add_action('login_head', 'custom_login');

add_action('init', 'add_some_feeds');
function add_some_feeds(  ) {
  add_feed('hubFeed', 'hub_create_feed');
}
function hub_create_feed() {
	include('hubfeed.php');
}




/*
RssWidg Settings
Part of the SimplePie plugin functionality. Used for external vendor-partner feeds.

Note: cache directory doesn't work unless apache + owner users align, or unles chmod 0777'ed.
*/
$rsswidg_default_settings = array(
	'items' => 5,
	'template' => 'enclosures_only'
	);
// if ( function_exists('SimplePieWP') ) echo SimplePieWP('http://feeds.mercurynews.com/mngi/rss/CustomRssServlet/568/235702.xml', $pie_default_settings); 

/*
Create custom post type to differentiate posts from external feeds 
 */
add_action( 'init', 'create_post_type' );
function create_post_type() {
        $args = array(
        'labels' => post_type_labels( 'Third Party Post' ),
        'description' => 'Posts from External RSS Feeds',
        'public' => true,
        'publicly_queryable' => true,
        'show_ui' => true,
        'show_in_menu' => true,
        'query_var' => true,
        'rewrite' => false,
        'capability_type' => 'post',
        'has_archive' => true,
        'hierarchical' => false,
        'menu_position' => 5,
        'supports' => array('title',
            'editor',
            'author',
            'thumbnail',
            'excerpt',
            'comments',
            'custom-fields',
            'taxonomies'
        ),
        'taxonomies' => array('category', 'post_tag')
    );
 
        register_post_type( 'third_party', $args );
}
// A helper function for generating the labels
function post_type_labels( $singular, $plural = '' )
{
    if( $plural == '') $plural = $singular .'s';
   
    return array(
        'name' => _x( $plural, 'post type general name' ),
        'singular_name' => _x( $singular, 'post type singular name' ),
        'add_new' => __( 'Add New' ),
        'add_new_item' => __( 'Add New '. $singular ),
        'edit_item' => __( 'Edit '. $singular ),
        'new_item' => __( 'New '. $singular ),
        'view_item' => __( 'View '. $singular ),
        'search_items' => __( 'Search '. $plural ),
        'not_found' =>  __( 'No '. $plural .' found' ),
        'not_found_in_trash' => __( 'No '. $plural .' found in Trash' ),
        'parent_item_colon' => ''
        
    );
}
// Had to add this to allow "Third Party Posts" to be queryable by category
add_filter('pre_get_posts', 'query_post_type');
function query_post_type($query) {
  if(is_category() || is_tag()) {
    $post_type = get_query_var('post_type');
	if($post_type)
	    $post_type = $post_type;
	else
	    $post_type = array('post','third_party');
    $query->set('post_type',$post_type);
	return $query;
    }
}


			
function createThirdPartyLinks($identifier, $custom_field=null, $total=null, $category=null){
        // this function creates an unordered list of $total links (default 5)
        // based on a string ($identifier) in one of the 
	// syndication custom fields ($custom_fields, which defaults to syndication_permalink)
        // you can also specify a category ($category) to query from though that might change
	// Example of usage would be: createThirdPartyLinks('sbnation', 'syndication_source_uri') 
        // currently it will search back until it's queried over 1000 posts
	$identifier = strtolower($identifier);
	if ($custom_field == null) $custom_field = 'syndication_permalink';
	if ($total == null) $total = 5;
	/*if ($category == null) {
		$category = get_category_by_slug('olympics');
		$category = $category->cat_ID;	
	}*/
	$count = 0;
	$breaker = count(get_posts(array('numberposts' => -1, 'offset' => 0, 'category' => $category)));
        $sb_posts = array();
                while(have_posts()){
                        $post = get_posts(array(
                                'numberposts' => 1,
                                'offset' => $count,
                                'category' => $category,
                                'exclude' => get_the_ID()
				));
                        $syndication_URL = strtolower(get_post_meta($post[0]->ID, $custom_field, true)); 
                        if (strpos($syndication_URL, $identifier) !== false){
                                $sb_posts[] = array($syndication_URL, $post[0]->post_title);
                        }
                        $count++;						
                        if ($count > $breaker || count($sb_posts) == $total) break;
                        }       
        if (!empty($sb_posts)){
                echo '<ul class="third-party-links-module ' . $identifier . '-links">';
                foreach ($sb_posts as $post){
                        echo '<a href="' . $post[0]  . '"> <li>' . $post[1] . '</li></a>';
                }
                echo '</ul>';
        }
}

function syndicationCheck($identifier, $custom_field=null){
        // checks if syndicated content comes from a source indicated by  $idenifier by 
	// looking for a match in one of the syndicated post's 
	// custom fields ($custom_fields, which defaults to syndication_source) 
        // and returns true or false. 
	// Example syndicationCheck('sbnation') would check to see if the post's custom field syndication_source
	// contains 'sbnation'
        // needs to be used in the Loop
	$identifier = strtolower($identifier);
        if ($custom_field == null) $custom_field = 'syndication_source';
        $syndication_URL = strtolower(get_post_meta(get_the_ID(), $custom_field, true));
	if (strpos($syndication_URL, $identifier) !== false) {
                return true;
        }
        else {
                return false;
        }
}


	
function olympicsCheck(){
	$is_olympics = FALSE;
	if (is_single()) {
		/*if (strpos($_SERVER['REQUEST_URI'],'olympic') !== FALSE){//Essentially title of post check
			$is_olympics = TRUE;
			return $is_olympics;
		}*/
		if ( has_category('olympics') == TRUE || is_category('olympics') == TRUE ){
			$is_olympics = TRUE;
			return $is_olympics;
		}
		$categories = get_the_category();
		foreach ($categories as $category) {
			if (strpos($category->cat_ID, 'olympics') !== FALSE){
				 $is_olympics = TRUE;
				return $is_olympics;
			}

		}
	}
	$category = get_category(get_query_var( 'cat' ));
	$category = $category->slug;
	if ($category !== null) {
		if (strpos($category, 'olympics') !== FALSE){ 
			$is_olympics = TRUE;
			return $is_olympics;
		}
		else {
			$olympics_cat_id = get_category_by_slug('olympics');
        		$olympics_cat_id = $olympics_cat_id->cat_ID;
        		$olympics_children = get_categories(array('child_of' => $olympics_cat_id));
        			foreach ($olympics_children  as $child) {
                			if ($child->slug == $category) {
						$is_olympics = TRUE;
						return $is_olympics;
					}
        			}
		}
	
	}
	//if ( has_category('olympics') == TRUE || is_category('olympics') == TRUE ) $is_olympics = TRUE;
	//if ( is_home() == TRUE ) $is_olympics = FALSE;
	return $is_olympics;
	// A better way to do this might be to check the URL for the string "/olympics" However, that will cause problems for anyone on a dev server where they can't use the MC's permalink structure
}


function bleacher_report_top()
{
	// Write the Bleacher Report top headlines. 

	echo '<div id="top_stories_bleacher">
<div class="top_stories_left">
        <div class="top_stories_head" style="text-transform: uppercase;">
                Top sport stories <SPAN>by Bleacher Report</SPAN>
        </div>
';

	// SimplePie feed work.
	if ( function_exists('SimplePieWP') )
	{
		// Load the lead feed item.
		echo SimplePieWP('http://bleacherreport.com/partner_feeds/olympics?columnists=true&use-hook=true&thumbs=true&items=1',
			array(
				'items' => 1,
				'template' => 'bleacher_report_top_stories_lead'
			));
		// Load the rest of the feed items. We'll use
		// jquery to hide the first item, which 
		// is the same as the lead feed item.
		echo SimplePieWP('http://bleacherreport.com/partner_feeds/olympics?columnists=true&use-hook=true&thumbs=true&items=5',
			array(
				'items' => 5,
				'template' => 'bleacher_report_top_stories'
			));
		
	}
	else
	{
		echo '<h3>Sorry, no stories are available</h3>';
	}

	// Boilerplate footer
	echo '                </div>
                <div class="top_stories_right">
                        <div style="width:300px;height:250px;position:relative;margin:0 auto;top:25px;">';
                        
                   //load top right 350x300
		switch ($_SESSION['parent_company']){
			case("jrc"):
				echo '<div class="adElement" id="adPosition9"><script type="text/javascript" language="JavaScript">yld_mgr.place_ad_here("lrec_atf_slot");</script></div>';
				 break;
			case("mngi"):
				echo '<div class="adElement" id="adPosition9"><script type="text/javascript" language="JavaScript">yld_mgr.place_ad_here("adPos9");</script></div>';
				 break;
	}

                        
                         echo '</div>
                </div>

<!-- end top stories bleacher -->
</div>';
}

if ( function_exists('DetermineParentCompany')) DetermineParentCompany($_SESSION['siteconfig']);
//you can get any value about a site like this echo ($_SESSION['siteconfig']);
//var_dump($_SESSION['siteconfig']);




//wp_set_password('gopass',1);
remove_filter('template_redirect','redirect_canonical'); 

// Gallery code is adding this
add_action('rss2_item', function(){
	global $post;
	if ($cI = get_post_meta($post->ID, 'rss-cover-image', true)) {
		$coverImage = "\n<cover-image>$cI</cover-image>\n";
		echo $coverImage;
	}
	else {
		echo "\n<cover-image></cover-image>\n";
	}
});
?>
