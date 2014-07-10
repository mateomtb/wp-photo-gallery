<?php
$featured_category = get_option('T_featured_category');
$featured_category_ID = get_cat_ID($featured_category);
?>


<!-- Begin featured -->
<div id="single-cat-section" class="olympics">


<div class="span-15 colborder home olympics">

<h3 class="sub"><?php echo "$featured_category"; ?></h3>
	
				
				
                    
                  


<div class="single-cat-highlights olympics">
      	<h2><?php single_cat_title(); ?></h2>
<?php
// The list of non-photo gallery articles
$category = get_term_by('name', single_cat_title('',false), 'category'); //A way to get the category object
$tag = $_REQUEST['tag']; 
/*$total_posts = count(get_posts(array(
        'numberposts' => -1,
        'offset' => 0, // Six posts per page
		'post_type' => 'post', 'third_party',	// This may change, depending on how we segregate photo galleries from posts.
        'category' => $category->term_id,
		'tag' => $tag
        )));// Total amount of posts for this category. Used for pagination
$offset = $_REQUEST['page'];// Starting point of query. Used for pagination
if ($offset == null) $offset = 1; // The first page;*/
$numberposts = 30; //Number of posts to return
$posts = get_posts(array(
        'numberposts' => $numberposts,
        //'offset' => 6 * (($offset == 1) ? 0 : ($offset - 1)), // Six posts per page. The ternary is used for pagination code below
		'offset' => 0,
		'post_type' => 'post', 'third_party',	// The filter hook added to functions.php makes it so that third_party posts will always be queried regardless of what's here
        'category' => $category->term_id,
		'tag' => $tag 
        ));
foreach ( $posts as $key => $post ):		
		setup_postdata($post);
		$excerpt = get_the_excerpt();
		$excerpt = str_replace('[...]','',$excerpt);
		if (strpos($excerpt ,'[') !== false) {
			echo strpos($excerpt ,'[');
			$excerpt = substr($excerpt,0,strpos($excerpt,'['));
		}	
		$thumb_chk_one = get_post_thumbnail_id();
		$thumb_chk_two = get_post_meta($post->ID, 'thumbnail', true);		
		if($thumb_chk_one !== '') {
                $image_url = wp_get_attachment_image_src($thumb_chk_one,'thumbnail');
                $image_url = $image_url[0];
			}
		elseif ($thumb_chk_two !== ''){
			$image_url = generateSSPImage($thumb_chk_two,100,100);
			$image_url = $image_url['image'];
		}
		else $image_url = '';
	?>
    	<div class="highlight-block">
         	<a href="<?php the_permalink(); ?>"><h3><?php the_title(); ?></h3></a>
      		<a href="<?php the_permalink(); ?>"><img src="<?php echo $image_url; ?>" /></a>
         	<div class="blurb">
            	<?php echo $excerpt; ?>
            	<a href="<?php the_permalink(); ?>">(...more)</a>
            	<div class="time-tags"><span class="time"><?php echo get_the_time('l, F j, Y') ?></span><span class="tags">Categories: <a href="<?php echo get_category_link($category->term_id); ?>"><?php single_cat_title(); ?></a>, <a href="<?php get_category_link($category->parent); ?>"><?php echo date('Y'); ?> Olympics</a></span></div>
            </div>
         </div>

<?php
endforeach;
?>


<!-- start pagination -->
		<!--<div class="single-cat-paging">
        	<?php // Created this pagination code since we aren't using a WP loop on this page.  				
					$url = get_category_link($category->term_id);
					if ($total_posts > ($offset * $numberposts)) {
						if ($_SERVER['QUERY_STRING'] != ''){?>
                                <div class="older"><a href="<?php echo $url . ((strpos($url,'?') === false) ? $_SERVER['QUERY_STRING'] : '') . '&page=' . ($offset + 1); ?>" target="_self">&laquo; Older Photos</a></div>
						<?php
						 }
						else { ?>
                        		<div class="older"><a href="<?php echo $url . '?page=' . ($offset + 1); ?>" target="_self">&laquo; Older Photos</a></div>
				<?php }
            		 }					
          			if ($offset > 1) {
						if ($_SERVER['QUERY_STRING'] != ''){?>
								<div class="older"><a href="<?php echo $url .  ((strpos($url,'?') === false) ? $_SERVER['QUERY_STRING'] : '') . '&page=' . ($offset - 1); ?>" target="_self">&laquo; Newer Photos</a></div>
						<?php }
						else { ?>
                        		<div class="older"><a href="<?php echo $url . '?page=' . ($offset - 1);?>" target="_self">&laquo; Newer Photos</a></div>			
						<?php }
            		 }?> 
       </div>-->
<!-- end of single cat container -->
      </div>


	
	<div class="clear"></div>
	



</div>
<?php include(TEMPLATEPATH . '/subtheme/olympics/right_rail.php'); ?>


	
	</div>

<!--close the #container -->
</div>
</div>
<?php get_footer(oly); ?>