<?php
/*
Plugin Name: Tout
Plugin URI: http://tout.com
Description: Embed Tout videos in Wordpress posts.
Version: 1.0
Author: Brian Henderson
Author URI: http://www.twincities.com
License: GPL2
*/

wp_embed_register_handler($toutEmbed, '#https?://(www\.)?tout.com/m/*#i', 'wp_embed_handler_tout' );




function wp_embed_handler_tout( $matches, $attr, $url, $rawattr ) {

echo $url;
$toutVideoID =explode ("/" , $url);
//var_dump($toutVideoID);

	$embed = sprintf('<embed src="https://dftnngj7vho79.cloudfront.net/prod/toutPlayer.swf?autoplay=false&product=embed&website_origin=http://www.tout.com&api_origin=https://api.tout.com&oauth_origin=https://www.tout.com&tout_api_path=/api/v1/touts/' . $toutVideoID[4] . '&mixpanel_token=8f42d6c99005ef738c46dc8f6350829b" type="application/x-shockwave-flash" width="420" height="388" class="tout-flash-player" id="tout_flash_player_' . $toutVideoID[4] . '" style="display: block;" bgcolor="#FFFFFF" quality="high" scale="scale" allowfullscreen="true" allowscriptaccess="always" salign="t1" wmode="opaque"></embed>',
			esc_attr($matches[1])
			);

	return apply_filters( 'embed_tout', $embed, $matches, $attr, $url, $rawattr );
}









?>
