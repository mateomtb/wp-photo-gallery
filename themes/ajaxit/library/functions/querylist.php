<?php
	die('querylist.php is a dead file');
	$backup = $post; 
	$i == 0; 
	$featured_offset_query = new WP_Query($xquery);

	while ($featured_offset_query->have_posts()) {
		$featured_offset_query->the_post(); 
		$i++;
		$do_not_duplicate = $post->ID;

		//  container that holds thumb markup and starts the process 
		$thumb_markup = '';
		if ( has_post_thumbnail()==true ) {
			//---------------------------------------------------------------------smug mug post with featured image
			$thumb_id = get_post_thumbnail_id();
			if (has_post_thumbnail( $post->ID ) ) {
				if ( $is_iPad || $is_Android_tablet ) {
					$image = wp_get_attachment_image_src( $thumb_id, 'tablet_index_image' );
				} else if ( $is_iPhone || $is_Android_mobile ) {
					$image = wp_get_attachment_image_src( $thumb_id, 'mobile_index_image' );
				} else {
					$image = wp_get_attachment_image_src( $thumb_id, 'mobile_index_image' );
				}
				array_push($photo_array, array( 'url' => $image[0], 'title' => str_replace("\r","",trim( the_title('', '', false)) ), 'date' => get_the_time('M d, Y'), 'link' => get_permalink() ) );
			} else {
				//--no thumbnail so send generic image
				array_push($photo_array, array( 'url' => THEME . '/css/images/photo.gif', 'title' => str_replace("\r","",trim( the_title('', '', false)) ), 'date' => get_the_time('M d, Y'), 'link' => get_permalink() ) );
			}


		} else {
			//---------------------------------------------------------------------SSP
			$thumb = get_post_meta($post->ID, 'thumbnail', true);
			
			if(!empty($thumb)) {
				die($thumb);
				$thumb_markup = generate_thumb($thumb);
				array_push($photo_array, array( 'url' => $thumb_markup['list_image_url'], 'title' => str_replace("\r","",trim( the_title('', '', false)) ), 'date' => get_the_time('M d, Y'), 'link' => get_permalink() ) );
			
			} else {
				//--no thumbnail so send generic image
				array_push($photo_array, array( 'url' => THEME . '/css/images/photo.gif', 'title' => str_replace("\r","",trim( the_title('', '', false)) ), 'date' => get_the_time('M d, Y'), 'link' => get_permalink() ) );
			}
		}
	}

$post = $backup;  // copy it back
wp_reset_query(); // to use the original query again
?>