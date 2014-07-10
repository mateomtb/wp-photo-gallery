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
if (is_category()) { 
	$context['archivetype'] = $context['category'][0]->name;
}
elseif( is_tag() ) { 
	$context['archivetype'] = "Posts Tagged &#8216;" . single_tag_title("", false) . "&#8217";
} 
elseif (is_day()) {
	$context['archivetype'] = "Archive for " . the_time('F jS, Y');
} 
elseif (is_month()) { 
	$context['archivetype'] = "Archive for " . the_time('F, Y');
} 
elseif (is_year()) { 
	$context['archivetype'] = "Archive for " . the_time('Y');
} 
elseif (is_author()) { 
	$context['archivetype'] = "Author Archive";
} 
elseif (isset($_GET['paged']) && !empty($_GET['paged'])) { 
	$context['archivetype'] = "Blog Archives";
} 

//These contexts are found in sidebar.php
$context['sidebar'] = $sidebarContext;
$context['related'] = $relatedContext;
$context['ad'] = $adContext;

/* End contexts */
Timber::render('archive.twig', $context);
?>

<?php get_footer(); ?>









