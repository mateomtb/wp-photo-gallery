<?php
/* Configure Home Page Queries and Assign to Templating Contexts */


/* Set categories and other config for all content on home page */


// All of the configuration can come from a JSON file for each site
$config = getContentConfigFeed($context['domain'], $context['section']);


    /* Array is structured like this
    array(
        string heading,
        string category-slug,
        int number-of-posts,
        string custom-field,
        string custom-field-value,
        string tag
    );  
    */
    
// Right now heading is sort of useless since we're using the category slug to get the category name
// where a heading is neeeded. But it's probably good to anticipate custom requests and to have another 
// bit of meta data?

// Arrays based on custom values or tags need to be queried first unless we include a priority system
// Otherwise, the exclusion array could include posts that were already queried into a more generic array
// See comment in $priorityQueries array below

// Assign arrays structured as above created from JSON file

// Lead Stories
$lead_array = array();
$secondary_lead_story_array = array();

$all_posts = get_posts(array(
    'post_status' => 'publish',
    'posts_per_page' => -1,
    'fields' => 'ids',
    'orderby' => 'modified'
    )
);



if( isset( $all_posts ) && !empty( $all_posts ) ){
    $lead_in_array = 'lead array!';
    foreach( $all_posts as $p ){    
        $article_curation = get_post_meta( $p , "article_curation" , true );
        if( is_string( $article_curation ) === false && $article_curation['lead_story'] !== false ) {
            array_push( $lead_array , $p );
            array_push( $lead_array , $lead_in_array );
        }
        elseif( is_string( $article_curation ) === false && $article_curation['secondary_lead_story'] !== false ) {
            array_push( $secondary_lead_story_array, $p );
        }
    }
}

// Gets the lead story with the arg of all the posts set to lead_story.
function get_respective_post( $id ){
    if( isset( $id ) && !empty( $id ) ){
        if( in_array( 'lead array!' , $id) ){
            foreach ( $id as $ids ) {          
                $meta_values = get_post_meta( $ids );
                $leadStory = Timber::get_post( intval( $ids ) );
                return $leadStory;
                }
            }
        if( ! in_array( 'lead array!' , $id) ){
            foreach ( $id as $ids ) {
                $meta_values = get_post_meta( $ids );
                $nonLeadStory = Timber::get_post( intval( $ids ) );
                return $nonLeadStory;
            }
            
        }
    }

    else {
        // Lead_story checkbox not checked on any post, grabs most recent.
        $args = array( 'numberposts' => '1' );
        $most_recent_article = Timber::get_post( $args );
        return $most_recent_article;
    }
}

//echo '<pre>'; var_dump( $leadStory_posts ); echo '</pre>';
//var_dump($leadStory_posts);
//var_dump($leadStory);
$secondaryLeadStory = array_values($config['secondary_lead_story']);
$relatedStories = array_values($config['related_stories']);
$secondaryStories = array_values($config['secondary_stories']);


// Story feed
$feedStoryHeading = $config['story_feed_heading'];
$storyFeeds = array_values($config['story_feed']);

// Breaking and apocalypse
$breakingNews = array_values($config['breaking_news']);
$apocalypse = array_values($config['apocalypse']);

// Section promos and most popular
$sectionPromos = array_values($config['section_promos']);
$mostPopular = $config['most_popular'];

if ( isset( $mostPopular )) {
    // Need to find out if there is an Omniture API we can leverage
    // Hoping to avoid Jetpack

    // Run queries and assign here
    $context['most_popular'] = $mostPopular;
}

$priorityQueries = array(
    // We could choose different arrays here that do not include the exclude posts
    // array during their querying if order down below is insufficient
    // for prioritization
    // Or simply pass an empty array for the $excludeArray
);

/* End config*/

/* Run queries and assign contexts to be used in Twig templates */

// Breaking Alert
$context['breaking_news'] = unboltQuery('get_posts', $breakingNews, $context['exclude_posts']);

// Apocalypse
$context['apocalypse'] = unboltQuery('get_posts', $apocalypse, $context['exclude_posts']);

if ($context['apocalypse']) {
    // Bring config from above down here for these sorts of stories
    // Lead Story
    //$context['lead_story'] = call_user_func_array("get_respective_post", array( $lead_array ));

    // Apoc secondary lead story
    $apocSecondaryLeadStory = array_values($config['apoc_secondary_lead_story']);

    $context['apoc_secondary_lead_story'] = unboltQuery('get_posts', $apocSecondaryLeadStory, $context['exclude_posts']);
    
    // Apoc secondary stories
    $apocSecondaryStories = array_values($config['apoc_secondary_stories']);
    $context['apoc_secondary_story'] = array();
    foreach($apocSecondaryStories as $story) {
        $context['apoc_secondary_story'][] = unboltQuery('get_post', $story, $context['exclude_posts']);
    }
    
    // Apoc related
    $apocRelatedStories = array_values($config['apoc_related_stories']);
    $context['apoc_related_stories'] = unboltQuery('get_posts', $apocRelatedStories, $context['exclude_posts']);
    
    // Apoc story feed
    $apocStoryFeed = array_values($config['apoc_story_feed']);
    $context['apoc_story_feed'] = array();
    foreach ($apocStoryFeed as $story) {
        $context['apoc_story_feed'][] = unboltQuery('get_post', $story, $context['exclude_posts']);
    }

}
// Normal
else {
    // Lead story
    $context['lead_story'] = call_user_func_array("get_respective_post", array( $lead_array ));
    //$context['lead_story'] = get_respective_post( $lead_array );
    // Secondary lead story
    //$context['secondary_lead_story'] = unboltQuery('get_posts', $secondaryLeadStory, $context['exclude_posts']);
    $context['secondary_lead_story'] = call_user_func_array("get_respective_post", array( $secondary_lead_story_array ));
    //echo '<pre>'; var_dump($context['secondary_lead_story']); echo '</pre>';
    // Secondary stories
    $context['secondary_stories'] = array();
    foreach($secondaryStories as $story) {
        //$context['secondary_stories'][] =  Timber::get_post(createWPQueryArray(array_values($story)));
        $context['secondary_stories'][] = unboltQuery('get_post', array_values($story), $context['exclude_posts']);
    }
    // Story feed small
    $context['story_feed_heading'] = $config['story_feed_heading'];
    $context['story_feed'] = array();
    foreach($storyFeeds as $story) {
        $context['story_feed'][] = unboltQuery('get_post', array_values($story), $context['exclude_posts']);
    }
    // Related stories (only appear if second lead story does not exist)
    $context['related_stories'] = Timber::get_posts(createWPQueryArray($relatedStories));
    $context['related_stories'] = unboltQuery('get_posts', $relatedStories, $context['exclude_posts']);
    $context['related_stories_heading'] = $relatedStories[0];
}
// Section promos
$context['section_promos'] = array();
foreach($sectionPromos as $promo) {
    $context['section_promos'][] = unboltQuery('get_posts', array_values($promo), $context['exclude_posts']);
}

//Eventful
if ( function_exists('get_eventful') ):
    $context['events'] = get_eventful($context);
endif;

// Bottom Line
// You can still run queries that do not exclude anything if needed
$context['bottom_line1'] = Timber::get_posts('tag=bottom_line1');
$context['bottom_line2'] = Timber::get_posts('tag=bottom_line2');
$context['bottom_line3'] = Timber::get_posts('tag=bottom_line3');
/* End run queries */
?>
