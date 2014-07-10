<?php
/*
Plugin Name: SSP Insert Gallery
Plugin URI:
Version: v3.1
Author: mateo leyba
Description: Adds Google Survey Tags. Dynamicaly passes Slideshow Pro Director CMS gallery to Gallerfic Slideshow
Copyright 2012 mateo leyba (email : mleyba [a t ] denverpost DOT com)

This program is free software; you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation; either version 2 of the License, or
(at your option) any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program; if not, write to the Free Software
Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA 02111-1307 USA

*/

function dfm_gallery_sripts()
{
    // Register scripts
wp_register_script( 'init-galleriffic-script', plugins_url( '/js/init_slideshow_smug.js', __FILE__ ), array(), null );
wp_enqueue_script( 'init-galleriffic-script' );
wp_register_script( 'jquery-galleriffic-script', plugins_url( '/js/jquery.galleriffic_smug.js', __FILE__ ), array(), null );
wp_enqueue_script( 'jquery-galleriffic-script' );
wp_register_script( 'jquery-history-script', plugins_url( '/js/jquery.history.js', __FILE__ ), array(), null );
wp_enqueue_script( 'jquery-history-script' );
wp_register_script( 'jquery-opacityrollover-script', plugins_url( '/js/jquery.opacityrollover.js', __FILE__ ), array(), null );
wp_enqueue_script( 'jquery-opacityrollover-script' );
wp_register_script( 'writecapture-script', plugins_url( '/js/wcapture_jquery.js', __FILE__ ), array(), null );
        wp_enqueue_script( 'writecapture-script' );
//make some varibles available to jquery.galleriffic.js (server file path to images folder)
        //Because we love to do special stuff! This is for newhaven which can't decide bewteen nhregister and newhavenregister
//Also adding a key/value pair for the interstitial toggles
        if ($_SESSION['siteconfig']['domain'] == "newhavenregister"){
            $plugindomainvalue = "nhregister";
        }
        else { $plugindomainvalue = $_SESSION['siteconfig']['domain'];
        }

$jsvars_array = array('plugin_url' => plugins_url('/images/', __FILE__), 'plugin_domain' => $plugindomainvalue);
$jsvars_array['int_toggle'] = get_option('T_int_toggle');
wp_localize_script( 'jquery-galleriffic-script', 'plugvar', $jsvars_array );

}



function dfm_gallery_styles()
{
    // Register styles
    wp_register_style( 'gallery-style', plugins_url( '/css/galleriffic-smug.css', __FILE__ ), array(), null);
    wp_enqueue_style( 'gallery-style' );
}




function sspx_init() {



function addShowjava($atts) {
dfm_gallery_sripts();
dfm_gallery_styles();
	//add_action( 'wp_enqueue_scripts', 'dfm_gallery_sripts' );
	//add_action( 'wp_enqueue_styles', 'dfm_gallery_styles');

//check for the existiance of the smugdata custom field.
global $post;
$thePostID = $post->ID;
$smuginfo = get_post_meta($thePostID, 'smugdata', true);
//if smugdata is empty run assume its a ssp post and run this gallery code, if it's populated just return empty and run the smug gallery function
if (isset($smuginfo) && empty($smuginfo) ){
				
//example of user input, this is what you put in your post body. [insertslideshowjava xml="77583397001" api="reverb, captured, dp, seen"]
extract(shortcode_atts(array(
'xml' => 'no id',
'api' => 'none',
), $atts));

$album_id = explode("=", $xml);
//var_dump($album_id[1]);

//var_dump($xml); [insertSlideshowjava xml="http://dpphoto.slideshowpro.com/images.php?album=113795"]

// Director config
/*---------------Start Director Setup ------------------------*/
    # Include DirectorAPI class file
# and create a new instance of the class
# Be sure to have entered your API key and path in the DirectorPHP.php file.
//require_once(dirname(__FILE__) . '/classes/DirectorPHP.php');
require_once(THEMELIB . '/classes/DirectorPHP.php');
//echo THEMELIB . '/classes/DirectorPHP.php';
//include($_SERVER['DOCUMENT_ROOT'] . '/feedstuff/config2.php');
//include(THEMELIB . '/director_keys/sspcodes.php');
//include(THEMELIB . '/functions/sspcodes.php');
$director = setSSPcodes( $api );

# When your application is live, it is a good idea to enable caching.
# You need to provide a string specific to this page and a time limit
# for the cache. Note that in most cases, Director will be able to ping
# back to clear the cache for you after a change is made, so don't be
# afraid to set the time limit to a high number.

//$director->cache->set('thisismediacenterTC01', '+10 minutes');




# What sizes do we want?
$director->format->add(array('name' => 'thumb', 'width' => '50', 'height' => '50', 'crop' => 1, 'quality' => 75, 'sharpening' => 1));
$director->format->add(array('name' => 'large', 'width' => '900', 'height' => '540', 'crop' => 0, 'quality' => 95, 'sharpening' => 1));
$director->format->add(array('name' => 'pictopia', 'width' => '400', 'height' => '450', 'crop' => 0, 'quality' => 95, 'sharpening' => 1));

//----image sizes created by cj for mobile
$director->format->add(array('name' => 'iphone_cj', 'width' => '480', 'height' => '480', 'crop' => 0, 'quality' => 95, 'sharpening' => 1));
$director->format->add(array('name' => 'ipad_cj', 'width' => '1024', 'height' => '1024', 'crop' => 0, 'quality' => 85, 'sharpening' => 0));
//$director->format->add(array('name' => 'mini_thumb_cj', 'width' => '65', 'height' => '65', 'crop' => 1, 'quality' => 85, 'sharpening' => 0));

# We can also request the album preview at a certain size

$director->format->preview(array('width' => '100', 'height' => '50', 'crop' => 1, 'quality' => 85, 'sharpening' => 1));



# Make API call using get_album method. Replace "1" with the numerical ID for your album

$album = $director->album->get($album_id[1]);


# Set images variable for easy access

$contents = $album->contents;
$total_images = count($contents);
//var_dump ($contents[0]);


ob_start();
$makemeunique = explode (" ", microtime());

//-------------------------------------Code from CJ
//added this because I had to modify the actual wordpress plugin, all other code is in the theme
global $mobile_current_template;	//add cj
global $is_iPad, $is_iPhone, $is_Android_tablet, $is_Android_mobile;
global $photo_array;

//echo 'detectmobile: '. $mobile_smart->detectmobile; //add cj
//print_r($mobile_smart); //add cj

//width="<?php echo $image->iphone_cj->width (chris add the end php tag here)" height="<?php echo $image->iphone_cj->height (chris add the end php tag here)"

//die('mobile_current_template: '. $mobile_current_template );
if ( $mobile_current_template != '' ) {	//add cj
//return array("Hello world you rockin!");
$photo_array = array();

foreach ($contents as $image) {
//array_push( $photo_array, $image ); //$image->iphone_cj->url, $image->caption, $image->created
if ( $is_iPad || $is_Android_tablet ) {
//die('ipad');
array_push( $photo_array, array( "xURL"=>$image->ipad_cj->url, "caption"=>$image->caption, "title"=>$image->seq ) );
} else if ( $is_iPhone || $is_Android_mobile ) {
//die('is_iPhone');
array_push( $photo_array, array( "xURL"=>$image->iphone_cj->url, "caption"=>$image->caption, "title"=>$image->seq ) );
} else {
//die('is_else');
array_push( $photo_array, array( "xURL"=>$image->iphone_cj->url, "caption"=>$image->caption, "title"=>$image->seq ) );
}

//array_push( $photo_array, array() $image ); //$image->iphone_cj->url, $image->caption, $image->created
//$xString = $xString . '{"url":"'. $image->ipad_cj->url. '","title":"'. $image->seq. '","caption":"'. jsonCleanText($image->caption) .'" },';
}

} else {	//add cj --- everything below is NOT my code
?>
<!-- Start Advanced Gallery Html Containers 3 -->
<div class="clear"></div>
<div class="p402_premium">
<div id="gallery_smug" class="contentsmug">
<div class="slideshow-container">

<div id="outer_interstitial" style="width:925px; height:25px;">
<div id="int_close_box" style="position: absolute;z-index: 2000;top: 0px;right: 0px; display:none; background-color: #000;width: 100px;height: 25px;"><h3 style="float:left; margin:3px 0px 0px 13px; color:#fff; font-family:inherit;" class"int">Close</h3><img style="margin:2px 0px 0px 0px;" src="<?php echo plugins_url( '/images/closebutton.png', __FILE__ );?>" /></div>
<div id="interstitial" style="position:absolute;z-index:100;top:0;display:none;margin:0px 0px 0px 25px;height:540px;width:900px;text-align:center;"></div>
</div>
<div id="loading" class="loader"></div>
<div id="slideshow" class="slideshow"></div>
</div>
<div id="controls" class="controls"></div> <!-- .controls -->
<div class="navcontainersmug">
<div id="thumbs" class="navigationsmug">
<ul class="thumbs noscript">
<?php
$MCurl = get_option('T_mcurl');
//update theme_options to this variable and uncomment
//$MCurl = get_option('T_mycapurl');

//$MCurl="";
$MCurl = trim($MCurl,"/");
$purchaseURL = $MCurl . "/mycapture/remoteimage.asp?image=";

//echo '<script type="text/javascript" src="' . $purchaseURL . '"></script>';


?>
<?php foreach ($contents as $image): ?>
<li>
<a class="thumb" name="name here" href="<?php echo $image->large->url ?>" title="title">
<img src="<?php echo $image->thumb->url ?>" width="<?php echo $image->thumb->width ?>" height="<?php echo $image->thumb->height ?>" alt="<?php echo $album->name; ?>" />
</a>
<div class="caption">
<div class="pictopia"><?php
if ((strtolower($image->title) == "forsale")&&($MCurl!="")){
//echo $image->title;
//$objCount=$objCount+1;
//$currentURL = "http://" . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
echo "<a href=\"" . $purchaseURL . $image->pictopia->url . "\" target='_blank'>Buy This Photo</a>";
}
?>
</div>
<div class="image-title"><?php echo $image->seq . " of " . $total_images ?> </div><div class="clear"></div>
<div class="image-desc"><?php echo $image->caption ?></div><div class="clear"></div>
</div>
</li>

<?php endforeach ?>
</ul>
</div> <!--#thumbs-->
</div> <!--#.nav-container-->
<div id="caption" class="caption-container"></div><!-- .caption-container -->
</div> <!-- end premium div -->
</div>
<?php
}//add cj

$data = ob_get_contents();
ob_end_clean();


    return $data;

} else {return '';}

}
//end ssp gallery function

function addsmugmug($atts,$feed=false) {
	
	dfm_gallery_sripts();
	dfm_gallery_styles();
			//-------------------------------------Code from CJ
			global $mobile_current_template;	//add cj
			global $is_iPad, $is_iPhone, $is_Android_tablet, $is_Android_mobile;
			global $photo_array;
			global $post;
			$thePostID = $post->ID;
			//get custom field 'smugdata' from the current post
			
			
			if (get_post_meta($post->ID, 'smugdata', true ) != '') {
				$smugdata = get_post_meta($post->ID, 'smugdata', true );
				//var_dump($smugdata);
				//parse smugthumb which is coming from the custom field in the post so we can get the AlbumID and AlbumKey
                $pq = parse_url($smugdata, PHP_URL_QUERY);
                $qatts = array();
                parse_str($pq, $qatts);			
			} else { return "No Gallery Found.";}
		
 
            // SMUGMUG caching

$smugvalues = getSmugApi($smugdata);//returns smug values for these images based on what instance they are in

$tokenarray = unserialize($smugvalues[0]['smug_token']);//setup the token value so we can use it as an array
            $cachevar = plugin_dir_path( __FILE__ ) . 'smugcache';	

            // APC Cache Version
$f = new phpSmug("APIKey={$smugvalues[0]['smug_api_key']}", "AppName=DFM Photo Gallery 1.0", "OAuthSecret={$smugvalues[0]['smug_secret']}", "APIVer=1.3.0");
            $cache_result = $f->enableCache("type=apc", "cache_dir={$cachevar}", "cache_expire=180" );
            echo "<!-- CACHE RESULT: $cache_result -->\n";

           // var_dump($f);
			$f->setToken( "id={$tokenarray['Token']['id']}", "Secret={$tokenarray['Token']['Secret']}" );
			
			if ( $is_iPad || $is_Android_tablet ) {
				$customsizeString = "CustomSize=1024x1024";
			} else if ( $is_iPhone || $is_Android_mobile ) {
				$customsizeString = "CustomSize=480x480";
			} else {
				$customsizeString = "CustomSize=50x50";
			}
			
			
			$albums = $f->albums_getInfo("AlbumID={$qatts["AlbumID"]}", "AlbumKey={$qatts["AlbumKey"]}", "Strict=1");
			$images = $f->images_get("AlbumID={$qatts["AlbumID"]}", "AlbumKey={$qatts["AlbumKey"]}", $customsizeString, "Heavy=1" );
			$images = ( $f->APIVer == "1.3.0" ) ? $images['Images'] : $images;	
		    //print_r($images);	
			if ($feed == true) {
				$albums = $f->albums_getInfo("AlbumID={$qatts["AlbumID"]}", "AlbumKey={$qatts["AlbumKey"]}", "Strict=1");
				$feed_data = array();
				$feed_data['albums'] = $albums;
				$feed_data['images'] = $images;
				return $feed_data;		
			    
			}
			ob_start();
			
			if ( $mobile_current_template != '' ) 
            {	//add cj
//die('count: '. count( $images ));
$photo_array = array();
//array("Peter"=>32, "Quagmire"=>30, "Joe"=>34);
//'{"url":"'. $image->ipad_cj->url. '","title":"'. $image->seq. '","caption":"'. jsonCleanText($image->caption) .'" },';
                $n = 0;
foreach ($images as $image):
                    $n++;
//echo $image["Caption"] . '<BR>';
array_push( $photo_array, array( "xURL"=>$image['CustomURL'], "caption"=>$image["Caption"], "title"=>$n ) );

//array_push( $photo_array, array( "caption"=>'test caption', "seq"=>$image["Position"]) );
//array_push( $photo_array, array( "ipad_cj"=>array("url"=>$image['CustomURL']), "caption"=>$image["Caption"], "seq"=>$image["Position"]) );
//$image->iphone_cj->url, $image->caption, $image->created
endforeach;
//$xString = $xString . '{"url":"'. $image->ipad_cj->url. '","title":"'. $image->seq. '","caption":"'. jsonCleanText($image->caption) .'" },';

//foreach ($contents as $image) {
// array_push( $photo_array, $image ); //$image->iphone_cj->url, $image->caption, $image->created
//}




} else {	//add cj --- everything below is NOT my code
?>
<!-- Start Advanced Gallery Html Containers -->
<div class="p402_premium">
<div id="gallery_smug" class="contentsmug">
<div class="slideshow-container">

<div id="outer_interstitial" style="width:925px; height:25px;">
<div id="int_close_box" style="position: absolute;z-index: 2000;top: 0px;right: 0px; display:none; background-color: #000;width: 100px;height: 25px;"><h3 style="float:left; margin:3px 0px 0px 13px; color:#fff; font-family:inherit;" class"int">Close</h3><img style="margin:2px 0px 0px 0px;" src="<?php echo plugins_url( '/images/closebutton.png', __FILE__ );?>" /></div>
<div id="interstitial" style="position:absolute;z-index:100;top:0;display:none;margin:0px 0px 0px 25px;height:540px;width:900px;text-align:center;"></div>
</div>

<div id="loading" class="loader"></div>
<div id="slideshow" class="slideshow"></div>
</div>
<div id="controls" class="controls"></div> <!-- .controls -->
<div class="navcontainersmug">
<div id="thumbs" class="navigationsmug">
<ul class="thumbs noscript">
<?php $n = 0; ?>
<?php foreach ($images as $image): ?>
<?php $n++ ?>
<li>
<a class="thumb" href="<?php echo $image['LargeURL'] ?>" title="<?php echo $image['FileName'] ?>">
<img src="<?php echo $image['CustomURL'] ?>" alt="<?php echo $image["Caption"]; ?>" /></a>
<div class="caption">
<div class="pictopia">
<?php
$forsale = get_post_meta($post->ID, 'forsale', true);
if ($forsale == 'yes'){
    //make the smugmug gallery available to buy from
    //echo "for sale";
    if ($albums['Printable'] != true) {
        $f->albums_changeSettings("AlbumID={$qatts["AlbumID"]}", "Printable=true", "Protected=true", "Public=true", "Larges=true", "Originals=false", "X2Larges=false", "X3Larges=false", "XLarges=false", "WorldSearchable=false", "SmugSearchable=true" );
    }
    $buyURL = urlencode($albums['URL']);
    //echo "<a href=\"https://secure.smugmug.com/cart/batchadd?url=" . $buyURL ."\" target=\"_blank\"> Buy This Photo</a>";
	echo "<a href=\"" .  $albums['URL'] . "#i=" . $image['id'] . "&k=" . $image['Key'] . "\" target=\"_blank\"> Buy This Photo</a>";
} elseif ($forsale != 'yes') {
    //make them smugmug gallery NOT available to buy from
    //echo "not for sale";
    $f->albums_changeSettings("AlbumID={$qatts["AlbumID"]}", "Printable=false", "Protected=true", "Public=false", "Larges=true", "Originals=false", "X2Larges=false", "X3Larges=false", "XLarges=false", "WorldSearchable=false", "SmugSearchable=false");
    
}
?>
</div>

<p class="image-title"><?php echo $n . " of " . count($images); ?></p>
<p class="image-desc"><?php echo $image["Caption"]; ?></p>
</div>
</li>
<?php endforeach; ?>
</ul>
</div> <!-- #thumbs -->
</div> <!-- .nav-container -->
<div id="caption" class="caption-container"></div> <!-- .caption-container -->

</div> <!-- #gallery -->
</div>
<?php
}

$data = ob_get_contents();
ob_end_clean();
return $data;
}


	add_shortcode('insertSlideshowjava', 'addshowjava');

	// We only want to use this code for mobile now instead of integrating into new gallery plugin
global $mobile_current_template;
if ($mobile_current_template) {
	add_shortcode('insertSmugmug', 'addsmugmug');
}
}

       
add_action('plugins_loaded', 'sspx_init');


?>
