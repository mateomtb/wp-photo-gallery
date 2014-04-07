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

class DFMToPrintArticle
{
    // We use this class to create an article XML for the
    // purpose of sending to a print-edition CMS.

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

    public function get_article($post_id=0, $template_filename = 'single.xml.twig')
    {
        // Returns an xml representation of the desired article
        // Takes a parameter, post_id, for manual lookups of post collection field.
        $post = $this->post;
        if ( $post_id > 0 ):
            $post = get_post($post_id);
        endif;

        $context = Timber::get_context();
        $post = new TimberPost();
        $context['post'] = $post;
        ob_start();
        Timber::render(array($template_filename), $context);
        $xml = ob_get_clean();
        return $xml;
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


class DFMRequest
{
    // A class to handle HTTP requests.
    // Example use:
    // $request = new DFMRequest();
    // $curl_options = array(
    //  CURLOPT_URL => $target_url,
    //  CURLOPT_POSTFIELDS => $post,
    //  CURLOPT_RETURNTRANSFER => 1,
    //  CURLOPT_VERBOSE => 1,
    //  CURLOPT_HEADER => 1,
    //  CURLOPT_POST => 1,
    // );
    // if ( $request->curl_options($curl_options) == true ):
    //  $result = $request->curl_execute();
    //  $reponse = $request->curl_results($result);
    //  if ( isset($response) ):
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
        // Return a "user:password" formatted credentials.
        return trim(file_get_contents('.credentials'));
    }

    public function set_url($url)
    {
        return str_replace('%%%CREDENTIALS%%%', $this->credentials, $url);
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

		if(curl_errno($this->cur)):
            echo "ERROR: ";
			echo curl_error($this->cur);
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


// Hard-coded, for now.
include('class.saxo.php');
$params = array('');
$target_urls = array(
    'user' => 'https://%%%CREDENTIALS%%%@mn1reporter.saxotech.com/ews/products/1/users/944621807',
    'article' => 'https://%%%CREDENTIALS%%%@mn1reporter.saxotech.com/ews/products/1/stories?timestamp=' . time(),
    'textformats' => 'https://%%%CREDENTIALS%%%@mn1reporter.saxotech.com/ews/products/1/textformats/720743380?timestamp=' . time()
    );
$post = file_get_contents('saxo/st2saxo.xml');
$request = new DFMRequest();
$curl_options = array(
    CURLOPT_URL => $request->set_url($target_urls['article']),
    //CURLOPT_POSTFIELDS => http_build_query($params),
    CURLOPT_POSTFIELDS => $post,
    CURLOPT_RETURNTRANSFER => 1,
    CURLOPT_VERBOSE => 1,
    CURLOPT_HEADER => 1,
    CURLOPT_POST => 1,
    CURLOPT_HTTPHEADER => array('Content-Type: application/xml; charset=UTF-8')
);
if ( $request->curl_options($curl_options) == true ):
    $result = $request->curl_execute();
    $reponse = $request->curl_results($result);
    if ( isset($response) ):
        var_dump($response);
        $request->curl_destroy();
    endif;
endif;
