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

    public function get_article($post_id=0)
    {
        // Returns an xml representation of the desired article
        // Takes a parameter, post_id, for manual lookups of post collection field.
        $post_id = 1;
        $post = $this->post;
        if ( $post_id > 0 ):
            $post = get_post($post_id);
        endif;

        if ( !class_exists('Timber') ):
        include($this->path_prefix . '/../timber/timber.php');
        endif;
        $context = Timber::get_context();
        $context['product_id'] = 1; // *** HC for now
        $context['author_print_id'] = 944621807; // *** HC for now
        $post = new TimberPost();
        $context['post'] = $post;
        ob_start();
        Timber::render(array($this->article_template), $context);
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
        $this->path_prefix = '';
        if ( function_exists('plugin_dir_path') ):
            $this->path_prefix = plugin_dir_path( __FILE__ );
        endif;
        $this->credentials=$this->get_credentials();
    }

    private function get_credentials()
    {
        // Return a "user:password" formatted credentials.
        $credentials = trim(file_get_contents($this->path_prefix . '.credentials'));
        if ( $credentials == FALSE || $credentials == '' ):
            die('No .credentials file in dfm-wp plugin directory available.' . "\n");
        endif;
        return $credentials;
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
    $fm->add_meta_box( 'ToPrint', array( 'post' ) );
    endif;
} );


// Hard-coded, for now.
include('class.saxo.php');
