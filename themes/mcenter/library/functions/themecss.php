<?php include('css-header.php');

$slideshow_height = get_option('T_slideshow_height');
if(!$slideshow_height) { $slideshow_height = "425"; } ?>

ul#portfolio {height:<?php echo $slideshow_height; ?>px;}
