<?php
	$login = file_get_contents('.credentials');

	//SendFileToSaxo();
	function SendFileToSaxo() {
		global $login;
		$target_url = 'http://'. $login .'@cjohnson-development.mn1.dc.publicus.com/apps/ows.dll/sites/22/stories';
		
		$post = getXmlFromXSL( 'article.xml', 'article.xslt');

		//$post = file_get_contents( 'TestFile.xml' ) or die('ouch1');
		//$post = file_get_contents( 'article1.xml' ) or die('ouch1');
		//die( $post );
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

	function getXmlFromXSL( $xmlFile, $xTemplate) {
		//this function uses the templates/xml files Peter B sent Joe & I to dynamically render article xml content from article.xml
		$xml = new DOMDocument;
		$xml->load( $xmlFile );
		$xsl = new DOMDocument;
		$xsl->load( $xTemplate );
		// Configure the transformer
		$proc = new XSLTProcessor;
		$proc->importStyleSheet($xsl); // attach the xsl rules
		return $proc->transformToXML($xml);
	}

?>