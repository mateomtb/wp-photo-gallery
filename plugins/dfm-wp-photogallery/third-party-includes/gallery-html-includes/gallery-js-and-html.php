<div class="photo-gallery">
</div> <!-- .photo-gallery -->
<!-- TEMPLATE -->
<script id="carouselTemp" type="text/x-handlebars-template">
	{{#ImageElementCollection}}
	<div id="carousel" class="carousel slide">
		<div class="carousel-inner">
			{{#ImageElement}}
			<div class="item">
				<div class="image-container widescreen">
					<img src="{{fullUrl}}" alt="Description of {{title}}. {{caption}}" {{#if height}} height="{{height}}" {{/if}} {{#if width}} width="{{width}}" {{/if}} />
				</div>
				<div class="carousel-caption">
					<!--<h4>{{#if title}}{{title}}{{/if}}</h4>-->
					<p>{{#if caption}} {{caption}} {{/if}}</p>
				</div>
					<div class="forsale">
						{{#if forsaleHREF}}<a href="{{forsaleHREF}}" target="_blank">Buy This Photo</a>{{/if}}
					</div>
			</div>
			{{/ImageElement}}
		</div>
		<a class="left carousel-control" href="#carousel" id="prev_btn" data-slide="prev">&lsaquo;</a>
		<a class="right carousel-control" href="#carousel" id="next_btn" data-slide="next">&rsaquo;</a>
	</div>
	<ol class="carousel-indicators" style="display:none;">
		{{#ImageElement}}
		<li data-target="#carousel" data-slide-to="{{@index}}">{{position}}</li>
		{{/ImageElement}}
		<li data-target="#carousel" class="directional" id="prev_indicator" data-slide="prev">&lsaquo;</li>
		<li data-target="#carousel" class="directional" id="next_indicator" data-slide="next">&rsaquo;</li>
	</ol>
	{{/ImageElementCollection}}
</script>


<!-- ON LOAD -->
<script>
(function($){
	var images,     // object consisting of all images in slideshow
		template,   // handlebars template
		html,       // html to be printed to carousel container
		ratio,      // ratio of container (determined by '.widescreen')
		carouselWidth,
		imageContainerHeight,
		noCache = Date(), // Prevent IE caching of JSON
		json = _JSONHelper; // CUSTOM CODE found in js/JSON_helper.js
	// COUNTER FOR HANDLEBARS (PAGINATION)
	var positionCounter = 1;
	Handlebars.registerHelper('position', function() { return positionCounter++; });

	// get data from json object
	$.getJSON(json, { "noCache": noCache }, function(data) {
		// build the carousel
		template = Handlebars.compile($('#carouselTemp').html());
		html = template(data);
		$('.photo-gallery').html(html);

		// add active class to first items
		$('.carousel-inner').find('.item').first().addClass('active');
		$('.carousel-indicators').find('li').first().addClass('active');

		// trigger the carousel and add settings
		$('#carousel').carousel('pause'); 
		
		// collect images
		images = $('.item').find('img'); 

		// set ratio for image container
		ratio = $('.widescreen').length ? 1.74 : 1.48;

		// set init dimensions for carousel elements and position controls 
		carouselWidth = $('#carousel').width();
		imageContainerHeight = Math.round(carouselWidth / ratio);
		positionControls();

		// initial resize of images to fit within image container
		$.each(images, function (key, image) {
			imagesLoaded(image, function(){
				resizeImage(image);
			});
		});
		window.galleryJSON = data; // Global
	});

	// on resize, make sure aspect ratios remain the same for all photos (may not be called)
	$(window).smartresize(function() {
		carouselWidth = $('#carousel').width();
		imageContainerHeight = Math.round(carouselWidth / ratio);
		positionControls();
		$.each(images, function (key, image) {
			imagesLoaded(image, function(){
			resizeImage(image);
			});
		});
	});

	function positionControls() {
		if($(window).width() < 768) {
			var controlHeight = $('.carousel-control').height();
			$('.carousel-control').css({'top' : (imageContainerHeight - controlHeight) / 2 + (controlHeight / 2)  + 'px'});
		} else {
			$('.carousel-control').css({'top' : '50%'});
		}
	}
	
	function matchURLtoSize(imgSrc) {
		// It's proven very difficult to retrieve the native dimensions of each image in IE
		// even when they are set as attributes of the image at the JSON/Boostrap level
		// The image's source is retrievable however
		// This tailor-made function will return the width and height for a given image src as an array by 
		// cross referencing the gallery's JSON data, where height and width are defined 
		var data = galleryJSON;
		var imgs = data.ImageElementCollection.ImageElement; // Very specific to current JSON structure
		for (var obj in imgs) {
			if (imgs.hasOwnProperty(obj)) {
				if (imgs[obj].fullUrl === imgSrc) {
					return [imgs[obj].width, imgs[obj].height];
				}
			}
		}
		return [0,0];
	}
	
	// handler for cycling through images and resizing according to current sizes
	function resizeImage(img) {
		// set vars
		if (!img.width || !img.height) {
			// Thank you IE
			var widthHeight =  matchURLtoSize($(img).attr('src'));
			$(img).attr('width', widthHeight[0]);
			$(img).attr('height', widthHeight[1]);
		}
		var imageRatio = Math.ceil(($(img).attr('width')/$(img).attr('height'))*100)/100;
		if(imageRatio < ratio) {
			$(img).attr('width', imageRatio * imageContainerHeight);
			$(img).attr('height', imageContainerHeight);
		} else if (imageRatio > ratio) {
			$(img).attr('width', carouselWidth);
			$(img).attr('height', Math.ceil(carouselWidth / imageRatio));
			if($(window).width() < 768 ) {
				img.style.top = (imageContainerHeight - $(img).attr('height')) / 2 + 'px';
			} else {
				img.style.top = 0;
			}
		} else {
			$(img).attr('width', carouselWidth);
			$(img).attr('height', imageContainerHeight);
		}
	}

})(jQuery);
</script>