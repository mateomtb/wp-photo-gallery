<?php
/**
 * The template for displaying all pages.
 *
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages
 * and that other 'pages' on your WordPress site will use a
 * different template.
 *
 * To generate specific templates for your pages you can use:
 * /mytheme/views/page-mypage.twig
 * (which will still route through this PHP file)
 * OR
 * /mytheme/page-mypage.php
 * (in which case you'll want to duplicate this file and save to the above path)
 *
 * Methods for TimberHelper can be found in the /functions sub-directory
 *
 * @package  WordPress
 * @subpackage  Timber
 * @since    Timber 0.1
 */
$templates = array('leaf.twig', 'index.twig');
$context = global_context($context);
$domain_bits = explode('.', $_SERVER['HTTP_HOST']);
$context['dfm'] = DFMDataForWP::retrieveRowFromMasterData('domain', $domain_bits[1]);
$post = new TimberPost();
$context['post'] = $post;
Timber::render($templates, $context);
