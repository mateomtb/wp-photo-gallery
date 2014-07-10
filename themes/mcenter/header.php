<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" <?php language_attributes(); ?>>
<head profile="http://gmpg.org/xfn/11">
<title><?php is_home() ? bloginfo('description') : wp_title(''); ?></title>
	<meta name="google-site-verification" content="nvmJi8lLVDa_Ts-mG_nXzUKCULNy5N1wHetYXdhVScw" />
	<meta http-equiv="content-type" content="<?php bloginfo('html_type') ?>; charset=<?php bloginfo('charset') ?>" />

	<?php if ( $_SERVER['HTTP_HOST'] == 'photos.denverpost.com' ) echo '<meta name="google-site-verification" content="c8cfI79sqfUXPy8rENwcY9IzY3utVOSnvseEfHSQ1CI" />'; ?> 	
	<?php if(is_search()) { ?>
	<meta name="robots" content="noindex, nofollow" /> 
    <?php }?>
<?php if($_SESSION['siteconfig']['domain'] === 'denverpost'){
echo '<script type="text/javascript">var _sf_startpt=(new Date()).getTime()</script>';
}?>
<!-- Favicon -->
<?php
// For determining the favicon
global $domain;
$domain = 'denverpost';
$dot = 'com';
if ( strpos($_SERVER['HTTP_HOST'], '.com') == TRUE || strpos($_SERVER['HTTP_HOST'], '.net') == TRUE )
{

	if ( strpos($_SERVER['HTTP_HOST'], '.net') == TRUE )
		$domain_bits = explode('.', str_replace('.net', '', $_SERVER['HTTP_HOST']));
	else
		$domain_bits = explode('.', str_replace('.com', '', $_SERVER['HTTP_HOST']));

	if ( isset($_GET['domain']) ) $_SESSION['domain'] = $_GET['domain'];

	$domain = ($_SESSION['domain']) ? $_SESSION['domain'] : array_pop($domain_bits);

	// We've got some .net's in the house
	$nets = array('alvaradostar', 'burlesonstar', 'crowleystar', 'joshuastar', 'keenestar');
	if ( in_array($domain, $nets) == TRUE )
		$dot = 'net';
}

// To adequately test this, session cookies must be cleared on each load
if ( !isset($_SESSION['favicon']) )
{
	$_SESSION['favicon'] = '';
	// generated from favicons/parse_middleman.py in the dfm-politics repo
	$favicons = array(
	'reporterherald' => 'http://extras.mnginteractive.com/live/media/favIcon/reporterherald/favicon.png',
	'berkshireeagle' => 'http://extras.mnginteractive.com/live/media/favIcon/berkshireeagle/favicon.png',
	'saratogian' => 'http://www.saratogian.com/favicon.ico',
	'trentonian' => 'http://www.trentonian.com/images/tt_favicon.png',
	'delconewsnetwork' => 'http://www.delconewsnetwork.com/images/favicon_dnn.png',
	'timescall' => 'http://extras.mnginteractive.com/live/media/favIcon/timescall/favicon.png',
	'elpasotimes' => 'http://extras.mnginteractive.com/live/media/favIcon/ElPaso/favicon.ico',
	'joshuastar' => 'http://extras.mnginteractive.com/live/media/favIcon/joshuastar/favicon.png',
	'olneyenterprise' => 'http://extras.mnginteractive.com/live/media/favIcon/olneyenterprise/favicon.png',
	'romeobserver' => 'http://www.romeobserver.com/images/ro_favicon.png',
	'somosfrontera' => 'http://extras.mnginteractive.com/live/media/favIcon/SomosFrontera/favicon.ico',
	'lowellsun' => 'http://extras.mnginteractive.com/live/media/favIcon/lowellsun/favicon.png',
	'ukiahdailyjournal' => 'http://extras.mnginteractive.com/live/media/favIcon/ukiahdailyjournal/favicon.png',
	'brushnewstribune' => 'http://extras.mnginteractive.com/live/media/favIcon/brushnewstribune/favicon.png',
	'lavozpa' => 'http://www.lavozpa.com/images/voz_favicon.png',
	'daily-times' => 'http://extras.mnginteractive.com/live/media/favIcon/daily-times/favicon.png',
	'scsun-news' => 'http://extras.mnginteractive.com/live/media/favIcon/scsun-news/favicon.png',
	'tbrnews' => 'http://extras.mnginteractive.com/live/media/favIcon/tbrnews/favicon.png',
	'alamogordonews' => 'http://extras.mnginteractive.com/live/media/favIcon/alamogordonews/favicon.png',
	'burlington-record' => 'http://extras.mnginteractive.com/live/media/favIcon/burlington-record/favicon.png',
	'montereyherald' => 'http://extras.mnginteractive.com/live/media/favIcon/monterey/favicon.ico',
	'housatonictimes' => 'http://www.housatonictimes.com/images/ht_favicon.png',
	'macombdaily' => 'http://www.macombdaily.com/images/md_favicon.png',
	'thenewsherald' => 'http://www.thenewsherald.com/favicon.ico',
	'redwoodtimes' => 'http://extras.mnginteractive.com/live/media/favIcon/redwoodtimes/favicon.png',
	'fortmorgantimes' => 'http://extras.mnginteractive.com/live/media/favIcon/fortmorgantimes/favicon.png',
	'newhavenregister' => 'http://www.nhregister.com/favicon.ico',
	'denverpost' => 'http://extras.mnginteractive.com/live/media/favIcon/dpo/favicon.ico',
	'vivacolorado' => 'http://extras.mnginteractive.com/live/media/favIcon/VivaColorado/favicon.ico',
	'heritage' => 'http://www.heritage.com/favicon.ico',
	'redlandsdailyfacts' => 'http://lang.dailynews.com/socal/favicons/redlands.ico',
	'coloradodaily' => 'http://extras.mnginteractive.com/live/media/favIcon/ColoradoDaily/favicon.ico',
	'whittierdailynews' => 'http://lang.dailynews.com/socal/favicons/whittier.ico',
	'thetranscript' => 'http://extras.mnginteractive.com/live/media/favIcon/thetranscript/favicon.png',
	'southernchestercountyweeklies' => 'http://www.southernchestercountyweeklies.com/images/favicon_sccw.png',
	'crowleystar' => 'http://extras.mnginteractive.com/live/media/favIcon/crowleystar/favicon.png',
	'voicenews' => 'http://www.voicenews.com/images/mi_favicon.png',
	'sourcenewspapers' => 'http://www.sourcenewspapers.com/images/mi_favicon.png',
	'advocate-news' => 'http://extras.mnginteractive.com/live/media/favIcon/advocate-news/favicon.png',
	'marinij' => 'http://extras.mnginteractive.com/live/media/favIcon/marinij/favicon.png',
	'parkrecord' => 'http://extras.mnginteractive.com/live/media/favIcon/parkrecord/favicon.png',
	'dailybreeze' => 'http://lang.dailynews.com/socal/favicons/dailybreeze.ico',
	'news-herald' => 'http://www.news-herald.com/favicon.ico',
	'nhregister' => 'http://www.nhregister.com/favicon.ico',
	'manchesterjournal' => 'http://extras.mnginteractive.com/live/media/favIcon/manchesterjournal/favicon.png',
	'dailybulletin' => 'http://lang.dailynews.com/socal/favicons/dailybulletin.ico',
	'advocateweekly' => 'http://extras.mnginteractive.com/live/media/favIcon/advocateweekly/favicon.png',
	'southjerseylocalnews' => 'http://www.southjerseylocalnews.com/images/favicon_sjln.png',
	'journal-advocate' => 'http://extras.mnginteractive.com/live/media/favIcon/journal-advocate/favicon.png',
	'nashobapublishing' => 'http://extras.sentinelandenterprise.com/sent/np_favicon.ico',
	'yorkdispatch' => 'http://extras.mnginteractive.com/live/media/favIcon/yorkdispatch/favicon.png',
	'gazettes' => 'http://www.google.com/s2/favicons?domain=gazettes.com',
	'presstelegram' => 'http://lang.dailynews.com/socal/favicons/presstele.ico',
	'jacksboronewspapers' => 'http://extras.mnginteractive.com/live/media/favIcon/jacksboronewspapers/favicon.png',
	'record-bee' => 'http://extras.mnginteractive.com/live/media/favIcon/record-bee/favicon.png',
	'ctpostchronicle' => 'http://www.ctpostchronicle.com/images/pc_favicon.png',
	'ctbulletin' => 'http://www.ctbulletin.com/images/mob_favicon.png',
	'coloradohometownweekly' => 'http://extras.mnginteractive.com/live/media/favIcon/coloradohometownweekly/favicon.png',
	'pressandguide' => 'http://www.pressandguide.com/images/mi_favicon.png',
	'troyrecord' => 'http://www.troyrecord.com/favicon.ico',
	'mercurynews' => 'http://extras.mnginteractive.com/live/media/favIcon/mercury/favicon.ico',
	'benningtonbanner' => 'http://extras.mnginteractive.com/live/media/favIcon/benningtonbanner/favicon.png',
	'sentinelandenterprise' => 'http://extras.sentinelandenterprise.com/sent/favicon.ico',
	'dailyfreeman' => 'http://www.dailyfreeman.com/favicon.ico',
	'dailytribune' => 'http://www.dailytribune.com/images/dt_favicon.png',
	'sbsun' => 'http://lang.dailynews.com/socal/favicons/thesun.ico',
	'cnweekly' => 'http://www.cnweekly.com/images/cn-favicon.png',
	'detroitnews' => 'http://www.google.com/s2/favicons?domain=detroitnews.com',
	'akronnewsreporter' => 'http://extras.mnginteractive.com/live/media/favIcon/akronnewsreporter/favicon.png',
	'ruidosonews' => 'http://extras.mnginteractive.com/live/media/favIcon/ruidosonews/favicon.png',
	'reformer' => 'http://extras.mnginteractive.com/live/media/favIcon/reformer/favicon.png',
	'contracostatimes' => 'http://extras.mnginteractive.com/live/media/favIcon/contra/favicon.ico',
	'morningstarpublishing' => 'http://www.morningstarpublishing.com/images/mi_favicon.png',
	'connecticutmag' => 'http://www.connecticutmag.com/favicon.ico',
	'twincities' => 'http://extras.mnginteractive.com/live/media/favIcon/twincities/favicon.png',
	'publicopiniononline' => 'http://extras.mnginteractive.com/live/media/favIcon/publicopiniononline/favicon.png',
	'foothillsmediagroup' => 'http://www.foothillsmediagroup.com/favicon.ico',
	'foothillstrader' => 'http://www.foothillstrader.com/images/ft_favicon.png',
	'insidebayarea' => 'http://extras.mnginteractive.com/live/media/favIcon/IBA/favicon.ico',
	'longmontweekly' => 'http://extras.mnginteractive.com/live/media/favIcon/longmontweekly/favicon.png',
	'mainlinemedianews' => 'http://www.mainlinemedianews.com/favicon.ico',
	'buckslocalnews' => 'http://www.buckslocalnews.com/images/favicon_bln.png',
	'pvnews' => 'http://extras.mnginteractive.com/live/media/favIcon/pvnews/favicon.png',
	'ydr' => 'http://extras.mnginteractive.com/live/media/favIcon/ydr/favicon.png',
	'currentargus' => 'http://extras.mnginteractive.com/live/media/favIcon/currentargus/favicon.png',
	'thereporteronline' => 'http://www.thereporteronline.com/images/ro_favicon.png',
	'dailydemocrat' => 'http://extras.mnginteractive.com/live/media/favIcon/dailydemocrat/favicon.png',
	'mendocinobeacon' => 'http://extras.mnginteractive.com/live/media/favIcon/mendocinobeacon/favicon.png',
	'timesheraldonline' => 'http://extras.mnginteractive.com/live/media/favIcon/timesheraldonline/favicon.png',
	'eveningsun' => 'http://extras.mnginteractive.com/live/media/favIcon/eveningsun/favicon.png',
	'minutemannewscenter' => 'http://www.minutemannewscenter.com/images/mnc_favicon.png',
	'pottsmerc' => 'http://www.pottsmerc.com/images/tm_favicon.png',
	'impactousa' => 'http://extras.mnginteractive.com/live/media/favIcon/impactousa/favicon.png',
	'themorningsun' => 'http://www.themorningsun.com/images/ms_favicon.png',
	'dailynews' => 'http://lang.dailynews.com/socal/favicons/dn.ico',
	'breckenridgeamerican' => 'http://extras.mnginteractive.com/live/media/favIcon/breckenridgeamerican/favicon.png',
	'dailycamera' => 'http://extras.mnginteractive.com/live/media/favIcon/DailyCamera/dcicon.ico',
	'sgvtribune' => 'http://lang.dailynews.com/socal/favicons/sangabe.ico',
	'chicoer' => 'http://extras.mnginteractive.com/live/media/favIcon/chico/favicon.ico',
	'pasadenastarnews' => 'http://lang.dailynews.com/socal/favicons/pasadena.ico',
	'dolphin-news' => 'http://www.dolphin-news.com/images/dn-favicon.png',
	'redbluffdailynews' => 'http://extras.mnginteractive.com/live/media/favIcon/RedBluff/favicon.ico',
	'eptrail' => 'http://extras.mnginteractive.com/live/media/favIcon/eptrail/favicon.png',
	'timesherald' => 'http://www.timesherald.com/images/th_favicon.png',
	'phoenixvillenews' => 'http://www.phoenixvillenews.com/images/pv_favicon.png',
	'demingheadlight' => 'http://extras.mnginteractive.com/live/media/favIcon/demingheadlight/favicon.png',
	'Times-Standard (Eureka)' => 'http://extras.mnginteractive.com/live/media/favIcon/EurekaTimes/favicon.ico',
	'countytimes' => 'http://www.countytimes.com/images/ct_favicon.png',
	'westhartfordnews' => 'http://www.westhartfordnews.com/images/whn_favicon2.png',
	'willitsnews' => 'http://extras.mnginteractive.com/live/media/favIcon/willitsnews/favicon.png',
	'julesburgadvocate' => 'http://extras.mnginteractive.com/live/media/favIcon/julesburgadvocate/favicon.png',
	'keenestar' => 'http://extras.mnginteractive.com/live/media/favIcon/keenestar/favicon.png',
	'orovillemr' => 'http://extras.mnginteractive.com/live/media/favIcon/orovillemr/favicon.png',
	'oneidadispatch' => 'http://www.oneidadispatch.com/favicon.ico',
	'broomfieldenterprise' => 'http://extras.mnginteractive.com/live/media/favIcon/broomfieldenterprise/favicon.png',
	'alvaradostar' => 'http://extras.mnginteractive.com/live/media/favIcon/alvaradostar/favicon.png',
	'registercitizen' => 'http://www.registercitizen.com/favicon.ico',
	'berksmontnews' => 'http://www.berksmontnews.com/images/b-m_favicon.png',
	'burlesonstar' => 'http://extras.mnginteractive.com/live/media/favIcon/burlestonstar/favicon.png',
	'shorelinetimes' => 'http://www.shorelinetimes.com/images/st-favicon.png',
	'dailylocal' => 'http://www.dailylocal.com/images/dl_favicon.png',
	'paradisepost' => 'http://extras.mnginteractive.com/live/media/favIcon/paradisepost/favicon.png',
	'ldnews' => 'http://extras.mnginteractive.com/live/media/favIcon/ldnews/favicon.png',
	'middletownpress' => 'http://www.middletownpress.com/favicon.ico',
	'thevalleydispatch' => 'http://extras.mnginteractive.com/live/media/favIcon/thevalleydispatch/favicon.png',
	'lcsun-news' => 'http://extras.mnginteractive.com/live/media/site557/2009/1215/20091215_084156_lcsn%20favicon_19.jpg',
	'lamarledger' => 'http://extras.mnginteractive.com/live/media/favIcon/lamarledger/favicon.png',
	'montgomerynews' => 'http://www.montgomerynews.com/favicon.ico',
	'lakecountrysun' => 'http://extras.mnginteractive.com/live/media/favIcon/lakecountrysun/favicon.png',
	'santacruzsentinel' => 'http://extras.mnginteractive.com/live/media/favIcon/santacruzsentinel/favicon.png',
	'canoncitydailyrecord' => 'http://extras.mnginteractive.com/live/media/favIcon/canoncitydailyrecord/favicon.png',
	'morningjournal' => 'http://www.morningjournal.com/favicon.ico',
	'grahamleader' => 'http://extras.mnginteractive.com/live/media/favIcon/grahamleader/favicon.png',
	);
	if ( key_exists($domain, $favicons) && strpos($favicons[$domain], 'http') === 0 )
	{
	$_SESSION['favicon'] = $favicons[$domain];
	}
} 

if ( isset($_SESSION['favicon']) && $_SESSION['favicon'] != '' ) echo '<link rel="icon" href="' . $_SESSION['favicon'] . '" type="image/x-icon" />';
else
{
	echo '<link rel="shortcut icon" href="';
	bloginfo('template_url');
	echo '/assets/favicon.ico" />';	
} ?>

<!-- Styles  -->
	<link rel="stylesheet" type="text/css" href="<?php bloginfo('stylesheet_url'); ?>" />
	<link rel="stylesheet" type="text/css" href="<?php bloginfo('stylesheet_directory'); ?>/library/nav/css/superfish.css" media="screen" />
	<link rel="stylesheet" type="text/css" href="<?php bloginfo('template_directory'); ?>/library/styles/print.css" media="print" />

	<!--[if IE]><link rel="stylesheet" type="text/css" href="<?php bloginfo('template_directory'); ?>/library/styles/ie.css" media="screen, projection" /><![endif]-->
	<!--<link rel="stylesheet" type="text/css" href="<?php bloginfo('template_directory'); ?>/library/styles/basic_ie.css" media="screen, projection" />-->
	
	<?php if ($css) {?>
	<link rel="stylesheet" type="text/css" href="<?php bloginfo('template_directory'); ?>/library/functions/style.php" media="screen, projection" />
	<?php } 
	/*  add header logo style */	
	$header_logo = get_option('T_header_logo');
	?>
	
<!--	<link rel="stylesheet" type="text/css" href="<?php bloginfo('template_directory'); ?>/library/functions/themecss.php" media="screen, projection" /> -->

	<link rel="alternate" type="application/rss+xml" title="<?php bloginfo('name'); ?> RSS Feed" href="<?php bloginfo('rss2_url'); ?>" />
	<link rel="pingback" href="<?php bloginfo('pingback_url'); ?>" />
	
	<?php $posttags = get_the_tags(); $mytag = getmy_tag($posttags); //get the post tag ?>
	<?php // Canonical link for DFM Syndication.
	if ( is_singular() ) {
		remove_action('wp_head','rel_canonical'); // Default canonical tag removed (rel_canonical) because it does not work the way we need it to for syndication.
		// Won't work locally if your syndication_source_uri doesn't have dfm in the url
		if (strrpos($syndUrl = get_post_meta($post->ID, "syndication_source_uri", true), 'dfm') !== false && function_exists('createCanonical')) {
				echo createCanonical($syndUrl);
		}
		else {?>
			<link rel="canonical" href="<?php echo get_post_meta($post->ID, "syndication_source_uri", true); ?>" />
	<?php 
		}
	} ?>
	
    <?php $category = get_the_category();  //get the post category ?>
    <?php 
	$alldeeezcats = deeez_cats($category); // category list comma separated in quotes for apt ad tags IN THE HEADER ONLY
	//echo "deezcats " . $alldeeezcats;
	$alldeeezcats2 = deeez_cats2($category); // category list for omniture and used for ad tags IN THE IFRAME ONLY
	//echo "deezcats2 " . $alldeeezcats2;
	$slash_cats = slash_cats($category); // forward slash seperated list for dfp ad tags
	$parentcat = parent_of_cat($category);
	?>
	<?php if ( is_singular() ) {
	
		
	 //get the value of the custom field google_survey_off, if set to utahraz don't show the survey. google_survery var is in the gallerific.js file line 517ish.
    if ( $google_var = get_post_meta( $post->ID, 'google_survey_off', true) ) { 
        echo '<script type="text/javascript">var google_survey = "' . $google_var . '";</script>' . "\n";
    }
    else
    {
    	$google_var = null;
    	echo '<script type="text/javascript">var google_survey = "' . $google_var . '";</script>' . "\n";
    }
    //google survey container for Dart tag
    echo '<script type="text/javascript">var showGoogle = "";</script>' . "\n";

	$thepagetag = strtolower('mc_' . $mytag);
	//echo "mytag is " . $mytag;
	/*
if ($mytag == "special_project"){
	include (THEMELIB . '/apps/quicktime.php');
	}
	if ($mytag == ""){
	include (THEMELIB . '/apps/quicktime.php');
	}
*/
	if ($mytag == "Video"){
	//echo $mytag;
	$thevidid = get_post_meta($post->ID, 'videoid', true);
	$bcpub = get_option('T_bcpubid');
	$bcplayid = get_option('T_bcplayerid');
	$faceapid = $_SESSION['siteconfig']['facebook_app_id'];
	//$faceapid = get_option('T_fbappid');

	//var_dump($thethumb);
	$image_id = get_post_thumbnail_id();  
	$image_url = wp_get_attachment_image_src($image_id,'thumbnail');
	//var_dump($image_url);
	echo '<meta property="fb:app_id" content="' . $faceapid . '">';
	echo '<meta property="og:type" content="video">';
	echo '<meta property="og:video:width" content="398">';
	echo '<meta property="og:video:height" content="224">';
	echo '<meta property="og:url"  content="' . get_permalink() . '">';
	echo '<meta property="og:video" content="http://c.brightcove.com/services/viewer/federated_f9?isVid=1&isUI=1&secureConnections=1&publisherID=' . $bcpub . '&playerID=' . $bcplayid  . '&domain=embed&videoId=' . $thevidid . '">';
	//echo '<link rel="video_src" href="http://c.brightcove.com/services/viewer/federated_f9?isVid=1&isUI=1&publisherID=934995285&playerID=1014161614001&domain=embed&videoId=' . $thethumb .'" />';
	//echo '<link rel="image_src" href="' . $image_url[0] . '" />';
	echo '<meta property="og:image" content="' . $image_url[0] . '">';
	echo '<meta property="og:video:type" content="application/x-shockwave-flash">';
	}
	
	if ($mytag == "Photo" || "photo"){
	//start get thumbnail info
	$thumb_markup = '';
	$fb_image = '';
	$faceapid = $_SESSION['siteconfig']['facebook_app_id'];
	//$faceapid = get_option('T_fbappid');
	//if there is a featured image on the post use that
	$image_id = get_post_thumbnail_id();
	  	if(!empty($image_id)) {
	  	$image_url = wp_get_attachment_image_src($image_id,'thumbnail');
	  	$fb_image = $image_url[0];
	  	echo '<meta property="fb:app_id" content="' . $faceapid . '">' . "\n";
		echo '<meta property="og:type" content="article">' . "\n";
		echo '<meta property="og:url" content="' . get_permalink() . '">' . "\n";
		echo '<meta property="og:image" content="' . $fb_image . '">' . "\n";
	  	}
	
	//if there is a ssp custom field thumbnail set use this
	$thumb = get_post_meta($post->ID, 'thumbnail', true);
		if(!empty($thumb)) {
		$thumb_markup = generate_thumb($thumb);
		$fb_image = $thumb_markup['fbook_url'];
		//end get thumbnail info
		
		echo '<meta property="fb:app_id" content="' . $faceapid . '">' . "\n";
		echo '<meta property="og:type" content="article">' . "\n";
		echo '<meta property="og:url" content="' . get_permalink() . '">' . "\n";
		echo '<meta property="og:image" content="' . $fb_image . '">' . "\n";
		}
	
	//get the smugmug thumbnail if it's a smug gallery
	$smugthumb = get_post_meta($post->ID, 'smugdata', true);
		if(!empty($smugthumb)) {
		$thumb_markup =getSmugThumb($smugthumb); /* this function is in the shared functions plugin */
		$fb_image = $thumb_markup[0]["MediumURL"];
		//end get thumbnail info
		
		echo '<meta property="fb:app_id" content="' . $faceapid . '">' . "\n";
		echo '<meta property="og:type" content="article">' . "\n";
		echo '<meta property="og:url" content="' . get_permalink() . '">' . "\n";
		echo '<meta property="og:image" content="' . $fb_image . '">' . "\n";
		}
	}
	
	$thepagetitle = trim(wp_title('', false));
	include (THEMELIB . '/apps/omnituresingle.php');
	} wp_enqueue_script( 'comment-reply' ); ?>
    
	<?php if ( is_home() ) { 
	$thepagetag = 'home';
	$thepagecat = 'home';
	$thepagetitle = 'home';
	$theme_options = get_option('T_theme_options');
	include (THEMELIB . '/apps/omnituresingle.php');
	}?>

	<?php if ( is_archive() ) {
	//echo single_cat_title();
	$thepagetag = 'archive_galleries';
	$thepagetitle = trim(wp_title('', false));
	include (THEMELIB . '/apps/omnituresingle.php');
	}?>
    
    <?php if ( is_search() ) {
	$thepagetag = 'search_galleries';
	$thepagetitle = trim(wp_title('', false));
	include (THEMELIB . '/apps/omnituresingle.php');
	}?>
    
    <?php if ( is_preview() ) {
    //empty function so preview shows gallery and does not count page view in omniture
    echo '<script type="text/javascript">function omniTrack(){};</script>';
     }?> 

   <?php


include (THEMELIB . '/ads/adtags.php');

 
?>


<?php wp_head(); ?>
<script type="text/javascript"> 
 
    jQuery(document).ready(function() { 
        jQuery('ul.sf-menu').superfish({ 
            delay:       500,                            // one second delay on mouseout 
            animation:   {opacity:'show',height:'show'},  // fade-in and slide-down animation 
            speed:       'fast',                          // faster animation speed 
            autoArrows:  true,                           // disable generation of arrow mark-up 
            dropShadows: true                            // disable drop shadows 
        }); 
    }); 
 
</script>


<!--Visual Revenue Reader Response Tracking Script (v6) -->
<script type="text/javascript">
	var _vrq = _vrq || [];
	_vrq.push(['id', 177]);
	_vrq.push(['automate', true]);
	_vrq.push(['track', function(){}]);
	(function(d, a){
		var s = d.createElement(a),
		x = d.getElementsByTagName(a)[0];
		s.async = true;
		s.src = 'http://a.visualrevenue.com/vrs.js';
		x.parentNode.insertBefore(s, x);
	})(document, 'script');
</script>
<!-- End of VR RR Tracking Script - All rights reserved -->

<script>
var _gaq = _gaq || [];
  _gaq.push(['_setAccount', '<?php echo $_SESSION['siteconfig']['google_analytics']; ?>']);
  _gaq.push(['_trackPageview']);

  (function() {
    var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
    ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
  })();
</script>

</head>

<body <?php body_class();?>>

<script type="text/javascript">
//var articleUrl = window.location.protocol + "://" + window.location.host + "/" + window.location.pathname;
window.twitterHandle = "<?php echo $_SESSION['siteconfig']["twitter_short_name"] ?>";

var TriggerPrompt = function(articleUrl, contentId) {

	var ARTICLE_URL = articleUrl;
   var CONTENT_ID = contentId || '';
   var el = document.createElement('script');
   var url = 'http://survey.g.doubleclick.net/survey?site=55481229' +
             '&url=' + encodeURIComponent(ARTICLE_URL) +
             (CONTENT_ID ? '&cid=' + encodeURIComponent(CONTENT_ID) : '') +
             '&random=' + (new Date).getTime() +
             '&after=1';
	if ( typeof console.log != 'undefined' ) console.log(url);
   el.setAttribute('src', url);
   var head = document.getElementsByTagName('head')[0] ||
       document.getElementsByTagName('body')[0];
   head.appendChild(el);
 };
</script>
<?php //load wallpaper ad
if ($_SESSION['siteconfig']["ad_server_on_mc"] == "apt") {
			switch ($_SESSION['parent_company']){
			case("jrc"):?>
				<script type="text/javascript" language="JavaScript">yld_mgr.place_ad_here("popunder_slot");</script>
				<?php break;
			case("mngi"):?>
				<script type="text/javascript" language="JavaScript">yld_mgr.place_ad_here("adPos3");</script>
				<?php break;
		}
} elseif ($_SESSION['siteconfig']["ad_server_on_mc"] == "dfp") {?>
  
	<div id="header"></div>
	<!-- Beginning Sync AdSlot 4 [100,100]]  -->
	<div id='wallpaper'>
	<script type='text/javascript'>
	googletag.display('wallpaper');
	</script>
	</div>
	<!-- End AdSlot 4 -->

	<!-- Beginning Sync AdSlot 5 [50,50]]  -->
	<div id='interstitial'>
	<script type='text/javascript'>
	googletag.display('interstitial');
	</script>
	</div>
	<!-- End AdSlot 5 -->

    
    <?php } ?>	
<?php 
	$homesite = get_option('T_sitenamex');
	$theme_options = get_option('T_theme_options');
?>
<div id="myhatwrap" class="shadow" style="background-color:<?php echo $sitelogo = get_option('T_header_logo_bg'); ?>;">
<div id="myhat">
<div class="papertitle"><a target="_self" href="<?php echo $homesite = get_option('T_sitenamex'); ?>"><img src="<?php echo $sitelogo = get_option('T_header_logo_path'); ?>" alt="<?php echo $homesite = get_option('T_sitenamex'); ?>" /></a></div>
<?php
	//Header Links in logo bar - Jason Armour 3.19.2012
	$header_links = get_option('T_header_links');
	if($header_links) { include (THEMELIB . '/apps/header_links.php'); }
?>

<?php include (TEMPLATEPATH . '/searchform.php'); ?>
<!-- end my hat -->
</div>
<!-- end my hat wrap -->
</div>
<div class="clear"></div>
<div id="top">

<!-- Begin Masthead -->
<div id="masthead">

<a style="float:right; margin:13px 25px 0px 0px;" href="<?php bloginfo('rss2_url'); ?>" class="feed">Subscribe via RSS</a>

<a href="<?php echo get_settings('home'); ?>"><img src="<?php echo bloginfo('template_directory') . '/images/mcenter.png'; ?>" style="float:left; margin-top:5px; margin-left:20px;" /></a>

</div>
<div class="clear"></div>
<?php include (TEMPLATEPATH . '/nav.php'); ?>
<div class="clear"></div>
<?php //load pencil ad

if ($_SESSION['siteconfig']["ad_server_on_mc"] == "apt") {
		switch ($_SESSION['parent_company']){
			case("jrc"):?>
				<div style="margin-left:6px; margin-top:0px;"><script type="text/javascript" language="JavaScript">yld_mgr.place_ad_here("pencil_slot");</script></div>
				<?php if ( is_home() ) { ?>
					<div style="margin: 5px 0px 3px 20px; height:110px;"><div style="float:left; margin: 0px 10px 0px 0px; padding-top: 10px; width: 728px;"><script type="text/javascript" language="JavaScript">yld_mgr.place_ad_here("top_slot");</script></div><div style="float: left; height: 102px; margin-top; 5px; width: 200px;"><script type="text/javascript" language="JavaScript">yld_mgr.place_ad_here("topright_slot");</script></div></div>
				<?php } ?>
				<?php break;
			case("mngi"):?>
				<div style="margin-left:6px; margin-top:0px;"><script type="text/javascript" language="JavaScript">yld_mgr.place_ad_here("adPos1");</script></div>
				<?php break;
	}
} elseif ($_SESSION['siteconfig']["ad_server_on_mc"] == "dfp") {?>
    
    <!-- Beginning Sync AdSlot 3 [[970,30]]  -->
	<div id='sbb'>
	<script type='text/javascript'>
	googletag.display('sbb');
	</script>
	</div>
	<!-- End AdSlot 3 -->
    
    <?php } ?>

</div>
</div>
<div class="container">
	<div class="container-inner">
