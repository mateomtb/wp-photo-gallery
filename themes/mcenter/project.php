<?php get_header(); 
$theme_options = get_option('T_theme_options'); ?>


<div class="span-<?php $sidebar = get_option('T_sidebar'); if($sidebar || (!$theme_options && !$sidebar)) { echo "15 colborder home"; } else { echo "24 last"; } ?>">
<div <?php if(function_exists('post_class')) : ?><?php post_class(); ?><?php else : ?>class="post post-<?php the_ID(); ?>"<?php endif; ?>>
<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
	
    <?php $posttags = get_the_tags(); $mytag = getmy_tag($posttags);  //get the post tag ?>
    <?php $category = get_the_category();  //get the post category ?>
    <?php $alldeeezcats2 = deeez_cats2($category); // category list underscore separated?>
	<?php $thepagetag = 'project_galleries'; ?>
    <?php $menucat = get_post_meta($post->ID, 'menu_category', true); ?>
    


<div class="spheader">
<img src="http://photos.denverpost.com/mediacenter/projectfiles/images/dplogobug.jpg" align="dp logo" height="50" width="52" />
<h3>Special Project</h3>
<?php $headline1 = get_post_meta($post->ID, 'project_headline', true);
	if(!empty($headline1)) { ?> 
		<h1><?php echo $headline1 ?></h1>
<?php } ?>
<?php $headline2 = get_post_meta($post->ID, 'project_deck', true);
	if(!empty($headline2)) { ?> 
		<h2><?php echo $headline2; ?></h2>
<?php } ?>
</div>
<?php the_content(); ?>
<!-- <div style="float:left; margin-right:10px; margin-top-1px;">
<iframe
src="http://www.facebook.com/plugins/like.php?href=http%3A%2F%2Fphotos.d
enverpost.com%2Fmediacenter%2Fcategory%2Fspecial-projects%2Fdiego-lemos%
2F&amp;layout=standard&amp;show_faces=true&amp;width=450&amp;action=like
&amp;colorscheme=light&amp;height=20" scrolling="no" frameborder="0"
style="border:none; overflow:hidden; width:450px; height:20px;"
allowTransparency="true"></iframe>
</div> -->
<div style="float:left; margin-right:10px; margin-top:-1px;">
<iframe src="http://www.facebook.com/plugins/like.php?href=<?php the_permalink() ?>&amp;layout=standard&amp;show_faces=true&amp;width=450&amp;action=recommend&amp;colorscheme=light&amp;height=80" scrolling="no" frameborder="0" style="border:none; overflow:hidden; width:300px; height:80px;" allowTransparency="true"></iframe></div>
<div style="float:left; margin-right:10px; margin-top:-1px;">
<a href="http://twitter.com/share?url=<?php the_permalink(); ?>" class="twitter-share-button" data-count="none" data-via="denverpost">Tweet</a><script type="text/javascript" src="http://platform.twitter.com/widgets.js"></script></div>

<!-- <a href="http://www.addthis.com/bookmark.php" class="addthis_button"><img style="float:left; padding-right:7px;" src="<?php // echo bloginfo('template_directory') . '/images/smplus.png'; ?>" width="16" height="16" border="0" alt="Share" /><h4>Share This Gallery</h4></a>
            <script type="text/javascript" src="http://s7.addthis.com/js/250/addthis_widget.js"></script> -->
            
<div class="clear"></div>
<div class="adholder" style="float:right; width:300px; height:250px; margin: 0px 0px 10px 10px;">
        <iframe src="<?php echo bloginfo('template_directory') . '/ads/photo350x200.html'; ?>?thepagetag=<?php echo $thepagetag ?>&thepagecat=<?php echo $alldeeezcats2 ?>" id="adpos9_iframe" name="adpos9_iframe" width="300" height="250" frameborder="0" marginheight="0" marginwidth="0" scrolling="no"></iframe>
</div>
<div class="bottominfo">
<div class="bottomleft">
<div class="spmenu">
	<div class="spmenutitle"><h2>Menu:</h2></div>
	<ul>	
            <?php query_posts('category_name=' . $menucat); //echo $menucat;?>
               <?php if ( have_posts() ) while ( have_posts() ) : the_post(); ?>
                <li>
                	<div class="deez-list">
                        <?php if ( has_post_thumbnail()==true ) { ?> 
                        <a href="<?php the_permalink() ?>" rel="bookmark" title="Permanent Link to <?php the_title_attribute(); ?>"><?php the_post_thumbnail('project-menu'); ?> </a> <?php } ?>
                        <?php $seticon = get_post_meta($post->ID, 'menu_type', true);
							if(!empty($seticon)) {
								switch ($seticon){
								case "photo":
									echo '<img src="http://photos.denverpost.com/mediacenter/projectfiles/images/cameraicon.jpg" height="16" width="20" alt"icon" />'; 
									 break;
								case "video":
									echo '<img src="http://photos.denverpost.com/mediacenter/projectfiles/images/videoicon.jpg" height="17" width="20" alt"icon" />'; 
									 break;
								default:
									echo '<img src="http://photos.denverpost.com/mediacenter/projectfiles/images/cameraicon.jpg" height="16" width="20" alt"icon" />';
										break;
									}
								} ?>
                        <?php $menutitle = get_post_meta($post->ID, 'menu_title', true);
								if(!empty($menutitle)) { ?> 
								<a href="<?php the_permalink() ?>"><h2><?php echo $menutitle ?></h2></a>
							<?php } ?>
                            <?php $menudesc = get_post_meta($post->ID, 'menu_description', true);
								if(!empty($menudesc)) { ?> 
								<a href="<?php the_permalink() ?>"><p><?php echo $menudesc ?></p></a>
							<?php } ?>

                    </div>
                </li>
                <?php endwhile; wp_reset_query();?>
            </ul>
</div>
<div class="readthis">
    <div class="readthisinner">
	<img src="http://photos.denverpost.com/mediacenter/projectfiles/images/newsicon.png" height="31" width="43" alt"icon" />
    <div class="readthislinks">
    <h2>Read The Story</h2>
    <?php $storylinks = get_post_meta($post->ID, 'story_links', true);
								if(!empty($storylinks)) { ?> 
								<?php echo $storylinks ?>
							<?php } ?>
    </div>                        
    </div>
</div>

</div>
<div class="bottomright">
<div class="aboutblock">
	<div class="aboutblockmenutitle"><h2>About: <?php $menutitle = get_post_meta($post->ID, 'menu_title', true);
								if(!empty($menutitle)) { ?> 
								<?php echo $menutitle ?>
							<?php } ?></h2></div>
    <div class="aboutinner">
    <?php if ( has_post_thumbnail()==true ) {  
        the_post_thumbnail('project-about');
		 } ?>
    <?php $pagedesc = get_post_meta($post->ID, 'page_description', true);
	if(!empty($pagedesc)) { ?> 
		<p><?php echo $pagedesc ?></p>
<?php } ?>
	</div>
	<div class="eee_bar"></div>
</div>

<div class="creditblock">
	<div class="creditmenutitle"><h2>Credits:</h2></div>
    <div class="creditblockinner">
	 <?php $projectcreds = get_post_meta($post->ID, 'project_credits', true);
	if(!empty($projectcreds)) { ?> 
		<?php echo $projectcreds ?>
<?php } ?>
    </div>
    <div class="eee_bar"></div>  
</div>

</div>
</div>
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
<?php include (THEMELIB . '/apps/ad-main.php'); ?>
</div>
</div>
<?php $sidebar = get_option('T_sidebar'); if($sidebar || (!$theme_options && !$sidebar)) { get_sidebar(); } ?>

<!-- Begin Footer -->
<?php get_footer(); ?>
