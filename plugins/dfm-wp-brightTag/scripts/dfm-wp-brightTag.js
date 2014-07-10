var dfmBrightTag = {
	init: function(){
		var tagjs = document.createElement("script");
		var s = document.getElementsByTagName("script")[0];
		tagjs.async = true;
		tagjs.src = "//s.btstatic.com/tag.js#site=sfWGaRL";
		s.parentNode.insertBefore(tagjs, s);
	}
};
dfmBrightTag.init();