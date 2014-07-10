/*
** JS to create a Large (500px wide) Media Center Rotator
** Authors:
	JavaScript: Josh Kozlowski
	HTML and CSS: Jonanthan Boho and Josh Kozlowski
	Last Modified: 03/12/2012
	Version: 1.0

***** example of options object		
	var mc_rotator_large_options = {
	non_generic : false, //only do this if you want the rotator to pull from all galleries and the "rotator-home" curated category
	link_four : ['Broncos','www.denverpost.com/broncos'],
	domain: 'denverpost', //only do this when you need to specify a domain,
	category: 'olympics' //the WordPress category slug that is queried to generate the rotator's feed
	};

******/
var mc_rotator_large_options = mc_rotator_large_options || {};
var mc_rotator_large = {
	move: 0, // A property for the animation that tracks the location of slide,
	slidePos: 0, // A property to track the slide
	prevPos: 0, // A property to track the slide
	timer: 0, // A property for event listening control
	ie : navigator.userAgent.indexOf('MSIE') != -1 ? true : false, //IE test
	ie7 : navigator.appVersion.indexOf("MSIE 7.") != -1 ? true : false, // IE7 test
	comp : document.compatMode == 'BackCompat' ? true : false, // Backwards compatibility test (quirks mode test)
	mcStyles: mc_rotator_large_options.styles ? mc_rotator_large_options.styles : 'http://extras.mnginteractive.com/live/partners/MediaCenter/widget_large/mc_widget_large.css', // Location of styles
	ieCompStyles : mc_rotator_large_options.ieCompStyles ? mc_rotator_large_options.ieCompStyles : 'http://extras.mnginteractive.com/live/partners/MediaCenter/widget_large/mc_widget_large_ie_quirks.css', // Location of quirks mode styles
	initWidget: function() {		
		var url = this.createUrl();
		var mc_json_url = (mc_rotator_large_options.non_generic == false) ? url + 'rotator?cat=mc_rotator_home___&size=large' : url + this.section() + '&size=large'; //Path to JSONP feed		
		var widget = '<div id="mc-widget-container-large"></div>'; //Widget container				
		document.write(widget); // Write widget container
		document.write('<link rel="stylesheet" href="' + this.mcStyles + '" type="text/css" />'); //Write styles
		if (this.ie && this.comp) document.write('<link rel="stylesheet" type="text/css" href="' + this.ieCompStyles + '" />');
		this.widgetContainer = document.getElementById('mc-widget-container-large'); // Container for the widget 		
		var json_s = document.createElement('script'); // JSONP script creation
		var src = mc_json_url; 
		json_s.type = 'text/javascript';
		json_s.src = src;		
		document.getElementsByTagName('head')[0].appendChild(json_s); //Execute JSONP call    	
	},
	createWidget: function (data){
		this.data = data; //Assign data property
		if (this.errorCheck()) return false; // Stop execution if there is a problem with the data
		if (this.data.length < 4) return false; // Stop execution if the feed size was configured incorrectly or if there's not enough data
		this.widgetContainer.innerHTML = this.widgetHtml();	// Build most of the HTML for the widget
		this.Carousel = document.getElementById('mc-widget-large-carousel'); // Assign Carousel Container
		this.slideGen(); // Add slider html (works differently in IE)
		this.forward = document.getElementById('mc-widget-large-forward');	// Assign forward button
		this.backward = document.getElementById('mc-widget-large-backward'); // Assign fackward button
		this.slide = document.getElementById('mc-widget-large-slide'); // Assign slide
		// Events for clicking slider buttons (limit to once every 800 ms)
		this.addEvent(this.forward, 'click', function(){
			if (Date.now() - mc_rotator_large.timer > 800){
				mc_rotator_large.slideRight();
				mc_rotator_large.timer = Date.now();
			};
		});
		this.addEvent(this.backward, 'click', function(){
			if (Date.now() - mc_rotator_large.timer > 800){
				mc_rotator_large.slideLeft();
				mc_rotator_large.timer = Date.now();
			};
		});
	},
	widgetHtml : function(){
		var html = '\n\
			<div class="top-story">' +
				'<h4><a href="' + this.createUrl() + '">Media Center: Photos &amp; Videos</a></h4>' +
				'<div class="was-figure">' +
					'<a href="' + this.data[0].url + '"><img src="' + this.data[0].images_large + '" alt=""></a>' +
				'</div>' +
				'<h2><a href="' + this.data[0].url + '">' + this.data[0].title + '</a></h2>' +
				'<p class="excerpt">' + this.data[0].excerpt + '</p>' +
				'<div class="meta">' +
					'<p class="timestamp">' + this.data[0].timeago + '</p>' +
					//'<p class="comments-bug"><span class="visuallyhidden">Comments: </span><a href="' + this.data[0].url + '">' + this.data[0].comment_total + '</a></p>' +
				'</div>' +
			'</div>' +
			'<div class="carousel slide three-image">' +
				'<div id="mc-widget-large-carousel" class="carousel-inner"></div>' +
				'<a id="mc-widget-large-backward" class="carousel-control left">&lsaquo;</a>' +
				'<a id="mc-widget-large-forward" class="carousel-control right">&rsaquo;</a>' +
			'</div>';//Carousel
		return html;
	},
	slideHtml: function(count){
		var item_number = 3 * count; // One slide contains 3 items from the array of json from WP.  IE only includes one slide at a time
		var slide_inner_html = ''; // Will be string of the three items for the slide
			for(var i = 1; i < 4; i++){
				slide_inner_html += '\n\
					<div class="was-figure">' +
						'<a href="' + this.data[item_number + i].url + '"><img src="' + this.data[item_number + i].images_large + '" alt=""></a>' +
						'<h3><a href="' + this.data[item_number + i].url + '">' + this.data[item_number + i].title + '</a></h3>' +
					'</div>';
		};
		var html = '\n\
			<div class="item' + ((item_number == 0 || this.ie) ? ' active' : '') + '"><div class="slide">' + slide_inner_html + '</div></div>';
		return html;
	},
	slideGen: function(){
		// IE can't take advantage of the sliding animation css, so we just trade slide html in and out
		if (this.ie){
			this.Carousel.innerHTML = this.slideHtml(this.slidePos);
		}
		else {
			for (var i = 0; i < this.slideCount(); i++){
				this.Carousel.innerHTML = this.Carousel.innerHTML + this.slideHtml(i);
			};
		};
	},
	slideCount: function(){
		// Each slide is three items, so we establish how many slides there are in case the number of items in the feed increases or decreases in the future (currently ten)
		var c = this.data.length - 1;
		return Math.floor(c/3); 
	},	
	slideRight: function(){
		if (this.ie) {
			this.ieSlideRight();
		}
		else {
			var mc = mc_rotator_large; // Cut down on verbosity in timeouts
			this.Carousel.children[this.slidePos].className = this.Carousel.children[this.slidePos].className + ' left';
			if (this.slidePos <= (this.slideCount() - 2)){
				this.prevPos = this.slidePos; 
				this.slidePos++;
			}
			else {
				this.prevPos = this.slidePos;
				this.slidePos = 0;
			};
			this.Carousel.children[mc_rotator_large.slidePos].className = this.Carousel.children[mc.slidePos].className + ' next';
			this.animation = window.setTimeout(function(){
				mc.Carousel.children[mc_rotator_large.slidePos].className = mc.Carousel.children[mc.slidePos].className + ' left';
			},50);
			this.animation = window.setTimeout(function(){
				mc.Carousel.children[mc.slidePos].className = 'item active';
				mc.Carousel.children[mc.prevPos].className = 'item';
			},650);
		};
	},
	slideLeft: function(){
		if (this.ie) {
			this.ieSlideLeft();
		}
		else {
			var mc = mc_rotator_large; // Cut down on verbosity in timeouts
			this.Carousel.children[this.slidePos].className = this.Carousel.children[this.slidePos].className + ' right';
			if(this.slidePos != 0){
				this.prevPos = this.slidePos; 
				this.slidePos--;
			}
			else {
				this.prevPos = this.slidePos;
				this.slidePos = this.slideCount() - 1;
			};
			this.Carousel.children[mc_rotator_large.slidePos].className = this.Carousel.children[mc.slidePos].className + ' prev';
			this.animation = window.setTimeout(function(){
				mc.Carousel.children[mc_rotator_large.slidePos].className = mc.Carousel.children[mc.slidePos].className + ' right';
			},50);
			this.animation = window.setTimeout(function(){
				mc.Carousel.children[mc.slidePos].className = 'item active';
				mc.Carousel.children[mc.prevPos].className = 'item';
			},650);
		};
	},
	ieSlideRight: function(){
		if(this.slidePos <= (this.slideCount() - 2)){
			this.slidePos++;
		}
		else {
			this.slidePos = 0;
		};
		this.slideGen();
	},
	ieSlideLeft: function(){
		if(this.slidePos != 0){
			this.slidePos--;
		}
		else {
			this.slidePos = (this.slideCount() - 1);
		};
		this.slideGen();
	},
	domain: function(){
		if (typeof mc_rotator_large_options.domain != 'undefined'){
			return mc_rotator_large_options.domain;
		};
		var domain = (location.host.match(/([^.]+)\.\w{2,3}(?:\.\w{2})?$/) || [])[1];
		return domain;
	},
	section: function(){
		if (typeof mc_rotator_large_options.category != 'undefined') {
			return 'rotator?cat=' + mc_rotator_large_options.category;
		};
		var url = location.pathname;
		var patt = /news|sports|entertainment|lifestyles/gi;
		var the_match = patt.exec(url);
		if (the_match == 'news'){
			the_match = 'rotator?cat=news';
		}
		else if (the_match == 'sports'){
			the_match = 'rotator?cat=sports';
		}
		else if (the_match == 'entertainment'){
			the_match = 'rotator?cat=entertainment';
		}
		else if (the_match == 'lifestyles'){
			the_match == 'rotator?cat=lifestyles';
		}
		else { 
			the_match = 'rotator?cat=mc_rotator_home___';
		};		
		return the_match;
		},
	errorCheck : function() {
		if (typeof this.data.error !== 'undefined') {	
			if (typeof this.widgetContainer.parentNode !== 'undefined'){
				this.widgetContainer.parentNode.removeChild(this.widgetContainer);
				return true;
			}
			else {
				return true;
			};
		}
		else if (this.numberOfItems <= 1){// We need two items at a minimum for the rotator to work
			if (typeof this.widgetContainer.parentNode !== 'undefined'){
				this.widgetContainer.parentNode.removeChild(this.widgetContainer);
				return true;
			}	
			else {
				return true;
			};
		};
		return false;
	},			
	createUrl: function() {
		if (mc_rotator_large_options.url) return mc_rotator_large_options.url;
		var domain = this.domain();
		var url = 'http://photos.' + domain + '.com/';	
		switch(domain) {
			//Some URLs that don't fall into the photos.domain.com structure
			case 'delcotimes':
				url = 'http://media.delcotimes.com/';
				break;
			case 'dailycamera':
				url = 'http://mediacenter.dailycamera.com/';
				break;
			case 'chicoer':
				url = 'http://media.chicoer.com/';
				break;
			case 'eptrail':
				url = 'http://mediacenter.eptrail.com/';
				break;
			case 'reporterherald':
				url = 'http://media.reporterherald.com/';
				break;
			case 'coloradodaily':
				url = 'http://mediacenter.coloradodaily.com/';
				break;
			case 'theoaklandpress':
				url = 'http://media.theoaklandpress.com/';
				break;
			case 'macombdaily':
				url = 'http://media.macombdaily.com/';
				break;
			case 'themorningsun':
				url = 'http://media.themorningsun.com/';
				break;
			case 'dailytribune':
				url = 'http://media.dailytribune.com/';
				break;
			case 'heritage':
				url = 'http://media.heritage.com/';
				break;
			case 'thenewsherald':
				url = 'http://media.thenewsherald.com/';
				break;
			case 'pressandguide':
				url = 'http://media.pressandguide.com/';
				break;
			case 'voicenews':
				url = 'http://media.voicenews.com/';
				break;
			case 'sourcenewspapers':
				url = 'http://media.sourcenewspapers.com/';
				break;
			case 'morningstarpublishing':
				url = 'http://media.morningstarpublishing.com/';
				break;
			case 'dailylocal':
				url = 'http://media.dailylocal.com/';
				break;
			case 'pottsmerc':
				url = 'http://media.pottsmerc.com/';
				break;
			case 'timesherald':
				url = 'http://media.timesherald.com/';
				break;
			case 'thereporteronline':
				url = 'http://media.thereporteronline.com/';
				break;
			case 'mainlinemedianews':
				url = 'http://media.mainlinemedianews.com/';
				break;
			case 'montgomerynews':
				url = 'http://media.montgomerynews.com/';
				break;
			case 'phoenixvillenews':
				url = 'http://media.phoenixvillenews.com/';
				break;
			case 'buckslocalnews':
				url = 'http://media.buckslocalnews.com/';
				break;
			case 'delconewsnetwork':
				url = 'http://media.delconewsnetwork.com/';
				break;
			case 'berksmontnews':
				url = 'http://media.berksmontnews.com/';
				break;
			case 'southernchestercountyweeklies':
				url = 'http://media.southernchestercountyweeklies.com/';
				break;
			case 'ydr':
				url = 'http://mediacenter.ydr.com/';
				break;
			case 'news-herald':
				url = 'http://media.news-herald.com/';
				break;
			case 'morningjournal':
				url = 'http://media.morningjournal.com/';
				break;
			case 'dailyfreeman':
				url = 'http://media.dailyfreeman.com/';
				break;
			case 'saratogian':
				url = 'http://media.saratogian.com/';
				break;
			case 'troyrecord':
				url = 'http://media.troyrecord.com/';
				break;
			case 'oneidadispatch':
				url = 'http://media.oneidadispatch.com/';
				break;
			case 'cnweekly':
				url = 'http://media.cnweekly.com/';
				break;
			case 'romeobserver':
				url = 'http://media.romeobserver.com/';
				break;
			case 'trentonian':
				url = 'http://media.trentonian.com/';
				break;
			case 'southjerseylocalnews':
				url = 'http://media.southjerseylocalnews.com/';
				break;
			case 'middletownpress':
				url = 'http://media.middletownpress.com/';
				break;
			case 'registercitizen':
				url = 'http://media.registercitizen.com/';
				break;
			case 'countytimes':
				url = 'http://media.countytimes.com/';
				break;
			case 'westhartfordnews':
				url = 'http://media.westhartfordnews.com/';
				break;
			case 'housatonictimes':
				url = 'http://media.housatonictimes.com/';
				break;
			case 'minutemannewscenter':
				url = 'http://media.minutemannewscenter.com/';
				break;
			case 'ctpostchronicle':
				url = 'http://media.ctpostchronicle.com/';
				break;
			case 'shorelinetimes':
				url = 'http://media.shorelinetimes.com/';
				break;
			case 'ctbulletin':
				url = 'http://media.ctbulletin.com/';
				break;
			case 'dolphin-news':
				url = 'http://media.dolphin-news.com/';
				break;
			case 'nhregister':
				url = 'http://photos.newhavenregister.com/';
				break;
			case 'burlesonstar':
				url = 'http://photos.burlesonstar.net/';
				break;
			case 'crowleystar':
				url = 'http://photos.crowleystar.net/';
				break;
			case 'joshuastar':
				url = 'http://photos.joshuastar.net/';
				break;
			case 'keenestar':
				url = 'http://photos.keenestar.net/';
				break;
			case 'alvaradostar':
				url = 'http://photos.alvaradostar.net/';
				break;
		};
		return url;	
	},
	addEvent: function(elem, evnt, func) {
		// Cross Browser Event Handler
		if (elem.addEventListener)  // !IE
			elem.addEventListener(evnt,func,false);
	    else if (elem.attachEvent) { // IE
	       elem.attachEvent("on"+evnt, func);
	    }
	}	
}
// Initialize widget
mc_rotator_large.initWidget();