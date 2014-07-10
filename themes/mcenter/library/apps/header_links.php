<?php
// Header links - Jason Armour 3.19.2012
// These are pulled from the Media Center Appearance settings
$link_color = get_option('T_header_link_color');
?>
<div class="toplinks" style="color:<?php echo $link_color ?> !important;">
<a href="<?php echo get_settings('home'); ?>" style="color:<?php echo $link_color ?> !important;">HOME</a> |
<?php
$cat_1 = get_option('T_header_link_1');
$cat_2 = get_option('T_header_link_2');
$cat_3 = get_option('T_header_link_3');
$cat_4 = get_option('T_header_link_4');

if(!$cat_1) {$cat_1 = "uncategorized";}
if(!$cat_2) {$cat_2 = "uncategorized";}
if(!$cat_3) {$cat_3 = "uncategorized";}
if(!$cat_4) {$cat_4 = "uncategorized";}

$cat_1_ID = get_cat_ID($cat_1);
$cat_2_ID = get_cat_ID($cat_2);
$cat_3_ID = get_cat_ID($cat_3);
$cat_4_ID = get_cat_ID($cat_4);

$categories_stack = array();
if($cat_1 != "") {array_push($categories_stack,"$cat_1_ID");}
if($cat_2 != "") {array_push($categories_stack,"$cat_2_ID");}
if($cat_3 != "") {array_push($categories_stack,"$cat_3_ID");}
if($cat_4 != "") {array_push($categories_stack,"$cat_4_ID");}

$last_key = end(array_keys($categories_stack));

foreach ($categories_stack as $key => $category) {
	query_posts("cat=$category");
?>
<a href="<?php echo get_category_link($category);?>" style="color:<?php echo $link_color ?> !important;text-transform:uppercase;"><?php single_cat_title(); ?></a>
<?php 
	if($key != $last_key) {
	    echo " | ";
	 }
} 
wp_reset_query();
?>
</div>