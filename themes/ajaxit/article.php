<?php 
/* This article just returns a story */
get_header(); 
?>

<?php

//-----------------------------------interface js for when it loads, tell it what it needs to do
if ( $xfeed == 0 ) { ?>
	<script>
		function pageloaded() {
			xInterface.doNext = 3;
		}
	</script>

	<?php get_footer(); ?>

<?php













} else {
	//-----------------------------------feed for this content is below:::
	include(THEMELIB . '/functions/tags_cats.php');
	global $photo_array;
	
	//------------------------------------------------------------------OLMPIC ARTICLE
	$content_post = get_post( get_the_ID() );
	$content = $content_post->post_content;
	$content = apply_filters('the_content', $content);
	$content = trim( str_replace(']]>', ']]>', $content));
	$time = get_the_time('M d, Y');
	$arr = array('title' => $thepagetitle, 'description' => $description, 'time' => $time, 'photos' => '[]', 'thepagetag' => $thepagetag, 'alldeeezcats2' => $alldeeezcats2, 'parentcat' => $parentcat, 'mytag' => $mytag, 'thepagetitle' => $thepagetitle, 'text_article' => $content);
	echo json_encode($arr);
}
?>




