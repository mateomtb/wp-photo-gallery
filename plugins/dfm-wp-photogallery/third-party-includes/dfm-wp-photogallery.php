<?php
/*                                                                                                                                                                                                                                                             
Plugin Name: DFM Gallery
Description: Creates photo galleries from data hosted in SmugMug 
Version: 1.00
Author: Josh Kozlowski and Jonathan Boho
Author Contact : joshuamkozlowski@gmail.com
License: TBD. 
*/

// !!!Separate plugin. Required and must be activated!!!
require_once(WP_PLUGIN_DIR . '/dfm-wp-data/dfm-wp-data.php');
// !!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!



interface DFMGalleryInterface {
	// How to create a gallery
	// new DFMGallery(); 
	
	// Setter args are strings unless noted by arg name
	
	// Array of JS deps pathed from root of plugin
	public function setJSDeps($JSDepsArray);
	
	// Array of CSS deps pathed from root of plugin
	public function setCSSDeps($CSSDepsArray);
	
	// Set HTML deps by passing an array of file paths from root of plugin
	// This is where the Handlebars.js template is defined
	public function setHTML($HTMLDepsArray);
	
	// Path to dir where JSON will be written
	// Since you might want to point to a tmp dir,
	// You need to specify something like plugin_dir_path(__FILE__)
	// If you want to use the js/json dir already in the plugin
	// Might need to be chmod ugo+rwx (777) in some systems
	public function setJSONDir($JSONDir);
	
	// Since the JSON that contains all of the gallery data 
	// is written to a file, we don't really
	// need to recreate the data every time a gallery is loaded
	// Here you can set how long until the JSON is recreated 
	// (i.e. how often the SmugMug API is used)
	// Default is 15 minutes. Pass number of minutes
	public function setCacheTime($timeInt);
	
	// This function is still in the works, but will be used to bust any APC caching
	public function setAPCCacheBusting($bool);
	
	// Set to TRUE if you want a new JSON file to be written every time the page loads
	// Ideal for testing
	public function setJSONCacheBusting($bool);
		
	// Set to TRUE if you want the cover image added as a custom field to the gallery's post
	// Useful for RSS
	public function setMeta($bool);
	
	// Function you want to hook to your WP shortcode 
	// returns gallery code
	public function createDFMGallery();
}

interface SmugMugDepsInterface {
	// We have to use the SmugMug API
	// An instance of this class is created in a factory function
	// and probably does not need to be bothered with,
	// unless we have to use the SmugMug API in a new way down the road
	
	// new SmugMugDeps();
	// Setter function args are strings unless noted by arg name
	
	// Set WordPress Post object
	public function setPost(&$postObject);
	
	// Set SmugMug path to SmugMug includes if you need their classes
	public function setIncludes($includesArray);
	
	// Set source of URL that looks like this:
	//  http://bangphotos.smugmug.com/gallery/settings.mg?AlbumID=[ID]&AlbumKey=[KEY]
	public function setSmugData($smugData);
	
	// Set Path to directory for SmugMug caching
	// Not sure how well that caching is working at this time
	public function setSmugCache($path);
	
	// Set if you need a special Image size returned
	// Currently we use the "Large" image sent by SmugMug
	public function setCustomSize($size);
	
	// This function puts everything from the API together and its output is used to build JSON
	// Returns an array
	public function smugMugPackage(); 
}



class DFMGallery extends DFMGalleryDeps implements DFMGalleryInterface {
		
	private $post;
	private $JSDeps;
	private $CSSDeps;
	private $HTML;
	private $JSONDir;
	private $fileName;
	private $filter;
	private $cacheTime;
	private $cacheBusting = false;
	private $JSONcaching = true;
	private $JSONFile;
	private $addMeta = false;
	
	public function setJSDeps($JSDepsArray) {
		$this->JSDeps = $JSDepsArray;
	} 
	
	public function setCSSDeps($CSSDepsArray) {
		$this->CSSDeps = $CSSDepsArray;
	}
	
	public function setHTML($HTMLDepsArray) {
		$this->HTML = $HTMLDepsArray;
	}
	
	public function setFileName($fileName) {
		$this->fileName = $fileName;
	}
	
	public function setFilter($filter) {
		$this->filter = $filter;
	}
	
	public function setJSONDir($JSONDir){
		$this->JSONDir = $JSONDir;
	}
	
	public function setCacheTime($timeInt) {
		$this->cacheTime = $timeInt;
	}
	
	public function setAPCCacheBusting($bool) {
		$this->cacheBusting = $bool;
	}
	
	public function setJSONCacheBusting($bool) {
		$this->JSONcaching = $bool;
	}
	
	public function setMeta($bool) {
		$this->addMeta = $bool;
	}
	
	private function getCacheTime(){
		if (!$this->cacheTime) {
			return 15 * 60; // 15 minutes
		}
		else {
			return $this->cacheTime * 60;
		}
	}
	
	private function synthesizeJSONDirAndFileName() {
		// To keep PHP logic and front end code separate,
		// we need a way for the front end code to know what the gallery's JSON
		// file is called. The next three functions set a file naming convention
		// and a filter that should be matched by the file naming structure generated in 
		// js/custom/JSON-helper.js
		$fileNamePart = $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
		$fileNameFilter = '/[^0-9a-z]/i';
		
		
		$fileName = preg_replace($fileNameFilter, '', $fileNamePart) . '.json';
		return $this->JSONDir . $fileName;
	}
	protected function writeScripts() {
		// using wp_register_script and wp_enqueue_script
		// in this function resulted in having to wrap the AJAX call to JSON
		// in document.ready which slowed things down
		// So we're just writing the html to the page here now
		if ($scripts = $this->JSDeps) {
			foreach($scripts as $script) {
				$url = plugins_url() . '/dfm-wp-photogallery/' . $script;
				echo "<script type=\"text/javascript\" src=\"$url\"></script>\n";
			}
		}
	}

	protected function writeStyles() {
		// see comment above in writeScripts()
		if ($styleSheets = $this->CSSDeps) {
			foreach($styleSheets as $styleSheet) {
				$url = plugins_url() . '/dfm-wp-photogallery/' . $styleSheet;
				echo "<link type=\"text/css\" rel=\"stylesheet\" href=\"$url\" />\n";
			}
		}
	}
	
	private function createJSONFile() {
		$post = $this->post;
		$file = $this->synthesizeJSONDirAndFileName();
		// Assign data to instance for other uses
		$this->JSONFile = $file;
		$keepCaching = (!$this->JSONcaching || !file_exists($file)) ? true : false;
			if ($keepCaching || $this->timeMinusCacheTime() > $this->fileCreationTime($file)) {
				$json = $this->createJSONFeed($post);
				if (!$json) {
					error_log('Something is wrong. Make sure you\'ve provided smugdata or the equivalent.');
					return false;
				}
				$fh = fopen($file, 'w');
				fwrite($fh, $json);
				fclose($fh);
				return true;
			}
		return true;
	}
	
	private function useJSON($dataRequired) {
		// Use JSON data for various tasks, like providing data for RSS
		// Code is specific right now, but we can scale up for other tasks
		$JSON = json_decode(file_get_contents($this->JSONFile));
		if ($dataRequired === 'FEATURED_IMAGE') {
			$featuredImage = $JSON->ImageElementCollection->ImageElement[0]->fullUrl;
			if ($this->addMeta) {
				if (!get_post_meta($this->post->ID, 'featured-image', true)) {
					add_post_meta($this->post->ID, 'featured-image',  $featuredImage);
				}
				else {
					update_post_meta($this->post->ID, 'featured-image',  $featuredImage);
				}
			}
		}
	}
	
	private function PHPTemplating($subject, $replace, $search) {
		// Do something like Handlebars.js does
		return str_replace($subject, $replace, $search);
	}
	
	private function timeMinusCacheTime() {
		return (time() - $this->getCacheTime());
	}
	
	private function fileCreationTime($file) {
		return filemtime($file);
	}
	
	protected function insertHTML() {
		$this->useJSON('FEATURED_IMAGE'); // Add featured image info to post for future use
		// Meant to be inserted at location of shortcode used to hook gallery creation function
		$html = '';
		foreach ($this->HTML as $include) {
			//include_once($scriptInclude);
			//if (strpos($include, 'rss-data') !== false) {
				// Add RSS data
				// Changing how this works for now
				//$html .= "\n" . $this->PHPTemplating(
					//'{{COVER_PATH}}', 
					//$this->useJSON('FEATURED_IMAGE'), 
					//file_get_contents(plugin_dir_path(__FILE__) . $include)
				//) . "\n";
			//}
			//else {
				$html .= "\n" . file_get_contents(plugin_dir_path(__FILE__) . $include) . "\n";
			//}
		}
		return $html;
	} 

	public function createDFMGallery() {
		//if (preg_match('/\/feed$|\/feed\?/', $_SERVER['REQUEST_URI'])){
		if (!is_single()) {
			// Stop execution when instance is created on a WordPress RSS feed page
			return false;
		}
		global $post; // Word Press post object. This doesn't exist until shortcode calls this function
		$this->post = $post;
		//$postModifiedTime = get_post_modified_time('U');
		//if ($this->cacheBusting && (get_post_time('U', true, $post->ID) !== $postModifiedTime)) {
			//DFMGalleryUtils::clearAPCCache($postModifiedTime, 10);
		//}
		//add_action( 'wp_enqueue_scripts', $this->writeScripts());
		//add_action( 'wp_enqueue_styles', $this->writeStyles());
		$this->writeScripts();
		$this->writeStyles();
		if ($this->createJSONFile()) {
			return $this->insertHTML();
		}
		else {
			$errorHTMLasPHPINclude = array('gallery-html-includes/error-gallery.php');
			$errorGallery = new DFMGalleryException();
			$errorGallery->setHTML($errorHTMLasPHPINclude);
			return $errorGallery->createErrorGallery();
		}
	}
}

class DFMGalleryDeps {
	
	protected function createJSONFeed(&$post) {
		$smugMugDataPackage = SmugMugDepsInstanceFactory::createInstance($post);
		
		$albumAndImageData = $smugMugDataPackage[0];
		$smugInstance = $smugMugDataPackage[1];
		$smugMetaDataFromPost = $smugMugDataPackage[2];
		
		if (!$albumAndImageData['albums'] || !$albumAndImageData['images']) {
			error_log('SmugMug album or image data missing.');
			return false;
		}
		
		// We can make images sellable in SmugMug
		$forsale = strtolower(get_post_meta($post->ID, 'forsale', true));
		$forsale = ($forsale === 'yes') ? $albumAndImageData['albums']['URL'] : false;
		$this->changeSmugGalleryPurchaseOptions($forsale, $albumAndImageData, 
			$smugInstance, $smugMetaDataFromPost);
		
		
		$JSON = $this->JSONStructure(
			$post->post_title, 
			$this->JSONImageStructure($albumAndImageData['images'], 
			$forsale
		)
		);
		return $JSON;
	}
	
	private function JSONStructure($title, $imageElementArrays) {
		$skeleton = array(
			"ImageElementCollection" => array(
				"title" => $title,
				"ImageElement" => $imageElementArrays
			)
		);
		return json_encode($skeleton);
	}
	
	private function JSONImageStructure($imageData, $forsale = false) {
		$imageElementArrays = array();
		$imageElementArray = array(
			// Current structure of image data for reference.
			// TODO change key names in handlebars to match SmugMug data so is easier to scale? 
			// "forsaleHREF" => '', // Not always included
			//"fullUrl" => '',
			//"thumbUrl" => '',
			//"caption" => '',
			//"width" => '',
			//"height" => ''
		);
		foreach($imageData as $iD) {
			$imageElementArray['fullUrl'] = $iD['LargeURL'];
			$imageElementArray['customUrl'] = $iD['CustomURL'];
			$imageElementArray['caption'] = $iD['Caption'];
			$imageElementArray['width'] = $iD['Width'];
			$imageElementArray['height'] = $iD['Height'];
			if ($forsale) {
				$imageElementArray['forsaleHREF'] = $forsale . "#i=" . $image['id'] . "&k=" . $image['Key'];
			}
			$imageElementArrays[] = $imageElementArray;
		}
		return $imageElementArrays;
	}
	
	private function changeSmugGalleryPurchaseOptions($bool, $smugData, &$instance, $metaAttributes) {
		if ($smugData['albums']['Printable'] !== true) {
			// Only do this one time at most if album is for sale
			if ($bool) {
				$instance->albums_changeSettings(
					"AlbumID={$metaAttributes["AlbumID"]}", 
					"Printable=true", 
					"Protected=true", 
					"Public=true",
					"Larges=true", 
					"Originals=false", 
					"X2Larges=false", 
					"X3Larges=false", 
					"XLarges=false", 
					"WorldSearchable=false", 
					"SmugSearchable=true"
				);
			}
			else {
				$instance->albums_changeSettings(
					"AlbumID={$metaAttributes["AlbumID"]}", 
					"Printable=false", 
					"Protected=true", 
					"Public=false", 
					"Larges=true", 
					"Originals=false", 
					"X2Larges=false", 
					"X3Larges=false", 
					"XLarges=false", 
					"WorldSearchable=false", 
					"SmugSearchable=false"
				);
			}
		}
	}
}

class DFMGalleryException extends DFMGallery {
	// Improve exceptions and error handling as needed
	public function createErrorGallery() {
		$this->writeScripts();
		$this->writeStyles();
		return $this->insertHTML();
	} 
}

class SmugMugDeps implements SmugMugDepsInterface {

	protected $post; 
	protected $includes; 
	protected $smugData; 
	protected $smugCache; 
	protected $smugMugImageCustomSizeString = 'CustomSize=50x50'; 
	
	public function setPost(&$postObject){
		$this->post = $postObject;
	}
	
	public function setIncludes($includesArray) {
		$this->includes = $includesArray;
	}
	
	public function setSmugData($smugData) {
		$this->smugData = $smugData;
	}
	
	public function setSmugCache($path) {
		$this->smugCache = $path;
	}
	
	public function setCustomSize($size) {
		$this->smugMugImageCustomSizeString = $size;
	}
	
	private function includeIncludes(){
		if ($includes = $this->includes) {
			foreach ($includes as $include) {
				require_once($include);
			}
		}
	}
	
	private function parseMeta(){
		// return SmugMug AlbumID and AlbumKey based on URL provided in meta field
		// as associative array
		if ($this->smugData) {
			$albumData = parse_url($this->smugData, PHP_URL_QUERY);
			$adArray = array();
			parse_str($albumData, $adArray);
			if ($adArray['AlbumID'] && $adArray['AlbumKey']) {
				return $adArray;
			}
			else {
				$this->error('SmugMug AlbumID and AlbumKey not set.');
				return false;
			}
		} 
		else {
			$this->error('SmugData not set.'); 
			return false;
		}
	}
	
	private function getSmugApi(){
		if (!class_exists('DFMDataForWP')) {
			$this->error('You need to activate the DFM Data plugin. See README.');
			return false;
		}
		if ($this->smugData) {
			$getTheHost = parse_url($this->smugData);
			$dataForThisHost = DFMDataForWP::retrieveRowFromMasterData('smug_url', $getTheHost["host"]); 
			$smugAPIArray = array(
				"smug_api_key" => $dataForThisHost["smug_api_key"], 
				"smug_secret" => $dataForThisHost["smug_secret"], 
				"smug_token" => $dataForThisHost["smug_token"]
			);
			return array ($smugAPIArray);
		}
		else {
			$this->error('SmugData not set.'); 
			return false;
		}
	}
	
	private function smugMugCaching($instance) {
		if (!$this->smugCache) {
			$this->error("Cache dir not set");
			return false;
		}
		$cache_result = $instance->enableCache(
			"type=apc", 
			"cache_dir={$this->smugCache}", 
			"cache_expire=180"
		);
		echo "<!-- CACHE RESULT: $cache_result -->\n";
		
	}
	
	public function smugMugPackage() {
		$this->includeIncludes();
		$smugAPIValues = $this->getSmugApi();
		$smugTokenValues = unserialize($smugAPIValues[0]['smug_token']);
		$smugAttrs = $this->parseMeta();

		if(!$smugAPIValues || !$smugTokenValues || !$smugAttrs) {
			$this->error('Something is wrong. Check other log items.');
			return false;
		}
		
		// Use SmugMug's PHP class here
		$smugMugAPIInstance = new phpSmug(
			"APIKey={$smugAPIValues[0]['smug_api_key']}", 
			"AppName=DFM Photo Gallery 1.0", 
			"OAuthSecret={$smugAPIValues[0]['smug_secret']}", 
			"APIVer=1.3.0"
		);
		
		//$this->smugMugCaching($smugMugAPIInstance); // Some caching
			
		// Hit the SmugMug API and create some arrays of image and album data	
		$smugMugAPIInstance->setToken(
			"id={$smugTokenValues['Token']['id']}", 
			"Secret={$smugTokenValues['Token']['Secret']}"
		);
		// Albums an image arrays assigned here
		$albums = $smugMugAPIInstance->albums_getInfo(
			"AlbumID={$smugAttrs["AlbumID"]}",
			"AlbumKey={$smugAttrs["AlbumKey"]}", 
			"Strict=1"
		);
		$images = $smugMugAPIInstance->images_get(
			"AlbumID={$smugAttrs["AlbumID"]}", 
			"AlbumKey={$smugAttrs["AlbumKey"]}", 
			$this->smugMugImageCustomSizeString, 
			"Heavy=1" 
		);
		// Hack for difference in data returned between versions of SmugMug
		$images = ($smugMugAPIInstance->APIVer == "1.3.0") ? $images['Images'] : $images;
		
		$albums = $smugMugAPIInstance->albums_getInfo(
			"AlbumID={$smugAttrs["AlbumID"]}", 
			"AlbumKey={$smugAttrs["AlbumKey"]}", 
			"Strict=1"
		);
		
		// Return 3-item array
		return array(
			array('albums' => $albums, 'images' => $images), 
			$smugMugAPIInstance, 
			$smugAttrs
		);
	}
	
	private function error($str){
		error_log($str);
		return false;
	}
	
}

class SmugMugDepsInstanceFactory {
	public static function createInstance(&$post) {
		$dir = plugin_dir_path(__FILE__);
		$smugDataInstance = new SmugMugDeps();
		$smugDataInstance->setPost($post);
		$smugDataInstance->setSmugData(get_post_meta($post->ID, 'smugdata', true));
		if (!class_exists('phpSmug')) {
			// Some sites already have this class defined in a different plugin
			$smugMugincludes = array($dir . 'third-party-includes/phpSmug.php', 
				$dir . 'third-party-includes/phpSmugAPCcache.php');
				$smugDataInstance->setIncludes($smugMugincludes);
		}
		$smugDataInstance->setSmugCache($dir . 'smugcache');
		return $smugDataInstance->smugMugPackage();
	}
}

class DFMGalleryUtils {
	public static function clearAPCCache($offset, $interval) {
		// Calculate how long since last post update. If within last hour?, call apc_clear_cache();
		// TODO - finish
		if (function_exists('apc_clear_cache')) {
		}
	}
}

// End Classes


// Include Instances

require_once(plugin_dir_path(__FILE__) . 'dfm-wp-photogallery-instances.php');

?>