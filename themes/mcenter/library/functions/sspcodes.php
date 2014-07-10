<?php

switch ($api) {
    case "dp":
        $director = new Director('hosted-ec5968d1bc7bc366d67ef8a87fd69909', 'dpphoto.slideshowpro.com');
        $director->cache->set('mc_dp', '+10 minutes');
        break;
    case "captured":
        $director = new Director('hosted-4f77020e8274f637f878c2224c753770', 'denverpost.slideshowpro.com');
        $director->cache->set('mc_captured', '+10 minutes');
        break;
	case "seen":
        $director = new Director('hosted-4f77020e8274f637f878c2224c753770', 'denverpost.slideshowpro.com');
        $director->cache->set('mc_seen', '+10 minutes');
        break;
    case "reverb":
        $director = new Director('hosted-9c9cf54218f185433472b1e031a9b8c3', 'reverb.slideshowpro.com');
        $director->cache->set('mc_reverb', '+10 minutes');
        break;
	case "newmc":
        $director = new Director('hosted-5f1907e0ef82c8203250bd7ac2733f0c', 'mcenter.slideshowpro.com');
        $director->cache->set('mc_newmc', '+10 minutes');
        break;
    case "tcmc":
        $director = new Director('local-a2a59137c0a5b30e8b291c698126e167', 'photo.twincities.com/ssp');
        $director->cache->set('mc_tcmc', '+10 minutes');
        break;
   	case "tcmc2":
		$director = new Director('hosted-aa219310cfe390c8fe2d9a424fb8de42', 'twincities.slideshowpro.com');
		$director->cache->set('mc_tcmc2', '+10 minutes');
	    break;
    case "dpmc":
        $director = new Director('local-904d36b9b89af2bbd00b046bd1ffa3aa', 'director.denverpost.com');
        $director->cache->set('mc_dpmc', '+10 minutes');
        break;
    case "epmc":
        $director = new Director('local-70926b0a95cb7b8be468c24ebbe16b47', 'director.elpasotimes.com');
        $director->cache->set('mc_epmc', '+10 minutes');
        break;    
    case "dtmc":
        $director = new Director('local-1b2c777a6c5be1edcbda99d11392f8e9', 'director.daily-times.com');
        $director->cache->set('mc_dtmc', '+10 minutes');
        break;
    case "lcmc":
        $director = new Director('local-04db8094035d38842debf2b701b85556', 'director.lcsun-news.com');
        $director->cache->set('mc_lcmc', '+10 minutes');
        break;
	case "metro":
        $director = new Director('local-cc94149216b861fa419a89976fa7afc9', 'director-lang-ieng.medianewsgroup.com');
        $director->cache->set('mc_metro', '+10 minutes');
        break;
    case "sgvn":
        $director = new Director('local-9ab1f662b717bcebb35f130a3398d828', 'director-lang-sgvn.medianewsgroup.com');
        $director->cache->set('mc_sgvn', '+10 minutes');
        break;
    case "ieng":
    //echo "ieng";
        $director = new Director('local-db5c88a3ffb1ba26a80faf1c579f0cf9', 'director-lang-metro.medianewsgroup.com');
        $director->cache->set('mc_ieng', '+10 minutes');
        break;  
    case "merc":
        $director = new Director('hosted-3cdd36deb8721ca583438e67f06b5778', 'mercphotos.slideshowpro.com');
        $director->cache->set('mc_merc', '+10 minutes');
        break;
    case "merc2":
        $director = new Director('local-522ea8e0654fc3e7584aa809d68862cb', 'director.mercurynews.com');
        $director->cache->set('mc_merc2', '+10 minutes');
        break;
    case "norcalmc":
        $director = new Director('local-f66f79321803c3dc36ba6238d9af4397', 'director-norcal.medianewsgroup.com');
        $director->cache->set('mc_norcalmc', '+10 minutes');
        break; 
   	case "pmpmc":
        $director = new Director('local-40608b612cbf7ca3e60e33da50c0c95b', 'director-pmp.medianewsgroup.com');
        $director->cache->set('mc_pmpmc', '+10 minutes');
        break;    
   	case "ctmc":
        $director = new Director('local-70ef883912083e0699995fc5945e6de4', 'director.newhavenregister.com');
        $director->cache->set('mc_ctmc', '+10 minutes');
        break;
	case "lowellmc":
        $director = new Director('local-c99070c523344e2e7da4d9ba7d85043f', 'director-lowell.medianewsgroup.com');
        $director->cache->set('mc_lowellmc', '+10 minutes');
        break;
   	case "nenimc":
        $director = new Director('local-5a6c3cbe2bc4467d7229faa4ef2bef04', 'director-neni.medianewsgroup.com');
        $director->cache->set('mc_nenimc', '+10 minutes');
        break;
   	case "mimc":
        $director = new Director('local-08dfe6308f01c470dad56d817324f3d4', 'director-mich.medianewsgroup.com');
        $director->cache->set('mc_mimc', '+10 minutes');
        break;
   	case "detmc":
        $director = new Director('local-d57c79d2132cb879c42ca95df34a7a01', 'director-detroit.medianewsgroup.com');
        $director->cache->set('mc_detmc', '+10 minutes');
        break;
   	case "nymc":
        $director = new Director('local-36d55e2858396c71f178ea52fc91b684', 'director-ny.medianewsgroup.com');
        $director->cache->set('mc_nymc', '+10 minutes');
        break;
   	case "ohmc":
        $director = new Director('local-d3bedbcd773d4c0771683f8cfa192047', 'director-ohio.medianewsgroup.com');
        $director->cache->set('mc_ohmc', '+10 minutes');
        break;
   	case "pamc":
        $director = new Director('local-d3bedbcd773d4c0771683f8cfa192047', 'director-penn.medianewsgroup.com');
        $director->cache->set('mc_pamc', '+10 minutes');
        break;
   	case "ydmc":
        $director = new Director('local-a1d1a2aec6761b4907cb4939c6806f31', 'director-york.medianewsgroup.com');
        $director->cache->set('mc_ydmc', '+10 minutes');
        break;
   	case "yorkmc":
        $director = new Director('local-e8e334c2ebe04b4ee2eb37eb90bcbdb9', 'director-ydis.medianewsgroup.com');
        $director->cache->set('mc_yorkmc', '+10 minutes');
        break;
   	case "starmc":
        $director = new Director('locallocal-70ef883912083e0699995fc5945e6de4', 'director-star.medianewsgroup.com');
        $director->cache->set('mc_starmc', '+10 minutes');
        break;
   	case "utmc":
        $director = new Director('local-c99070c523344e2e7da4d9ba7d85043f', 'director-utah.medianewsgroup.com');
        $director->cache->set('mc_utmc', '+10 minutes');
        break;
   	case "njmc":
        $director = new Director('local-5cadaeb55a767c9fb83801565e799bee', 'director-nj.medianewsgroup.com');
        $director->cache->set('mc_njmc', '+10 minutes');
        break;                                                                                      
    default:
       $director = new Director('hosted-ec5968d1bc7bc366d67ef8a87fd69909', 'dpphoto.slideshowpro.com');
}
?>