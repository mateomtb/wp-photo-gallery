<?php
die('this is a very old sppcodes file... get rid of it');

//----------------ALERT this function has been replaced by /library/director_keys/sspcodes.php
switch ($api) {
    case "dp":
        $director = new Director('hosted-ec5968d1bc7bc366d67ef8a87fd69909', 'dpphoto.slideshowpro.com');
        break;
    case "captured":
        $director = new Director('hosted-4f77020e8274f637f878c2224c753770', 'denverpost.slideshowpro.com');
        break;
	case "seen":
        $director = new Director('hosted-4f77020e8274f637f878c2224c753770', 'denverpost.slideshowpro.com');
        break;
    case "reverb":
	//echo "reverb";
        $director = new Director('hosted-9c9cf54218f185433472b1e031a9b8c3', 'reverb.slideshowpro.com');
        break;
	case "newmc":
        $director = new Director('hosted-5f1907e0ef82c8203250bd7ac2733f0c', 'mcenter.slideshowpro.com');
        break;
    case "tcmc":
        $director = new Director('local-a2a59137c0a5b30e8b291c698126e167', 'photo.twincities.com/ssp');
        break; 
    case "tcmc2":
        $director = new Director('hosted-aa219310cfe390c8fe2d9a424fb8de42', 'twincities.slideshowpro.com');
        break;   
    default:
       $director = new Director('hosted-ec5968d1bc7bc366d67ef8a87fd69909', 'dpphoto.slideshowpro.com');
}
?>