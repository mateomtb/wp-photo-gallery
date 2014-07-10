<div class="latest-olympic-galleries">
<?php
// The list of photo gallery articles.
// *** NEEDS LOGIC TO FIGURE OUT WHAT MAKES A GALLERY A GALLERY. This can be accomplished by looking for the tag "photo"
$olympics_cat = get_category_by_slug('olympics');
$olympics_rotator_cat = get_category_by_slug('featured');
$olympics_highlights_cat = ('highlights');
$posts = get_posts(array(
        'numberposts' => 3,
        'offset' => 0,
		'post_type' => 'post',	// This may change, depending on how we segregate photo galleries from posts.
        'category' => $olympics_cat->cat_ID, '-' . $olympics_rotator_cat->cat_ID, '-' . $olympics_highlights_cat->cat_ID,
		'tag' => 'Photo', 'photo',
        ));
?>
 	<h2><a href="<?php echo get_category_link($olympics_cat->cat_ID); ?>">Latest Olympic Galleries</a></h2>
<?php
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
		if($thumb_chk_one != '') {
                $image_url = wp_get_attachment_image_src($thumb_chk_one,'thumbnail');
                $image_url = $image_url[0];
			}
		elseif ($thumb_chk_two != ''){
			$image_url = generateSSPImage($thumb_chk_two,181,181);
			$image_url = $image_url['image'];
		}
		else $image_url = '';
?>
         <div class="gallery-block">
      		<a href="<?php the_permalink(); ?>"><img src="<?php echo $image_url; ?>" /></a>
         	<div class="blurb">
            	<?php echo $excerpt; ?>
            	<a href="<?php the_permalink(); ?>">(...more)</a>
            </div>
         </div>
<?php
endforeach;
?>
</div>
