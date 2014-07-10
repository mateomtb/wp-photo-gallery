//---------used for all mobile phone devices
var xCatListingScroll = 0;

function interfaceLoaded () {
	console.debug('------interfaceLoaded------');
	
	xGallery = new Gallery();
	toggleHTML = document.getElementById( "loading_container" ).innerHTML;
	
	buildIndexScroll();
	//buildGalleryScroll();
	
	//document.addEventListener('resize', function (e) { console.debug('------resize------'); }, false);
	//resizeScreen();
	//mainlib = new gallerytracklib(decodeHTMLEntities('mobile_main_listing'), false, false);
	//if(typeof gallerytracklib!='undefined'){
		//make sure the library exists (isnt on local server for some reason)
		//mainlib = new gallerytracklib(decodeHTMLEntities('mobile_main_listing'), false, false);
		//omniTrack(1, this.gallerySlideArray.length);
	//}
	
	setTimeout('hideAddressBar();', 100);
	//hideAddressBar();
}

function showArticle() {
	//alert( articleArray.title );
	console.debug('------showArticle------');
	var xtitle = processTitle( articleArray.title );
	//document.getElementById('gallery_toolbar_xTitle').innerHTML = xtitle;
	//article_content
	document.getElementById('article_thelist').innerHTML = '<li style="font-family:Arial;font-weight:normal;font-size:14px;line-height:14px;color:#000;text-align:left;padding:0px;margin:0px 5px 0px 5px;"><span style="font-weight:bold;font-size:22px;line-height:24px;margin-bottom:10px;">'+ xtitle +'</span>'+ articleArray.text_article +'</li>';
	setTimeout("buildArticleScroll();", 300);
}

function buildIndexScroll () {
	myIndexScroll = new iScroll('wrapper', {
			snap: false,
			momentum: true,
			hScrollbar: false,
			onScrollEnd: function () {
				if ( this.lastPage != this.currPageX ) {
					//s.t();
					//refreshTheMainAd();
					//console.debug('moved: '+ myIndexScroll.momentum[0] +','+ myIndexScroll.momentum[1] +','+ myIndexScroll.momentum[2] );
					this.lastPage = this.currPageX;
				}
			}
		 });
}

function buildArticleScroll () {
	myArticleScroll = new iScroll('article_wrapper', {
		snap: false,
		momentum: true
	});
}

function orientationHasChanged() {
	console.debug('------orientationHasChanged------');
	//xOrientation = Math.abs(window.orientation) == 90 ? 'landscape' : 'portrait';
	determineOrientation();
	setTimeout('resizeScreen();', 500);
}

function loadIndexData( xURL ) {
	//----process here is fade off main content in .25 sec, THEN load the content
	//-----for mobile, this function is a bit redundant, but it must stay to accomidate tablet
	if ( justClicked ) return;
	justClicked = 1; setTimeout("justClicked = 0;", 1000);
	setTimeout("loadIndexURL('"+ xURL +"');", 250);
}

function loadCatData() {
	console.debug('------loadCatData------');
	//indexArray = new Array();
	xURL = cleanUpURL( homeURL +'/category/sports/?c=all' );
	request(
		xURL, null,function() {
			if ( this.readyState == 4) {
				xdata = this.responseText;
				//alert( '::'+ this.status );	// 200 is best, 0 otherwise could be a problem
				if ( xdata == '' ) {
					//alert( 'Loading Index data timed out! This is an error isolated to Android (I think). Please reload.' );
					//loadIndexURL( xURL );
				} else {
					//alert( xdata );
					var xTempArray = eval ("(" + xdata + ")");
					toggleLoadingScreen( 0 );
					//echo '{"category_title":"desktopset","category_id":"0"}';
					//document.getElementById( 'mainframe_window_full' ).style.visibility = 'visible';
					
					console.debug('		building new CAT Scroll');
					//alert( 'showFullCategoryListing: build it');
					//just queried server for full list of categories, now process and display
					xString = '<div class="nav_header_text" style="">CATEGORIES</div>';
					for (var i = 0; i < xTempArray.category.length; i++) {
						xString = xString + '<a href="'+ xTempArray.category[i].link +'" onclick="event.returnValue=false;toggle_section_nav_window();loadIndexData(this.href);">';
						xString = xString + '	<li class="cat_listing" style="height:40px;" >';
						xString = xString + '		<div class="list_image_title" style="margin-top:10px;">'+ xTempArray.category[i].title +' ('+ xTempArray.category[i].count +')</div>';
						xString = xString + '	</li>';
						xString = xString + '</a>';
				    }
					xString = xString + '<div class="nav_header_text" style="">OPTIONS</div><a href="" onclick="event.returnValue=false;setDesktopVersionON();" ><li class="cat_listing" style="height:40px;" ><div class="list_image_title" style="margin-top:12px;font-size:14px;">SHOW DESKTOP VERSION</div></li></a>';

					//alert( xString );
					
					
					document.getElementById( 'nav_thelist' ).innerHTML = xString;
					
					setTimeout(function() {
						xCatListingScroll = new iScroll('nav_wrapper', {
							snap: false, momentum: true, hScrollbar: false
						});
					}, 10);
					
					
					document.getElementById('backnavwindow').style.left = '0px';
					document.getElementById('backnavwindow').style.visibility = 'visible';
				}
			}
		}, 'GET'
	);
	toggleLoadingScreen( 1 );
	document.getElementById( 'mainframe_window_full' ).style.visibility = 'hidden';
}

function showIndex() {
	console.debug('------showIndex------');
	xString = '';
	
	//--------------------------intro title
	xString = xString + '<li style="height:30px;background-color:#000;">';
	if ( indexArray.category_title == '' ) {
		//mainlib.record_photoView( "Newest_listing" );
		xString = xString + '		<div class="list_image_title" style="margin-left:0px;"><img style="width:12px;margin-right:4px;" src="'+ themeURL +'/css/images/dubarrows.png" />Newest ('+ indexArray.photos.length +')</div>';
	} else {
		//mainlib.record_photoView( indexArray.category_title + "_listing" );
		xString = xString + '		<div class="list_image_title" style="margin-left:0px;"><img style="width:12px;margin-right:4px;" src="'+ themeURL +'/css/images/dubarrows.png" />'+ indexArray.category_title + ' ('+ indexArray.photos.length +')</div>';
	}
	xString = xString + '</li>';
	//--------------------------intro title (end)
	
	for (var i = 0; i < indexArray.photos.length; i++) {
		xString = xString + '<li>';
		if ( indexArray.photos[i].vid ) {
			xString = xString + '	<a href="'+ indexArray.photos[i].link +'" onclick="event.returnValue=false;if ( !justClicked ) { loadVideoData(this.href); }">';
		} else {
			xString = xString + '	<a href="'+ indexArray.photos[i].link +'" onclick="event.returnValue=false;if ( !justClicked ) { xGallery.loadGalleryData(this.href); }">';
		}
		xString = xString + '		<img class="list_image" src="'+ indexArray.photos[i].url +'" />';
		xString = xString + '		<div class="list_image_title">'+ processTitle( indexArray.photos[i].title ) +'</div>';
		xString = xString + '		<div class="list_image_date">'+ indexArray.photos[i].date +'</div>';
		xString = xString + '	</a>';
		xString = xString + '</li>';
    }
	
	//--------------------------load more text
	if ( indexArray.photos.length >= 24 ) {
		xString = xString + '<li id="load_more_button" style="height:50px;background-color:#000;" ontouchend="loadMoreGalleriesIntoIndex();">';
		xString = xString + '		<div class="list_image_more_galleries" style="" >Load more galleries >></div>';
		xString = xString + '</li>';
	}
	//--------------------------load more text (end)
	
	//var zyear = d.getUTCFullYear();
	//background: -webkit-gradient(linear, left top, left bottom, color-stop(100%,rgba(0,0,0,0.8)), color-stop(0%,rgba(40,40,40,0.8)) );
	//background: -webkit-linear-gradient(top, #5f000a, #390602);
	//--------------------------bottom DFM window
	var d = new Date().getUTCFullYear();
	xString = xString + '<li class="dfm_box">';
	xString = xString + '		<img style="display: block;margin: 0px auto;width:100px;margin-top:10px;margin-bottom:10px;" src="'+ themeURL +'/css/images/dfm_logo.png" />';
	xString = xString + '		<div style="display: block;margin: 0px auto;width:90%;color:white;font-family:Arial;font-size:10px;color:#FFF;text-align:center;line-height:100%;">';
	xString = xString + '		All contents © '+ d +' Digital First Media or other copyright holders. All rights reserved. This material may not be published, broadcast, rewritten or redistributed for any commercial purpose.</div>';
	xString = xString + '</li>';
	//--------------------------bottom (end)
		
	document.getElementById( 'thelist' ).innerHTML = xString;
	myIndexScroll._resize();
	if ( indexArray.photos.length <= 24 ) {		//only rescroll up at the top on the first initial load
		myIndexScroll.scrollToPage(0, 0, 0);
	}
	//refreshTheMainAd();		//might as well get a new ad here too :)
}

function setAllCSSsizes() {
	console.debug('------setAllCSSsizes------');
	xwidth = window.innerWidth;xheight = window.innerHeight;
	xstylesheet = -1;	//xstylesheets 0 = portrait, 1 = landscape
	
	if ( xInterface.xOrientation == 'portrait' && !xInterface.processedPortrait ) {
		console.debug('			setAllCSSsizes: process portrait');
		//alert( 'process portrait');
		xInterface.processedPortrait = 1;
		xstylesheet = 0;
	} else if ( xInterface.xOrientation == 'landscape' && !xInterface.processedLandscape ) {
		console.debug('			setAllCSSsizes: process landscape');
		//alert( 'process landscape');
		xInterface.processedLandscape = 1;
		xstylesheet = 1;
	}
	
	if ( xstylesheet > -1 ) {
		ChangeStyleSheet('.article_window_full', 'width', xwidth+'px', xstylesheet);
		ChangeStyleSheet('.article_window_full', 'height', xheight+'px', xstylesheet);
		
		ChangeStyleSheet('.mainframe_window_full', 'width', xwidth+'px', xstylesheet);
		ChangeStyleSheet('.mainframe_window_full', 'height', xheight+'px', xstylesheet);
		
		ChangeStyleSheet('#backnavwindow', 'width', xwidth+'px', xstylesheet);
		ChangeStyleSheet('#backnavwindow', 'height', (xheight-40)+'px', xstylesheet);
		
		//-----------gallery
		//ChangeStyleSheet('.gallery_bigImage', 'maxWidth', xwidth +"px", xstylesheet);
		//ChangeStyleSheet('.gallery_bigImage', 'maxHeight', xheight +"px", xstylesheet);
		
		ChangeStyleSheet('#gallery_scroller li', 'width', xwidth +"px", xstylesheet);
		ChangeStyleSheet('#gallery_scroller li', 'height', xheight +"px", xstylesheet);

		ChangeStyleSheet('.gallery_wraptocenter', 'width', xwidth +"px", xstylesheet);
		ChangeStyleSheet('.gallery_wraptocenter', 'height', xheight +"px", xstylesheet);
		
		ChangeStyleSheet('#gallery_wrapper', 'width', xwidth+'px', xstylesheet);
		ChangeStyleSheet('#gallery_wrapper', 'height', xheight+'px', xstylesheet);
		
		ChangeStyleSheet('.gallery_toolbar', 'width', xwidth+'px', xstylesheet);
		
		ChangeStyleSheet('#content', 'width', xwidth+'px', xstylesheet);
		ChangeStyleSheet('#content', 'height', xheight+'px', xstylesheet);
		
		setTimeout('checkCSSafterLoad();', 300);
	}
	
	//iphone		//320 x 416 portrait	?		//480 x 268 landscape	?
	//android		//320 x 508 portrait			//533 x 295 landscape
	
	if ( xGallery.galleryArray["title"] != undefined ) {
		xnumber_of_ads = Math.floor( (xGallery.galleryArray.photos.length - 1 ) / xGallery.ad_every );
		document.getElementById('gallery_scroller').style.width = ( window.innerWidth * ( xGallery.galleryArray.photos.length + 2 + xnumber_of_ads ) ) +"px";	//change size here *****
		if ( xGallery.myGalleryScroll != undefined ) { 
			xGallery.myGalleryScroll._resize();
			setTimeout("xGallery.myGalleryScroll.scrollToPage(xGallery.myGalleryScroll.currPageX, 0);", 200);
		}
		
	} else if ( articleArray.title != undefined ) {
		if ( myArticleScroll != undefined ) {
			myArticleScroll._resize();
			//setTimeout("alert( 'now');myArticleScroll._resize();", 1300);
		}
		
	} else {
		//keep this here. If you hide a gallery in portrait, then turn to landscape it would show, now it wont
		document.getElementById('article_window_full').style.left = xwidth +"px";
	}
	myIndexScroll._resize();
	if ( xCatListingScroll != 0) {
		xCatListingScroll._resize();
	}
	
	
}


function showFullCategoryListing() {
	alert( 'this function is dead: showFullCategoryListing');
	console.debug('------showFullCategoryListing------');
	if ( !xCatListingScroll ) {	//--first see if it exists
		
		//myIndexScroll._resize();
		//myIndexScroll.scrollToPage(0, 0, 0);
	}
	//------now show it
	console.debug('		showing CAT Scroll');
	document.getElementById( 'nav_thelist' ).innerHTML = xString;
	document.getElementById('backnavwindow').style.left = '0px';
	document.getElementById('backnavwindow').style.visibility = 'visible';
}

function toggle_section_nav_window () {
	console.debug('------toggle_section_nav_window------');
	if ( !xCatListingScroll ) {
		//we havent loaded the data yet, so do it now.
		loadCatData();
	} else {
		//data is loaded but now we need to see if we open it or close it.
		
		if ( document.getElementById('backnavwindow').style.left != '0px' ) {
			console.debug('------show backnavwindow------');
			//setTimeout("xCatListingScroll.scrollToPage(0, 0, 0);", 1000);
			xCatListingScroll.scrollToPage(0, 0, 0);
			document.getElementById('backnavwindow').style.left = '0px';
			//document.getElementById('backnavwindow').style.visibility = 'visible';
		} else {
			console.debug('------hide backnavwindow------');
			document.getElementById('backnavwindow').style.left = '5000px';
			document.getElementById( 'mainframe_window_full' ).style.visibility = 'visible';
			//document.getElementById('backnavwindow').style.visibility = 'visible';
		}
	}
	/*
	//if ( justClicked ) return;
	//justClicked = 1; setTimeout("justClicked = 0;", 500);
	
	if ( document.getElementById('section_nav_window').style.top == '40px' ) {
		//-----------nav window is already visible, so hide it
		document.getElementById('section_nav_window').style.top = "-400px";
	} else {
		//-----------nav window is already hidden
		if ( document.getElementById( "loading_container" ) ) {
			//-----------loading container exists
			if (document.getElementById( "loading_container" ).innerHTML == '' ) {
				//-----------loading container exists and is NOT visible (we dont want to show nav if it is visible) 
				document.getElementById('section_nav_window').style.top = "40px";
			}
		} else {
			//----------loading container does not exist, so go ahead and show nav
			document.getElementById('section_nav_window').style.top = "40px";
		}
		
	}
	*/
}

//------------------------------------------------------Gallery object 
//	(continued from universal_tools.js - this is platform specific methods)

Gallery.prototype.buildGalleryScroll = function(){
	this.myGalleryScroll = new iScroll('gallery_wrapper', {
		snap: true,
		momentum: false,
		hScrollbar: false,
		onScrollEnd: function () {
			//document.querySelector('#indicator > li.active').className = '';
			//document.querySelector('#indicator > li:nth-child(' + (this.currPageX+1) + ')').className = 'active';
			
			
			
			
			//console.debug('moved: lastPage: '+ this.lastPage +', currentpage '+ this.currPageX );
			if ( this.lastPage != this.currPageX ) {
				//console.debug('moved: '+ this.momentum[0] +','+ this.momentum[1] +','+ this.momentum[2] );
				var xcount = Number(this.momentum[0]) + Number(this.momentum[1]) + Number(this.momentum[2]);
				if ( ( xcount == 3 && this.dirX == 1 ) || ( xcount == -3 && this.dirX == -1 ) ) {
					//console.debug('three swipes in a row!' );
					if ( (this.dirX == 1) && (xGallery.gallerySlideArray[this.currPageX+1] == 2) ) {
						console.debug('load a forward ad now!' );
						putiFrameAdInDiv( themeURL +"/ads/apt300x250.html?thepagetag=mc_photo&thepagecat="+ xGallery.galleryArray.alldeeezcats2 +"&id="+yld_mgrpub_id+"&stnm="+yld_mgrsite_name+"&ct="+yld_mgrcontent+"&pc="+parent_company, "adposgallery_"+ (this.currPageX+1-1), 300, 250, 'adspace_'+ (this.currPageX+1-1) );
						xGallery.gallerySlideArray[this.currPageX+1] = 20;
						
					} else if ( (this.dirX == -1) && (xGallery.gallerySlideArray[this.currPageX-1] == 2) ) {
						console.debug('load a backward ad now!' );
						putiFrameAdInDiv( themeURL +"/ads/apt300x250.html?thepagetag=mc_photo&thepagecat="+ xGallery.galleryArray.alldeeezcats2 +"&id="+yld_mgrpub_id+"&stnm="+yld_mgrsite_name+"&ct="+yld_mgrcontent+"&pc="+parent_company, "adposgallery_"+ (this.currPageX-1-1), 300, 250, 'adspace_'+ (this.currPageX-1-1) );
						xGallery.gallerySlideArray[this.currPageX-1] = 20;
					}
				}
				
				this.lastPage = this.currPageX;
				
				//---------mobile stuff
				hideAddressBar();
				xGallery.galleryScrollEnd( this.currPageX );
				
				//this.gallerySlideArray = new Array();		//0=photo, 1=intro, 2=ad (unloaded/seen), 3=end, 20=ad (loaded but not seen)
				
			}
			
		}
	});
}

Gallery.prototype.showGallery = function(){
	xString = '';
	
	this.gallerySlideArray = new Array();		//0=photo, 1=intro, 2=ad, 3=end
	var xcount = 0;
	var gtitle = processTitle( this.galleryArray.title );
	
	//----------------------------------------------intro gallery page with ad!
	xString = xString + '<li style="background-color:#333333;" >';
	xString = xString + '	<div id="gallery_intro_top_container" style="">';
	//xString = xString + '		<img id="gallery_intro_thumb" style="" src="'+ this.galleryArray.photos[0].url +'" alt="44" />';
	xString = xString + '		<div id="gallery_intro_headline" style="">'+ gtitle +'</div>';
	xString = xString + '		<div id="gallery_intro_description" style="">'+ unescape(this.galleryArray.description) +'</div>';
	xString = xString + '	</div>';
	xString = xString + '	<div id="gallery_intro_ad_container" style=""></div>';
	xString = xString + '	<div id="gallery_intro_next_text" style="">< < < Swipe left for next image!</div>';
	xString = xString + '</li>';
	this.gallerySlideArray.push(1);
	//alert( decodeHTMLEntities(gtitle) );
	//if(typeof gallerytracklib!='undefined'){
		//make sure the library exists (isnt on local server for some reason)
		//gallib = new gallerytracklib(decodeHTMLEntities(gtitle), false, false);
		//omniTrack((1, this.gallerySlideArray.length);
	//}
	//gallib = new gallerytracklib(decodeHTMLEntities(gtitle), false, false);
	
	//filter: url(blur.svg#gaussian_blur);
	
	for (var i = 0; i < this.galleryArray.photos.length; i++) {
		xString = xString + '	<li id="photoframe_'+ xcount +'" style="position:relative;" ontouchstart="xActiveTouch = 1;" ontouchmove="xActiveTouch = 0;" ontouchend="if (xActiveTouch) { xGallery.toggleTopLayer(); }">';
		xString = xString + '		<div class="gallery_bigImage" style="background-image:url(' + this.galleryArray.photos[i].url +');background-size: contain;"></div>';
		xString = xString + '	</li>';
		xcount = xcount + 1;
		this.gallerySlideArray.push( this.galleryArray.photos[i] );
		
		if ( ( Math.ceil( (i+1) / this.ad_every ) == ( (i+1) / this.ad_every )) && ((i+1) != this.galleryArray.photos.length ) ) { 
			xString = xString + '	<li ontouchstart="xActiveTouch = 1;" ontouchmove="xActiveTouch = 0;" ontouchend="if (xActiveTouch) { xGallery.toggleTopLayer(); }">';
			xString = xString + '			<div id="gallery_wraptocenter" class="gallery_wraptocenter"><span></span><div class="gallery_ad" style="border:1px solid white;width:300px;height:250px;display: inline-block;" id="adspace_'+ xcount +'" ></div></div>';
			xString = xString + '   <div id="gallery_next_text" style="">< Swipe here for next image! ></div>';
			xString = xString + '	</li>';
			xcount = xcount + 1;
			this.gallerySlideArray.push(2);
		}
    }
		omniTrack(1, this.gallerySlideArray.length); // First Omniture track
	
	//----------------------------------------------exit page
	xString = xString + '	<li id="youmightlike_container" >';
	//xString = xString + '		<div id="gallery_wraptocenter" class="gallery_wraptocenter"><span></span>exit page yo!</div>';
	//xString = xString + '		<div id="gallery_wraptocenter" class="gallery_wraptocenter"><span></span>';
	//xString = xString + '			<div id="" class="xGallerybuttonclass"  ontouchstart="xGallery.closeGallery();">Close Gallery</div>';
	//xString = xString + '		</div>';
    xString = xString + '	</li>';
	this.gallerySlideArray.push(3);
	
	document.getElementById('gallery_thelist').innerHTML = xString;
	this.buildGalleryScroll();
	
	//--------------determine when first image is loaded, then SHOW the gallery
	var a = new Image;
	a.onload = function( ){
		setTimeout(function() {
			document.getElementById( 'loading_container_gallery' ).innerHTML = '';
			document.getElementById('gallery_thelist').style.opacity = '1.0';
		}, 10);
	};
	a.src = this.galleryArray.photos[0].url;
	
	document.getElementById( 'gallery_toolbar_xCounter' ).innerHTML = '1 of '+ this.gallerySlideArray.length;
	
	xnumber_of_ads = Math.floor( (this.galleryArray.photos.length - 1 ) / this.ad_every );
	document.getElementById('gallery_scroller').style.width = ( window.innerWidth * ( this.galleryArray.photos.length + 2 + xnumber_of_ads ) ) +"px";	//change size here *****
	
	this.myGalleryScroll._resize();
	setTimeout('putiFrameAdInDiv( themeURL +"/ads/spreed320x50.html?thepagetag=photos&thepagecat=gallery&sku="+spreed_sku, "galleryadlow", 320, 50, "gallery_intro_ad_container" );', 1000);
	
}

Gallery.prototype.clearGallery = function(){
	gallib = null;
	this.galleryArray = new Array();
	articleArray = new Array();
	document.getElementById('gallery_thelist').style.opacity = '0.0';
	document.getElementById('gallery_thelist').innerHTML = '';
	//document.getElementById('gallery_toolbar_xTitle').innerHTML = '';
	document.getElementById('gallery_toolbar_xCounter').innerHTML = '';
	if (this.myGalleryScroll ) { setTimeout("xGallery.myGalleryScroll.scrollToPage(0, 0);", 100);}
}

Gallery.prototype.showLastPageOfGallery = function() {
	if ( !this.lastpagedrawn ) {
		//last page has not been rendered, so render it
		xString = '';
		xString = xString + '	<div style="width:90%;margin:auto;margin-top:48px;font-family:Arial;font-weight:bold;font-size:18px;text-align:left;color:#FFF;">Other galleries you might like:</div>';
		
		xString = xString + '	<div style="width:90%;margin:auto;margin-top:4px;text-align:center;margin-bottom:4px;">';
		var xcount = 4; if ( this.galleryArray.youmightlike.length < xcount) { xcount = this.galleryArray.youmightlike.length; }
		for (var i = 0; i < xcount; i++) {
			xString = xString + '		<div style="position:relative;margin:4px;width:100px;display:inline-block;"  ontouchstart="xActiveTouch = 1;" ontouchmove="xActiveTouch = 0;" onclick="event.returnValue=false;if (xActiveTouch) { xGallery.loadGalleryMightLike(\''+ this.galleryArray.youmightlike[i].link +'\'); }">';
			xString = xString + '		<div style="background-size: 100%;width:100%;height:100px;border:1px solid #FFF;background-image:url(' + this.galleryArray.youmightlike[i].url +');background-repeat:no-repeat;"></div>';
			//xString = xString + '				<div class="list_image_title" style="margin:5px 0px 0px 0px;width:100%;">'+ processTitle( this.galleryArray.youmightlike[i].title ) +'</div>';
			xString = xString + '				<div class="list_image_date" style="margin:5px 0px 0px 0px;">'+ this.galleryArray.youmightlike[i].date.toUpperCase() +'</div>';
			xString = xString + '		</div>'
		}
		
		/*
		xString = xString + '	<div style="position:relative;margin:10px;width:200px;display:inline-block;"  ontouchstart="xActiveTouch = 1;" ontouchmove="xActiveTouch = 0;" onclick="event.returnValue=false;if (xActiveTouch) { xGallery.closeGallery(); }">';
		xString = xString + '		<div style="background-size: 100%;width:100%;height:100px;border:1px solid #FFF;background-image:url(' + themeURL +'/css/images/back_home.png);background-repeat:no-repeat;"></div>';
		xString = xString + '				<div class="list_image_title" style="margin:5px 0px 0px 0px;width:100%;">Click here to go back</div>';
		xString = xString + '				<div class="list_image_date" style="margin:-4px 0px 0px 0px;">HOME</div>';
		xString = xString + '		</div>';
		xString = xString + '	</div>';
		*/
		document.getElementById('youmightlike_container').innerHTML = xString;
		this.lastpagedrawn = 1;
	}
}
//------------------------------------------------------Gallery object (end)



function scrollBackIntoView() {
	console.debug('------scrollBackIntoView------');
	//only callled from interface when ads are moved
	//alert( window.parent.window.pageXOffset +':'+ window.parent.document.body.scrollLeft );
	if ( window.pageXOffset > 0 ) {
		window.scrollTo(0, 1);
	}
	//-----we check this here for iphone so that the user can scroll the screen down to see the url bar if they want.
}

function resizeScreen() {
	hideAddressBar();
	setTimeout('setAllCSSsizes();', 500);	//
}

