<?php
/**
 * @package WordPress
 * @subpackage DFM-Media-Center
 * @since DFM-Media-Center 0.1
 */
get_header(); ?>

<?php

const MAX_POSTS = 7;

$data = Timber::get_context();
$data['posts'] = Timber::get_posts();

if ( function_exists('build_thumbs') ):
    foreach ( $data['posts'] as $post ):
        build_thumbs($post->ID);
    endforeach;
endif;

Timber::render('index.twig', $data);


?>

<?php get_footer(); ?>
