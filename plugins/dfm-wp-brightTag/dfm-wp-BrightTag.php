<?php
/**
	 * Plugin Name: BrightTag
	 * Description: Allows the Bright Tags to run on page.
	 * Version: 1.0
	 * Author: Eric McAllister
**/
$iframeTag = "//s.thebrighttag.com/iframe?c=sfWGaRL";
?>
<noscript>
	<iframe src="<?php echo $iframeTag; ?>" width="1" height="1" frameborder="0" scrolling="no" marginheight="0" marginwidth="0"></iframe>
</noscript>
<?php 
function dfm_wp_brightTag(){
	wp_enqueue_script('dfm-wp-brightTag', 
    '/wp-content/plugins/dfm-wp-brightTag/scripts/dfm-wp-brightTag.js',
    'version 1.0',	
    true);
};
add_action( 'wp_footer', 'dfm_wp_brightTag' );
?>