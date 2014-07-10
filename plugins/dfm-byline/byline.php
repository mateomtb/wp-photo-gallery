<?php
/*
Plugin Name: Custom Byline Display 
Plugin URI: 
Description: Publishes a byline using information from inputs created by Easy Custom Fields, which is required for this plugin to work. Also, it can display a link to the original publication in the footer, should such a link be available.
Usage: It hooks into the_author(), and ...
Author: Joe Murphy
Version: 0.1
Author URI: http://twitter.com/denverpostjoe
*/

function custom_byline($author)
{
	// Function updated by Josh Kozlowski on 7/24/12
	global $post;

	$custom_name = trim(strip_tags(get_post_meta($post->ID, 'author_name', TRUE)));
	$custom_source = trim(get_post_meta($post->ID, 'syndication_source', TRUE));
	$custom_link = trim(get_post_meta($post->ID, 'syndication_source_uri', TRUE));
	

	//Commented code was in consideration for use but we're going another route for now. Leaving it in until we're sure, though. 
	//It would still probably need a couple of updates

	/*$originating_feed = get_post_meta($post->ID, 'syndication_feed', TRUE); // Use this to check for an identifying string for the three Olympics providers: The Denver Post, The Mercury News, and the Sale Lake Tribune
	$ap = (strpos(strtolower(preg_replace('/\s/','',$custom_source)), 'associatedpress') >= 0) ? true : false; //AP
	$sb = (strpos(strtolower(preg_replace('/\s/','',$custom_source)), 'sbnation') >= 0) ? true : false; //SBNation
	if (!$ap){
		$dp = (strpos($originating_feed,'denverpost') >= 0) ? true : false; //Denver Post
		$merc = (strpos($originating_feed,'mercurynews') >= 0) ? true : false; //Mercury News
		$sltrib = (strpos($originating_feed,'sltrib') >= 0) ? true : false; // Salt Lake Tribune

		if ($dp || $merc || $sltrib ){
			$dp = ($dp) ? 'The Denver Post' : '';
			$merc = ($merc) ? 'The Mercury News' : '';
			$slbrib = ($sltrib) ? 'The Salt Lake Tribune' : '';
			$custom_byline = $author;
			if ( $custom_link != '' ) $custom_byline = '<a href="' . $custom_link . '">' . $custom_byline . '&nbsp;' . $dp . $merc . $sltrib . '</a>';
			if ( $custom_byline != '' ){
		    	$custom_byline = preg_replace('/^by/i','',$custom_byline);
		    		return $custom_byline;		
			}
		}
	}	
        elseif ($ap){
		$custom_byline = $author;
		if ( $custom_link != '' ) $custom_byline = '<a href="' . $custom_link . '">' . $custom_byline . '</a>';
		if ( $custom_byline != '' ){  
                	$custom_byline = preg_replace('/^by/i','',$custom_byline);
                	return $custom_byline;              
                }		
	}
	elseif($sb){
		$custom_byline = 'SBNation.com';
		if ( $custom_link != '' ) $custom_byline = '<a href="' . $custom_link . '">' . $custom_byline . '</a>';
		return $custom_byline;
	}
	else {
		$custom_byline = $custom_name;
		if ( $custom_source != '' ) $custom_byline .= ' / ' . $custom_source;
		if ( $custom_link != '' ) $custom_byline = '<a href="' . $custom_link . '">' . $custom_byline . '</a>';

		if ( $custom_byline != '' )  return $custom_byline;

		return $author;
	}*/
	

	$custom_byline = $custom_name;
	$custom_byline = preg_replace('/^by/i','',$custom_byline);
	if ( $custom_link != '' ) $custom_byline = '<a href="' . $custom_link . '">' . $custom_byline . '</a>';
	if ( $custom_byline != '' ){
		return $custom_byline;
	}
	$author = preg_replace('/^by/i','',$author);
	return $author;
}

add_filter('the_author', 'custom_byline');




function custom_shirttail($content)
{
	global $post;

	$custom_source = trim(get_post_meta($post->ID, 'syndication_source', TRUE));
	$custom_link = trim(get_post_meta($post->ID, 'syndication_source_uri', TRUE));

	$custom_shirttail = '';
	if ( $custom_source != '' && $custom_link != '' )
	{
		$custom_shirttail = '<p id="shirttail"><a href="' . $custom_link . '">Originally published by ' . $custom_source . '</a></p>';
	}

	return $content . $custom_shirttail;
}

add_filter('the_content', 'custom_shirttail');



/* CUSTOM FIELDS */
// We do this for all the custom posts we need to make this site run.
if ( file_exists(WP_PLUGIN_DIR . '/easy-custom-fields/easy-custom-fields.php') )
{
require_once( WP_PLUGIN_DIR . '/easy-custom-fields/easy-custom-fields.php' );
$field_data = array (
        'BylineOverride' => array (
                'fields' => array(
                        'author_name'  => array(),
                        'syndication_source'  => array(),
                ),
        ),
        'OriginalPublication' => array (
                'fields' => array (
                        'pub_date' => array(),
                        'syndication_source' => array(),
                ),
        ),
);
$easy_cf = new Easy_CF($field_data);
}

?>