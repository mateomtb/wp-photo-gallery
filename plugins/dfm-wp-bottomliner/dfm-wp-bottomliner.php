<?php
/**
 * Plugin Name: 
 * Plugin URI: 
 * Description: 
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


class DFMAutoAutoBlog
{
    // We use this class to 


    function __construct($post, $collection_type = 'package')
    {
        switch ( gettype($post) ):
            case 'object':
                $this->post = $post;
                break;
            case 'integer':
                $this->post = get_post($post);
                break;
            case 'string':
                $this->post = get_post(intval($post));
                break;
        endswitch;
        $this->collection_type=$collection_type;
        $this->collection=$this->get_collection();
    }

    public function get_collection($post_id=0)
    {
        // Returns the tag slug of the collection for a particular post.
        // Takes a parameter, post_id, for manual lookups of post collection field.
        if ( $post_id == 0 )
            $post_id = $post->ID;

        $collection = get_post_custom_values('package', $post_id);
        if ( $this->collection_type == 'related' )
            $collection = get_post_custom_values('related', $post_id);
        
        return $collection;
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
