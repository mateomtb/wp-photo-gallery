    </div> <!-- #content -->
    <footer id="site-footer">
        <div class="container">
            <a class="branding md"><?php include('img/logo.svg');?><span class="sr-only">The Denver Post</span></a>
            <ul class="share-widget list-inline">
                <li>
                    <a data-toggle="tooltip" data-placement="top" data-original-title="Like us on Facebook" title="Like us on Facebook" class="webicon facebook" href="">Facebook</a>
                </li>
                <li>
                    <a data-toggle="tooltip" data-placement="top" data-original-title="Follow us on Twitter @denverpost" title="Follow us on Twitter @denverpost" class="webicon twitter" href="http://www.twitter.com/denverpost">Twitter</a>
                </li>
                <li>
                    <a data-toggle="tooltip" data-placement="top" data-original-title="Google Plus" title="Google Plus" class="webicon googleplus" href="">Google Plus</a>
                </li>
                <li>
                    <a data-toggle="tooltip" data-placement="top" data-original-title="Subscribe to our RSS Feed" title="Subscribe to our RSS Feed" class="webicon rss" href="">RSS Feed</a>
                </li>
            </ul> <!-- .share-widget -->
            <ul class="colophon list-inline">
                <li>Copyright &copy;<?php echo date('Y'); ?> The Denver Post</li>
                <li><a href="">Terms of Use</a></li>
                <li><a href="">Ethics Policy</a></li>
                <li><a href="">Privacy Policy</a></li>
                <li><a href="">Permissions</a></li>
                <li><a href="">Corrections</a></li>
                <li><a href="">Accessibility</a></li>
                <br />
                <li><a href=""><strong>Site Help</strong></a></li>
                <li><a href=""><strong>Contact Us</strong></a></li>
                <li><a href=""><strong>Unsubscribe</strong></a></li>
            </ul>
        </div><!-- .container -->
    </footer><!-- #site-footer -->
    
    <!-- JAVASCRIPTS -->
    
    <!-- JQUERY: Grab Google CDN's jQuery. fall back to local if necessary -->
    <script src="<?php echo JS_DIR; ?>/lib/jquery.js"></script>
    <script src="<?php echo JS_DIR; ?>/bartertown.min.js"></script>
    <!--[if lt IE 9]>
      <script src="<?php echo JS_DIR; ?>/ie/selectivizr.js"></script>
      <script src="<?php echo JS_DIR; ?>/ie/respond.js"></script>
    <![endif]-->
    
    <script>
    
    
    (function() {
      $('document').ready(function(){

        // VARS
        // ---------------------------------------

        var breakpointMD = 768,
            breakpointLG = 960,
            $bigMenu = $($('#site-navigation ul')[0]); // this is the navbar for offcanvas layout purposes

        // RESIZE HANDLER
        // ----------------------------------------

        $(window).resize(function() {

          // For Tablets and larger
          if($(window).width() > breakpointMD) {
            $('body').removeClass('off-canvas-active');
            $('.menu-toggle').removeClass('moved');
            $('.back-toggle').removeClass('active');
            if($bigMenu.hasClass('active')) {
              $bigMenu.removeClass('active');
              $('.dropdown-menu').removeClass('active');
              checkRightRailHeight();
            }
            // clear search active class when resizing
            if($('body').hasClass('search-active')) {
                $('body').removeClass('search-active')
            }
          } else {
           // $('#content .row:first-child').removeAttr('style');
          }

          // For Tablet and smaller
          if($(window).width() <= breakpointMD) {
            setToggle();
          }

            if($(window).width() < breakpointMD) {
                setSearchButton();
            } else {
                restoreDefaultSearch();
            }

          // For Desktops and larger
          if($(window).width() >= breakpointLG) {
            if($('.share-placeholder').length) {
                activateSharebar();
            }
          } else {
            if($('.share-placeholder').length) {
                deactivateSharebar();
            }
          }
        }); // end resize function

        // Smart resize -- in case you need it
        $(window).on("debouncedresize", function() {
            
        });
        
        // CAROUSELS
        // ----------------------------------------
        if($('.carousel').length) {
          $('.carousel').carousel();
        }

        // SEARCH TOGGLE
        // ----------------------------------------
        if($(window).width() < breakpointMD) {
            setSearchButton();
        } else {
            restoreDefaultSearch();
        }
        function setSearchButton() {
            $('#search-button').off('click').on('click', function(e){
                e.preventDefault();
                console.log('seach');
                ($('body').hasClass('search-active')) ? $('body').removeClass('search-active') : $('body').addClass('search-active');
            });
            if($('body').hasClass('search-active')) {
                $('#search-field').focus();
            } else {
                $('#search-field').blur();
            }
        }
        function restoreDefaultSearch() {
            $('#search-button').off('click').on('click', function(){
                $('#site-search').submit();
            });
        }

        // MEDIA CENTER CAROUSEL
        // ----------------------------------------
        if($('#media-center-promo').length) {
          var item = $('#media-center-promo').find('.active'),
            title = item[1].dataset.title,
            caption = item[1].dataset.caption;

          $('#media-center-info h2').text(title);
          $('#media-center-info .excerpt').text(caption);

          // ON SLIDE -- CHANGE CAPTION
          // ----------------------------------------
          $('#media-center-promo').on('slid.bs.carousel', function () {
            item = $(this).find('.active'),
            title = item[0].dataset.title,
            caption = item[0].dataset.caption;
            $('#media-center-info h2').text(title);
            $('#media-center-info .excerpt').text(caption);
          });
        }

        // OFF CANVAS
        // ----------------------------------------
        $('.menu-toggle').on('click', function(){
          $('body').toggleClass('off-canvas-active');
          if($('body').hasClass('off-canvas-active')) {

          } else {
            $('.menu-toggle').removeClass('moved');
            $('.back-toggle').removeClass('active');
            $bigMenu.removeClass('active');
          }
        });

        // SOCIAL BAR MOVEMENT
        // ----------------------------------------

        if($('.share-placeholder').length) {
            ($(window).width() >= breakpointLG) ?                 setTimeout(activateSharebar, 500) : deactivateSharebar();
        }

        function activateSharebar() {
            // OBJECTS
            var $article = $('.the-article'),
                $shareBar = $('.share-toolbar');

            // POSITION
            var artTop = $article.offset(), // top of the overall story div
                topBounds = artTop.top, // top boundary for scrolling
                bottomBounds = artTop.top +  $article.height() -  $shareBar.height(),
                scrollTP = $(window).scrollTop();

                positionSharebar(artTop, topBounds, bottomBounds, scrollTP);  

              // ON SCROLL
              $(window).scroll(function() { 
                  scrollTP = $(window).scrollTop(); // reset scrolling variable
                  positionSharebar(artTop, topBounds, bottomBounds, scrollTP);
              });
          }

        function deactivateSharebar() {
            $('.share-placeholder').removeAttr('style');
            $(window).unbind('scroll');
        }

        function positionSharebar(at, tb, bb, st) {
            if (st > tb && st < bb) { // if the sharebar is within our bounds
              $('.share-placeholder').css({'position' : 'fixed', 'top' : '0', 'z-index' : '1000'}); // set the sharebar position to fixed
            } else if(st <= tb) { // else if the sharebar is on top of our boundary
              $('.share-placeholder').css({'position' : 'absolute', 'top' : '0', 'z-index' : '25'}); // set to the original css position
            } else if(st >= bb) { // else if the sharebar is below out boundary
              $('.share-placeholder').css({'position' : 'absolute' , 'top' : bb - (at.top + 10), 'z-index' : '5000' }); // freeze the sharebar on the bottom
            }
        }

        // TOOLTIPS
        // ----------------------------------------
        $('.share-widget').tooltip({
          selector: "[data-toggle=tooltip]",
          container: "body"
        });

        // CHECK CLICK EVENT ON ON CANVAS NAV
        // ----------------------------------------
        if($(window).width() <= breakpointMD) {
          setToggle();
        }
        function setToggle() {
            $('.dropdown-toggle').on('click', function() {
                $bigMenu.addClass('active');
                $('.dropdown-menu').removeClass('active');
                $(this).parent().find('.dropdown-menu').toggleClass('active');
                $('.back-toggle').addClass('active');
                $('.menu-toggle').addClass('moved');
                $('.back-toggle').on('click', function(){
                    console.log('click');
                    $('.menu-toggle').removeClass('moved');
                    $('.back-toggle').removeClass('active');
                    $bigMenu.removeClass('active');
                });
            });
        }

        // CHECK RIGHT RAIL HEIGHT
        // ----------------------------------------
        setTimeout(checkRightRailHeight, 200);
        // For instances when the right rail is longer
        // than the content rail
        function checkRightRailHeight() {
            console.log('check');
            var rrH = $('.right-rail').height();
            var cwH = $('.content-well').height();
            console.log(rrH);
            if (rrH > cwH) {
                $('#content .row:first-child').height(rrH);
            }
        }

        // WEATHER/TRAFFIC/MARKETS
        // this could probably a btn group
        // ----------------------------------------
        var weatherToggle = $('.weather-toggle a'),
            trafficToggle = $('.traffic-toggle a'),
            marketsToggle = $('.markets-toggle a');

        weatherToggle.click(function(e) {
          e.preventDefault();
          activateTopBar($(this), $('.weather-bar'), $('#topbar').find('.visible'));
          trafficToggle.removeClass('active');
          marketsToggle.removeClass('active');
        });

        trafficToggle.click(function(e){
          e.preventDefault();
          activateTopBar($(this), $('.traffic-bar'), $('#topbar').find('.visible'));
          weatherToggle.removeClass('active');
          marketsToggle.removeClass('active');
        });

        marketsToggle.click(function(e){
          e.preventDefault();
          activateTopBar($(this), $('.markets-bar'), $('#topbar').find('.visible'));
          trafficToggle.removeClass('active');
          weatherToggle.removeClass('active');
        });

      function activateTopBar($btn, $target, $active) {
        if($('#topbar').is(':visible')) {
          if($btn.hasClass('active')) {
            $('#topbar').slideUp('fast', function(){
              $target.removeClass('visible');
            });
          } else {
            $('#topbar').slideUp('fast', function(){
              $('#topbar .visible').removeClass('visible');
              $target.addClass('visible');
              $('#topbar').slideDown('fast');
            });

          }
        } else {
          $target.addClass('visible');
          $('#topbar').slideDown('fast');
        }
        $btn.toggleClass('active');
      }
      });
    }());
    
    </script>
</body>
</html>