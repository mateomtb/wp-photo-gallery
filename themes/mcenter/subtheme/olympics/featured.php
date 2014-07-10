<?php
$featured_category = get_option('T_featured_category');
$featured_category_ID = get_cat_ID($featured_category);
?>


<!-- Begin featured -->
<div id="featured-section">

<div class="span-15 colborder home">
<h3 class="sub"><?php echo "$featured_category"; ?></h3>
	<?php 
		$featured_query = new WP_Query("cat=-88,-101&showposts=1"); ?>
	<?php while ($featured_query->have_posts()) : $featured_query->the_post();
		$do_not_duplicate = $post->ID; ?>
			<!--<div <?php if(function_exists('post_class')) : ?><?php post_class(); ?><?php else : ?>class="post post-<?php the_ID(); ?>"<?php endif; ?>>
				
				
				<div class="entry">
					<?php include (THEMELIB . '/apps/multimedia.php'); ?>
                    <p><?php echo gPPGetVideo($post->ID); ?></p>-->

			<?php if (strpos($_SERVER['QUERY_STRING'], 'olympics_categories') !== FALSE): //Doing this logic branch because we need a way to generate the Olympics category listing page ?>
						
            
                  <div class="all-cat-highlights">
                        <h2>Categories</h2>    
       					    
        		        <div class="cat-left-column">                   
                            <ul>
                            <?php
							$tag = $_REQUEST['tag'];							
							$olympics_cat_id = get_category_by_slug('olympics');
                        	$olympics_cat_id = $olympics_cat_id->cat_ID;
							$cats = get_categories(array('child_of' => $olympics_cat_id));
						$cats_count = 0; 						
						$style;						
						foreach ($cats as $cat):							
							$filled = get_posts(array(// Doing this because a tag can be passed and we don't want to show categories empty of posts with that tag
                                        'category' => $cat->cat_ID,
										'numberposts' => '1',
										'offset' => 0,
										'tag' => $tag));
							if (!empty($filled)) :
								$the_cat_link = get_category_link($cat->cat_ID);
								if (strpos($the_cat_link,'?') !== false) {
									$the_cat_link = (($tag != '') ? $the_cat_link . '&tag=' . $tag : $the_cat_link);	
								}
								else {
									$the_cat_link = (($tag != '') ? $the_cat_link . '?tag=' . $tag : $the_cat_link);
								}							
								if ($cats_count % 2 == 0){?>						
									<li><a href="<?php echo $the_cat_link; ?>"><div class="squared trans-<?php echo (floor($cats_count/8) +1); //needed a way to gradually increase this number to match existing gradient styling ?>"></div><span class="squared-text"><?php echo $cat->name; ?></span></a></li>                            
						  <?php 
								}
							endif;
							$cats_count++;
						endforeach;
						?>
                            </ul>
                        </div>
                        
                        <div class="cat-right-column">
                            <ul>
                                <?php							
							$cats_count = 0; 						
							$style;						
							foreach ($cats as $cat):
							$filled = get_posts(array(// Doing this because a tag can be passed and we don't want to show categories empty of posts with that tag
                                        'category' => $cat->cat_ID,
										'numberposts' => '1',
										'offset' => 0,
										'tag' => $tag));
							if (!empty($filled)) :
								$the_cat_link = get_category_link($cat->cat_ID);
								if (strpos($the_cat_link,'?') !== false) {
									$the_cat_link = (($tag != '') ? $the_cat_link . '&tag=' . $tag : $the_cat_link);	
								}
								else {
									$the_cat_link = (($tag != '') ? $the_cat_link . '?tag=' . $tag : $the_cat_link);
								}							
								if ($cats_count % 2 == 1){?>						
									<li><a href="<?php echo $the_cat_link; ?>"><div class="squared trans-<?php echo (floor($cats_count/8) +1); //needed a way to gradually increase this number to match existing gradient styling ?>"></div><span class="squared-text"><?php echo $cat->name; ?></span></a></li>                            
						  <?php 
								}
							endif;	
							$cats_count++;
						endforeach;
						?>
                            </ul>
                        </div>  
            
            <!-- end all-cat-highlights -->
            </div>
            	
			
			<!-- begin rotator -->
			<?php 
			else: // begin regular home page
			if (get_category_by_slug('olympics-featured')):	
				// Olympics rotator
				$olympics_rotator_query_offset = 0;
				$olympics_rotator_total = 6; //amount of items you want to show in the rotator
				$olympics_rotator_data = array(); //array for relevants posts. Going to work with this so there are "$number_of_items" of posts for rotator
				function olympicsrotatorQuery($offset){
                                	$olympics_rotator_cat = get_category_by_slug('olympics-featured')->cat_ID; // Category for curation                                
	                               	$olympics_rotator_query = array(
                                        'post_type' => 'post','third_party',
                                        'category' => $olympics_rotator_cat,
										'numberposts' => '1',
										'offset' => $offset          
                                	);
						$olympics_rotator_post = get_posts($olympics_rotator_query);
						return $olympics_rotator_post;
				}				
				$get_total_olympics_posts = count(get_posts(array('category' => get_category_by_slug('olympics-featured')->cat_ID, 'offset' => 0, 'numberposts' => -1)));
				while($olympics_rotator_query_offset <= $get_total_olympics_posts){
					$olympics_rotator_post = olympicsrotatorQuery($olympics_rotator_query_offset);
					if ($olympics_rotator_post[0]->ID != null){
						$olympics_post_attachments = wp_get_attachment_image_src(get_post_thumbnail_id($olympics_rotator_post[0]->ID),'olympics-rotator');
						$olympics_post_ssp_meta = get_post_meta($olympics_rotator_post[0]->ID, 'thumbnail', true);
						if ($olympics_rotator_post[0]->post_excerpt == ''){							
								$olympics_rotator_excerpt = $olympics_rotator_post[0]->post_content;
								if (strpos($olympics_rotator_excerpt ,'[') !== false) {
									$olympics_rotator_excerpt = substr($olympics_rotator_excerpt,0,strpos($olympics_rotator_excerpt,'[')); // Remove insert code for SSP and captions in scenarios where this code creates the excerpt
								}
								$olympics_rotator_excerpt = str_replace("\n\r","\n",$olympics_rotator_excerpt);
								$olympics_rotator_excerpt = explode('\n',$olympics_rotator_excerpt);
								if (strlen($olympics_rotator_excerpt[0]) > 150){
									$olympics_rotator_excerpt = substr($olympics_rotator_excerpt[0], 0, 149) . '...';
								}
								else {
									$olympics_rotator_excerpt =  $olympics_rotator_excerpt[0];
								}	
						}
						else { 
							$olympics_rotator_excerpt = substr($olympics_rotator_post[0]->post_excerpt, 0, 150) . '...';
						}
						if ($olympics_post_attachments[0] != ''){// This branch is for post that have a media attachment							
							$olympics_rotator_data[] = array('title' => $olympics_rotator_post[0]->post_title, 'excerpt' => $olympics_rotator_excerpt, 'image' => $olympics_post_attachments[0], 'url' => $olympics_rotator_post[0]->guid ); 
						}
						elseif ($olympics_post_ssp_meta != ''){// This branch is for post's that don't have a media attachment but have a thumbnail
							$olympics_rotator_ssp_image = generateSSPImage($olympics_post_ssp_meta,590,400); //hit the SSP API for the image path
							$olympics_rotator_data[] = array('title' => $olympics_rotator_post[0]->post_title, 'excerpt' => $olympics_rotator_excerpt, 'image' => $olympics_rotator_ssp_image['image'], 'url' => $olympics_rotator_post[0]->guid);
						}
					}
					if (count($olympics_rotator_data) == 5) break; 
					$olympics_rotator_query_offset++;
				}
				if (count($olympics_rotator_data) >= 2) {// Now $olympics_rotator_data is an array with at least two items that include an image path, a title, excerpt, and url
				?>
						<div id="rotator">
                            <ul>
                            <?php 
                            foreach ($olympics_rotator_data as $item){?>
                                <li>
                                    <h2><a href="<?php echo $item['url']; ?>"><?php echo $item['title']; ?></a></h2>
                                    <div class="rotator-image-wrap">  
                                        <img src="<?php echo $item['image']; ?>" alt=""/>
                                    </div>
                                    <div class="rotator-caption-wrap-new">
                                    	<p><?php echo $item['excerpt']; ?><a href="<?php echo $item['url']; ?>">(Read Full Story)</a></p>
                                    </div>
                                </li>
                            
                            <?php } ?>                            
                            </ul>
                         </div>                                           		
			<?php }
				else {
					echo '<!--There weren\'t enough posts that satisfied the criteria for the rotator-->';	
				}
		
			 endif;	
			 //end rotator php?> 
 
<script type="text/javascript">

(function() {
	jQuery('#rotator ul li').css({opacity: 0.0}); // Set the opacity of all slide components to 0 
	jQuery('#rotator ul li:first').css({opacity: 1.0}); // Get the first items and display (gets set to full opacity)
	jQuery('#rotator ul li:first').addClass('active');
	setInterval('rotate()', 8000); // Call the rotator function to run the slideactive, 6000 = change to next image after 6 seconds
})();

function rotate() {
	
	//Check if browser supports opacity css. Currently false in IE. There were animation issues with home page rotator
	var ops = jQuery.support.opacity;
	
	//Get the first image
	var current = (jQuery('#rotator ul li.active') ? jQuery('#rotator ul li.active') : jQuery('#rotator ul li:first'));  
	
	//Get next image, when it reaches the end, rotate it back to the first image
	var next = ((current.next().length) ? ((current.next().hasClass('active')) ? jQuery('#rotator li:first') :current.next()) : jQuery('#rotator li:first'));
	
	// Set the fade in effect for the next image, the active class has higher z-index
	next.animate({opacity: 1.0}, (1000 * ops));
		
	//Hide the current image
	current.animate({opacity: 0.0}, (2000 * ops), function(){
		current.removeClass('active');
		next.addClass('active');
	});
};	
</script>
             			
<!-- end olympics rotator -->



		<div class="todays-olympic-highlights">
      	<h2>Today's Olympic Highlights</h2>
<?php
// The list of non-photo gallery articles
$olympics_highlights_cat = get_category_by_slug('olympics-highlights');

if ($olympics_highlights_cat): //easy way to not show content here if the "olympics-highlights" category doesn't exist.	
	$posts = get_posts(array(
		'numberposts' => 8,
		'offset' => 0,
			'post_type' => 'post', 'third_party',	// This may change, depending on how we segregate photo galleries from posts.
		'category' => $olympics_highlights_cat->cat_ID,
		));
	foreach ( $posts as $key => $post ):		
		setup_postdata($post);
		$excerpt = get_the_excerpt();
		$excerpt = str_replace('[...]','',$excerpt);
		if (strpos($excerpt ,'[') !== false) {//Doing this so SSP code doesn't show up in excerpt
			echo strpos($excerpt ,'[');
			$excerpt = substr($excerpt,0,strpos($excerpt,'['));
		}
		if (strlen($excerpt) > 150) {
			$excerpt = substr($excerpt, 0, 149) . '...';
		}	
		$thumb_chk_one = get_post_thumbnail_id();//The code grabs you an image either from the Post itself or from SSP
		$thumb_chk_two = get_post_meta($post->ID, 'thumbnail', true);
		if($thumb_chk_one != '') {
                $image_url = wp_get_attachment_image_src($thumb_chk_one,'thumbnail');
                $image_url = $image_url[0];
			}
		elseif ($thumb_chk_two != ''){
			$image_url = generateSSPImage($thumb_chk_two,100,100); //in functions.php
			$image_url = $image_url['image'];
		}
		else $image_url = '';
	?>
		 <div class="highlight-block">
			 <a href="<?php the_permalink(); ?>"><img src="<?php echo $image_url; ?>" alt=""/></a>
			<h3><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
			<div class="blurb">
			<?php echo $excerpt; ?>
			<a href="<?php the_permalink(); ?>">(Read full story)</a>
		    </div>
		 </div>
<?php
	endforeach;
endif;
?>
<!-- end of today's olympics container -->
      </div>


<?php include(TEMPLATEPATH . '/subtheme/olympics/three.php'); ?>
<?php endif; //end of the branch between regular home and the category listing page ?>

	<?php endwhile; wp_reset_query(); ?>
	<div class="clear"></div>
	


</div>
</div>


<?php include(TEMPLATEPATH . '/subtheme/olympics/right_rail.php'); ?>




<!-- close #container -->
</div>
</div>


