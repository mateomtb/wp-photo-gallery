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
        Timber::render(array('single.xml.twig'), $context);
        $xml = ob_get_clean();
        return $xml;
    }

    
}

class DFMSaxoUser
{
    // Mapping between wordpress' site object and user object and
    // Saxo's EWS User object ( https://docs.newscyclesolutions.com/display/MWC/Editorial+Web+Service+3.0#EditorialWebService3.0-ListingUsers,Products,Categories,AccessLevels&TextFormats )

    function __construct()
    {

    }

}


class DFMRequest
{
    // A class to handle HTTP requests.
    // Example use:
    // $request = new DFMRequest();
    // $curl_options = array(
    //  CURLOPT_URL => $target_url,
    //  CURLOPT_POSTFIELDS => $post
    //  CURLOPT_RETURNTRANSFER => 1,
    //  CURLOPT_VERBOSE => 1,
    //  CURLOPT_HEADER => 1,
    //  CURLOPT_POST => 1,
    // );
    // if ( $request->curl_options($curl_options) == true ):
    //  $result = $request->curl_execute();
    //  $reponse = $request->curl_results($result);
    //  if ( $response != false ):
    //      var_dump($response);
    //      $request->curl_destroy();
    //  endif;
    // endif;

    var $cur;

    function __construct()
    {
        $this->cur = curl_init();
        $this->credentials=$this->get_credentials();
    }

    private function get_credentials()
    {
        // Return a "user:password" formatted credentials for saxo.
        return file_get_contents('.credentials');
    }

    public function curl_initialize()
    {
        // In case we need to re-initalize the curl object.
		$this->cur = curl_init();
        return true;
    }

    public function curl_options($values = array())
    {
        // Set options. Takes an array of CURL_OPTION => CURL_OPTION_VALUE.
        foreach ( $values as $key => $value ):
            curl_setopt($this->cur, $key, $value);
        endforeach;

        return true;
    }

    public function curl_execute()
    {
        // Wrapper for curl_exec
		$result = curl_exec($this->cur);
        return $result;
    }

    public function curl_results($result)
    {
		// Takes a curl_exec return object and pulls out the header
        // and body content.
        $response = array();
		$header_size = curl_getinfo($this->cur, CURLINFO_HEADER_SIZE);
		$response['header'] = substr($result, 0, $header_size);
		$response['body'] = substr($result, $header_size);

		echo $header . '';
		echo $body . '';

		if(curl_errno($this->cur)):
			print curl_error($this->cur);
        endif;
        return $response;
    }

    public function curl_destroy()
    {
        // Wrapper for curl_close()
	    curl_close($this_>cur);
        return true;
    }
}


function send_to_saxo($post_id)
{
    $article = new DFMSaxoArticle($post_id);
    $xml = $article->get_article();
    // *** initiate curl
    // *** if this is an article update, get the saxo article id (custom field)
    // *** send document to saxo
    // *** if this is a new article, get the saxo article id and store it in a custom field
    // *** Get the response from saxo, let the user know if it failed or succeeded.
    // *** If it failed, print as many relevant details of the failure as possible.
}
add_action( 'save_post', 'send_to_saxo' );
