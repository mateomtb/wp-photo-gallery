<?php
/* 
Plugin Name: insert brightcove video
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



function bc_head() {
	echo '<link rel="stylesheet" type="text/css" href="' . get_settings('siteurl') . '/wp-content/plugins/bcvideo/bcvideo.css" />';

	}

add_action('wp_head', 'bc_head');


function bcplayer_init() {
	
	
	function generate_video($atts) {
	
	
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
<script type="text/javascript" src="http://admin.brightcove.com/js/BrightcoveExperiences.js"></script>

<object id="myExperience1265213507001" class="BrightcoveExperience">
  <param name="bgcolor" value="#FFFFFF" />
  <param name="width" value="600" />
  <param name="height" value="335" />
  <param name="wmode" value="transparent" />
  <param name="playerID" value="77543683001" />
  <param name="playerKey" value="AQ~~,AAAAAF4Pseg~,AuucDCy8Ix1LVZExjO6fAaXxVLmsA2Wu" />
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
	
function generate_video2($atts) {
	global $mobile_current_template;	//add cj
	global $videoData;					//keeps track of video variables for mobile
	
	//example of user input, this is what you put in your post body. [insertVid2 vidid="77583397001"]
	extract(shortcode_atts(array(
		'vidid' => 'no id',
	), $atts));

	//var_dump($vidid);

	ob_start();
	
	
	if ( $mobile_current_template != '' ) {	//add cj
		//echo 'test text here yo: '. $vidid;
		$videoData = $vidid;
		//echo '<script>alert( "'. $vidid .'" );</script>';
	} else {	//add cj --- everything below is NOT my code ?>
		
		<div class="clear"></div>
		<div id="videocontainer" class="videocontainer" style="">		
			<div class="videobox">
				<!-- Start of Brightcove Player -->

				<div style="display:none"></div>

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
				  <param name="playerKey" value="AQ~~,AAAAADe65VU~,G496cZ36A_WiTZ4IQyeReBB7z075a2tu" />
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
		</div>	

		<?php

	}
	
	$data = ob_get_contents();
	ob_end_clean();
	return $data;
	//print_r($data);
}	
	
function create_bc_video($atts) {
	
	
	//example of user input, this is what you put in your post body. [insertBCvideo vidid="xxxxxxxx" propertyid="dailynews"]
		extract(shortcode_atts(array(
			'vidid' => 'no id',
			'propertyid' => 'no property',
		), $atts));
	
		//var_dump($vidid);
		
		//setup list of properties player id's I'll move this to a config file when it's all working - mateo 5/3/12
switch ($propertyid) {
    case "dailynews":
        $playerid = '1620111210001';
        $playerkey = 'AQ~~,AAAAAGA-Sig~,6sNVJ3Bb4XsaQmpCZhT7ksFAPod2HrIj';
        break;
   	case "dailybreeze":
        $playerid = '1618290560001';
        $playerkey = 'AQ~~,AAAAAGBdRAo~,t2cIYZUexJ1B1XEc-XqO20_0p1EDnrCa';
        break;  
   	case "presstelegram":
        $playerid = '1620111214001';
        $playerkey = 'AQ~~,AAAAAGApB6s~,yrcO1jAnZOLnTJakebWwogXCEqoS-dAM';
        break;  
    case "mercnews":
        $playerid = '77543683001';
        $playerkey = 'AQ~~,AAAAAF4Pseg~,AuucDCy8Ix1LVZExjO6fAaXxVLmsA2Wu';
        break;                                   
    default:
       $playerid = '';
}
		
		
		
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
  <param name="playerID" value="<?php echo $playerid?>" />
  <param name="playerKey" value="<?php echo $playerkey?>" />
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
  
    //add_shortcode('insertVid', 'generate_video');
	//add_shortcode('insertVid2', 'generate_video2');
	add_shortcode('insertBCvideo', 'create_bc_video');
}	
         
add_action('plugins_loaded', 'bcplayer_init');
	

?>