<?php
/** Configure Section Page Queries and Assign to Templating Contexts**/


/* Set categories and other config for all content on home page */

// See homepage.php for explanation

$config = getContentConfigFeed($context['domain'], $context['section']);

// Lead Stories
$leadStory = array_values($config['lead_story']);
$secondaryLeadStory = array_values($config['secondary_lead_story']);
$relatedStories = array_values($config['related_stories']);
$secondaryStories = array_values($config['secondary_stories']);

// Feed stories (In Other News)
$feedStoryHeading = $config['story_feed_heading'];
$storyFeeds = array_values($config['story_feed']);

// Breaking
$breakingNews = array_values($config['breaking_news']);

// Columnists
$columnists = $config['columnists'];
/* End config*/

/* Run queries and assign contexts to be used in templates */

// Breaking Alert
$context['breaking_news'] = unboltQuery('get_posts', $breakingNews, $context['exclude_posts']);
// Lead story
$context['lead_story'] = unboltQuery('get_posts', $leadStory, $context['exclude_posts']);
// Secondary lead story
$context['secondary_lead_story'] = unboltQuery('get_posts', $secondaryLeadStory, $context['exclude_posts']);
// Related stories (only appear if second lead story does not exist)
$context['related_stories'] = unboltQuery('get_posts', $relatedStories, $context['exclude_posts']);
$context['related_stories_heading'] = $relatedStories[0];
// Secondary stories
$context['secondary_stories'] = array();
foreach($secondaryStories as $story) {
    $context['secondary_stories'][] = unboltQuery('get_post', $story, $context['exclude_posts']);
}
// Story feed small
$context['story_feed'] = array();
foreach($storyFeeds as $story) {
    $context['story_feed'][] = unboltQuery('get_post', $story, $context['exclude_posts']);
}
// Section promos
if ( is_array($columnists) ):
    $context['columnists'] = array();
    foreach($columnists as $columnist) {
        $context['columnists'][] = unboltQuery('get_posts', $columnist, $context['exclude_posts']);
    }
endif;
/* End run queries */
?>
