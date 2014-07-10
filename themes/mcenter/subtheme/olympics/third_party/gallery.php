

<?php get_header(); 
$theme_options = get_option('T_theme_options'); ?>

<div style="min-height:1750px!important;" class="span-<?php $sidebar = get_option('T_sidebar'); if($sidebar || (!$theme_options && !$sidebar)) { echo "15 colborder home"; } else { echo "24 last"; } ?>">
<div <?php if(function_exists('post_class')) : ?><?php post_class(); ?><?php else : ?>class="post post-<?php the_ID(); ?>"<?php endif; ?>>
<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
	
    <?php $posttags = get_the_tags(); $mytag = getmy_tag($posttags); //get the post tag ?>
    <?php $category = get_the_category();  //get the post category ?>
    <?php $alldeeezcats2 = deeez_cats2($category); // category list m dash separated with underscore in multiple word cats?>
    <?php $alldeeezcats3 = deeez_cats3($category); // category id's seperated by commas for use in recent photos video at the bottom of the page?>
	<?php $thepagetag = strtolower($mytag . '_galleries'); ?>
<!--disable this unless needed	
<div class="adholder" align="center" style="margin-top:10px;min-height:100px;">
-->
<h1><?php the_title(); ?></h1>
<p class="topdate">Posted <?php the_time('M d, Y') ?><?php edit_post_link( __( '  &raquo;&raquo;Edit', 'twentyeleven' ), '', '' ); ?></p>
By <?php 

the_author(); ?>
<?php include(THEMELIB . '/functions/socialstuff.php'); ?>

<?php the_content(); ?>
</div>
<div class="clear"></div>
<div style="width:950px; float:left;">
	
<?php
if ( function_exists('bleacher_report_top') ) bleacher_report_top();
?>	


<div id="mpav" style="position:relative;height:auto;width:950px;display:block;">
<?php include(TEMPLATEPATH . '/subtheme/olympics/five.php'); ?>
</div>
<div class="clear"></div>


			<?php endwhile; else : ?>

				<h2 class="center">Not Found</h2>
				<p class="center">Sorry, but you are looking for something that isn't here.</p>
				<?php get_search_form(); ?>

			<?php endif; ?>
<?php comments_template('', true); ?>
</div>
</div>



</div>
</div>



<!-- Begin Footer -->
<?php get_footer(oly); ?>
