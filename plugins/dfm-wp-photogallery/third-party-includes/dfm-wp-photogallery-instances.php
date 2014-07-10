<?php
// Gallery Instances

// Did not want to incorporate mobile code into this plugin
// See mobile theme and ssp-insertslideshow.php if using this in Media Center
// This should not impact the use of the plugin on other sites unless its intended for 
// use on mobile pages that use the wptap-mobile-detector plugin
global $mobile_current_template;
if (!$mobile_current_template):


// Default gallery

add_shortcode('insertSmugmug', function() {

	$dir = plugin_dir_path(__FILE__);
	$JSDeps = array(
		'js/carousel.js',
		'js/smart-resize.js',
		'js/bootstrap-transition.js',
		'js/handlebars.min.js',
		'js/imagesLoaded.js',
		'js/custom/JSON-helper.js',
		'js/custom/carousel-bindings.js'
	);
	$CSSDeps = array(
		'css/gallery-styles.css',
		'css/custom/gallery-styles.css'
	);
	$HTMLAsPHPInclude = array(
		'gallery-html-includes/gallery-js-and-html.php'
	);
	$JSONDir = $dir . 'js/json/'; // Needs to be able to be written to

	$gallery = new DFMGallery();
	$gallery->setJSDeps($JSDeps);
	$gallery->setCSSDeps($CSSDeps);
	$gallery->setHTML($HTMLAsPHPInclude);
	$gallery->setJSONDir($JSONDir);
	//$gallery->setMeta(true);
	//$gallery->setAPCCacheBusting(false);
	return $gallery->createDFMGallery();

});

// End default gallery


// Longform gallery

add_shortcode('insertLongForm', function() {

	$dir = plugin_dir_path(__FILE__);
	$longformJSDeps = array(
		'js/handlebars.min.js',
		'js/custom/JSON-helper.js',
		'js/custom/longform-bindings.js'
	);
	//$longformCSSDeps = array('css/longform-gallery-styles.css');
	$longformHTMLAsPHPInclude = array(
		'gallery-html-includes/2014-longform-gallery-js-and-html.php'
	);
	$longformJSONDir = $dir . 'js/json/'; // Needs to be able to be written to

	$longformGallery = new DFMGallery();
	$longformGallery->setJSDeps($longformJSDeps);
	$longformGallery->setCSSDeps($longformCSSDeps);
	$longformGallery->setHTML($longformHTMLAsPHPInclude);
	$longformGallery->setJSONDir($longformJSONDir);
	//$longformGallery->setMeta(true);
	//$longformGallery->setJSONCacheBusting(false);
	return $longformGallery->createDFMGallery();

});

endif; // End mobile check

?>