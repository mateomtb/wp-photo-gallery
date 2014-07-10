<?php

if ($_REQUEST['embedded_gallery']) :
	header('Content-Type: application/javascript');
	include(get_theme_root() . '/mcenter/embed_gallery.php');
else:
	$posttags = get_the_tags();
	$mytag = getmy_tag($posttags); //in functions php, returns the first tag name of a post
	
	//---------------olypics code
	global $olympics_var;$olympics_var = '';if ( $_GET["third_party"] ) { $olympics_var = $_GET["third_party"];$mytag='Article';}
	
	//echo 'feed for single is: '. $mytag .'<BR>';
	switch ($mytag) {
		case "Article":
	    	include(TEMPLATEPATH . '/article.php');
	        break;
	    case "Photo":
	    	include(TEMPLATEPATH . '/gallery.php');
	        break;
	    case "Video":
	    	//echo "it's a video";
	        include(TEMPLATEPATH . '/video.php');
	        break;

	    default:
	        include(TEMPLATEPATH . '/gallery.php');
	}
endif; // Logic for embed galleries
?>
