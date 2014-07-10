

<?php get_header(); 
$theme_options = get_option('T_theme_options'); ?>

<div style="min-height:1750px!important;" class="span-<?php $sidebar = get_option('T_sidebar'); if($sidebar || (!$theme_options && !$sidebar)) { echo "15 colborder home"; } else { echo "24 last"; } ?>">
<div <?php if(function_exists('post_class')) : ?><?php post_class(); ?><?php else : ?>class="post post-<?php the_ID(); ?>"<?php endif; ?>>
<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
	
    <?php $posttags = get_the_tags(); $mytag = getmy_tag($posttags); //get the post tag ?>
    <?php $category = get_the_category();  //get the post category ?>
    <?php $alldeeezcats2 = deeez_cats2($category); // category list m dash separated with underscore in multiple word cats?>
    <?php $alldeeezcats3 = deeez_cats3($category); // category id's seperated by commas for use in recent photos video at the bottom of the page?>
	<?php $thepagetag = strtolower($mytag . '_galleries'); ?>
<!--disable this unless needed	
<div class="adholder" align="center" style="margin-top:10px;min-height:100px;">
-->

<?php
echo "<h1>";
the_title();
echo "</h1>";
?>
<p class="the_author">by <span><?php the_author(); ?></span></p>
<p class="topdate">Posted <?php the_time('M d, Y') ?><?php edit_post_link( __( '  &raquo;&raquo;Edit', 'twentyeleven' ), '', '' ); ?></p>


<?php include(THEMELIB . '/functions/socialstuff.php'); ?>
<div class="clear"></div>

<?php the_content(); ?>

<p>
<!-- POST META DATA GRAY-BAR -->
<div class="clear"></div>

<p class="postmetadata"><?php the_time('M d, Y') ?> | Categories: <?php if (the_category(', '))  the_category(); ?> <?php if (get_the_tags()) the_tags('| Tags: '); ?> | <?php echo '<span class="leavecomment">'; comments_popup_link('Leave A Comment &#187;', '1 Comment &#187;', '% Comments &#187;'); echo '</span>'; ?> <?php edit_post_link('Edit', '| ', ''); ?> </p>
<?php comments_template('', true); ?>
</div>



<div class="clear"></div>
<div style="width:950px; float:left;position:relative;margin-top:50px!important;">


<?php
if ( function_exists('bleacher_report_top') ) bleacher_report_top();
?>	


<div id="mpav" style="position:relative;height:auto;width:950px;display:block;">
<?php include(TEMPLATEPATH . '/subtheme/olympics/five.php'); ?>
</div>
<div class="clear"></div>


			<?php endwhile; else : ?>

				<h2 class="center">Not Found</h2>
				<p class="center">Sorry, but you are looking for something that isn't here.</p>
				<?php get_search_form(); ?>

			<?php endif; ?>

</div>
</div>



</div>
</div>



<!-- Begin Footer -->
<?php get_footer(oly); ?>



<script type="text/javascript">

//Hide the tooglebox when page load
jQuery('#respond').hide();
//slide up and down when hover over heading 2
jQuery('span.leavecomment a, .reply a.comment-reply-link').click(function(){
// slide toggle effect set to slow you can set it to fast too.
jQuery('#respond').slideDown('slow');
return false;
});

</script>
