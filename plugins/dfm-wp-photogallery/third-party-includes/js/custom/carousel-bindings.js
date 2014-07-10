// Add Omniture code and any bindings specific to your implementation here
// Also limit clicks per second
(function($, callback){
	// omnitureTracking() called when gallery first recognized in DOM and then after each slide
	var timer = 0,
		slideLimitPerMS = 2000,
		UNIXTime = function() {
			return new Date().getTime();
		};
	var int = setInterval(function() {
		if ($('#carousel').length) {
			
			var controls = $('a.carousel-control, ol.carousel-indicators li'),
				captions = $('div.carousel-caption p'),
				HTMLTag = /\<[a-z]+\>/i,
				HTMLCaptions = HTMLTag.test(captions.text());
			
			if (!document.addEventListener){
				// Some IE < 9 stuff
				// Without the numbers inside the items the controls look more presentable in IE 8
				$('ol.carousel-indicators li').text('');
			}
			
			// If editors add html to captions, we let them control how each one looks
			if (!HTMLCaptions) {
				captions.each(function(){
					$(this).html(captionProcessor($(this).text(), 280));
				});
			
				captions.on('click', function(){captionClicks($(this))});
			}
			else {
				captions.each(function(){
					var html = $(this).text();
					$(this).html(html);
				});
				editorialCaptions();
			}
			
			// Synch up hash numbers with gallery item
			//addHashSupport($('.photo-gallery'));
			
			//controls.on('click', function() {
				//if ((UNIXTime() - timer) < slideLimitPerMS) {
					//return false;
				//}
			//});
			
			omnitureTracking();
			$('#carousel').on('slid', function() {
				omnitureTracking();
				//timer = UNIXTime();
			});
			clearInterval(int);
		}
	}, 100);
	
	
	
	// Based on current Omniture implementation 
	function omnitureTracking() {
		if (typeof omniTrack === 'function') {
			var total = $('.photo-gallery .item').length;
			var params = $('.photo-gallery .item.active').index() + 1;
			omniTrack(params, total);
		}
	}
	
	function captionProcessor(caption, maxLength) {
		var regExp,
			matches,
			captionString = '',
			processedString = '',
			cutOffString = '';
		if (!caption) {
			return '';
		}
		caption = caption.replace(/\n/g,' '); 
		if (caption.length < (maxLength + 1)) {
			return caption;
		}
		regExp = new RegExp('.{1,' + maxLength + '}\\s','g'); // [^] for all chars not supported in older IEs
		matches = caption.match(regExp);
		if (!matches) {
			return;
		}
		if (matches.length === 1) {
			return captionString;
		}
		// Sometimes the last match will be cut off. The following blocks assign any cut-off text to a var. 
		for (var i = 0, len = matches.length; i < len; i++) { 
			processedString += matches[i];
		};
		if (processedString.length < caption.length) {
			cutOffString = caption.slice((processedString.length ), (caption.length));
		} 
		// Create caption html
		for (var i = 0, len = matches.length; i < len; i++) {
			if (i === 0) {
				captionString = '<span class="show-cap">' + matches[0] + '...</span>';
			}
			else if ((i + 1) < len) {
				captionString += '<span>... ' + matches[i] + '...</span>';
			}
			else {
				captionString += '<span>... ' + matches[i] + cutOffString + '</span>';
			}
		}
		return captionString;
	}
	
	function captionClicks(caption) {
		if (caption.find('span').length <= 1) {
			return false;
		}
		var current = caption.find('span.show-cap');
		current.removeClass('show-cap');
		if (current.next().length) {
			current.next().addClass('show-cap');
		}
		else {
			caption.find('span')[0].className = 'show-cap';
		}
	}
	
	function editorialCaptions() {
		$('div.carousel-caption').css('height', '100%');
	}
	
	function addHashSupport(gallery){
		// Set hash to #1 on initial gallery view
		if (!window.location.hash) {
			window.location.hash = '#1';
		}
		updateSlideToHash(gallery)
		
		// Bind hash changing
		gallery.find('.carousel').on('slid', function() {
			var item = gallery.find('.carousel-inner .item.active');
			window.location.hash = "#"+parseInt(item.index() + 1);
		});

		$(window).on('hashchange', function() {
			updateSlideToHash(gallery);
		});
		
		function updateSlideToHash(gallery) {
			var hash = document.location.hash,
				index = (hash) ? parseInt(hash.split('#')[1]) : undefined;
			if (typeof index === 'number' && index !== NaN) {
				// Change active slide and indicator
				gallery.find('.carousel-inner div').removeClass('active');
				gallery.find('.carousel-indicators li').removeClass('active');
				gallery.find('.carousel-inner div:nth-child(' + index + ')').addClass('active');
				gallery.find('.carousel-indicators li:nth-child(' + index + ')').addClass('active');
			}
		}
	}
	
})(jQuery);