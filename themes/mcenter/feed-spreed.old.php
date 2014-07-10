<?php
/**
 * RSS2 Feed Template for displaying RSS2 Posts feed.
 *
 * @package WordPress
 */
?>
<?php
$device_id = ($_GET["deviceid"]);
$numberofposts = ($_GET["numberofposts"]);

// The Query
$the_query = new WP_Query( 'posts_per_page=' . $numberofposts );
//query_posts('posts_per_page=' . $numberofposts);
var_dump($the_query);

// The Loop
//while ( $the_query->have_posts() ) : $the_query->the_post();
	//echo '<li>';
	//the_title();
	//echo '</li>';
//endwhile;

// Reset Post Data
//wp_reset_postdata();
?>
<?php
//header('Content-Type: ' . feed_content_type('rss-http') . '; charset=' . get_option('blog_charset'), true);
//$more = 1;
?>
<channel>
	
	<?php while ($the_query->have_posts()) : $the_query->
	the_post(); ?>
	<item>
		<title><?php the_title_rss() ?></title>
	</item>
	<?php endwhile; ?>
</channel>