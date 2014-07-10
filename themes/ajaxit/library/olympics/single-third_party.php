<?php 
die('single-third_party.php is not used!');
$posttags = get_the_tags();
$mytag = getmy_tag($posttags); //in functions php, returns the first tag name of a post
if (has_category('olympics')) {
	if ( $mytag != null){
		$mytag = 'Olympics-gallery';	
	}
	else {
		$mytag = 'Olympics-article';

	}

}
?>

<?php 
switch ($mytag) 
{
    case "Photo":
    echo "it's a photo";
        include(TEMPLATEPATH . '/singlephoto.php');
        break;
    case "Video":
    //echo "it's a video";
        include(TEMPLATEPATH . '/video.php');
        break;
    case "Olympics-gallery":
		echo "it's a Olympics-gallery";
		include(TEMPLATEPATH . '/subtheme/olympics/third_party/gallery.php');    
        break;
    case "Olympics-article":
		echo "it's a Olympics-article";
		include(TEMPLATEPATH . '/subtheme/olympics/third_party/article.php');
        break; 
    default:
        include(TEMPLATEPATH . '/singlephoto.php');
