<?php get_header(); 
$theme_options = get_option('T_theme_options'); ?>


<div class="span-<?php $sidebar = get_option('T_sidebar'); if($sidebar || (!$theme_options && !$sidebar)) { echo "15 colborder home"; } else { echo "24 last"; } ?>">
<div <?php if(function_exists('post_class')) : ?><?php post_class(); ?><?php else : ?>class="post post-<?php the_ID(); ?>"<?php endif; ?>>
<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
	
    <?php $posttags = get_the_tags(); $mytag = getmy_tag($posttags); //get the post tag ?>
    <?php $category = get_the_category();  //get the post category ?>
    <?php $alldeeezcats2 = deeez_cats2($category); // category list m dash separated with underscore in multiple word cats?>
    <?php $alldeeezcats3 = deeez_cats3($category); // category id's seperated by commas for use in recent photos video at the bottom of the page?>
	<?php $thepagetag = strtolower($mytag . '_galleries'); ?>


<h1><?php the_title(); ?></h1>
<p class="topdate">Posted <?php the_time('M d, Y') ?></p>
<?php include(THEMELIB . '/functions/socialstuff.php'); ?>
<div style="clear:left;"></div>


<?php the_content(); ?>
</div>
<div class="clear"></div>
<div style="width:630px; float:left;">
<?php include (THEMELIB . '/functions/youmightlike.php'); ?>
<div class="clear"></div>

<p class="postmetadata alt">
					<small>
						This entry was posted
						<?php { ?>
						on <?php the_time('l, F jS, Y') ?> at <?php the_time() ?>
						and is filed under <?php the_category(', ') ?><?php if (get_the_tags()) the_tags(' and tagged with '); ?>.
						You can follow any responses to this entry through the <?php post_comments_feed_link('RSS 2.0'); ?> feed.

						<?php } edit_post_link('Edit this entry','','.'); ?>

					</small>
				</p>


<div class="navi prev left"><?php next_post_link('%link', '&larr;', TRUE); ?></div>
<div class="navi next right"><?php previous_post_link('%link', '&rarr;', TRUE); ?></div>
<div class="clear"></div>
			<?php endwhile; else : ?>

				<h2 class="center">Not Found</h2>
				<p class="center">Sorry, but you are looking for something that isn't here.</p>
				<?php get_search_form(); ?>

			<?php endif; ?>
<?php comments_template('', true); ?>
</div>

<?php
if ($alldeeezcats2==the_count) { ?>
<div class="adholder" style="float:right; width:300px; margin: 0px 0px 10px 10px;">
<?php  
}
else {
?>
<div class="adholder" style="float:right; width:300px; margin: -255px 0px 10px 10px;">
<?php } //echo "deezcats2 " . $alldeeezcats2; ?>
        <iframe src="<?php echo bloginfo('template_directory') . '/ads/photo350x200.html'; ?>?thepagetag=<?php echo $thepagetag ?>&thepagecat=<?php echo $alldeeezcats2; ?>" id="adpos9_iframe" name="adpos9_iframe" width="300" height="250" frameborder="0" marginheight="0" marginwidth="0" scrolling="no"></iframe>
        <div class="adElement" id="adPosition9" style="float:right;"><script type="text/javascript" language="JavaScript">yld_mgr.place_ad_here("adPos9");</script></div>	   
             
</div>
</div>




<!-- Begin Footer -->
<?php get_footer(); ?>