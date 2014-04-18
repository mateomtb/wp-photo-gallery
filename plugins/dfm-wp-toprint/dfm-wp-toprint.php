<?php
/**
 * Plugin Name: DFM To Print
 * Plugin URI: 
 * Description: Publish and update articles to / in print-edition CMSes.
 * Version: 0.1
 * Author: Chris Johnson and Joe Murphy, Digital First Media
 * Author URI: http://digitalfirstmedia.com/
 * License: 
 */

// TODOS:
/*
// Usage:
*/

include('class.request.php');

class DFMToPrintArticle
{
    // We use this class to create an article XML for the
    // purpose of sending to a print-edition CMS.

    var $article_template;
    var $post;
    var $path_prefix;

    function __construct($post=1)
    {
        $this->article_template = 'single.xml.twig';
        $this->set_post($post);
        $this->path_prefix = '';
        if ( function_exists('plugin_dir_path') ):
            $this->path_prefix = plugin_dir_path( __FILE__ );
        endif;
    }

    public function set_post($post)
    {
        // Should we need to change the post object in an existing object.
        // Load up the post we're sending out.
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
            default:
                return false;
        endswitch;
        return $this->post;
    }

    public function set_article_template($value)
    {
        // Should we need to change the template string in an existing object.
        $this->article_template = $value;
        return $this->article_template;
    }

    public function update_post($field_array)
    {
        // Update the WordPress post object.
        // This is a wrapper for the update_post_meta() function, and we do this
        // in case we need to add anything to the update.
        foreach ( $field_array as $key => $value ):
            $return = update_post_meta($this->post->ID, $key, $value);
        endforeach;
        return $return;
    }

    public function get_article($newarticle = false, $post_id=0)
    {
        // Returns an xml representation of the desired article
        // Takes two parameters:
        // $newarticle, boolean, if this is an article we're adding to EWS.
        // $post_id, integer, for manual lookups of post collection field.
        $post = $this->post;
        if ( $post_id > 0 ):
            $post = get_post($post_id);
        endif;

        if ( !class_exists('Timber') ):
        include($this->path_prefix . '../timber/timber.php');
        endif;
        $context = Timber::get_context();
        $context['product_id'] = 1; // *** HC for now
        $context['author_print_id'] = 944621807; // *** HC for now
        $context['statuscode'] = 1;
        if ( $newarticle === false ):
            $context['statuscode'] = 2;
            $context['updatedtime'] = date('c');
            $context['newarticle'] = $newarticle;
        endif;
        //$the_post = new TimberPost();
        $context['post'] = new TimberPost($post->ID);
        ob_start();
        Timber::render(array($this->article_template), $context);
        $xml = ob_get_clean();
        $this->log_article($xml);
        return $xml;
    }

    public function log_article($xml)
    {
        // Save the article xml to a file in the log directory.
        $filename = $this->post->ID . '_' . $this->post->slug . '_' . time() . '.xml';
        if ( is_dir($this->path_prefix . 'log/') ):
            return file_put_contents($this->path_prefix . 'log/' . $filename, $xml);
        endif;
        return false;
    }
}

class DFMToPrintUser
{
    // Mapping between wordpress' site object and user object
    var $user_id;

    function __construct()
    {
        $this->user_id = array('wp'=>0, 'remote'=>0);
    }
}


// *******************
//
// CUSTOM FIELDS
//
// *******************
// We don't need to display these in the post-edit interface, we
// just need them available to us robots.
add_action( 'init', function() {
    if ( class_exists('Fieldmanager_Group') ):
    $fm = new Fieldmanager_Group( array(
        'name' => 'toprint_article_fields',
        'children' => array(
            'print_cms_id' => new Fieldmanager_Textfield( 'Print CMS ID' ),
        ),
    ) );
    endif;
} );


// Hard-coded, for now.
include('class.saxo.php');
