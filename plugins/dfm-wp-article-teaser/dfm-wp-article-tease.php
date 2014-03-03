<?php
/**
 * Plugin Name: DFM In-Article Teasers
 * Plugin URI: 
 * Description: Takes a WP link object and appends it in-article as a teaser to the destination. Requires Easy Custom Fields.
 * Version: 0.1
 * Author: Joe Murphy, Digital First Media
 * Author URI: http://digitalfirstmedia.com/
 * License: Apache-2
 */

// TODOS:
/*
// Usage:
*/

if ( !file_exists(WP_PLUGIN_DIR . '') ) die("Requires plugin (  )");

require_once( WP_PLUGIN_DIR . '' );


class DFMInArticleTeaser
{
    // We use this class to manage In-Article Teasers


    function __construct($post, $collection_type = 'package')
    {
    }

    public function get_collection($post_id=0)
    {
        // Returns the tag slug of the collection for a particular post.
    }

    public function get_collection_items()
    {
        // Returns an array of post objects in the collection.
        $args = array(
            'tag' => $this->collection[0],
            'limit' => 10,
            );
        $query = new WP_Query($args);
        if ( $query->have_posts() )
            return $query->posts;
        
        return false;
    }
}
