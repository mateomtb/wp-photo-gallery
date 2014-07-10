<?php
// Top Nav Dynamic links - Jason Armour 2.6.12
// These are pulled from the Media Center Appearance settings for categories
global $current_blog;
$currentID = $current_blog->blog_id;

?>
<ul class="sf-menu">
	<li>
		<a href="<?php echo get_settings('home'); ?>">Home</a>
	</li>
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

$i = 0;
foreach ($categories_stack as $category) {
	$cat_data = get_the_category($category);
	query_posts("cat=$category");
?>
	<li class="<?php echo preg_replace('/\d/','',str_replace(' ','',strtolower(get_cat_name($category)))); ?>">
		<a href="<?php echo get_category_link($category);?>"><?php single_cat_title(); ?></a>

			<ul>
			<?php
			if ($currentID == 1) { 
				wp_list_categories('depth=1&orderby=id&title_li=&use_desc_for_title=1&child_of='.$category);
			}
			else { // Display all sub categories for any site other than National
				wp_list_categories('depth=0&orderby=id&title_li=&use_desc_for_title=1&child_of='.$category);
			}
			?>
			</ul>

	</li>
<?php 
	$i++;
} 
wp_reset_query();
?>
	<?php  wp_nav_menu( array( 'theme_location' => 'custom-top-right', 'items_wrap' => '%3$s' ) ); ?>

</ul>
