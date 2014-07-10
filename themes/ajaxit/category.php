<?php
	//960 × 640	 iphone retina //480 × 320  iphone older
	$cat_title = single_cat_title('', false);
	$category_id = get_cat_ID( $cat_title );
	$xcat    = ''; 
	if ( $_GET["c"] ) { 
		$xcat    = $_GET["c"]; 
		//echo '<script> alert("'. $xcat .'"); </script>';
	}
	
	if ( $xcat == 'desktop' ) {
		//--------user has requested to view desktop version
		session_start();
		// store session data
		$_SESSION['desktop'] = '1';
		$_SESSION['CREATED'] = time();  // update creation time
		echo '{"category_title":"desktopset","category_id":"0"}';
		
	} else {
		//echo $cat_title .'<BR>';
		//echo $category_id .'boom<BR>';
		//echo TEMPLATEPATH . '/index.php<BR>';
		include (TEMPLATEPATH . '/index.php');
	}
	
?>
