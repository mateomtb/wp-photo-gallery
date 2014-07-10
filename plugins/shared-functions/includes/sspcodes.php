<?php
//------------------Please make sure you turn SSP debugging to false (3rd parameter) 

switch ($api) {
    case "dp":
        $director = new Director('hosted-ec5968d1bc7bc366d67ef8a87fd69909', 'dpphoto.slideshowpro.com', false);
        $director->cache->set('mc_dp', '+10 minutes');
        break;
    case "captured":
        $director = new Director('hosted-4f77020e8274f637f878c2224c753770', 'denverpost.slideshowpro.com', false);
        $director->cache->set('mc_captured', '+10 minutes');
        break;
	case "seen":
        $director = new Director('hosted-4f77020e8274f637f878c2224c753770', 'denverpost.slideshowpro.com', false);
        $director->cache->set('mc_seen', '+10 minutes');
        break;
    case "reverb":
        $director = new Director('hosted-9c9cf54218f185433472b1e031a9b8c3', 'reverb.slideshowpro.com', false);
        $director->cache->set('mc_reverb', '+10 minutes');
        break;
	case "newmc":
        $director = new Director('hosted-5f1907e0ef82c8203250bd7ac2733f0c', 'mcenter.slideshowpro.com', false);
        $director->cache->set('mc_newmc', '+10 minutes');
        break;
    case "tcmc":
        $director = new Director('local-a2a59137c0a5b30e8b291c698126e167', 'photo.twincities.com/ssp', false);
        $director->cache->set('mc_tcmc', '+10 minutes');
        break;
   	case "tcmc2":
		$director = new Director('hosted-aa219310cfe390c8fe2d9a424fb8de42', 'twincities.slideshowpro.com', false);
		$director->cache->set('mc_tcmc2', '+10 minutes');
	    break;
	case "tcmc3":
		$director = new Director('local-118e16b22476f2d9b1f51e4b92a6a7d2', 'director.twincities.com', false);
		$director->cache->set('mc_tcmc3', '+10 minutes');
	    break;
    case "dpmc":
        $director = new Director('local-904d36b9b89af2bbd00b046bd1ffa3aa', 'director.denverpost.com', false);
        $director->cache->set('mc_dpmc', '+10 minutes');
        break;
    case "epmc":
        $director = new Director('local-70926b0a95cb7b8be468c24ebbe16b47', 'director.elpasotimes.com', false);
        $director->cache->set('mc_epmc', '+10 minutes');
        break;    
    case "dtmc":
        $director = new Director('local-1b2c777a6c5be1edcbda99d11392f8e9', 'director.daily-times.com', false);
        $director->cache->set('mc_dtmc', '+10 minutes');
        break;
    case "lcmc":
        $director = new Director('local-04db8094035d38842debf2b701b85556', 'director.lcsun-news.com', false);
        $director->cache->set('mc_lcmc', '+10 minutes');
        break;
	case "metro":
        $director = new Director('local-cc94149216b861fa419a89976fa7afc9', 'director-lang-ieng.medianewsgroup.com', false);
        $director->cache->set('mc_metro', '+10 minutes');
        break;
    case "sgvn":
        $director = new Director('local-9ab1f662b717bcebb35f130a3398d828', 'director-lang-sgvn.medianewsgroup.com', false);
        $director->cache->set('mc_sgvn', '+10 minutes');
        break;
    case "ieng":
    //echo "ieng";
        $director = new Director('local-db5c88a3ffb1ba26a80faf1c579f0cf9', 'director-lang-metro.medianewsgroup.com', false);
        $director->cache->set('mc_ieng', '+10 minutes');
        break;  
    case "merc":
        $director = new Director('hosted-3cdd36deb8721ca583438e67f06b5778', 'mercphotos.slideshowpro.com', false);
        $director->cache->set('mc_merc', '+10 minutes');
        break;
    case "merc2":
        $director = new Director('local-522ea8e0654fc3e7584aa809d68862cb', 'director.mercurynews.com', false);
        $director->cache->set('mc_merc2', '+10 minutes');
        break;
	case "newhaven":
		$director = new Director('hosted-3abd9ca6bf50a5d3b978a7b64cfeb97d', 'nhregister.slideshowpro.com', false);
		$director->cache->set('mc_newhaven', '+10 minutes');
		break;
    default:
		$director = new Director('hosted-ec5968d1bc7bc366d67ef8a87fd69909', 'dpphoto.slideshowpro.com', false);
		$director->cache->set('mc_default', '+10 minutes');
}

?>