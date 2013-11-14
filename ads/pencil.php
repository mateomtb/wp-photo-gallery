<?php if($realads):?>

	<div class="ad pencil expanded visible-lg-up">
		<script type="text/javascript">
		function sBmouseOver()
		{
		document.getElementById("closeimg").src="http://ads.advance.net/RealMedia/ads/Creatives/ADVANCE/SLIDING_BILLBOARD_CLOSER/close_button_highlite.gif"
		}
		function sBmouseOut()
		{
		document.getElementById("closeimg").src="http://ads.advance.net/RealMedia/ads/Creatives/ADVANCE/SLIDING_BILLBOARD_CLOSER/close_button_sprite.gif"
		}
		 jQuery(document).ready(function(){
		shrink = true;
		jQuery("#box").bind("mouseenter", function(e){
		shrink = false;
		});
		jQuery("#box").bind("mouseleave", function(e){
		shrink = true;
		});
		jQuery("#box").slideDown();
		jQuery("#closer").show();
		billclose = setTimeout(function() {
		if (shrink) {
		jQuery("#closer").hide();
		jQuery("#box").slideUp();
		}
		jQuery("#box").bind("mouseleave.close", function(e){
		jQuery("#closer").hide();
		jQuery("#box").slideUp();
		});
		}, 5000);
		});
		jQuery(function()
		{
		jQuery("#trigger").click(function(event) {
		jQuery("#box").unbind("mouseleave.close");
		jQuery("#trigger").blur();
		clearTimeout(billclose);
		event.preventDefault();
		jQuery("#box").slideDown();
		jQuery("#closer").show();
		billclose = setTimeout(function() {
		if (shrink) {
		jQuery("#closer").hide();
		jQuery("#box").slideUp();
		}
		jQuery("#box").bind("mouseleave.close", function(e){
		jQuery("#closer").hide();
		jQuery("#box").slideUp();
		});
		}, 5000);
		});
		jQuery("#closer").click(function(event) {
		jQuery("#closer").blur();
		clearTimeout(billclose);
		event.preventDefault();
		jQuery("#closer").hide();
		jQuery("#box").slideUp();
		});
		});
		</script>
		<style>
		#box {display: none;}
		</style>
		<div style="position: relative; width: 980px"><a href="#" id="trigger"><img border="0" src="http://ads.advance.net/RealMedia/ads/Creatives/MICHIGANLIVE/MediaKit01_MI_Other_SBB/mcpencil.jpg"></a><div><div id="box" style="z-index: -1; display: none; height: 300px; "><a href="#" id="closer" style="position: absolute; top: 33px; left: 892px; display: none; "><img onmouseover="sBmouseOver();" onmouseout="sBmouseOut();" id="closeimg" border="0" width="85px" height="24px" src="http://ads.advance.net/RealMedia/ads/Creatives/ADVANCE/SLIDING_BILLBOARD_CLOSER/close_button_sprite.gif"></a><a href="http://ads.mlive.com/RealMedia/ads/click_lx.ads/www.mlive.com/slidingbillboard/index.ssf/L40/1700687978/ImpactAd/MICHIGANLIVE/MediaKit01_MI_Other_SBB/cw008464.html/534b586c75302b7242736f41414c7a75" target="_blank"><img border="0" src="http://ads.advance.net/RealMedia/ads/Creatives/MICHIGANLIVE/MediaKit01_MI_Other_SBB/mcbillboard.gif"></a></div></div></div>
	</div>
	
	
<?php else:?>
	<div class="ad pencil visible-lg-up">
		<img src="http://placehold.it/970x30&text=970x30+pencilad">
	</div>
<?php endif; ?>
