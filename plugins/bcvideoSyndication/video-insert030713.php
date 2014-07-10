<?php
/* 
Plugin Name: Brightcove Video (with Syndication)
Plugin URI: 
Version: v1.00
Author: mateo leyba
Description: Inserts bright cove video
Copyright 2009 mateo leyba  (email : mleyba [a t ] mateoleyba DOT com)

    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License as published by
    the Free Software Foundation; either version 2 of the License, or
    (at your option) any later version.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program; if not, write to the Free Software
    Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307  USA

*/



function bcplayer_init_syn() {
	
	
	function generate_video_merc_syn($atts) {
	
	
	//example of user input, this is what you put in your post body. [insertVid vidid="77583397001"]
		extract(shortcode_atts(array(
			'vidid' => 'no id',
		), $atts));
	
		//var_dump($vidid);

		ob_start();?>
<div class="clear"></div>		
<div class="videobox">
<!-- Start of Brightcove Player -->

<div style="display:none">

</div>

<!--
By use of this code snippet, I agree to the Brightcove Publisher T and C 
found at https://accounts.brightcove.com/en/terms-and-conditions/. 
-->

<script language="JavaScript" type="text/javascript" src="http://admin.brightcove.com/js/BrightcoveExperiences.js"></script>

<object id="myExperience<?php echo $vidid?>" class="BrightcoveExperience">
  <param name="bgcolor" value="#FFFFFF" />
  <param name="width" value="600" />
  <param name="height" value="335" />
  <param name="wmode" value="transparent" />
  <param name="playerID" value="2235459141001" />
  <param name="playerKey" value="AQ~~,AAAAAF4Pseg~,AuucDCy8Ix18FsWpZ1iJC8zEd4KoUAOL" />
  <param name="isVid" value="true" />
  <param name="isUI" value="true" />
  <param name="dynamicStreaming" value="true" />
  <param name="@videoPlayer"  value="<?php echo $vidid?>" />
</object>

<!-- 
This script tag will cause the Brightcove Players defined above it to be created as soon
as the line is read by the browser. If you wish to have the player instantiated only after
the rest of the HTML is processed and the page load is complete, remove the line.
-->
<script type="text/javascript">brightcove.createExperiences();</script>

<!-- End of Brightcove Player -->

</div>	




		<?php
	   $data = ob_get_contents();
        ob_end_clean();
unset($director);	
	return $data;
	//print_r($data);
	
	}
	
	function generate_video_tc_syn($atts) {
	
	
	//example of user input, this is what you put in your post body. [insertVidTC vidid="77583397001"]
		extract(shortcode_atts(array(
			'vidid' => 'no id',
		), $atts));
	
		//var_dump($vidid);

		ob_start();?>
<div class="clear"></div>		
<div class="videobox">
<!-- Start of Brightcove Player -->

<div style="display:none">

</div>

<!--
By use of this code snippet, I agree to the Brightcove Publisher T and C 
found at https://accounts.brightcove.com/en/terms-and-conditions/. 
-->

<script language="JavaScript" type="text/javascript" src="http://admin.brightcove.com/js/BrightcoveExperiences.js"></script>

<object id="myExperience<?php echo $vidid?>" class="BrightcoveExperience">
  <param name="bgcolor" value="#FFFFFF" />
  <param name="width" value="600" />
  <param name="height" value="335" />
  <param name="wmode" value="transparent" />
  <param name="playerID" value="1384899576001" />
  <param name="playerKey" value="AQ~~,AAAAAGBdRBg~,Fa2suEROi7GQq7ucmRsNOH_GyBbUXumQ" />
  <param name="isVid" value="true" />
  <param name="isUI" value="true" />
  <param name="dynamicStreaming" value="true" />
  <param name="@videoPlayer" value="<?php echo $vidid?>" />
</object>



<!-- 
This script tag will cause the Brightcove Players defined above it to be created as soon
as the line is read by the browser. If you wish to have the player instantiated only after
the rest of the HTML is processed and the page load is complete, remove the line.
-->
<script type="text/javascript">brightcove.createExperiences();</script>

<!-- End of Brightcove Player -->

</div>	




		<?php
	   $data = ob_get_contents();
        ob_end_clean();
	return $data;
	//print_r($data);
	
	}		
	
	function generate_video_dpo_syn($atts) {
	
	
	//example of user input, this is what you put in your post body. [insertVid vidid="77583397001"]
		extract(shortcode_atts(array(
			'vidid' => 'no id',
		), $atts));
	
		//var_dump($vidid);

		ob_start();?>
<div class="clear"></div>		
<div class="videobox">
<!-- Start of Brightcove Player -->

<div style="display:none">

</div>

<!--
By use of this code snippet, I agree to the Brightcove Publisher T and C 
found at https://accounts.brightcove.com/en/terms-and-conditions/. 
-->

<script language="JavaScript" type="text/javascript" src="http://admin.brightcove.com/js/BrightcoveExperiences.js"></script>

<object id="myExperience<?php echo $vidid?>" class="BrightcoveExperience">
  <param name="bgcolor" value="#FFFFFF" />
  <param name="width" value="600" />
  <param name="height" value="335" />
  <param name="wmode" value="transparent" />
  <param name="playerID" value="784767430001" />
  <param name="playerKey" value="AQ~~,AAAAADe65VU~,G496cZ36A_UyJjxj4eEF2Fg5YE08WWhw" />
  <param name="isVid" value="true" />
  <param name="isUI" value="true" />
  <param name="dynamicStreaming" value="true" />
  <param name="@videoPlayer"  value="<?php echo $vidid?>" />
</object>

<!-- 
This script tag will cause the Brightcove Players defined above it to be created as soon
as the line is read by the browser. If you wish to have the player instantiated only after
the rest of the HTML is processed and the page load is complete, remove the line.
-->
<script type="text/javascript">brightcove.createExperiences();</script>

<!-- End of Brightcove Player -->

</div>	




		<?php
	   $data = ob_get_contents();
        ob_end_clean();
unset($director);	
	return $data;
	//print_r($data);
	
	}	

	add_shortcode('insertVidMerc', 'generate_video_merc_syn');
	add_shortcode('insertVidTC', 'generate_video_tc_syn');
	add_shortcode('insertVidDPO', 'generate_video_dpo_syn');
}	
         

         
add_action('plugins_loaded', 'bcplayer_init_syn');
	

?>
