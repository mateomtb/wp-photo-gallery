<?php 
if ($_REQUEST['embedded_gallery']) :
  header('Content-Type: application/javascript');
  include(TEMPLATEPATH . '/embed_gallery.php');
else:
$posttags = get_the_tags();
$mytag = getmy_tag($posttags); //in functions php, returns the first tag name of a post

?>

<?php 
switch ($mytag) 
{
    case "photo":
    //echo "it's a photo";
        include(TEMPLATEPATH . '/singlephoto.php');
        break;
    case "Photo":
    //echo "it's a photo";
        include(TEMPLATEPATH . '/singlephoto.php');
        break;    
    case "video":
    //echo "it's a video";
        include(TEMPLATEPATH . '/video.php');
        break;
    case "Video":
    //echo "it's a video";
        include(TEMPLATEPATH . '/video.php');
        break;
    case "special_project":
    //echo "it's a video";
        include(TEMPLATEPATH . '/project.php');
        break;
    default:
        include(TEMPLATEPATH . '/singlephoto.php');

}
endif; // End logic for embed gallery vs. everything else. did it this way so we could change http header and also to use include.
