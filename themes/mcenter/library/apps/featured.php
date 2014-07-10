<?php
//$timthumb = get_option('T_timthumb');
$featured_category = get_option('T_featured_category');
$featured_category_ID = get_cat_ID($featured_category);
?>
<!-- Begin featured -->
<div id="featured-section">
<div class="span-15 colborder home" <?php if ($_SESSION['siteconfig']["domain"] == "denverpost"){echo 'data-vr-zone="mediacenter_featured"';}?>>

<h3 class="sub"><?php echo "$featured_category"; ?></h3>
    <?php 
        $args = array(
                'posts_per_page' => 1,
                'post__in'  => get_option( 'sticky_posts' ),
                'ignore_sticky_posts' => 1
            );
        $featured_query = new WP_Query($args);
         while ($featured_query->have_posts()) : $featured_query->the_post();
        $do_not_duplicate = $post->ID; ?>
            <div class="post post-<?php the_ID(); ?>" <?php if ($_SESSION['siteconfig']["domain"] == "denverpost"){echo 'data-vr-contentbox=""';}?>>
                <div class="entry">
                    <h1><a href="<?php the_permalink() ?>" rel="bookmark" title="Permanent Link to <?php the_title_attribute(); ?>"><?php the_title(); ?></a></h1>
                    <p class="topdate">Posted <?php the_time('M d, Y') ?> | <?php $posttags = get_the_tags(); $mytag = getmy_tag($posttags); if ($mytag == "prep_championships") { ?></p><?php } else { ?><span class="tagcolor"><?php echo $mytag;//in functions php, returns the first tag name of a post ?></span></p><? } ?>
                    
                    
                    <!-- begin home page post image -->
<?php 


$thumb_markup = '';

if ( has_post_thumbnail()==true ) {
?> <a href="<?php the_permalink() ?>" rel="bookmark" title="Permanent Link to <?php the_title_attribute(); ?>"><?php the_post_thumbnail('featured-thumbnail'); ?> </a> <?php
}

$thumb = get_post_meta($post->ID, 'thumbnail', true);
$smugthumb = get_post_meta($post->ID, 'smugdata', true);?>

<?php if (!empty($smugthumb)) {?>
<div style="width:590px; overflow:hidden;">
<?php $thumb_markup =getSmugThumb($smugthumb); /* this function is in the shared functions plugin */ ?>
<a href="<?php the_permalink() ?>" rel="bookmark" title="Permanent Link to <?php the_title_attribute(); ?>"><img style="min-width:100%;" src="<?php echo $thumb_markup[0]["MediumURL"];?>"></a><br /></div>
<?php } elseif (empty($smugthumb) && !empty($thumb)) {
$thumb_markup = generate_thumb($thumb); /* this function is in the themes functions.php */ ?>
<a href="<?php the_permalink() ?>" rel="bookmark" title="Permanent Link to <?php the_title_attribute(); ?>"><img src="<?php echo $thumb_markup['mypreview_url'];?>></a><br />
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

<div class="span-8 last" <?php if ($_SESSION['siteconfig']["domain"] == "denverpost"){echo 'data-vr-zone="mediacenter_previous"';}?>>


<?php include (THEMELIB . '/functions/previousplogs.php'); ?>
    
    </div>
</div>
<hr />
