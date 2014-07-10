<?php die('olympics/article.php is not used!');get_header(); ?>

<?php
//echo '1<BR>';
//-----------------------------------interface js for when it loads, tell it what it needs to do
if ( $xfeed == 0 ) { ?>
	<script>
		alert( 'third_party');
		function pageloaded() {
			//BuildInterface();
			//loadGalleryData(document.location);
			//doNext = 2;
			xInterface.doNext = 2;
			//alert(document.location + '?fdx1');
			
			//loadIndexData(homeURL );
			//LoadThisURL( homeURL );
			
			//document.getElementById('scroller').style.width = ( window.parent.innerWidth * 3 ) +"px";
			//setTimeout('setSizes();', 1000);
		}
		//myGalleryScroll._resize(); 
	</script>

	<?php get_footer(); ?>

<?php













} else {
	//-----------------------------------feed for this content is below:::
	include(THEMELIB . '/functions/tags_cats.php');
	global $photo_array;
	
	if (have_posts()) {
		//echo '4: '. count($photo_array) .'<BR>';
		while (have_posts()) {
			the_post();
			//$posttags = get_the_tags(); $mytag = getmy_tag($posttags); //get the post tag 
			$category = get_the_category();  //get the post category 
			$alldeeezcats2 = deeez_cats2($category); // category list m dash separated with underscore in multiple word cats
			$alldeeezcats3 = deeez_cats3($category); // category id's seperated by commas for use in recent photos video at the bottom of the page
			$thepagetag = strtolower($mytag . '_galleries');
			
			
			//var mycars = new Array();
			//-----this include processes the content of the article into $description, $title, $time, $photo_array
			include (THEMELIB . '/functions/processcontent.php');
			//echo $title . '<BR>';
			//echo $description . '<BR>';
			//echo $time . '<BR>';
			
			$xString = '{"title":"'. $title .'","description":"'. $description .'","time":"'. $time .'","photos":[';
			
			//echo '<BR><BR>photoArray count: '. count($photo_array) .'<BR>';
			
			foreach ($photo_array as $image) {
				//print_r($image );
				//echo '<BR><BR>';
				//$xString = $xString . '{"url":"'. $image->ipad_cj->url. '","title":"'. $image->seq. '","caption":"'. jsonCleanText($image->caption) .'" },';
				//xURL"=>$image->iphone_cj->url, "caption"=>$image->caption, "title
				$xString = $xString . '{"url":"'. $image['xURL']. '","title":"'. $image['title']. '","caption":"'. jsonCleanText($image['caption']) .'" },';
				
				
				//echo '7<BR>';
				//echo $image->ipad_cj->url . '<BR>';
				//echo $image->seq . '<BR>';
				//str_replace("\r","",trim( htmlspecialchars( $image->caption, ENT_QUOTES) ) )
			}
			
		}
	}
	
	//$xString = $xString . ']}';
	$xString = $xString . '],"thepagetag":"'. $thepagetag .'", "alldeeezcats2":"'. $alldeeezcats2 .'", "parentcat":"'. $parentcat .'", "mytag":"'. $mytag .'", "thepagetitle":"'. $thepagetitle .'" }';
	echo $xString;
	//echo '{"title":"'. $title .'","description":"'. $description .'","time":"'. $time .'","photos":[{"firstName":"John","lastName":"Doe" },{"firstName":"Kate","lastName":"Smith" },{"firstName":"Peter","lastName":"Jones" }]}';
	
	
	//$posttags = get_the_tags();
	//$mytag = getmy_tag($posttags); //in functions php, returns the first tag name of a post
	//echo 'feed for single is: '. $mytag .'<BR>';
	//echo 'gallery php feed: '. $mytag;
}







/*
die('single.php');
$posttags = get_the_tags();
$mytag = getmy_tag($posttags); //in functions php, returns the first tag name of a post
//echo 'feed for single is: '. $mytag .'<BR>';
if (has_category('olympics')) {
	if ( $mytag != null){
		$mytag = 'Olympics-gallery';	
	}
	else {
		$mytag = 'Olympics-article';
	}
}
die('234');
switch ($mytag) {
    case "Photo":
    	include(TEMPLATEPATH . '/gallery.php');
        break;
    case "Video":
    	//echo "it's a video";
        include(TEMPLATEPATH . '/video.php');
        break;
	case "Olympics-gallery":
		echo "it's a Olympics-gallery";
		include(THEMELIB . '/olympics/single.php');    
		break;
	case "Olympics-article":
		echo "it's a Olympics-article";
		include(THEMELIB . '/olympics/article.php');
		break;
    default:
        include(TEMPLATEPATH . '/gallery.php');
}
die('olympics - article.php');
get_header(); 
$theme_options = get_option('T_theme_options');
*/



?>
