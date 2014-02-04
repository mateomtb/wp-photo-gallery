    </div> <!-- #content -->
    <footer id="site-footer">
        <div class="container">
            <a class="branding md"><?php include('img/logo.svg');?><span class="sr-only">The Denver Post</span></a>
            <ul class="share-widget list-inline">
                <li>
                    <a data-toggle="tooltip" data-placement="top" data-original-title="Like us on Facebook" title="Like us on Facebook" class="fc-webicon facebook" href="">Facebook</a>
                </li>
                <li>
                    <a data-toggle="tooltip" data-placement="top" data-original-title="Follow us on Twitter @denverpost" title="Follow us on Twitter @denverpost" class="fc-webicon twitter" href="http://www.twitter.com/denverpost">Twitter</a>
                </li>
                <li>
                    <a data-toggle="tooltip" data-placement="top" data-original-title="Google Plus" title="Google Plus" class="fc-webicon googleplus" href="">Google Plus</a>
                </li>
                <li>
                    <a data-toggle="tooltip" data-placement="top" data-original-title="Subscribe to our RSS Feed" title="Subscribe to our RSS Feed" class="fc-webicon rss" href="">RSS Feed</a>
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
            $bigMenu = $($('#site-navigation ul')[0]); // this is the navbar for offcanvas layout purposes

        // CAROUSELS
        // ----------------------------------------
        if($('.carousel').length) {
          $('.carousel').carousel();
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

        // TOOLTIPS
        // ----------------------------------------
        $('.share-widget').tooltip({
          selector: "[data-toggle=tooltip]",
          container: "body"
        });

        // CHECK CLICK EVENT ON ON CANVAS NAV
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

        // RESIZE HANDLER
        // ----------------------------------------

        $(window).resize(function() {
          if($(window).width() > breakpointMD) {
            $('body').removeClass('off-canvas-active');
            $('.menu-toggle').removeClass('moved');
            $('.back-toggle').removeClass('active');
            if($bigMenu.hasClass('active')) {
              $bigMenu.removeClass('active');
              $('.dropdown-menu').removeClass('active');
            }
          }
        if($(window).width() <= breakpointMD) {
          setToggle();
        }
        });

        // left rail shrinking
            //         if($('.home-page').length) {
            // var $leftRail = $('.left-rail'),
            //                 bh = $('.centerpiece').height(),
            //                 breakpointMD = 768;
            //             if($(window).width() > 767) {
            //               bh = $('.centerpiece').height() - 40;
            //   $leftRail.css({'height' : bh});
            //             } else {
            //               $leftRail.css({'height' : 'auto'});
            //             }
            // $(window).resize(function(){
            //     if($(window).width() > breakpointMD) {
            //                   bh = $('.centerpiece').height() - 40;
            //       $leftRail.css({'height' : bh});
            //     } else {
            //                   $leftRail.css({'height' : 'auto'});
            //                 }
            //             });
            //         }





      });
    }());
    
    </script>
</body>
</html>