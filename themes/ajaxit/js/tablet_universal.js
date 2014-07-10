//1280 x 800
var backNavScroll;
var movecount = 1;
var imagesPerIndexPage=12;

function interfaceLoaded () {
	console.debug('------interfaceLoaded------');
	//xInterface.xOrientation = 0;			//this is necessary for slow android boo!
	
	xGallery = new Gallery();
	toggleHTML = document.getElementById( "loading_container" ).innerHTML;
	//alert( toggleHTML );
	//setTimeout('determineOrientation( function(){ setAllCSSsizes(); } );', 100);
	setTimeout('determineOrientation( function(){ setAllCSSsizes();setTimeout("runDoNext();", 1000); } );', 500);
	
	//if(typeof gallerytracklib!='undefined'){
		//make sure the library exists (isnt on local server for some reason)
		//mainlib = new gallerytracklib(decodeHTMLEntities('tablet_main_listing'), false, false);
		//omniTrack(1, this.gallerySlideArray.length);
	//}
	//alert( processSSPurl( 'http://mcenter.slideshowpro.com/albums/027/935/album-308918/cache/022912_nuggetsBlazers_1.sJPG_900_540_0_95_1_50_50.sJPG?1330650190', 300, 300, 1 ) );
}

function showArticle() {
	console.debug('------showArticle------');
	var xtitle = processTitle( articleArray.title );
	document.getElementById('gallery_toolbar_xTitle').innerHTML = xtitle;
	//article_content
	document.getElementById('article_thelist').innerHTML = '<li style="margin:0px 30px 0px 30px;font-family:Arial;font-weight:normal;font-size:14px;line-height:14px;color:#000;text-align:left;padding:0px;"><BR><span style="font-weight:bold;font-size:22px;line-height:24px;margin:10px 0px 10px 0px;">'+ xtitle +'</span>'+ articleArray.text_article +'</li>';
	setTimeout("buildArticleScroll();", 300);
}

function buildIndexScroll () {
	myIndexScroll = new iScroll('wrapper', {
		snap: false,
		momentum: true
	});
	/*
	myIndexScroll = new iScroll('wrapper', {
		snap: true,
		momentum: false,
		hScrollbar: false,
		onScrollEnd: function () {
			//console.debug('moved: lastPage: '+ this.lastPage +', currentpage '+ this.currPageX );
			if ( this.lastPage != this.currPageX ) {
				s.t();
				
				//---------omniture code to catch listing views
				//if ( indexArray.category_title == '' ) {
				//	mainlib.record_photoView( "Newest_listing" );
				//} else {
				//	mainlib.record_photoView( indexArray.category_title + "_listing" );
				//}
				
				movecount = movecount + 1;
				if ( movecount > 3 ) {
					movecount = 1;
					refreshTheMainAd();
				}
				
				console.debug('moved: '+ myIndexScroll.momentum[0] +','+ myIndexScroll.momentum[1] +','+ myIndexScroll.momentum[2] );
				this.lastPage = this.currPageX;
				hideBackNav();
				
				
			}
		}
	});
	*/
}

function buildArticleScroll () {
	myArticleScroll = new iScroll('article_wrapper', {
		snap: false,
		momentum: true
	});
}

function buildBackNavScroll () {
	backNavScroll = new iScroll('nav_wrapper', {
		snap: false,
		momentum: true,
		hScrollbar: false,
		onScrollEnd: function () {
			//console.debug('moved: lastPage: '+ this.lastPage +', currentpage '+ this.currPageX );
			
		}
	});
}

function showIndex() {
	console.debug('------showIndex------');
	//indexArray = eval ("(" + xdata + ")");
	//indexArray.photos[12].url
	//indexArray.photos[12].title
	//indexArray.photos[12].date
	//indexArray.photos[12].link
	//alert(indexArray.photos.length );
	//
	var xCatTitle;
	if ( indexArray.category_title == '' ) {
		xCatTitle = 'Newest' + ' ('+ indexArray.photos.length +')';
		//document.getElementById( 'toolbar_category_text' ).innerHTML = 'Newest';
	} else {
		xCatTitle = indexArray.category_title + ' ('+ indexArray.photos.length +')';
		//document.getElementById( 'toolbar_category_text' ).innerHTML = indexArray.category_title + ' ('+ indexArray.photos.length +')';
	}
	document.getElementById( 'toolbar_category_text' ).innerHTML = xCatTitle;
	//mainlib.record_photoView( xCatTitle + "_listing" );
	
	
	var xString = '';
	
	for (var i = 0; i < indexArray.photos.length; i++) {
		if ( indexArray.photos[i].vid ) {
			xString = xString + '<li style="float:left;" ontouchstart="xActiveTouch = 1;" ontouchmove="xActiveTouch = 0;" onclick="event.returnValue=false;if (xActiveTouch) { loadVideoData(\''+ indexArray.photos[i].link +'\'); }">';
			//xString = xString + '	<a href="'+ indexArray.photos[i].link +'" onclick="event.returnValue=false;if ( !justClicked ) { loadVideoData(this.href); }">';
		} else {
			xString = xString + '<li style="float:left;" ontouchstart="xActiveTouch = 1;" ontouchmove="xActiveTouch = 0;" onclick="event.returnValue=false;if (xActiveTouch) { xGallery.loadGalleryData(\''+ indexArray.photos[i].link +'\'); }">';
		}
		
		xString = xString + '	<div class="scroller_li_mid" style="position:relative;background-image:url(' + indexArray.photos[i].url +');">';
		xString = xString + '			<div class="list_image_title_container">';
		xString = xString + '				<div class="list_image_title">'+ processTitle( indexArray.photos[i].title ) +'</div>';
		xString = xString + '				<div class="list_image_date">'+ indexArray.photos[i].date.toUpperCase() +' | PHOTO</div>';
		xString = xString + '			</div>';
		xString = xString + '	</div>';
		xString = xString + '</li>';
	}
	//width:200px;height:200px;float:left;border:1px solid red;font-size:14px;
	
	//--------------------------load more text
	if ( indexArray.photos.length >= 24 ) {
		xString = xString + '<li id="load_more_button" style="border-bottom:1px solid #000;float:left;width:100%;height:50px;background-color:#333;" ontouchend="loadMoreGalleriesIntoIndex();">';
		xString = xString + '		<div class="list_image_more_galleries" style="" >Load more galleries >></div>';
		xString = xString + '</li>';
	}
	//border-top:1px solid rgba(126,0,24,1);
	//--------------------------load more text (end)
	
	document.getElementById('thelist').innerHTML = xString;
	//alert( myIndexScroll );
	
	if ( myIndexScroll == undefined ) {
		setTimeout("buildIndexScroll();", 100);
	} else {
		myIndexScroll._resize();
	}
	
	//'<li style="font-family:Arial;font-weight:normal;font-size:14px;line-height:14px;color:#000;text-align:left;padding:0px;margin:0px 5px 0px 5px;">
	//<span style="font-weight:bold;font-size:22px;line-height:24px;margin-bottom:10px;">'+ xtitle +'</span>'+ articleArray.text_article +'</li>';
	//
	
	//alert( indexArray.category_title );
	
	/*
	////
	if ( xInterface.xOrientation == 'landscape' ) {
		//---set the sizes of the list containers
		zwidth = Math.floor( (window.innerWidth)/4);	//1280
		zheight = Math.floor( (window.innerHeight - 140) /3);	//656
		zsize = Math.max( zwidth, zheight, Math.floor( (window.innerHeight)/3), Math.floor( (window.innerWidth - 140) /4)  ); 
	} else  {
		zwidth = Math.floor( (window.innerWidth)/3); //xrule.style.width = xwidth+"px";
		zheight = Math.floor( (window.innerHeight - 140) /4);
		zsize = Math.max( zwidth, zheight, Math.floor( (window.innerHeight)/4), Math.floor( (window.innerWidth - 140) /3)  ); 
	}
	//zwidth = Math.max(zwidth,zheight, Math.floor( (window.innerWidth)/3), Math.floor( (window.innerHeight - 140) /4)); 
	//zwidth = 400;
	//zheight = 400;
	//alert( zwidth +', '+ zheight );
	
	
	
	//--------------------------create frames to hold images (that scroll)
	var numberOfPages = Math.ceil(indexArray.photos.length / imagesPerIndexPage);
	var xString = '';
	for (var i = 1; i <= numberOfPages; i++) {
		xString = xString + '<li id="index_box_'+ i +'" style="background-color:black;"></li>';
	}
	document.getElementById( 'thelist' ).innerHTML = xString;
	//--------------------------create frames to hold images (that scroll) (end)
	*/
	
	/*
	for (var i = 0; i < indexArray.photos.length; i++) {
		//ontouchstart="xActiveTouch = 1;" ontouchmove="xActiveTouch = 0;" ontouchend="if (xActiveTouch) { toggleTopLayer(); }"
		var xString = '';
		xString = xString + '	<a href="'+ indexArray.photos[i].link +'" ontouchstart="xActiveTouch = 1;" ontouchmove="xActiveTouch = 0;" onclick="event.returnValue=false;if (xActiveTouch) { xGallery.loadGalleryData(this.href); }" >';
		xString = xString + '		<div class="list_image_container" style="position:relative;">';
		//xString = xString + '		<div class="" style="position:absolute;top:0px;left:0px;width:100%;height:100%;background-color:none;box-shadow:inset 0 0 10px #000000;"></div>';
		//xString = xString + '			<img class="list_image" style="" src="'+ indexArray.photos[i].url +'" />';
		xString = xString + '			<img class="list_image" style="" src="'+ processSSPurl( indexArray.photos[i].url, zsize, zsize, 1 ) +'" />';
		xString = xString + '			<div class="list_image_title_container">';
		xString = xString + '				<div class="list_image_title">'+ processTitle( indexArray.photos[i].title ) +'</div>';
		xString = xString + '				<div class="list_image_date">'+ indexArray.photos[i].date.toUpperCase() +' | PHOTO</div>';
		xString = xString + '			</div>';
		xString = xString + '		</div>';
		xString = xString + '	</a>';
		//<span class="tagcolor">photo</span>
		
		//-----------------------------------------drawing it to the screen ****THIS NEEDS TO BE REDONE
		document.getElementById( 'index_box_'+ Math.ceil( (i+1) / imagesPerIndexPage) ).innerHTML = document.getElementById( 'index_box_'+ Math.ceil( (i+1) / imagesPerIndexPage) ).innerHTML + xString;
		//-----------------------------------------drawing it to the screen ****THIS NEEDS TO BE REDONE (end)
    }
	
	//--------create the width of the scroller
	document.getElementById('scroller').style.width = (window.innerWidth* numberOfPages )+'px';
	//--------build the scroller
	setTimeout("buildIndexScroll();", 200);
	
	setTimeout("setAllCSSsizes();", 500);
	//setTimeout("myIndexScroll.scrollToPage(1, 0, 0);", 1000);
	
	setTimeout("document.getElementById('index_box_1').style.opacity = '1.0';", 500);
	setTimeout("document.getElementById('index_box_2').style.opacity = '1.0';", 500);
	//setTimeout("document.getElementById('index_box_3').style.opacity = '1.0';", 500);
	//alert( 234 );
	*/
	
	refreshTheMainAd();		//might as well get a new ad here too :)
}

function orientationHasChanged() {
	console.debug('------orientationHasChanged------');
	determineOrientation( function(){ setAllCSSsizes(); } );
	//setTimeout('determineOrientation();', 100);
	if ( xGallery.galleryArray["title"] != undefined ) {
		//----------------------------rotate the gallery
	} else {
		//----------------------------rotate the main index area
	}
	window.scrollTo(0, 0);
}

function setAllCSSsizes() {
	console.debug('------setAllCSSsizes------');
	//alert( 'setallcsssizes');
	//console.debug('--function setallcsssizes: xOrientation = '+ xOrientation);
	xwidth = window.innerWidth;xheight = window.innerHeight;
	xstylesheet = -1;	//xstylesheets 0 = portrait, 1 = landscape
	
	if ( (xInterface.xOrientation == 'portrait') && (!xInterface.processedPortrait) ) {
		//alert( 'process portrait');
		console.debug('			process portrait');
		xInterface.processedPortrait = 1;
		xstylesheet = 0;
	} else if ( (xInterface.xOrientation == 'landscape') && (!xInterface.processedLandscape) ) {
		//alert( 'process landscape');
		console.debug('			process landscape');
		xInterface.processedLandscape = 1;
		xstylesheet = 1;
	}
	
	if ( xstylesheet > -1 ) {
		//OK, we need to set styles for orientation stylesheet xstylesheet
		//document.getElementById('content').style.height = window.innerHeight +"px";
		//ChangeStyleSheet('#content', 'border', '1px solid red', xstylesheet);
		//alert( xwidth +':'+ xheight );
		console.debug(xwidth +':'+ xheight +': xstylesheet: '+ xstylesheet);
		
		ChangeStyleSheet('.article_window_full', 'width', xwidth+'px', xstylesheet);
		ChangeStyleSheet('.article_window_full', 'height', xheight+'px', xstylesheet);
		
		ChangeStyleSheet('.mainframe_window_full', 'width', xwidth+'px', xstylesheet);
		//ChangeStyleSheet('.mainframe_window_full', 'height', xheight+'px', xstylesheet);	//do not need to change this
		
		//-----------gallery
		ChangeStyleSheet('.gallery_bigImage', 'maxWidth', xwidth +"px", xstylesheet);
		ChangeStyleSheet('.gallery_bigImage', 'maxHeight', xheight +"px", xstylesheet);
		
		ChangeStyleSheet('#gallery_scroller li', 'width', xwidth +"px", xstylesheet);
		ChangeStyleSheet('#gallery_scroller li', 'height', xheight +"px", xstylesheet);

		ChangeStyleSheet('.gallery_wraptocenter', 'width', xwidth +"px", xstylesheet);
		ChangeStyleSheet('.gallery_wraptocenter', 'height', xheight +"px", xstylesheet);
		
		ChangeStyleSheet('#gallery_wrapper', 'width', xwidth+'px', xstylesheet);
		ChangeStyleSheet('#gallery_wrapper', 'height', xheight+'px', xstylesheet);
		
		//ChangeStyleSheet('#wrapper', 'width', xwidth+'px', xstylesheet);
		//ChangeStyleSheet('#wrapper', 'height', xheight+'px', xstylesheet);
		
		ChangeStyleSheet('.gallery_toolbar', 'width', xwidth+'px', xstylesheet);
		
		ChangeStyleSheet('#content', 'width', xwidth+'px', xstylesheet);
		ChangeStyleSheet('#content', 'height', xheight+'px', xstylesheet);
		
		//ChangeStyleSheet('#scroller li', 'width', xwidth+'px', xstylesheet);
		
		//ChangeStyleSheet('.article_content', 'width', xwidth+'px', xstylesheet);
		//ChangeStyleSheet('.article_content', 'height', xheight+'px', xstylesheet);
		
		//ChangeStyleSheet('#article_wrapper', 'width', xwidth+'px', xstylesheet);
		//ChangeStyleSheet('#article_wrapper', 'height', xheight+'px', xstylesheet);
		//ChangeStyleSheet('#article_scroller li', 'width', xwidth+'px', xstylesheet);
		
		//------------------------------------
		//document.getElementById('#scroller').style.width = ( window.innerWidth * 3 ) +"px";
		//ChangeStyleSheet('#scroller', 'width', (xwidth*2)+'px', xstylesheet);
		
		
		//--------------------------------------set sizes for index images on main screen
		if ( xInterface.xOrientation == 'landscape' ) {
			//---set the sizes of the list containers
			var zwidthsmall = Math.floor( (window.innerWidth)/8) - 2;
			var zwidthmid = Math.floor( (window.innerWidth)/4) - 2;
			var zwidthlarge = Math.floor( (window.innerWidth)/3) - 2;
		} else  {
			var zwidthsmall = Math.floor( (window.innerWidth)/6) - 2;
			var zwidthmid = Math.floor( (window.innerWidth)/3) - 2;
			var zwidthlarge = Math.floor( (window.innerWidth)/3) - 2;
		}
		
		ChangeStyleSheet('.scroller_li_small', 'height', zwidthsmall+'px', xstylesheet);
		ChangeStyleSheet('.scroller_li_small', 'width', zwidthsmall+'px', xstylesheet);
		
		ChangeStyleSheet('.scroller_li_mid', 'height', zwidthmid+'px', xstylesheet);
		ChangeStyleSheet('.scroller_li_mid', 'width', zwidthmid+'px', xstylesheet);
		
		ChangeStyleSheet('.scroller_li_large', 'height', zwidthlarge+'px', xstylesheet);
		ChangeStyleSheet('.scroller_li_large', 'width', zwidthlarge+'px', xstylesheet);
		
		/*
		if ( zheight <= zwidth ) {
			ChangeStyleSheet('.list_image', 'width', zwidth+'px', xstylesheet);
		} else {
			ChangeStyleSheet('.list_image', 'height', zheight+'px', xstylesheet);
		}
		
		ChangeStyleSheet('.list_image', 'margin', xmargin+'px 0px 0px 0px', xstylesheet);
		*/
		
		setTimeout('checkCSSafterLoad();', 300);
	}
	
	//sizes have been changed, now we need to resize any galleries that are currently open and jump to the current slide
	if ( xGallery.galleryArray["title"] != undefined ) {
		//alert( window.innerWidth );
		xnumber_of_ads = Math.floor( (xGallery.galleryArray.photos.length - 1 ) / xGallery.ad_every );
		document.getElementById('gallery_scroller').style.width = ( xwidth * ( xGallery.galleryArray.photos.length + 2 + xnumber_of_ads ) ) +"px";	//change size here *****
		//xGallery.myGalleryScroll._resize();
		if ( xGallery.myGalleryScroll != undefined ) {
			xGallery.myGalleryScroll._resize();
			setTimeout("xGallery.myGalleryScroll.scrollToPage(xGallery.myGalleryScroll.currPageX, 0);", 200);
		}
		//myIndexScroll._resize();
	} else if ( articleArray.title != undefined ) {
		if ( myArticleScroll != undefined ) {
			myArticleScroll._resize();
			//setTimeout("alert( 'now');myArticleScroll._resize();", 1300);
		}
		
	} else {
		//keep this here. If you hide a gallery in portrait, then turn to landscape it would show, now it wont
		document.getElementById('article_window_full').style.left = xwidth +"px";
	}
	
	if ( myIndexScroll != undefined ) { //resize the index scroll
		//document.getElementById('scroller').style.width = (xwidth * Math.ceil(indexArray.photos.length / imagesPerIndexPage) )+'px';
		myIndexScroll._resize();	
	}
	
	
	
	//if (indexArray.length != 0) {
		//this is required because on some slow loads, this will get called before the script is loaded...wierdness
		//setTimeout("myIndexScroll.scrollToPage(myIndexScroll.currPageX, 0);", 200);
	//}
	
	if ( document.getElementById('content').style.height == 0 ) {
		//alert( 'height issue on #content: '+ document.getElementById('content').style.height );
	}
}


//------------------------------------------------------Gallery object 
//	(continued from universal_tools.js - this is platform specific methods)

Gallery.prototype.buildGalleryScroll = function(){
	this.myGalleryScroll = new iScroll('gallery_wrapper', {
		snap: true,
		momentum: false,
		hScrollbar: false,
		onScrollEnd: function () {
			//console.debug('moved: lastPage: '+ this.lastPage +', currentpage '+ this.currPageX );
			if ( this.lastPage != this.currPageX ) {
				//console.debug('moved: '+ this.momentum[0] +','+ this.momentum[1] +','+ this.momentum[2] );
				var xcount = Number(this.momentum[0]) + Number(this.momentum[1]) + Number(this.momentum[2]);
				if ( ( xcount == 3 && this.dirX == 1 ) || ( xcount == -3 && this.dirX == -1 ) ) {
					console.debug('three swipes in a row!' );
					if ( (this.dirX == 1) && (xGallery.gallerySlideArray[this.currPageX+1] == 2) ) {
						console.debug('load a forward ad now!' );
						putiFrameAdInDiv( themeURL +"/ads/apt300x250.html?thepagetag=mc_photo&thepagecat="+ xGallery.galleryArray.alldeeezcats2 +"&id="+yld_mgrpub_id+"&stnm="+yld_mgrsite_name+"&ct="+yld_mgrcontent+"&pc="+parent_company, "adposgallery_"+ (this.currPageX+1-1), 300, 250, 'adspace_'+ (this.currPageX+1-1) );
						xGallery.gallerySlideArray[this.currPageX+1] = 20;
						
					} else if ( (this.dirX == -1) && (xGallery.gallerySlideArray[this.currPageX-1] == 2) ) {
						console.debug('load a backward ad now!' );
						putiFrameAdInDiv( themeURL +"/ads/apt300x250.html?thepagetag=mc_photo&&thepagecat="+ xGallery.galleryArray.alldeeezcats2 +"&id="+yld_mgrpub_id+"&stnm="+yld_mgrsite_name+"&ct="+yld_mgrcontent+"&pc="+parent_company, "adposgallery_"+ (this.currPageX-1-1), 300, 250, 'adspace_'+ (this.currPageX-1-1) );
						xGallery.gallerySlideArray[this.currPageX-1] = 20;
					}
				}
				
				this.lastPage = this.currPageX;
				xGallery.galleryScrollEnd( this.currPageX );
				
				//this.gallerySlideArray = new Array();		//0=photo, 1=intro, 2=ad (unloaded/seen), 3=end, 20=ad (loaded but not seen)
				
			}
		}
	});
}

Gallery.prototype.showGallery = function(){
	console.debug('------Gallery.prototype.showGallery------');
	var gtitle = processTitle( this.galleryArray.title );
	document.getElementById('gallery_toolbar_xTitle').innerHTML = gtitle;
	
	hideBackNav();	//just in case its shown
	
	//console.debug('gallerytracklib: '+ gtitle);
	//if(typeof gallerytracklib!='undefined'){
		//make sure the library exists (isnt on local server for some reason)
		//gallib = new gallerytracklib(decodeHTMLEntities(gtitle), false, false);
	//}
	//alert( (typeof iScroll!='undefined') );
	
	//gallib.record_photoView('Gallery Intro');
	//document.getElementById('gallery_toolbar_xCounter').innerHTML = '1 of '+ galleryArray.photos.length;
	xString = '';
	
	this.gallerySlideArray = new Array();		//0=photo, 1=intro, 2=ad, 3=end
	var xcount = 0;
	
	//----------------------------------------------intro gallery page with ad!
	xString = xString + '<li style="background-color:#333333;">';
	xString = xString + '	<div id="gallery_intro_top_container" style="">';
	xString = xString + '		<img id="gallery_intro_thumb" style="" src="'+ this.galleryArray.photos[0].url +'" alt="44" />';
	xString = xString + '		<div id="gallery_intro_headline" style="">'+ processTitle( this.galleryArray.title ) +'</div>';
	xString = xString + '		<div id="gallery_intro_description" style="">'+ this.galleryArray.description +'</div>';
	xString = xString + '	</div>';
	xString = xString + '	<div id="gallery_intro_ad_container" style=""></div>';
	xString = xString + '	<div id="gallery_intro_next_text" style="">< < < Swipe left for next image!</div>';
	xString = xString + '</li>';
	
	this.gallerySlideArray.push(1);
	
	//processSSPurl( 'http://mcenter.slideshowpro.com/albums/027/935/album-308918/cache/022912_nuggetsBlazers_1.sJPG_900_540_0_95_1_50_50.sJPG?1330650190', 300, 300, 1 )
	for (var i = 0; i < this.galleryArray.photos.length; i++) {
		//xString = xString + '	<li ontouchstart="xActiveTouch = 1;" ontouchmove="xActiveTouch = 0;" ontouchend="if (xActiveTouch) { xGallery.toggleTopLayer(); }">';
		//xString = xString + '		<div id="gallery_wraptocenter" class="gallery_wraptocenter"><span></span><img id="g_image_'+ (i+1)+'" class="gallery_bigImage" style="" src="'+ this.galleryArray.photos[i].url +'" alt="none" /></div>';
        //xString = xString + '	</li>';
		xString = xString + '	<li ontouchstart="xActiveTouch = 1;" ontouchmove="xActiveTouch = 0;" ontouchend="if (xActiveTouch) { xGallery.toggleTopLayer(); }">';
		xString = xString + '		<div class="gallery_bigImage" id="g_image_'+ (i+1)+'" style="background-image:url(' + this.galleryArray.photos[i].url +');background-size: contain;"></div>';
		xString = xString + '	</li>';
		
		xcount = xcount + 1;
		this.gallerySlideArray.push( this.galleryArray.photos[i] );	//gallerySlideArray.push(0);
		
		if ( ( Math.ceil( (i+1) / this.ad_every ) == ( (i+1) / this.ad_every )) && ((i+1) != this.galleryArray.photos.length ) ) {
			xString = xString + '	<li ontouchstart="xActiveTouch = 1;" ontouchmove="xActiveTouch = 0;" ontouchend="if (xActiveTouch) { xGallery.toggleTopLayer(); }">';
			xString = xString + '		<div id="gallery_wraptocenter" class="gallery_wraptocenter"><span></span><div class="gallery_ad" style="border:1px solid white;width:300px;height:250px;display: inline-block;" id="adspace_'+ xcount +'" ></div></div>';
            xString = xString + '   <div id="gallery_next_text" style="">< < < Swipe here for next image! > > ></div>';
	        xString = xString + '	</li>';
			
			xcount = xcount + 1;
			this.gallerySlideArray.push(2);
		}
    }
	omniTrack(1, this.gallerySlideArray.length); // First Omniture track
	//----------------------------------------------exit gallery page
	xString = xString + '	<li id="youmightlike_container" style="background-color:#333;">';
	//xString = xString + '		<div id="gallery_wraptocenter" class="gallery_wraptocenter"><span></span>';
	//xString = xString + '			<div id="" class="xGallerybuttonclass"  ontouchstart="xGallery.closeGallery();">Close Gallery</div>';
	//xString = xString + '		</div>';
    xString = xString + '	</li>';

	/*
	xString = xString + '	<li style="background-color:#333333;" ontouchstart="xActiveTouch = 1;" ontouchmove="xActiveTouch = 0;" ontouchend="if (xActiveTouch) { toggleTopLayer(); }">';
	xString = xString + '		<div id="youmightlike_container" style="margin-top:50px;">';
			// $xquery = "cat=" . $related . "&showposts=5&offset=1&tag=Photo"; include (THEMELIB . '/functions/querylist_bar.php'); 
	xString = xString + '		<div style="margin:0px 15px 0px 15px;height:1px;width:max-width:100%;border-top:1px solid #666;"></div>';
			// $xquery = "cat=" . $related . "&showposts=5&offset=6&tag=Photo"; include (THEMELIB . '/functions/querylist_bar.php'); 
			
			// $xquery = "cat=" . $related . "&showposts=5&offset=11&tag=Photo"; include (THEMELIB . '/functions/querylist_bar.php'); 
	xString = xString + '		</div>';
	xString = xString + '	</li>';
	*/
	this.gallerySlideArray.push(3);
	//----------------------------------------------exit gallery page (end)
	
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
	
	setTimeout("setAllCSSsizes();", 500);
	//<div class="adholder" align="center" style="margin-top:-50px;min-height:100px;">
	//	<iframe src="<?php echo bloginfo('template_directory') . '/ads/photo728x90.html'; ?>?thepagetag=<?php echo $thepagetag ?>&thepagecat=<?php echo $alldeeezcats2; ?>" id="adpos14_iframe" name="adpos14_iframe" width="728" height="90" frameborder="0" marginheight="0" marginwidth="0" scrolling="no"></iframe>
	//</div>
	//setupSharing();
	
	setTimeout('putiFrameAdInDiv( themeURL +"/ads/apt728x90.html?thepagetag=photo_galleries&thepagecat="+ xGallery.galleryArray.alldeeezcats2 +"&id="+yld_mgrpub_id+"&stnm="+yld_mgrsite_name+"&ct="+yld_mgrcontent+"&pc="+parent_company, "galleryfrontlow", 728, 90, "gallery_intro_ad_container" );', 1200);
	//http://192.168.1.105/mediacenter/wp-content/themes/mcenter/ads/photo728x90.html?thepagetag=mc_photo&thepagecat=mc_entertainment-mc_hollywood-mc_movies-mc_music&mcpubid=23850269999&mcsitename=www.twincities.com&mcccc=20337001
}

Gallery.prototype.clearGallery = function(){
	console.debug('------Gallery.prototype.clearGallery------');
	//alert( 'scrolled back');
	gallib = null;
	this.galleryArray = new Array();
	articleArray = new Array();
	document.getElementById('gallery_thelist').style.opacity = '0.0';
	document.getElementById('gallery_thelist').innerHTML = '';
	document.getElementById('gallery_toolbar_xTitle').innerHTML = '';
	document.getElementById('gallery_toolbar_xCounter').innerHTML = '';
	
	if (this.myGalleryScroll ) { setTimeout("xGallery.myGalleryScroll.scrollToPage(0, 0);", 100);}
	refreshTheMainAd();
}

Gallery.prototype.showLastPageOfGallery = function() {
	//this draws the content of the last page. It is not created at gallery opening because we really dont need to load these images until user gets to end of gallery. Only do it once.
	if ( !this.lastpagedrawn ) {
		//last page has not been rendered, so render it
		xString = '';
		xString = xString + '	<div style="width:96%;margin:auto;margin-top:56px;font-family:Arial;font-weight:bold;font-size:22px;text-align:left;color:#FFF;">Other galleries you might like:</div>';
		
		xString = xString + '	<div style="width:96%;margin:auto;margin-top:4px;text-align:center;">';
		for (var i = 0; i < this.galleryArray.youmightlike.length; i++) {
			xString = xString + '		<div style="position:relative;margin:10px;width:200px;display:inline-block;"  ontouchstart="xActiveTouch = 1;" ontouchmove="xActiveTouch = 0;" onclick="event.returnValue=false;if (xActiveTouch) { xGallery.loadGalleryMightLike(\''+ this.galleryArray.youmightlike[i].link +'\'); }">';
			xString = xString + '		<div style="background-size: 100%;background-position:0px -50px;width:100%;height:100px;border:1px solid #FFF;background-image:url(' + this.galleryArray.youmightlike[i].url +');background-repeat:no-repeat;"></div>';
			xString = xString + '				<div class="list_image_title" style="margin:5px 0px 0px 0px;width:100%;">'+ processTitle( this.galleryArray.youmightlike[i].title ) +'</div>';
			xString = xString + '				<div class="list_image_date" style="margin:-4px 0px 0px 0px;">'+ this.galleryArray.youmightlike[i].date.toUpperCase() +' | PHOTO</div>';
			xString = xString + '		</div>'
		}
		
		xString = xString + '	<div style="position:relative;margin:10px;width:200px;display:inline-block;"  ontouchstart="xActiveTouch = 1;" ontouchmove="xActiveTouch = 0;" onclick="event.returnValue=false;if (xActiveTouch) { xGallery.closeGallery(); }">';
		xString = xString + '		<div style="background-size: 100%;width:100%;height:100px;border:1px solid #FFF;background-image:url(' + themeURL +'/css/images/back_home.png);background-repeat:no-repeat;"></div>';
		xString = xString + '				<div class="list_image_title" style="margin:5px 0px 0px 0px;width:100%;">Click here to go back</div>';
		xString = xString + '				<div class="list_image_date" style="margin:-4px 0px 0px 0px;">HOME</div>';
		xString = xString + '		</div>';
		xString = xString + '	</div>';
		document.getElementById('youmightlike_container').innerHTML = xString;
		this.lastpagedrawn = 1;
	}
}

//------------------------------------------------------Gallery object (end)

function loadIndexData( xURL ) {
	//----process here is fade off main content in .25 sec, THEN load the content
	document.getElementById( 'toolbar_category_text' ).innerHTML = '';
	setTimeout("loadIndexURL('"+ xURL +"');", 250);
	
	indexArray = new Array();
	//document.getElementById('index_box_1').style.opacity = '0.0';
	//document.getElementById('index_box_2').style.opacity = '0.0';
	//document.getElementById('index_box_3').style.opacity = '0.0';
	
	if ( myIndexScroll ) { 
		//setTimeout("document.getElementById('index_box_1').innerHTML = '';", 250);
		//setTimeout("document.getElementById('index_box_2').innerHTML = '';", 250);
		setTimeout("document.getElementById( 'thelist' ).innerHTML = '';", 250);
		setTimeout("myIndexScroll.destroy();myIndexScroll = undefined;", 250);
		
	}
}

function showFullCategoryListing() {
	alert( 'function showFullCategoryListing is not built yet, not sure i need it for ipad');
}

function scrollBackIntoView() {
	//console.debug('------scrollBackIntoView------');
	//only callled from interface when ads are moved
	window.scrollTo(0, 0);
	//document.getElementById('content').style.left = (document.getElementById('content').style.left + 1) + 'px';
}

function hideBackNav() {
	if ( document.getElementById('content').style.left != '0px' ) {
		//backnav window is shown, so put content back//
		document.getElementById('content').style.left = '0px';
		setTimeout("document.getElementById('backnavwindow').style.visibility = 'hidden';", 250);
	}
}

function toggle_section_nav_window () {
	if ( justClicked ) return;
	justClicked = 1; setTimeout("justClicked = 0;", 1000);
	
	if ( document.getElementById('content').style.left != '250px' ) {
		if ( backNavScroll == undefined ) {
			buildBackNavScroll();
		}
		document.getElementById('backnavwindow').style.visibility = 'visible';
		document.getElementById('content').style.left = '250px';
	} else {
		hideBackNav();
	}
}
