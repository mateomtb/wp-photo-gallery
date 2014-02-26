jQuery(document).ready(function() {
    if ( typeof console.log != 'undefined' ) console.log("LOADING");

var mainCSS = "<link rel=\"stylesheet\" type=\"text/css\" href=\"http://webservices.medianewsgroup.com/eventful/eventful.css\" />";	
var saxoCSS = "<link rel=\"stylesheet\" type=\"text/css\" href=\"http://webservices.medianewsgroup.com/eventful/eventfulsaxo.css\" />";
//var saxoCSS = "<link rel=\"stylesheet\" type=\"text/css\" href=\"http://bangops.com/dfmtests/eventful/eventfulsaxo.css\" />";
var smallCSS = "<link rel=\"stylesheet\" type=\"text/css\" href=\"http://webservices.medianewsgroup.com/eventful/eventfulsmall.css\" />";
var ieOverride = "<!--[if IE]><link rel=\"stylesheet\" type=\"text/css\" href=\"http://webservices.medianewsgroup.com/eventful/all-ie-only.css\" /><![endif]-->";

var currentURL = document.URL;
var eventfulOldURL = 'http://webservices.medianewsgroup.com/eventful/eventful.php?referrer=' + currentURL; 
var eventful300URL = 'http://webservices.medianewsgroup.com/eventful/eventfulsaxo.php?referrer=' + currentURL;
//alert (eventful300URL);
var eventfulsmallURL = 'http://webservices.medianewsgroup.com/eventful/eventfulsmall.php?referrer=' + currentURL;

jQuery(document).ready(function() {
	if ( typeof console.log != 'undefined' ) console.log("Rotator loading...");
	jQuery('.rotator').jshowoff({ animatePause: false, speed:5000, links:true, controls:true, controlText:{play:'Reproducir',pause:'Pausar',previous:'',next:''}, effect:'fade' });
});


   jQuery(document).ready(function() {
   if ( typeof console.log != 'undefined' ) console.log("Datepicker functions started");
   
   jQuery('#inp-start_date').datepicker( {
       //altField: "#inp-start_date_display",
	   //altFormat: "mm/dd/yy",
	   //dateFormat: "yymmdd00",
       selectWeek: true,
       inline: true,	   
	   onClose: function( selectedDate ) {
		var formattedDate = Date.parse(selectedDate);
		formattedDate = jQuery.datepicker.formatDate( "yymmdd00", new Date(selectedDate));
		jQuery( "#inp-stop_date" ).datepicker( "option", "minDate", selectedDate );
		window.startdate = formattedDate;
		if(typeof stopdate === 'undefined'){
		window.stopdate=formattedDate;
		}
		var whenquerystring ="<input id=\"actualdaterange\" type=\"hidden\" name=\"when\" value=\"" + startdate + "-" + stopdate + "\"  />";
		jQuery("#startstopdate").html(whenquerystring);		
		}
   });
   
   jQuery('#inp-stop_date').datepicker( {
       //altField: "#inp-stop_date_display",
	   //altFormat: "mm/dd/yy",
	   //dateFormat: "yymmdd23",
       selectWeek: true,
       inline: true,
       onClose: function( selectedDate ) {
	    var formattedDate = Date.parse(selectedDate);
		formattedDate = jQuery.datepicker.formatDate( "yymmdd23", new Date(selectedDate));		
		jQuery( "#inp-start_date" ).datepicker( "option", "maxDate", selectedDate );
		window.stopdate = formattedDate;
		if(typeof startdate === 'undefined'){
		window.startdate=formattedDate;
		}
		var whenquerystring ="<input id=\"actualdaterange\" type=\"hidden\" name=\"when\" value=\"" + startdate + "-" + stopdate + "\"  />";
		jQuery("#startstopdate").html(whenquerystring);		
		}		
   });  
});

if (document.getElementById("eventful") != null) {
  jQuery("head").append(mainCSS);
  jQuery.ajax({
  url: eventfulOldURL,
  dataType: 'html',
  type: 'GET',
  success: function(response) {    
	if ( typeof console.log != 'undefined' ) console.log("Eventful widget loading...");
	jQuery("#eventful").html(response);	
  },
 error: function(jqXHR, textStatus, errorThrown) {
          if ( typeof console.log != 'undefined' ) console.log(jqXHR.readyState + '\n' + textStatus + '\n' + errorThrown.message);
        }
});
} else {
  // do stuff
}

if (document.getElementById("eventfulsmall")!= null) {
  jQuery("head").append(smallCSS);
  jQuery("head").append(ieOverride);
  jQuery.ajax({
  url: eventfulsmallURL,
  dataType: 'html',
  type: 'GET',
  success: function(response) {
	//if ( typeof console.log != 'undefined' ) console.log("Eventful widget loading...");
	window.eventsURL = jQuery(response).find(".topEight li a");
	window.eventsURL = eventsURL[0].host;
	jQuery("#eventfulsmall").html(response);	
	
  },
 error: function(jqXHR, textStatus, errorThrown) {
          if ( typeof console.log != 'undefined' ) console.log(jqXHR.readyState + '\n' + textStatus + '\n' + errorThrown.message);
		  //alert (jqXHR.readyState + '\n' + textStatus + '\n' + errorThrown.message);
        }
});
} else {
  // do stuff
}


if(jQuery("#eventfulsaxo")) {
  jQuery("head").append(saxoCSS);
  jQuery.ajax({
  url: eventful300URL,
  dataType: 'html',
  type: 'GET',
  success: function(response) {
	//if ( typeof console.log != 'undefined' ) console.log("Eventful widget loading...");
	window.eventsURL = jQuery(response).find(".topEight li a");
	window.eventsURL = eventsURL[0].host;
	//if ( typeof console.log != 'undefined' ) console.log(eventsURL);	
	jQuery("#eventfulsaxo").html(response);
	
  },
 error: function(jqXHR, textStatus, errorThrown) {
          //if ( typeof console.log != 'undefined' ) console.log(jqXHR.readyState + '\n' + textStatus + '\n' + errorThrown.message);
		  //alert (jqXHR.readyState + '\n' + textStatus + '\n' + errorThrown.message);
        }
});
} 

else {
  //Do nothing.
}

});


   jQuery(document).ready(function() {
   jQuery('#pickadate').datepicker( {
       dateFormat: "yymmdd",
        onSelect: function(date) {
           		   
		   var selectedDate = "http://" + eventsURL + "/search?q=*&when=" + date + "00-" + date + "23&ga_type=events";
           top.location.href = selectedDate;
       },
      selectWeek: true,
       inline: true,
      startDate: '01/01/2000',       
       firstDay: 1
   });
     
  
   
});

var vMode = document.documentMode;
var standardsCheck = document.compatMode==='CSS1Compat'?'Standards':'Quirks';
if (standardsCheck == "Quirks" && vMode == 5){
console.log (standardsCheck);
jQuery(document).ready(function(event,request, settings) {
   var p = jQuery(".moreEventsButton");  
var offset = p.offset();  
var topeightLeft = { 
"left" : offset.left,
"margin-top" : "30px"
};  
jQuery(".topEight").css(topeightLeft); 
 });

}


/*

Title:		jShowOff: a jQuery Content Rotator Plugin
Author:		Erik Kallevig
Version:	0.1.2
Website:	http://ekallevig.com/jshowoff
License: 	Dual licensed under the MIT and GPL licenses.

*/

(function(jQuery){jQuery.fn.jshowoff=function(settings){var config={animatePause:true,autoPlay:true,changeSpeed:600,controls:true,controlText:{play:'Play',pause:'Pause',next:'Next',previous:'Previous'},effect:'fade',hoverPause:true,links:true,speed:3000};if(settings)jQuery.extend(true,config,settings);if(config.speed<(config.changeSpeed+20)){alert('jShowOff: Make speed at least 20ms longer than changeSpeed; the fades aren\'t always right on time.');return this;};this.each(function(i){var jQuerycont=jQuery(this);var gallery=jQuery(this).children().remove();var timer='';var counter=0;var preloadedImg=[];var howManyInstances=jQuery('.jshowoff').length+1;var uniqueClass='jshowoff-'+howManyInstances;var cssClass=config.cssClass!=undefined?config.cssClass:'';jQuerycont.css('position','relative').wrap('<div class="jshowoff '+uniqueClass+'" />');var jQuerywrap=jQuery('.'+uniqueClass);jQuerywrap.css('position','relative').addClass(cssClass);jQuery(gallery[0]).clone().appendTo(jQuerycont);preloadImg();if(config.controls){addControls();if(config.autoPlay==false){jQuery('.'+uniqueClass+'-play').addClass(uniqueClass+'-paused jshowoff-paused').text(config.controlText.play);};};if(config.links){addSlideLinks();jQuery('.'+uniqueClass+'-slidelinks a').eq(0).addClass(uniqueClass+'-active jshowoff-active');};if(config.hoverPause){jQuerycont.hover(function(){if(isPlaying())pause('hover');},function(){if(isPlaying())play('hover');});};if(config.autoPlay&&gallery.length>1){timer=setInterval(function(){play();},config.speed);};if(gallery.length<1){jQuery('.'+uniqueClass).append('<p>For jShowOff to work, the container element must have child elements.</p>');};function transitionTo(gallery,index){var oldCounter=counter;if((counter>=gallery.length)||(index>=gallery.length)){counter=0;var e2b=true;}
else if((counter<0)||(index<0)){counter=gallery.length-1;var b2e=true;}
else{counter=index;}
if(config.effect=='slideLeft'){var newSlideDir,oldSlideDir;function slideDir(dir){newSlideDir=dir=='right'?'left':'right';oldSlideDir=dir=='left'?'left':'right';};counter>=oldCounter?slideDir('left'):slideDir('right');jQuery(gallery[counter]).clone().appendTo(jQuerycont).slideIt({direction:newSlideDir,changeSpeed:config.changeSpeed});if(jQuerycont.children().length>1){jQuerycont.children().eq(0).css('position','absolute').slideIt({direction:oldSlideDir,showHide:'hide',changeSpeed:config.changeSpeed},function(){jQuery(this).remove();});};}else if(config.effect=='fade'){jQuery(gallery[counter]).clone().appendTo(jQuerycont).hide().fadeIn(config.changeSpeed,function(){
//Do Nothing
});if(jQuerycont.children().length>1){jQuerycont.children().eq(0).css('position','absolute').fadeOut(config.changeSpeed,function(){jQuery(this).remove();});};}else if(config.effect=='none'){jQuery(gallery[counter]).clone().appendTo(jQuerycont);if(jQuerycont.children().length>1){jQuerycont.children().eq(0).css('position','absolute').remove();};};if(config.links){jQuery('.'+uniqueClass+'-active').removeClass(uniqueClass+'-active jshowoff-active');jQuery('.'+uniqueClass+'-slidelinks a').eq(counter).addClass(uniqueClass+'-active jshowoff-active');};};function isPlaying(){return jQuery('.'+uniqueClass+'-play').hasClass('jshowoff-paused')?false:true;};function play(src){if(!isBusy()){counter++;transitionTo(gallery,counter);if(src=='hover'||!isPlaying()){timer=setInterval(function(){play();},config.speed);}
if(!isPlaying()){jQuery('.'+uniqueClass+'-play').text(config.controlText.pause).removeClass('jshowoff-paused '+uniqueClass+'-paused');}};};function pause(src){clearInterval(timer);if(!src||src=='playBtn')jQuery('.'+uniqueClass+'-play').text(config.controlText.play).addClass('jshowoff-paused '+uniqueClass+'-paused');if(config.animatePause&&src=='playBtn'){jQuery('<p class="'+uniqueClass+'-pausetext jshowoff-pausetext">'+config.controlText.pause+'</p>').css({fontSize:'62%',textAlign:'center',position:'absolute',top:'40%',lineHeight:'100%',width:'100%'}).appendTo(jQuerywrap).addClass(uniqueClass+'pauseText').animate({fontSize:'600%',top:'30%',opacity:0},{duration:500,complete:function(){jQuery(this).remove();}});}};function next(){goToAndPause(counter+1);};function previous(){goToAndPause(counter-1);};function isBusy(){return jQuerycont.children().length>1?true:false;};function goToAndPause(index){jQuerycont.children().stop(true,true);if((counter!=index)||((counter==index)&&isBusy())){if(isBusy())jQuerycont.children().eq(0).remove();transitionTo(gallery,index);pause();};};function preloadImg(){jQuery(gallery).each(function(i){jQuery(this).find('img').each(function(i){preloadedImg[i]=jQuery('<img>').attr('src',jQuery(this).attr('src'));});});};function addControls(){jQuerywrap.append('<p class="jshowoff-controls '+uniqueClass+'-controls"><a class="jshowoff-play '+uniqueClass+'-play" href="#null">'+config.controlText.pause+'</a> <a class="jshowoff-prev '+uniqueClass+'-prev" href="#null">'+config.controlText.previous+'</a> <a class="jshowoff-next '+uniqueClass+'-next" href="#null">'+config.controlText.next+'</a></p>');jQuery('.'+uniqueClass+'-controls a').each(function(){if(jQuery(this).hasClass('jshowoff-play'))jQuery(this).click(function(){isPlaying()?pause('playBtn'):play();return false;});if(jQuery(this).hasClass('jshowoff-prev'))jQuery(this).click(function(){previous();return false;});if(jQuery(this).hasClass('jshowoff-next'))jQuery(this).click(function(){next();return false;});});};function addSlideLinks(){jQuerywrap.append('<p class="jshowoff-slidelinks '+uniqueClass+'-slidelinks"></p>');jQuery.each(gallery,function(i,val){var linktext=jQuery(this).attr('title')!=''?jQuery(this).attr('title'):i+1;jQuery('<a class="jshowoff-slidelink-'+i+' '+uniqueClass+'-slidelink-'+i+'" href="#null">'+linktext+'</a>').bind('click',{index:i},function(e){goToAndPause(e.data.index);return false;}).appendTo('.'+uniqueClass+'-slidelinks');});};});return this;};})(jQuery);(function(jQuery){jQuery.fn.slideIt=function(settings,callback){var config={direction:'left',showHide:'show',changeSpeed:600};if(settings)jQuery.extend(config,settings);this.each(function(i){jQuery(this).css({left:'auto',right:'auto',top:'auto',bottom:'auto'});var measurement=(config.direction=='left')||(config.direction=='right')?jQuery(this).outerWidth():jQuery(this).outerHeight();var startStyle={};startStyle['position']=jQuery(this).css('position')=='static'?'relative':jQuery(this).css('position');startStyle[config.direction]=(config.showHide=='show')?'-'+measurement+'px':0;var endStyle={};endStyle[config.direction]=config.showHide=='show'?0:'-'+measurement+'px';jQuery(this).css(startStyle).animate(endStyle,config.changeSpeed,callback);});return this;};})(jQuery);

