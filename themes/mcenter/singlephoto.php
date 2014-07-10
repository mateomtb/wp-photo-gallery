<?php 
get_header(); 

$theme_options = get_option('T_theme_options'); ?>


<div class="span-<?php $sidebar = get_option('T_sidebar'); if($sidebar || (!$theme_options && !$sidebar)) { echo "15 colborder home"; } else { echo "24 last"; } ?>">
<div <?php if(function_exists('post_class')) : ?><?php post_class(); ?><?php else : ?>class="post post-<?php the_ID(); ?>"<?php endif; ?>>
<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
	
    <?php $posttags = get_the_tags(); $mytag = getmy_tag($posttags); //get the post tag ?>
    <?php $category = get_the_category();  //get the post category ?>
    <?php $alldeeezcats2 = deeez_cats2($category); // category list m dash separated with underscore in multiple word cats?>
    <?php $alldeeezcats3 = deeez_cats3($category); // category id's seperated by commas for use in recent photos video at the bottom of the page?>
	<?php $thepagetag = strtolower($mytag . '_galleries'); ?>

<?php //load top banner ad.

if ($_SESSION['siteconfig']["ad_server_on_mc"] == "apt") {
		switch ($_SESSION['parent_company']){
			case("jrc"):?>
				<div style="margin: 5px 0px 3px 0px; height:110px;"><div style="float:left; margin: 0px 10px 0px 0px; padding-top: 10px; width: 728px;"><script type="text/javascript" language="JavaScript">yld_mgr.place_ad_here("top_slot");</script></div><div style="float: left; height: 102px; margin-top; 5px; width: 200px;"><script type="text/javascript" language="JavaScript">yld_mgr.place_ad_here("topright_slot");</script></div></div>
				<?php break;
			case("mngi"):?>
				<div class="adholder" align="center" style="margin-top:10px;min-height:100px;"><div class="adElement" id="adPosition14"><script type="text/javascript" language="JavaScript">yld_mgr.place_ad_here("adPos14");</script></div></div>
				<?php break;
		}
	} elseif ($_SESSION['siteconfig']["ad_server_on_mc"] == "dfp") {?>
    	<div align="center" style="margin-top:10px;min-height:100px;">
		<!-- Beginning Sync AdSlot 2 [[728,90]]  -->
		<div id='top_leaderboard'>
		<script type='text/javascript'>
		googletag.display('top_leaderboard');
		</script>
		</div>
		<!-- End AdSlot 2 -->
    	</div>
    <?php } ?>

<h1><?php the_title(); ?></h1>
<p class="topdate">Posted <?php the_time('M d, Y') ?><?php edit_post_link( __( '  &raquo;&raquo;Edit', 'twentyeleven' ), '', '' ); ?></p>
By <?php 

the_author(); ?>
<?php include(THEMELIB . '/functions/socialstuff.php'); ?>
<div style="clear:left;"></div>


<?php the_content(); ?>
</div>
<div class="clear"></div>
<div style="width:950px; float:left;">
<?php include (THEMELIB . '/functions/youmightlike.php'); ?>
<div class="clear"></div>

<p class="postmetadata alt">
					<small>
						This entry was posted
						<?php { ?>
						on <?php the_time('l, F jS, Y') ?> at <?php the_time() ?>
						and is filed under <?php the_category(', ') ?><?php if (get_the_tags()) the_tags(' and tagged with '); ?>.
						You can follow any responses to this entry through the <?php post_comments_feed_link('RSS 2.0'); ?> feed.

						<?php } edit_post_link('Edit this entry','','.'); ?>

					</small>
				</p>


<div class="navi prev left"><?php next_post_link('%link', '&larr;', TRUE); ?></div>
<div class="navi next right"><?php previous_post_link('%link', '&rarr;', TRUE); ?></div>
<div class="clear"></div>
			<?php endwhile; else : ?>

				<h2 class="center">Not Found</h2>
				<p class="center">Sorry, but you are looking for something that isn't here.</p>
				<?php get_search_form(); ?>

			<?php endif; ?>
<?php comments_template('', true); ?>
</div>
</div>

<!-- Begin Footer -->
<?php get_footer(); 
?>
