<?php
if(!function_exists('md_install')){
	/**
	 * Initialize the plugin.
	 *
	 * @since 1.0
	 */
	function md_install()
	{
		global $table_prefix, $wpdb;
		
		/*
		//http://christoper-johnsons-macbook-pro.local/mediacenter/
		$table_mobiles = $table_prefix."md_mobiles";

		$table_mobilemeta = $table_prefix."md_mobilemeta";

		$sql1 = "
		
		CREATE TABLE `$table_mobiles` (
		  `mobile_id` int(11) NOT NULL auto_increment,
		  `mobile_name` varchar(255) NOT NULL default '',
		  `mobile_agent` varchar(255) NOT NULL default '',
		  `is_system_mobile` tinyint(1) NOT NULL default '0',
		  PRIMARY KEY  (mobile_id)
		);";
		//DBCC CHECKIDENT(MyTableName, RESEED, 0)
		$sql2 = "

		CREATE TABLE `$table_mobilemeta` (
		  `mobile_id` int(11) NOT NULL,
		  `theme_template` varchar(255) NOT NULL default '',
		  `redirect` varchar(255) NULL,
		  PRIMARY KEY  (mobile_id)
		);";
		
		require_once(ABSPATH . 'wp-admin/upgrade-functions.php');

		dbDelta($sql1);

		dbDelta($sql2);
		
		$insert_mobile = "DELETE FROM `$table_mobiles` WHERE 1";
		$wpdb->query($insert_mobile);
		
		$insert_mobile = "INSERT INTO `$table_mobiles` (`mobile_id`, `mobile_name`,`mobile_agent`, `is_system_mobile`)VALUES
		(1, 'iPhone/iPod', 'iPhone|iPod|aspen|webmate', 1),
		(2, 'Apple iPad', 'ipad|iPad', 0),
		(3, 'Android','android|dream|cupcake', 0)";
		$wpdb->query($insert_mobile);
		*/
		
		/*
		$insert_mobile = "INSERT INTO `$table_mobiles` (`mobile_name`, `mobile_agent`, `is_system_mobile`)VALUES
		('iPhone/iPod', 'iPhone|iPod|aspen|webmate', 1),
		('Android','android|dream|cupcake', 1),
		('BlackBerry Storm','blackberry9500|blackberry9530', 1),
		('Nokia','series60|series40|nokia|Nokia', 1),
		('Apple iPad', 'ipad|iPad', 0),	
		('Opera','opera mini|Opera',0),
		('Palm','pre\/|palm os|palm|hiptop|avantgo|plucker|xiino|blazer|elaine',0),
		('Palmer','xiasdfasdfino|bsdfsdflazer|eladfsdfine',0),
		('Windows Smartphone','iris|3g_t|windows ce|opera mobi|windows ce; smartphone;|windows ce; iemobile',0),
		('Blackberry','blackberry|Blackberry',0)";
		*/
		
		//if(!$wpdb->get_results("SELECT * FROM `$table_mobiles`"))
		
		
		//$insert_mobile = "DELETE FROM `$table_mobilemeta` WHERE 1";
		//$wpdb->query($insert_mobile);
		
		//------------below is added by chris johnson adding the mobile template settings that we want.
		//INSERT INTO `wp_md_mobilemeta` VALUES(1, 'webkit', '');
		//INSERT INTO `wp_md_mobilemeta` VALUES(5, 'webkit', '');
		//$insert_mobile = "INSERT INTO `$table_mobilemeta` VALUES(1, 'iphone', '')";
		//if(!$wpdb->get_results("SELECT * FROM `$table_mobilemeta`"))
		//$wpdb->query($insert_mobile);
			
		//$insert_mobilepad = "INSERT INTO `$table_mobilemeta` VALUES(5, 'ipad', '')";
		//if(!$wpdb->get_results("SELECT * FROM `$table_mobilemeta`"))
		
		/*
		$insert_mobile = "INSERT INTO `$table_mobilemeta` (`mobile_id`, `theme_template` ) VALUES
		(1, 'iphone'),
		(2, 'ipad')";
		
		
		$insert_mobile = "INSERT INTO `$table_mobilemeta` (`mobile_id`, `theme_template` ) VALUES
		(1, 'ajaxit'),
		(2, 'ajaxit'),
		(3, 'ajaxit')";
		
		$wpdb->query($insert_mobile);
		*/
		//------------below is added by chris johnson adding the mobile template settings that we want. (end)
	}
}

if(!function_exists('md_uninstall')) {
	/**
	 * Uninstallation of plugin.
	 *
	 * @since 1.0
	 */
	function md_uninstall()
	{
		global $table_prefix, $wpdb;

		$table_mobiles = $table_prefix."md_mobiles";
		$table_mobilemeta = $table_prefix."md_mobilemeta";

		$sql1 = "DROP TABLE `$table_mobiles`";
		$sql2 = "DROP TABLE `$table_mobilemeta`";

		require_once(ABSPATH . 'wp-admin/upgrade-functions.php');

		dbDelta($sql1);
		dbDelta($sql2);
	}
}

if(!function_exists('md_pluginversion')) {
	/**
	 * The plugin version.
	 *
	 * @since 1.0
	 * @return string Plugin version
	 */
	function md_pluginversion(){
		$md_plugin_data = implode('', file(dirname(dirname(__FILE__)).'/mobiledetector.php'));
		if (preg_match("|Version:(.*)|i", $md_plugin_data, $version)) {
				$version = $version[1];
		}
		return $version;
	}
}

if(!function_exists('md_pluginname')) {
	/**
	 * The plugin name.
	 *
	 * @since 1.0
	 * @return string Plugin name
	 */
	function md_pluginname()
	{
		$md_plugin_data = implode('', file(dirname(dirname(__FILE__)).'/mobiledetector.php'));
		if (preg_match("|Plugin\sName:(.*)|i", $md_plugin_data, $pluginname)) {
				$pluginname = $pluginname[1];
		}
		return $pluginname;
	}
}

/*
function md_get_mobiles(){
	global $wpdb;

	$sql = "SELECT * FROM `".TABLE_MOBILES."`";
	//print_r ( $wpdb->get_results($sql) );
	die('bing<BR><BR>wtap die md_get_mobiles');
	return $wpdb->get_results($sql);
}

function md_user_agent()
{
	global $wpdb;
	$user_agents = array();

	$sql = "SELECT `mobile_id`,`mobile_agent` FROM `".TABLE_MOBILES."`";
	$mobiles = $wpdb->get_results($sql);

	foreach($mobiles as $mobile) {
		$user_agents[$mobile->mobile_id] = $mobile->mobile_agent;
	}
	die('wtap die md_user_agent');
	return $user_agents;
}
*/

if(!function_exists('get_mobile_themes')) {
	/**
	 * Retrieve list of mobile themes with theme data in theme directory.
	 *
	 * @since 1.0
	 * @global array $wptap_mobile_themes Stores the working mobile themes.
	 *
	 * @return array Mobile Theme list with theme data.
	 */

	 function get_mobile_themes()
	 {
		if(!function_exists('get_themes'))
			return null;
		
		return $wp_themes = get_themes();

		/*foreach($wp_themes as $name=>$theme) {
			$stylish_dir = $wp_themes[$name]['Stylesheet Dir'];

			if(is_file($stylish_dir.'/style.css')) {
				$theme_data = get_theme_data($stylish_dir.'/style.css');
				$tags = $theme_data['Tags'];

				foreach($tags as $tag) {
					if(eregi('Mobile Theme', $tag) || eregi('WPtap', $tag)) {
						$wptap_mobile_themes[$name] = $theme;
						break;
					}
				}
			}
		}

		return $wptap_mobile_themes;*/
	 }
}

function switchTheme($theme) {
	$theme = 'ajaxit';
	return $theme;
}

function switchStyleSheet($theme) {
	
	if(strpos($_SERVER['HTTP_USER_AGENT'], 'iPad') !== false) {
		//echo "ipad!";
		$theme = "ajaxit";
	} else 	if(strpos($_SERVER['HTTP_USER_AGENT'], 'iPhone') !== false) {
		//echo "iPhone!";
		$theme = "ajaxit";
	} else 	if(strpos($_SERVER['HTTP_USER_AGENT'], 'Android') !== false) {
		//echo "Android!";
		$theme = "ajaxit";
		
	} else {
		$theme = 'default';
	}
	
	return $theme;
}

/**
 * Detect user agent.
 *
 * @since 1.0
 */
function mobileDetect() {
	
	//-----------------------------------------desktop version
	session_start();
	if (isset($_SESSION['desktop'])) {
		//--- they have set desktop on
		//now make sure its not old
		if (time() - $_SESSION['CREATED'] > 30) {
			//session is expired - 1 minute = 60, 1800 = 1/2 hour, 3600 = hour
			session_destroy();   // destroy session data in storage
			session_unset();     // unset $_SESSION variable for the runtime
		} else {
			//session is still good
			//session_regenerate_id(true);    // change session ID for the current session an invalidate old session ID
		    return '';
		}
		
		/*
		if (!isset($_SESSION['CREATED'])) {
		    $_SESSION['CREATED'] = time();
		} else if (time() - $_SESSION['CREATED'] > 60) {
		    // session started more than 1 minute ago
		    session_regenerate_id(true);    // change session ID for the current session an invalidate old session ID
		    $_SESSION['CREATED'] = time();  // update creation time
		}
		
		if ( $_SESSION['desktop'] == '1' ) {
			
		}
		*/
		
	}
	//-----------------------------------------desktop version
	
	if(strpos($_SERVER['HTTP_USER_AGENT'], 'iPad') !== false) {
		//echo "ipad2!";
		return "ipad";
	} else 	if(strpos($_SERVER['HTTP_USER_AGENT'], 'iPhone') !== false) {
		//echo "iPhone2!";
		return "iphone";
	} else 	if(strpos($_SERVER['HTTP_USER_AGENT'], 'Android') !== false) {
		//echo "Android2!";
		
		if(strpos($_SERVER['HTTP_USER_AGENT'], 'Firefox') !== false) {
			//Mozilla/5.0 (Android; Mobile; rv:14.0 Firefox/14.0.1
			//on android mobile Firefox:
			if(strpos($_SERVER['HTTP_USER_AGENT'], ' rv:') !== false) {
				$androidVersion = explode(" rv:", $_SERVER['HTTP_USER_AGENT']);
				$androidVersion = explode(".", $androidVersion[1]);
				//only works on Android 2.2 or greater for FF 12.0 and above
				if ( $androidVersion >= 12 ) {
					return "android";
				}
			}
				
		} else {
			//Mozilla/5.0 (Linux; U; Android 1.6; en-us; sdk Build/Donut) AppleWebKit/528.5+ (KHTML, like Gecko) Version/3.1.2 Mobile Safari/525.20.1   (emulator DOES NOT LOAD css)
			$androidVersion = explode("Android ", $_SERVER['HTTP_USER_AGENT']);$androidVersion = explode(";", $androidVersion[1]);$androidVersion = $androidVersion[0];
			if ( $androidVersion < 2.1 ) {
				//this is an old version of Android - css wont work, so send regular desktop until I can fix
			} else {
				return "android";
			}
		}
		

		
		
	}
	
	
	/*
	global $wpdb;

	$container = $_SERVER['HTTP_USER_AGENT'];
	$useragents = md_user_agent();
	$mobile_current_id = null;

	foreach ($useragents as $mobile_id => $useragent) {
		$useragent = explode('|', $useragent);
		
		foreach($useragent as $agent) {
			if (eregi($agent, $container)) {
				$mobile_current_id = $mobile_id;
				break;
			}
		}
	}

	$mobilemeta = $wpdb->get_row("SELECT `theme_template`,`redirect` FROM `".TABLE_MOBILEMETA."` WHERE `mobile_id`=$mobile_current_id");
	//echo "laser: ".$mobilemeta->theme_template;
	//$theme = $options['mobile_theme'];
	if($mobilemeta->redirect) {
		header("Location: $mobilemeta->redirect");
		//echo "REDIREDCT: ". $mobilemeta->redirect;
		exit;
	}

	return $mobilemeta->theme_template;
	*/
}
?>