<?php
/**
 * The main template file
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * E.g., it puts together the home page when no home.php file
 *
 * Methods for TimberHelper can be found in the /functions sub-directory
 *
 * @package 	WordPress
 * @subpackage 	Timber
 * @since 		Timber 0.1
 * Template Name: RSS Feed List
 */
//$context = Timber::get_context();
$context = global_context($context);
//$domain_bits = explode('.', $_SERVER['HTTP_HOST']);
//$context['dfm'] = DFMDataForWP::retrieveRowFromMasterData('domain', $domain_bits[1]);
$context['categories'] = Timber::get_terms('category', array('parent' => 0));
Timber::render('rsslist.twig', $context);

?>