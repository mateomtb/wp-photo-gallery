// On document load -- jQuery
$(document).ready(function() {

  // Detection for touch devices
  // -----------------------------------
  if (Modernizr.touch) {
    console.log('touch device!!!');
    // Fast click implementation
    // Removes 300 ms delay on most mobile phones
    FastClick.attach(document.body);
  } else {
    console.log('not a touch device!!!');
  }

  // VARS
  var projectURL = ''; // base url for project for use in ajax apps

  ////////////////////
  // AJAX FUNCTIONS //
  ////////////////////
  
  $.ajaxSetup({ cache: false });
  
  /////////////
  // ON LOAD //
  /////////////
  
  // place on load functions here

});