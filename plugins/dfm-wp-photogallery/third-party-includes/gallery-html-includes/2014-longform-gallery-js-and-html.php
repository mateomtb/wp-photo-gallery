<div class="gallery-scroll">
	<div class="scroller">
	</div>
</div> <!-- .gallery-scroll -->
<script id="longformTemp" type="text/x-handlebars-template">
	{{#ImageElementCollection}}
	<figure>
		{{#ImageElement}}
					<img src="{{fullUrl}}" alt="" />
					<figcaption>
						<span class="counter">{{position}}</span>{{#if caption}} {{caption}} {{/if}}
						<span class="photographer">Photo by Add this to feed</span>
					</figcaption>
		{{/ImageElement}}
	</figure>
	{{/ImageElementCollection}}
</script>

<!-- ON LOAD -->
<script>
(function($){
	var noCache = Date(), // Prevent IE caching of JSON
		positionCounter = 1,
		url,
		json = _JSONHelper; // CUSTOM CODE found in js/JSON_helper.js
		
	// COUNTER FOR HANDLEBARS (PAGINATION)
	Handlebars.registerHelper('position', function() {
		// More than one position per loop
		if (url !== this.fullUrl) {
			url = this.fullUrl;
			return positionCounter++;
		}
		else {
			return positionCounter;
		} 
	});

	// get data from json object
	$.getJSON(json, { "noCache": noCache }, function(data) {
		// build the carousel
		template = Handlebars.compile($('#longformTemp').html());
		html = template(data);
		$('div.gallery-scroll div.scroller').html(html);
	});
})(jQuery);
</script>