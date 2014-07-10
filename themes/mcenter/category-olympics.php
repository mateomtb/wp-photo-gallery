<?php get_header(); 
$theme_options = get_option('T_theme_options');
?>

<!-- Show the welcome box, slideshow, slider and magazine front only on first page.  Makes for better pagination. -->
<?php if ( $paged < 1 ) { ?>

<?php
//pull featured section
//$featured = get_option('T_featured');
//if(($featured) || (!$theme_options && !$featured)) { include ('subtheme/olympics/featured.php'); }
if (olympicsCheck()) include ('subtheme/olympics/featured.php');
?>
<!-- End Better Pagination -->
<?php } ?>

<?php
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
if (olympicsCheck())
{
	get_footer(oly);
}
else 
{
 get_footer();
}
?>

