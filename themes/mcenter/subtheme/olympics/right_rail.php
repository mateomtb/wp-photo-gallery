<?php
// This is some code to add a query string to the home page link since there is logic that creates the categories listings if the query string is present
$olympics_home = get_category_link(get_category_by_slug('olympics'));
if (strpos($olympics_home, '?') !== FALSE) {//Have to do this for users that have dev environments that use query strings for permlinks
	$categories_link = $olympics_home . '&olympics_categories';
}
else {
	$categories_link = $olympics_home . '?olympics_categories';
}
?>
<div class="span-8 last">

   	<div class="view-all-gallery-categories">
      	<a href="<?php echo $categories_link; ?>"><img src="<?php bloginfo('template_directory'); ?>/images/view-all-olympics-categories.png" /></a>
        <a href="<?php echo ((strpos($categories_link,'?') === false) ? $categories_link . '?tag=photo' : $categories_link . '&tag=photo' ); ?>" style="margin-top:10px;"><img src="<?php bloginfo('template_directory'); ?>/images/ViewAllOlympicsPhotos.png" /></a>
      </div>
      
		<?php //load top right 250x300
		switch ($_SESSION['parent_company']){
			case("jrc"):?>
				<div class="adElement" id="adPosition9"><script type="text/javascript" language="JavaScript">yld_mgr.place_ad_here("lrec_atf_slot");</script></div>
				<?php break;
			case("mngi"):?>
				<div class="adElement" id="adPosition9"><script type="text/javascript" language="JavaScript">yld_mgr.place_ad_here("adPos9");</script></div>
				<?php break;
	}
	?>

<style type="text/css">
.widget_hed { margin:30px 0 5px 0!important; } 
.athlete-profiles a img 
{ 
float:left;
margin-right:10px; 
}
.sbnation .simplepie h4 img { width:16px; height:16px; }
</style>

		<h3 class="widget_hed">Athlete Profiles</h3>
		<div class="athlete-profiles br-profiles">
<?php
if ( function_exists('SimplePieWP') )
	echo SimplePieWP('http://bleacherreport.com/partner_feeds/olympic-athlete-profile?use-hook=true&thumbs=true&items=10', 
                        array(
                                'items' => 5,
                                'template' => 'bleacher_report_profiles'
                        ));

?>
		</div>


<!-- SBNATION links only appear on homepage and non-syn articles -->
<?php

if (function_exists('SimplePieWP')){?>

	<div class="athlete-profiles sbnation sbrightrail">
		<div id="sbnation-branding" style="width:100%;height:35px;"><a href="http://www.sbnation.com" target="_blank"><img src="<?php echo bloginfo('template_directory') . '/images/sbn-footer-logo.png';  ?>" alt="SBNation.com" /></a></div>
		<?php echo SimplePieWP('http://feeds.feedburner.com/rss/current/london-olympics-2012', $rsswidg_default_settings); ?>
	</div>
<?php }?>




<!-- BB widget -->
<div class="mod_box" style="padding: 4px!important;">
<script src="http://widget.breakingburner.com/loader/widget/nhregister/2012-olympics"></script><iframe width="300" height="600" id="breakingburner-iframe" frameborder="no" scrolling="no"></iframe>    
</div>
<!-- BB widget -->

<?php include (THEMELIB . '/functions/previousplogs.php'); ?>
	
<?php echo "</div>" ?>

	
