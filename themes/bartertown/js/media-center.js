(function($, jsonpCallback, domain, options){
    console.log('foo');
    // The URL to the media center
    var mediaCenterUrl = createUrl();
    // Container to which the widget will be attached as jQUery selector
    var container = options.container || '#media-center-container';
    // URL of media center widget template with Handlebars.js expressions
    var templateSource = options.templateSource || 
        'http://www.' + domain + '.com/wp-content/themes/bartertown/js/media-center-template.js';
    // URL of data
    var dataSource = options.dataSource || 
        mediaCenterUrl + 'rotator/?size=responsive&cat=' + section() + '&callback=' + jsonpCallback;
    // Part of the error message
    var ERROR_COMPONENT = 'The media center widget requires ';
    
    // Dependencies
    if (typeof $ === 'undefined') {
        console.log(ERROR_COMPONENT + 'need jQuery.');
        return false;
    }
    if (typeof $.fn.carousel !== 'function') {
        console.log(ERROR_COMPONENT + 'jQuery.fn.carousel. See http://sandbox.digitalfirstmedia.com/btown/');
        return false;
    }
    if (typeof Handlebars === 'undefined') {
        console.log(ERROR_COMPONENT + 'need Handlebars.js');
        return false;
    }
    if (!domain) {
        console.log(ERROR_COMPONENT + 'a domain to find feeds');
        return false;
    }

    // Define jsonp function for widget data
    window[jsonpCallback] = function(json){
        createWidget(json);
    }
    
    // Define jsonp function for widget template
    window['__mediaCenterTemplate'] = function(template) {
        window['__mcTemplate'] = template;
    }
    
    // JSONP call for for the Handlebars Template
        jsonp(templateSource);

    // Callback in a callback. So we just wait for the template assignment of the window object
    var waitingForTemplate = setInterval(function(){
        if (typeof __mcTemplate !== 'undefined') {
            jsonp(dataSource);
            clearInterval(waitingForTemplate);
        }
    }, 100);


    // ##Some funtions to break up the rest of the code nicely##
    
    // Called once the second jsonp call (for the data) succeeds
    function createWidget(data){
    
        // Some Handlebars.js stuff 
        // URL to media center
        Handlebars.registerHelper('mediacenter', function() { return mediaCenterUrl; });
        var template = Handlebars.compile(__mcTemplate);
        var html = template(data);
        $(container).html(html);
         

        // Init carousel and bind caption changes
        $('div#media-center-promo.carousel').carousel(); 
    
        $('div#media-center-promo').on('slid.bs.carousel', function () {
            var item = $(this).find('div.item.active'),
                title = item.attr('data-title'),
                caption = item.attr('data-caption'),
                url = item.attr('data-href');
            $('#media-center-info h2 a').text(title);
            $('#media-center-info .excerpt').text(caption);
            $('#media-center-info a').attr('href', url);
        });

        
        // Clean up globals
        delete window['jsonpCallback'];
        delete window['mediaCenterTemplate'];
        delete window['__mcTemplate'];
    }
        
    // Wordpress category that the feed pulls from
    function section() {
        if (typeof options.category !== 'undefined') {
            return 'rotator?cat=' + options.category;
        }
        var url = location.pathname,
            patt = /news|sports|entertainment|life|living|style/i,
            theMatch = (url.match(patt) || [])[0];
        
        if (theMatch === 'news'){
            theMatch = 'news';
        }
        else if (theMatch === 'sports'){
            theMatch = 'sports';
        }
        else if (theMatch === 'entertainment'){
            theMatch = 'entertainment';
        }
        else if (theMatch === 'life' || theMatch === 'living' || theMatch === 'style'){
            theMatch = 'lifestyles';
        }
        else {
            theMatch = 'mc_rotator_home___';
        }
        return theMatch;
    }
        
    // Not all media center URLs are photos.domain.com
    function createUrl() {
        if (options.url) {
                return options.url;
        }
        var url = 'http://photos.' + domain + '.com/';
        switch(domain) {
            //Some URLs that don't fall into the photos.domain.com structure
            case 'delcotimes':
                url = 'http://media.delcotimes.com/';
                break;
            case 'dailycamera':
                url = 'http://mediacenter.dailycamera.com/';
                break;
            case 'chicoer':
                url = 'http://media.chicoer.com/';
                break;
            case 'eptrail':
                url = 'http://mediacenter.eptrail.com/';
                break;
            case 'reporterherald':
                url = 'http://media.reporterherald.com/';
                break;
            case 'coloradodaily':
                url = 'http://mediacenter.coloradodaily.com/';
                break;
            case 'theoaklandpress':
                url = 'http://media.theoaklandpress.com/';
                break;
            case 'macombdaily':
                url = 'http://media.macombdaily.com/';
                break;
            case 'themorningsun':
                url = 'http://media.themorningsun.com/';
                break;
            case 'dailytribune':
                url = 'http://media.dailytribune.com/';
                break;
            case 'heritage':
                url = 'http://media.heritage.com/';
                break;
            case 'thenewsherald':
                url = 'http://media.thenewsherald.com/';
                break;
            case 'pressandguide':
                url = 'http://media.pressandguide.com/';
                break;
            case 'voicenews':
                url = 'http://media.voicenews.com/';
                break;
            case 'sourcenewspapers':
                url = 'http://media.sourcenewspapers.com/';
                break;
            case 'morningstarpublishing':
                url = 'http://media.morningstarpublishing.com/';
                break;
            case 'dailylocal':
                url = 'http://media.dailylocal.com/';
                break;
            case 'pottsmerc':
                url = 'http://media.pottsmerc.com/';
                break;
            case 'timesherald':
                url = 'http://media.timesherald.com/';
                break;
            case 'thereporteronline':
                url = 'http://media.thereporteronline.com/';
                break;
            case 'mainlinemedianews':
                url = 'http://media.mainlinemedianews.com/';
                break;
            case 'montgomerynews':
                url = 'http://media.montgomerynews.com/';
                break;
            case 'phoenixvillenews':
                url = 'http://media.phoenixvillenews.com/';
                break;
            case 'buckslocalnews':
                url = 'http://media.buckslocalnews.com/';
                break;
            case 'delconewsnetwork':
                url = 'http://media.delconewsnetwork.com/';
                break;
            case 'berksmontnews':
                url = 'http://media.berksmontnews.com/';
                break;
            case 'southernchestercountyweeklies':
                url = 'http://media.southernchestercountyweeklies.com/';
                break;
            case 'ydr':
                url = 'http://mediacenter.ydr.com/';
                break;
            case 'news-herald':
                url = 'http://media.news-herald.com/';
                break;
            case 'morningjournal':
                url = 'http://media.morningjournal.com/';
                break;
            case 'dailyfreeman':
                url = 'http://media.dailyfreeman.com/';
                break;
            case 'saratogian':
                url = 'http://media.saratogian.com/';
                break;
            case 'troyrecord':
                url = 'http://media.troyrecord.com/';
                break;
            case 'oneidadispatch':
                url = 'http://media.oneidadispatch.com/';
                break;
            case 'cnweekly':
                url = 'http://media.cnweekly.com/';
                break;
            case 'romeobserver':
                url = 'http://media.romeobserver.com/';
                break;
            case 'trentonian':
                url = 'http://media.trentonian.com/';
                break;
            case 'southjerseylocalnews':
                url = 'http://media.southjerseylocalnews.com/';
                break;
            case 'middletownpress':
                url = 'http://media.middletownpress.com/';
                break;
            case 'registercitizen':
                url = 'http://media.registercitizen.com/';
                break;
            case 'countytimes':
                url = 'http://media.countytimes.com/';
                break;
            case 'westhartfordnews':
                url = 'http://media.westhartfordnews.com/';
                break;
            case 'housatonictimes':
                url = 'http://media.housatonictimes.com/';
                break;
            case 'minutemannewscenter':
                url = 'http://media.minutemannewscenter.com/';
                break;
            case 'ctpostchronicle':
                url = 'http://media.ctpostchronicle.com/';
                break;
            case 'shorelinetimes':
                url = 'http://media.shorelinetimes.com/';
                break;
            case 'ctbulletin':
                url = 'http://media.ctbulletin.com/';
                break;
            case 'dolphin-news':
                url = 'http://media.dolphin-news.com/';
                break;
            case 'nhregister':
                url = 'http://photos.newhavenregister.com/';
                break;
            case 'burlesonstar':
                url = 'http://photos.burlesonstar.net/';
                break;
            case 'crowleystar':
                url = 'http://photos.crowleystar.net/';
                break;
            case 'joshuastar':
                url = 'http://photos.joshuastar.net/';
                break;
            case 'keenestar':
                url = 'http://photos.keenestar.net/';
                break;
            case 'alvaradostar':
                url = 'http://photos.alvaradostar.net/';
                break;
            case 'insidebayarea':
                url = 'http://photos.mercurynews.com/';
                break;
            case 'contracostatimes':
                url = 'http://photos.mercurynews.com/';
                break;
            case 'broomfieldenterprise':
                url = 'http://mediacenter.broomfieldenterprise.com/';
                break;
        }
        return url;
    }

    // Create scripts calls to json with padding
    function jsonp(source) {
        var script = document.createElement('script');
        script.type = 'text/javascript';
        script.src = source;
        document.getElementsByTagName('head')[0].appendChild(script);
    }

})(
    // Our JQuery
        dfm.$, 
    // Callback to data can be variable
        '__callback', 
    // The site's domain
        dfm.env.domain || (location.host.match(/([^.]+)\.\w{2,3}(?:\.\w{2})?$/) || [])[1],
    // Options for URLs, categories and containers
        mc_rotator_options_responsive || {}
);