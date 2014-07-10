<?php
//$timthumb = get_option('T_timthumb');
$featured_category = get_option('T_featured_category');
$featured_category_ID = get_cat_ID($featured_category);
?>

<!-- Begin featured -->

<?php $featured_query = new WP_Query("cat=-88,-101&showposts=1"); ?>
	<?php while ($featured_query->have_posts()) : 
		$featured_query->the_post();
		$do_not_duplicate = $post->ID; ?>
		
		<div data-role="content">
			<h2><?php the_title(); ?></h2>
            <p class="topdate">Posted <?php the_time('M d, Y') ?> | <?php $posttags = get_the_tags(); $mytag = getmy_tag($posttags); if ($mytag == "prep_championships") { ?></p><?php } else { ?><span class="tagcolor"><?php echo $mytag;//in functions php, returns the first tag name of a post ?></span></p><? } ?>
            
            
            <!-- begin home page post image -->
<?php 
$thumb_markup = '';
if ( has_post_thumbnail()==true ) { ?>
	<a href="<?php the_permalink() ?>" rel="bookmark" title="Permanent Link to <?php the_title_attribute(); ?>">
		<?php the_post_thumbnail('featured-thumbnail'); ?> </a>

<?php
}
$thumb = get_post_meta($post->ID, 'thumbnail', true);
?>

<?php if(!empty($thumb)) { ?>
	<?php $thumb_markup = generate_thumb($thumb); /* this function is in the themes functions.php */ ?>
	<a href="<?php the_permalink() ?>" rel="bookmark" title="Permanent Link to <?php the_title_attribute(); ?>">
		<img src="<?php echo $thumb_markup['iphone_feature_url'];?></a><br /><br />
<?php } ?>
<!-- end home page post image -->  

					<?php the_content(); ?>
				</div>
				<div class="clear"></div>
				<p class="postmetadata"><?php the_time('M d, Y') ?> | Categories: <?php if (the_category(', '))  the_category(); ?> <?php if (get_the_tags()) the_tags('| Tags: '); ?> | <?php comments_popup_link('Leave A Comment &#187;', '1 Comment &#187;', '% Comments &#187;'); ?> <?php edit_post_link('Edit', '| ', ''); ?> </p>
		</div>
	<?php endwhile; wp_reset_query(); ?>
	<div class="clear"></div>
	


</div>

<div class="span-8 last">

<?php //include (THEMELIB . '/functions/previousplogs.php'); ?>
	
	</div>
</div>
<hr />