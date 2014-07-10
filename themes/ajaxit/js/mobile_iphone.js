function hideAddressBar() {
	//console.debug('------hideAddressBar------');
	//alert(99);
	//this was added for iphone version and is called from sizeiFrameWindows() in interface.js
	// Was not clear to me why this block would not execute if hash was not falsey, so I guessed that it might
	// have been intended for the "dev" check from universal_tools.js:240. Links from Facebook that included
	// a hash number were not working. Josh K. 1/31/2014
	if(window.location.hash !== 'dev') {
		if((document.height || document.body.clientHeight) <= window.outerHeight + 10) {
			document.body.style.height = (window.outerHeight + 60) +'px';
			setTimeout( function(){ window.scrollTo(0, 1); }, 50 );
			//document.getElementById('article_window_full').style.width = window.innerWidth +"px";
			//document.getElementById('article_window_full').style.height = (window.innerHeight + 0) +"px";
			//document.getElementById('mainframe_window_full').style.width = window.innerWidth +"px";
			//document.getElementById('mainframe_window_full').style.height = (window.innerHeight + 0) +"px";
		} else {
			document.body.style.height = (window.outerHeight + 60) +'px';
			setTimeout( function(){ window.scrollTo(0, 1); }, 0 );
			//document.getElementById('article_window_full').style.width = window.innerWidth +"px";
			//document.getElementById('article_window_full').style.height = window.innerHeight +"px";
			//document.getElementById('mainframe_window_full').style.width = window.innerWidth +"px";
			//document.getElementById('mainframe_window_full').style.height = window.innerHeight +"px";
		}
		//alert( (document.height <= window.outerHeight + 10) );
		//setTimeout( function(){ alert( (document.height <= window.outerHeight + 10) ); }, 1000 );
		
		if ( xInterface.doNext != 0 ) {
			//we dont want to run this if there is nothing down the road to do
			hideAddressBarDone(0);
		}
		//setTimeout( function(){ hideAddressBarDone(); }, 100 );
	}
}

function hideAddressBarDone( xnum ) {
	
	//-------is this function still necessary, confirm!
	//alert( 'dead function: IsOrientationDone;'); 
	//if(document.height <= window.outerHeight + 10) {
	// document.height undefined in some tests. Changed this Josh K. 1/31/2014
	// https://developer.mozilla.org/en-US/docs/Web/API/document.height
	if((document.height || document.body.clientHeight) <= window.outerHeight + 10) {
		console.debug('------hideAddressBarDone------');
		determineOrientation( function(){ setAllCSSsizes();setTimeout('runDoNext();', 1000); } );
		//setTimeout('setAllCSSsizes();', 1000);
		//document.getElementById('article_window_full').style.width = window.innerWidth +"px";
		//document.getElementById('article_window_full').style.height = window.innerHeight +"px";
		//document.getElementById('mainframe_window_full').style.width = window.innerWidth +"px";
		//document.getElementById('mainframe_window_full').style.height = window.innerHeight +"px";
	} else {
		if ( xnum > 100 ) {
			console.debug('ERROR: hideAddressBarDone did not occur! *****');
			// Added by Josh K. 2/4/2014
			// If hideAddressBar fails, we still want the code to continue so the loading screen isn't up forever
			determineOrientation( function(){ setAllCSSsizes();setTimeout('runDoNext();', 1000); } );
		} else {
			xnum = xnum + 1;
			setTimeout( function(){ hideAddressBarDone(xnum); }, 100 );
		}
	}
}












