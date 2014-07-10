<?php
//------------------this php file runs BEFORE any of the header, index, footer pages.
//$url = "http" . ((!empty($_SERVER['HTTPS'])) ? "s" : "") . "://".$_SERVER['SERVER_NAME'].$_SERVER['REQUEST_URI']; 
//$xfeed = 0;//strpos($url, '&fdx1');

add_filter('query_vars', 'parameter_queryvars' );
function parameter_queryvars( $qvars ) {
    $qvars[] = 'xfd';
    return $qvars;
}

//---------------------------------------------------------olympics custom post - third_party
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
//---------------------------------------------------------olympics custom post - third_party (end)


function queryWPlistOfArticles( $xquery ) {
	global $is_iPad, $is_iPhone, $is_Android_tablet, $is_Android_mobile, $post;
	$backup = $post; 
	$i == 0;$temp_array = array();
	//var_dump($xquery);die();
	$my_query = new wp_query($xquery);
	if( $my_query->have_posts() ) {
		while ($my_query->have_posts()) {
			$my_query->the_post();
			//<li><a href="<?php the_permalink() " rel="bookmark" title=" Link to  the_title_attribute(); "> the_title();
			$i++;
			$do_not_duplicate = $post->ID;
			
			$isVideo = 0;
			$xTags = get_the_tags();
			if ($xTags) {
				foreach($xTags as $tag) {
			  		if ( $tag->name == "Video" ) {
						$isVideo = 1;
					}
				}
			}
			//  container that holds thumb markup and starts the process 
			$thumb_markup = '';
			$thumb = get_post_meta($post->ID, 'thumbnail', true);
			$smugthumb = get_post_meta($post->ID, 'smugdata', true);
			if ( has_post_thumbnail()==true ) {
				//-----------------------------------------------Post with featured image it get's priority because video posts use this if it's missing move on down and fail to generic image if none found
				$thumb_id = get_post_thumbnail_id();
				if (has_post_thumbnail( $post->ID ) ) {
					if ( $is_iPad || $is_Android_tablet ) {
						$image = wp_get_attachment_image_src( $thumb_id, 'tablet_index_image' );
					} else if ( $is_iPhone || $is_Android_mobile ) {
						$image = wp_get_attachment_image_src( $thumb_id, 'mobile_index_image' );
					} else {
						$image = wp_get_attachment_image_src( $thumb_id, 'mobile_index_image' );
					}
					array_push($temp_array, array( 'url' => $image[0], 'title' => str_replace("\r","",trim( the_title('', '', false)) ), 'date' => get_the_time('M d, Y'), 'link' => get_permalink(), 'vid' => $isVideo ) );
					}

				} elseif (!empty($thumb)==true) { //check for ssp thumb
					//
					$thumb_markup = generate_thumb($thumb);
					array_push($temp_array, array( 'url' => $thumb_markup['list_image_url'], 'title' => str_replace("\r","",trim( the_title('', '', false)) ), 'date' => get_the_time('M d, Y'), 'link' => get_permalink(), 'vid' => $isVideo ) );

				} elseif (!empty($smugthumb)==true) { //check for smugmug thumb
					//
					$thumb_markup =getSmugThumb($smugthumb); /* this function is in the shared functions plugin */
					array_push($temp_array, array( 'url' => $thumb_markup[0]["ThumbURL"], 'title' => str_replace("\r","",trim( the_title('', '', false)) ), 'date' => get_the_time('M d, Y'), 'link' => get_permalink(), 'vid' => $isVideo ) );

				}  else {
					//--no thumbnail so send generic image
					array_push($temp_array, array( 'url' => THEME . '/css/images/photo.gif', 'title' => str_replace("\r","",trim( the_title('', '', false)) ), 'date' => get_the_time('M d, Y'), 'link' => get_permalink(), 'vid' => $isVideo ) );
				}	
			
		}
	}

	$post = $backup;  // copy it back
	wp_reset_query(); // to use the original query again
	return $temp_array;
}






// Define path constants
define('THEME', get_bloginfo('template_url'), true);
define('THEME_JS', THEME . '/js/', true);
define('THEMELIB', TEMPLATEPATH . '/library');

//define('MCENTERPATH', get_bloginfo('wpurl') . '/wp-content/themes/mcenter/');
//customFunctionRocks('hi');

//print_r($_SERVER);
global $photo_array, $videoData;	//cj
//-------------------------------------------------------------------------------------------set the platform variables
//global $is_iPad, $is_iPhone, $is_Android_tablet, $is_Android_mobile;
$is_iPad = (bool) strpos($_SERVER['HTTP_USER_AGENT'],'iPad');
$is_iPhone = (bool) strpos($_SERVER['HTTP_USER_AGENT'],'iPhone');
if ( (bool) strpos($_SERVER['HTTP_USER_AGENT'],'Android') ) {
	if ( (bool) strpos($_SERVER['HTTP_USER_AGENT'],'Mobile') ) {
		$is_Android_mobile = 1;$is_Android_tablet = 0;
	} else {
		$is_Android_mobile = 0;$is_Android_tablet = 1;
	}
}
/*
function mobile_detect(mobile,tablet,mobile_redirect,tablet_redirect,debug) {
var ismobile = (/iphone|ipod|android|blackberry|opera|mini|windows\sce|palm|smartphone|iemobile/i.test(navigator.userAgent.toLowerCase()));
var istablet = (/ipad|android|android 3.0|xoom|sch-i800|playbook|tablet|kindle/i.test(navigator.userAgent.toLowerCase()));
*/
//-------------------------------------------------------------------------------------------set the platform variables (end)

function olympicsCheck(){
	$is_olympics = FALSE;
	if (is_single()) {
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

function jsonCleanText( $xText ) {
	//-----mobile function
	$xText = str_replace("\r","", $xText);	//should it be an <BR>
	$xText = str_replace("\n","", $xText);	//should it be an <BR>
	$xText = trim( htmlspecialchars( $xText, ENT_QUOTES) );
	return $xText;
}

function processTitleRemoveWordPhotos ( $xTitle ) {
	//-----mobile function
	$xTitle = str_replace("Photos: ","",$xTitle);
	echo $xTitle;
	//$xTitle = "*";
	//return $xTitle;
}

function generateListFromQuery( $xQuery ) { 
	$theme_options = get_option('T_theme_options');
	global $mobile_smart;
	?>
	
	<ul data-role="listview" data-inset="true" >

	<?php $backup = $post; $i == 0; ?>
		<?php $featured_offset_query = new WP_Query($xQuery); ?>
		<?php while ($featured_offset_query->have_posts()) : $featured_offset_query->the_post(); $i++;
			$do_not_duplicate = $post->ID; 
			   
			//  container that holds thumb markup and starts the process 
			$thumb_markup = '';
			if ( has_post_thumbnail()==true ) {
				the_post_thumbnail('previous-thumbnail');
			}
			$thumb = get_post_meta($post->ID, 'thumbnail', true); ?>

            <li class="" data-corners="false" data-shadow="false" data-iconshadow="true" data-inline="false" data-wrapperels="div" data-icon="arrow-r" data-iconpos="right" >
				<?php if(!empty($thumb)) { ?>
					<?php $thumb_markup = generate_thumb($thumb);?>
					<a class="ui-link-inherit" href="<?php the_permalink() ?>">
						<img class="ui-li-thumb" src="<?php echo $thumb_markup['previous_url'];?>

				<?php } ?>
				<h3 class="ui-li-heading"><?php the_title() ?></h3>
				<p class="ui-li-desc"><?php $posttags = get_the_tags(); $mytag = getmy_tag($posttags); echo $mytag; ?> | <?php the_time('M d, Y') ?></p>
				<?php //echo substr(get_the_excerpt(),0,55); ?>
				</a>

			</li>

		<?php endwhile; ?>
		<?php //$i == 0; ?>

	</ul>

	<?php
	$post = $backup;  // copy it back
	wp_reset_query(); // to use the original query again
	
}




# Include DirectorAPI class file
require_once(THEMELIB . '/classes/DirectorPHP.php');

// Remove the WordPress generator
function gpp_remove_generators() { return ''; }  
add_filter('the_generator','gpp_remove_generators');

// thumbnail support for non photo gallery content, you upload a thumbnail to these posts so there is something to show on the homepage, recent, archive etc.
add_theme_support( 'post-thumbnails' );
//the_post_thumbnail( array(256,256) );
set_post_thumbnail_size( 256, 256, true ); // Normal post thumbnails
//add_image_size( 'featured-thumbnail', 590, 9999, true ); // Home Page featured thumbnail size
//add_image_size( 'thefive-thumbnail', 165, 150, true ); // Home Page the five thumbnail size
//add_image_size( 'previous-thumbnail', 114, 114, true ); // Home Page the five thumbnail size
//add_image_size( 'project-menu', 65, 65, true ); //Special project menu
//add_image_size( 'project-about', 135, 135, true ); //Special project about image
//add_image_size( 'facebook-thumb', 150, 150, true ); //Facebook og thumb image

add_image_size( 'tablet_index_image', 300, 300, true );
add_image_size( 'mobile_index_image', 80, 80, true );

//echo the_post_thumbnail( 'tablet_index_image' );
//die();
/*
//----------CJ - Add these image sizes so that in querylist.php you can call the correct size for smugmug 'featured image'
if ( $is_iPad || $is_Android_tablet ) {
	add_image_size( 'mobile_index_image', 256, 256, true );	//turns out these just 'soft' crop them in html. no good :(
	$cj_wp_image_crop_string = "medium";
} else if ( $is_iPhone || $is_Android_mobile ) {
	add_image_size( 'mobile_index_image', 80, 80, true );
	$cj_wp_image_crop_string = 'thumbnail';
}
*/

function generate_thumb($thumb){ 
	global $is_iPad, $is_iPhone, $is_Android_tablet, $is_Android_mobile;
	 if ($thumb != "") {
		// Separate our comma separated list $thumb into an array
		$thumbnaildata = explode(",", $thumb);
		//var_dump($thumbnaildata[0]);
		//var_dump($thumbnaildata[1]);
		$api = $thumbnaildata[1];
	}

	if (isset($api)) {
		$director = setSSPcodes( $api );			//mu-plugins Shared function
	}
		else //because there are a lot of posts without thunbnaildata[1] set, they will all be this director install 
			$director = new Director('hosted-ec5968d1bc7bc366d67ef8a87fd69909', 'dpphoto.slideshowpro.com', false);

	/*---------------Start Director Setup ------------------------*/
	// When your application is live, it is a good idea to enable caching.
	// You need to provide a string specific to this page and a time limit 
	// for the cache. Note that in most cases, Director will be able to ping
	// back to clear the cache for you after a change is made, so don't be 
	// afraid to set the time limit to a high number.
	//$director->cache->set('thisisTCthumbs', '+240 minutes');
	
	if ( $is_iPad || $is_Android_tablet ) {
		$list_image		= array('name' => 'list_image'    , 'width' => "256", 'height' => '256', 'crop' => 1, 'quality' => 80, 'sharpening' => 1);
		$list_image_bar	= array('name' => 'list_image_bar', 'width' => "200", 'height' => '100', 'crop' => 1, 'quality' => 80, 'sharpening' => 1);
	} else if ( $is_iPhone || $is_Android_mobile ) {
		//$list_image = array('name' => 'list_image', 'width' => "480", 'height' => '480', 'crop' => 1, 'quality' => 85, 'sharpening' => 1);
		$list_image = array('name' => 'list_image', 'width' => "80", 'height' => '80', 'crop' => 1, 'quality' => 85, 'sharpening' => 1);
		$list_image_bar	= array('name' => 'list_image_bar', 'width' => "200", 'height' => '100', 'crop' => 1, 'quality' => 80, 'sharpening' => 1);
	
	//} else if ( $is_Android_mobile ) {
	//	$list_image = array('name' => 'list_image', 'width' => "80", 'height' => '80', 'crop' => 1, 'quality' => 85, 'sharpening' => 1);
		
	} else {
		$list_image = array('name' => 'list_image', 'width' => "80", 'height' => '80', 'crop' => 1, 'quality' => 85, 'sharpening' => 1);
		$list_image_bar	= array('name' => 'list_image_bar', 'width' => "200", 'height' => '100', 'crop' => 1, 'quality' => 80, 'sharpening' => 1);
	}
	
	//now add each of the image sizes above
	$director->format->add($list_image);
	$director->format->add($list_image_bar);
	//$director->format->add($nextimage);
	
	//do these two lines just this once
	$album = $director->album->get($thumbnaildata[0]);
	$album_name = $album->name;
	
	$imginfo = Array (
		'list_image_url' => $album->contents[0]->list_image->url,
		'list_image_bar' => $album->contents[0]->list_image_bar->url
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

/*
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
*/

add_action('init', 'theme_load_js');


add_action('wp_print_scripts', 'enqueueMyScripts');

function enqueueMyScripts(){

if ( is_singular() ) {
	wp_enqueue_script('galleriffic', THEME_JS .'jquery.galleriffic.js', array('jquery'), '', true);
	wp_enqueue_script('history', THEME_JS .'jquery.history.js', array('jquery'), '', true);
	wp_enqueue_script('opaicty', THEME_JS .'jquery.opacityrollover.js', array('jquery'), '', true);
	wp_enqueue_script('gallerifficinit', THEME_JS .'init_slideshow.js', array('galleriffic'), '', true);
	}

}

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
	
?>