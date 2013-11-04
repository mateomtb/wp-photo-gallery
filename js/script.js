// Avoid `console` errors in browsers that lack a console.
(function() {
    var method;
    var noop = function noop() {};
    var methods = [
        'assert', 'clear', 'count', 'debug', 'dir', 'dirxml', 'error',
        'exception', 'group', 'groupCollapsed', 'groupEnd', 'info', 'log',
        'markTimeline', 'profile', 'profileEnd', 'table', 'time', 'timeEnd',
        'timeStamp', 'trace', 'warn'
    ];
    var length = methods.length;
    var console = (window.console = window.console || {});

    while (length--) {
        method = methods[length];

        // Only stub undefined methods.
        if (!console[method]) {
            console[method] = noop;
        }
    }
}());

//JQUERY
$(document).ready(function() {
	
	// APPLICATION VARS
	var projectURL = ""; // base url for project for use in ajax apps

	////////////////////
	// AJAX FUNCTIONS //
	////////////////////
	
	$.ajaxSetup({ cache: false });
	
	// BACKBUTTON LOADER
	// $(window).hashchange( function(){
	// 	// ...
	// });
	
	$('#tooltips').tooltip();
	
	// RESPONSIVE TABLES
	if($('.responsive').length) {
		var switched = false;
		var updateTables = function() {
			if (($(window).width() < 767) && !switched ){
				switched = true;
				$("table.responsive").each(function(i, element) {
					splitTable($(element));
				});
				return true;
			} else if (switched && ($(window).width() > 767)) {
				switched = false;
				$("table.responsive").each(function(i, element) {
					unsplitTable($(element));
				});
			}
		};
		$(window).load(updateTables);
		$(window).bind("resize", updateTables);
		
		
		function splitTable(original) {
			original.wrap("<div class='table-wrapper' />");
			var copy = original.clone();
			copy.find("td:not(:first-child), th:not(:first-child)").css("display", "none");
			copy.removeClass("responsive");
			original.closest(".table-wrapper").append(copy);
			copy.wrap("<div class='pinned' />");
			original.wrap("<div class='scrollable' />");
		}
		function unsplitTable(original) {
			original.closest(".table-wrapper").find(".pinned").remove();
			original.unwrap();
			original.unwrap();
		}
	}


	// Validate
	// http://bassistance.de/jquery-plugins/jquery-plugin-validation/
	// http://docs.jquery.com/Plugins/Validation/
	// http://docs.jquery.com/Plugins/Validation/validate#toptions
		// 	
		// $('#contact-form').validate({
		// 	    rules: {
		// 	      name: {
		// 	        minlength: 2,
		// 	        required: true
		// 	      },
		// 	      email: {
		// 	        required: true,
		// 	        email: true
		// 	      },
		// 	      subject: {
		// 	      	minlength: 2,
		// 	        required: true
		// 	      },
		// 	      message: {
		// 	        minlength: 2,
		// 	        required: true
		// 	      }
		// 	    },
		// 	    highlight: function(label) {
		// 	    	$(label).closest('.control-group').addClass('error');
		// 	    },
		// 	    success: function(label) {
		// 	    	label
		// 	    		.text('OK!').addClass('valid')
		// 	    		.closest('.control-group').addClass('success');
		// 	    }
		// 	  });


	/////////////
	// ON LOAD //
	/////////////


	//////////////////////
	// HELPER FUNCTIONS //
	//////////////////////	
	function getCheckedValue(radioObj) {
		if(!radioObj) { return ""; }
		var radioLength = radioObj.length;
		if(radioLength === undefined) {
			return (radioObj.checked) ? radioObj.value : "";
		}
		for (var i = 0; i < radioLength; i++) {
			if(radioObj[i].checked) {
				return radioObj[i].value;
			}
		}
		return "";
	}
	function getUrlVars() {
		var vars = {};
		var parts = window.location.href.replace(/[#&]+([^=&]+)=([^&]*)/gi, function(m,key,value) {
			vars[key] = value;
		});
		return vars;
	}
	function addCommas(nStr) {
		nStr += '';
		var x = nStr.split('.');
		var x1 = x[0];
		var x2 = x.length > 1 ? '.' + x[1] : '';
		var rgx = /(\d+)(\d{3})/;
		while (rgx.test(x1)) {
			x1 = x1.replace(rgx, '$1' + ',' + '$2');
		}
		return x1 + x2;
	}
	function formatDate(input) {
		var datePart = input.match(/\d+/g),
			months = new Array("", "Jan", "Feb", "March", "April", "May", "June", "July", "Aug", "Sept", "Oct", "Nov", "Dec");	
			year = datePart[0],
			day = datePart[2],
			month = months[parseInt(datePart[1])];
		return month + ' ' + day + ', ' + year;
	}
});