<?php

$shortname = "T";

global $categories;
$cats_array = get_categories();
$categories = array();
foreach ($cats_array as $cats) {
	$categories[0] = "";
	$categories[$cats->cat_ID] = $cats->cat_name;	
}
$icon_categories = file( get_template_directory() . '/lib/functions/iconlist.txt', FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);

if(!isset($themename)) {
	$themename = "Media Center";
	$thumbnailsize = "150 x 150 pixels";
}

if(!isset($header_logo)) {$header_logo = "false";}
if(!isset($header_logo_bg)) {$header_logo_bg = "";}
if(!isset($header_logo_path)) {$header_logo_path = "";}
if(!isset($header_logo_desc)) {$header_logo_desc = "false";}
if ( !isset($footer_link_markup) ) $footer_link_markup = '';
$options = array (

        		array(	"name" => "Theme Options",
						"desc" => "",
			    		"id" => $shortname."_theme_options",
			    		"std" => "",
			    		"type" => "hidden"),        		
        							    			    		
							    
			    array(	"name" => "Logo",
						"type" => "title"),
				
				array(	"type" => "open"),
				
				array(	"name" => "Add your Logo",
						"desc" => "Check this box to add your header logo.",
			    		"id" => $shortname."_header_logo",
			    		"std" => $header_logo,
			    		"type" => "checkbox"),
			    							    
				array(	"name" => "Logo URL",
					    "id" => $shortname."_header_logo_path",
						"desc" => "Upload your logo via any FTP program and paste the full URL here.",
					    "std" => $header_logo_path,
					    "type" => "text"),
					
				array(	"name" => "Logo Background Color",
					    "id" => $shortname."_header_logo_bg",
						"desc" => "Set the 8 bit hex color (RGB) of the logo bar here. (#000000)",
					    "std" => $header_logo_bg,
					    "type" => "text"),
					    
				array(	"name" => "Show Description",
						"desc" => "Check this box to show the site description. Hides by default when you add the logo.",
			    		"id" => $shortname."_header_desc",
			    		"std" => $header_logo_desc,
			    		"type" => "checkbox"),

				array(	"type" => "close"),
				
				array(	"name" => "Menu Links",
						"type" => "title"),
				
				array(	"type" => "open"),

			    array(	"name" => "Show Menu Links",
						"desc" => "Check this option to show links in the footer bar",
			    		"id" => $shortname."_header_links",			    		
			    		"type" => "checkbox",
			    		"std" => "true"),
					    							    
				array(	"name" => "First Link" ,
						"id" => $shortname."_header_link_1",
						"std" => "",						
						"type" => "select",
						"options" => $categories),
				
				array(	"name" => "First Link Icon" ,
						"id" => $shortname."_header_link_icon_1",
						"std" => "",						
						"type" => "select",
						"options" => $icon_categories),
				
				array(	"name" => "Second Link" ,
						"id" => $shortname."_header_link_2",
						"std" => "",						
						"type" => "select",
						"options" => $categories),
						
				array(	"name" => "Second Link Icon" ,
						"id" => $shortname."_header_link_icon_2",
						"std" => "",						
						"type" => "select",
						"options" => $icon_categories),
						
				array(	"name" => "Third Link" ,
						"id" => $shortname."_header_link_3",
						"std" => "",						
						"type" => "select",
						"options" => $categories),
						
				array(	"name" => "Third Link Icon" ,
						"id" => $shortname."_header_link_icon_3",
						"std" => "",						
						"type" => "select",
						"options" => $icon_categories),
						
				array(	"name" => "Fourth Link" ,
						"id" => $shortname."_header_link_4",
						"std" => "",						
						"type" => "select",
						"options" => $categories),				
				
				array(	"name" => "Fourth Link Icon" ,
						"id" => $shortname."_header_link_icon_4",
						"std" => "",						
						"type" => "select",
						"options" => $icon_categories),				
				
				array(	"type" => "close"),
				
				array(	"name" => "Footer Links",
						"type" => "title"),
				
				array(	"type" => "open"),

			    array(	"name" => "Show Footer Links",
						"desc" => "Check this option to show links in the footer.",
			    		"id" => $shortname."_footer_links",			    		
			    		"type" => "checkbox",
			    		"std" => "true"),
					    							    
				array(	"name" => "Footer link HTML - Line 1" ,
						"id" => $shortname."_footer_link_markup_1",
						"desc" => "Input valid HTML of links here in the form of a list (&#60li&#62&#60a href=\"http://domain\"&#62LINK NAME&#60/a&#62&#60/li&#62).",
					    "std" => $footer_link_markup,
					    "type" => "textarea"),
		
				array(	"name" => "Footer link HTML - Line 2" ,
						"id" => $shortname."_footer_link_markup_2",
						"desc" => "Input valid HTML of links here in the form of a list (&#60li&#62&#60a href=\"http://domain\"&#62LINK NAME&#60/a&#62&#60/li&#62).",
					    "std" => $footer_link_markup,
					    "type" => "textarea"),
							
				array(	"type" => "close"),
				
				array(	"name" => "Homepage Setup & Design",
						"type" => "title"),
            	
            	array(	"type" => "open"),
			    		
				array(	"name" => "Show Featured Section",
						"desc" => "Check this option to show the Featured Section.  This section will contain a main featured post at left, with the three previous posts at right.",
			    		"id" => $shortname."_featured",
			    		"std" => "true",
			    		"type" => "checkbox"),
			    
	    	    array(	"name" => "Featured category" ,
						"id" => $shortname."_featured_category",
						"std" => "",						
						"type" => "select",
						"options" => $categories),
			    		
			    array(	"name" => "Show Blog Section",
						"desc" => "Check this option to show the Blog Section.",
			    		"id" => $shortname."_blog",
			    		"std" => "false",
			    		"type" => "checkbox"),
			    
	    	    array(	"name" => "Blog category" ,
						"id" => $shortname."_blog_category",
						"std" => "",						
						"type" => "select",
						"options" => $categories),
						
                array(	"name" => "News Tabs Section",
						"desc" => "Check this option to show the latest posts from four chosen categories below.",
			    		"id" => $shortname."_news",			    		
			    		"type" => "checkbox",
			    		"std" => "true"),

			    array(	"name" => "News Tab 1" ,
						"id" => $shortname."_news_tab_1",
						"std" => "",						
						"type" => "select",
						"options" => $categories),

				array(	"name" => "News tab 2" ,
						"id" => $shortname."_news_tab_2",
						"std" => "",
						"type" => "select",
						"options" => $categories),

				array(	"name" => "News Tab 3" ,
						"id" => $shortname."_news_tab_3",
						"std" => "",
						"type" => "select",
						"options" => $categories),

				array(	"name" => "News Tab 4" ,
						"id" => $shortname."_news_tab_4",
						"std" => "",
						"type" => "select",
						"options" => $categories),
			    		
			    array(	"type" => "close"),
			    		
				array(	"name" => "Category Section Options",
						"type" => "title"),
            	
            	array(	"type" => "open"),
			    		
			    array(	"name" => "Show Five Categories Section",
						"desc" => "Check this option to show the latest posts from five chosen categories below.",
			    		"id" => $shortname."_category_section",			    		
			    		"type" => "checkbox",
			    		"std" => "true"),
			    		
			    array(	"name" => "First category" ,
						"id" => $shortname."_category_section_1",
						"std" => "",						
						"type" => "select",
						"options" => $categories),

				array(	"name" => "Second category" ,
						"id" => $shortname."_category_section_2",
						"std" => "",
						"type" => "select",
						"options" => $categories),
										   
				array(	"name" => "Third category" ,
						"id" => $shortname."_category_section_3",
						"std" => "",
						"type" => "select",
						"options" => $categories),
						
				array(	"name" => "Fourth category" ,
						"id" => $shortname."_category_section_4",
						"std" => "",
						"type" => "select",
						"options" => $categories),
						
				array(	"name" => "Fifth category" ,
						"id" => $shortname."_category_section_5",
						"std" => "",
						"type" => "select",
						"options" => $categories),
			    		
			    array(	"type" => "close"),	    
					    
				array(	"name" => "Brightcove Social Setup",
						"type" => "title"),
						
				array(	"type" => "open"),
			    
			    array(	"name" => "Brightcove Publisher ID",
						"id" => $shortname."_bcpubid",
						"desc" => "Brightcove Publisher ID;",
						"type" => "text"),
				
				array(	"name" => "Brightcove Player ID",
						"id" => $shortname."_bcplayerid",
						"desc" => "Brightcove Player ID;",
						"type" => "text"),		
							    
				array(	"type" => "close"),
				
				array(	"name" => "MyCapture Photo Sales Setup",
						"type" => "title"),
						
				array(	"type" => "open"),
			    
			    array(	"name" => "MyCapture URL",
						"id" => $shortname."_mcurl",
						"desc" => "MyCapture Domain URL;",
						"type" => "text"),
							    
				array(	"type" => "close"),
		
				array(	"name" => "Facebook Setup",
						"type" => "title"),
						
				array(	"type" => "open"),
			    
			    array(	"name" => "Facebook App ID",
						"id" => $shortname."_fbappid",
						"desc" => "Facebook App ID;",
						"type" => "text"),
						
																		   
				array(	"type" => "close"),

			   array(  "type" => "open"),

                               array(      "name" => "Interstitial Ad/Survey Toggle",
                                                "type" => "title"),

                                array(  "name" => "Turn off ads/survey interstitial",
                                                "id" => $shortname."_int_toggle",
						"std" => "true",
                                                "type" => "checkbox"),

                                array(  "type" => "close"),
 
			    array(	"name" => "Yahoo Advertising Code",
						"type" => "title"),
						
				array(	"type" => "open"),
			    
			    array(	"name" => "yld_mgr.pub_id=",
						"id" => $shortname."_yld_mgrpub_id",
						"desc" => "The value from yahoo ad code i.e yld_mgr.pub_id=\"21204022309\";",
						"type" => "text"),
				
				array(	"name" => "yld_mgr.site_name=",
						"id" => $shortname."_yld_mgrsite_name",
						"desc" => "The value from yahoo ad code i.e. yld_mgr.site_name=\"www.denverpost.com\";",
						"type" => "text"),
						
				array(	"name" => "yld_mgr.content_topic_id_list=",
						"id" => $shortname."_yld_mgrcontent",
						"desc" => "The value from yahoo ad code i.e. yld_mgr.content_topic_id_list=[\"20337001\"]",
						"type" => "text"),
																		   
				array(	"type" => "close"),
				
				array("type" => "open"),
				        			
				array("name" => "Spreed Advertising Code",
					"type" => "title",
					),

				array("name" => "Spreed SKU",
					"id" => $shortname."_spreed_sku",
					"desc" => "This is the one variable in the Spreed ad tags",
					"type" => "text",),
				
				array("type" => "close"),
				
        		array(	"name" => "Omniture Tracking Code",
						"type" => "title"),
						
				array(	"type" => "open"),
						
				array(	"name" => "var s_account=",
						"id" => $shortname."_tracking_code",
						"desc" => "This is the value found in the Omniture code that looks like this var s_account=\"denverpost\";",
						"std" => "",
						"type" => "text"),		
										   
				array(	"type" => "close"),
				
				array(	"name" => "Main Site URL",
						"type" => "title"),
				
				array(	"type" => "open"),
				
				array( "name" => "Main Site URL",
						"type" => "text",
						"id" => $shortname."_sitenamex",
						"desc" => "This is the name of the \"Main\" site for this property i.e. http://www.denverpost.com."
						
				),
				
				array(	"type" => "close"),
				
				array(  "name" => "Site Language",
                                                "type" => "title"),				

				array(  "type" => "open"),

                                array( "name" => "Site Language",
                                                "type" => "text",
                                                "id" => $shortname."_language",
                                                "desc" => "The site language. Example - \"Spanish\". Defaults to English."

                                ),

                                array(  "type" => "close")
		  );

function mytheme_add_admin() {

    global $themename, $shortname, $options;

    if ( isset($_GET['page']) && $_GET['page'] == basename(__FILE__) ) {
    
        if ( 'save' == $_REQUEST['action'] ) {

                foreach ($options as $value) {
                    update_option( $value['id'], $_REQUEST[ $value['id'] ] ); }

                foreach ($options as $value) {
                    if( isset( $_REQUEST[ $value['id'] ] ) ) { update_option( $value['id'], $_REQUEST[ $value['id'] ]  ); } else { delete_option( $value['id'] ); } }

                header("Location: themes.php?page=theme-options.php&saved=true");
                die;

        } else if( 'reset' == $_REQUEST['action'] ) {

            foreach ($options as $value) {
                delete_option( $value['id'] ); }

            header("Location: themes.php?page=theme-options.php&reset=true");
            die;

        }
    }

    add_theme_page($themename." Options", "$themename Options", 'edit_themes', basename(__FILE__), 'mytheme_admin');

}

//add_theme_page($themename . 'Header Options', 'Header Options', 'edit_themes', basename(__FILE__), 'headimage_admin');

function headimage_admin(){
	
}

function mytheme_head(){
	global $options;
	foreach($options as $value) {
		if (get_settings( $value['id'] ) === FALSE) { $$value['id'] = $value['std']; } else { $$value['id'] = get_settings( $value['id'] ); }
	}	
}

function mytheme_admin() {

    global $themename, $shortname, $options;

    if ( $_REQUEST['saved'] ) echo '<div id="message" class="updated fade"><p><strong>'.$themename.' Options saved.</strong></p></div>';
    if ( $_REQUEST['reset'] ) echo '<div id="message" class="updated fade"><p><strong>'.$themename.' Options reset.</strong></p></div>';
    
?>
<div class="wrap">
<h2><?php echo $themename; ?> Options</h2>

<p><?php _e('Global configurations for Media Center Setup. Do not edit this stuff please.', 'gpp'); ?></p>

<form method="post">

<div id="poststuff" class="dlm">

<?php foreach ($options as $value) { 
    
	switch ( $value['type'] ) {
	
		case "open":
		?>
		
        
		<?php break;
		
		case "close":
		?>
        </table></div></div>
        
        
		<?php break;
		
		case "title":
		?>
		<div class="postbox close">
		<h3><?php echo $value['name']; ?></h3>
			<div class="inside">
        
		<table width="100%" border="0" style="background-color:#ccc; padding:5px 10px;"><tr>
        </tr>
                
        
		<?php break;

		case 'text':
		?>
        
        <tr>
            <td width="20%" rowspan="2" valign="middle"><strong><?php echo $value['name']; ?></strong></td>
            <td width="80%"><input style="width:400px;" name="<?php echo $value['id']; ?>" id="<?php echo $value['id']; ?>" type="<?php echo $value['type']; ?>" value="<?php if (get_option( $value['id'] ) === FALSE) { $$value['id'] = $value['std']; } else { $$value['id'] = get_option( $value['id'] ); } echo $$value['id']; ?>" /></td>
        </tr>

        <tr>
            <td><small><?php echo $value['desc']; ?></small></td>
        </tr><tr><td colspan="2" style="margin-bottom:5px;border-bottom:1px dotted #000000;">&nbsp;</td></tr><tr><td colspan="2">&nbsp;</td></tr>

		<?php 
		break;
		
		case 'textarea':
		?>
        
        <tr>
            <td width="20%" rowspan="2" valign="middle"><strong><?php echo $value['name']; ?></strong></td>
            <td width="80%"><textarea name="<?php echo $value['id']; ?>" style="width:400px; height:200px;" type="<?php echo $value['type']; ?>" cols="" rows=""><?php if ( get_settings( $value['id'] ) != "") { echo stripslashes( get_settings(  $value['id'] ) ); } else { echo $value['std']; } ?></textarea></td>
            
        </tr>

        <tr>
            <td><small><?php echo $value['desc']; ?></small></td>
        </tr><tr><td colspan="2" style="margin-bottom:5px;border-bottom:1px dotted #000000;">&nbsp;</td></tr><tr><td colspan="2">&nbsp;</td></tr>

		<?php 
		break;
		
		case 'select':
		?>
        <tr>
            <td width="20%" rowspan="2" valign="middle"><strong><?php echo $value['name']; ?></strong></td>
            <td width="80%"><select style="width:240px;" name="<?php echo $value['id']; ?>" id="<?php echo $value['id']; ?>"><?php foreach ($value['options'] as $option) { ?><option <?php if ( get_settings( $value['id'] ) == $option) { echo ' selected="selected"'; } elseif ($option == $value['std']) { echo ' selected="selected"'; } ?>><?php echo $option; ?></option><?php } ?></select></td>
       </tr>
                
       <tr>
            <td><small><?php echo $value['desc']; ?></small></td>
       </tr><tr><td colspan="2" style="margin-bottom:5px;border-bottom:1px dotted #000000;">&nbsp;</td></tr><tr><td colspan="2">&nbsp;</td></tr>

		<?php
        break;
            
		case "checkbox":
		?>
            
           <?php if(get_option('T_theme_options')) { $val = "false";} else { $val="true"; }?> 
            <tr>
            <td width="20%" rowspan="2" valign="middle"><strong><?php echo $value['name']; ?></strong></td>
                <td width="80%"><? if(get_option($value['id']) || ((get_option("T_theme_options")===FALSE && get_option($value['id'])===FALSE) && ($value['std']=="true") )){ $checked = "checked=\"checked\""; } elseif (get_option($value['id'])===FALSE && (get_option("T_theme_options")=="true")){ $checked = ""; } else {$checked = ""; } ?>
                        <input type="checkbox" name="<?php echo $value['id']; ?>" id="<?php echo $value['id']; ?>" value="true" <?php echo $checked; ?> /> <small><?php echo $value['desc']; ?></small>
                        </td>
            </tr>
                        
            <tr>
                <td></td>
           </tr><tr><td colspan="2" style="margin-bottom:5px;border-bottom:1px dotted #000000;">&nbsp;</td></tr><tr><td colspan="2">&nbsp;</td></tr>
            
        <?php 		break;
        
        case "hidden":
		?>
        <input type="hidden" name="<?php echo $value['id']; ?>" id="<?php echo $value['id']; ?>" value="true" />
            
        <?php 		break;
	
 
} 
}
?>

</div>

<p class="submit">
<input name="save" type="submit" value="Save changes" />    
<input type="hidden" name="action" value="save" />
</p>
</form>
<form method="post">
<p class="submit">
<input name="reset" type="submit" value="Reset" /> <small>This will reset the whole Theme Options to Default. Be careful when using it.</small>
<input type="hidden" name="action" value="reset" />
</p>
</form>

			<script type="text/javascript">
			<!--
			jQuery('.postbox h3').prepend('<a class="togbox">+</a> ');
			jQuery('.postbox h3').click( function() { jQuery(jQuery(this).parent().get(0)).toggleClass('closed'); } );
			jQuery('.postbox.close').each(function(){ jQuery(this).addClass("closed"); });
			//-->
			</script>

<?php }  add_action('admin_menu', 'mytheme_add_admin'); ?>
