<?php get_header(); rewind_posts(); 

$theme_options = get_option('T_theme_options'); ?>
<div class="span-<?php $sidebar = get_option('T_sidebar'); if($sidebar || (!$theme_options && !$sidebar)) { echo "15 colborder home"; } else { echo "24 last"; } ?>">

		<?php 
		query_posts($query_string.'&posts_per_page=10');
		if (have_posts()) : ?>

 	  <?php $post = $posts[0]; // Hack. Set $post so that the_date() works. ?>
 	  <?php /* If this is a category archive */ if (is_category()) { ?>
		<h3 class="sub"><?php single_cat_title(); ?></h3>
 	  <?php /* If this is a tag archive */ } elseif( is_tag() ) { ?>
		<h3 class="sub">Posts Tagged &#8216;<?php single_tag_title(); ?>&#8217;</h3>
 	  <?php /* If this is a daily archive */ } elseif (is_day()) { ?>
		<h3 class="sub">Archive for <?php the_time('F jS, Y'); ?></h3>
 	  <?php /* If this is a monthly archive */ } elseif (is_month()) { ?>
		<h3 class="sub">Archive for <?php the_time('F, Y'); ?></h3>
 	  <?php /* If this is a yearly archive */ } elseif (is_year()) { ?>
		<h3 class="sub">Archive for <?php the_time('Y'); ?></h3>
	  <?php /* If this is an author archive */ } elseif (is_author()) { ?>
		<h3 class="sub">Author Archive</h3>
 	  <?php /* If this is a paged archive */ } elseif (isset($_GET['paged']) && !empty($_GET['paged'])) { ?>
		<h3 class="sub">Blog Archives</h3>
 	  <?php } ?>
<div class="clear"></div>

<div class="contentarchive"> <!-- <div class="content"> -->

<?php while (have_posts()) : the_post(); ?>
<div <?php if(function_exists('post_class')) : ?><?php post_class(); ?><?php else : ?>class="post post-<?php the_ID(); ?>"<?php endif; ?>>
<h2 style="margin-bottom:0;"><a href="<?php the_permalink() ?>" rel="bookmark" title="Permanent Link to <?php the_title_attribute(); ?>"><?php the_title() ?></a></h2>
<p class="byline"><?php the_time('M d, Y') ?> | <span class="tagcolor"><?php $posttags = get_the_tags(); $mytag = getmy_tag($posttags);

switch ($mytag) {
    case "special_project":
        echo "Special Project"; ?></span></p><?php
        break;
    case "prep_championships":
        ?></span></p><?php
        break;
	case "Photo":
		echo "Photo"; ?></span></p><?php
		break;
	case "Video":
		echo "Video"; ?></span></p><?php
		break;	
}

?>



<!-- begin thumbs -->
<?php
//  container that holds thumb markup and starts the process  
$thumb_markup = '';

if ( has_post_thumbnail()==true ) {
the_post_thumbnail('previous-thumbnail', array('class' => 'archive-thumbnail', 'alt' => 'alttext'));
}


$thumb = get_post_meta($post->ID, 'thumbnail', true);
$smugthumb = get_post_meta($post->ID, 'smugdata', true);?>

<?php if (!empty($smugthumb)) {
$thumb_markup = getSmugThumb($smugthumb); /* this function is in the shared functions plugin */ ?>
<a href="<?php the_permalink() ?>" rel="bookmark" title="Permanent Link to <?php the_title_attribute(); ?>"><img class="archive-thumbnail"width=114 height=114 src="<?php echo $thumb_markup[0]["ThumbURL"];?>"></a>
<?php } elseif (empty($smugthumb) && !empty($thumb)) {
$thumb_markup = generate_thumb($thumb); /* this function is in the themes functions.php */ ?>
<a href="<?php the_permalink() ?>" rel="bookmark" title="Permanent Link to <?php the_title_attribute(); ?>"><img class="archive-thumbnail" src="<?php echo $thumb_markup['previous_url'];?></a>
<?php }


if ( $mytag == "special_project" || "prep_championship" ) {
	$menudesc = get_post_meta($post->ID, 'menu_description', true);
		if(!empty($menudesc)) { ?> 
		<a href="<?php the_permalink() ?>"><p><?php echo $menudesc ?></p></a>
		<?php }      
 } 
 
 if ( $mytag == "Photo" || "Video" ) {
	 the_excerpt();
	 }
 ?>
 




<!-- end thumbs -->    

   
<div class="clear"></div>
<p class="postmetadata"><?php the_time('M d, Y') ?> | Categories: <?php if (the_category(', '))  the_category(); ?> <?php if (get_the_tags()) the_tags('| Tags: '); ?> | <?php comments_popup_link('Leave A Comment &#187;', '1 Comment &#187;', '% Comments &#187;'); ?> <?php edit_post_link('Edit', '| ', ''); ?> </p>
</div>
<hr />
<?php endwhile; ?>

<div class="clear"></div>

<div class="nav-interior">
			<div class="prev"><?php next_posts_link('&laquo; Older Entries') ?></div>
			<div class="next"><?php previous_posts_link('Newer Entries &raquo;') ?></div>
		</div>
<div class="clear"></div>

	<?php else : ?>

		<h2 class="center">Not Found</h2>
		<?php get_search_form(); ?>

	<?php endif; ?>
</div>

<div class="span-8 last">
<?php include (THEMELIB . '/functions/previousplogs.php'); ?>
</div>

</div>
</div>
		
<?php $sidebar = get_option('T_sidebar'); if($sidebar || (!$theme_options && !$sidebar)) { get_sidebar(); } ?>

<!-- Begin Footer -->
<?php get_footer(); ?>
