<?php /**
 * @package WordPress
 * @subpackage ThemeName
 * @since ThemeName 1.0
 * Template Name: Rotator
 */
header('Content-Type: application/javascript');
?>

<?php 
/* Creates a feed of data for the Media Center rotators on news.com
  Author: Josh Kozlowski
 * Last Modified 2/13/2013
*/

if ($_REQUEST['size'] === 'responsive'){
	include get_template_directory() . '/new_rotator_feed.php';
}
else {
	include get_template_directory() . '/old_rotator_feed.php';
}

?>
