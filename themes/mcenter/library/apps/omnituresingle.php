<?php 
//basedomain for jrc omniture
$basedomain = trim($_SESSION['siteconfig']['url'], 'www..../');
if ($basedomain === 'gametimect.com') {
	$omniUrl = 'http://local.gametimect.com/assets/s_code.js';
} 
else {
	$omniUrl = "http://local.$basedomain/assets/s_code.js";
}

//site name for jrc omniture
$sitename = get_bloginfo('name');
//break name on Media Center to get the property name
$sitename_bits = explode(' Media', $sitename);
$company_select =  strtolower($_SESSION['siteconfig']["company"]);

// falsey on non-mobile
global $mobile_current_template;

// Vars used in JS below
$thepagetag = omniTag();
$parentcat = omniCat();
$thepagetitle = omniTitle();
$mobile = ($mobile_current_template) ? "Mobile - " : '';
?>

<?php
// Start switch

switch ($company_select){
	// Mixes PHP and JS. Should be revisited in new Media Center theme
	// JRC
	case("jrc"):?>
		<div id="omniture" style="display:none;">
			<!-- SiteCatalyst code version: H.17.
		
			Copyright 1997-2005 Omniture, Inc. More info available at
		
			http://www.omniture.com -->
			<script type="text/javascript">
				var tag = '<?php echo $thepagetag; ?>';
				var category = '<?php echo $parentcat; ?>';
				var title = '<?php echo $thepagetitle; ?>';
				var s_account= '<?php echo get_option('T_tracking_code');?>';
			</script>
		
			<script type="text/javascript" src="<?php echo $omniUrl;?>"></script>
		
			<script type="text/javascript"><!--
				// You may give each page an identifying name, server, and channel on
				// the next lines.
				function omniTrack(params, total){
					if (params && total) {
						var imgnumber = 'image_number_' + params + '_of_' + total;
					}
					s.pageName="<?php echo $sitename;?>";
					s.server="<?php echo $_SERVER['HTTP_HOST'];?>";
					s.channel="media center <?php echo $mobile;?>";
					s.pageType="";
					s.prop1= category;
					s.prop2="Media Center <?php echo $mobile;?>| " + tag + " | " + category + " | " + title;
					s.prop3="";
					s.prop4="";
					// Gallery prop
					(imgnumber) ? s.prop5="Media Center <?php echo $mobile;?>/ " + tag + " / "
						+ category +" / " + title + " / " + imgnumber : s.prop5="";
					// End gallery prop
					s.prop6="<?php echo $mobile_current_template;?>";
					s.prop7= title;
					s.prop8="";
					s.prop9="viewmode=default";
		
					/* E-commerce Variables */
					s.campaign="";
					s.state="";
					s.zip="";
					s.events="event1";
					s.products="";
					s.purchaseID="";
					s.eVar1="";
					s.eVar2="";
					s.eVar3="";
					s.eVar4="<?php echo $sitename; ?> /";
					s.eVar5="";
		
					/* Hierarchy Variables */
					s.hier1="Journal Register,<?php echo $sitename_bits[0]; ?>,<?php echo $_SERVER['HTTP_HOST']; ?>,media center <?php echo trim($mobile);?>," 
						+ category + ",<?php echo $sitename; ?> /,,";
					s.hier2="Journal Register,media center <?php echo trim($mobile);?>,<?php echo $sitename_bits[0]; ?>,<?php echo $_SERVER['HTTP_HOST']; ?>" 
						+ category + ",<?php echo $sitename; ?> /,,";
					/************* DO NOT ALTER ANYTHING BELOW THIS LINE ! **************/
					var s_code=s.t();if(s_code)document.write(s_code)//-->
			};
			</script>
		</div>
	<?php break;
	// End JRC
	
	// MNG
	case("mng"):?>
		<div id="omniture" style="display:none;">
			<script type="text/javascript">
				var tag = '<?php echo $thepagetag; ?>';
				var category = '<?php echo $parentcat; ?>';
				var title = '<?php echo $thepagetitle; ?>';
				var s_account= '<?php echo get_option('T_tracking_code');?>';
			</script>
			<script type="text/javascript" src="http://extras.mnginteractive.com/live/js/omniture/SiteCatalystCode_H_17.js"></script>
			<script type="text/javascript" src="http://extras.mnginteractive.com/live/js/omniture/OmnitureHelper.js"></script>
			<script type="text/javascript">
				function omniTrack(params, total){
					if (params && total) {
						var imgnumber = 'image_number_' + params + '_of_' + total;
					}
					s.pageName="Media Center <?php echo $mobile;?>: " + tag + ": " + category + ": " + title + ": " // this is your page name.
					s.channel="Media Center <?php echo $mobile;?>"; 
					s.prop1="Media Center <?php echo $mobile;?>"; 
					s.prop2="Media Center <?php echo $mobile;?>/ " + tag;
					s.prop3="Media Center <?php echo $mobile;?>/ " + tag + " / " + category;
					s.prop4="Media Center <?php echo $mobile;?>/ " + tag + " / " + category + " / " + title;
					// Gallery prop
					(imgnumber) ? s.prop5="Media Center <?php echo $mobile;?>/ " + tag + " / " 
						+ category +" / " + title + " / " + imgnumber : s.prop5="";
					// End gallery prop
					<?php echo ($mobile_current_template) ? "s.prop6=\"$mobile_current_template\";" : ''; ?>
					s.prop9=getCiQueryString("SOURCE");
					s.eVar2=getCiQueryString("SOURCE");

					/* E-commerce Variables */

					s.campaign=getCiQueryString("EADID")+getCiQueryString("CREF");
					s.events="event1";
					s.eVar4=s.pageName;

					/************* DO NOT ALTER ANYTHING BELOW THIS LINE ! **************/
					var s_code=s.t();if(s_code)document.write(s_code)//-->
				};
		</script>

</div>
	<?php break;
	// End MNG
	
	// Admin 
	case("admin"):?>
		<script type="text/javascript">
			function omniTrack(){
				// Do nothing
			};
		</script>
	<?php break;
}

// End switch
?>
<?php
if (is_single() && preg_match('/\[insert[^BCvideo|Vid]/', $post->post_content)) {
	// Do nothing
	// Fire Omniture tracking on every page besides photo galleries
	// Gallery code on desktop and mobile handles Omniture itself
	// "[insert" is a reference to WP shortcodes to hook gallery creation
	// BCvideo occurs for Brightcove video posts where we do want Omniture to fire
	// Vid is from the Denver Post
}
else {?>
	<script type="text/javascript">
		omniTrack(); 
	</script>
<?php 
}?>
