<?php
	$sidebar = false;
	$alert = false;
	$allads = false;
	$leader = false;
	$earads = false;
	$pencil = false;
	$wallpaper = false;
	$reload = false;
	$realads = false;
	$inline_promo = false;
	$factbox = false;
	$rightrail_promo = false;
	$section_promo = false;
	$section_promo2 = false;
	$loggedin = false;
	$secondstory = false;

	if(isset($_REQUEST['sidebar']) && $_REQUEST['sidebar'] == true) {
		$sidebar = true;
	}
	if(isset($_REQUEST['alert']) && $_REQUEST['alert'] == true) {
		$alert = true;
	}
	if(isset($_REQUEST['earads']) && $_REQUEST['earads'] == true) {
		$earads = true;
	}
	if(isset($_REQUEST['leader']) && $_REQUEST['leader'] == true) {
		$leader = true;
	}
	if(isset($_REQUEST['pencil']) && $_REQUEST['pencil'] == true) {
		$pencil = true;
	}
	if(isset($_REQUEST['allads']) && $_REQUEST['allads'] == true) {
		$allads = true;
	}
	if(isset($_REQUEST['wallpaper']) && $_REQUEST['wallpaper'] == true) {
		$wallpaper = true;
	}
	if(isset($_REQUEST['reload']) && $_REQUEST['reload'] == true) {
		$reload = true;
	}
	if(isset($_REQUEST['realads']) && $_REQUEST['realads'] == true) {
		$realads = true;
		$allads = true;
	}
	if(isset($_REQUEST['inlinepromo']) && $_REQUEST['inlinepromo'] == true) {
		$inline_promo = true;
	}
	if(isset($_REQUEST['factbox']) && $_REQUEST['factbox'] == true) {
		$factbox = true;
	}
	if(isset($_REQUEST['rightrailpromo']) && $_REQUEST['rightrailpromo'] == true) {
		$rightrail_promo = true;
	}
	if(isset($_REQUEST['sectionpromo']) && $_REQUEST['sectionpromo'] == true) {
		$section_promo = true;
	}
	if(isset($_REQUEST['sectionpromotwo']) && $_REQUEST['sectionpromotwo'] == true) {
		$section_promo2 = true;
	}
	if(isset($_REQUEST['loggedin']) && $_REQUEST['loggedin'] == true) {
		$loggedin = true;
	}
	if(isset($_REQUEST['secondstory']) && $_REQUEST['secondstory'] == true) {
		$secondstory = true;
	}
?>