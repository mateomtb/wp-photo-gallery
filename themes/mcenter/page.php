<?php get_header(); 
$theme_options = get_option('T_theme_options'); ?>
<div class="span-<?php $sidebar = get_option('T_sidebar'); if($sidebar || (!$theme_options && !$sidebar)) { echo "15 colborder home"; } else { echo "24 last"; } ?>">
<div class="content">
		<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
		<div <?php if(function_exists('post_class')) : ?><?php post_class(); ?><?php else : ?>class="post post-<?php the_ID(); ?>"<?php endif; ?>>
			<h2><?php the_title(); ?></h2>
			<?php include (THEMELIB . '/apps/multimedia.php'); ?>
			<p><?php echo gPPGetVideo($post->ID); ?></p>
			<?php the_content('<p class="serif">Read the rest of this page &raquo;</p>'); ?>
			<?php wp_link_pages(array('before' => '<p><strong>Pages:</strong> ', 'after' => '</p>', 'next_or_number' => 'number')); ?>
		</div>
		<?php endwhile; endif; ?>
	<?php edit_post_link('Edit this entry.', '<p>', '</p>'); ?>
	</div>
	</div>
	
<?php $sidebar = get_option('T_sidebar'); if($sidebar || (!$theme_options && !$sidebar)) { get_sidebar(); } ?>

<!-- Begin Footer -->
<?php get_footer(); ?>