
/*
** JS to create a Media Center Rotator
** Authors:
	JavaScript: Josh Kozlowski
	HTML and CSS: Mateo Leyba and Josh Kozlowski
	Last Modified: 10/9/12
	Version: 2.0

***** example of options object		
	var mc_rotator_options = {
	non_generic : false, //only do this if you want the rotator to pull from all galleries and the "rotator-home" curated category
	link_one : ['Preps','http://www.denverpost.com/preps'],
	link_two : ['Colorado',' www.denverpost.com'],
	link_three : ['Reverb','www.heyreverb.com'],
	link_four : ['Broncos','www.denverpost.com/broncos'],
	domain: 'denverpost', //only do this when you need to specify a domain,
	category: 'olympics' //the WordPress category slug that is queried to generate the rotator's feed
	};

******/
var mc_rotator_options = mc_rotator_options || {};
var mc_rotator = {
	counter : 0, // A counter for the data items
	previousCount : 0, // Another counter for tracking the elements in the animation
	textSlide: 'right', // Direction that text needs to slide
	direction : true, // A toggle for tracking which way image changes are occuring. true = forward, false = backward
	move: 0, // A property for the animation that tracks the location of the sliding text
	ieOpacityCounter: 100, // A property for the animation's IE opacity fade
	burnsCount : 0, // A property for the position of the panning animation
	stopPreloading : 0, // A property for keep tracking of image preloads since they don't all load initially
	ie : navigator.userAgent.indexOf('MSIE') != -1 ? true : false, //IE test
	ie7 : navigator.appVersion.indexOf("MSIE 7.") != -1 ? true : false, // IE7 test
	comp : document.compatMode == 'BackCompat' ? true : false, //Backwards compatibility test (quirks mode test)
	mcStyles: mc_rotator_options.styles ? mc_rotator_options.styles :'http://extras.mnginteractive.com/live/partners/MediaCenter/widget/mc_widget_styles.css', //Location of widget styles
	widgetHtml : function() {
		var url = this.createUrl();
		var html = '\n\
		<div class="rotatetitlebar">' +
			'<h2"><a class="mctitle" href="' + url + '">MEDIA CENTER GALLERIES</a></h2>' +
		'</div>' +
			'<div id="mc-top-links" class="top-bottom-links">' +
				'<ul>' +
					'<li><a class="mclink" href="' + url + 'category/news/" target="_blank">News</a></li>' +
				'<li><a class="mclink" href="' + url + 'category/sports/" target="_blank">Sports</a></li>' +
					'<li><a class="mclink" href="' + url + 'category/entertainment/" target="_blank">Entertainment</a></li>' + 
					'<li><a class="mclink" href="' + url + 'category/lifestyles/" target="_blank">Lifestyles</a></li>' + 
			'</ul>' + 
			'</div>' +
			'<div id="mc-photo-show">' +
			'<div class="rimagearea" id="mc-rotator-image-container">' +				
			'</div>' +
			'<div class="rnavcontainer">' +
					'<div id="previousmc" class="imgLeftmc"><div class="rleftarrow"></div><div class="rleftarrow"></div></div>' +
					'<div id="playpausebox"><div id="playpause" class="rotatepause"></div></div>' +
						'<div id="nextmc" class="imgRightmc"><div class="rrightarrow"></div><div class="rrightarrow"></div></div>' +
						'</div>' +
				'<div id="rotatedesctext"><a href=""></a><p></p></div>' +
		'</div>' +
		'<div id="mc-bottom-links" class="top-bottom-links">' +
			'<ul>' +
				'</ul>' +
			'</div>'
		return html;
	}, // The inner html
	initWidget: function() {		
		url = this.createUrl();
		var mc_json_url = '/elpasotimes/rotator?cat=mc_rotator_home___'; //Path to JSONP feed
		//var mc_json_url = (mc_rotator_options.non_generic == false) ? url + 'rotator?cat=mc_rotator_home___' : url + this.section(); //Path to JSONP feed		
var widget = '<div id="the-mc-widget-container" class="mc-widget-item-0"></div>'; //Widget container				
		document.write(widget); // Write widget container
		document.write('<link rel="stylesheet" href="' + this.mcStyles + '" type="text/css" />'); //Write styles
		this.widgetContainer = document.getElementById('the-mc-widget-container'); // Container for the widget 		
		var json_s = document.createElement('script'); // JSONP script creation
		var src = mc_json_url; 
		json_s.type = 'text/javascript';
		json_s.src = src;		
		document.getElementsByTagName('head')[0].appendChild(json_s); //Execute JSONP call    	
	},
	createWidget: function (data){
		this.data = data; //Assign data property
		this.numberOfItems = (this.data.length - 1); // Assign number of items property. Normalized to start at zero and match counter
		if (this.errorCheck()) return false; // Kill the widget and stop execution if there is a problem with the data
		this.widgetContainer.innerHTML = this.widgetHtml();	//Finish buidling the HTML for the widget
		this.bottomLinks(); // Function that adds bottom link
		this.imageContainer = document.getElementById('mc-rotator-image-container'); // Assign widget container property
		this.mainText = document.getElementById('rotatedesctext'); // Assign property for text container
		this.stopPlayButtonContainer = document.getElementById('playpausebox'); // Assign property for play-pause button container
		this.stopPlayButton = document.getElementById('playpause'); // Assign property for play-pause button
		this.previousButton = document.getElementById('previousmc'); // Assign property for previous button
		this.nextButton = document.getElementById('nextmc'); // Assign property for next button
		this.createImageContainers(); // Create containers for images		
		this.mainImage = document.getElementById('mc-rotator-image-0'); // Assign property for element which will load in different images. 
		this.compatibilize(); // A function to make opacity animation work across all browsers			
		this.renderFirstItem(); // Add the rest of the first item into the code		
		this.imagePreloader(); // Not all the images load initially. This loads the image into it's container before the animation starts
		if (this.ie7 && !this.comp) this.ie7ButtonFixes();
		if (typeof mc_rotator_options.callback != 'undefined') mc_rotator_options.callback(); //A callback if html needs to be changed	
		this.burnsAnimation(); // Start the panning animation		
		this.anim = window.setTimeout(function(){mc_rotator.animation();},7000);	//Start the rotator animation
		this.stopPlayButton.onclick = function(){mc_rotator.stopPlay();}; // Pause play button event handler
		this.previousButton.onclick = function(){mc_rotator.previous();}; // Previous button event handler
		this.nextButton.onclick = function(){mc_rotator.next()}; // Next button event handler		
	},
	animation : function(){		
		this.newInt = window.setInterval(function(){				
			if (mc_rotator.textSlide == 'right'){
				mc_rotator.textSlideRight();
				if (mc_rotator.mainText.style.right == '-300px'){						
					mc_rotator.textSlide = 'left';
					mc_rotator.stopPlayButtonContainer.style.display = 'none'; 
					mc_rotator.itemCountIncrement();
					mc_rotator.nextText();
				};
			}
			else if (mc_rotator.textSlide == 'left') {				
				if (mc_rotator.mainText.style.right == '0px'){					
					mc_rotator.textSlide = 'right';
					clearInterval(mc_rotator.newInt);	
					mc_rotator.resetNext();
					mc_rotator.resetOpacity();					
					mc_rotator.nextImage();													
					mc_rotator.anim = window.setTimeout(function(){mc_rotator.animation();},7000);
					mc_rotator.stopPlayButtonContainer.style.display = 'block'; 
					return false;	
				}
				else{
					mc_rotator.textSlideLeftAndImageOpacityFade();
				};
			};									
		},50);							
	},
	burnsAnimation : function() {
		this.burns = window.setInterval(function(){
			if (mc_rotator.burnsCount == 100){
				clearInterval(mc_rotator.burns);
				mc_rotator.burnsCount = 0;
				mc_rotator.burnsAnimation();
			};
			mc_rotator.mainImage.style.left = '-' + mc_rotator.burnsCount + 'px'; 	
			mc_rotator.burnsCount++;
		},165);	
	},
	stopPlay : function() {
		if (this.stopPlayButton.className == 'rotatepause') {
			this.stopPlayButton.className = 'rotateplay';
			this.nextButton.style.display = 'block';
			this.previousButton.style.display = 'block';
			this.stopAnimations();
		}
		else if (this.stopPlayButton.className == 'rotateplay'){
			this.stopPlayButton.className = 'rotatepause';
			this.nextButton.style.display = 'none';
			this.previousButton.style.display = 'none';
			this.burnsAnimation();
			this.anim = setTimeout(function(){mc_rotator.animation();},7000);											
		};		
	},
	nextImage : function () {				
		this.imagePreloader();
		var previous_image = document.getElementById('mc-rotator-image-' + this.previousCount);
		this.mainImage = document.getElementById('mc-rotator-image-' + this.counter);	
		previous_image.className = '';
		this.mainImage.className = 'current-image';
		if (this.ie7 || this.comp){			
			previous_image.style.display = 'none';
			previous_image.style.width = '1px';
			previous_image.style.height = '1px';
			this.mainImage.style.display = 'block';
			this.mainImage.style.width = '400px';
			this.mainImage.style.height = '200px';
		};									
	},
	nextText : function() {
		this.mainText.firstChild.innerHTML = '<h2>' + this.data[this.counter].title + '</h2>';
		this.mainText.firstChild.setAttribute('href', this.data[this.counter].url);
		this.mainText.lastChild.innerHTML = this.data[this.counter].excerpt;	
	},
	resetNext : function () {		
		this.burnsCount = 0;									
		this.mainImage.style.left = 0;						
	},
	resetOpacity : function () {
		this.mainImage.style.opacity = 1;
		if (this.ie) {
			this.ieOpacityCounter = 100;	
			this.mainImage.style.filter = 'alpha(opacity=100)';
		};
	},
	imagePreloader : function() {
		if (this.stopPreloading == (this.numberOfItems + 1)) return false;		
		for (var i = 0; i <= this.numberOfItems; i++){
			if (document.getElementById('mc-rotator-image-' + i).src == this.data[i].image){
					this.stopPreloading++;
				};							 
		};		
		if (this.stopPreloading == (this.numberOfItems + 1)) return false;
		this.stopPreloading = 0;
		if (this.direction){
			var next_image_shell = document.getElementById('mc-rotator-image-' + (this.counter + 1));		
			next_image_shell.src = this.data[(this.counter + 1)].image;
			next_image_shell.style.opacity = 1;	
			if (this.ie) next_image_shell.style.opacity.filter = 'alpha(opacity=100)';						
		}
		else {
			if (this.counter == this.numberOfItems){
				var next_image_shell = document.getElementById('mc-rotator-image-' + (this.numberOfItems));
				next_image_shell.src = this.data[this.numberOfItems].image;
				next_image_shell.style.opacity = 1;	
				if (this.ie) next_image_shell.style.opacity.filter = 'alpha(opacity=100)';	
			}
			else {
				var next_image_shell = document.getElementById('mc-rotator-image-' + (this.counter));
				next_image_shell.src = this.data[(this.counter)].image;
				next_image_shell.style.opacity = 1;	
				if (this.ie) next_image_shell.style.opacity.filter = 'alpha(opacity=100)';			
			};	
		};
	},
	next : function() {
		this.direction = true;
		this.itemCountIncrement();
		this.resetNext();
		this.nextText();
		this.nextImage();	
	},
	previous : function() {
		this.direction = false;
		this.itemCountDecrement();
		this.resetNext();
		this.nextText();
		this.nextImage();	
	},
	textSlideRight : function(){
		this.mainText.style.right = (this.move * -1) + 'px';
		this.move += 20;	
	},
	textSlideLeftAndImageOpacityFade: function(){
		this.mainText.style.right = (this.move * -1) + 'px';
		this.move -= 20;
		this.mainImage.style.opacity -= .03;						
		if (this.ie) {
			this.ieOpacityCounter -= 4;
			this.mainImage.style.filter = 'alpha(opacity=' + this.ieOpacityCounter + ')';
		};			
	},
	stopAnimations : function() {		
		clearInterval(this.newInt);
		clearInterval(this.burns);
		clearTimeout(this.anim);
		this.mainText.style.right = 0;		
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
	createImageContainers: function(){
		for (x in this.data){
			var img = document.createElement('img');
			img.alt = '';
			if (this.counter == 0) {
					img.setAttribute('id', 'mc-rotator-image-' + this.counter);
					img.src = this.data[0].image;
					img.setAttribute('class', 'current-image');
					this.imageContainer.appendChild(img);
				}
			else {
				img.src = '';
				img.setAttribute('id', 'mc-rotator-image-' + this.counter);
				this.imageContainer.appendChild(img);		
			};
			this.counter++;		
		};
        this.counter = 0;		
	},	
	compatibilize : function() {		
		if (!this.ie) this.mainImage.parentNode.style.width = '300px'; 
		this.mainImage.style.opacity = 1;	
		if (this.ie) {			
			this.mainImage.style.filter = 'alpha(opacity=100)';
			if (this.ie7 || this.comp) {
				this.mainImage.style.display = 'block';
				this.mainImage.style.width = '400px';
				this.mainImage.style.height = '200px';
			};
		};		
	},
	renderFirstItem : function() {
		this.mainText.firstChild.innerHTML = '<h2>' + this.data[0].title + '</h2>';
		this.mainText.firstChild.setAttribute('href', this.data[0].url);
		this.mainText.lastChild.innerHTML = this.data[0].excerpt;		
		this.imageContainer.onclick = function(){window.location = mc_rotator.mainText.firstChild.getAttribute('href');}; // Clickthrough for main image	
	},
	ie7ButtonFixes : function() {
		// Effort had been made to limit page weight and not use images for buttons
		// That is the reason for this and it addresses display in regular ie7
		// Switching to a sprite for the buttons is not a bad idea though
		var ie_7_pause_play_styles = '#the-mc-widget-container #playpausebox {height:auto!important} #the-mc-widget-container .rotatepause {width:auto!important; margin-bottom:-1px!important;} #the-mc-widget-container .rotateplay {width:auto!important; height:auto!important; margin-left:5px!important} #the-mc-widget-container .rrightarrow {margin:4px -2px 4px 6px!important}';			
		var head = document.getElementsByTagName('head')[0];
    	if (head) {
			var style = document.createElement('style');
			var rules = document.createTextNode(ie_7_pause_play_styles);
			style.type = 'text/css';
			if(style.styleSheet){
				style.styleSheet.cssText = rules.nodeValue;
			}
			else {
				style.appendChild(rules);
			};
			head.appendChild(style);
		};
	}, 	
	itemCountIncrement: function(){
		this.previousCount = this.counter;
		if (this.counter == this.numberOfItems){
			this.counter = 0;
		}
		else {
			this.counter++;
		};		
	},
	itemCountDecrement: function(){
		this.previousCount = this.counter;
		if (this.counter == 0){
			this.counter = this.numberOfItems;
		}
		else {
			this.counter--;
		};		
	},
	domain: function(){
		if (typeof mc_rotator_options.domain != 'undefined'){
			return mc_rotator_options.domain;
		};
		var domain = (location.host.match(/([^.]+)\.\w{2,3}(?:\.\w{2})?$/) || [])[1];
		return domain;
	},
	section: function(){
		if (typeof mc_rotator_options.category != 'undefined') {
			return 'rotator?cat=' + mc_rotator_options.category;
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
	bottomLinks: function() {
		var par_el = document.getElementById('mc-bottom-links');		
		for (x in mc_rotator_options){
			if (par_el.firstChild.childNodes.length == 4) break;
			if (typeof mc_rotator_options[x] === 'object'){
				if (typeof mc_rotator_options[x][0] != 'undefined' && typeof mc_rotator_options[x][1] != 'undefined'){					
					mc_rotator_options[x][0] = mc_rotator_options[x][0].replace(/^\s+/g,'').replace(/\s+$/g,'');				
					mc_rotator_options[x][1] = mc_rotator_options[x][1].replace(/\s/g,'');
					var patt = /^http:\/\//;
					if (patt.test(mc_rotator_options[x][1])){
						mc_rotator_options[x][1] = mc_rotator_options[x][1].substring(mc_rotator_options[x][1].indexOf('http://') + 7);
					};
					var new_item = document.createElement('li');
					var new_link = document.createElement('a');
					new_link.appendChild(document.createTextNode(mc_rotator_options[x][0]));
					new_link.setAttribute('href', 'http://' + mc_rotator_options[x][1]);
					new_link.setAttribute('target', 'blank');
					new_link.className = 'mclink';
					new_item.appendChild(new_link);
					par_el.firstChild.appendChild(new_item);
				};
			};
		};		
	},
	createUrl: function() {
		if (mc_rotator_options.url) return mc_rotator_options.url;
		var domain = this.domain();
		var url = 'http://photos.' + domain + '.com/';	
		switch(domain) {//Some URLs that don't fall into the photos.domain.com structure
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
	}	
};
// Initialize widget
mc_rotator.initWidget();