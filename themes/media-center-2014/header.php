<?php
/**
 * @package WordPress
 * @subpackage DFM-Media-Center
 * @since DFM-Media-Center 0.1
 */
?>
<?php 
include 'inc/config.php';
if ( !class_exists('Timber') ) die('Please activate the Timber plugin in <a href="/wp-admin/plugins.php">your wp-admin/plugins.php');
$context = Timber::get_context();
$context['globalcontext'] = global_context($context['globalcontext']);
$context['posts'] = Timber::get_posts();
//print_r($context);

/* End contexts */
Timber::render('header.twig', $context);
?>
