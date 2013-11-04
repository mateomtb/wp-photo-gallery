<!DOCTYPE HTML> 
<!--[if IE 8]>    <html class="no-js lt-ie9" lang="en"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js" lang="en"> <!--<![endif]-->
<head>
	<title><?php echo THE_TITLE; ?></title>
    <meta charset="utf-8"> 
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
	<meta http-equiv="imagetoolbar" content="no" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0">
	<!-- MODERNIZER -->
	<script src="<?php echo JS_DIR; ?>/lib/modernizr.js"></script>
	<!-- STYLESHEETS -->
    <link href='http://fonts.googleapis.com/css?family=Merriweather:400,900,700,300' rel='stylesheet' type='text/css'>
	<link href='http://fonts.googleapis.com/css?family=Oxygen:300,400,700' rel='stylesheet' type='text/css'>
	<link rel="stylesheet" href="<?php echo BASE_URL;?>/style.css" media="screen"/>
</head>
<body <?php if($page_type === 'home') { echo ' class="home-page"'; }
       else if($page_type === 'section') { echo ' class="section-page"'; }
       else if($page_type === 'article') { echo ' class="article-page"'; }?>>
	<!-- Chrome Frame -->
	<!--[if lt IE 8]><p class="chromeframe">Your browser is <em>old.</em> <a href="http://browsehappy.com/">Upgrade to a different browser</a> or <a href="http://www.google.com/chromeframe/?redirect=true">install Google Chrome Frame</a> to experience this site.</p><![endif]-->
	<header id="site-header">
		<?php include('temps/ui/flag.php'); ?>
		<?php include('temps/ui/main-nav.php'); ?>
		<?php include('temps/ui/hot-topics.php'); ?>
	</header>
	<div id="content" class="container">