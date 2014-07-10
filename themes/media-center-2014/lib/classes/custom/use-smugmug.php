<?php

/* Media Center */

if (class_exists('SmugMugDeps')) {
	
	class UseSmug extends SmugMugDeps {
	
		// SmugMugDeps currently found in plugins/dfm-wp-photogallery/dfm-wp-photogallery.php 
	
		function __construct($smugData) {
			$this->smugData = $smugData;
			//$this->setSmugCache('/tmp/');
		}
	
		public function smugImage(){
			if ($this->smugData) {
				$size = func_get_args();
				if ( isset($size[0]) ) {
					$size = $size[0];
					$this->smugMugImageCustomSizeString = "CustomSize=$size";
					$smugPackage = $this->smugMugPackage();
					$image = $smugPackage[0]['images'][0]["CustomURL"];
				}
				else {
					$smugPackage = $this->smugMugPackage();
					$image = $smugPackage[0]['images'][0]["LargeURL"];
				}
				return $image;
			}
		}
	}
	
}
/* End Media Center */

?>
