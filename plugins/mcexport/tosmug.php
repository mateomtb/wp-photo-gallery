<?php
include( $_SERVER['DOCUMENT_ROOT'] . '/wp-blog-header.php');
    $_SESSION['SiteName'] = $_GET["SiteName"];
    $_SESSION['MCFolder'] = $_GET["MCFolder"];
    $_SESSION['smugmugurl'] = $_GET['smugmugurl'];
set_time_limit(0);

/* Create mcexport2 table sql:

CREATE TABLE `mcexport2` (
`xmlpath` varchar( 255 ) NOT NULL ,
`smugid` int( 11 ) NOT NULL ,
`smugkey` varchar( 255 ) NOT NULL ,
`totalphotos` int( 11 ) NOT NULL ,
`currentphotos` int( 11 ) NOT NULL ,
`status` varchar( 255 ) NOT NULL
) ENGINE = InnoDB DEFAULT CHARSET = latin1;
*/
$thispage = $_SERVER['REQUEST_URI'];
$refreshtime = "30";
header("Refresh: $refreshtime; url=$thispage");

$dir = "/Users/Bhenderson/Downloads/" . $_SESSION['MCFolder'];
//$dir = '/home/joe/Rss_BREF';

//mysql vars
$username="root";
$password="root";
$database="mc2014ms";
mysql_connect(localhost,$username,$password);
@mysql_select_db($database) or die( "Unable to select database");


//FUNCTION: check category
function mcsmugcategory ($smugObj) {
	$smugcats = $smugObj->categories_get();
	//var_dump($smugcats);
	//Check if there is a mycapture category
	foreach($smugcats as $item){
		//echo $item["Name"];
    		if (isset($item["Name"]) && $item["Name"] == "TorranceMyCapture"){
    			echo "Mycapturelegacy!";
			$catID = $item["id"];
		}
	}

if(!isset($catID)){
	$catID = $smugObj->categories_create("Name=TorranceMyCapture");
}
echo $catID . "<br><br><br>";
return $catID;

}



//FUNCTION: New Album
function mcsmugnewalbum ($mcXMLPath, $mcXMLFile, $smugObj, $albumcatID, $retry){
	//var_dump ($mcXMLPath);
	//var_dump ($mcXMLFile);
	//var_dump ($albumcatID);
	//var_dump ($smugObj);
	//var_dump ($albumLog);
	//var_dump ($retry);
	$title = $mcXMLFile->channel->EVENT_TITLE;
	//echo "yolo title";
	//var_dump($title);
	echo "<h1>ALBUM PATH: " . $mcXMLPath . "</h1>";
	$newAlbum = $smugObj->albums_create("Title=$title", "CategoryID=$albumcatID", "Protected=true", "Printable=true", "Public=true", "Larges=true", "Originals=false", "X2Larges=false", "X3Larges=false", "XLarges=false", "SmugSearchable=true");
	//var_dump ($smugObj);
	$smugAlbumID = strval($newAlbum['id']);
	$smugAlbumKey = $newAlbum['Key'];
	$totalImages = count($mcXMLFile->channel->item);

	if ($smugAlbumID == "" || $smugAlbumKey == ""){mcsmugnewalbum ($mcXMLPath, $mcXMLFile, $smugObj, $albumcatID, $retry);}
	if ($retry == false){
		$processedquery = "INSERT INTO mcexport2 VALUES ('$mcXMLPath', '$smugAlbumID', '$smugAlbumKey' ,'$totalImages','0','NEW')";
		echo $processedquery;
		mysql_query($processedquery) or die('query failed:'.mysql_error().'<br/>sql:'.$sql.'<br/>');
		return $newAlbum;
	}
	else {
		$processedquery = "UPDATE mcexport2 SET smugid='" . $smugAlbumID . "' , smugkey='" . $smugAlbumKey . "' WHERE xmlpath='" . $mcXMLPath  . "' totalphotos='" . $totalimages . "' currentphotos='0' status='NEW' WHERE xmlpath='" . $mcXMLPath  . "'";
		echo $processedquery;
		mysql_query($processedquery) or die('query failed:'.mysql_error().'<br/>sql:'.$sql.'<br/>');
		return $newAlbum;
	}
}

//FUNCTION: Check Album
function mcsmugcheckalbum ($xmlpath, $MCXML, $smugObj){

	$resumequery = "SELECT * FROM mcexport2 WHERE xmlpath = '" . $xmlpath . "'";
	echo $resumequery;
	$resumeresult = mysql_query($resumequery) or die('query failed:'.mysql_error().'<br/>sql:'.$sql.'<br/>');
	$errors = array();
	while ($entry = mysql_fetch_array($resumeresult)){
		if($entry['xmlpath'] == $xmlpath){
			$checkID = $entry['smugid'];
			$checkKey = $entry['smugkey'];
			$currentphotos = $entry['currentphotos'];
			$status = $entry['status'];
		}
	}

	echo "Checking if we need to update<br>";
	$albums = $smugObj->albums_getInfo("AlbumID={$checkID}", "AlbumKey={$checkKey}", "Strict=1");
	if ($albums['ImageCount'] != count($MCXML->channel->item)){
		echo "There are " . $albums['ImageCount'] . " images  already in smug. The original MyCapture album has " . count($MCXML->channel->item) . "<br>";
		echo "<h1> Image count does not match or this is a new album</h1><br>";
		$images = $smugObj->images_get("AlbumID={$checkID}", "AlbumKey={$checkKey}");
		$images = ( $smugObj->APIVer == "1.3.0" ) ? $images['Images'] : $images;
		//var_dump($images);
		if ($status == "DONE"){
			foreach ($images as $imgbust){					
				$imgbustID = $imgbust['id'];
				echo "<br>Image " . $counter . " " . $imgbustID;
				//var_dump($imgbust);					
				$albumReset = $smugObj->images_delete("ImageID={$imgbustID}");	
				echo "<br>";
				//var_dump($albumReset);
				}
			}

		else{
			$i = $albums['ImageCount'];
			$statusquery = "UPDATE mcexport2 SET status = 'IN_PROG' WHERE xmlpath='" . $xmlpath  . "'";
			echo $statusquery;
			mysql_query($statusquery) or die('query failed:'.mysql_error().'<br/>sql:'.$sql.'<br/>');
			while ($i != count($MCXML->channel->item)){
				echo "Starting upload... <br>" . $i;				
				$imageURL = $MCXML->channel->item[$i]->enclosure['url'];
				$imageCaption = $MCXML->channel->item[$i]->Caption;
				echo "Uploading " . $MCXML->channel->item[$i]->enclosure['url'] . "<br>" . $MCXML->channel->item[$i]->Caption . "<br>To " . $checkID . "<br>";
				$imageupload = $smugObj->images_uploadFromURL("AlbumID=${checkID}" , "URL=${imageURL}", "Caption=${imageCaption}");					
				//var_dump($imageupload);		
				echo "<br>";			
				$i ++;
				$counterquery = "UPDATE mcexport2 SET currentphotos='" . $i . "' WHERE xmlpath='" . $xmlpath  . "'";
				mysql_query($counterquery) or die('query failed:'.mysql_error().'<br/>sql:'.$sql.'<br/>');
				flush();
			ob_flush();
			}
} 

			$albums = $smugObj->albums_getInfo("AlbumID={$checkID}", "AlbumKey={$checkKey}", "Strict=1");
			if ($albums['ImageCount'] == $i){
				$statusquery = "UPDATE mcexport2 SET status = 'DONE' WHERE xmlpath='" . $xmlpath  . "'";
				mysql_query($statusquery) or die('query failed:'.mysql_error().'<br/>sql:'.$sql.'<br/>');
			}
			else{
				$statusquery = "UPDATE mcexport2 SET status = 'ERROR' WHERE xmlpath='" . $xmlpath  . "'";
				mysql_query($statusquery) or die('query failed:'.mysql_error().'<br/>sql:'.$sql.'<br/>');
				$newError = "The album " .  $albums['Title'] . "(" . $albums['URL'] . ") contains" . $albums['ImageCount'] . " images, but there are " . count($MCXML->channel->item) . " images in the MyCapture XML. Check to see if the images still exist in MyCapture./n";
				array_push($errors, $newError);


			}
		} 



	else {
			echo "<h1> Since the number of images matches no update needed.</h1><br>";
			$statusquery = "UPDATE mcexport2 SET status = 'DONE' WHERE xmlpath='" . $xmlpath  . "'";
			mysql_query($statusquery) or die('query failed:'.mysql_error().'<br/>sql:'.$sql.'<br/>');
			}

$reportrecipients = "bhenderson@pioneerpress.com";
$reportSubject = date('F j h:i:s');
echo $reportSubject . "<br>";
var_dump($errors);
//mail ($reportrecipients, $reportSubject, $errors[0]);

		} 	



function in_array_r($needle, $haystack, $strict = false) {
    foreach ($haystack as $item) {
        if (($strict ? $item === $needle : $item == $needle) || (is_array($item) && in_array_r($needle, $item, $strict))) {
            return true;
        }
    }

    return false;
}

/*function xmlencode($data) {
    $data = utf8_encode($data);
    $data = htmlentities($data);
    var_dump($data);
    return $data;
}*/



//setup smugmug connection
//set smug url that we want to upload to
$smugURL = $_SESSION['smugmugurl'];
echo $smugURL;
echo $_SERVER['DOCUMENT_ROOT'] . '/wp-blog-header.php';
// SMUGMUG caching            
$smugvalues = getSmugApi($smugURL);//returns smug values for these images based on what instance they are in
var_dump($smugvalues);
$tokenarray = unserialize($smugvalues[0]['smug_token']);
$cachevar = dirname(__FILE__) . 'smugcache';	
// APC Cache Version
$f = new phpSmug("APIKey={$smugvalues[0]['smug_api_key']}", "AppName=DFM Photo Gallery 1.0", "OAuthSecret={$smugvalues[0]['smug_secret']}", "APIVer=1.3.0");
$cache_result = $f->enableCache("type=apc", "cache_dir={$cachevar}", "cache_expire=180" );
//echo "<!-- CACHE RESULT: $cache_result -->\n";		
$f->setToken( "id={$tokenarray['Token']['id']}", "Secret={$tokenarray['Token']['Secret']}" );
$categoryID = mcsmugcategory($f);
//echo $categoryID;
if (is_dir($dir)) {
    if ($dh = opendir($dir)) {
    		ob_start;
        	while (($file = readdir($dh)) !== false) {
            $path = $dir . "/" . $file;
            if ($file == ".DS_Store" || $file == "." || $file == ".." || $file == "processed") { continue; }
            //echo "foldername: " . $file . "\n<br>";
			if (filetype($path) == "file"){
			$options = LIBXML_NOENT | LIBXML_NOCDATA;
			$xml = simplexml_load_file($path, 'SimpleXMLElement', $options);
			//var_dump($xml);
			$albumsearchquery = "SELECT * FROM mcexport2 WHERE xmlpath = '" . $path . "'";
			//echo $albumsearchquery;
			$albumsearch = mysql_query($albumsearchquery)  or die('query failed:'.mysql_error().'<br/>sql:'.$sql.'<br/>');
			$searchdebug = mysql_num_rows($albumsearch);
			//echo $searchdebug;
			if ($searchdebug != 0){
				//echo "PROGRESS<br>";
				while ($entry = mysql_fetch_array($albumsearch)){
					if($entry['xmlpath'] == $path){
						$smugid = $entry['smugid'];
						$smugkey = $entry['smugkey'];
						$albumStatus = $entry['status'];
					}
				}
			}
			else if ($searchdebug == 0){
				echo "maybe progress<br>";
				//var_dump($xml);	
				echo "<h1>ALBUM PATH: " . $path . "</h1>";			
				//$theNewAlbum = mcsmugnewalbum($path, xmlencode($xml), $f, $categoryID, false);
				$theNewAlbum = mcsmugnewalbum($path, $xml, $f, $categoryID, false);
				//$theNewAlbum = mcsmugnewalbum($path, xmlencode($xml), $categoryID, $f, $siteFileHandle, false);
				$smugid = strval($theNewAlbum['id']);
				$smugkey = $theNewAlbum['Key'];				
			}
			echo "Log entry exists!<br>ID AND KEY:" . $smugid . "  " . $smugkey . "<br>";
			if ($smugid == 0 || $smugkey == ""){
				echo "NEW ALBUM FAILED. RETRYING.";
				echo "<h1>ALBUM PATH: " . $path . "</h1>";
				//$theNewAlbum = mcsmugnewalbum($path, xmlencode($xml), $f, $categoryID, true);
				$theNewAlbum = mcsmugnewalbum($path, $xml, $f, $categoryID, true);
				//$theNewAlbum = mcsmugnewalbum($path, xmlencode($xml), $categoryID, $f, $siteFileHandle, false);
				$smugid = strval($theNewAlbum['id']);
				$smugkey = $theNewAlbum['Key'];
			}
			 
			//mcsmugcheckalbum($smugid, $smugkey, $xml, $f);
			if ($albumStatus != "DONE" && $albumStatus != "ERROR"){mcsmugcheckalbum($path, $xml, $f);}
		}
        }
        closedir($dh);
    }
}

?>