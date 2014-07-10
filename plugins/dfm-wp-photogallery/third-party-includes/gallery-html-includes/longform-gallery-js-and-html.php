<div class="photo-gallery">
</div> <!-- .photo-gallery -->
<script id="longformTemp" type="text/x-handlebars-template">
	{{#ImageElementCollection}}
	<div id="images">
		{{#ImageElement}}
					<div class="imagewrap">
						<div class="imagecontainer">
							<a name="photo{{position}}"><img src="{{fullUrl}}" alt="Description of {{title}} {{caption}}" /></a>
						</div>
						<div class="caption"><div class="linkage"><p><a href="#photo{{position}}">{{position}}</a></p></div><p>{{#if caption}} {{caption}} {{/if}}<a class="hashy" href="#photo{{position}}">#</a></p></div>
					</div>	 
		{{/ImageElement}}
	</div>
	{{/ImageElementCollection}}
</script>

<!-- ON LOAD -->
<script>
(function($){
	var noCache = Date(), // Prevent IE caching of JSON
		positionCounter = 0,
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
		$('.photo-gallery').html(html);
	});
})(jQuery);
</script>