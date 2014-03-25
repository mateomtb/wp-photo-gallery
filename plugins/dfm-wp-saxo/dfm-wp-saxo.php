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


class DFMSaxoArticle
{
    // We use this class to create an article XML for the
    // purpose of sending to Saxotech's OWS.


    function __construct($post)
    {
        $this->collection_type=$collection_type;
        $this->collection=$this->get_collection();
    }

    public function get_article($post_id=0)
    {
        // Returns an xml representation of the desired article
        // Takes a parameter, post_id, for manual lookups of post collection field.
    }

}
