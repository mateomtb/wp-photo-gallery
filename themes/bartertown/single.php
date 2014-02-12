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

if ( function_exists('dfm_get_package') ):
    $context['package'] = TimberHelper::function_wrapper('dfm_get_package');
endif;

$context['sidebar'] = Timber::get_sidebar('sidebar.php');
Timber::render(array('single-' . $post->ID . '.twig', 'single-' . $post->post_type . '.twig', 'single.twig'), $context);
