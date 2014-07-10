<?php
//---------------created for ajaxit theme, gets all the tags and category variables set up
//die('hi');
$posttags = get_the_tags(); 
$mytag = getmy_tag($posttags); //get the post tag
$category = get_the_category();  //get the post category

//print_r ($category);
//$posttagsString = 'hi';
//die( count( $category ) );
//die(implode(",", $posttags));


$alldeeezcats = deeez_cats($category); // category list comma separated in quotes for ad tags IN THE HEADER ONLY
//echo "deezcats " . $alldeeezcats;
$alldeeezcats2 = deeez_cats2($category); // category list for omniture and used for ad tags IN THE IFRAME ONLY
//echo "deezcats2 " . $alldeeezcats2;
$parentcat = parent_of_cat($category);

//die( $parentcat );
/*
if ( is_singular() ) {
	$thepagetag = strtolower('mc_' . $mytag);
	//echo "mytag is " . $mytag;

	if ($mytag == "Video"){
		//echo $mytag;
		$thevidid = get_post_meta($post->ID, 'videoid', true);
		$bcpub = get_option('T_bcpubid');
		$bcplayid = get_option('T_bcplayerid');
		$bcplayid = get_option('T_bcplayerid');
		$faceapid = get_option('T_fbappid');

		//var_dump($thethumb);
		$image_id = get_post_thumbnail_id();  
		$image_url = wp_get_attachment_image_src($image_id,'thumbnail');
		//var_dump($image_url);
		echo '<meta property="fb:app_id" content="' . $faceapid . '">';
		echo '<meta property="og:type" content="video">';
		echo '<meta property="og:video:width" content="398">';
		echo '<meta property="og:video:height" content="224">';
		echo '<meta property="og:url"  content="' . get_permalink() . '">';
		echo '<meta property="og:video" content="http://c.brightcove.com/services/viewer/federated_f9?isVid=1&isUI=1&secureConnections=1&publisherID=' . $bcpub . '&playerID=' . $bcplayid  . '&domain=embed&videoId=' . $thevidid . '">';
		//echo '<link rel="video_src" href="http://c.brightcove.com/services/viewer/federated_f9?isVid=1&isUI=1&publisherID=934995285&playerID=1014161614001&domain=embed&videoId=' . $thethumb .'" />';
		//echo '<link rel="image_src" href="' . $image_url[0] . '" />';
		echo '<meta property="og:image" content="' . $image_url[0] . '">';
		echo '<meta property="og:video:type" content="application/x-shockwave-flash">';

	} else if ($mytag == "Photo" || "photo") {
		//start get thumbnail info
		$thumb_markup = '';
		$fb_image = '';
		//if there is a featured image on the post use that
		$image_id = get_post_thumbnail_id();
		  	if(!empty($image_id)) {
		  	$image_url = wp_get_attachment_image_src($image_id,'thumbnail');
		  	$fb_image = $image_url[0];
		  	echo '<meta property="fb:app_id" content="' . $faceapid . '">';
			echo '<meta property="og:type" content="article">';
			echo '<meta property="og:url"  content="' . get_permalink() . '">';
			echo '<meta property="og:image" content="' . $fb_image . '">';
		}

		//if there is a ssp custom field thumbnail set use this
		$thumb = get_post_meta($post->ID, 'thumbnail', true);
			if(!empty($thumb)) {
			$thumb_markup = generate_thumb($thumb);
			$fb_image = $thumb_markup['fbook_url'];
			//end get thumbnail info
			echo '<meta property="fb:app_id" content="' . $faceapid . '">';
			echo '<meta property="og:type" content="article">';
			echo '<meta property="og:url"  content="' . get_permalink() . '">';
			echo '<meta property="og:image" content="' . $fb_image . '">';
		}
	}
}
*/

$thepagetitle = trim(wp_title('', false));
//include (THEMELIB . '/apps/omnituresingle.php');
//wp_enqueue_script( 'comment-reply' );

if ( is_home() ) { 
	$thepagetag = 'home';
	$thepagecat = 'home';
	$thepagetitle = 'home';
	$theme_options = get_option('T_theme_options');
	//include (THEMELIB . '/apps/omniture.php');
}

if ( is_archive() ) {
	//echo single_cat_title();
	$thepagetag = 'archive_galleries';
	$thepagetitle = trim(wp_title('', false));
	//include (THEMELIB . '/apps/omnituresingle.php');
}

if ( is_search() ) {
	$thepagetag = 'search_galleries';
	$thepagetitle = trim(wp_title('', false));
	//include (THEMELIB . '/apps/omnituresingle.php');
}

?>
