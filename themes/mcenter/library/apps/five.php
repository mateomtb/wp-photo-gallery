<!-- Begin Five Category Section -->
<div id="category-section">
<?php
$cat_1 = get_option('T_category_section_1');
$cat_2 = get_option('T_category_section_2');
$cat_3 = get_option('T_category_section_3');
$cat_4 = get_option('T_category_section_4');
$cat_5 = get_option('T_category_section_5');

if(!$cat_1) {$cat_1 = "uncategorized";}
if(!$cat_2) {$cat_2 = "uncategorized";}
if(!$cat_3) {$cat_3 = "uncategorized";}
if(!$cat_4) {$cat_4 = "uncategorized";}
if(!$cat_5) {$cat_5 = "uncategorized";}

$cat_1_ID = get_cat_ID($cat_1);
$cat_2_ID = get_cat_ID($cat_2);
$cat_3_ID = get_cat_ID($cat_3);
$cat_4_ID = get_cat_ID($cat_4);
$cat_5_ID = get_cat_ID($cat_5);

$categories_stack = array();

if($cat_1 != "") {array_push($categories_stack,"$cat_1_ID");}
if($cat_2 != "") {array_push($categories_stack,"$cat_2_ID");}
if($cat_3 != "") {array_push($categories_stack,"$cat_3_ID");}
if($cat_4 != "") {array_push($categories_stack,"$cat_4_ID");}
if($cat_5 != "") {array_push($categories_stack,"$cat_5_ID");}

$span_1 = array("24","11","7","5","4");
$span_2 = array("24","12","8","6","4");

$i = 0;
foreach ($categories_stack as $category) {
$cat_num = count($categories_stack); 
		$i++; ?>
<?php 
query_posts("showposts=1&cat=$category"); ?>
<div class="column <?php if ($i < $cat_num) { ?>span-<?php echo $span_1[$cat_num-1];?> colborder<?php  } ?> post-<?php the_ID(); ?><?php if ($i == $cat_num ) { ?> span-<?php echo $span_2[$cat_num-1];?> last<?php $i==0; } ?>"

<?php
// Dynamically set the Visual Revenue Zone Tags - - Added 3/18/2013 by, Rob J.
 if ($_SESSION['siteconfig']["domain"] == "denverpost"){ ?>
data-vr-zone="<?php

switch ($i){
	case 1: 
		echo 'mediacenter_'. strtolower($cat_1);
		break;
	case 2:
		echo 'mediacenter_'. strtolower($cat_2);
		break;
	case 3:
		echo 'mediacenter_'. strtolower($cat_3);
		break;
	case 4:
		echo 'mediacenter_'. strtolower($cat_4);
		break;
	case 5:
		echo 'mediacenter_'. strtolower($cat_5);
		break;
			}?>"
<?php } ?>> 

<?php 
// Add Visual Revenue content box for column content
if ($_SESSION['siteconfig']["domain"] == "denverpost"){echo '<div data-vr-contentbox="">';}?>

<?php while (have_posts()): the_post(); ?>
<h2 class="sub"><a href="<?php echo get_category_link($category);?>"><?php single_cat_title(); ?> &raquo;</a></h2>

<?php 
//  container that holds thumb markup and starts the process  
$thumb_markup = '';
if ( has_post_thumbnail()==true ) {
the_post_thumbnail('thefive-thumbnail');
}

$thumb = get_post_meta($post->ID, 'thumbnail', true);
$smugthumb = get_post_meta($post->ID, 'smugdata', true);?>

<?php if (!empty($smugthumb)) {
$thumb_markup = getSmugThumb($smugthumb); /* this function is in the themes functions.php */ ?>
<div style="width:165px; height:150px; overflow:hidden;>
<a href="<?php the_permalink() ?>" rel="bookmark" title="Permanent Link to <?php the_title_attribute(); ?>"><img style="min-width:100%;" src="<?php echo $thumb_markup[0]["ThumbURL"];?>"></a><br />
</div> <?php } elseif (empty($smugthumb) && !empty($thumb)) {
$thumb_markup = generate_thumb($thumb); /* this function is in the themes functions.php */ ?>
<a href="<?php the_permalink() ?>" rel="bookmark" title="Permanent Link to <?php the_title_attribute(); ?>"><img class="archive-thumbnail" src="<?php echo $thumb_markup['previous_url'];?></a>
<?php } ?>


<h6><a href="<?php the_permalink() ?>" rel="bookmark" title="Permanent Link to <?php the_title_attribute(); ?>"><?php the_title() ?></a></h6>
<p class="byline"><?php the_time('M d, Y') ?> | <?php $posttags = get_the_tags(); $mytag = getmy_tag($posttags); if ($mytag == "prep_championships") { ?></p><?php } else { ?><span class="tagcolor"><?php echo $mytag;//in functions php, returns the first tag name of a post ?></span></p><? } ?>
<p><?php echo substr(get_the_excerpt(),0,100); ?></p>
<?php endwhile;?>
<h6><a href="<?php echo get_category_link($category);?>">More in <?php single_cat_title(); ?></a></h6>
<ul>
<?php query_posts("showposts=5&offset=1&cat=$category"); ?>
<?php while (have_posts()) : the_post(); ?>
<li><a href="<?php the_permalink() ?>" rel="bookmark" title="Permanent Link to <?php the_title(); ?>" class="title"><?php the_title(); ?></a></li>
<?php endwhile; ?>
</ul>
</div>
<?php  if ($_SESSION['siteconfig']["domain"] == "denverpost"){echo '</div>';}?>
<?php }// } ?>
</div>
<div class="clear"></div>
