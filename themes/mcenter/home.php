<?php get_header(); 
$theme_options = get_option('T_theme_options');
?>

<!-- Show the welcome box, slideshow, slider and magazine front only on first page.  Makes for better pagination. -->
<?php if ( $paged < 1 ) { ?>

<?php
//pull featured section
$featured = get_option('T_featured');
if(($featured) || (!$theme_options && !$featured)) { include (THEMELIB . '/apps/featured.php'); }
?>

<!-- End Better Pagination -->
<?php } ?>

<?php

if ( isset($_GET['update_cats'])):

$blogs = $wpdb->get_results( $wpdb->prepare("SELECT blog_id, domain, path FROM $wpdb->blogs WHERE site_id = %d AND public = '1' AND archived = '0' AND mature = '0' AND spam = '0' AND deleted = '0' ORDER BY registered DESC", $wpdb->siteid), ARRAY_A );

$cat_option = 5;
$cat_option = intval($_GET['update_cats']);
foreach ( $blogs as $blog ):
	$option_to_change = 'T_category_section_' . $cat_option;
	$option_next = 'T_category_section_' . ( $cat_option + 1 );
/*
	// In case we make a mistake
	if ( get_blog_option($blog['blog_id'], $option_to_change) == get_blog_option($blog['blog_id'], $option_next) ):
		echo get_blog_option($blog['blog_id'], $option_to_change) . ": ";
		$switch_to_category = 'Lifestyles';
		update_blog_option($blog['blog_id'], $option_to_change, $switch_to_category);
		echo get_blog_option($blog['blog_id'], $option_to_change) . "<br>";
	endif;

	// For mass edits of a category header
	if ( get_blog_option($blog['blog_id'], $option_to_change) == 'Olympics' ):
		echo get_blog_option($blog['blog_id'], $option_to_change) . ": ";
		$switch_to_category = 'Images Of The Day';
		update_blog_option($blog['blog_id'], $option_to_change, $switch_to_category);
		echo get_blog_option($blog['blog_id'], $option_to_change) . "<br>";
	endif;
*/
endforeach;

endif;

//pull blog
$blog = get_option('T_blog');
if($blog) { include (THEMELIB . '/apps/blog.php'); }
?>

<?php
//pull news
$news = get_option('T_news');
if($news) { include (THEMELIB . '/apps/news.php'); }
?>

<?php
//pull five categories
$category_section = get_option('T_category_section');
if($category_section || (!$theme_options && !$category_section)) { include (THEMELIB . '/apps/five.php'); }
?>

<!-- Begin Footer -->
<?php get_footer(); ?>
