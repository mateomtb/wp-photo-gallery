<?php 

/**
 * Plugin Name: DFM Eventful
 * Description: Add the eventful widget to DFM Unbolt Wordpress project.
 * Version: 1.0
 * Author: Brian Henderson
 * Author Contact : bhenderson@Pioneerpress.com
 * License: TBD
**/



add_action( 'wp_enqueue_scripts', 'register_eventful_styles' );

function register_eventful_styles() {
	wp_register_style( 'jqueryuicss', 'http://ajax.googleapis.com/ajax/libs/jqueryui/1.10.4/themes/smoothness/jquery-ui.css');
	wp_enqueue_style( 'jqueryuicss' );
    wp_register_style( 'eventfulcss', plugins_url('/dfm-wp-eventful/css/eventful.css'));
	wp_enqueue_style( 'eventfulcss' );

}



function get_eventful(){
$domain_bits = explode('.', $_SERVER['HTTP_HOST']);
$context['dfm'] = DFMDataForWP::retrieveRowFromMasterData('domain', $domain_bits[1]);
$eventsURL= $context['dfm']['events_url'] ; 
$apiToken= $context['dfm']['events_api'] ;
$eventfulURL= $eventsURL . '/api/v1/events/search?api_token=' . $apiToken . '&sort_order=popularity&image_size=block250';

$apiCategory = '';
$eventsJSON = json_decode(file_get_contents($eventfulURL));
$events = $eventsJSON->api_results->events;
$events = array_slice($events, 0, 4);
$pageloc = $_SERVER["QUERY_STRING"];

	if (strpos($pageloc,'music') || strpos($pageloc,'reverb') == true) {
		$apiCategory = 'music';
	}
	if (strpos($pageloc,'food') || strpos($pageloc,'restaurant') == true) {
		$apiCategory = 'food';
	}
	if (strpos($pageloc,'stage') || strpos($pageloc,'theater') == true) {
		$apiCategory = 'performing_arts';
	}
	if (strpos($pageloc,'sports') || strpos($pageloc,'buffzone') == true) {
		$apiCategory = 'sports';
	}		
	if (strpos($pageloc,'movie') || strpos($pageloc,'film') || strpos($pageloc,'cinema') == true) {
		$apiCategory = 'movies_film';
	}
	if (strpos($pageloc,'moms') || strpos($pageloc,'family') || strpos($pageloc,'kids') == true) {
		$apiCategory = 'family_fun_kids';
	}	
	if (strpos($pageloc,'books') == true) {
		$apiCategory = 'books';
	}
	if (strpos($pageloc,'comedy') == true) {
		$apiCategory = 'comedy';
	}
	if (strpos($pageloc,'art') == true) {
		$apiCategory = 'art';
	}
    if (strpos($pageloc,'business') == true) {
		$apiCategory = 'business';
	}
    if (strpos($pageloc,'health') == true) {
		$apiCategory = 'support';		
	}

		$apiCall =  $eventsURL . '/api/v1/events/search?api_token=' . $apiToken . '&sort_order=popularity&image_size=block250&category=' . $apiCategory;		
		$eventsJSON = json_decode(file_get_contents($apiCall));
		$events = $eventsJSON->api_results->events;
		$events = array_slice($events, 0, 4);
		return ($events);
}
 ?>