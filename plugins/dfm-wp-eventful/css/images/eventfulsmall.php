<?php include 'functions.php';  header('Content-Type: text/html; charset=utf-8'); header("Access-Control-Allow-Origin: *"); $finalmix = array(); $testSSD=dfmMatrix(); $testPC = DetermineParentCompany($testSSD); $siteconfig= $_SESSION['siteconfig'];?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/2000/REC-xhtml1-20000126/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
<base target="_top">
<title>Advanced search - Eventful - Test</title>
<script type="text/javascript">
if (typeof window.Eventful != "object") window.Eventful = {};
Eventful.Hosts = {};
Eventful.Hosts.movies = "http://movies.eventful.com";
Eventful.Hosts.web = "http://eventful.com";
Eventful.Session = {};
Eventful.Session.userType = "session";
Eventful.Session.userRole = "";
Eventful.Session.userName = "";
Eventful.Session.isLoggedIn = false;
Eventful.Session.Prefs = {};
Eventful.Session.Prefs.sf = "%m/%d/%Y";
Eventful.Session.Prefs.tmf = "%b %e";
Eventful.Session.Prefs.mf = "%b %e, %Y";
Eventful.Session.Tests = {};
Eventful.GADebug = false;
</script>

<?php $eventsURL= $siteconfig['events_url'] ; 
$apiToken=$siteconfig['events_api'] ;
$eventfulURL= $eventsURL . 'api/v1/events/featured?api_token=' . $apiToken;
//Overrides for Beta
$eventsURL= "http://events.macombdaily.com";
$eventfulURL = "http://events.macombdaily.com/api/v1/events/search?api_token=29141fcd7359efd099833206ef55d111&image_size=block250";
 ?>

<!--[if IE]>
	<link rel="stylesheet" type="text/css" href="all-ie-only.css" />
<![endif]-->

<!--<link rel="stylesheet" type="text/css" href="http://webservices.medianewsgroup.com/eventful/eventful.css" />
<link rel="stylesheet" type="text/css" href="http://webservices.medianewsgroup.com/eventful/eventfulsaxo.css" />-->
<link rel="stylesheet" href="http://code.jquery.com/ui/1.9.2/themes/base/jquery-ui.css" />
<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.8.1/jquery.min.js"></script>
<script type="text/javascript" src="http://webservices.medianewsgroup.com/eventful/eventful.js"></script>
<script src="http://webservices.medianewsgroup.com/eventful/jquery.jshowoff.min.js"></script>
   <script src="http://code.jquery.com/ui/1.9.2/jquery-ui.js"></script>
   <script>
   $(document).ajaxComplete(function() {
   $('#datepicker').datepicker( {
       dateFormat: "yymmdd",
        onSelect: function(date) {
           var selectedDate = "<?php echo $eventsURL; ?>/search?q=*&when=" + date + "00-" + date + "23&ga_type=events";
            top.location.href = selectedDate;
       },
       selectWeek: true,
       inline: true,
       startDate: '01/01/2000',       
       firstDay: 1
   });
});
   </script>


</head>
<body id="events" class="nav-events subnav-search">
<div style="clear:both;"></div>

<?php 
//var_dump ($siteconfig);
//var_dump ($testPC);

//echo "The URL for the API Call is: " . $eventfulURL;
$apiCategory = '';
$eventsJSON = json_decode(file_get_contents($eventfulURL));
$events = $eventsJSON->api_results->events;
$events = array_slice($events, 0, 4);
$pageloc = $_SERVER['HTTP_REFERER'];

	if (strpos($pageloc,'music') || strpos($pageloc,'reverb') == true) {
		$apiCategory = 'music';
		$apiCall = $eventsURL . '/api/v1/events/featured?api_token=' . $apiToken . '&category=' . $apiCategory;
		$eventsJSON = json_decode(file_get_contents($apiCall));
		echo "The URL for the API Call is: " . $apiCall;
		$events = $eventsJSON->api_results->events;
		$events = array_slice($events, 0, 4);
	}

	if (strpos($pageloc,'food') || strpos($pageloc,'restaurant') == true) {
		$apiCategory = 'food';
		$apiCall = $eventsURL . '&category=' . $apiCategory;
		$eventsJSON = json_decode(file_get_contents($apiCall));
		$events = $eventsJSON->api_results->events;
		$events = array_slice($events, 0, 4);
	}

	if (strpos($pageloc,'stage') || strpos($pageloc,'theater') == true) {
		$apiCategory = 'performing_arts';
		$apiCall = $eventsURL . '&category=' . $apiCategory;
		$eventsJSON = json_decode(file_get_contents($apiCall));
		$events = $eventsJSON->api_results->events;
		$events = array_slice($events, 0, 4);
		}

	if (strpos($pageloc,'sports') || strpos($pageloc,'buffzone') == true) {
		$apiCategory = 'sports';
		$apiCall = $eventsURL . '&category=' . $apiCategory;
		$eventsJSON = json_decode(file_get_contents($apiCall));
		$events = $eventsJSON->api_results->events;
		$events = array_slice($events, 0, 4);
		}
		
	if (strpos($pageloc,'movie') || strpos($pageloc,'film') || strpos($pageloc,'cinema') == true) {
		$apiCategory = 'movies_film';
		$apiCall = $eventsURL . '&category=' . $apiCategory;
		echo "The URL for the API Call is: " . $eventfulURL;
		$eventsJSON = json_decode(file_get_contents($apiCall));
		$events = $eventsJSON->api_results->events;
		$events = array_slice($events, 0, 4);
		}

	if (strpos($pageloc,'moms') || strpos($pageloc,'family') || strpos($pageloc,'kids') == true) {
		$apiCategory = 'family_fun_kids';
		$apiCall = $eventsURL . '&category=' . $apiCategory;
		$eventsJSON = json_decode(file_get_contents($apiCall));
		$events = $eventsJSON->api_results->events;
		$events = array_slice($events, 0, 4);
		}
	
	
//var_dump($events);
//var_dump($eventsJSON);
 ?>
<div class="thingsToDoIn"><span>Local Events</span></div>
<div class="menu">
<div id="featuredEvents" class="activeTab">Most Popular</div>
<div id="datePickerTab">Pick Dates</div>
</div>
<div style="clear:both;"></div>


<div class="rotator">



<?php foreach($events as $event) {?>

	<div class="eventSlide" style="" title="&nbsp;">
	<div style="clear:both;"></div>
		<div class="imageContainer" style="" title="<?php echo $event->title;?>"><a href="<?php echo $event->permalink;?>"><img src="<?php echo $event->image;?>" width="161" height="161" /></a></div>
		<div class="eventDescription" style="" title="<?php echo $event->title;?>">
			<div class="eventTitle"><a href="<?php echo $event->permalink;?>" style="font: Times New Roman, serif !important;"><?php 
			
			$titlelength = strlen($event->title);
			
			if ($titlelength < 27) {
				echo $event->title;
			}			

			if ($titlelength > 27 ) {
				echo substr( $event->title, 0, 27) . '...';
			}						
			?></a></div>
			<div class="eventDate" style=""><?php 
$date = $event->start_time;
echo date('M j', strtotime($date));
?></div>
			<div class="eventVenue"><a href="<?php echo $event->venue_url;?>" style=""><?php echo $event->venue_name;?></a></div>
			
			
			<div class="share" style="">
				<a href="http://www.facebook.com/sharer.php?u=<?php echo $event->permalink;?>" class="facebook"></a>
				<a href="http://twitter.com/share?text=An%20Awesome%20Link&url=<?php echo $event->permalink;?>" class="twitter"></a>
				<a href="https://plus.google.com/share?url=<?php echo $event->permalink;?>" onclick="javascript:window.open(this.href,
  '', 'menubar=no,toolbar=no,resizable=yes,scrollbars=yes,height=600,width=600');return false;" class="googlePlus"></a>
				<a class="email" href="mailto:?subject=<?php echo $event->title;?>&body=<?php echo $event->permalink;?>"></a>
			</div>
			
		
	</div>
	</div>
	<?php } ?>

</div>

<div id="datepicker"></div>

<script type="text/javascript">	
$('.rotator').jshowoff({ animatePause: false, speed:5000, links:true, controls:true, controlText:{play:'Reproducir',pause:'Pausar',previous:'',next:''}, effect:'fade' });
</script>

<div class="search">

<form id="site-search" action="<?php echo $eventsURL; ?>/search" method="get">
<input type="text" name="q" id="inp-q" value=""    alt="Search" class="inactive-text"      />



<button style="background-color: #9d2e27; background-image: -moz-linear-gradient(center top , #ce5445, #9d2e27); border: 1px solid #9d2e27; text-shadow: 0 -1px 0 #9d2e27; border-radius: 3px; color: #FFFFFF; cursor: pointer; display: inline-block; font-family: arial,helvetica,sans-serif; font-size: 9px; font-weight: bold; height: 18px; padding: 0; margin-left:10px; position: relative; text-align: center; text-transform: uppercase; top: 0;     width: 46px; background-clip: padding-box;">

<span style="border-color: #FFFFFF transparent transparent; border-style: solid none none; border-width: 2px 0 0; display: block; height: 0;    left: 0;   opacity: 0.2;   position: absolute;    top: 0;    width: 100%;"></span>GO</button>


</form>

<div class="asLink">&lt; Advanced Search</div>
</div>

<div class="advancedSearch">

<div id="searchHead" class="activeTab">Advanced Search</div>
<div style="clear:both;"></div>
                 <form id="form-advanced-search" action="<?php echo $eventsURL; ?>/search" method="get">
                  <div id="search-keyword" class="area">
                    <h3>Enter keyword</h3><label for="inp-q" class=""><span class="field-name" style="margin-left:10px; margin-right:25px;">Enter Keywords</span></label>
      <input type="text" name="q" id="inp-q" value=""    alt="eg. festivals; art show" class="inactive-text"      /><span class="alert-error"></span><!--</label>--></li>
                  </div>
                
                  <div id="search-type" class="area">
                    <h3>2. Select search</h3>
                    <fieldset id="inp-domain">
<span class="field">
  <label for="inp-domain-events" class="radio"><input type="radio" name="domain" id="inp-domain-events" value="events" checked="checked" />
  Events</label>
</span>
<span class="field">
  <label for="inp-domain-venues" class="radio"><input type="radio" name="domain" id="inp-domain-venues" value="venues"  />
  Venues</label>
</span>
<span class="field">
  <label for="inp-domain-performers" class="radio"><input type="radio" name="domain" id="inp-domain-performers" value="performers"  />
  Performers</label>
</span>
<span class="field">
  <label for="inp-domain-users" class="radio"><input type="radio" name="domain" id="inp-domain-users" value="users"  />
  Users</label>
</span>
<span class="field">
  <label for="inp-domain-demands" class="radio"><input type="radio" name="domain" id="inp-domain-demands" value="demands"  />
  Demands</label>
</span>
</fieldset>
                  </div>
				  
                
                  <div id="search-refine" class="area">
                    <!--<h3>Refine search</h3>-->
                    <div class="field-container form-inline">
                      <label for="inp-start_date"><span class="field-name">Select Dates</span></label>
                      <div class="date-picker" id="date-picker-start_date">
  <div class="hidden popover empty" id="date-piker-start_date-popover" style="display:none;">
    <div class="popbd">
      <div class="calendar"></div>
      <div class="cleaner"></div>
    </div>
    <!--[if lte IE 7]><iframe class="popover-layer"></iframe><![endif]-->
  </div>
  <label for="inp-start_date" class="">
      <input type="text" name="start_date" id="inp-start_date" value=""    alt="mm/dd/yy" class="inactive-text" autocomplete="off"     /></label>
</div>
                      <div class="date-picker" id="date-picker-stop_date">
  <div class="hidden popover empty" id="date-piker-stop_date-popover" style="display:none;">
    <div class="popbd">
      <div class="calendar"></div>
      <div class="cleaner"></div>
    </div>
    <!--[if lte IE 7]><iframe class="popover-layer"></iframe><![endif]-->
  </div>
  <label for="inp-stop_date" class="">
      <input type="text" name="stop_date" id="inp-stop_date" value=""    alt="mm/dd/yy" class="inactive-text" autocomplete="off"     /></label>
</div>
                    </div>
                  
				  
				  
				  
				  
				  
				  
				  
				  
				  
				  
				  
                    <div class="field-container form-inline">
                        <label for="inp-sort_order" class="">    <span class="field-name">Sort by</span>    <select name="sort_order" id="inp-sort_order" >
      <option value="">-- optional --</option>
      <option value="Relevance" selected="selected">Relevance</option>
      <option value="Date" >Date</option>
      <option value="Popularity" >Popularity</option>
      <option value="Event" >Alphabetically</option>
      <option value="Venue" >Venue Name</option>
  
    </select></label>
                        <label for="inp-c" class="">    <span class="field-name">Limit to</span>    <select name="c" id="inp-c" >
      <option value="">-- optional --</option>
      <option value="music" >Concerts &amp; Tour Dates</option>
      <option value="conference" >Conferences &amp; Tradeshows</option>
      <option value="learning_education" >Education</option>
      <option value="family_fun_kids" >Kids &amp; Family</option>
      <option value="festivals_parades" >Festivals</option>
      <option value="movies_film" >Film</option>
      <option value="food" >Food &amp; Wine</option>
      <option value="fundraisers" >Fundraising &amp; Charity</option>
      <option value="art" >Art Galleries &amp; Exhibits</option>
      <option value="support" >Health &amp; Wellness</option>
      <option value="books" >Literary &amp; Books</option>
      <option value="attractions" >Museums &amp; Attractions</option>
      <option value="community" >Neighborhood</option>
      <option value="business" >Business &amp; Networking</option>
      <option value="singles_social" >Nightlife &amp; Singles</option>
      <option value="schools_alumni" >University &amp; Alumni</option>
      <option value="clubs_associations" >Organizations &amp; Meetups</option>
      <option value="outdoors_recreation" >Outdoors &amp; Recreation</option>
      <option value="performing_arts" >Performing Arts</option>
      <option value="animals" >Pets</option>
      <option value="politics_activism" >Politics &amp; Activism</option>
      <option value="sales" >Sales &amp; Retail</option>
      <option value="science" >Science</option>
      <option value="religion_spirituality" >Religion &amp; Spirituality</option>
      <option value="sports" >Sports</option>
      <option value="technology" >Technology</option>
      <option value="other" >Other &amp; Miscellaneous</option>
  
    </select></label>
                        
                    </div>
                  </div>

				  <div class="feLink">&lt; Featured Events</div>
                
                  <div class="form-submit">
                    <button 
  tabindex="1" 
  
  type="Submit" class="bn bn-sz-lg bn-green"><span class="bn-in"></span>Search</button>
                    <p class="form-summary" id="form-summary"/>
                    <p class="progress" />
                  </div>
                  <input type="hidden" name="t" value="" id="inp-date-time" />
                </form>


</div>
<div style="clear:both;"></div>

<div class="moreEvents" style="text-align:center!important">
	<div class="moreEventsButton">
		<span style="color:#34567c; line-height: 2.8em; font: 11px Arial,Helvetica,sans-serif; font-weight:bold;">More Local Events <?php 
$city=explode(",", $siteconfig['city']);
echo $city[0]; ?> <img src="http://webservices.medianewsgroup.com/eventful/images/downArrow.gif" /></span>

	<div class="topEight">
		<li><a href="<?php echo $eventsURL; ?>/search?cat=music">Concerts</a></li>                             
		<li><a href="<?php echo $eventsURL; ?>/search?cat=festivals_parades">Festivals</a></li>
		<li><a href="<?php echo $eventsURL; ?>/search?cat=family_fun_kids">Family</a></li>  
		<li><a href="<?php echo $eventsURL; ?>/search?cat=singles_social">Nightlife</a></li>
		<li><a href="<?php echo $eventsURL; ?>/search?cat=performing_arts">Performing arts</a></li> 
		<li><a href="<?php echo $eventsURL; ?>/search?cat=food">Restaurants</a></li>     
		<li><a href="<?php echo $eventsURL; ?>/search?cat=sports">Sports</a></li></div>
	</div>
</div>

<script>
$('.asLink').click(function() {
  $('.menu').hide();
  $('.jshowoff').hide();
  $('.search').hide();
  $('#datepicker').hide();
  $('#searchHead').show();
  $('.advancedSearch').show();
});

$('.feLink').click(function() {
  $('.menu').show();
  $('.jshowoff').show();
  $('.search').show();
  $('#searchHead').hide();
  $('.advancedSearch').hide();
});


$('#datePickerTab').click(function() {
  $('#datepicker').show();
  $('.jshowoff').hide();  
  $('#datePickerTab').addClass('activeTab');
  $('#featuredEvents').removeClass('activeTab');
});

$('#featuredEvents').click(function() {
  $('#datepicker').hide();
  $('.jshowoff').show();   
  $('#featuredEvents').addClass('activeTab');
  $('#datePickerTab').removeClass('activeTab');
});

$('.moreEventsButton').mouseover(function() {
  $('.topEight').show();
});

$('.moreEventsButton').mouseout(function() {
  $('.topEight').hide();
});

$(window).load(function () {
	$('.ui-datepicker-prev').removeAttr("title");
	$('.ui-datepicker-next').removeAttr("title");
});

</script>

</body>
