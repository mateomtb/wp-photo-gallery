<?php
// Feed for new Bartertown rotator
// This old code is messy and outdated
// Here we can refactor without breaking anything on NGPS/Saxo news.com




function mcStrReplace ($str) {
	$str = preg_replace('/[^a-zA-Z0-9_]/', '', $str);
	return $str;
}
$the_path = get_template_directory() . '/';
$mc_host = mcStrReplace($_SERVER['HTTP_HOST']);
$mc_type_of_rotator = mcStrReplace($_REQUEST['cat']);
$mc_size = mcStrReplace($_REQUEST['size']);
$mc_callback = mcStrReplace($_REQUEST['callback']);
$mc_complete_cache_path = $the_path . '/rotator_feeds_cache/json_rotator_' . $mc_host . '_' . $mc_type_of_rotator 
	. '_' . $mc_size . '_' . $mc_callback . '.json';

// Caching Code
if (file_exists($mc_complete_cache_path)){
	$cached = 15 * 60; //cache this data every 15 mins
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
	$number_of_items = 6; //Number of items for the feed.
	$bc_embed_pattern = '/(https?:\/\/bcove.me\/[A-Za-z0-9]+)/'; // To check if post contains embedded brightcove
	//$bc_embed_pattern = '/bcove.me\//'; // To check if post contains embedded brightcove
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
			'meta_key' => 'smugdata'
		));
		$curated_rotator_posts = get_posts(array( 
			'post_type' => 'post',
			'category' => $curated_cat->cat_ID,
			'numberposts' => $number_of_items - count($curated_rotator_posts_ordered), 
			'offset' => 0,
			'meta_key' => 'smugdata'
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
			'offset' => '0',
			'meta_key' => 'smugdata'
	));
	$returned_posts = array_slice(array_merge($curated_rotator_posts,$non_curated_rotator_posts),0,$number_of_items); //An array of the Posts that will provide the data. $number_of_items in length	
	if (count($returned_posts) == $number_of_items): //Making sure that the correct amount of data is in the array
		$rotator_titles = array();
		$rotator_urls = array();
		$rotator_images = array();
		$rotator_contents = array();
		$rotator_type = array();

		foreach ($returned_posts as $post){
			$post_title = $post->post_title;
			$post_title = niceEllipsis($post_title, 75);
			$rotator_titles[] = $post_title;
		}

		foreach ($returned_posts as $post){
			$rotator_urls[] = get_permalink($post->ID);
		}
		// The following foreach creates the excerpts. Since you can't really count on anyone creating this, the code creates it from the post content and attempts to strip out html and other code (such as SSP xml call and Brightcove embed call)
		foreach ($returned_posts as $post){
			$excerpt = ($post->post_excerpt) ? $post->post_excerpt : $post->post_content;
			$excerpt = preg_replace($bc_embed_pattern, '', strip_tags($excerpt));
			if (strpos($excerpt,'[') !== false) {
				$excerpt = trim(substr($excerpt,0,strpos($excerpt,'[')));
			}
			if ($_REQUEST['size'] === 'large'){
				$excerpt = niceEllipsis($excerpt, 150);
			}
			else {
				$excerpt = niceEllipsis($excerpt, 100);
			}
			$rotator_contents[] = $excerpt;
		}

	
		/*foreach($returned_posts as $post){
			$rotator_timeago[] = strtoupper(human_time_diff(strtotime($post->post_date), current_time('timestamp')) . ' ago');
		}
		foreach($returned_posts as $post){
			$rotator_comment_total[] = get_comments_number($post->ID);
		}*/
		
		// Creates an array of image paths
	   foreach($returned_posts as $post){
			// Smugmug
			if ($smugData = get_post_meta($post->ID, 'smugdata', true)){
				$imageArr = getsmugthumb($smugData, $rotator='responsive');
				$rotator_images[] = $imageArr[0]['LargeURL'];
				$rotator_type[] = 'smugmug';			
			}
			//elseif ($image = bcImageCheck($post, $bc_embed_pattern)) {
				//$images[] = cacheCropImage($image, $width, $height, $the_path);
			//}
			// WP attachment image
			elseif ($image = wp_get_attachment_image_src(get_post_thumbnail_id($post->ID), 'full')) {
				// Works for BC embed images
				$image = $image[0];
				$rotator_images[] = $image;
				$rotator_type[] = null;
			}
			// SSP image
			elseif ($image = get_post_meta($post->ID, 'thumbnail', true)) {
				$image = generateRotatorImage($image, 2000, 2000);
				$image = $image['rotator'];
				if ($image == NULL) $image = rotatorImageError(); //This is what comes back from the Director if it breaks
				$rotator_images[] = $image;
				$rotator_type[] = null;
			}
			// Backup
			else {
				$rotator_images[] = rotatorImageError();
				$rotator_type[] = null;
			}
		}

		//else {
			//foreach ($returned_posts as $post){
				//$images[] = 'n/a';
			//}
		//}
		$JSON_for_rotator = createRotatorJSON($rotator_titles, $rotator_urls, $rotator_contents, $rotator_images, $rotator_type);

		echo $JSON_for_rotator; // write out the JSON. Technically it's an array of JSON encoded objects
		//echo '//foo';	
		// End caching
	
		$fp = fopen($file_path, 'w');
		fwrite($fp, ob_get_contents());
		fclose($fp);
	
	else:
		echo '{error: true}'; // Error message
	endif;	
}
// This function creates the output
function createRotatorJSON($titles, $urls, $excerpts, $images, $galleryType){
	$JSON_posts = array();	
	//var_dump($images);
	for ($i = 0; $i < count($titles); $i++){
		//make all of it JSON 
		//make all of it JSON 
		$JSON_posts[] =  array(
			"title"  => $titles[$i], 
			"images" => ($i < 3) ? getCustomSmugMugSizes($images[$i]) : getCustomSmugMugSizes($images[$i], true), 
			"url" => $urls[$i], 
			"excerpt" => $excerpts[$i],
			"gallery_type" =>  $galleryType[$i]
		);
	}	
	$the_JSON = json_encode(
			array(
				"top_items" => array_slice($JSON_posts, 0, 3), 
				"bottom_items" => array_slice($JSON_posts, 3, 3)
			)
		); // An array of JSON encoded objects
	if ($mc_callback = mcStrReplace($_REQUEST['callback'])) {
		$the_JSON = "$mc_callback($the_JSON)";
	}
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
		//var_dump($post);
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
/*function bcImageCheck($post, $bcURLPattern) {
	// Check for and return an Brightcove cover image if it's present
	$content = $post->post_content;
	$id = $post->ID;
	$featuredImage = get_the_post_thumbnail($id);
	if (preg_match($bcPattern, $content) && $featuredImage) {
		return $featuredImage;
	}
	else {
		return false;
	}
}*/
function cacheCropImage($image_url, $width, $height, $server_path){
	$server_path = $server_path . '/rotator_images_cache/';
	$http_path = content_url() . '/themes/mcenter/rotator_images_cache/';
	$cache_image_name = preg_replace('/[^\.A-Za-z0-9]/', '', $image_url);
	$cache_image_name = preg_replace('/(\.\w+$)/', '-cropped' . $width . 'x' . $height . '$1', $cache_image_name);
	if (file_exists($server_path . $cache_image_name)) {
		return $http_path . $cache_image_name;
	}
	else {
		$image_p = imagecreatetruecolor($width, $height);
		$image = imagecreatefromjpeg($image_url);
		imagecopyresampled($image_p, $image, 0, 0, 0, 0, $width, $height, $width, $height);
		imagejpeg($image_p, $server_path . $cache_image_name, 60);
		return $http_path . $cache_image_name;
	}
}
function niceEllipsis($str, $len){
// Return a substring so that it doesn't get cut-off midword 
	if (strlen($str) > $len) {
		$str = preg_replace('/\n/', ' ', $str);
		$len -= 1;
		$regExp = "/^.{1,$len}\s/";
		$match = array();
		preg_match($regExp, $str, $match);
		$str= preg_replace('/[\.\,]$/', '', trim($match[0])) . '...';
		return ($str) ? $str : '';
	}
	return $str;
}

function getCustomSmugMugSizes($url, $simple=false){
	// Take Smugmug large url and find and replace the 'L' identifier with sizes
	if ($url) {
		if ($simple) {
			$nurl = changeSmugMugLargeUrl($url, '400', '225');
			return $nurl;
		}
		$urls = array();
		$sizes = array(
		    array(320, 240),
		    array(640, 480),
		    array(480, 320),
		    array(960, 640),
		    array(640, 480),
		    array(1280, 960),
		    array(800, 600),
		    array(1600, 1200)
		);
		foreach ($sizes as $size) {
			$w = $size[0]; // width
			$h = $size[1]; // height
			$nurl = changeSmugMugLargeUrl($url, $w, $h);
			$urls[(string)'_' . $w . 'x' . $h] = $nurl;
		}
		return $urls;
	}
	else {
		return $url;
	}
}

function changeSmugMugLargeUrl($url, $width, $height){
	$nurl = preg_replace('/\/L\//', (string) '/' . $width . 'x' . $height . '/', $url);
	$nurl = preg_replace('/\-L\./', (string) '-' . $width . 'x' . $height . '.', $nurl);
	return $nurl;
}

/*class UseSmug extends SmugMugDeps {
	
	// SmugMugDeps currently found in plugins/dfm-wp-photogallery/dfm-wp-photogallery.php 
	
	function __construct($smugData) {
		$this->smugData = $smugData;
	}
	
	public function smugImage($size=null){
		if ($this->smugData) {
			if ($size) {
				$size = $size[0];
				$this->smugMugImageCustomSizeString = "CustomSize=$size";
				$smugPackage = $this->smugMugPackage();
				$image = $smugPackage[0]['images'][0]["CustomURL"];
			}
			else {
				$smugPackage = $this->smugMugPackage();
				var_dump($smugPackage[0]);
				$image = $smugPackage[0]['images'][0]["LargeURL"];
			}
			return $image;
		}
	}
}*/

?>