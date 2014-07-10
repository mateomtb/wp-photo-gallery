<?php
/**
 * @package WordPress
 * @subpackage DFM-Media-Center
 * @since DFM-Media-Center 0.1
 */
?>
<?php 

get_header();

include get_template_directory() . '/sidebar.php';

/* Config */
$actual_link = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
$archivequery = parse_url($actual_link, PHP_URL_QUERY) . "&posts_per_page=5";
/* End config */

/* Contexts */

// Main
$context = Timber::get_context();
$context['posts'] = Timber::get_posts($archivequery);
$context['category'] = get_the_category();
$context['searchtitle'] = 'Search results for '. get_search_query();

//These contexts are found in sidebar.php
$context['sidebar'] = $sidebarContext;
$context['related'] = $relatedContext;
$context['ad'] = $adContext;

/* End contexts */
Timber::render('search.twig', $context);
?>

<?php get_footer(); ?>









