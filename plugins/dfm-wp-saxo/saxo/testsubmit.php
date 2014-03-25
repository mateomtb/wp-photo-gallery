<?php
	
	
	SendFileToSaxo();
	function SendFileToSaxo() {
		$target_url = 'http://' . $login . '@cjohnson-development.mn1.dc.publicus.com/apps/ows.dll/sites/la/stories';
		
		$post = file_get_contents( 'TestFile.xml' ) or die('ouch1');
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_VERBOSE, 1);
		curl_setopt($ch, CURLOPT_HEADER, 1);

		curl_setopt($ch, CURLOPT_URL,$target_url);
		curl_setopt($ch, CURLOPT_POST,1);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $post);

		$result=curl_exec ($ch) or die('error1');
		//echo ':'. $result . ':';


		//---get header info
		$header_size = curl_getinfo($ch, CURLINFO_HEADER_SIZE);
		$header = substr($result, 0, $header_size);
		$body = substr($result, $header_size);

		echo $header . '<BR>';
		echo $body . '<BR>';
		
		if(curl_errno($ch))
			print curl_error($ch);
		else
			curl_close($ch);
	}


	//mainAttempt();
	function mainAttempt() {
		// Load the XML source
		$xml = new DOMDocument;
		//$xml->load('collection.xml');
		$xml->load('article.xml');

		$xsl = new DOMDocument;
		//$xsl->load('collection.xslt');
		$xsl->load('article.xslt');

		// Configure the transformer
		$proc = new XSLTProcessor;
		$proc->importStyleSheet($xsl); // attach the xsl rules

		$xDoc = $proc->transformToXML($xml);
		//echo $xDoc; die();
		$xDoc = trim(file_get_contents( 'TestFile.xml' )) or die('ouch1');

		$login = file_get_contents('.credentials');
			//$url = 'http://'. $login .'@cjohnson-development.mn1.dc.publicus.com/apps/ows.dll/sites/la/stories';


		//http://CJohnson:TxGxA7vC@cjohnson-development.mn1.dc.publicus.com/apps/ows.dll/sites/la/stories

		/*
		as type/text xml as the content of the body
		have to set header

		content type and then the body

		gives back xml story id
		*/



		$target_url = 'http://' . $login . '@cjohnson-development.mn1.dc.publicus.com/apps/ows.dll/sites/la/stories';
		//This needs to be the full path to the file you want to send.
		//$file_name_with_full_path = realpath('article1.xml');
		
			//return;
		        /* curl will accept an array here too.
		         * Many examples I found showed a url-encoded string instead.
		         * Take note that the 'key' in the array will be the key that shows up in the
		         * $_FILES array of the accept script. and the at sign '@' is required before the
		         * file name.
		         */
		//$post = array('Location'=>'@'.$xDoc);
		   //$post = array('file'=>'@'.$file_name_with_full_path);
		    
		//$post = $xDoc;
		$post = $xDoc;//array('file'=>$xDoc);
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL,$target_url);
		curl_setopt($ch, CURLOPT_POST,1);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $post);

		//curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
		//curl_setopt($ch, CURLOPT_USERPWD, $login);
		//curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
		//curl_setopt($ch, CURLOPT_VERBOSE, 1);\

		//curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-type: application/x-www-form-urlencoded'));
		echo '1<BR>';
		//curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.1; SV1; .NET CLR 1.0.3705; .NET CLR 1.1.4322)');
		$result=curl_exec ($ch) or die('error1');
		echo '2<BR>';
		//curl_close ($ch);
		echo ':'. $result . ':';

		if(curl_errno($ch))
			print curl_error($ch);
		else
			curl_close($ch);


		    /*

			//CURLOPT_HTTPHEADER 	An array of HTTP header fields to set, in the format array('Content-type: text/plain', 'Content-length: 100') 
			//"application/x-www-form-urlencoded"	MJ set this

		    public string postStory(Uri address, string username, string password, string strData ,ref string message)
	        {
	            string location = "";
	            try
	            {
	                WebClient wc = new WebClient();
	                wc.Credentials = new System.Net.NetworkCredential(username, password);
	                byte[] bret = wc.UploadData(address, "POST", System.Text.Encoding.ASCII.GetBytes(strData));
	                string sret = System.Text.Encoding.ASCII.GetString(bret);
	                location = wc.ResponseHeaders["Location"].ToString();
	            }
	            catch (Exception e)
	            {
	                message = e.Message;
	            }
	            return location;
	        } // postStory
	        */

	        /*
	        CURLOPT_HTTPHEADER 	An array of HTTP header fields to set, in the format array('Content-type: text/plain', 'Content-length: 100')
	        */
	}
	

	function olderAttempt() {
		//http://username:password@www.mydomain.com/directory/
		$login = '*****';
		$url = 'http://'. $login .'@cjohnson-development.mn1.dc.publicus.com/apps/ows.dll/sites/la/stories';
		//$homepage = file_get_contents( $url );
		//echo $homepage;

		//return;


		$target_url = 'http://cjohnson-development.mn1.dc.publicus.com/apps/ows.dll/sites/la/stories';
	        //This needs to be the full path to the file you want to send.
		$file_name_with_full_path = realpath('story2.xml');
		//echo $file_name_with_full_path;
		//return;
	        /* curl will accept an array here too.
	         * Many examples I found showed a url-encoded string instead.
	         * Take note that the 'key' in the array will be the key that shows up in the
	         * $_FILES array of the accept script. and the at sign '@' is required before the
	         * file name.
	         */
		$post = array('payload'=>'@'.$file_name_with_full_path);
	 	//$post = array('onl:heading'=>'Jargon', 'onl:kicker'=>'xNet Heading');
	    $ch = curl_init();
		curl_setopt($ch, CURLOPT_URL,$target_url);
		curl_setopt($ch, CURLOPT_POST,1);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
	    curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
	    curl_setopt($ch, CURLOPT_USERPWD, $login);
		curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
		//curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.1; SV1; .NET CLR 1.0.3705; .NET CLR 1.1.4322)');
		$result=curl_exec ($ch) or die('error2');
		//curl_close ($ch);
		echo ':'. $result . ':';

		if(curl_errno($ch))
	    	print curl_error($ch);
		else
	    	curl_close($ch);

		/*
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_USERPWD, "$username:$password");
		curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
		$output = curl_exec($ch);
		$info = curl_getinfo($ch);
		curl_close($ch);
		*/



		/*
		//$url = 'http://server.com/path';
		$data = array('key1' => 'value1', 'key2' => 'value2');

		// use key 'http' even if you send the request to https://...
		$options = array(
		    'http' => array(
		        'header'  => "Content-type: application/x-www-form-urlencoded\r\n",
		        'method'  => 'POST',
		        'content' => http_build_query($data),
		    ),
		);
		$context  = stream_context_create($options);
		$result = file_get_contents($url, false, $context);

		var_dump($result);
		*/
	}



	//this seems to not cause an error, but i am unsure its actually making the connection
	//anotherAttempt();
	function anotherAttempt() {
		echo '1<BR>';
		$xmldatafile=realpath('article1.xml'); // Make sure the file path is correct
		$xmlData = file_get_contents($xmldatafile);
		$postFields = array('file'=>'@'.$xmldatafile);
		//$postFields = 'data='.$xmlData; 
		$result = postData($postFields,'http://cjohnson-development.mn1.dc.publicus.com/apps/ows.dll/sites/la/stories');
		echo '3<BR>';
		die();
	}

	function postData($postFields,$url){
					echo '2<BR>';
					$login = '******';
	                $ch = curl_init(); 
	                curl_setopt($ch, CURLOPT_URL, $url); 
	                curl_setopt($ch, CURLOPT_POST ,1); 
	                curl_setopt($ch, CURLOPT_POSTFIELDS ,$postFields); 
	                curl_setopt($ch, CURLOPT_FOLLOWLOCATION ,1); 
	                curl_setopt($ch, CURLOPT_HEADER ,0);
	                curl_setopt($ch, CURLOPT_USERPWD, $login);
	                curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
	                curl_setopt($ch, CURLOPT_RETURNTRANSFER ,1); 
	                $data = curl_exec($ch); 
	                curl_close($ch);
	                echo '22<BR>';

	                if(curl_errno($ch))
				    	print curl_error($ch);
					else
				    	curl_close($ch);

	                return $data; 
	} 


	//nonGrepAttempt();		//does not seem to be working
	function nonGrepAttempt() {
		$xml = file_get_contents('article1.xml');
		
		$login = '******';
		$url = 'http://'. $login .'@cjohnson-development.mn1.dc.publicus.com/apps/ows.dll/sites/la/stories';

		$post_data = array(
		    "xml" => $xml,
		);

		$stream_options = array(
		    'http' => array(
		       'method'  => 'POST',
		       'header'  => "Content-type: application/x-www-form-urlencoded\r\n",
		       'content' => http_build_query($post_data),
		    ),
		);

		$context  = stream_context_create($stream_options);
		$response = file_get_contents($url, null, $context);
		echo $response . ' bing!';
	}

?>
