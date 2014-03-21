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


Timber::render(array('single.xml.twig'), $context);
