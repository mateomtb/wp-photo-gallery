<?php get_header(); ?>

<?php
//-----------------------------------interface js for when it loads, tell it what it needs to do

if ( $xfeed == 0 ) { ?>
	<script>
		function pageloaded() {
			xInterface.doNext = 1;
		}
	</script>

	<?php get_footer(); ?>
<?php





























	



} else {
	//-----------------------------------feed for this content is below::
	include(THEMELIB . '/functions/tags_cats.php');
	$cat_array = array();$photo_array = array();
	
	if ($xcat=='all') {
		//-------------------------------------------------------------------------------we want a full list of CATEGORIES
		$args=array( 'orderby' => 'name', 'order' => 'ASC' );
		$categories=get_categories($args);$cat_title = 'all';$category_id = 'all';
		foreach($categories as $category) {
			array_push($cat_array, array( 'title' => $category->name, 'count' => $category->count, 'link' => get_category_link( $category->term_id ) ) );
		}
		//-------------------------------------------------------------------------------we want a full list of CATEGORIES (end)
		
		
		
		
	} else {
		//-------------------------------------------------------------------------------regular category or newest listing of GALLERIES
		$xoffset = 0;
		$numberOfPosts = 24;//http://192.168.1.105/mediacenter/?xfd&offset=1
		if ( $_GET["offset"] ) { $xoffset = $_GET["offset"]; $numberOfPosts = 24; }
		if ( $category_id != '' ) {
			//---------------user is viewing a category page
			//$xquery = "cat=".$category_id."&showposts=". $numberOfPosts ."&offset=". $xoffset ."&tag=photo,photos";
			$xquery=array( 'cat' => $category_id, 'showposts' => $numberOfPosts, 'offset'=>$xoffset, 'tag'=>'photo,photos,video,videos');
		} else {
			//---------------user is viewing most recent galleries index
			//$xquery = "cat=-88,-101&showposts=". $numberOfPosts ."&offset=". $xoffset ."&tag=photo,photos";
			$xquery=array( 'cat' => '-88,-101', 'showposts' => $numberOfPosts, 'offset'=>$xoffset, 'tag'=>'photo,photos,video,videos');
		}
		$photo_array = queryWPlistOfArticles($xquery);	//function found in functions.php
		
		//include (THEMELIB . '/functions/querylist.php');
		//-------------------------------------------------------------------------------regular category or newest listing of GALLERIES (end)
	}

	if ( $cat_title == null ) {
		$cat_title = '';$category_id = '';	//just in case they are blank
	}
	
	$arr = array('category_title' => $cat_title, 'category_id' => $category_id, 'category' => $cat_array, 'photos' => $photo_array, 'thepagetag' => $thepagetag, 'alldeeezcats2' => $alldeeezcats2, 'parentcat' => $parentcat, 'mytag' => $mytag, 'thepagetitle' => $thepagetitle, 'offset' => $xoffset );
	echo json_encode($arr);

}

?>


