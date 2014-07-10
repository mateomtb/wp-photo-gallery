dfm-wp-photogallery
===================

Master photo gallery plugin 

####Requirements

Active https://github.com/dfmedia/dfm-wp-data plugin

```const WP_PLUGIN_DIR``` needs to be defined in your wp-config.php

The plugin should work in any development environment with PHP 5.3.6 and WordPress 3.5.1 or higher, but please report any issues

####Notes

Sample WP posts that demonstrate functional galleries can be found in the "demo" directory (Tools>>Import in WP Dashboard)

You do not need to use the samples if you already know how to create gallery posts, but they are in place for convenience and example

New instances should be added to the plugin's instances file, and not used elsewhere, at the moment

####Troubleshooting

Report issues here: https://github.com/dfmedia/dfm-wp-photogallery/issues

Make sure the directory to which your JSON file should be written is "rwx" by the relevant class (js/json in current instances)

Check out the class interface for the DFMGallery class in dfm-wp-photogallery.php for more specifics

####Current Instances (see class interface for details (dfm-wp-photogallery.php))

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
			'gallery-html-includes/gallery-js-and-html.php',
			'gallery-html-includes/rss-data.php'
		);
		$JSONDir = $dir . 'js/json/'; // Needs to be able to be written to

		$gallery = new DFMGallery();
		$gallery->setJSDeps($JSDeps);
		$gallery->setCSSDeps($CSSDeps);
		$gallery->setHTML($HTMLAsPHPInclude);
		$gallery->setJSONDir($JSONDir);
		$gallery->setRSSMeta(true);
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
		$longformCSSDeps = array('css/longform-gallery-styles.css');
		$longformHTMLAsPHPInclude = array(
			'gallery-html-includes/longform-gallery-js-and-html.php',
			'gallery-html-includes/rss-data.php'
		);
		$longformJSONDir = $dir . 'js/json/'; // Needs to be able to be written to

		$longformGallery = new DFMGallery();
		$longformGallery->setJSDeps($longformJSDeps);
		$longformGallery->setCSSDeps($longformCSSDeps);
		$longformGallery->setHTML($longformHTMLAsPHPInclude);
		$longformGallery->setJSONDir($longformJSONDir);
		$longformGallery->setRSSMeta(true);
		//$longformGallery->setJSONCacheBusting(false);
		return $longformGallery->createDFMGallery();

	});
