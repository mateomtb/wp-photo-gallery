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
if ( function_exists('build_thumbs') ):
    build_thumbs($post->ID);
endif;


/* Config */
$galleryType = get_post_meta($post->ID, 'gallery-type', true);
/* End config */

/* Contexts*/

// Main
$context = Timber::get_context();
$context['globalcontext'] = global_context($context['globalcontext']);
//$context['dfm'] = DFMDataForWP::retrieveRowFromMasterData('domain', $context['domain']);

//Dev only get context
$devurl = parse_url("http://" . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']);
$pathbits = explode('/', $devurl['path']);
$context['dfm'] = DFMDataForWP::retrieveRowFromMasterData('domain', $pathbits[1]);
$context['post'] = Timber::get_post();
$context['editlink'] = edit_post_link();

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


$escapedfragment = $_GET['_escaped_fragment_'];
if ($escapedfragment){
		$photoID = explode('/', $escapedfragment);	
		$photoID = explode('=', $escapedfragment);	
		$fileNamePart = $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
		$fileNameFilter = '/[^0-9a-z]/i';				
		$fileNamePart = preg_replace($fileNameFilter, '', $fileNamePart);
		$fileNamePart = str_replace('escapedfragment' , '', $fileNamePart);		
		$fileNamePart = str_replace('photonum' . $photoID[1] , '', $fileNamePart);		
		$photoID = $photoID[1] - 1;		
		$JSONfilename = plugins_url('dfm-wp-photogallery/js/json/' . $fileNamePart . '.json');
		$JSONfile = file_get_contents($JSONfilename);
		$JSONobject = json_decode($JSONfile);
		$context['snapshot_item'] = $JSONobject->ImageElementCollection->ImageElement[$photoID];				
		$context['totalphotos'] = count($JSONobject->ImageElementCollection->ImageElement);				
  		Timber::render('snapshot.twig', $context);
}


else{
		$fileNamePart = $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
		$fileNameFilter = '/[^0-9a-z]/i';				
		$fileNamePart = preg_replace($fileNameFilter, '', $fileNamePart);
		$fileNamePart = str_replace('escapedfragment' , '', $fileNamePart);		
		$fileNamePart = str_replace('photonum' . $photoID[1] , '', $fileNamePart);		
		$JSONfilename = plugins_url('dfm-wp-photogallery/js/json/' . $fileNamePart . '.json');
		$JSONfile = file_get_contents($JSONfilename);
		$JSONobject = json_decode($JSONfile);
		$context['galleryJSON'] = $JSONobject->ImageElementCollection;		
		$context['totalphotos'] = count($JSONobject->ImageElementCollection->ImageElement);	
	Timber::render('single.twig', $context);
}
get_footer();

?>
