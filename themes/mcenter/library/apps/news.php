<script type="text/javascript">
	jQuery(document).ready(function(){
		jQuery('#tabs').tabs();
	});
</script>
		
<!--BEGIN FEATURED POST-->
<div class="span-15 colborder">
<div id="feature" class="column span-10 colborder">

<?php
$news_cat_1 = get_option('T_news_tab_1');
$news_cat_2 = get_option('T_news_tab_2');
$news_cat_3 = get_option('T_news_tab_3');
$news_cat_4 = get_option('T_news_tab_4');

if(!$news_cat_1) {$news_cat_1 = "uncategorized";}
if(!$news_cat_2) {$news_cat_2 = "uncategorized";}
if(!$news_cat_3) {$news_cat_3 = "uncategorized";}
if(!$news_cat_4) {$news_cat_4 = "uncategorized";}

$news_cat_1_ID = get_cat_ID($news_cat_1);
$news_cat_2_ID = get_cat_ID($news_cat_2);
$news_cat_3_ID = get_cat_ID($news_cat_3);
$news_cat_4_ID = get_cat_ID($news_cat_4);

$categories_stack = array();

if($news_cat_1 != "") {array_push($categories_stack,"$news_cat_1_ID");}
if($news_cat_2 != "") {array_push($categories_stack,"$news_cat_2_ID");}
if($news_cat_3 != "") {array_push($categories_stack,"$news_cat_3_ID");}
if($news_cat_4 != "") {array_push($categories_stack,"$news_cat_4_ID");}

?>

<div id="tabs">
    <ul>
    
<?php $i = 0;
    foreach ($categories_stack as $category) {
        $cat_num = count($categories_stack); 
$i++; ?>

<?php query_posts("showposts=1&cat=$category"); ?>
    <?php while (have_posts()): the_post(); ?>
            <li><a href="#<?php single_cat_title(); ?>"><?php single_cat_title(); ?></a></li>
    <?php endwhile;?>
<?php } ?>
    </ul>

<?php $i = 0;
    foreach ($categories_stack as $category) {
        $cat_num = count($categories_stack); 
$i++; ?>
    
<?php query_posts("showposts=1&cat=$category"); ?>
    <?php while (have_posts()): the_post(); ?>
    <div id="<?php single_cat_title(); ?>">
    <h6 class="sub"><a href="<?php the_permalink() ?>" rel="bookmark" title="Permanent Link to <?php the_title_attribute(); ?>"><?php the_title() ?></a></h6>
    <?php if(postattachment()) { //check if image is on the post
			if($timthumb || (!$theme_options && !$timthumb)) { // check if timthumb is on ?>
                <a href="<?php the_permalink() ?>" rel="bookmark" title="Permanent Link to <?php the_title_attribute(); ?>"><img src="<?php bloginfo( 'template_directory' ); ?>/library/functions/timthumb.php?src=<?php imagepath(); ?>&amp;w=150&amp;h=150&amp;zc=1" alt="<?php the_title(); ?>" class="attachment-thumbnail" /></a>
			<?php } else { postimage('thumbnail'); } }?>
            <p class="byline"><?php the_time('M d, Y') ?> | <?php comments_popup_link('No Comments', '1 Comment', '% Comments'); ?></p>
            <p><?php echo substr(get_the_excerpt(),0,175); ?>... <span class="read_more"><a href="<?php the_permalink(); ?>">[ More ]</a></span></p>
    <?php endwhile;?>
<h6 class="alignright"><a href="<?php echo get_category_link($category);?>">More in <?php single_cat_title(); ?></a></h6>
<div class="clear"></div>
</div>
<?php } ?>
</div>
<hr />
<ul>
<?php
global $post;
$myposts = get_posts('numberposts=3&offset=4');
foreach($myposts as $post) :
setup_postdata($post);
?>
<li><h6><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h6>
<p class="byline"><?php the_time('M d, Y') ?> | by <?php the_author_posts_link(); ?> | <?php comments_popup_link('No Comments', '1 Comment', '% Comments'); ?></p>
<p><?php echo substr(get_the_excerpt(),0,175); ?>... <span class="read_more"><a href="<?php the_permalink(); ?>">[ More ]</a></span></p>
</li>
<?php endforeach; ?>
</ul>
<hr />
<ul>
<?php
global $post;
$myposts = get_posts('numberposts=5&offset=8');
foreach($myposts as $post) :
setup_postdata($post);
?>
<li><h6><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a><span class="meta"> | <?php the_time('M j, Y') ?> | <?php comments_popup_link('No Comments', '1 Comment', '% Comments'); ?></span></h6></li>
<?php endforeach; ?>
</ul>
</div>

<!-- TOP MIDDLE BOX -->
<div id="midcol" class="column span-4 last">
<?php if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar('Homepage Middle Column') ) : ?>
<?php endif; ?>
</div>
<hr />
<?php include (THEMELIB . '/apps/ad-main.php'); ?>
</div>

<!-- TOP RIGHT BOX -->
<div class="column span-8 last">
<div id="home_right">
<h3>Previously Featured</h3>
 <?php $i == 0; ?>
 	<?php 
 		$news_offset_query = new WP_Query("category_name='$news_category'&showposts=3&offset=1"); ?>
 	<?php while ($news_offset_query->have_posts()) : $news_offset_query->the_post(); $i++;
 		$do_not_duplicate = $post->ID; ?>
 			<div <?php if(function_exists('post_class')) : ?><?php post_class(); ?><?php else : ?>class="post post-<?php the_ID(); ?>"<?php endif; ?>>
 			<?php 
 			if(postattachment()) { //check if image is on the post
 			if($timthumb || (!$theme_options && !$timthumb)) { // check if timthumb is on ?>
 <a href="<?php the_permalink() ?>" rel="bookmark" title="Permanent Link to <?php the_title_attribute(); ?>"><img src="<?php bloginfo( 'template_directory' ); ?>/library/functions/timthumb.php?src=<?php imagepath(); ?>&amp;w=150&amp;h=150&amp;zc=1" alt="<?php the_title(); ?>" class="attachment-thumbnail" /></a>
 			<?php } else { postimage('thumbnail'); } }?>
 			<h6><a href="<?php the_permalink() ?>" rel="bookmark" title="Permanent Link to <?php the_title_attribute(); ?>"><?php the_title() ?></a></h6>
 			<p class="byline"><?php the_time('M d, Y') ?> | <a href="<?php the_permalink(); ?>">Read </a> | <?php comments_popup_link('Discuss', '1 Comment', '% Comments'); ?></p>
 			<p><?php echo substr(get_the_excerpt(),0,100); ?></p>
 			</div>
 			<hr />
 	<?php endwhile; ?>
 	<?php $i == 0; ?>
 	<?php include (THEMELIB . '/apps/ad-sidebar.php'); ?>
<!-- EXTRA BOX -->
<div class="box">
<h6>About <?php bloginfo('name'); ?></h6>
<p class="small"><?php bloginfo('description'); ?></p>
</div>
</div>
</div>
<hr />
