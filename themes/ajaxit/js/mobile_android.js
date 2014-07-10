//alert( 'android loaded');
//console.log("Hello Android user");

//Mozilla/5.0 (Linux; U; Android 4.0.3; en-us; GT-P5113 Build/IML74K) AppleWebKit/534.30 (KHTML, like Gecko) Version/4.0 Safari/534.30          (tablet)
//Mozilla/5.0 (Linux; U; Android 2.3.5; en-us; YP-G1 Build/GINGERBREAD) AppleWebKit/533.1 (KHTML, like Gecko) Version/4.0 Mobile Safari/533.1   (Phone)

//Mozilla/5.0 (Linux; U; Android 1.6; en-us; sdk Build/Donut) AppleWebKit/528.5+ (KHTML, like Gecko) Version/3.1.2 Mobile Safari/525.20.1   (emulator DOES NOT LOAD css)
//Mozilla/5.0 (Linux; U; Android 1.5; en-us; MB300 Build/Blur_Version.0.13.37.MB300.ATT.en.US Flex/P014) AppleWebKit/528.5+ (KHTML, like Gecko) Version/3.1.2 Mobile Safari/525.20.1
//																													(shelby's phone DOES NOT LOAD css)


function hideAddressBar() {
	console.debug('------hideAddressBar------');
	//alert( navigator.userAgent );
	if ( (navigator.userAgent.indexOf("Firefox") != -1) || (navigator.userAgent.indexOf("Chrome") != -1) ) {
		//alert('firefox');
		determineOrientation( function(){ setAllCSSsizes();setTimeout('runDoNext();', 1000); } );
		return;
	}
	
	if(document.documentElement.scrollHeight<window.outerHeight/window.devicePixelRatio) {
		document.documentElement.style.height=(window.outerHeight/window.devicePixelRatio)+'px';
	}
	setTimeout('window.scrollTo(1,1);',0);
	if ( xInterface.doNext != 0 ) {
		//we dont want to run this if there is nothing down the road to do
		hideAddressBarDone(0);
	}
	//setTimeout('setSizes();', 1000);
	//setTimeout('alert( "width: "+ window.innerWidth +", height: "+ window.screen.height);', 2000);
	//320 x 508 portrait
	//533 x 295 landscape
}

function hideAddressBarDone( xnum ) {
	console.debug('------hideAddressBarDone------');
	//-------is this function still necessary, confirm!
	//alert( 'dead function: IsOrientationDone;'); 
	//if(document.height <= window.outerHeight + 10) {
	if ((document.height || document.body.clientHeight) == window.innerHeight) {
		determineOrientation( function(){ setAllCSSsizes();setTimeout('runDoNext();', 1000); } );
		//setTimeout('setAllCSSsizes();', 1000);
		//document.getElementById('article_window_full').style.width = window.innerWidth +"px";
		//document.getElementById('article_window_full').style.height = window.innerHeight +"px";
		//document.getElementById('mainframe_window_full').style.width = window.innerWidth +"px";
		//document.getElementById('mainframe_window_full').style.height = window.innerHeight +"px";
	} else {
		if ( xnum > 100 ) {
			console.debug('ERROR: hideAddressBarDone did not occur! *****');
		} else {
			xnum = xnum + 1;
			setTimeout( function(){ hideAddressBarDone(xnum); }, 100 );
		}
	}
}
























