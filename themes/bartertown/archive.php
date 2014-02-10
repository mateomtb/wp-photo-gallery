<?php
/**
 * The template for displaying Archive pages.
 *
 * Used to display archive-type pages if nothing more specific matches a query.
 * For example, puts together date-based pages if no date.php file exists.
 *
 * Learn more: http://codex.wordpress.org/Template_Hierarchy
 *
 * Methods for TimberHelper can be found in the /functions sub-directory
 *
 * @package 	WordPress
 * @subpackage 	Timber
 * @since 		Timber 0.2
 */

		$templates = array('archive.twig', 'index.twig');

		$context = Timber::get_context();

		$context['title'] = 'Archive';
		if (is_day()){
			$context['title'] = 'Archive: '.get_the_date( 'D M Y' );
		} else if (is_month()){
			$context['title'] = 'Archive: '.get_the_date( 'M Y' );
		} else if (is_year()){
			$context['title'] = 'Archive: '.get_the_date( 'Y' );
		} else if (is_tag()){
			$context['title'] = single_tag_title('', false);
		} else if (is_category()){
			$context['title'] = single_cat_title('', false);
			array_unshift($templates, 'archive-'.get_query_var('cat').'.twig');
		} else if (is_post_type_archive()){
			$context['title'] = post_type_archive_title('', false);
			array_unshift($templates, 'archive-'.get_post_type().'.twig');
		}

		$context['posts'] = Timber::get_posts();
		include get_template_directory() . '/homepage.php';
		
/*
$secondaryCats = array ('football','basketball','soccer');
foreach ($secondaryCats as $secondaryCat){
	$secondaryQuery = "category_name=" . $secondaryCat . "&posts_per_page=1";
	$context['secondary'][$secondaryCat] = Timber::get_posts($secondaryQuery);
}
$columnists = array ('walters','powers','sansevere');
foreach ($columnists as $columnist){
	$columnistQuery = "category_name=" . $columnist . "&posts_per_page=1";
	$context['columnists'][$columnist] = Timber::get_posts($columnistQuery);
}

$othernews = array ('local-news','business','entertainment','opinion','lifestyle','weather','world');
foreach ($othernews as $other){
	$otherQuery = "category_name=" . $other . "&posts_per_page=1";
	$context['othernews'][$other] = Timber::get_posts($otherQuery);
} */


		Timber::render($templates, $context);
