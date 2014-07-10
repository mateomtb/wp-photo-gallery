<?php switch ($_SESSION['parent_company']){
	case("jrc"): 
	
		//basedomain for jrc omniture
		$fulldomain = get_option('T_sitenamex');
		$domain_bits = explode('.', $fulldomain);
		$basedomain = $domain_bits[1] . '.' . $domain_bits[2];
		//site name for jrc omniture
		$sitename = get_bloginfo('name');
		//break name on Media Center to get the property name
		$sitename_bits = explode(' Media', $sitename);
		?>
		
		
		
		<div id="omniture">
			<!-- SiteCatalyst code version: H.17. Copyright 1997-2005 Omniture, Inc. More info available at http://www.omniture.com -->
			<script language="JavaScript" type="text/javascript">
				//var s_account = "denverpost"
				var s_account="<?php echo $omniact = get_option('T_tracking_code'); ?>";
				
				var tag = '<?php echo $thepagetag; ?>';
				var category = '<?php echo $parentcat; ?>';
				var title = '<?php echo preg_replace('/[^a-z0-9_]/i', '_', $thepagetitle); ?>';
			</script>
			
			<script language="JavaScript" type="text/javascript" src="http://extras.mnginteractive.com/live/js/omniture/SiteCatalystCode_H_17.js"></script>
			<script language="JavaScript" type="text/javascript" src="http://extras.mnginteractive.com/live/js/omniture/OmnitureHelper.js"></script>
			
			<script language="JavaScript" src="http://<?php echo $basedomain; ?>/scripts/s_code.js"></script>
			
			<script language="JavaScript" type="text/javascript"><!--
				var blogname = "<?php bloginfo('name'); ?>";
				s.pageName="Media Center Mobile:"+ blogname +"/<?php trim(wp_title("")); ?>";
				s.channel = "Media Center Mobile";
				
				s.server="<?php echo $_SERVER['HTTP_HOST']; ?>";
				s.pageType=" ";
				s.prop1= category;
				s.prop2="Media Center Mobile| " + tag + " | " + category + " | " + title;
				s.prop3="";
				s.prop4="";
				s.prop5="";
				s.prop6="";
				s.prop7= title;
				s.prop8="";
				s.prop9="viewmode=default" ;
				s.prop10="";
				s.prop11="";
				s.prop12="";
				s.prop13="";
				s.prop14="";
				s.prop15="";
				s.prop16="";
				s.prop17="";
				s.prop18="";
				s.prop19="";
				s.prop20="";
				
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
				s.hier1="Journal Register,<?php echo $sitename_bits[0]; ?>,<?php echo $_SERVER['HTTP_HOST']; ?>,media center," + category + ",<?php echo $sitename; ?> /,,";
				s.hier2="Journal Register,media center,<?php echo $sitename_bits[0]; ?>,<?php echo $_SERVER['HTTP_HOST']; ?>" + category + ",<?php echo $sitename; ?> /,,";
				/************* DO NOT ALTER ANYTHING BELOW THIS LINE ! **************/
				var s_code=s.t();if(s_code)document.write(s_code);//-->

			</script>
			
			<noscript>
				<img src="http://denverpost.112.2O7.net/b/ss/denverpost/1/H.17--NS/0" height="1" width="1" border="0" alt="" />
			</noscript>
			<!-- End SiteCatalyst code version: H.17. -->
			<!-- Please do not serve this script locally. -->
			<script type="text/javascript" src="http://extras.mnginteractive.com/live/omniture/trackedgallery/galtracklib.js" ></script>
		</div>
		<script language="JavaScript" type="text/javascript">
			/* dont change pagename  */
		</script>
		
		
</div>







	<?php break;
	case("mngi"):?>



	
		<div id="omniture">
			<!-- SiteCatalyst code version: H.17. Copyright 1997-2005 Omniture, Inc. More info available at http://www.omniture.com -->
			<script language="JavaScript" type="text/javascript">
				//var s_account = "denverpost"
				var s_account="<?php echo $omniact = get_option('T_tracking_code'); ?>";
			</script>
			<script language="JavaScript" type="text/javascript" src="http://extras.mnginteractive.com/live/js/omniture/SiteCatalystCode_H_17.js"></script>
			<script language="JavaScript" type="text/javascript" src="http://extras.mnginteractive.com/live/js/omniture/OmnitureHelper.js"></script>
			<script language="JavaScript" type="text/javascript"><!--
				var blogname = "<?php bloginfo('name'); ?>";
				s.pageName="Media Center Mobile:"+ blogname +"/<?php trim(wp_title("")); ?>";
				s.channel = "Media Center Mobile";
				s.prop1 = "D=g";
                s.prop2 = "Media Center Mobile/?";
                s.prop3 = "Media Center Mobile/?/?";
                s.prop4 = "Media Center Mobile/?/?/?";
                s.prop5 = "Media Center Mobile/?/?/?/" + blogname +" / <?php trim(wp_title("")); ?>";
				s.prop9 = getCiQueryString("SOURCE");
				s.eVar2 = getCiQueryString("SOURCE");
				s.events = "event1";
				s.eVar4 = s.pageName;
				var s_code=s.t();if (s_code) {document.write(s_code)}//--></script>
			<noscript>
				<img src="http://denverpost.112.2O7.net/b/ss/denverpost/1/H.17--NS/0" height="1" width="1" border="0" alt="" />
				<!--<img src="http://<?php echo $omniact ?>.112.2O7.net/b/ss/<?php echo $omniact ?>/1/H.17--NS/0" height="1" width="1" border="0" alt="" />-->
			</noscript>
			<!-- End SiteCatalyst code version: H.17. -->
			<!-- Please do not serve this script locally. -->
			<script type="text/javascript" src="http://extras.mnginteractive.com/live/omniture/trackedgallery/galtracklib.js" ></script>
		</div>
		<script language="JavaScript" type="text/javascript">
			/* dont change pagename  */
		</script>










	<?php break;			
}?>
