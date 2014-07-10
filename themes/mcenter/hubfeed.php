<?php header('Content-type: text/xml');echo '<?xml version="1.0" encoding="UTF-8"?>'."\n"; ?>
<galleries>
<?php query_posts('cat=15&posts_per_page=4'); ?>

<?php while (have_posts()) : the_post(); ?>
	<gallery>
    	<img><?php
//  container that holds thumb markup and starts the process  
//$thumb_markup = '';
global $post;
$thumb_markup = '';
$desc = get_post_meta($post->ID, 'feed_desc', true);
$thumb = get_post_meta($post->ID, 'thumbnail', true); ?>
<?php if(!empty($thumb)) { ?>
<?php $thumb_markup = generate_thumb($thumb); /* this function is in the themes functions.php */ ?>
src="<?php echo substr($thumb_markup['previous_url'], 0, -3);?>
<?php }?>
</img>
    	<title><?php the_title() ?></title>
        <desc><?php echo $desc; ?></desc>
        <url><?php the_permalink() ?></url>
	</gallery>
    <?php endwhile; ?>
</galleries>      