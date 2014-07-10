<?php
include( $_SERVER['DOCUMENT_ROOT'] . '/wp-blog-header.php');
//echo $_SERVER['DOCUMENT_ROOT'];
if (session_id() == "") { @session_start(); }
if ( !isset($_SESSION['wp_table'], $_SESSION['StartDate'], $_SESSION['EndDate'])){
    $_SESSION['SiteName'] = $_POST["SiteName"];
    $_SESSION['wp_table'] = $_POST["wp_table"];
    $_SESSION['StartDate'] = $_POST["StartDate"];
    $_SESSION['EndDate'] = $_POST["EndDate"];
    $_SESSION['smugmugurl'] = $_POST["smugmugurl"];
    $_SESSION['apivalue'] = $_POST["apivalue"];
}

//include(dirname(__FILE__) . '/classes/DirectorPHP.php');
//include(dirname(__FILE__) . '/share_functions.php');
/*
$username="root";
$password="root";
$database="localmc";
set_time_limit(0);

mysql_connect(localhost,$username,$password);
@mysql_select_db($database) or die( "Unable to select database");
 */
//$queryposts = "SELECT * FROM " . $_SESSION['wp_table'] . "_posts WHERE post_date BETWEEN '" . $_SESSION['StartDate'] . "' AND '" . $_SESSION['EndDate'] . "'";

$queryposts = "SELECT * FROM wp_14_posts WHERE post_date BETWEEN '2012-07-01 00:00:00' AND '2012-07-05 23:59:59'";

//$queryposts = "SELECT * FROM " . $table[0];

$posts = $wpdb->get_results($queryposts);
//var_dump($posts);
//$postsnum = count($posts);
//echo "posts " . $postsnum;


foreach ($posts as $thapost){
	$content = $thapost->post_content;
	$title = $thapost->post_title;
	$post_ID = $thapost->ID;
	$postParent = $thapost->post_parent;
	$postDate = $thapost->post_date;
	$hasSmug = false;
	

		//If the post is not a revision and contains the SSP shortcode begin the loop.
		//narrow down to this sites ssp api value so we only get this sites ssp content we don't want to update the syndicated stuff
	if($postParent == 0 && strpos($content, 'api="' . $_SESSION['apivalue'] . '"' )){
		echo "<br> title=" . $title . "<br>";
		echo "post id = " . $post_ID . "<br>";
		//Check the post for insertSmugmug and add it if necessary.
		if(strpos($content, "[insertSmugmug]") == false){
		echo "NO INSERT SMUGMUG.<br>";

		$content = $content . " [insertSmugmug]";
		//$insertSmugQuery = "UPDATE " . $_SESSION['wp_table'] . "_posts SET post_content=\"" . mysql_real_escape_string($content) . "\" WHERE ID =\"" . $post_ID . "\""; 
		
		//$wpdb->update($wpdb->wp_14_posts, array("post_content" => stripslashes($content)), array("ID" => $post_ID, "post_parent" => "0"), array("%s"));		
		$insertSmugQueryRev = "UPDATE " . $_SESSION['wp_table'] . "_posts SET post_content=\"" . mysql_real_escape_string($content) . "\" WHERE ID = \"" . $post_ID . "\"";
		echo $insertSmugQueryRev . "<br>";
		$update_the_post = $wpdb->query($insertSmugQueryRev); 
		//mysql_query($insertSmugQuery);		
		//mysql_query($insertSmugQueryRev);		
		}	
		echo "CONTENT " . $content;	
		$isolatedShortcodes = explode("[", $content);
		$isolatedValues = explode("\"", $isolatedShortcodes[1]);
		//Store the SSP data as meta tags if they don't exist.		
		$albumID = explode("=" , $isolatedValues[1]);
		echo "<br><strong>The ID of the album is: </strong>" . $albumID[1];
		//$IDcheck = mysql_query("SELECT * FROM `" . $_SESSION['wp_table'] . "_postmeta` WHERE (`meta_key`= 'SSPAlbumID') AND (`post_id` =" . $post_ID . ")");
		
		//query to see if SSPAlbumID meta key exists
		$sspid = "SELECT * FROM `" . $_SESSION['wp_table'] . "_postmeta` WHERE (`meta_key`= 'SSPAlbumID') AND (`post_id` =" . $post_ID . ")";
		$IDcheck = $wpdb->get_results($sspid);
		
		//$IDcount = mysql_numrows($IDcheck);
		
		if (empty($IDcheck)){	
		
		$metaSSPID = "INSERT INTO " . $_SESSION['wp_table'] . "_postmeta VALUES ('NULL', '" . $post_ID . "', 'SSPAlbumID', '" . $albumID[1] . "')";
		
		
		//no SSPAlbumID meta key create it
		
		$wpdb->insert($_SESSION['wp_table'] . "_postmeta", array("meta_key" => "SSPAlbumID", "meta_value" => $albumID[1]));

		echo "<br>Custom Fieled SSPAlbumID added " . $albumID[1] .  "<br>";
		}
									
		$api = $isolatedValues[3];
		$APIcheck = "SELECT * FROM `" . $_SESSION['wp_table'] . "_postmeta` WHERE (`meta_key`= 'SSPAPI') AND (`post_id` =" . $post_ID . ")";
		$APIcount = $wpdb->get_results($APIcheck);
		if (empty($APIcount)){
		
		$metaSSPAPI = "INSERT INTO " . $_SESSION['wp_table'] . "_postmeta VALUES ('NULL', '" . $post_ID . "', 'SSPAPI', '" . $api . "')";
		
		$wpdb->insert($_SESSION['wp_table'] . "_postmeta", array("meta_key" => "SSPAPI", "meta_value" => $api));
		
		echo "<br>Custom Field SSPAPI added " . $api .  "<br>";
		}	
	
	//BRAIN I GOT TO HERE
	
		//setup ssp Director instance
		$director = setSSPcodes( $api );
		$album = $director->album->get($albumID[1]);
		echo "<br><strong>The API of the site is: </strong>" . $api . "<br>";
		//var_dump($album);
		
		//Count ssp director album images and check forsale info
		$contents = $album->contents;
		$total_images = count($contents);
		$printable = "false";
		foreach ($contents as $imgsrc) {
			if ($imgsrc->title == "forsale" || $imgsrc->title == "forsale"){
				$printable = "true";
				break;
			}
		}
		
		
		//Does the post have smugdata already?

		$Smugyes = "SELECT * FROM `" . $_SESSION['wp_table'] . "_postmeta` WHERE (`meta_key`= 'smugdata') AND (`post_id` =" . $post_ID . ")";
		$Smugcheck = $wpdb->get_results($Smugyes);
//var_dump($Smugcheck);
		echo "<br>SMUG KEY: " . $Smugcheck[0]->meta_value;
		$Smugcount = $wpdb->num_rows;
		//$smugDataResult = mysql_fetch_assoc($Smugcheck);
		//make sure if there is a smugdata value, did it really create a new album albumkey and albumid
		// parse the smugdata to get the album key and id
		$pq = parse_url($Smugcheck[0]->meta_value, PHP_URL_QUERY);
        $qatts = array();
	    parse_str($pq, $qatts);
		//check the values
	    if (empty($qatts['AlbumID'])){
			//no smug values exist or there was smugdata but no values for the key or album lets try again to create an album in smug
	    	$hasSmug = "new_album";
	    } elseif ($Smugcount > 0) {
			//there were values let's go make sure the images match.


			$hasSmug = "check_album";
		}
		
		//setup smugmug connection
		//set smug url that we want to upload to
		$smugURL = $_SESSION['smugmugurl'];
        // SMUGMUG caching            
		$smugvalues = getSmugApi($smugURL);//returns smug values for these images based on what instance they are in
		$tokenarray = unserialize($smugvalues[0]['smug_token']);
        $cachevar = dirname(__FILE__) . 'smugcache';	
        // APC Cache Version
		$f = new phpSmug("APIKey={$smugvalues[0]['smug_api_key']}", "AppName=DFM Photo Gallery 1.0", "OAuthSecret={$smugvalues[0]['smug_secret']}", "APIVer=1.3.0");
		$cache_result = $f->enableCache("type=apc", "cache_dir={$cachevar}", "cache_expire=180" );
		//echo "<!-- CACHE RESULT: $cache_result -->\n";		
		$f->setToken( "id={$tokenarray['Token']['id']}", "Secret={$tokenarray['Token']['Secret']}" );
		
		
		//Create a new album and upload everything from SSP because the album did not exist or some values were missing.
		if ($hasSmug=="new_album") {
			echo "need to create a new gallery!<br>";
			//setup a log
			$site = "logs/" . $_SESSION['SiteName'] . $_SESSION['StartDate'] . "_" . $_SESSION['EndDate'] . ".txt";
			$siteFileHandle = fopen($site, 'a') or die("can't open file");
			$sspalbumstring = "SSP Album <<<" . $albumID[1] . ">>> In instance " . $_SESSION['apivalue'];
			fwrite($siteFileHandle, $sspalbumstring);
			//var_dump($f);
			//create new smug album
			$newAlbum = $f->albums_create("Title={$title}_{$postDate}", "Protected=true", "Printable=$printable", "Public=false", "Larges=true", "Originals=false", "X2Larges=false", "X3Larges=false", "XLarges=false");
			//var_dump ($newAlbum);
			$smugAlbumID = strval($newAlbum['id']);
			$smugAlbumKey = $newAlbum['Key'];
			$smugdata = $smugURL . "/gallery/settings.mg?AlbumID=" . $smugAlbumID . "&AlbumKey=" . $smugAlbumKey;		
			$metaSmugData = "INSERT INTO " . $_SESSION['wp_table'] . "_postmeta VALUES ('NULL', '" . $post_ID . "', 'smugdata', '" . $smugdata . "')";
			echo "<br>" . $metaSmugData . "<br>";
			$wpdb->get_results($metaSmugData);
			//loop through SSP info and upload to new smug album
			foreach ($contents as $imgsrc) {		
				$imageURL = $imgsrc->original->url;
				$imageCaption = $imgsrc->caption;
				$forsale = $imgsrc->title;	
				$imageupload = $f->images_uploadFromURL("AlbumID=$smugAlbumID" , "URL=$imageURL" , "Caption=$imageCaption");
				$logstring =  "post id = " . $post_ID . " post title = " . $title . " post date = " . $postDate . " new url = " . $imageupload['URL'] . "\n";
				fwrite($siteFileHandle, $logstring);
				echo "new album! " . $logstring . "<br>";
				flush();
    			ob_flush();
				//var_dump($imageupload);
				//echo "<br>";
			}

		}						
		//Count the photos. If the number in Smugmug doesn't match the number in SSP, delete the photos from Smug and reupload
		if ($hasSmug =="check_album"){
			echo "Checking if we need to update <br>";
			$albums = $f->albums_getInfo("AlbumID={$qatts['AlbumID']}", "AlbumKey={$qatts['AlbumKey']}", "Strict=1");
			echo "There are " . $albums['ImageCount'] . " images  already in smug. The original SSP album has " . $total_images . "\n";
			//var_dump($albums);
			if ($albums['ImageCount'] != $total_images){
				//setup log
				$siteupdate = "logs/update" . $_SESSION['SiteName'] . $_SESSION['StartDate'] . "_" . $_SESSION['EndDate'] . ".txt";
				$siteFileHandleupdate = fopen($siteupdate, 'a') or die("can't open file");
				echo "There are " . $albums['ImageCount'] . " images  already in smug. The original SSP album has " . $total_images . "<br>";
				echo "<h1> DO OVER!!!!!!!!!</h1><br>";
				$images = $f->images_get("AlbumID={$qatts["AlbumID"]}", "AlbumKey={$qatts["AlbumKey"]}");
				$images = ( $f->APIVer == "1.3.0" ) ? $images['Images'] : $images;
				//var_dump($images);

				foreach ($images as $imgbust){					
					$imgbustID = $imgbust['id'];
					echo "<br>Image " . $counter . " " . $imgbustID;
					//var_dump($imgbust);					
					$albumReset = $f->images_delete("ImageID={$imgbustID}");	
					echo "<br>";
					//var_dump($albumReset);
					}
				foreach ($contents as $imgsrc) {					
					$imageURL = $imgsrc->original->url;
					$imageCaption = $imgsrc->caption;
					$forsale = $imgsrc->title;
					$imageupload = $f->images_uploadFromURL("AlbumID={$qatts["AlbumID"]}" , "URL=$imageURL" , "Caption=$imageCaption");
					$logstringupdate =  "post id = " . $post_ID . " post title = " . $postDate . " new url = " . $imageupload['URL'] . "\n";
					fwrite($siteFileHandleupdate, $logstring);
					echo "album update! " . $logstringupdate . "<br>";
					flush();
    				ob_flush();
				}
			} else {
			echo "Since the number of images matches no update needed, all is good<br>";
			}
		} 		
		
		echo "<br><br>";
		flush();
    	ob_flush();
	}

}


fclose($siteFileHandle);
//mysql_close();
session_destroy();
?>
