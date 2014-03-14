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
 */

if (!class_exists('Timber')):
    echo 'Timber not activated. Make sure you activate the plugin in <a href="/wp-admin/plugins.php#timber">/wp-admin/plugins.php</a>';
endif;
$context = Timber::get_context();
$context['posts'] = Timber::get_posts();
// As we run specific queries, we need a place to store IDs of posts that are curated
// so they can be excluded from subsequent queries
$context['exclude_posts'] = array();
$templates = array('index.twig');
include get_template_directory() . '/homepage.php';
$zipCode = $_SESSION['dfm']['zip_code'];
$context['media_center'] = ($mc = json_decode(file_get_contents(getMediaCenterFeed($context['section'])), true)) ? $mc : null;
$context['get_weather'] = ($get_weather = getWeather($apiUrl, $zipCode, $apiKey)) ? $get_weather : null;
$context['get_cw'] = ($gw = json_decode(file_get_contents(getCurrentConditions($apiUrl, $get_weather, $wLanguage, $apiKey)), true)) ? $gw : null;
$context['get_fc'] = ($fc = json_decode(file_get_contents(getForecasts($apiUrl, $get_weather, $wLanguage, $apiKey)), true)) ? $fc : null;
$context['get_traffic'] = ($get_traffic = getTraffic($zipCode)) ? $get_traffic : null;
$context['get_timezone'] = ($timezone = getTimeZone()) ? $timezone : null;
if (is_home()) array_unshift($templates, 'home.twig');
Timber::render('index.twig', $context);