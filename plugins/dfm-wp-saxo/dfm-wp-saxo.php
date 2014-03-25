<?php
/**
 * Plugin Name: Publish and update articles to / in Saxotech.
 * Plugin URI: 
 * Description: 
 * Version: 0.1
 * Author: Chris Johnson and Joe Murphy, Digital First Media
 * Author URI: http://digitalfirstmedia.com/
 * License: 
 */

// TODOS:
/*
// Usage:
*/

if ( !file_exists(WP_PLUGIN_DIR . '') ) die("Requires plugin (  )");

require_once( WP_PLUGIN_DIR . '' );


class DFMSaxoExport
{
    // We use this class to 


    function __construct($post, $collection_type = 'package')
    {
        $this->collection_type=$collection_type;
        $this->collection=$this->get_collection();
    }

    public function get_collection($post_id=0)
    {
        // Returns the tag slug of the collection for a particular post.
        // Takes a parameter, post_id, for manual lookups of post collection field.
    }

    public function get_collection_items()
    {
        // Returns an array of post objects in the collection.
    }
}
