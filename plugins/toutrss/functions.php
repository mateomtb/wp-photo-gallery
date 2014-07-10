<?php 

function dfmMatrix (){
    $sites_info = file((dirname(__FILE__) . '/includes/dfm_site_data.txt'), FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
    //var_dump($sites_info);
    $keylistsort = str_replace(" ", "_", explode("|||", $sites_info[0])); //make the list of keys from spreadsheet column names
    //var_dump($sites_info);
    $keylist = array_map('strtolower', $keylistsort);
	//$count1 = count($keylist);
	//$count2 = count($items);
	
    foreach ($sites_info as $property) {
        $items = explode("|||", $property);//get all spreadsheet values into an array
		$count1 = count($keylist);
		$count2 = count($items);
				
		//if($count1 != $count2){
		//echo "Count does not match";
		//}
		
		//if($count1 == $count2){
		//echo "LIES!!!!!!!!!!!!!!!!!!!!!!!";
		//}
		//echo "The keylist count is" . $count1 . "The item count is" . $count2; 	
        //var_dump($items);
        $property_bykeys[] = @array_combine($keylist, $items);
        }
        foreach ($property_bykeys as $url) {
        $proplist_byurl[] = $url["domain"]; 
        }
        $finalmix = array_combine($proplist_byurl, $property_bykeys);
        //var_dump($finalmix);
        return $finalmix;
    }

function DetermineParentCompany($existingconfig) {
    //find out the domain name of the site we are currently on
 
	if(isset($_SERVER['QUERY_STRING'])){
    $domain_bits = explode('=', $_SERVER['QUERY_STRING']);
	if (strpos($domain_bits[1], "&") != FALSE ) {
	$domain_bits[1] = substr($domain_bits[1], 0, strpos($domain_bits[1], "&"));
	}
	//echo 'THE DOMAIN IS ';
	//var_dump ($domain_bits);
	$domain = $domain_bits[1];
	}	
	//else {
    // $domain_bits = explode('.', $_SERVER['HTTP_HOST']);
	//}
	
    if ($domain_bits[0] == 'photos' || $domain_bits[0] == 'media' || $domain_bits[0] == 'mediacenter' || $domain_bits[0] == 'extra'){
        $domain = $domain_bits[1];      
    }
    //else {
	//      $domain_bits = explode('/', $_SERVER['REQUEST_URI']);
	//      $domain = str_replace('-', '', $domain_bits[1]);
    // } 
    //echo $domain; 
    //if ($_SERVER['HTTP_HOST'] == 'localhost' || $_SERVER['HTTP_REFERER'] == 'localhost' || $_SERVER['HTTP_HOST'] == 'bhenderson' || $_SERVER['HTTP_REFERER'] == 'bhenderson' || $_SERVER['HTTP_HOST'] == 'devserver' || $_SERVER['HTTP_REFERER'] == 'devserver' || $_SERVER['HTTP_HOST'] == '173.45.227.56' || $_SERVER['HTTP_REFERER'] == '173.45.227.56') $domain = 'denverpost';
	//var_dump ($domain_bits);
	//echo 'THE DOMAIN IS' . $domain;
    //check if site array config passed to the function is valid for the domain we are currently on. If it's different swictch to the proper array confi 9-20-12 -mateo
    session_start();
    
    //if(is_array($existingconfig) && $finalmix["domain"] == $domain){
    //    echo "finalmix is here, domain is set to " . $domain;
        //var_dump($finalmix);
    //    return $finalmix;
    //    }
    //else
    //    {               
    //in case the text file was saved from a mac.
    ini_set("auto_detect_line_endings", true);
    // These txt files have info about our sites.
    $mng_sites = array_map('strtolower', file((dirname(__FILE__) . '/includes/mngi_sites.txt'), FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES));//list of all mng sites 
    $jrc_sites = array_map('strtolower', file((dirname(__FILE__) . '/includes/jrc_sites.txt'), FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES));// list of all jrc sites
    
    //this text file now contians all the info about every site, including the above. 
    $sites_info = array_map('strtolower', file((dirname(__FILE__) . '/includes/dfm_site_data.txt'), FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES));

    
    //create an array from the dfm_site_data.txt file
    //$property_bykeys = array();//Store all properies info by key index
    //$proplist_byurl = array();//Store all properties with url as key index
    //$finalmix = array();//Combine both to have a complete array searchable by url and keys for all values in spreadsheet
    $keylist = str_replace(" ", "_", explode("|||", $sites_info[0])); //make the list of keys from spreadsheet column names

    $finalmix = dfmMatrix();
    //var_dump($finalmix);musi
    
// legacy if statements to compare the mng and jrc text file lists to detrmine company affiliation for ad tags etc..
    /****** Find out if the domain of this site is a JRC or MNGI property  mateo 6_7_2012 ******/
    if ( in_array($domain, $mng_sites) == TRUE ) {
        $parent_company= "mngi";
        $apt_leader_path= "mngi_apt_leader.html";
        //$_SESSION['parent_company']= "mngi";
        //$_SESSION['apt_leader_path']= "mngi_apt_leader.html";
        //echo "it's mngi!";
    } elseif ( in_array($domain, $jrc_sites) == TRUE ) {
        $parent_company= "jrc";
        $apt_leader_path= "jrc_apt_leader.html";
        //$_SESSION['parent_company']= "jrc";
        //$_SESSION['apt_leader_path']= "jrc_apt_leader.html";
        //echo "it's jrc!";
    } else {
        //error_log("No matches found for property name " . $domain, 0);
        //echo "error message for matt";
    }

    $_SESSION['parent_company'] = $parent_company;//legacy var to id mng or jrc property 9-19-12 - mateo
    $_SESSION['apt_leader_path'] = $apt_leader_path;//legacy var to use mng or jrc style ad tags 9-19-12 - mateo
    $_SESSION['siteconfig'] = $finalmix[$domain];//the master var that is an array of all the config values a site may need, including the above which we should update someday 9-19-12 - mateo
//    var_dump($finalmix[$domain]);
    return $finalmix[$domain];

    //}
}
?>
