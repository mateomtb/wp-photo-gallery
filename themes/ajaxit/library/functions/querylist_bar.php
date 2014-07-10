<?php die('querylist_bar.php is a dead file'); ?>
<div class="bar_list_cat_text" style="font-family:Arial;font-weight:bold;font-size:20px;color:#FFF;padding:0px;text-align:left;margin-left:15px;margin-top:10px;"><img style="width:16px;" src="<?php echo THEME . '/css/images/' ?>dubarrows.png" /> <?php echo $cat_title; ?></div>

<div class="bar_list_container" style="width:100%;display:table;table-layout:fixed;margin:4px 0px 10px 0px;background:none;color:#000;padding:0px 10px 0px 10px;">
	
<?php $backup = $post; $i == 0; ?>
	<?php $featured_offset_query = new WP_Query($xquery); ?>
	<?php while ($featured_offset_query->have_posts()) : $featured_offset_query->the_post(); $i++;
		$do_not_duplicate = $post->ID; ?>
			
		<?php    
		//  container that holds thumb markup and starts the process 
		$thumb_markup = '';
		if ( has_post_thumbnail()==true ) {
			the_post_thumbnail('previous-thumbnail');
		}
		$thumb = get_post_meta($post->ID, 'thumbnail', true); ?>
		
			<?php if(!empty($thumb)) { ?>
				<?php $thumb_markup = generate_thumb($thumb);?>
				
					
					<div class="" style="width:auto;display:table-cell;background:none;height:100%;padding:5px;">
						<a href="<?php the_permalink() ?>">
							<img class="list_image_bar" style="max-width:100%;" src="<?php echo $thumb_markup['list_image_bar'];?>" />
							<div class="list_image_bar_title" style="max-width:100%;font-family:Arial;font-weight:bold;font-size:12px;color:#979797;line-height:110%;background-color:none;"><?php processTitleRemoveWordPhotos( the_title('', '', false) );?></div>
						</a>
					</div>
				
				
			<?php } ?>
					
				

	<?php endwhile; ?>
	<?php //$i == 0; ?>

</div>

<?php
//border:1px solid #FFF;

/*
<div class="bar_list_container" style="width:100%;display:table;height:180px;margin:10px 0px 10px 0px;background:none;color:#000;padding:0px 10px 0px 10px;">
	<div class="" style="width: auto;display:table-cell;background:yellow;height:100%;">1</div>
	<div class="" style="width: auto;display:table-cell;background:green;height:100%;">2</div> 
	<div class="" style="width: auto;display:table-cell;background:blue;height:100%;">3</div> 
	<div class="" style="width: auto;display:table-cell;background:orange;height:100%;">4</div> 
	<div class="" style="width: auto;display:table-cell;background:red;height:100%;">5</div> 
</div>
*/
$post = $backup;  // copy it back
wp_reset_query(); // to use the original query again
?>