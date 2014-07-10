<?php get_header(); 
$theme_options = get_option('T_theme_options');
?>

<!-- Show the welcome box, slideshow, slider and magazine front only on first page.  Makes for better pagination. -->
<?php if ( $paged < 1 ) { ?>

<?php
//pull welcomebox
$welcomebox = get_option('T_welcomebox');
if($welcomebox || (!$theme_options && !$welcomebox)) { include (THEMELIB . '/apps/welcomebox.php'); }
?>

<?php
//pull homepage video
$featured_video = get_option('T_featured_video');
$video_path = get_option('T_featured_video_path');
$video_thumb = get_option('T_featured_video_thumb');
//pull slideshow
$slideshow = get_option('T_slideshow');
$slideshow_status = get_option('T_slideshow_status');

if($featured_video && $video_path && $video_thumb){ // if homepage video is on, replace slideshow
	include (THEMELIB . '/apps/video-home.php');
} else { // show slideshow only if homepage video is off
	if(($slideshow  && $slideshow_status == "Dynamic")) { include (THEMELIB . '/apps/slideshow.php'); }
	if((!$theme_options && !$slideshow) || ($slideshow && $slideshow_status == "Static")) { include (THEMELIB . '/apps/slideshow-static.php'); } 
} 
?>

<?php
//pull slider
$slider = get_option('T_slider');
if($slider || (!$theme_options && !$slider)) { include (THEMELIB . '/apps/slider.php'); }
?>

<?php
//pull featured section
$featured = get_option('T_featured');
if(($featured) || (!$theme_options && !$featured)) { include (THEMELIB . '/apps/featured.php'); }
?>

<!-- End Better Pagination -->
<?php } ?>

<?php
//pull blog
$blog = get_option('T_blog');
if($blog) { include (THEMELIB . '/apps/blog.php'); }
?>

<?php
//pull five categories
$category_section = get_option('T_category_section');
if($category_section || (!$theme_options && !$category_section)) { include (THEMELIB . '/apps/five.php'); }
?>

<!-- Begin Footer -->
<?php get_footer(); ?>