//var processedPortrait = 0;
//var processedLandscape = 0;
var justClicked = 0;
//var lastWidth = 0;					//not sure we need this var ?????????? CJ ***
//var xOrientation = 0;
var indexArray = new Array();
//var doNext = 0;					//what to do next, when done with all the waiting: 0= nothing, 1=loadIndexData, 2=loadGalleryData
var currentGalleryURL = '';
var currentMainURL = document.location;

//var gallib;		//new gallerytracklib("Test Mobile Gallery", true, true);
var mainlib;	//
//http://stackoverflow.com/questions/9838837/hide-url-in-browser-on-android-2-3-using-html-javascript

var xGallery;	//gallery object
var xActiveTouch = 0;

function Interface () {
	console.debug('------Interface object created------');
	this.processedPortrait = 0;
	this.processedLandscape = 0;
	this.doNext = 0;				//0= nothing, 1=loadIndexData, 2=loadGalleryData
	this.xOrientation = 0;
	//xInterface.currentGalleryURL = '';
	//this.galleryArray = new Array();
	//this.gallerySlideArray = new Array();		//0=photo, 1=intro, 2=ad (unloaded), 3=end, 20=ad (loaded but not seen), 200=ad (loaded and seen)
	//this.myGalleryScroll = null;
	
	//this.lastFrame = -1;
	return this;
	//Gallery.loadGalleryData( 'hello world yo');
}

//I/browser ( 1002): Console: innerWidth: 320, innerHeight: 452 http://192.168.1.136/mediacenter/wp-content/themes/ajaxit/js/universal_tools.js:14
function intervalWatchThings( x ) {
	//-----this is a debugging tool
	if ( x == undefined ) { x= 0;}
	if ( indexArray.length < 1 ) {
		//----index has not been set yet, so keep loop going
		xwidth = window.innerWidth;xheight = window.innerHeight;
		console.debug('innerWidth: '+ xwidth +', innerHeight: '+ xheight +', document.height == window.innerHeight: '+ (document.height == window.innerHeight) );
		//console.debug('innerWidth: '+ xwidth +', innerHeight: '+ xheight +', document.height: '+ document.height +', getHeightx(): '+ getHeightx() );
		x = x + 1;
		if ( x < 100 ) { 
			setTimeout('intervalWatchThings('+ x +');', 10);
		}
	} else {
		console.debug('FINISHED: innerWidth: '+ xwidth +', innerHeight: '+ xheight);
	}
}

function runDoNext() {
	//-----when everything is done, like orientation change, hide url bar, css, then do this.
	console.debug('------runDoNext------');
	switch(xInterface.doNext) {
	case 1:
		loadIndexData( currentMainURL );
		break;
	case 2:
		xGallery.loadGalleryData( currentGalleryURL );
		break;
	case 3:
		loadArticleData( currentMainURL );
		break;
	case 4:
		loadVideoData( currentMainURL );
		break;
	default:
		//nothing
		//alert( 'ERROR: runDoNext is in default.');
		console.debug('ERROR: runDoNext is in default.');
	}
	xInterface.doNext = 0;
}

function loadVideoData( xURL ) {
	console.debug('------loadVideoData------: '+ xURL );
	
	if ( justClicked ) return;
	justClicked = 1; setTimeout("justClicked = 0;", 1000);
	//console.debug('------loadGalleryData------: '+ xURL );
	this.currentGalleryURL = xURL;
	xURL = cleanUpURL( xURL );
	//alert( toggleHTML);
	/*
	setTimeout(function() {
		// in a bit, show the 'loading screen, unless of course, it is already loaded
		//alert( xGallery.galleryArray.title );
		if (xGallery.galleryArray.title == undefined ) {
			//alert( 'undefined, so show it');
			document.getElementById( "loading_container_gallery" ).innerHTML = toggleHTML;
		} else {
			document.getElementById( "loading_container_gallery" ).innerHTML = '';
		}
	}, 400);
	*/
	request(
		xURL, null,function() {
			if ( this.readyState == 4) {
				var xdata = this.responseText;
				if ( xdata == '' ) {
					//alert( 'Loading Gallery data timed out! This is an error isolated to Android (I think). Please reload.' );
					//loadGalleryData( xURL );
				} else {
					//alert( xdata );
					articleArray = eval ("(" + xdata + ")");
					showVideo();
				}
			}
		}, 'GET'
	);
	
	document.getElementById('gallery_content').style.visibility ='hidden';
	document.getElementById('article_content').style.visibility ='visible';
	
	document.getElementById('article_window_full').style.left = "0px";
	document.getElementById('article_window_full').style.visibility ='visible';
}

function showVideo() {
	//alert('showvid2');
	//alert( articleArray.title );
	console.debug('------showVideo------');
	var xtitle = processTitle( articleArray.title );
	//document.getElementById('gallery_toolbar_xTitle').innerHTML = xtitle;
	//article_content
	
	var xx = '';//'<div class="clear" style="border:1px solid red;width:10px;height:10px;"></div>';
	xx +='<div id="videocontainer" class="videocontainer" style="position:relative;margin-bottom:10px;height:165px;width:300px;top:0px;left:0px;">';	
	xx +='	<div class="videobox" style="position:relative;">';
	xx +='		<!-- Start of Brightcove Player -->';
	
	//xx +='		<div style="display:none"></div>';

	
	//xx +='		<script language="JavaScript" type="text/javascript" src="http://admin.brightcove.com/js/BrightcoveExperiences.js"></script>';
	//alert( articleArray.description );
	xx +='		<object id="myExperience'+ articleArray.description +'" class="BrightcoveExperience">';
	xx +='		  <param name="bgcolor" value="#FFFFFF" />';
	//xx +='		  <param name="width" value="200" /><param name="height" value="105" />';
	//xx +='				<PARAM NAME="scale" VALUE="ToFit">';
	xx +='		  <param name="width" value="300" /><param name="height" value="165" />';
	xx +='		  <param name="wmode" value="transparent" />';
	xx +='		  <param name="playerID" value="784767430001" /><param name="playerKey" value="AQ~~,AAAAADe65VU~,G496cZ36A_WiTZ4IQyeReBB7z075a2tu" />';
	xx +='		  <param name="isVid" value="true" /><param name="isUI" value="true" /><param name="dynamicStreaming" value="true" />';
	xx +='		  <param name="@videoPlayer"  value="'+ articleArray.description +'" />';
	xx +='		</object><BR><BR>';
	
	//xx +='		<script type="text/javascript">brightcove.createExperiences();</script>';

	xx +='		<!-- End of Brightcove Player -->';

	xx +='	</div></div>';
	
	//alert( articleArray.description );
	
	document.getElementById('article_thelist').innerHTML = '<li style="font-family:Arial;font-weight:normal;font-size:14px;line-height:14px;color:#000;text-align:left;padding:0px;margin:0px 5px 0px 5px;"><BR><BR>'+ xx +'<BR><span style="font-weight:bold;font-size:22px;line-height:24px;margin-bottom:10px;">'+ xtitle +'</span>'+ articleArray.text_article +'</li>';
	setTimeout("buildArticleScroll();", 1000);
	setTimeout("brightcove.createExperiences();", 400);
}

function loadArticleData( xURL ) {
	console.debug('------loadArticleData------: '+ xURL );
	
	if ( justClicked ) return;
	justClicked = 1; setTimeout("justClicked = 0;", 1000);
	
	xGallery.currentGalleryURL = xURL;
	xURL = cleanUpURL( xURL );
	//alert( xURL );
	request(
		xURL, null,function() {
			if ( this.readyState == 4) {
				var xdata = this.responseText;
				if ( xdata == '' ) {
					//alert( 'Loading Gallery data timed out! This is an error isolated to Android (I think). Please reload.' );
					//loadGalleryData( xURL );
				} else {
					//alert( xdata );
					articleArray = eval ("(" + xdata + ")");
					showArticle();
				}
			}
		}, 'GET'
	);
	document.getElementById('gallery_content').style.visibility ='hidden';
	document.getElementById('article_content').style.visibility ='visible';
	
	document.getElementById('article_window_full').style.left = "0px";
	document.getElementById('article_window_full').style.visibility ='visible';
	
}


function putiFrameAdInDiv( xADsrc, adIDname, xWidth, xHeight, xDivID ) {
	//alert( xADsrc );
	xString = '<div align="center" >';
	xString = xString + '<iframe src="'+ xADsrc +'" id="'+ adIDname +'" name="'+ adIDname +'" width="'+ xWidth +'px" height="'+ xHeight +'px" frameborder="0" marginheight="0" marginwidth="0" scrolling="no" ><\/iframe>';
	xString = xString + '</div>';
	document.getElementById( xDivID ).innerHTML = xString;
	//putiFrameAdInDiv( window.parent.styleURL +"/ads/photo728x90.html?thepagetag=photos&thepagecat=gallery", "adposmainlow", 728, 90, "index_ad" );
}

//loadGoogle( function(){alert('going to delete');} );
function loadGoogle( callback ) {
	//callback();
	if ( callback != undefined ) {
		//alert( callback );
		setTimeout(callback, 2000);
	}
	/*
	//xURL = xURL + '?xfd';
	//alert(xURL);
	request(
		'www.google.com', null,function() {
			if ( this.readyState == 4) {
				xdata = this.responseText;
				alert( xdata );
			}
		}, 'GET'
	);
	*/
}

function loadIndexURL( xURL ) {
	console.debug('------loadIndexURL------');
	indexArray = new Array();
	currentMainURL = xURL;xURL = cleanUpURL( xURL );
	//alert(xURL);
	request(
		xURL, null,function() {
			if ( this.readyState == 4) {
				xdata = this.responseText;
				//alert( '::'+ this.status );	// 200 is best, 0 otherwise could be a problem
				if ( document.location.hash === 'dev' && typeof console !== 'undefined' ) console.log( xURL, '::', this.status );
				if ( xdata == '' ) {
					//alert( 'Loading Index data timed out! This is an error isolated to Android (I think). Please reload.' );
					if ( document.location.hash === 'dev' && typeof console !== 'undefined' ) console.log( 'Loading Index data timed out! This is an error isolated to Android (I think). Please reload.' );
					//loadIndexURL( xURL );
				} else {
					if ( document.location.hash === 'dev' && typeof console !== 'undefined' ) console.log("XDATA: ", xdata);
					indexArray = eval ("(" + xdata + ")");
					toggleLoadingScreen( 0 );
					//echo '{"category_title":"desktopset","category_id":"0"}';
					document.getElementById( 'mainframe_window_full' ).style.visibility = 'visible';
					if ( indexArray.category_title == 'all' && indexArray.category_id == 'all' ) {
						//alert( 'listing of all catagories' );
						showFullCategoryListing();
					} else {
						showIndex();
					}
					//s.pageName="Media Center Mobile: "+ blogname +" / "+ indexArray.category_title;
					//alert( s.pageName );
					//$xString . '],"thepagetag":"'. $thepagetag .'","alldeeezcats2":"'. $alldeeezcats2 .'" }';;
					//alert( indexArray.thepagetag );
				}
			}
		}, 'GET'
	);
	toggleLoadingScreen( 1 );
	document.getElementById( 'mainframe_window_full' ).style.visibility = 'hidden';
}

function setDesktopVersionON() {
	//user has chosen to view desktop version ........code for this is in the category.php and wptap plugin md-includes/function.php file.
	console.debug('------setDesktopVersionON------');
	xURL = cleanUpURL( homeURL +'/category/sports/?c=desktop' );
	request(
		xURL, null,function() {
			if ( this.readyState == 4) {
				xdata = this.responseText;
				if ( xdata != '' ) {
					indexArray = eval ("(" + xdata + ")");
					if ( indexArray.category_title == 'desktopset' && indexArray.category_id == '0' ) {
						//--------------------USER WANTS DESKTOP VERSION, SO SEND EM THERE
						document.location.href = currentMainURL;
					}
				}
			}
		}, 'GET'
	);
	toggleLoadingScreen( 1 );
	document.getElementById( 'mainframe_window_full' ).style.visibility = 'hidden';
	document.getElementById('section_nav_window').style.top = '-440px';
}

//alert( processSSPurl( 'http://mcenter.slideshowpro.com/albums/027/935/album-308918/cache/022912_nuggetsBlazers_1.sJPG_900_540_0_95_1_50_50.sJPG?1330650190', 300, 300, 1 ) );
//zhtml = zhtml + '	<img style="margin-top:1px;" src="'+ processSSPurl( item[6], 766, 500, 1 ) +'" />';
function processSSPurl( xURL, xwidth, xheight, xcrop ) {
	//console.debug('-------processSSPurl: '+ xURL +'-------');
	//http://mcenter.slideshowpro.com/albums/027/935/album-308918/cache/022912_nuggetsBlazers_1.sJPG_900_540_0_95_1_50_50.sJPG?1330650190
	//so i need to break apart this URL and resize... all varibles, including the capitolization of sJPG in both instances needs to be copied.
	//xTemp = xURL.split('.s');
	//alert( xURL );
	//http://photo.twincities.com/ssp/p.php?a=RWB3cUxCZHBvb3JdIzQwJUhaUSs9PDg6KzQ8Ny4gNSQ%2BIy0rOiciKD87LiY0LTsuOjoyJT46
	
	//check to see if it is smug mug
	
	if ( (xURL == null) || (xURL == undefined ) ) {
		return '';
	}
	
	if (xURL.indexOf("smugmug") != -1) {
		//http://dpostphoto.smugmug.com/photos/i-bBD8PdV/0/50x50/i-bBD8PdV-50x50.jpg
		xURL = xURL.split('/');
		xURL = 'http://'+ xURL[2] +'/'+ xURL[3] +'/'+ xURL[4] +'/'+ xURL[5] +'/'+ xwidth +'x'+ xheight +'/'+ xURL[4] +'-'+ xwidth +'x'+ xheight +'.jpg';
		//alert( xURL );
		return xURL;
	} else {
		return xURL;

		//xwidth =270; xheight = 270;
		/*
		var xfocusX = xURL.split('_');
		var xfocusY = xfocusX[ (xfocusX.length - 1 ) ];xfocusY = xfocusY.split('.');xfocusY = xfocusY[0];

		if ( xfocusX.length <= 1 ) {
			return xURL;
		} else {
			//console.debug('xfocusY: '+ xfocusY +', xfocusX.length: '+ xfocusX.length);
			var firstJPG = xfocusX[ (xfocusX.length - 8 ) ];firstJPG = firstJPG.split('.');firstJPG = firstJPG[ firstJPG.length-1];

			xfocusX = xfocusX[ (xfocusX.length - 2 ) ];

			var zURL = xURL.split('.sJPG_');
			(zURL.length < 2) ? (zURL = xURL.split('.sjpg_')) : 0;
			//if ( zURL.length < 2 ) { zURL = xURL.split('.sjpg_'); }

			zURL = zURL[0] +'.'+ firstJPG +'_'+xwidth+'_'+xheight+'_'+xcrop+'_80_1_'+xfocusX+'_'+xfocusY+'.sJPG?'+ Math.floor(Math.random()*50000000);
			//console.debug('loading ssp image: '+ zURL);
			//alert( zURL.length );
			return zURL;
		}
		*/
	}
	
	
	
}

function clickShare( xobject ) {
	if ( xobject.id == 'twitter_button' ) {
		if ( xGallery.galleryArray.title == undefined ) {
			window.open('http://twitter.com/share?url='+ encodeURIComponent( this.currentGalleryURL ) +'&size=m&text='+ encodeURIComponent( 'Media Center' ) );
		} else {
			window.open('http://twitter.com/share?url='+ encodeURIComponent( xGallery.currentGalleryURL ) +'&size=m&text='+ encodeURIComponent( xGallery.galleryArray.title ) );
		}
		
	} else 	if ( xobject.id == 'facebook_button' ) {
		//window.open('http://m.facebook.com/sharer.php?u=http%3A%2F%2Fm.denverpost.com%2Fdenverpost%2Farticle%2FDScKcwT3&t=Mark+Kiszla%3A+NBA%27s+joke+of+parity+is+on+the+Nuggets')"
		//window.open('http://www.facebook.com/plugins/like.php?href='+ encodeURIComponent( xGallery.currentGalleryURL ) +'&send=false&layout=button_count&width=200&show_faces=false&action=like&colorscheme=light&font=lucida+grande&height=21&appId='+ facebookid);
		//window.open('https://www.facebook.com/plugins/error/confirm/like?iframe_referer='+ encodeURIComponent( homeURL ) +'&secure=true&plugin=like&return_params={%22href%22%3A%22'+ encodeURIComponent( xGallery.currentGalleryURL ) +'%22%2C%22send%22%3A%22false%22%2C%22layout%22%3A%22button_count%22%2C%22width%22%3A%22300%22%2C%22show_faces%22%3A%22false%22%2C%22action%22%3A%22recommend%22%2C%22colorscheme%22%3A%22light%22%2C%22appId%22%3A%22'+ facebookid +'%22%2C%22ret%22%3A%22sentry%22%2C%22act%22%3A%22connect%22}');
		window.open('http://m.facebook.com/sharer.php?u='+ encodeURIComponent( xGallery.currentGalleryURL ) +'&t='+ encodeURIComponent( xGallery.galleryArray.title ) );

	}
	//alert( xobject.id );
	//https://www.facebook.com/plugins/error/confirm/like?iframe_referer=http%3A%2F%2F173.45.226.6%2Fdev2%2F&secure=true&plugin=like&return_params={%22href%22%3A%22http%3A%2F%2F173.45.226.6%2Fdev2%2F2012%2F02%2Fphotos-136th-westminster-kennel-club-annual-dog-show-16%2F%22%2C%22send%22%3A%22false%22%2C%22layout%22%3A%22button_count%22%2C%22width%22%3A%22300%22%2C%22show_faces%22%3A%22false%22%2C%22action%22%3A%22recommend%22%2C%22colorscheme%22%3A%22light%22%2C%22appId%22%3A%22166361770063055%22%2C%22ret%22%3A%22sentry%22%2C%22act%22%3A%22connect%22}
}

function toggleShare() {
	//alert( 'toggleshare');
	//alert( document.getElementById('share_container').style.top);
	
	if ( document.getElementById('share_container').style.top != '40px' ) {
		//show share window
		document.getElementById('share_container').style.top = '40px';
		//setupSharing();
		
		
		//document.getElementById('share_container').style.visibility = 'visible';
		//document.getElementById('share_window_container').style.z-index = 0;
	} else {
		document.getElementById('share_container').style.top = '-200px';
		//document.getElementById( 'share_twitter_href' ).innerHTML = '';
		//document.getElementById( 'share_facebook_container' ).innerHTML = '';
		//document.getElementById('share_container').style.visibility = 'hidden';
	}
}

function processTitle( xtitle ) {
	//console.debug('------processTitle------: '+ xtitle);
	if (xtitle.indexOf("Photos: ") != -1) {
		xtitle=xtitle.split("Photos: ");
		xtitle = xtitle[1];
	} else if (xtitle.indexOf("Video: ") != -1) {
		xtitle=xtitle.split("Video: ");
		xtitle = xtitle[1];
	} else {
		
	}
	return unescape(xtitle);
}

function clickNavBarLink( xnum ) {
	//this function is still used when user clicks top title to view newest galleries
	//if ( justClicked ) return;
	//justClicked = 1; setTimeout("justClicked = 0;", 1000);
	
	if ( xnum == 1 ) {
		xURL = homeURL +'/category/images-of-the-day/';
	} else if ( xnum == 2 ) {
		xURL = homeURL +'/category/news/';
	} else if ( xnum == 3 ) {
		xURL = homeURL +'/category/sports/';
	} else if ( xnum == 4 ) {
		xURL = homeURL +'/category/entertainment/';
	} else if ( xnum == 5 ) {
		xURL = homeURL +'/category/sports/?c=all';
	} else if ( xnum == 0 ) {
		xURL = homeURL;	
	} else {
		
	}
	loadIndexData( xURL );
	document.getElementById('section_nav_window').style.top = '-440px';
}

function determineOrientation( callback ) {
	console.debug('------determineOrientation------');
	//primary purpose is to set xOrientation to "portrait" or "landscape", afterwards we call setAllCSSsizes
	var orientationTimer = 0;
	clearTimeout(orientationTimer);
	orientationTimer = setTimeout(function() {
		// calculate the orientation based on aspect ratio 
		var aspectRatio = 1;
		if (window.innerHeight !== 0) {
			aspectRatio = window.innerWidth / window.innerHeight;
		}
		// determine the orientation based on aspect ratio 
		xInterface.xOrientation = aspectRatio <= 1 ? "portrait" : "landscape";
		console.debug('orientation set to: '+ xInterface.xOrientation);
		
		if ( callback != undefined ) {
			//alert( callback );
			setTimeout(callback, 10);
			//setTimeout('setAllCSSsizes();', 10);
		}
	}, 500);
}

function checkCSSafterLoad() {
	//this function is redundant error checking to make sure that css and div sizes have processed successfully
	console.debug('------checkCSSafterLoad------: '+ document.getElementById('content').offsetHeight );
	//if ( (document.getElementById('content').style.height == 0) || (document.getElementById('content').style.height == '') ) {
	if ( (document.getElementById('content').offsetHeight == 0) || (document.getElementById('content').offsetHeight == '') ) {
		console.debug('***********DOCUMENT div content is 0, reset and re-setAllCSSsizes()*****');
		xInterface.processedPortrait = 0;
		xInterface.processedLandscape = 0;
		setAllCSSsizes();
	}
}

function loadMoreGalleriesIntoIndex() {
	console.debug('------loadMoreGalleriesIntoIndex------: '+ currentMainURL);
	//http://192.168.1.108/mediacenter/?xfd&offset=1
	xURL = cleanUpURL( currentMainURL ) + '&offset='+ indexArray.photos.length;
	document.getElementById( "load_more_button" ).innerHTML = '<div class="list_image_title" style="text-align:center;margin-top:16px;">Loading ...</div>';
	document.getElementById( "load_more_button" ).ontouchend = null;
	
	if(typeof gallerytracklib!='undefined'){
		//make sure the library exists (isnt on local server for some reason)
		s.t();	//user has clicked to load more galleries, this is how we will record an additional 'view' for this page
	}
	
	//load_more_button
	//indexArray.photos.length
	//alert(xURL);
	//return;
	request(
		xURL, null,function() {
			if ( this.readyState == 4) {
				xdata = this.responseText;
				if ( xdata == '' ) {
					//alert( 'Loading Index data timed out! This is an error isolated to Android (I think). Please reload.' );
					//loadIndexURL( xURL );
				} else {
					//xString = document.getElementById( "load_more_button" ).innerHTML;	//get the existing content
					
					var tempArray = eval ("(" + xdata + ")");
					//alert( tempArray.photos.length );
					//.push("Kiwi") 
					
					if ( tempArray.photos.length == 0 ) {
						document.getElementById( 'thelist' ).removeChild( document.getElementById( 'load_more_button' ) );
						myIndexScroll._resize();
					} else {
						for (var i = 0; i < tempArray.photos.length; i++) {
							indexArray.photos.push( tempArray.photos[i] );
						}
						showIndex();
					}
					
				}
			}
		}, 'GET'
	);
	//toggleLoadingScreen( 1 );
	//document.getElementById( 'mainframe_window_full' ).style.visibility = 'hidden';
	
}

//--------------------------------------------------------------utilities


function countVisibleCharacters(xwidth, xheight, xtext ) {
	//this wont work because u can change orientation and that will affect what all text shows. :(
    var element = document.createElement('div');
    element.style['width'] = xwidth +'px';
    element.style.overflow = 'hidden';
    element.style['z-index'] = -1;
    element.style.height = xheight;
    element.style.border = '1px solid red';
    element.style['line-height'] = '1.2em';
    //element.style['max-height'] = '3.6em';
    //element.style['white-space'] = 'nowrap';
    //alert( element.style['white-space'] );
    
    element.innerHTML = xtext;

    var text = element.firstChild.nodeValue;
    //var text = element.innerHTML;
    var r = 0;
   
    element.removeChild(element.firstChild);
    document.getElementsByTagName('body') [0].appendChild(element);
        
    //alert( text.length );
    //text.length
    for(var i = 0; i < text.length; i++) {
        var newNode = document.createElement('span');
        newNode.appendChild(document.createTextNode(text.charAt(i)));
        element.appendChild(newNode);
        //alert( element.appendChild(newNode) );
        if ( (newNode.offsetLeft < element.offsetWidth) && (newNode.offsetTop < element.offsetHeight) ) {
        //if ( newNode.offsetTop < element.offsetHeight) {
            //alert( r );
            r++;
        }
    }
    document.getElementsByTagName('body') [0].removeChild(element);
    xtext = xtext.slice(0,(r-5) ) + '...';
    return xtext;
}
//var c = countVisibleCharacters( 60, '2.4em', '1234 567 890 12 3458 90 123 45678 901 234 567 890 3458 90 123 45678 90' );
//alert(c);

function cleanUpURL( xURL ) {
	//this function will ALWAYS be called when asking for a feed from the server to avoid problems
	//problems:
	//if there is a # at the end of a the Url, get rid of it or process it
	xURL = String(xURL);
	if (window.location.hash !== 'dev') {
		// Links from Facebook that include hashes were not loading
		// Josh K. 1/28/2014
		xURL = xURL.replace(/\#.*/, '');
	}
	if ( xURL.indexOf("?") != -1 ) {
		//url already has a ? at the end, so use a & instead
		xURL = xURL + '&xfd';
	} else {
		xURL = xURL + '?xfd';
	}
	//alert( xURL );
	return xURL;
}

function refreshTheMainAd() {
	//thepagecat="+ xGallery.galleryArray.alldeeezcats2
	//alert( "refreshTheMainAd: "+ indexArray.alldeeezcats2 );
	putiFrameAdInDiv( themeURL +"/ads/apt728x90.html?thepagetag=home&thepagecat="+ indexArray.alldeeezcats2 +"&id="+yld_mgrpub_id+"&stnm="+yld_mgrsite_name+"&ct="+yld_mgrcontent+"&pc="+parent_company, "adposmainlow", 728, 90, "index_ad" );
}

function ChangeStyleSheet( xtitle, xattribute, xvalue, xstylesheet ) {
	//------changes values of a class
	//ChangeStyleSheet('.toolbar_top', 'background', 'red')
	var thecss = new Array();
	
	//stylesheets 0 = portrait, 1 = landscape
	if ( xstylesheet == undefined ) {
		if ( xInterface.xOrientation == 'portrait' ) {
			thecss = document.styleSheets[0];
		} else {
			thecss = document.styleSheets[1];
		}
	} else {
		//function has specified that we want to set a specific stylesheet, 0 = portrait, 1 = landscape
		thecss = document.styleSheets[ xstylesheet ];
	}
	
	for(var i=0; i<thecss.cssRules.length; i++) {
		//alert( document.styleSheets[i].title );
		var sheet=thecss.cssRules? thecss.cssRules[i]: thecss.rules[i];
		if(sheet.selectorText == xtitle) {
			//alert( 'found: '+ xtitle );
			sheet.style[xattribute]=xvalue;
			return sheet;
		}
	}
	return false;		//only does this if it does not find the item
}

function toggleLoadingScreen( xOn ) {
	//var xOn will force on or off (1 or 0) regardless of current state, otherwise it checks contents
	if ( document.getElementById( "loading_container" ) ) {
		if ( xOn == undefined) {
			if (document.getElementById( "loading_container" ).innerHTML != '' ) {
				xOn = 0;
			} else {
				xOn = 1;
			}
		}
		if ( !xOn ) {
			//hide it
			//toggleHTML = document.getElementById( "loading_container" ).innerHTML;
			document.getElementById( "loading_container" ).innerHTML = '';
		} else {
			//show it
			if (document.getElementById( "loading_container" ).innerHTML == '' ) {
				//only show it, if its not already visible
				document.getElementById( "loading_container" ).innerHTML = toggleHTML;
			}
		}
	}
}

function XHR() {
    var xhr = false;
    xhr = window.ActiveXObject
        ? new ActiveXObject("Microsoft.XMLHTTP")
        : new XMLHttpRequest();
    return xhr;
}
       
// Build the request and get the reply back, snd is the parameters, with GET this is null, with POST, it is the sent parameters, type is either GET or POST
function request( url, snd, callback, type ) {
    var http = XHR();
    if (http) {
        http.onreadystatechange = callback;
    };
    http.open(type, url, true);
    if (type == "POST") {
        http.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        http.setRequestHeader("Content-length", snd.length);
        http.setRequestHeader("Connection", "close");
    }      
    http.send(snd);
}

function decodeHTMLEntities(text) {
	var result = "";
	var ele = document.createElement("p");
	ele.innerHTML = text;
	if (ele.textContent) {
		result = ele.textContent;
	} else if (ele.innerText) {
		result = ele.innerText;
	} else {
		result = text;
	}
	return result;
}

function dumpProps(obj, parent) {
   // Go through all the properties of the passed-in object
   for (var i in obj) {
      // if a parent (2nd parameter) was passed in, then use that to
      // build the message. Message includes i (the object's property name)
      // then the object's property value on a new line
      if (parent) { var msg = parent + "." + i + "\n" + obj[i]; } else { var msg = i + "\n" + obj[i]; }
      // Display the message. If the user clicks "OK", then continue. If they
      // click "CANCEL" then quit this level of recursion
      //if (!confirm(msg)) { return; }
		console.debug( msg );
      // If this property (i) is an object, then recursively process the object
      if (typeof obj[i] == "object") {
         if (parent) { dumpProps(obj[i], parent + "." + i); } else { dumpProps(obj[i], i); }
      }
   }
}

//------------------------------------------------------Gallery object 
//	(please note that additional methods are assigned in tablet/mobile universal js)

function Gallery () {
	console.debug('------Gallery object created------');
	this.currentGalleryURL = '';
	this.galleryArray = new Array();
	this.gallerySlideArray = new Array();		//0=photo, 1=intro, 2=ad (unloaded), 3=end, 20=ad (loaded but not seen), 200=ad (loaded and seen)
	this.myGalleryScroll = null;
	this.ad_every = 7;
	this.overlayState = 1;				//1= header/footer, 2= header/footer/caption, 3=hidden
	this.lastpagedrawn = 0;				//tells us the last page has been drawn and loaded, starts out false
	//this.lastFrame = -1;
	return this;
	//Gallery.loadGalleryData( 'hello world yo');
}

Gallery.prototype.loadGalleryData = function(xURL){
	if ( justClicked ) return;
	justClicked = 1; setTimeout("justClicked = 0;", 1000);
	console.debug('------loadGalleryData------: '+ xURL );
	this.currentGalleryURL = xURL;
	xURL = cleanUpURL( xURL );
	//alert( toggleHTML);
	
	setTimeout(function() {
		// in a bit, show the 'loading screen, unless of course, it is already loaded
		//alert( xGallery.galleryArray.title );
		if (xGallery.galleryArray.title == undefined ) {
			//alert( 'undefined, so show it');
			document.getElementById( "loading_container_gallery" ).innerHTML = toggleHTML;
		} else {
			document.getElementById( "loading_container_gallery" ).innerHTML = '';
		}
	}, 400);
	
	request(
		xURL, null,function() {
			if ( this.readyState == 4) {
				var xdata = this.responseText;
				if ( xdata == '' ) {
					//alert( 'Loading Gallery data timed out! This is an error isolated to Android (I think). Please reload.' );
					//loadGalleryData( xURL );
				} else {
					//alert( xdata );
					xGallery.galleryArray = eval ("(" + xdata + ")");
					//galleryArray.title//galleryArray.description//galleryArray.time
					//alert( galleryArray.photos[12].url );
					//s.pageName="Media Center Mobile: "+ blogname +" / "+ xGallery.galleryArray.title;
					xGallery.showGallery();
				}
			}
		}, 'GET'
	);
	
	document.getElementById('gallery_content').style.visibility ='visible';
	document.getElementById('article_content').style.visibility ='hidden';
	
	document.getElementById('article_window_full').style.left = "0px";
	document.getElementById('article_window_full').style.visibility ='visible';
}

Gallery.prototype.galleryScrollEnd = function( xCurrentPage ){
	//console.debug('------galleryScrollEnd------');
	if ( this.gallerySlideArray[ xCurrentPage ].title > 0 ) {
		//console.debug(gallerySlideArray[ xCurrentPage ].caption);
		document.getElementById( 'gallery_caption_text' ).innerHTML = unescape(this.gallerySlideArray[ xCurrentPage ].caption);
	} else {
		document.getElementById( 'gallery_caption_text' ).innerHTML = '';
	}
	
	//gallerySlideArray[ xCurrentPage ].title
	if (xGallery.galleryArray.title != undefined ) {	//make sure the gallyer is built and we arent just resetting the pos
		document.getElementById( 'gallery_toolbar_xCounter' ).innerHTML = (xCurrentPage + 1 ) +' of '+ this.gallerySlideArray.length;
	}
	
	//gallerySlideArray = new Array();		//0=photo, 1=intro, 2=ad (unloaded/seen), 3=end, 20=ad (loaded but not seen)
	if ( this.gallerySlideArray[ xCurrentPage ] == 2 ) {
		putiFrameAdInDiv( themeURL +"/ads/apt300x250.html?thepagetag=photos&thepagecat=gallery&id="+yld_mgrpub_id+"&stnm="+yld_mgrsite_name+"&ct="+yld_mgrcontent+"&pc="+parent_company, "adposgallery_"+ (xCurrentPage-1), 300, 250, 'adspace_'+ (xCurrentPage-1) );
	} else if ( this.gallerySlideArray[ xCurrentPage ] == 20 ) {
		this.gallerySlideArray[ xCurrentPage ] = 2;
		
	} else if ( this.gallerySlideArray[ xCurrentPage ] == 1 ) {
		this.toggleTopLayer(3);
	} else if ( this.gallerySlideArray[ xCurrentPage ] == 3 ) {
		//ending alert( xCurrentPage + ', '+ this.gallerySlideArray.length );
		this.toggleTopLayer(3);
		this.showLastPageOfGallery();
	}

	if ( this.gallerySlideArray[ xCurrentPage ].title) {
		omniTrack((xCurrentPage + 1 ), this.gallerySlideArray.length); // Call omniTrack on slides
		//if(typeof gallerytracklib!='undefined'){
			//console.debug('****record_photoView: '+ this.gallerySlideArray[ xCurrentPage ].title);
			//gallib.record_photoView( this.gallerySlideArray[ xCurrentPage ].title );
		//}
	}
	else {
		omniTrack(1, this.gallerySlideArray.length);
	}
}

Gallery.prototype.closeGallery = function(){
	console.debug('------Gallery.prototype.closeGallery------');
	justClicked = 1; setTimeout("justClicked = 0;", 1000);
	document.getElementById('article_window_full').style.left = "1300px";	//window.innerWidth +
	setTimeout("xGallery.clearGallery();", 800);
	//alert( indexArray.length );
	if ( indexArray.length < 1 ) {
		loadIndexURL(homeURL+'/');		//load main index for first time
	}
	document.getElementById( 'gallery_caption_text' ).innerHTML = '';
	document.getElementById( 'gallery_toolbar_xCounter' ).innerHTML = '';
	if ( document.getElementById( 'gallery_toolbar_xTitle' ) ) {
		document.getElementById( 'gallery_toolbar_xTitle' ).innerHTML = '';
	}
	
	if (this.myGalleryScroll ) { this.myGalleryScroll.destroy();}
	if (myArticleScroll) { myArticleScroll.destroy();}
	//gallib.deleteIt(); //
	document.getElementById('share_container').style.top = '-200px';		//hide the share window.
	document.getElementById('article_content').style.visibility ='hidden';
	gallib = null;
	this.lastpagedrawn = 0;
}

Gallery.prototype.loadGalleryMightLike = function(xURL) {
	if (this.myGalleryScroll ) { this.myGalleryScroll.destroy();}	//before cleargallery
	this.clearGallery();
	//user clicked a gallery they might like from inside a gallery
	//document.getElementById( 'gallery_caption_text' ).innerHTML = '';
	//document.getElementById( 'gallery_toolbar_xCounter' ).innerHTML = '';
	//if ( document.getElementById( 'gallery_toolbar_xTitle' ) ) {
	//	document.getElementById( 'gallery_toolbar_xTitle' ).innerHTML = '';
	//}
	
	//gallib = null;
	this.lastpagedrawn = 0;
	//document.getElementById('gallery_thelist').innerHTML = '';
	//this.galleryArray = new Array();
	//document.getElementById('gallery_thelist').style.opacity = '0.0';
	setTimeout("xGallery.loadGalleryData( '"+ xURL +"' );", 100);
	
}


Gallery.prototype.toggleTopLayer = function( xForce ){
	console.debug('------toggleTopLayer------: '+ this.overlayState);
	if ( xForce ) {
		this.overlayState = xForce;
	}
	//this.overlayState = 1;				//1= header/footer, 2= header/footer/caption, 3=hidden
	switch (this.overlayState) {
	case 3:
		this.overlayState = 1;
		document.getElementById('gallery_toplayer_container').style.opacity = '1.0';	//show top layer
		//document.getElementById('gallery_caption_container').style.opacity = '0.0';		//hide caption
		document.getElementById('gallery_caption_container').style.left = '5000px';
		break;
	case 1:
		this.overlayState = 2;
		document.getElementById('gallery_toplayer_container').style.opacity = '1.0';	//show top layer
		//document.getElementById('gallery_caption_container').style.opacity = '1.0';		//show caption
		document.getElementById('gallery_caption_container').style.left = '0px';
		break;
	case 2:
	default:
		this.overlayState = 3;
		document.getElementById('gallery_toplayer_container').style.opacity = '0.0';	//hide top layer
		//document.getElementById('gallery_caption_container').style.opacity = '0.0';		//hide caption
		document.getElementById('gallery_caption_container').style.left = '5000px';
		break;
	}
	//console.debug(document.getElementById('gallery_toplayer_container').style.opacity);
	//console.debug(document.getElementById('gallery_caption_container').style.opacity);
	//console.debug(document.getElementById('gallery_caption_container').style['z-index']);
	
}

//------------------------------------------------------Gallery object (end)

function updateOmnitureProperties() {
	//s.pageName="Media Center Mobile: "+ blogname +" / "+ xGallery.galleryArray.title;
	//alert( s.pageName );
	//s.prop2 = "Media Center Mobile/<?php echo $thepagetag ?>";
	//s.prop3 = "Media Center Mobile/<?php echo $thepagetag ?>/<?php echo $thepagecat ?>";
	//s.prop4 = "Media Center Mobile/<?php echo $thepagetag ?>/<?php echo $thepagecat ?>/<?php echo $thepagetitle ?>";
	
	/*
	var s_code;
	s.pageName="Media Center Mobile: <?php bloginfo('name'); ?> / <?php trim(wp_title("")); ?>"
	s.channel = "Media Center Mobile";
	s.prop1 = "D=g";
	s.prop2 = "Media Center Mobile/<?php echo $thepagetag ?>";
	s.prop3 = "Media Center Mobile/<?php echo $thepagetag ?>/<?php echo $thepagecat ?>";
	s.prop4 = "Media Center Mobile/<?php echo $thepagetag ?>/<?php echo $thepagecat ?>/<?php echo $thepagetitle ?>";
	s.prop9 = getCiQueryString("SOURCE");
	s.eVar2 = getCiQueryString("SOURCE");
	s.events = "event1";
	s.eVar4 = s.pageName;
	s_code = s.t();
	if (s_code) {document.write(s_code)};
	*/
}



function setupSharing() {
	alert( 'setupSharing: dead function!');
	//alert( '------setupSharing------:'+ xGallery.currentGalleryURL );
	//-------------------this function sets up the sharing buttons so that they will appropriately share the correct thing.
	//console.debug('------setupSharing------:'+ xGallery.currentGalleryURL);
	
	
	/*
	var xString = '<a href="http://twitter.com/share?url='+ encodeURIComponent( xGallery.currentGalleryURL ) +'" class="twitter-share-button">Tweet</a><script type="text/javascript" src="http://platform.twitter.com/widgets.js"></script>';
	document.getElementById( 'share_twitter_href' ).innerHTML = xString;
	twttr.widgets.load();
	
	xString = '<iframe id="facebookIframe" src="//www.facebook.com/plugins/like.php?href='+ encodeURIComponent( xGallery.currentGalleryURL ) +'&amp;send=false&amp;layout=button_count&amp;width=300&amp;show_faces=false&amp;action=like&amp;colorscheme=light&amp;font&amp;height=21&amp;appId='+ facebookid +'" scrolling="no" frameborder="0" style="border:none; overflow:hidden; width:200px; height:21px; visibility:hidden;" allowTransparency="true"></iframe>';
	document.getElementById( 'share_facebook_container' ).innerHTML = xString;
	
	document.getElementById('facebookIframe').onload= function() {
		//the iframe is sometimes 'ugly' for android until it has loaded. So I turn it invisible in the style for it a few lines above. Once loaded, show it.
		document.getElementById('facebookIframe').style.visibility = "visible";
	};
	
	<button id="twitter_button" style="width:150px;">Twitter</button>
	<button id="facebook_button" style="width:150px;">Facebook</button>
	*/
	
}
