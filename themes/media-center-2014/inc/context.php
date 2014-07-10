<?php

$_SESSION['siteconfig'] = DFMDataForWP::retrieveRowFromMasterData('domain', 'denverpost'); 
$_SESSION['context'] = $_SESSION['siteconfig'];
$_SESSION['context']['themefolder'] = get_bloginfo('template_directory');
//$_SESSION['context']['category'] = get_the_category();  //get the post category 
$_SESSION['context']['domain_pieces'] = explode(".", $_SESSION['siteconfig']["url"]);
$_SESSION['context']['dfp_domain'] = $_SESSION['context']['domain_pieces'][1] . '.' . str_replace("/", "", $_SESSION['context']['domain_pieces'][2]);
//$_SESSION['context']['slash_cats'] = slash_cats($category); // forward slash seperated list for dfp ad tags
//$_SESSION['context']['targetSet'] = preg_replace('/[^a-z0-9_]/i', '_', get_the_title());

?>
