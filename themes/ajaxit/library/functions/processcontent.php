<?php

//-----this is an include that processes the content of a post into variables, without outputting it to screen
$content = get_the_content();

//if ( count( $content ) > 1 ) {
if (strpos($content,'[insertSlideshowjava ') !== false) {
	//----------------------------------------------------------------------------slide show pro
	$content = explode('[insertSlideshowjava ', $content);
	$temp = explode('"', $content[1] );
	
	//$content = str_replace('<span id="more-17710"></span>', "", $content[0]);
	$content = strip_tags($content[0]);

	//$description = trim( htmlspecialchars( $content, ENT_QUOTES) );
	//$description = str_replace("\r","",trim( $content ) );
	$description = str_replace("\r","",trim( htmlspecialchars( $content, ENT_QUOTES) ) );
	$description = str_replace("\n","",$description );
	//echo 'description: '. $description . ':<BR><BR>';

	//$title = trim( htmlspecialchars( the_title(' ', ' ', false), ENT_QUOTES) );
	$title = str_replace("\r","",trim( the_title('', '', false)) );
	//$title = trim( the_title(' ', ' ', false) );

	//global $more; $more = 1;       //gets rid of extra tags in the_content below:
	//the_content("");

	//Content: The lead singer of the popular group has passed away at age 66. He is survived by his wife and four daughters. [insertSlideshowjava xml="http://twincities.slideshowpro.com/images.php?album=308711" api="tcmc2"]

	//the_time('M d, Y');
	$time = get_the_time('M d, Y');
	//die( $temp[3] );
	//array(2) { ["xml"]=> string(58) "http://twincities.slideshowpro.com/images.php?album=308711" ["api"]=> string(5) "tcmc2" 
	//$xarray = { ["xml"]=> string(58) "http://twincities.slideshowpro.com/images.php?album=308711" ["api"]=> string(5) "tcmc2" };
	$array = array( "xml" => $temp[1], "api" => $temp[3] );
	addShowjava( $array );




} else {
	//----------------------------------------------------------------------------Smugmug
	//die('smugmug');
	$content = explode('[insertSmugmug ', $content);
	$temp = explode('"', $content[1] );

	//$content = str_replace('<span id="more-17710"></span>', "", $content[0]);
	$content = strip_tags($content[0]);

	//$description = trim( htmlspecialchars( $content, ENT_QUOTES) );
    //$description = str_replace("","",trim( $content ) );
	$description = str_replace("\r","",trim( htmlspecialchars( $content, ENT_QUOTES) ) );
    $description = str_replace("\n","",$description );
    $description = str_replace("[insertSmugmug]","", $description );
	//echo 'description: '. $description . ':<BR><BR>';

	//$title = trim( htmlspecialchars( the_title(' ', ' ', false), ENT_QUOTES) );
	$title = str_replace("\r","",trim( the_title('', '', false)) );
	//$title = trim( the_title(' ', ' ', false) );

	//global $more; $more = 1;       //gets rid of extra tags in the_content below:
	//the_content("");

	//Content: The lead singer of the popular group has passed away at age 66. He is survived by his wife and four daughters. [insertSlideshowjava xml="http://twincities.slideshowpro.com/images.php?album=308711" api="tcmc2"]

	//the_time('M d, Y');
	$time = get_the_time('M d, Y');

	//[insertSmugmug smugalbumid="24277728" smugalbumkey="RPpwLJ"]
	//'smugalbumid' => 'no id', 'smugalbumkey' => 'none',
	$array = array( "smugalbumid" => $temp[1], "smugalbumkey" => $temp[3] );
	addsmugmug( $array );
}

?>
