<?php get_header(); 
$theme_options = get_option('T_theme_options'); ?>
<div class="span-<?php $sidebar = get_option('T_sidebar'); if($sidebar || (!$theme_options && !$sidebar)) { echo "15 colborder home"; } else { echo "24 last"; } ?>">
<div class="content">
		<h2>Whoops!  Whatever you are looking for cannot be found.</h2>
	</div>
	</div>
<?php $sidebar = get_option('T_sidebar'); if($sidebar || (!$theme_options && !$sidebar)) { get_sidebar(); } ?>
<!-- Begin Footer -->
<?php get_footer(); ?>