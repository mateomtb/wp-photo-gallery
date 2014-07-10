<?php
/*
Template Name: Video
*/
?>

<?php get_header(); 
$theme_options = get_option('T_theme_options'); ?>


<div class="span-special">
<div <?php if(function_exists('post_class')) : ?><?php post_class(); ?><?php else : ?>class="post post-<?php the_ID(); ?>"<?php endif; ?>>
<?php if (have_posts()) : while (have_posts()) : the_post(); ?>


<?php include (THEMELIB . '/apps/multimedia.php'); ?>
<p><?php echo gPPGetVideo($post->ID); ?></p>

<h1><?php the_title(); ?></h1>
<p class="topdate">Posted <?php the_time('M d, Y') ?></p>
<?php include(THEMELIB . '/functions/socialstuff.php'); ?>
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
<div class="span-8 last">
<?php include (THEMELIB . '/apps/ad-sidebar.php'); ?>
<?php include (THEMELIB . '/functions/previousplogs.php'); ?>
	
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

<?php $sidebar = get_option('T_sidebar'); if($sidebar || (!$theme_options && !$sidebar)) { get_sidebar(); } ?>

<!-- Begin Footer -->
<?php get_footer(); ?>