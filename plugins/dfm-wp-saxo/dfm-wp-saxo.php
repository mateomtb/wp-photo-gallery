<?php
/**
 * Plugin Name: DFM Saxo
 * Plugin URI: 
 * Description: Publish and update articles to / in Saxotech. 
 * Version: 0.1
 * Author: Chris Johnson and Joe Murphy, Digital First Media
 * Author URI: http://digitalfirstmedia.com/
 * License: 
 */

// TODOS:
/*
// Usage:
*/
//define(WP_INCLUDE_DIR, preg_replace('/wp-content$/', 'wp-includes', WP_CONTENT_DIR));
//include(WP_INCLUDE_DIR . '/post.php');

class DFMSaxoArticle
{
    // We use this class to create an article XML for the
    // purpose of sending to Saxotech's OWS.

    var $post;

    function __construct($post)
    {
        // Load up the post we're sending to Saxo.
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
    }

    public function get_article($post_id=0)
    {
        // Returns an xml representation of the desired article
        // Takes a parameter, post_id, for manual lookups of post collection field.
        $post = $this->post;
        $context = Timber::get_context();
        $post = new TimberPost();
        $context['post'] = $post;
        ob_start();
        Timber::render(array('single-' . $post->ID . '.twig', 'single-' . $post->post_type . '.twig', 'single.twig'), $context);
        $xml = ob_get_clean();
        return $xml;
    }

    
}
class DFMRequest
{
    // A class to handle HTTP requests.

    function __construct()
    {
        $this->credentials=$this->get_credentials();
    }

    private function get_credentials()
    {
        // Return a "user:password" formatted credentials for saxo.
        return file_get_contents('.credentials');
    }
}

function send_to_saxo()
{

    $article = new DFMSaxoArticle(14);
    $xml = $article->get_article();
}
add_action( 'save_post', 'send_to_saxo' );
