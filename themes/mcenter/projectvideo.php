!--<?php
/*
Template Name: Video Project
*/
?>

<?php get_header(); 
//$theme_options = get_option('T_theme_options'); ?>


<div class="span-24 last">
<div <?php if(function_exists('post_class')) : ?><?php post_class(); ?><?php else : ?>class="post post-<?php the_ID(); ?>"<?php endif; ?>>
<?php if (have_posts()) : while (have_posts()) : the_post(); ?>



<?php //include (THEMELIB . '/apps/multimedia.php'); ?>
<p><?php echo gPPGetVideo($post->ID); ?></p>

<h1><?php the_title(); ?></h1>
<p class="topdate">Posted <?php the_time('M d, Y') ?></p>
<ul class="sociallinks">
<li>
<a href="http://www.addthis.com/bookmark.php" class="addthis_button"><img style="float:left; padding-right:7px;" src="<?php echo bloginfo('template_directory') . '/images/smplus.png'; ?>" width="16" height="16" border="0" alt="Share" /><h4 style="width:160px;">Share This Gallery</h4></a>
            <script type="text/javascript" src="http://s7.addthis.com/js/250/addthis_widget.js"></script>
</li>
<li>
<a href="http://twitter.com/share?url=<?php the_permalink(); ?>"
class="twitter-share-button">Tweet</a><script type="text/javascript"
src="http://platform.twitter.com/widgets.js"></script>
</li>
<li style="margin:-3px 0px 0px 0px;">
<iframe src="http://www.facebook.com/plugins/like.php?href=<?php the_permalink() ?>&amp;layout=standard&amp;show_faces=true&amp;width=450&amp;action=recommend&amp;colorscheme=light&amp;height=80" scrolling="no" frameborder="0" style="border:none; overflow:hidden; width:300px; height:80px;" allowTransparency="true"></iframe>
</li>

</ul>
<div style="clear:left;"></div>
<?php the_content(); ?>
</div>

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
</div>
<div class="clear"></div>
<div class="span-24">
			<?php endwhile; else : ?>

				<h2 class="center">Not Found</h2>
				<p class="center">Sorry, but you are looking for something that isn't here.</p>
				<?php get_search_form(); ?>

			<?php endif; ?>
<?php comments_template('', true); ?>
<?php include (THEMELIB . '/apps/ad-main.php'); ?>
</div>



<!-- Begin Footer -->
<?php get_footer(); ?>