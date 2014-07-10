<?php include('css-header.php'); 
  //Load Variables
  $header_logo_path = get_option('T_header_logo_path');
  list($width, $height, $type, $attr) = getimagesize($header_logo_path);
?>
<?php
$header_logo = get_option('T_header_logo');
$header_desc = get_option('T_header_desc');
if($header_logo && $header_logo_path) { ?>

#top {height:<?php echo $height; ?>px;}
* html #masthead h4{ padding:0;}
#masthead h4{ background: url(<?php echo $header_logo_path; ?>) no-repeat; float:left;padding:5px 0; margin:0;text-indent:-9999px;display:block;width:<?php echo $width; ?>px;height:<?php echo $height; ?>px;}
#masthead h4 a {  text-indent:-9999px;display:block;width: <?php echo $width; ?>px; height: <?php echo $height; ?>px;}
#masthead span.description {position:relative; top: <?php echo ceil($height/3); ?>px;padding:5px 30px}
#nav {margin-top:<?php echo ceil($height/3); ?>px;}

<?php if(!$header_desc) { ?>
#masthead span.description {display:none;}
<?php } ?>
<?php } ?>


<?php if($themename=="Modslider") { 
if ($header_logo || (!$theme_options && !$header_logo)) {	
if((!$theme_options && !$header_logo)) {
	$header_logo_path=get_bloginfo('stylesheet_directory')."/images/logo.png";
	list($width, $height, $type, $attr) = getimagesize($header_logo_path);
}?>

#masthead h4{ float:left;padding:0; margin:0;text-indent:-9999px;display:block;width: <?php echo $width; ?>px; height: <?php echo $height; ?>px;}
#masthead h4 a { background: url(<?php echo $header_logo_path; ?>) no-repeat; text-indent:-9999px;display:block;width: <?php echo $width; ?>px; height: <?php echo $height; ?>px;}
#masthead span.description {position:absolute; top: <?php echo ceil($height/3); ?>px;padding:5px 30px}


/* Modslider horizontal sprite logo */
#masthead h4, #masthead h4 a  {width: <?php echo $width/2; ?>px;}
#masthead h4 a:hover {background-position:-<?php echo $width/2; ?>px 0}
#masthead span.description {top:<?php echo ceil($height/1.7); ?>px; padding-left:0}

<?php } ?>
<?php } ?>