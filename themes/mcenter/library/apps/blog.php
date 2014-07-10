<?php
$blog_category = get_option('T_blog_category');
?>
<!-- Begin blog -->
<div id="blog-section">
<div class="span-<?php $sidebar = get_option('T_sidebar'); if($sidebar || (!$theme_options && !$sidebar)) { echo "15 colborder home"; } else { echo "24 last"; } ?>">
<h3 class="sub"><?php echo "$blog_category"; ?></h3>
	<?php $blog_query = new WP_Query("category_name='$blog_category'&showposts=6"); $b == 0; ?>
	<?php while ($blog_query->have_posts()) : $blog_query->the_post();
		$do_not_duplicate = $post->ID; ?>
		<?php $b++; ?>
			<div <?php if(function_exists('post_class')) : ?><?php post_class(); ?><?php else : ?>class="post post-<?php the_ID(); ?>"<?php endif; ?>>
				<h2><a href="<?php the_permalink() ?>" rel="bookmark" title="Permanent Link to <?php the_title_attribute(); ?>"><?php the_title(); ?></a></h2>
				<div class="entry">
					<?php include (THEMELIB . '/apps/multimedia.php'); ?>
                    <p><?php echo gPPGetVideo($post->ID); ?></p>
					<?php the_content(); ?>
					<?php if ($b == 1) { ?>
					<?php include (THEMELIB . '/apps/ad-main.php'); ?>
					<?php } ?>
				</div>
				<div class="clear"></div>
				<p class="postmetadata"><?php the_time('M d, Y') ?> | Categories: <?php if (the_category(', '))  the_category(); ?> <?php if (get_the_tags()) the_tags('| Tags: '); ?> | <?php comments_popup_link('Leave A Comment &#187;', '1 Comment &#187;', '% Comments &#187;'); ?> <?php edit_post_link('Edit', '| ', ''); ?> </p>
			</div>
		<div class="clear"></div>
		
		<?php endwhile; wp_reset_query(); $b == 0; ?>
		
		<div class="nav">
			<div class="alignleft"><?php next_posts_link('&laquo; Older Entries') ?></div>
			<div class="alignright"><?php previous_posts_link('Newer Entries &raquo;') ?></div>
		</div>
		<div class="clear"></div>

</div>
</div>
<?php $sidebar = get_option('T_sidebar'); if($sidebar || (!$theme_options && !$sidebar)) { get_sidebar(); } ?>
<hr />