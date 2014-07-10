<?php

/* Config */
// *** TODO: Cache these requests.
$social = Array('fb'=> '', 'twitter' => '');
$permalink = get_permalink();
if ( $permalink != '' ):
    $social['fb'] = json_decode(
	file_get_contents('https://graph.facebook.com/fql?q=SELECT%20like_count%20FROM%20link_stat%20WHERE%20url=%27' . 
		urlencode($permalink) . '%27')
);
    $url = "http://urls.api.twitter.com/1/urls/count.json?url=" . urlencode($permalink);
    $social['twitter'] = json_decode(file_get_contents($url));
endif;

$relatedCategory = get_the_category();
$relatedCategory = $relatedCategory[0]->slug;

$relatedArgs = array(
	//'cat' => $relatedCategory,
	//'cat' => null,
	'posts_per_page' => 6
);

/* End config */


/* Contexts */

// Sidebar
$sidebarContext = Timber::get_context();
$sidebarContext['post'] = Timber::get_post();

$sidebarContext['fblikes'] = 0;
if (isset($social['fb']->like_count)){
	$sidebarContext['fblikes'] = $social['fb']->like_count;
}

$sidebarContext['tweets'] = $social['twitter']->count;

// Ad
$adContext = array();
$adContext['adposition'] = 'DFM-adPos-cube1';


// Related
$relatedContext = Timber::get_context();
$relatedContext['posts'] = Timber::get_posts($relatedArgs);

?>
