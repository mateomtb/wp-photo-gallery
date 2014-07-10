var _JSONHelper = (function() {
	// Return path to gallery's JSON
	var path = '/wp-content/plugins/dfm-wp-photogallery/js/json/',
		filter = /[^0-9a-z]/gi;
		
		
	var helper = {
		hardcodedPathComponent: 'http://' + window.location.host + path,
		dynamicPathComponentOne : window.location.hostname,
		dynamicPathComponentTwo : window.location.pathname,
		dynamicPathComponentThree : window.location.search,
		fileType : '.json',
		cleanPath : function(path) {
			return path.replace(filter,'');
		},
		synthesizeJSONDirAndFileName : function() {
			var fileFinal = 
				this.hardcodedPathComponent + 
				this.cleanPath(
					this.dynamicPathComponentOne + 
					this.dynamicPathComponentTwo + 
					this.dynamicPathComponentThree
				) +
				this.fileType;
			return fileFinal;
		}
	}
	return helper.synthesizeJSONDirAndFileName();
})();
