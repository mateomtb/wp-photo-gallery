<?php
/**
 * Plugin Name: DFM Site Data Manager
 * Description: Create DB table of DFM data for all sites. Adds static functions to query resulting table.
 * Version: 1.0
 * Author: Josh Kozlowski
 * Author Contact : joshuamkozlowski@gmail.com
 * License: TBD
**/

interface DFMDataForWPConfig {
	// !!!!
	// There are no safeguards against overwriting another table with this name
	// No WP prefix 
	// Only alphanumeric and underscores allowed in name
	const MASTER_TABLE = 'dfm_master_site_data';
	// !!!!
	// !!!!
	// !!!!
	// !!!!
}

interface DFMDataForWPInterface extends DFMDataForWPConfig {
	// Creates table with const MASTER_TABLE as name
	// Called when plugin activated
	public static function createDFMMasterDataTable();
	
	// Deletes table with const MASTER_TABLE as name
	// Called when plugin deactivated
	public static function destroyDFMMasterDataTable();

	// Query functions
	// If you know the name of each column, you can query them specifically
	
	// DFMDataForWP::retrieveValueFromMasterData('zip_code', 'domain', 'denverpost'));
	// returns "80203" 
	public static function retrieveValueFromMasterData($select, $where, $whereValue);
	
	// DFMDataForWP::retrieveRowFromMasterData('domain', 'denverpost'));
	// returns an associative array of all data for the Denver Post
	public static function retrieveRowFromMasterData($where, $whereValue);
}

// Singleton for creating DB, and associated query functions to access fields and rows
class DFMDataForWP implements DFMDataForWPInterface {
	
	const ERROR_MESSAGE = 'Something went wrong creating the table. Check logs for MYSQL errors.';
	// Becomes true when Settings page update is being used
	// so that error handling proceeds differently
	protected static $updating = false;
	
	private function getFieldNamesandDataAsArrays() {
		
		// Idea is to always return an array like this: [fieldNamesAsArray, rowsOfDataAsArrays]
		$dataSource = new DFMDataHelper();
		$dataSource->setSiteDataFile(dirname(__FILE__) . '/includes/' . 'dfm_site_data.txt');
		$dataSource->setSiteDataFileDataDelimiter('|||');
		if ($data = $dataSource->createDataArraysFromSiteFile()) {
			if (!$data[0] || !$data[1]) {
				error_log("There's a problem with the data source. Is the data structured properly?");
				return false;
			}
			return $data;
		}
		else {
			return false;
		}
	}
	
	public static function createDFMMasterDataTable() {

		// This is run when the plugin is activated and creates (overwrites) table in WP DB
		// Table created with WP in mind
		$tableName = self::tableName();
		// We will try to create the table with the temp name in case there are errors
		// If table creation succeeds, it will be to const MASTER_TABLE
		// Random table name used to avoid unlikely overwrites
		$tempTableName = (string) ('A_TEMP_TABLE_' . rand(1, 10000000));
		$sqlFieldsStr = ''; // Will be looped into rows in table creation
		$sql = ''; // various SQL statements below
		$fieldNamesAndRows = self::getFieldNamesandDataAsArrays();
		
		// WordPress DB prep
		//self::includeRequired();
		global $wpdb;
		
		// Create string for structure of table
		foreach($fieldNamesAndRows[0] as &$field) {
			// Clean up the field names just in case
			// All values are lower case already
			$field = self::cleanString($field);
			$sqlFieldsStr .= "$field text NOT NULL,\n";
		}
		
		// Create temp table
		$sql = "CREATE TABLE $tempTableName (" .
		"id mediumint(9) NOT NULL AUTO_INCREMENT," .
		$sqlFieldsStr . 
		"UNIQUE KEY id (id)
		) CHARACTER SET utf8 COLLATE utf8_general_ci;";
		$createTable = $wpdb->query($sql);
		if ($createTable === false) {
			self::tableCreationError();
			if (self::$updating) {
				return false;
			}
			die();
		}
		
		// Insert all of the data into the temprorary table
		foreach ($fieldNamesAndRows[1] as $data) {
			$insertArray = array_combine($fieldNamesAndRows[0], $data);
			$insert = $wpdb->insert($tempTableName, $insertArray);
			if (!$insert) {
				// Drop temp table and die if something went wrong with any insert
				self::tableCreationError();
				$sql = "DROP TABLE IF EXISTS $tempTableName";
				$dropTable = $wpdb->query($sql);
				if (self::$updating) {
					return false;
				}
				die();
			}
		}
		
		// If everything succeeded, rename table and drop any existing version of master table
		self::destroyDFMMasterDataTable();
		$sql = "RENAME TABLE $tempTableName TO $tableName";
		$renameTable = $wpdb->query($sql);
		// Everything worked
		return true;
	}
	
	public static function destroyDFMMasterDataTable() {
		//self::includeRequired();
		global $wpdb;
		$tableName = self::tableName();
		$sql = "DROP TABLE IF EXISTS $tableName";
		$dropTable = $wpdb->query("DROP TABLE IF EXISTS $tableName");
	}
	
	private static function tableName() {
		return self::cleanString(self::MASTER_TABLE);
	}
	
	private static function tableCreationError() {
		error_log(self::ERROR_MESSAGE);
	}
	
	private static function includeRequired() {
		//require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
	}

	// Safeguard
	private function cleanString($string) {
		return preg_replace('/[^0-9A-Za-z\_]/', '', $string);
	}
	
	

	// Query functions
	public static function retrieveValueFromMasterData($select, $where, $whereValue){
		// WP get_var using statement, SELECT $select FROM $table WHERE $where = $whereValue
		global $wpdb;
		$select = self::cleanString($select);
		$where = self::cleanString($where);
		$table = self::cleanString(self::MASTER_TABLE);
		$result = $wpdb->get_var($wpdb->prepare("SELECT $select FROM $table WHERE $where = %s", $whereValue));
		return $result;
	}

	public static function retrieveRowFromMasterData($where, $whereValue){
		// WP get_row using statement, SELECT * FROM $table WHERE $where = $whereValue
		global $wpdb;
		$where = self::cleanString($where);
		$table = self::cleanString(self::MASTER_TABLE);
		$result =  $wpdb->get_row($wpdb->prepare("SELECT * FROM $table WHERE $where = %s", $whereValue), ARRAY_A);
		return $result;
	}
}

class DFMDataHelper {
	
	private $siteDataFile;
	private $siteDataFileDataDelimiter;
	
	public function setSiteDataFile($file) {
		$this->siteDataFile = $file;
	}
	
	public function setSiteDataFileDataDelimiter($delimiter) {
		$this->siteDataFileDataDelimiter = $delimiter;
	}
	
	public function createDataArraysFromSiteFile() {
		
		// For now we are using a text file generated by an external script as the source of the DB table
		// Each row of the text file must be a new line.
		// First row must be the field/column names
		// This function will return a 2-item array. 
		// The first item is a simple array of all field names
		// The second item is an array of all data as arrays that match the index of the field names
		// Any future method that recreates this array structure will be easy to plug and play
		$fileNameAndPath = $this->siteDataFile;
		$delimiter = $this->siteDataFileDataDelimiter;
		
		if (!$fileNameAndPath || !$delimiter) {
			error_log("You need to specify a file and/or data delimiter");
			return false;
		}

		// Data from file
		$sitesInfo = file($fileNameAndPath, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
		
		// Will contain all data rows as arrays
		$rowsOfAllDataAsArrays = array();
		// First row of current data structure are field names
		$fieldNames = str_replace(" ", "_", explode($delimiter, $sitesInfo[0]));
		// Create array of field names
		$fieldNamesArray = array_map('strtolower', $fieldNames);
		// Loop through all rows besides field names (first row)
		foreach (array_slice($sitesInfo, 1) as $rowOfData) {
			$rowOFDataAsArray = explode($delimiter, $rowOfData); 
			if (count($rowOFDataAsArray) !== count($fieldNamesArray)) {
				error_log('The row of data starting with ' . $rowOfDataAsArray[0] .
					' does not have the same number of values as there are field names.');
				return false;
			}
			$rowsOfAllDataAsArrays[] = $rowOFDataAsArray;
		}
		return array($fieldNamesArray, $rowsOfAllDataAsArrays);
	}
}

class DFMDataForWPGUI extends DFMDataForWP {
	// GUI
	// No error handling
	private $pluginId;
	private $optionsPageInfo;
	private $queryVar;
	private $updatedHTML;
	private $errorHTML;
	
	public function setPluginId($id) {
		$this->pluginId = $id;
	}
	
	public function setOptionsPageInfo($optionsArray) {
		$this->optionsPageInfo = $optionsArray;
	}
	
	public function setQueryVar($var) {
		$this->queryVar = $var;
	}
	
	public function setUpdatedHTML($html) {
		$this->updatedHTML = $html;
	}
	
	public function setErrorHtml($html){
		$this->errorHTML = $html;
	}
	
	public function updateMasterDataTable() {
		add_options_page($this->optionsPageInfo[0], $this->optionsPageInfo[1], 'manage_options', $this->pluginId, array($this, 'pluginOptions'));
	}

	public function pluginOptions() {
		if (!current_user_can('manage_options'))  {
			wp_die( __('You do not have sufficient permissions to access this page.'));
		}
		if ($_REQUEST[$this->queryVar]) {
			DFMDataForWP::$updating = true;
			if ($DBUpdatedSuccess = self::createDFMMasterDataTable()) {
				echo $this->updatedHTML;
				return true;
			}
			else {
				echo $this->errorHTML;
				return false;
			}
		}
		// Open to ideas for best way to set this HTML with setter or something
		?>
		<div class="wrap">
			<form name="form1" method="post" action="options-general.php?page=<?php echo $this->pluginId . '&' . $this->queryVar;?>=true">
			<p class="submit">
			<input type="submit" name="Submit" class="button-primary" value="<?php esc_attr_e('Update DB') ?>" />
			</p>
			</form>
		</div>
	<?php
	}
}

// Use classes in WordPress here 

// Creates DB when activating plugin (WILL OVERWRITE OLD)
register_activation_hook(__FILE__, array('DFMDataForWP', 'createDFMMasterDataTable'));

register_deactivation_hook(__FILE__, array('DFMDataForWP', 'destroyDFMMasterDataTable'));

// For GUI
$gui = new DFMDataForWPGUI();
// $menu_slug from http://codex.wordpress.org/Function_Reference/add_options_page
$gui->setPluginId('DFMMasterDataUpdater');
// $page_title and $menu_title from http://codex.wordpress.org/Function_Reference/add_options_page
$gui->setOptionsPageInfo(array('Update DFM Master Data', 'DFM WP Data Manager'));
// passed to form action update page
$gui->setQueryVar('updateMasterDB'); 
// HTML returned when page is updated
$gui->setUpdatedHTML('<div class="wrap">Master Data Table updated!</div>');
// HTML returned if there is an error updating the table
$gui->setErrorHTML('<div class="wrap">Something went wrong! Check the PHP error log.</div>');

add_action('admin_menu', array($gui, 'updateMasterDataTable'));

?>