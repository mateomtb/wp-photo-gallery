<?php
 	$theme_options = get_option('T_theme_options');
?>

<!-- Navigation -->
<?php
	//pull categories from Media Center Apperance settings
	$category_section = get_option('T_category_section');
	if($category_section || (!$theme_options && !$category_section)) { include (THEMELIB . '/apps/five-top.php'); }
?>