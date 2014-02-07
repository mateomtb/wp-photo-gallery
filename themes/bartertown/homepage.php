<?php
/** Configure Home Page Queries and Assign to Templating Contexts**/


/* Set categories and other config for all content on home page */
// array('heading', 'category-slug', number-of-posts, custom-field, custom-field-value);

// Lead Stories
$leadStory = array(null, null, 1, 'lead_story', 'yes');
$secondaryLeadStory = array(null, null, 1, 'secondary_lead_story', 'yes');
$relatedStories = array('Related Stories', 'news', 4);

$secondaryStories1 = array('News', 'news', 1, 'secondary_story', 'yes');
$secondaryStories2 = array('Sports', 'sports', 1, 'secondary_story', 'yes');
$secondaryStories3 = array('Entertainment', 'entertainment', 1, 'secondary_story', 'yes');


// Other News
$otherNewsHeading = 'In Other News';

$otherNews1 = array('Denver', 'news', 1);
$otherNews2 = array('Colorado', 'news', 1);
$otherNews3 = array('Business', 'news', 1);
$otherNews4 = array('Weather', 'news', 1);
$otherNews5 = array('Nation/World', 'news', 1);
$otherNews6 = array('Broncos', 'sports', 1);
$otherNews7 = array('Local News', 'news', 1);
$otherNews8 = array('Business', 'news', 1);
$otherNews9 = array('Weather', 'news', 1);


// Blogs
$blogs1;
$blogs2;
$blogs3;

// Sub topics
$subTopic1;
$subTopic2;
$subTopic3;
$subTopic4;

/* End config*/


/* Run queries and assign contexts to be used in templates */

// Lead story
$context['lead_story'] = Timber::get_post(createWPQueryArray($leadStory));
// Secondary lead story
$context['secondary_lead_story'] = Timber::get_post(createWPQueryArray($secondaryLeadStory));
// Related stories (only appear if second lead story does not exist)
$context['related_stories'] = Timber::get_posts(createWPQueryArray($relatedStories));
$context['related_stories_heading'] = $relatedStories[0];
// First secondary story
$context['secondary_story_1'] = Timber::get_post(createWPQueryArray($secondaryStories1));
$context['secondary_story_1_heading'] = $secondaryStories1[0];
// Second secondary story
$context['secondary_story_2'] = Timber::get_post(createWPQueryArray($secondaryStories2));
$context['secondary_story_2_heading']= $secondaryStories2[1];
// Third secondary story
$context['secondary_story_3'] = Timber::get_post(createWPQueryArray($secondaryStories3));
$context['secondary_story_3_heading'] = $secondaryStories3[1];



/* End run queries */
?>