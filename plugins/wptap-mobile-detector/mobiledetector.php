<?php
/**
 Plugin Name: WPtap Mobile Detector
 Plugin URI: http://www.wptap.com/index.php/plugin/
 Description: This plugin automatically detects the type of mobile browser that you site is viewed from, and activates the mobile theme you have chosen for it. User can install multiple mobile themes and link it to different mobile browsers for best performance. If you have a separate WAP or mobile website, this detector also allows you to redirect your mobile traffic to the WAP/mobile site.

 Version: 1.1
 Author: WPtap Development Team
 Author URI: http://www.wptap.com/index.php
*/

//this is added to let json feeds get through to their appropriate www feed
$isItFeed = $_SERVER["SERVER_NAME"] . $_SERVER["REQUEST_URI"];
if(strpos($isItFeed, '/rotator') !== false) {
	return;
}

define('TABLE_MOBILES', $table_prefix.'md_mobiles');
define('TABLE_MOBILEMETA', $table_prefix.'md_mobilemeta');

require(dirname(__FILE__) . '/md-includes/function.php');

$pluginversion = md_pluginversion();
$pluginname = md_pluginname();
$mobile_current_template = mobileDetect();
//echo "mctemplate: ". $mobile_current_template;
// Activation of plugin
if(function_exists('register_activation_hook')) {
	register_activation_hook( __FILE__, 'md_install' );
}

// Uninstallation of plugin
if(function_exists('register_uninstall_hook')) {
	register_uninstall_hook(__FILE__, 'md_uninstall');
}

if(is_admin()) {
	require(dirname(__FILE__) . '/md-admin/function.php');
	add_action('admin_menu', 'md_option_menu');
}

if($mobile_current_template) {
	add_filter('template', 'switchTheme');		//webkit
	add_filter('stylesheet', 'switchStyleSheet');	//ipad
	//add_filter('option_template', 'serve_default_to_iesix');
	//add_filter('option_stylesheet', 'serve_default_to_iesix');
	
	//echo "BULLETS: ". $mobile_current_template;
	//add_filter('stylesheet', 'mobileDetect');
	//add_filter('template', 'mobileDetect');
	//add_filter('stylesheet', $mobile_current_template);
	//add_filter('template', $mobile_current_template);
	// Filters
    //add_filter('body_class', array(&$mobile_current_template, 'filter_addBodyClasses'));
    //add_filter('template', array(&$mobile_current_template, 'filter_switchTheme'));
    //add_filter('stylesheet', array(&$mobile_current_template, 'filter_switchTheme_stylesheet'));
 // } End Switcher

  // Content transformation {
    // Filters
    //add_filter('the_content', array(&$mobile_current_template, 'filter_processContent'));

	//$theme = $mobile_current_template;
}
?>