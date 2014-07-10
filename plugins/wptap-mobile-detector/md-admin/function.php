<?php
/* add option */
function md_option_menu()
{
	$pluginname = 'Mobile Detector';

	add_menu_page( __( $pluginname, 'WPtap' ), __( '<span style="font-size:12px;">'.$pluginname.'</span>', 'WPtap' ), 8, 'md-option', 'md_option_page', plugin_dir_url(__FILE__).'css/icon-menu.png');
	add_submenu_page( 'md-option', __('Settings', 'WPtap'), __('Settings', 'WPtap'), 8, 'md-option', 'md_option_page' );
	add_submenu_page( 'md-option', __('Add Device', 'WPtap'), __('Add Device', 'WPtap'), 8, 'md-device', 'md_add_devices' );
}
/* head style and jquery */
function md_admin_head()
{
	$adminuri = plugin_dir_url(__FILE__);

	echo '<script type="text/javascript" src="'.$adminuri.'js/global.js"></script>';
	echo "<link rel='stylesheet' id='mobiledetector-css'  href='{$adminuri}css/style.css' type='text/css' media='all' />";
}

if(isset($_GET['page']) && ($_GET['page'] == 'md-option' || $_GET['page'] == 'md-device'))
	add_action('admin_head', 'md_admin_head');

function md_add_devices()
{
	global $wpdb;

	$title = __('Add Device');
?>
<div class="wrap">
	<?php screen_icon('options-addmobiledetector'); ?>
	<h2><?php echo esc_html( $title ); // ?></h2>
<?php

if(isset($_POST['submit'])) {
	unset($_POST['submit']);

	$data = $wpdb->escape($_POST);
	unset($_POST);
	$wpdb->insert(TABLE_MOBILES, $data);

	echo '<div id="message" class="updated fade"><p><strong>Mobile device added.</strong></p></div>';
}	
?>
	<p><?php _e('Device types must be hard coded into this version of the plugin. Contact Chris Johnson if you want to add a device type at cjohnson@digitalfirstmedia.com') ?></p>
	
</div>
<?php
}

function md_option_page() 
{
	global $wpdb, $pluginversion, $pluginname;

	$title = __($pluginname.'('.$pluginversion.')');
	$wptap_mobile_themes = get_mobile_themes();
?>
<div class="wrap">
	<?php screen_icon('options-mobiledetector'); ?>
	<h2><?php echo esc_html( $title ); ?></h2>
	
	<div id="plugin-description" class="widefat alternate" style="margin:10px 0; padding:5px;background-color:#FFFEEB;">
		<p><?php _e('This plugin automatically detects the type of mobile browser that you site is viewed from, and activates the mobile theme you have chosen for it. User can install multiple mobile themes and link it to different mobile browsers for best performance. If you have a separate WAP or mobile website, this detector also allows you to redirect your mobile traffic to the WAP/mobile site.'); ?></p>
		<p><?php _e('MEDIA CENTER modifications done by Chris Johnson : cjohnson@digitalfirstmedia.com'); ?></p>
	</div>

<?php
	if(isset($_POST['action'])) {
		unset($_POST['submit']);
		
		$mobile_id = intval($_POST['mobile_id']);
		$action = $_POST['action'];
		unset($_POST['action']);

		if($action == 'update') {
			$data = $wpdb->escape($_POST);
			if($_POST['theme_template']) {
				$data['redirect'] = '';
			}
			unset($_POST);
			
			if(null == $wpdb->get_row("SELECT * FROM ".TABLE_MOBILEMETA." WHERE `mobile_id`=$mobile_id")) {
				$wpdb->insert(TABLE_MOBILEMETA, $data);
			} else {
				
				$wpdb->update(TABLE_MOBILEMETA, $data, array('mobile_id'=>$mobile_id));
			}

			echo '<div id="message" class="updated fade"><p><strong>Settings saved.</strong></p></div>';
		} else if($action == 'delete') {
			$mobile = $wpdb->get_row("SELECT `is_system_mobile` FROM ".TABLE_MOBILES." WHERE `mobile_id`=$mobile_id");
			
			if($mobile->is_system_mobile == '0') {
				$wpdb->query("DELETE FROM `".TABLE_MOBILEMETA."` WHERE `mobile_id`=$mobile_id");
				$wpdb->query("DELETE FROM `".TABLE_MOBILES."` WHERE `mobile_id`=$mobile_id");
			}
		}
	}

	$mobiles = md_get_mobiles();
?>
		<table class="widefat post fixed" cellspacing="0">
			<thead>
				<tr>
					<th class="manage-column" scope="col" width="160">Devices</th>
					<th class="manage-column" scope="col" width="150">Mobile Themes</th>
				</tr>
			</thead>
			
			<tr valign="top" class="<?php echo $rowclass; ?> author-self status-publish iedit">
				<th scope="row">iPhone/iPod/iTouch</th>
				<td>ajaxit</td>
			</tr>
			
			<tr valign="top" class="<?php echo $rowclass; ?> author-self status-publish iedit">
				<th scope="row">iPad</th>
				<td>ajaxit</td>
			</tr>
			
			<tr valign="top" class="<?php echo $rowclass; ?> author-self status-publish iedit">
				<th scope="row">Android</th>
				<td>ajaxit</td>
			</tr>
			
			<tfoot>
				<tr>
					<th class="manage-column" scope="col">Devices</th>
					<th class="manage-column" scope="col">Mobile Themes</th>
				</tr>
			</tfoot>
		
		</table>

</div>
<?php
}
?>