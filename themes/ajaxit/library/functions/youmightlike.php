<?php
//ok we want to randomly pick 3 categories from the current article
//	and pull 5 of the latest articles from these 
die('youmightlike.php is a DEAD page');

if ($category) {
	$category_ids = array();
	foreach($category as $individual_category) $category_ids[] = $individual_category->term_id;
	
	$args=array(
		'category__in' => $category_ids,
		'post__not_in' => array($post->ID),
		'showposts'=>5, // Number of related posts that will be shown.
		'caller_get_posts'=>1
	);
	
	//$xquery = "cat=".$category_id."&showposts=". $numberOfPosts ."&offset=". $xoffset ."&tag=photo,photos";
	$xquery = "category__in=".$category_ids."&post__not_in=". array($post->ID) ."&showposts=2&caller_get_posts=1";
	//$featured_offset_query = new WP_Query($xquery);
	//while ($featured_offset_query->have_posts()) {
		
	$my_query = new wp_query($xquery);
	if( $my_query->have_posts() ) {
		echo '<h3>Related Posts</h3><ul>';
		while ($my_query->have_posts()) {
			$my_query->the_post();
		?>
			<li><a href="<?php the_permalink() ?>" rel="bookmark" title="Permanent Link to <?php the_title_attribute(); ?>"><?php the_title(); ?></a></li>
		<?php
		}
		echo '</ul>';
	}
}
		
//if( $count<4 && $currentId!=$post->ID) {  
//echo ':'. count( $category ) . '<BR>';
//foreach ($category as $xcat) {
//	echo ':'. $xcat->name . '<BR>';
//}

//$category is an array of all the categories for this article, each is as such:
// ["term_id"]=> &string(1) "3" ["name"]=> &string(13) "Entertainment" ["slug"]=> &string(13) "entertainment" ["term_group"]=> string(1) "0" ["term_taxonomy_id"]=> string(1) "3" ["taxonomy"]=> string(8) "category" ["description"]=> &string(0) "" ["parent"]=> &string(1) "0" ["count"]=> &string(2) "49" ["object_id"]=> string(5) "17710" ["cat_ID"]=> &string(1) "3" ["category_count"]=> &string(2) "49" ["category_description"]=> &string(0) "" ["cat_name"]=> &string(13) "Entertainment" ["category_nicename"]=> &string(13) "entertainment" ["category_parent"]=> &string(1) "0" } [1]=> object(stdClass)#326 (16) 

die();
$youMightLikeArray = array();

$youMightLikeArray = get_category_parents($category[1]->cat_ID, false, ',');
$youMightLikeArray = explode( ',', $youMightLikeArray );

/*
//$backup = $post; $i == 0;
//var_dump($category);
switch ($category[0]->cat_ID) {
    case "56":
        $related = "25";
        break;
    case "26":
        $related = "17";
        break;
	case "55":
        $related = "12";
        break;
	case "22":
        $related = "5";
        break;
    default:
       $related = $alldeeezcats3;
       
}
$cat_title = get_category( $related );$cat_title = $cat_title->name;
$xquery = "cat=" . $related . "&showposts=5&offset=1&tag=Photo";



<li style="background-color:#333333;" ontouchstart="xActiveTouch = 1;" ontouchmove="xActiveTouch = 0;" ontouchend="if (xActiveTouch) { toggleTopLayer(); }">
	<div id="youmightlike_container" style="margin-top:50px;">
		<?php $xquery = "cat=" . $related . "&showposts=5&offset=1&tag=Photo"; include (THEMELIB . '/functions/querylist_bar.php'); ?>
		<div style="margin:0px 15px 0px 15px;height:1px;width:max-width:100%;border-top:1px solid #666;"></div>
		<?php $xquery = "cat=" . $related . "&showposts=5&offset=6&tag=Photo"; include (THEMELIB . '/functions/querylist_bar.php'); ?>
		<div style="margin:0px 15px 0px 15px;height:1px;width:max-width:100%;border-top:1px solid #666;"></div>
		<?php $xquery = "cat=" . $related . "&showposts=5&offset=11&tag=Photo"; include (THEMELIB . '/functions/querylist_bar.php'); ?>
	</div>
</li>
*/

?>
