<?php
	$sidebar = 'false';
	$alert = 'false';
	$allads = 'false';
	$leader = 'false';
	$earads = 'false';
	$pencil = 'false';
	$wallpaper = 'false';
	$reload = 'false';
	$realads = 'false';
	$inline_promo = 'false';
	$factbox = 'false';
	$rightrail_promo = 'false';
	$section_promo = 'false';
	$section_promo2 = 'false';
	$loggedin = 'false';
	$secondstory = 'false';
	$mostpop = 'false';

	if(isset($_REQUEST['sidebar'])) {
		$sidebar = 'true';
	}
	if(isset($_REQUEST['alert'])) {
		$alert = 'true';
	}
	if(isset($_REQUEST['earads'])) {
		$earads = 'true';
	}
	if(isset($_REQUEST['leader'])) {
		$leader = 'true';
	}
	if(isset($_REQUEST['pencil'])) {
		$pencil = 'true';
	}
	if(isset($_REQUEST['allads'])) {
		$allads = 'true';
	}
	if(isset($_REQUEST['wallpaper'])) {
		$wallpaper = 'true';
	}
	if(isset($_REQUEST['reload'])) {
		$reload = 'true';
	}
	if(isset($_REQUEST['realads'])) {
		$realads = 'true';
		$allads = 'true';
	}
	if(isset($_REQUEST['inlinepromo'])) {
		$inline_promo = 'true';
	}
	if(isset($_REQUEST['factbox'])) {
		$factbox = 'true';
	}
	if(isset($_REQUEST['rightrailpromo'])) {
		$rightrail_promo = 'true';
	}
	if(isset($_REQUEST['sectionpromo'])) {
		$section_promo = 'true';
	}
	if(isset($_REQUEST['sectionpromotwo'])) {
		$section_promo2 = 'true';
	}
	if(isset($_REQUEST['loggedin'])) {
		$loggedin = 'true';
	}
	if(isset($_REQUEST['secondstory'])) {
		$secondstory = 'true';
	}
	if(isset($_REQUEST['mostpop'])) {
		$mostpop = 'true';
	}
?>