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
    var $article_template;

    function __construct($post)
    {
        $this->article_template = 'single.xml.twig';
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
        endswitch;
    }

    function set_post($value)
    {
    }

    function set_article_template($value)
    {
    }

    public function get_article($post_id=0)
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
    //  $request->curl_results($result);
    //  if ( isset($request->response) ):
    //      var_dump($request->response);
    //      $request->curl_destroy();
    //  endif;
    // endif;

    var $cur;
    var $response;

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
        $url = str_replace('%%%CREDENTIALS%%%', $this->credentials, $url);
        $url = str_replace('%%%PRODUCTID%%%', 1, $url); //***HC***
        $url = str_replace('%%%USERID%%%', 944621807, $url); //***HC***
        return $url;
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
		$header_size = curl_getinfo($this->cur, CURLINFO_HEADER_SIZE);
		$header = substr($result, 0, $header_size);

        // Cycle through the parts of the header
        $response = array('body' => '', 'header' => array('responsecode' => ''), 'error' => '');
        foreach ( explode("\n", $header) as $key => $value ):
            if ( trim($value) == '' ):
                continue;
            endif;
            // If we have a colon then it's a name/value pair we want to parse
            // and add to $response['header'].
            // If we don't have a colon then it's a HTTP response code.
            if ( strpos($value, ':') > 0 ):
                $namevalue = explode(': ', $value);
                $response['header'][$namevalue[0]] = trim($namevalue[1]);
            else:
                $response['header']['responsecode'] .= trim($value) . "\n";
            endif;
        endforeach;
		$response['body'] = substr($result, $header_size);

		if(curl_errno($this->cur)):
            echo "ERROR: ";
			echo curl_error($this->cur);
            $response['error'] = curl_error($this->cur);
        endif;

        $this->response = $response;
        return $response;
    }

    public function curl_destroy()
    {
        // Wrapper for curl_close()
	    curl_close($this->cur);
        return true;
    }
}

// *******************
//
// CUSTOM FIELDS
//
// *******************
if ( class_exists('Fieldmanager_Group') ):
// We don't need to display these in the post-edit interface, we
// just need them available to us robots.
add_action( 'init', function() {
  $fm = new Fieldmanager_Group( array(
        'name' => 'toprint_article_fields',
        'children' => array(
            'print_cms_id' => new Fieldmanager_Textfield( 'Print CMS ID' ),
        ),
    ) );
} );
endif;


// Hard-coded, for now.
include('class.saxo.php');
$target_urls = array(
    'user' => 'https://%%%CREDENTIALS%%%@mn1reporter.saxotech.com/ews/products/%%%PRODUCTID%%%/users/%%%USERID%%%',
    'article' => 'https://%%%CREDENTIALS%%%@mn1reporter.saxotech.com/ews/products/%%%PRODUCTID%%%/stories?timestamp=' . time(),
    'textformats' => 'https://%%%CREDENTIALS%%%@mn1reporter.saxotech.com/ews/products/%%%PRODUCTID%%%/textformats/720743380?timestamp=' . time()
    );


$request = new DFMRequest();
$curl_options = array(
    CURLOPT_URL => $request->set_url($target_urls['article']),
    //CURLOPT_POSTFIELDS => http_build_query($params),
    CURLOPT_POSTFIELDS => file_get_contents('saxo/story.xml'),
    CURLOPT_RETURNTRANSFER => 1,
    CURLOPT_VERBOSE => 1,
    CURLOPT_HEADER => 1,
    CURLOPT_POST => 1,
    CURLOPT_HTTPHEADER => array('Content-Type: application/xml; charset=UTF-8')
);
if ( $request->curl_options($curl_options) == true ):
    $result = $request->curl_execute();
    $request->curl_results($result);
    if ( isset($request->response) ):
        $request->curl_destroy();
    endif;
endif;

// Saxo-specific
// If we've created a new article, we want to associate its saxo-id
// with the article in WP.
if ( isset($request->response['header']['Location']) ):
    // *** add check to see if value already exists in custom field.
endif;
