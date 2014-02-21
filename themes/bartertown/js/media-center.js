// Create from sandbox in human readable form and Handlebars.js expressions
// Remove all non single spaces and place as string in callback
__mediaCenterTemplate('<div class="media-center sm"><h4><a href="{{mediacenter}}">Media Center: Photos &amp; Videos</a></h4><div id="media-center-promo" class="carousel slide" data-interval="false"><ol class="carousel-indicators"><li data-target="#media-center-promo" data-slide-to="0" class="active"></li><li data-target="#media-center-promo" data-slide-to="1"></li><li data-target="#media-center-promo" data-slide-to="2"></li></ol><div class="carousel-inner">{{#top_items}}<div class="item {{#if @first}}active{{/if}}" data-title="{{title}}" data-caption="{{excerpt}}"><span data-picture data-alt=""> {{#images}}<span data-src="{{_320x240}}"></span><span data-src="{{_640x480}}" data-media="(min-device-pixel-ratio: 2.0)"></span><span data-src="{{_480x320}}" data-media="(min-width: 321px)"></span><span data-src="{{_960x640}}" data-media="(min-width: 321px) and (min-device-pixel-ratio: 2.0)"></span><span data-src="{{_640x480}}" data-media="(min-width: 481px)"></span><span data-src="{{_1280x960}}" data-media="(min-width: 481px) and (min-device-pixel-ratio: 2.0)"></span><span data-src="{{_800x600}}" data-media="(min-width: 641px)"></span><span data-src="{{_1600x1200}}" data-media="(min-width: 641px) and (min-device-pixel-ratio: 2.0)"></span><span data-src="{{_640x480}}" data-media="(min-width: 769px)"></span><span data-src="{{_1280x960}}" data-media="(min-width: 769px) and (min-device-pixel-ratio: 2.0)"></span><span data-src="{{_480x320}}" data-media="(min-width: 960px)"></span><span data-src="{{_960x640}}" data-media="(min-width: 960px) and (min-device-pixel-ratio: 2.0)"></span><span data-src="{{_640x480}}" data-media="(min-width: 1029px)"></span><span data-src="{{_1280x960}}" data-media="(min-width: 1029px) and (min-device-pixel-ratio: 2.0)"></span><span data-src="{{_800x600}}" data-media="(min-width: 1241px)"></span><span data-src="{{_1600x1200}}" data-media="(min-width: 1241px) and (min-device-pixel-ratio: 2.0)"></span><!-- Fallback content for non-JS browsers. Same img src as the initial, unqualified source element. --><noscript><img src="http://placehold.it/320x24" alt="You must enable javascript to see this image."></noscript> {{/images}}</span></div>{{/top_items}}</div><a class="left carousel-control" href="#media-center-promo" data-slide="prev"><span class="glyphicon glyphicon-chevron-left"></span></a><a class="right carousel-control" href="#media-center-promo" data-slide="next"><span class="glyphicon glyphicon-chevron-right"></span></a></div><div id="media-center-info" class="media-center-caption"> {{#top_items}}{{#if @first}}<h2><a href="{{href}}">{{title}}</a></h2><p class="excerpt">{{excerpt}}</p> {{else}} {{/if}} {{/top_items}}</div><h4 class="visible-md-up"><a href=""></a></h4><ul class="secondary-stories visible-md-up">{{#bottom_items}}<li class="col-lg-4"><a href="{{href}}"><img src="{{images}}" alt="{{title}}" /></a><h3><a href="{{href}}">{{title}}</a></h3></li> {{/bottom_items}}</ul> <!-- .secondary-stories --></div>')
