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

// Main
$context = Timber::get_context();
//$context['globalcontext'] = global_context($context['globalcontext']);
//$context['dfm'] = DFMDataForWP::retrieveRowFromMasterData('domain', $context['domain']);

//Dev only get context
$devurl = parse_url("http://" . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']);
$pathbits = explode('/', $devurl['path']);
$context['dfm'] = DFMDataForWP::retrieveRowFromMasterData('domain', $pathbits[1]);
$context['post'] = Timber::get_post();

// Old MC posts don't have a gallery_type custom field
// This is probably a better way of doing things, anyway
if (!$galleryType) {
    if (strpos($context['post']->post_content, 'insertLongForm') !== false) {
        $galleryType = 'scrollable';
    }
    else {
        $galleryType = 'traditional';
    }
}

$context['type'] = $galleryType;
//These contexts are found in sidebar.php
$context['sidebar'] = $sidebarContext;
$context['related'] = $relatedContext;
$context['ad'] = $adContext;

/* End contexts */

Timber::render('leaf.twig', $context);

get_footer();

?>
