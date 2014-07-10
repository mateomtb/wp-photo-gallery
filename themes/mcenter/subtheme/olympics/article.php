<?php get_header(); 
$theme_options = get_option('T_theme_options'); ?>



	
    <?php $posttags = get_the_tags(); $mytag = getmy_tag($posttags); //get the post tag ?>
    <?php $category = get_the_category();  //get the post category ?>
    <?php $alldeeezcats2 = deeez_cats2($category); // category list m dash separated with underscore in multiple word cats?>
    <?php $alldeeezcats3 = deeez_cats3($category); // category id's seperated by commas for use in recent photos video at the bottom of the page?>
	<?php $thepagetag = strtolower($mytag . '_galleries'); ?>

   
<div class="span-15">
<?php
echo "<h1>";
the_title();
echo "</h1>";
?>
<p class="the_author">by <span><?php the_author(); ?></span></p>
<p class="topdate">Posted <?php the_time('M d, Y') ?><?php edit_post_link( __( '  &raquo;&raquo;Edit', 'twentyeleven' ), '', '' ); ?></p>

<?php include(THEMELIB . '/functions/socialstuff.php'); ?>



<div id="olympics-article-container">

<!-- function that puts article content on page -->
<?php the_content(); ?>

<!-- POST META DATA GRAY-BAR -->
<div class="clear"></div>

<p class="postmetadata"><?php the_time('M d, Y') ?> | Categories: <?php if (the_category(', '))  the_category(); ?> <?php if (get_the_tags()) the_tags('| Tags: '); ?> | <?php echo '<span class="leavecomment">'; comments_popup_link('Leave A Comment &#187;', '1 Comment &#187;', '% Comments &#187;'); echo '</span>'; ?> <?php edit_post_link('Edit', '| ', ''); ?> </p>
<?php comments_template('', true); ?>



<div class="navi prev left"><?php next_post_link('%link', '&larr;', TRUE); ?></div>
<div class="navi next right"><?php previous_post_link('%link', '&rarr;', TRUE); ?></div>
<div class="clear"></div>
		

<!-- latest galleries include -->
<?php include(TEMPLATEPATH . '/subtheme/olympics/three.php'); ?>


</div>
<!-- closing div for olympics-article-container -->


</div>
<!--end of span-15 column -->

<div id="olympics-rightrail">
<?php include(TEMPLATEPATH . '/subtheme/olympics/right_rail.php'); ?>
</div>

<!-- end inner-container -->
</div> 
<!-- end container --> 
</div>



<?php get_footer(oly); ?>


<script type="text/javascript">

//Hide the tooglebox when page load
jQuery('#respond').hide();
//slide up and down when hover over heading 2
jQuery('span.leavecomment a:eq(0)').click(function(){
// slide toggle effect set to slow you can set it to fast too.
jQuery('#respond').slideDown('slow');
return false;
});
</script>


