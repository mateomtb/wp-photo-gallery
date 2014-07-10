<?php
global $xfeed, $wp_query;
if( isset( $wp_query->query_vars['xfd'] )) {
	$xfeed = 1;
} else {
	$xfeed = 0;
}

if ( $xfeed == 0 ) { ?>

	<!DOCTYPE html>
	<html>
		<head>
			<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
			<meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimum-scale=1.0, maximum-scale=1.0">
			<meta name="apple-mobile-web-app-capable" content="yes">
			<meta name="apple-mobile-web-app-status-bar-style" content="black">
			<link rel="apple-touch-icon" href="<?php echo THEME . '/css/images/' ?>mc_icon.png" />
			<script type="text/javascript" src="<?php echo THEME . '/js/' ?>iscroll.js"></script>
			<script type="text/javascript" src="<?php echo THEME . '/js/' ?>universal_tools.js"></script>
			<script language="JavaScript" type="text/javascript" src="http://admin.brightcove.com/js/BrightcoveExperiences.js"></script>
			
			<?php
			//----------- platform type is set in functions.php
			global $is_iPad, $is_iPhone, $is_Android_tablet, $is_Android_mobile;
			if ( $is_iPad ) { ?>
				<link rel="stylesheet" media="all and (orientation:portrait)" href="<?php echo THEME . '/css/' ?>ipad_portrait.css">
				<link rel="stylesheet" media="all and (orientation:landscape)" href="<?php echo THEME . '/css/' ?>ipad_landscape.css">
				<script type="text/javascript" src="<?php echo THEME . '/js/' ?>tablet_universal.js"></script>
				<script type="text/javascript" src="<?php echo THEME . '/js/' ?>tablet_ipad.js"></script>
			
			<?php } else if ( $is_iPhone ) { ?>
				<link rel="stylesheet" media="all and (orientation:portrait)" href="<?php echo THEME . '/css/' ?>iphone_portrait.css">
				<link rel="stylesheet" media="all and (orientation:landscape)" href="<?php echo THEME . '/css/' ?>iphone_landscape.css">
				<script type="text/javascript" src="<?php echo THEME . '/js/' ?>mobile_universal.js"></script>
				<script type="text/javascript" src="<?php echo THEME . '/js/' ?>mobile_iphone.js"></script>
			
			<?php } else if ( $is_Android_mobile ) { ?>
				<link rel="stylesheet" media="all and (orientation:portrait)" href="<?php echo THEME . '/css/' ?>iphone_portrait.css">
				<link rel="stylesheet" media="all and (orientation:landscape)" href="<?php echo THEME . '/css/' ?>iphone_landscape.css">
				<script type="text/javascript" src="<?php echo THEME . '/js/' ?>mobile_universal.js"></script>
				<script type="text/javascript" src="<?php echo THEME . '/js/' ?>mobile_android.js"></script>
			
			<?php } else if ( $is_Android_tablet ) { ?>
				<link rel="stylesheet" media="all and (orientation:portrait)" href="<?php echo THEME . '/css/' ?>ipad_portrait.css">
				<link rel="stylesheet" media="all and (orientation:landscape)" href="<?php echo THEME . '/css/' ?>ipad_landscape.css">
				<script type="text/javascript" src="<?php echo THEME . '/js/' ?>tablet_universal.js"></script>
				<script type="text/javascript" src="<?php echo THEME . '/js/' ?>tablet_android.js"></script>
					
			<?php } else { ?>
				<link rel="stylesheet" media="all and (orientation:portrait)" href="<?php echo THEME . '/css/' ?>ipad_portrait.css">
				<link rel="stylesheet" media="all and (orientation:landscape)" href="<?php echo THEME . '/css/' ?>ipad_landscape.css">
				<script type="text/javascript" src="<?php echo THEME . '/js/' ?>tablet_universal.js"></script>
				<script type="text/javascript" src="<?php echo THEME . '/js/' ?>tablet_android.js"></script>

			<?php } ?>
			
			<link rel="stylesheet" href="<?php echo THEME . '/css/' ?>universal.css">
			
			<script>
				//------------these are universal variables,etc loaded when the interface is loaded.
				var homeURL = '<?php echo site_url(); ?> ';homeURL = homeURL.replace(/^\s+|\s+$/g,"");		//home url link, has to be trimmed
				var themeURL = '<?php echo THEME ?>';			//used so we can access local URLs in the external javascript files
				var currentURL = '';							//used for sharing, so we always know where user is currently viewing
				
				var indexArray = new Array();		//array that keeps track of all the current index info
				var articleArray = new Array();		//array that keeps track of the article information
				
				//-------------variables for yahoo apt
				var yld_mgrpub_id = "<?php echo get_option('T_yld_mgrpub_id'); ?>";	//
				var yld_mgrsite_name = "<?php echo get_option('T_yld_mgrsite_name'); ?>";	//
				var yld_mgrcontent = "<?php echo get_option('T_yld_mgrcontent'); ?>";	//
				
				//-------------variables for Spreed
				var spreed_sku = "<?php echo get_option('T_spreed_sku'); ?>";	//
				
				//-------------variables for social
				var facebookid = "<?php echo get_option('T_fbappid'); ?>";
				
				//-------------variables for brightcove
				var bcpubid = "<?php echo get_option('T_bcpubid'); ?>";
				var bcplayerid = "<?php echo get_option('T_bcplayerid'); ?>";
				
				var parent_company = "<?php DetermineParentCompany($_SESSION['siteconfig']); echo $_SESSION['parent_company']; ?>";
				
				document.addEventListener('touchmove', function (e) { e.preventDefault(); }, false);
				document.addEventListener('DOMContentLoaded', function (e) { pageloaded(); }, false);
				document.addEventListener('DOMContentLoaded', function (e) { interfaceLoaded(); }, false);
				document.addEventListener('scroll', function (e) { scrollBackIntoView(); }, false);
				
				var supportsOrientationChange = "onorientationchange" in window, orientationEvent = supportsOrientationChange ? "orientationchange" : "resize";
				window.addEventListener(orientationEvent, function() { orientationHasChanged(); }, false);

				var myIndexScroll;
				var myArticleScroll;
				var xInterface = new Interface();
				
			</script>

			<title>MediaCenter</title>

			

			<?php 
			//include(THEMELIB . '/apps/omniture.php');
			include(get_theme_root() . '/mcenter/library/apps/omnituresingle.php'); // Want to be able to use omniTrack() method
			
}  ?>
