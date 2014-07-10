<?php
$featured_category = get_option('T_featured_category');
$featured_category_ID = get_cat_ID($featured_category);
?>


<!-- Begin featured -->
<div id="single-cat-section">


<div class="span-15 colborder home">

<h3 class="sub"><?php echo "$featured_category"; ?></h3>
	<?php 
		$featured_query = new WP_Query("cat=-88,-101&showposts=1"); ?>
	<?php while ($featured_query->have_posts()) : $featured_query->the_post();
		$do_not_duplicate = $post->ID; ?>
			<div <?php if(function_exists('post_class')) : ?><?php post_class(); ?><?php else : ?>class="post post-<?php the_ID(); ?>"<?php endif; ?>
				
				
				<div class="entry">
					<?php include (THEMELIB . '/apps/multimedia.php'); ?>
                    <p><?php echo gPPGetVideo($post->ID); ?></p>
                    
                  


<div class="all-cat-highlights">
      	<h2>Categories</h2>


<! -- TEST CONTENT ########################## REMOVE WHEN NECESSARY ########################################## -->

<div class="cat-left-column">
	<ul>
		<li><img src="#" alt="" class="squared trans-1"/><span class="squared-text">Archery</span></li>
		<li><img src="#" alt="" class="squared trans-1"/><span class="squared-text">Badminton</span></li>
		<li><img src="#" alt="" class="squared trans-1"/><span class="squared-text">Basketball</span></li>
		<li><img src="#" alt="" class="squared trans-1"/><span class="squared-text">Boxing</span></li>
		<li><img src="#" alt="" class="squared trans-1"/><span class="squared-text">Cricket</span></li>
		<li><img src="#" alt="" class="squared trans-2"/><span class="squared-text">Cycling</span></li>
		<li><img src="#" alt="" class="squared trans-2"/><span class="squared-text">Equestrian</span></li>
		<li><img src="#" alt="" class="squared trans-2"/><span class="squared-text">Football</span></li>
		<li><img src="#" alt="" class="squared trans-2"/><span class="squared-text">Gymnastics</span></li>
		<li><img src="#" alt="" class="squared trans-3"/><span class="squared-text">Hockey (field)</span></li>
		<li><img src="#" alt="" class="squared trans-3"/><span class="squared-text">Judo</span></li>
		<li><img src="#" alt="" class="squared trans-3"/><span class="squared-text">Modern Pentathlon</span></li>
		<li><img src="#" alt="" class="squared trans-3"/><span class="squared-text">Rackets</span></li>
		<li><img src="#" alt="" class="squared trans-4"/><span class="squared-text">Rowing</span></li>
		<li><img src="#" alt="" class="squared trans-4"/><span class="squared-text">Rugby Sevens</span></li>
		<li><img src="#" alt="" class="squared trans-4"/><span class="squared-text">Shooting</span></li>
		<li><img src="#" alt="" class="squared trans-5"/><span class="squared-text">Swimming</span></li>
		<li><img src="#" alt="" class="squared trans-5"/><span class="squared-text">Table Tennis</span></li>
		<li><img src="#" alt="" class="squared trans-5"/><span class="squared-text">Tennis</span></li>
		<li><img src="#" alt="" class="squared trans-6"/><span class="squared-text">Tug of War</span></li>
		<li><img src="#" alt="" class="squared trans-6"/><span class="squared-text">Water Motorsports</span></li>
		<li><img src="#" alt="" class="squared trans-6"/><span class="squared-text">Weightlifting</span></li>
	</ul>
</div>

<div class="cat-right-column">
	<ul>
		<li><img src="#" alt="" class="squared trans-1"/><span class="squared-text">Athletics</span></li>
		<li><img src="#" alt="" class="squared trans-1"/><span class="squared-text">Baseball</span></li>
		<li><img src="#" alt="" class="squared trans-1"/><span class="squared-text">Baque Pelota</span></li>
		<li><img src="#" alt="" class="squared trans-1"/><span class="squared-text">Canoeing and Kayaking</span></li>
		<li><img src="#" alt="" class="squared trans-1"/><span class="squared-text">Croquet</span></li>
		<li><img src="#" alt="" class="squared trans-2"/><span class="squared-text">Diving</span></li>
		<li><img src="#" alt="" class="squared trans-2"/><span class="squared-text">Fencing</span></li>
		<li><img src="#" alt="" class="squared trans-2"/><span class="squared-text">Golf</span></li>
		<li><img src="#" alt="" class="squared trans-2"/><span class="squared-text">Handball</span></li>
		<li><img src="#" alt="" class="squared trans-3"/><span class="squared-text">Jeu de Paume</span></li>
		<li><img src="#" alt="" class="squared trans-3"/><span class="squared-text">Lacrosse</span></li>
		<li><img src="#" alt="" class="squared trans-3"/><span class="squared-text">Polo</span></li>
		<li><img src="#" alt="" class="squared trans-3"/><span class="squared-text">Roque</span></li>
		<li><img src="#" alt="" class="squared trans-4"/><span class="squared-text">Rugby Union</span></li>
		<li><img src="#" alt="" class="squared trans-4"/><span class="squared-text">Sailing</span></li>
		<li><img src="#" alt="" class="squared trans-4"/><span class="squared-text">Softball</span></li>
		<li><img src="#" alt="" class="squared trans-5"/><span class="squared-text">Synchronized Swimming</span></li>
		<li><img src="#" alt="" class="squared trans-5"/><span class="squared-text">Taekwondo</span></li>
		<li><img src="#" alt="" class="squared trans-5"/><span class="squared-text">Triathlon</span></li>
		<li><img src="#" alt="" class="squared trans-6"/><span class="squared-text">Volleyball</span></li>
		<li><img src="#" alt="" class="squared trans-6"/><span class="squared-text">Water Polo</span></li>
		<li><img src="#" alt="" class="squared trans-6"/><span class="squared-text">Wrestling</span></li>
	</ul>
</div>


<!-- end all-cat-highlights -->
</div>


	<?php endwhile; wp_reset_query(); ?>
	<div class="clear"></div>
	


</div>



</div></div>

<?php include(TEMPLATEPATH . '/subtheme/olympics/right_rail.php'); ?>

<!--close the #container -->
</div>
</div>