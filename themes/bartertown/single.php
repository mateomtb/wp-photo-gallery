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

if ( function_exists('the_subheading') )
    $context['subhead'] = the_subheading();

// Disqus comments
if ( function_exists('dsq_comments_template') ):
    $comments_file = TimberHelper::function_wrapper('dsq_comments_template', array('You must have the DISQUS plugin enabled.'));
    $context['comment_form'] = TimberHelper::function_wrapper('comments_template', array($comments_file));
endif;

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

$context['sidebar'] = Timber::get_sidebar('sidebar.php');
Timber::render(array('single-' . $post->ID . '.twig', 'single-' . $post->post_type . '.twig', 'single.twig'), $context);
