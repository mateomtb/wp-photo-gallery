<?php
/**
 * @package WordPress
 * @subpackage DFM-Media-Center
 * @since DFM-Media-Center 0.1
 */
?>

<?php 
$context = Timber::get_context();
$dir = get_template_directory();
//begin powerlinks code
    global $post;
    $allcats = get_the_category($post->ID);
    //$powerlinkcat = parent_of_cat($allcats); // Need to add this function
    $powerid = '';
    switch ($powerlinkcat) {
            case "news":
                $powerid = "567";
                break;
            case "sports":
                $powerid = "569";
                break;
            case "entertainment":
                $powerid = "566";
                break;
            case "lifestyles":
                $powerid = "568";
                break;
            default:
                $powerid = "568";    
    }

if ( is_singular() ) {
	if ($_SESSION['siteconfig']['powerlinks'] != "n/a")
		$context['powerlinks'] = '<script type="text/javascript" src="http://ord1.powerlinks.com/affiliate/script/power-link/add-power-links?id=' . $powerid . '"></script>';
}
//end powerlinks
else {$context['powerlinks'] = "";}
$context['settingsmenu'] = file_get_contents($dir . '/inc/settings-menu.php');
$context['filters'] = file_get_contents($dir . '/inc/filters.php');

//$context['signin'] = file_get_contents($dir . '/inc/signin.php');
$context['signin'] = "";
$context['themefolder'] = get_bloginfo('template_url');


Timber::render('footer.twig', $context); ?>
