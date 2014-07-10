<?php /**
 * @package WordPress
 * @subpackage ThemeName
 * @since ThemeName 1.0
 * Template Name: Rotator
 */
header('Content-Type: application/javascript');
?>

<?php 
/* Creates a feed of data for the Media Center rotators on news.com
  Author: Josh Kozlowski
 * Last Modified 8/11/2013
*/

function mcStrReplace ($str) {
	$str = preg_replace('/[^a-zA-Z0-9_]/', '', $str);
	return $str;
}
$the_path = get_theme_root() . '/mcenter';
$mc_host = mcStrReplace($_SERVER['HTTP_HOST']);
$mc_type_of_rotator = mcStrReplace($_REQUEST['cat']);
$mc_size = mcStrReplace($_REQUEST['size']);
$mc_complete_cache_path = $the_path . '/rotator_feeds_cache/json_rotator_' . $mc_host . '_' . $mc_type_of_rotator . '_' . $mc_size . '.txt';

// Caching Code
if (file_exists($mc_complete_cache_path)){
	$cached = 15 * 60; //cache this data every 15  mins
	//$cached = 0;
	if (time() - $cached > filemtime($mc_complete_cache_path)){
		outputWidgetData($the_path, $mc_complete_cache_path);
	}
	else {
		include $mc_complete_cache_path;
	}
}
else {
	outputWidgetData($the_path, $mc_complete_cache_path);
}
// Outputs the Rotator Feed
function outputWidgetData($the_path, $file_path){
	$number_of_items = 10; //Number of items for the feed. 
	ob_start(); //Start buffer for caching 
	
	$curated_cat = get_category_by_slug('rotator-' . ((typeOfRotator() == 'mc_rotator_home___') ? 'home' : typeOfRotator())); // Needed something that would never actually be a category in the MC
	$non_curated_cat = get_category_by_slug(typeOfRotator());
	//run three WP queries. One to get curated and ordered posts, another to get curated but not ordered and the last to fill in enough content to get $number_of_items if for a rotator where no category was specified 
	// In between two and three we removed duplicates;
	if ($curated_cat){
		$curated_rotator_posts_ordered = get_posts(array( 
			'post_type' => 'post',
			'category' => $curated_cat->cat_ID,		
			'numberposts' => $number_of_items, 
			'offset' => '0',
			'order' => 'ASC', // This and next two items allow editors to order rotator posts with a custom field
			'orderby' => 'meta_value_num',
			'meta_key' => 'rotator-order',
		));
		$curated_rotator_posts = get_posts(array( 
			'post_type' => 'post',
			'category' => $curated_cat->cat_ID,		
			'numberposts' => $number_of_items - count($curated_rotator_posts_ordered), 
			'offset' => 0,
		));
		// Remove dupes
		$curated = array_merge($curated_rotator_posts_ordered, $curated_rotator_posts);
		$holder = array();
		foreach ($curated as $item){
		    if(!in_array($item, $holder)) {
		        $holder[] = $item;
		    }
		}
		$curated_rotator_posts = $holder;
	}
	else  $curated_rotator_posts = array();
	$non_curated_rotator_posts = get_posts(array( 
			'post_type' => 'post',
			'category' => (($curated_cat->name == 'rotator-home') ? '-' . $curated_cat->cat_ID : $non_curated_cat->cat_ID), 		
			'numberposts' => $number_of_items - count($curated_rotator_posts), 
			'offset' => '0'
	));
	$returned_posts = array_slice(array_merge($curated_rotator_posts,$non_curated_rotator_posts),0,$number_of_items); //An array of the Posts that will provide the data. $number_of_items in length	
	if (count($returned_posts) == $number_of_items): //Making sure that the correct amount of data is in the array
		$rotator_titles = array();
		$rotator_urls = array();
		$rotator_images = array();
		$rotator_excerpts = array();
		$rotator_timeago = array();
		$rotator_comment_total = array();	
		$rotator_large_images = array();

		foreach ($returned_posts as $post){
			$post_title = $post->post_title;
			if (strlen($post_title) > 75){
				$post_title = substr($post_title, 0, 74) . '...';
			}
			$rotator_titles[] = $post_title;
		}
	
		foreach ($returned_posts as $post){
			$rotator_urls[] = get_permalink($post->ID);
		}
		// The following foreach creates the excerpts. Since you can't really count on anyone creating this, the code creates it from the post content and attempts to strip out html and other code (such as SSP xml call)
		foreach ($returned_posts as $post){
			$post = strip_tags($post->post_content);
			if (strpos($post,'[') !== false) {
				$post = trim(substr($post,0,strpos($post,'[')));
			}
			if (strlen($post) > 100) {
						   $post = substr($post,0,100) . '...';
					}
			$rotator_contents[] = $post;
		}
		// Creates an array of image paths
		if ($_REQUEST['size'] != 'large'){
			foreach($returned_posts as $post){
				// WP attachment image
				if ($image = wp_get_attachment_image_src(get_post_thumbnail_id($post->ID),'rotator-thumb')) {
					$image = $image[0];
					$image_paths[] = $image;
				}
				// Smugmug
				elseif ($image = get_post_meta($post->ID, 'smugdata', true)){				
					$image = getSmugThumb($image,$rotator=true);	
					if ($image){
						if (function_exists('imagecopyresampled')){
							$image_paths[] = cacheCropImage($image[0]['CustomURL'], 400, 200, $the_path);	
						}
						else {
							$image_paths[] = $image[0]['CustomURL'];
						}
					}
					else {
						$image_paths[] = rotatorImageError();
					}
				}
				// SSP image
				elseif ($image = get_post_meta($post->ID, 'thumbnail', true)) {
					$image = generateRotatorImage($image, 400, 200);
					$image = $image['rotator'];
					if ($image == NULL) $image = rotatorImageError(); //This is what comes back from the Director if it breaks
					$image_paths[] = $image;
				}
				// Backup
				else {
					$image_paths[] = rotatorImageError();
				}
			}
		}
		else {
			foreach($returned_posts as $post){
				$image_paths[] = 'n/a';	
			}
		}
		foreach($returned_posts as $post){
                        $rotator_timeago[] = strtoupper(human_time_diff(strtotime($post->post_date), current_time('timestamp')) . ' ago'); 
                }
                foreach($returned_posts as $post){
                        $rotator_comment_total[] = get_comments_number($post->ID); 
                }
	        if ($_REQUEST['size'] == 'large'){
		    	foreach($returned_posts as $k => $post){
				$k == 0 ? $width = 471 : $width = 152;
				$k == 0 ? $height = 283 : $height = 90;
				$k == 0 ? $rotator_thumb = 'rotator-large-thumb' : 'rotator-large-thumb-small';
				// WP attachment image
				if ($image = wp_get_attachment_image_src(get_post_thumbnail_id($post->ID), $rotator_thumb)) {
					$image = $image[0];
					$image_paths_large [] = $image;
				}
				// Smugmug
				elseif ($image = get_post_meta($post->ID, 'smugdata', true)){
					$image = getSmugThumb($image,$k == 0 ? $rotator = 'large': $rotator = 'small');   
					if ($image){
						if (function_exists('imagecopyresampled')){
							$image_paths_large[] = cacheCropImage($image[0]['CustomURL'], $width, $height, $the_path);
						}
						else {
							$image_paths_large[] = $image[0]['CustomURL'];
						}
					}
					else {
						$image_paths_large[] = rotatorImageError();
					}
				}
				// SSP image
				elseif ($image = get_post_meta($post->ID, 'thumbnail', true)) {
					$image = generateRotatorImage($image, $width, $height);
					$image = $image['rotator'];
					if ($image == NULL) $image = rotatorImageError(); //This is what comes back from the Director if it breaks
					$image_paths_large[] = $image;
				}
				// Backup
				else {
					$image_paths_large[] = rotatorImageError();
				}
			}
		}
		else {
			foreach ($returned_posts as $post){
				$image_paths_large[] = 'n/a';
			}
		}
                $JSON_for_rotator = createRotatorJSON($rotator_titles, $rotator_urls, $image_paths, $rotator_contents, $rotator_timeago, $rotator_comment_total, $image_paths_large);
	
		echo $JSON_for_rotator; // write out the JSON. Technically it's an array of JSON encoded objects
		//echo '//foo';	
		// End caching
		
		$fp = fopen($file_path, 'w');
		fwrite($fp, ob_get_contents());
		fclose($fp);
		
	else:
		echo 'mc_rotator' . ($_REQUEST['size'] == 'large' ? '_large' : '') . '.createWidget({"error" : "Missing data."});'; // Error message
	endif;	
}
// This function creates the output
function createRotatorJSON($titles, $urls, $images, $excerpts, $timeagos, $comment_totals, $large_images){
	$JSON_posts;	
	//var_dump($images);
	for ($i = 0; $i < count($titles); $i++){
		//make all of it JSON 
		$JSON_posts .= '{ "title" : ' . json_encode($titles[$i]) . ', "image" : ' . json_encode($images[$i]) . ', "url" : ' . json_encode($urls[$i]) . ', "excerpt" : ' . json_encode($excerpts[$i]) . ', "timeago" : ' . json_encode($timeagos[$i]) . ', "comment_total" : ' . json_encode($comment_totals[$i])  . ', "images_large" :' . json_encode($large_images[$i]) . '},';
	}	
	$JSON_posts = trim($JSON_posts, ','); // Remove trailing comma
	$the_JSON = 'mc_rotator' . ($_REQUEST['size'] == 'large' ? '_large' : '') . '.createWidget([' . $JSON_posts  . ']);'; // An array of JSON encoded objects
	return $the_JSON;	  
}
// This function determines the output of the feed by checking the query string
// Example: ?cat=sports will come from the javascript call
// the value of "cat" should be the slug of the category of interest. 
function typeOfRotator() {
	// This is still a function because this was done differently before
	$str = $_REQUEST['cat'];
	return $str;	
}
function rotatorImageError(){
	return get_template_directory_uri() . '/images/mc_rotator_backup.jpg';
}
// This function goes to the SSP API
function generateRotatorImage($meta, $width, $height){ 
	if ($meta != ''){	
		$metadata = explode(',', $meta);	
	 $api = $metadata[1]; 
	}
	if (isset($api)) {
		//include(THEMELIB . '/director_keys/sspcodes.php');
		$director = setSSPcodes( $api ); //use the shared functions plugin to set the SSP API key
	}
	else {
		return false;	
	}
	$rotator = array('name' => 'rotator', 'width' => $width, 'height' => $height, 'crop' => 1, 'quality' => 50, 'sharpening' => 0); // Attributes of the image returned from the API...
	// ... The width is 400 because we want the image to move to the left in the actual rotator. Quality is fairly low to keep page load smaller
	$director->format->add($rotator);      

	$album = $director->album->get($metadata[0]);	
	$album_name = $album->name;

	$imginfo = Array (
		'rotator' => $album->contents[0]->rotator->url);
	
	return $imginfo;	
}
function cacheCropImage($smug_url, $width, $height, $server_path){
	$server_path = $server_path . '/rotator_images_cache/';
	$http_path = content_url() . '/themes/mcenter/rotator_images_cache/';
	$cache_image_name = preg_replace('/[^\.A-Za-z0-9]/', '', $smug_url);
	$cache_image_name = preg_replace('/(\.\w+$)/', '-cropped' . $width . 'x' . $height . '$1', $cache_image_name);
	if (file_exists($server_path . $cache_image_name)) {
		return $http_path . $cache_image_name;
	}
	else {
		$image_p = imagecreatetruecolor($width, $height);
		$image = imagecreatefromjpeg($smug_url);
		imagecopyresampled($image_p, $image, 0, 0, 0, 0, $width, $height, $width, $height);
		imagejpeg($image_p, $server_path . $cache_image_name, 60);
		return $http_path . $cache_image_name;
	}
}
?>
