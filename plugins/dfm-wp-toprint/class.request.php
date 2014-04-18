<?php

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
    var $print_cms_id;

    function __construct()
    {
        $this->cur = curl_init();
        $this->path_prefix = '';
        if ( function_exists('plugin_dir_path') ):
            $this->path_prefix = plugin_dir_path( __FILE__ );
        endif;
        $this->credentials=$this->get_credentials();
    }

    public function set_print_cms_id($value)
    {
        // Should we need to edit the print_cms_id
        $this->print_cms_id = $value;
        return $this->print_cms_id;
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
        $url = str_replace('%%%STORYID%%%', $this->print_cms_id, $url);
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
