<?php get_header(); ?>

<?php
//-----------------------------------interface js for when it loads, tell it what it needs to do
if ( $xfeed == 0 ) { ?>
	<script>
		function pageloaded() {
			xInterface.doNext = 2;
		}
	</script>

	<?php get_footer(); ?>

<?php













} else {
	//-----------------------------------feed for this content is below:::
	include(THEMELIB . '/functions/tags_cats.php');
	global $photo_array;	//from ssp plugin
	
	if (have_posts()) {
		while (have_posts()) {
			the_post();
			$category = get_the_category();  //get the post category 
			$alldeeezcats2 = deeez_cats2($category); // category list m dash separated with underscore in multiple word cats
			$alldeeezcats3 = deeez_cats3($category); // category id's seperated by commas for use in recent photos video at the bottom of the page
			$thepagetag = strtolower($mytag . '_galleries');
			
			//-----this include processes the content of the article into $description, $title, $time, $photo_array
			include (THEMELIB . '/functions/processcontent.php');
			$photoarray = array();
			foreach ($photo_array as $image) {
				array_push($photoarray, array( 'url' => $image['xURL'], 'title' => $image['title'], 'caption' => jsonCleanText($image['caption']) ) );
			}
			
			//-----------------------------------------------------YOUMIGHTLIKE
			$youMightLikeArray = array();
			if ($category) {
				$category_ids = array();
				foreach($category as $individual_category) $category_ids[] = $individual_category->term_id;
				
				$xquery=array( 'category__in' => $category_ids, 'post__not_in' => array($post->ID), 'showposts'=>10, 'caller_get_posts'=>1 );
				$youMightLikeArray = queryWPlistOfArticles($xquery);	//function found in functions.php
			}
			//-----------------------------------------------------YOUMIGHTLIKE (end)

			$arr = array('title' => $title, 'description' => $description, 'time' => $time, 'photos' => $photoarray, 'thepagetag' => $thepagetag, 'alldeeezcats2' => $alldeeezcats2, 'parentcat' => $parentcat, 'mytag' => $mytag, 'thepagetitle' => $thepagetitle, 'text_article' => '', 'youmightlike' => $youMightLikeArray);
			echo json_encode($arr);
		}
	}
}
?>
