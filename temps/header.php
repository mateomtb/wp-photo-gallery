<!DOCTYPE HTML> 
<!--[if IE 8]>    <html class="no-js lt-ie9" lang="en"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js" lang="en"> <!--<![endif]-->
<head>
	<title><?php echo THE_TITLE; ?></title>
    <?php include('temps/meta/boilerplate.php'); ?>
    <?php include('temps/meta/app.php'); ?>
    <?php include('temps/meta/facebook.php'); ?>
    <?php include('temps/meta/twitter.php'); ?>
	<!-- MODERNIZER -->
	<script src="<?php echo JS_DIR; ?>/lib/modernizr.js"></script>
	
	<!-- STYLESHEETS -->
	<link rel="stylesheet" href="<?php echo BASE_URL;?>/css/bartertown.min.css" media="screen"/> 

</head>
<body <?php if($page_type === 'home') { echo ' class="home-page"'; }
       else if($page_type === 'section') { echo ' class="section-page"'; }
       else if($page_type === 'article') { echo ' class="article-page"'; }?>>
	<!-- Chrome Frame -->
	<!--[if lt IE 8]><p class="chromeframe">Your browser is <em>old.</em> <a href="http://browsehappy.com/">Upgrade to a different browser</a> or <a href="http://www.google.com/chromeframe/?redirect=true">install Google Chrome Frame</a> to experience this site.</p><![endif]-->
	<?php if($leader == 'true' || $allads == 'true') { include('ads/leaderboard-static.php'); } ?>
	<header id="site-header">
		<?php include('temps/ui/flag.php'); ?>
		<?php include('temps/ui/main-nav.php'); ?>
		<?php include('temps/ui/hot-topics.php'); ?>
		<?php if($pencil == 'true' || $allads == 'true') { include('ads/pencil.php'); }?>
	</header>
	<div id="content" class="container">