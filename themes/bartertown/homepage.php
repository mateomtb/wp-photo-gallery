<?php
/** Configure Home Page Queries and Assign to Templating Contexts**/


/* Set categories and other config for all content on home page */

// All of the configuration could come from a JSON file for each site
$config = json_decode(file_get_contents(get_template_directory() . '/home_section_json/scsun-home.json'), true);

// Might be a better choice than WP Menus since we will not be overly reliant on a
// WordPress specific implementation?


// array('heading', 'category-slug', number-of-posts, custom-field, custom-field-value);
// Right now heading is sort of useless since we're using the category slug to get the category name
// where a heading is neeeded. But it's probably good to anticipate custom requests?

// Lead Stories
//$leadStory = array(null, null, 1, 'lead_story', 'yes');
$leadStory = array_values($config['lead_story']);
//$secondaryLeadStory = array(null, null, 1, 'secondary_lead_story', 'yes');
$secondaryLeadStory = array_values($config['secondary_lead_story']);
//$relatedStories = array('Related Stories', 'news', 4);
$relatedStories = array_values($config['related_stories']);



/*$secondaryStories = array(
    array('News', 'news', 1, 'secondary_story', 'yes'),
    array('Sports', 'sports', 1, 'secondary_story', 'yes'),
    array('Entertainment', 'entertainment', 1, 'secondary_story', 'yes')
);*/

$secondaryStories = array_values($config['secondary_stories']);


// Feed stories (In Other News)
//$feedStoryHeading = 'In Other News';

/*$storyFeeds = array(
    array('Denver', 'news', 1),
    array('Colorado', 'sports', 1),
    array('Entertainment', 'entertainment', 1),
    array('Weather', 'weather', 1),
    array('Businesss', 'business', 1)
    //array('Broncos', 'sports', 1),
    //array('Local News', 'news', 1),
    //array('Business', 'news', 1);
    //array('Weather', 'news', 1);
);*/
$feedStoryHeading = $config['story_feed_heading'];
$storyFeeds = array_values($config['story_feed']);

// Sub topics
/*$sectionPromos = array(
    array('Silver City', 'news', 4),
    array('Silver City', 'sports', 4),
    array('Silver City', 'entertainment', 4),
    array('Silver City', 'news', 4)
);*/

$sectionPromos = array_values($config['section_promos']);


$mostPopular = $config['most_popular'];

if ($mostPopular) {
    // Need to find out if there is an Omniture API we can leverage
    // Hoping to avoid Jetpack

    // Run queries and assign here
    $context['most_popular'] = $mostPopular;
}

/* End config*/





/* Run queries and assign contexts to be used in templates */

// We should probably move tags into the createWPQueryArray()

// Breaking Alert
$context['breaking_alert'] = excludeFilter(Timber::get_posts('tag=breaking-news'));

// Apocalypse
$context['apoc'] = excludeFilter(Timber::get_posts('tag=apoc'));
if ($context['apoc']) {
    // Bring config from above down here for these sorts of stories
    
    // Apoc secondary lead story
    $apocSecondaryLeadStory = array_values($config['apoc_secondary_lead_story']);

    $context['apoc_secondary_lead_story'] = unboltQuery(Timber, 'get_posts', $apocSecondaryLeadStory, $context['exclude_posts']);
    
    // Apoc secondary stories
    $apocSecondaryStories = array_values($config['apoc_secondary_stories']);
    $context['apoc_secondary_story'] = array();
    foreach($apocSecondaryStories as $story) {
        $context['apoc_secondary_story'][] = unboltQuery(Timber, 'get_post', $story, $context['exclude_posts']);
    }
    
    // Apoc related
    $apocRelatedStories = array_values($config['apoc_related_stories']);
    $context['apoc_related_stories'] = unboltQuery(Timber, 'get_posts', $apocRelatedStories, $context['exclude_posts']);
    
    // Apoc story feed
    $apocStoryFeed = array_values($config['apoc_story_feed']);
    $context['apoc_story_feed'] = array();
    foreach ($apocStoryFeed as $story) {
        $context['apoc_story_feed'][] = unboltQuery(Timber, 'get_post', $story, $context['exclude_posts']);
    }

}
// Normal
else {
    // Lead story
    $context['lead_story'] = unboltQuery(Timber, 'get_posts', $leadStory, $context['exclude_posts']);
    // Secondary lead story
    $context['secondary_lead_story'] = unboltQuery(Timber, 'get_posts', $secondaryLeadStory, $context['exclude_posts']);
    // Related stories (only appear if second lead story does not exist)
    //$context['related_stories'] = Timber::get_posts(createWPQueryArray($relatedStories));
    $context['related_stories'] = unboltQuery(Timber, 'get_posts', $relatedStories, $context['exclude_posts']);
    $context['related_stories_heading'] = $relatedStories[0];
    // Secondary stories
    $context['secondary_stories'] = array();
    foreach($secondaryStories as $story) {
        //$context['secondary_stories'][] =  Timber::get_post(createWPQueryArray(array_values($story)));
        $context['secondary_stories'][] = unboltQuery(Timber, 'get_post', array_values($story), $context['exclude_posts']);
    }
    // Story feed small
    $context['story_feed_heading'] = $config['story_feed_heading'];
    $context['story_feed'] = array();
    foreach($storyFeeds as $story) {
        $context['story_feed'][] = unboltQuery(Timber, 'get_post', array_values($story), $context['exclude_posts']);
    }
}
// Section promos
$context['section_promos'] = array();
foreach($sectionPromos as $promo) {
    $context['section_promos'][] = unboltQuery(Timber, 'get_posts', array_values($promo), $context['exclude_posts']);
}

//Eventful
if ( function_exists('get_eventful') )
    $context['events'] = get_eventful();


// Bottom Line
$context['bottom_line1'] = Timber::get_posts('tag=bottom_line1');
$context['bottom_line2'] = Timber::get_posts('tag=bottom_line2');
$context['bottom_line3'] = Timber::get_posts('tag=bottom_line3');
/* End run queries */
?>
