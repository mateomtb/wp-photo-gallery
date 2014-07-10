<?php get_header(); 
$theme_options = get_option('T_theme_options'); ?>



	
    <?php $posttags = get_the_tags(); $mytag = getmy_tag($posttags); //get the post tag ?>
    <?php $category = get_the_category();  //get the post category ?>
    <?php $alldeeezcats2 = deeez_cats2($category); // category list m dash separated with underscore in multiple word cats?>
    <?php $alldeeezcats3 = deeez_cats3($category); // category id's seperated by commas for use in recent photos video at the bottom of the page?>
	<?php $thepagetag = strtolower($mytag . '_galleries'); ?>

  
<div class="span-15">
<?php if (syndicationCheck('sbnation')) {?>
	<a href="<?php echo get_post_meta(get_the_ID(),'syndication_permalink', true);?>" target="blank"><h1><?php the_title(); ?></h1></a>
<?php } else { 
echo "<h1>";
the_title();
echo "</h1>";
}?>

<p class="the_author">by <span><?php the_author(); ?></span></p>
<p class="topdate">Posted <?php the_time('M d, Y') ?><?php edit_post_link( __( '  &raquo;&raquo;Edit', 'twentyeleven' ), '', '' ); ?></p>

<?php include(THEMELIB . '/functions/socialstuff.php'); ?>



<div id="olympics-article-container">

<?php 
if (syndicationCheck('sbnation')){?>
	<div id="sbnation-branding">
		<a href="http://www.sbnation.com" target="_blank"><img src="<?php echo bloginfo('template_directory') . '/images/sbn-footer-logo.png';  ?>" alt="SBNation.com" /></a>
	</div>
<?php } ?>




<!-- function that puts article content on page -->
<?php the_content(); ?>
<?php if (syndicationCheck('sbnation')){?> 
<p><a href="<?php echo get_post_meta(get_the_ID(),'syndication_permalink', true);?>" target="blank">View Original Story</a></p>




<!-- 5 SBNATION links -->
<div id="five_sblinks">
	<div id="sbnation-branding"><a href="http://www.sbnation.com" target="_blank"><img src="<?php echo bloginfo('template_directory') . '/images/sbn-footer-logo.png';  ?>" alt="SBNation.com" /></a></div>


<?php

if (function_exists('SimplePieWP')){

	echo "<div class='athlete-profiles sbnation sbrightrail'>";
	echo SimplePieWP('http://feeds.feedburner.com/rss/current/london-olympics-2012', $rsswidg_default_settings); 
	echo "</div>";
	}
	
?>
</div>		
<?php }?>






<!-- POST META DATA GRAY-BAR -->
<div class="clear"></div>

<p class="postmetadata"><?php the_time('M d, Y') ?> | Categories: <?php if (the_category(', '))  the_category(); ?> <?php if (get_the_tags()) the_tags('| Tags: '); ?> | <?php echo '<span class="leavecomment">'; comments_popup_link('Leave A Comment &#187;', '1 Comment &#187;', '% Comments &#187;'); echo '</span>'; ?> <?php edit_post_link('Edit', '| ', ''); ?> </p>
<?php comments_template('', true); ?>

<div class="navi prev left"><?php next_post_link('%link', '&larr;', TRUE); ?></div>
<div class="navi next right"><?php previous_post_link('%link', '&rarr;', TRUE); ?></div>
<div class="clear"></div>




<?php 
if (syndicationCheck('sbnation'))
{
	if ( function_exists('bleacher_report_top') ) bleacher_report_top();
}
?>

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
jQuery('span.leavecomment a, .reply a.comment-reply-link').click(function(){
// slide toggle effect set to slow you can set it to fast too.
jQuery('#respond').slideDown('slow');
return false;
});

jQuery('.top_stories_right').hide();
jQuery('.span-8 .sbrightrail').hide();

</script>

