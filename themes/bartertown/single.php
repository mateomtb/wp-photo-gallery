<?php
/**
 * The Template for displaying all single posts
 *
 * Methods for TimberHelper can be found in the /functions sub-directory
 *
 * @package  WordPress
 * @subpackage  Timber
 * @since    Timber 0.1
 */

$context = Timber::get_context();
$post = new TimberPost();
$context['post'] = $post;
$context['wp_title'] .= ' - ' . $post->title();


// This subhead-specific plugin doesn't yet work.
if ( function_exists('the_subheading') )
    $context['subhead'] = get_the_subheading();


// The 'Others also read...' posts
if ( function_exists('related_posts') )
    $context['also_read'] = related_posts(); 
elseif ( function_exists('wp_related_posts') ) 
    $context['also_read'] = wp_related_posts();


// Disqus comments
if ( function_exists('dsq_comments_template') ):
    $comments_file = TimberHelper::function_wrapper('dsq_comments_template', array('You must have the DISQUS plugin enabled.'));
    $context['comment_form'] = TimberHelper::function_wrapper('comments_template', array($comments_file));
endif;

// In-Article teaser content
if ( class_exists('DFMInArticleTeaser') ):
    $teaser = new DFMInArticleTeaser($post);
    $teaser_exists = $teaser->load_teaser();
    if ( $teaser_exists != NULL ):
        $context['teaser'] = $teaser_exists;
        $context['teaser_feeds'] = $teaser->get_feed_items();
    endif;
endif;

// Article-sidebar (as opposed to layout-sidebar) content
if ( class_exists('DFMCollection') ):
    // First we look for any Package collections that exist.
    $package = new DFMCollection($post);
    $package_name = $package->get_collection();
    if ( $package_name != NULL ):
        $context['package_name'] = $package_name[0];
        $context['package'] = $package->get_collection_items();
    endif;

    // Next we look for any Related collections.
    $collection = new DFMCollection($post, 'related');
    $collection_name = $collection->get_collection();
    if ( $collection_name != NULL ):
        $context['collection_name'] = $collection_name[0];
        $context['collection'] = $collection->get_collection_items();
    endif;
endif;


//if ( function_exists('rh_the_revision') ):
//    $context['revisions'] = TimberHelper::function_wrapper('rh_the_revision', array('<h4>', '</h4>'));
//endif;


// Layout-sidebar content
$context['sidebar'] = Timber::get_sidebar('sidebar.php');



Timber::render(array('single-' . $post->ID . '.twig', 'single-' . $post->post_type . '.twig', 'single.twig'), $context);
