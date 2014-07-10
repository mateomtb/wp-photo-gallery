<?php 
//echo 'session ' . $_SESSION['parent_company'];

if ($_SESSION['siteconfig']["ad_server_on_mc"] == "dfp") {?>
	<!-- Start: GPT Sync -->
			<script type='text/javascript'>
			(function(){
			var useSSL = 'https:' == document.location.protocol;
			var src = (useSSL ? 'https:' : 'http:') + '//www.googletagservices.com/tag/js/gpt.js';
			document.write('<scr' + 'ipt src="' + src + '"></scr' + 'ipt>');
			})();
			</script>
			
			<script type="text/javascript">
			
			<?php
			//setup vars for dfp tag declarations
			$domain_pieces = explode(".", $_SESSION['siteconfig']["url"]);
			$dfp_domain = $domain_pieces[1] . '.' . str_replace("/", "", $domain_pieces[2]);
			?>
			
			//Adslot 1 declaration
			var slot1= googletag.defineSlot('/8013/<?php echo $dfp_domain; ?>/media-center/<?php echo $slash_cats; ?>', [[300,250]],'cube1').setTargeting('pos',['Cube1_RRail_ATF']).addService(googletag.pubads());
			
			//Adslot 2 declaration
			var slot2= googletag.defineSlot('/8013/<?php echo $dfp_domain; ?>/media-center/<?php echo $slash_cats; ?>', [[728,90]],'top_leaderboard').setTargeting('pos',['top_leaderboard_ATF']).addService(googletag.pubads());
			
			//Adslot 3 declaration
			var slot3= googletag.defineSlot('/8013/<?php echo $dfp_domain; ?>/media-center/<?php echo $slash_cats; ?>', [[970,30]],'sbb').setTargeting('pos',['sbb']).addService(googletag.pubads());
			
			//Adslot 4 declaration
			var slot4= googletag.defineSlot('/8013/<?php echo $dfp_domain; ?>/media-center/<?php echo $slash_cats; ?>', [[100,100]],'wallpaper').setTargeting('pos',['wallpaper']).addService(googletag.pubads());
			
			//Adslot 5 declaration
			var slot5= googletag.defineSlot('/8013/<?php echo $dfp_domain; ?>/media-center/<?php echo $slash_cats; ?>', [[50,50]],'interstitial').setTargeting('pos',['interstitial']).addService(googletag.pubads());
			
			//Adslot 6 declaration
			var slot6= googletag.defineSlot('/8013/<?php echo $dfp_domain; ?>/media-center/<?php echo $slash_cats; ?>', [[900,540]],'galleryinterstitial').setTargeting('pos',['gallery_interstitial']).addService(googletag.pubads());
			
			googletag.pubads().setTargeting('kv',['<?php echo preg_replace('/[^a-z0-9_]/i', '_', $thepagetitle); ?>']);
			googletag.pubads().enableSyncRendering();
			googletag.enableServices();
			
			</script>
			<!-- End: GPT -->

<?php } elseif ($_SESSION['siteconfig']["ad_server_on_mc"] == "apt") { 
		
			switch ($_SESSION['parent_company']){
			case("jrc"):?>
				<!--YAHOO ADS--><script type="text/javascript">
				//General Information
				yld_mgr = {};
				yld_mgr.slots = {};
				yld_mgr.pub_id="<?php echo $ympubid = get_option('T_yld_mgrpub_id'); ?>";
				yld_mgr.site_name="<?php echo $ymsitename = get_option('T_yld_mgrsite_name'); ?>";
				yld_mgr.container_type="js";
				yld_mgr.request_type="ac";
				yld_mgr.clk_dest="_blank";
				yld_mgr.ad_output_encoding="utf-8";
				yld_mgr.max_count=3;
				yld_mgr.content_lang="en-US";
				yld_mgr.disable_content_send="0";
				yld_mgr.cstm_sctn_list=["Media Center"];
				yld_mgr.content_topic_id_list=["<?php echo $ymcontent = get_option('T_yld_mgrcontent'); ?>"];
			    var sectionKeywords = ["mediacenter","<? echo $thepagetag ?>",<? echo $alldeeezcats;?>];//Custom Content Categories - lower case, comma separated, max 10 categories, a-z, 0-9(category must start with a letter), and underscores are allowed
			    var content_type_list = [""];
				var reporting_tag_list = [""];//This is the section name
			
			
				//Ad slot configs
				
				
				yld_mgr.slots.top_slot = {};
				yld_mgr.slots.top_slot.ad_size_list=["728x90"];
				yld_mgr.slots.top_slot.ad_delivery_mode="ipatf";
				yld_mgr.slots.top_slot.ad_marker = "";
				yld_mgr.slots.top_slot.content_type_list = ["fn_news"];
				yld_mgr.slots.top_slot.cstm_content_cat_list=sectionKeywords;
				
				yld_mgr.slots.topright_slot = {};
				yld_mgr.slots.topright_slot.ad_size_list=["200x102"];
				yld_mgr.slots.topright_slot.ad_delivery_mode="ipatf";
				yld_mgr.slots.topright_slot.ad_marker = "";
				yld_mgr.slots.topright_slot.content_type_list = ["fn_news"];
				yld_mgr.slots.topright_slot.cstm_content_cat_list =sectionKeywords;
				
				yld_mgr.slots.pencil_slot = {};
				yld_mgr.slots.pencil_slot.ad_size_list=["972x30"];
				yld_mgr.slots.pencil_slot.ad_delivery_mode="ipatf";
				yld_mgr.slots.pencil_slot.ad_marker = "";
				yld_mgr.slots.pencil_slot.content_type_list = ["fn_news"];
				yld_mgr.slots.pencil_slot.cstm_content_cat_list=sectionKeywords;
				
				yld_mgr.slots.lrec_atf_slot = {};
				yld_mgr.slots.lrec_atf_slot.ad_size_list=["300x250"];
				yld_mgr.slots.lrec_atf_slot.ad_delivery_mode="ipatf";
				yld_mgr.slots.lrec_atf_slot.ad_marker = "";
				yld_mgr.slots.lrec_atf_slot.content_type_list = ["fn_news"];
				yld_mgr.slots.lrec_atf_slot.cstm_content_cat_list=sectionKeywords;
				
				yld_mgr.slots.lrec_btf_slot = {};
				yld_mgr.slots.lrec_btf_slot.ad_size_list=["300x250"];
				yld_mgr.slots.lrec_btf_slot.ad_delivery_mode="ipbtf";
				yld_mgr.slots.lrec_btf_slot.ad_marker = "";
				yld_mgr.slots.lrec_btf_slot.content_type_list = ["fn_news"];
				yld_mgr.slots.lrec_btf_slot.cstm_content_cat_list=sectionKeywords;
				
				yld_mgr.slots.bottom_slot = {};
				yld_mgr.slots.bottom_slot.ad_size_list=["728x90"];
				yld_mgr.slots.bottom_slot.ad_delivery_mode="ipbtf";
				yld_mgr.slots.bottom_slot.ad_marker = "";
				yld_mgr.slots.bottom_slot.content_type_list = ["fn_news"];
				yld_mgr.slots.bottom_slot.cstm_content_cat_list=sectionKeywords;
				
				yld_mgr.slots.popunder_slot = {};
				yld_mgr.slots.popunder_slot.ad_size_list=["1x1"];
				yld_mgr.slots.popunder_slot.ad_delivery_mode="ipbtf";
				yld_mgr.slots.popunder_slot.ad_marker = "";
				yld_mgr.slots.popunder_slot.content_type_list = ["fn_news"];
				yld_mgr.slots.popunder_slot.cstm_content_cat_list=sectionKeywords;
				
				
				</script><script type="text/javascript" src="http://e.yieldmanager.net/script.js"></script>
				<?php break;
			case("mngi"):?>
				<script language="JavaScript" type="text/javascript" src="http://extras.mnginteractive.com/live/js/tacoda/DartInclude.js"></script>
				<script language="JavaScript" type="text/javascript" src="http://extras.mnginteractive.com/live/js/tacoda/AccipiterInclude.js"></script>
				
				<!--YAHOO ADS--><script type="text/javascript">
				//General Information
				yld_mgr = {};
				yld_mgr.slots = {};
				yld_mgr.pub_id="<?php echo $ympubid = get_option('T_yld_mgrpub_id'); ?>";
				yld_mgr.site_name="<?php echo $ymsitename = get_option('T_yld_mgrsite_name'); ?>";
				yld_mgr.container_type="js";
				yld_mgr.request_type="ac";
				yld_mgr.clk_dest="_blank";
				yld_mgr.ad_output_encoding="utf-8";
				yld_mgr.max_count=3;
				yld_mgr.content_lang="en-US";
				yld_mgr.disable_content_send="0";
				yld_mgr.cstm_sctn_list=["section"];
				yld_mgr.content_topic_id_list=["<?php echo $ymcontent = get_option('T_yld_mgrcontent'); ?>"];
			    var sectionKeywords = ["mediacenter","<? echo $thepagetag ?>",<? echo $alldeeezcats;?>];//Custom Content Categories - lower case, comma separated, max 10 categories, a-z, 0-9(category must start with a letter), and underscores are allowed
			    var content_type_list = [""];
				var reporting_tag_list = [""];//This is the section name
			
				//Ad slot configs
				yld_mgr.slots.adPos1={};
				yld_mgr.slots.adPos1.ad_size_list=["1000x30"];
				yld_mgr.slots.adPos1.ad_delivery_mode="ipatf";
				yld_mgr.slots.adPos1.ad_format_list=["Standard Graphical","Rich Media"];
				yld_mgr.slots.adPos1.cstm_content_cat_list=sectionKeywords;
				yld_mgr.slots.adPos1.content_type_list=content_type_list;
				yld_mgr.slots.adPos1.reporting_tag_list=reporting_tag_list;
				//wallpaper
				yld_mgr.slots.adPos3={};
				yld_mgr.slots.adPos3.ad_size_list=["100x100"];
				yld_mgr.slots.adPos3.ad_delivery_mode="ipatf";
				yld_mgr.slots.adPos3.ad_format_list=["Standard Graphical","Rich Media"];
				yld_mgr.slots.adPos3.cstm_content_cat_list=sectionKeywords;
				yld_mgr.slots.adPos3.content_type_list=content_type_list;
				yld_mgr.slots.adPos3.reporting_tag_list=reporting_tag_list;
			
			
				
				yld_mgr.slots.adPos6={};
				yld_mgr.slots.adPos6.ad_size_list=["1x1"];
				yld_mgr.slots.adPos6.ad_delivery_mode="ipatf";
				yld_mgr.slots.adPos6.ad_format_list=["Standard Graphical","Rich Media"];
				yld_mgr.slots.adPos6.cstm_content_cat_list=sectionKeywords;
				yld_mgr.slots.adPos6.content_type_list=content_type_list;
				yld_mgr.slots.adPos6.reporting_tag_list=reporting_tag_list;
			
				yld_mgr.slots.adPos9={};
				yld_mgr.slots.adPos9.ad_size_list=["300x250"];
				yld_mgr.slots.adPos9.ad_delivery_mode="ipatf";
				yld_mgr.slots.adPos9.ad_format_list=["Standard Graphical","Rich Media"];
				yld_mgr.slots.adPos9.cstm_content_cat_list=sectionKeywords;
				yld_mgr.slots.adPos9.content_type_list=content_type_list;
				yld_mgr.slots.adPos9.reporting_tag_list=reporting_tag_list;
				
				yld_mgr.slots.adPos2={};
				yld_mgr.slots.adPos2.ad_size_list=["300x250"];
				yld_mgr.slots.adPos2.ad_delivery_mode="ipbtf";
				yld_mgr.slots.adPos2.ad_format_list=["Standard Graphical","Rich Media"];
				yld_mgr.slots.adPos2.cstm_content_cat_list=sectionKeywords;
				yld_mgr.slots.adPos2.content_type_list=content_type_list;
				yld_mgr.slots.adPos2.reporting_tag_list=reporting_tag_list;
			
				yld_mgr.slots.adPos10={};
				yld_mgr.slots.adPos10.ad_size_list=["25x25"];
				yld_mgr.slots.adPos10.ad_delivery_mode="ipatf";
				yld_mgr.slots.adPos10.ad_format_list=["Standard Graphical","Rich Media"];
				yld_mgr.slots.adPos10.cstm_content_cat_list=sectionKeywords;
				yld_mgr.slots.adPos10.content_type_list=content_type_list;
				yld_mgr.slots.adPos10.reporting_tag_list=reporting_tag_list;
				
				yld_mgr.slots.adPos13={};
				yld_mgr.slots.adPos13.ad_size_list=["250x30"];
				yld_mgr.slots.adPos13.ad_delivery_mode="ipatf";
				yld_mgr.slots.adPos13.ad_format_list=["Standard Graphical","Rich Media"];
				yld_mgr.slots.adPos13.cstm_content_cat_list=sectionKeywords;
				yld_mgr.slots.adPos13.content_type_list=content_type_list;
				yld_mgr.slots.adPos13.reporting_tag_list=reporting_tag_list;
			
			
				yld_mgr.slots.adPos14={};
				yld_mgr.slots.adPos14.ad_size_list=["728x90"];
				yld_mgr.slots.adPos14.ad_delivery_mode="ipbtf";
				yld_mgr.slots.adPos14.ad_format_list=["Standard Graphical","Rich Media"];
				yld_mgr.slots.adPos14.cstm_content_cat_list=sectionKeywords;
				yld_mgr.slots.adPos14.content_type_list=content_type_list;
				yld_mgr.slots.adPos14.reporting_tag_list=reporting_tag_list;
			
			
				</script><script type="text/javascript" src="http://e.yieldmanager.net/script.js"></script>
				<?php break;
	}

}
?>
