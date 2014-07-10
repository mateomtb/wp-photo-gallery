<?php
// if new session get a token from tout and store it in the session
session_start();
if (!isset($_SESSION['tout_token'])) {
	$postdata = http_build_query(
	    array(
			'client_id' => 'd6e060aabc12d374819073279d58bb731634dda07dedabb8b037a5300fb32a24',
			'client_secret' => 'cbc716bd04a138556db1341ee591269a00414bf1211d11f5d2b69413ddcafc15',
			'grant_type' => 'client_credentials'
	    )
	);

	$opts = array('http' =>
	    array(
	        'method'  => 'POST',
	        'header'  => 'Content-type: application/x-www-form-urlencoded',
	        'content' => $postdata
	    )
	);

	$context  = stream_context_create($opts);

	$result = json_decode(file_get_contents('https://www.tout.com/oauth/token', false, $context));
  	$_SESSION['tout_token'] = $result->access_token;
}
// get some touts
if (isset($_REQUEST['stream'])) {
	$stream = $_REQUEST['stream'];
	$results = file_get_contents('https://api.tout.com/api/v1/streams/'.$stream.'/touts?access_token='.$_SESSION['tout_token']);		
}

echo $results;
?>
