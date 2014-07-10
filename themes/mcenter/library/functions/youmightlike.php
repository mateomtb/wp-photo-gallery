<h3 class="sub">More Photos and Videos</h3>
<ul class="yml">
<?php $backup = $post; $i == 0; ?>
	<?php 
		$featured_offset_query = new WP_Query("cat=" . $category[0]->cat_ID . "&showposts=6&offset=1"); ?>
	<?php while ($featured_offset_query->have_posts()) : $featured_offset_query->the_post(); $i++;
		$do_not_duplicate = $post->ID; ?>
        <li>
			<div <?php if(function_exists('post_class')) : ?><?php post_class(); ?><?php else : ?>class="post post-<?php the_ID(); ?>"<?php endif; ?>>
            <div class="previouswrapper">
			
	  
<?php    
//  container that holds thumb markup and starts the process 
$thumb_markup = '';

if ( has_post_thumbnail()==true ) {
the_post_thumbnail('previous-thumbnail');
}

$thumb = get_post_meta($post->ID, 'thumbnail', true);
$smugthumb = get_post_meta($post->ID, 'smugdata', true);?>

<?php if (!empty($smugthumb)) {
$thumb_markup = getSmugThumb($smugthumb); /* this function is in the shared functions plugin */ ?>
<a href="<?php the_permalink() ?>" rel="bookmark" title="Permanent Link to <?php the_title_attribute(); ?>"><img class="archive-thumbnail"width=114 height=114 src="<?php echo $thumb_markup[0]["ThumbURL"];?>"></a>
<?php } elseif (empty($smugthumb) && !empty($thumb)) {
$thumb_markup = generate_thumb($thumb); /* this function is in the themes functions.php */ ?>
<a href="<?php the_permalink() ?>" rel="bookmark" title="Permanent Link to <?php the_title_attribute(); ?>"><img class="archive-thumbnail" src="<?php echo $thumb_markup['previous_url'];?></a>
<?php } ?>

			<h6><a href="<?php the_permalink() ?>" rel="bookmark" title="Permanent Link to <?php the_title_attribute(); ?>"><?php the_title() ?></a></h6>
			<a href="<?php the_permalink() ?>" rel="bookmark" title="Permanent Link to <?php the_title_attribute(); ?>"><p class="byline"><?php the_time('M d, Y') ?> | <?php $posttags = get_the_tags(); $mytag = getmy_tag($posttags); if ($mytag == "prep_championships") { ?></p><?php } else { ?><span class="tagcolor"><?php echo $mytag;//in functions php, returns the first tag name of a post ?></span></p><? } ?></a>
			<p><?php echo preg_replace('/(https?:\/\/bcove.me\/[A-Za-z0-9]+)/','', substr(get_the_excerpt(),0,115)); ?></p> <!-- set lenght of text and remove brightcove embed url (see brightcoveEmbed plugin-->
            </div>
			</div>
            </li>
			
	<?php endwhile; ?>
	<?php $i == 0; ?>
</ul>
<?php
$post = $backup;  // copy it back
wp_reset_query(); // to use the original query again
?>
