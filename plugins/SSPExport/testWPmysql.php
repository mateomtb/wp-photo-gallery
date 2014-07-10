<?php
$username="root";
$password="p1press";
$database="mc";
set_time_limit(0);

include('classes/DirectorPHP.php');

function setSSPcodes( $api ) {
    require(dirname(__FILE__) . '/includes/sspcodes.php');
    return $director;
}



//$director = new Director('your-api-key', 'your-api-path');


mysql_connect(localhost,$username,$password);
@mysql_select_db($database) or die( "Unable to select database");

$queryCompleteList = "SHOW TABLES"; 
$completeList = mysql_query($queryCompleteList);
$dbnum = mysql_numrows($completeList);
//while($table = mysql_fetch_row($completeList))
    //{
	//if(strpos ($table[0], "posts")) {	        
		//echo "<br>POSTS " . $table[0] . "\n";
		$queryposts = "SELECT * FROM wp_14_posts";
		//$queryposts = "SELECT * FROM " . $table[0];
		$posts = mysql_query($queryposts);
		$postsnum=mysql_numrows($posts);
		$querymeta = "SELECT * FROM wp_14_postmeta";
		//$querymeta = "SELECT * FROM " . substr($table[0], -1);
		$meta = mysql_query($querymeta);
		$metanum=mysql_numrows($meta);	
		echo "Number of posts = " . $postsnum . "<br>";
	//}


$i=5100;
while ($i < $postsnum) {
	$post_ID = mysql_result($posts, $i, "ID");
	$author = mysql_result($posts, $i, "post_author");
	$postDate = mysql_result($posts, $i, "post_date");
	$postDateGMT = mysql_result($posts, $i, "post_date_gmt");
	$content = mysql_result($posts, $i, "post_content");
	$title = mysql_result($posts, $i, "post_title");
	$excerpt = mysql_result($posts, $i, "post_excerpt");
	$postStatus = mysql_result($posts, $i, "post_status");
	$commentStatus = mysql_result($posts, $i, "comment_status");
	$pingStatus = mysql_result($posts, $i, "ping_status");
	$postPassword = mysql_result($posts, $i, "post_password");
	$postName = mysql_result($posts, $i, "post_name");
	$toPing = mysql_result($posts, $i, "to_ping");
	$pinged = mysql_result($posts, $i, "pinged");
	$postModified = mysql_result($posts, $i, "post_modified");
	$postModifiedGMT = mysql_result($posts, $i, "post_modified_gmt");
	$postContentFiltered = mysql_result($posts, $i, "post_content_filtered");
	$postParent = mysql_result($posts, $i, "post_parent");
	$guid = mysql_result($posts, $i, "guid");
	$menuOrder = mysql_result($posts, $i, "menu_order");
	$postType = mysql_result($posts, $i, "post_type");
	$postMimeType = mysql_result($posts, $i, "post_mime_type");
	$commentCount = mysql_result($posts, $i, "comment_count");


if($postParent == 0){

	echo "<br>" . $title;
	echo "<br><strong>Post ID: </strong>" . $post_ID;
	echo "<br><strong>Author: </strong>" . $author;
	echo "<br><strong>Post Date: </strong>" . $postDate;
	echo "<br><strong>Post Date GMT: </strong>" . $postDateGMT;
	echo "<br><strong>Content: </strong>" . $content;
	echo "<br><strong>Excerpt: </strong>" . $excerpt;
	echo "<br><strong>Post Status: </strong>" . $postStatus;
	echo "<br><strong>Comment Status: </strong>" . $commentStatus;
	echo "<br><strong>Ping Status: </strong>" . $pingStatus;
	echo "<br><strong>Post Password: </strong>" . $postPassword;
	echo "<br><strong>Post Name: </strong>" . $postName;
	echo "<br><strong>To Ping:</strong>" . $toPing;
	echo "<br><strong>Pinged: </strong>" . $pinged;
	echo "<br><strong>Post Modified: </strong>" . $postModified;
	echo "<br><strong>Post Modified GMT:</strong>" . $postModifiedGMT;
	echo "<br><strong>Post Content Filtered: </strong>" . $postContentFiltered;
	echo "<br><strong>Post Parent: </strong>" . $postParent;
	echo "<br><strong>GUID: </strong>" . $guid;
	echo "<br><strong>Menu order: </strong>" . $menuOrder;
	echo "<br><strong>Post Type: </strong>" . $postType;
	echo "<br><strong>Post Mime Type: </strong>" . $postMimeType;
	echo "<br><strong>Comment Count: </strong>" . $commentCount;


if(strpos($content, "[insertSlideshowjava " )){
	echo "<br><strong>THIS CONTAINS SSP</strong>";	
	$isolatedShortcodes = explode("[", $content);
	foreach($isolatedShortcodes as $piece){
		if (strpos($piece, "nsertSlideshowjava")){
		$isolatedValues = explode("\"", $piece);		
		}
	}	
	
	
	$albumID = explode("=" , $isolatedValues[1]);
	echo "<br><strong>The ID of the album is: </strong>" . $albumID[1];
	$api = $isolatedValues[3];
	echo "<br><strong>The API of the site is: </strong>" . $api;
	$director = setSSPcodes( $api );
	echo "<br><strong>The contents of the album are : </strong><br>";
	

	# Make API call using get_album method. Replace "1" with the numerical ID for your album

	$album = $director->album->get($albumID[1]);
	//var_dump($album);

	# Set images variable for easy access

	$contents = $album->contents;
	$total_images = count($contents);
	//echo '<pre>'. $contents[0]->src .'</pre>';
	foreach ($contents as $imgsrc) {
		echo "<br>" . $imgsrc->original->url;
	}



}

	$j=0;
	while ($j < $metanum) {
	$metaPostID = mysql_result($meta, $j, "post_id");
	if ($metaPostID == $post_ID) {
		//echo "<br>The meta ID is" . $metaPostID;
		$metaKey = mysql_result($meta, $j, "meta_key");
		$metaValue = mysql_result($meta, $j, "meta_value");
		echo "<br>" . $metaKey;
		echo ": " . $metaValue;
		}
	$j++;

	}
echo "<br><br>";

}



$i++;
}

//}


mysql_close();

?> 
