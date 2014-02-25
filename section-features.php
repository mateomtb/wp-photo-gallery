<?php require_once('inc/init.php'); // load in base objects ?>
<?php
    $page_type = 'section-features';
    $master_name = 'entertainment';
    $sub_name = 'entertainment';
?>
<?php require_once('temps/header.php'); // load in header ?>
<div class="row">
    <div class="content-well">
        <section class="features-main">
            <div class="tabbable tabs-below">
                <div id="myTabContent" class="tab-content">
                  <div class="tab-pane fade active in" id="television">
                    <figure>
                        <?php include('temps/ui/resp-photo-lg.php'); ?>
                        <div class="teaser">
                            <h3>American Idol recap: Who deserves to make the Top 10?</h3>
                            <p class="excerpt">Guys, for the most part, pale next to the girls.</p>
                        </div>
                    </figure>
                  </div>
                  <div class="tab-pane fade" id="music">
                    <figure>
                        <?php include('temps/ui/resp-photo-lg.php'); ?>
                        <div class="teaser">
                            <h3>Review: Alabama Shakes brings its blues-rock to Oakland</h3>
                            <p class="excerpt">Vocalist Brittany Howard proves to be a major talent at Fox Theater, but rest of the band doesn't follow her good example.</p>
                        </div>
                    </figure>
                  </div>
                  <div class="tab-pane fade" id="restaurants">
                    <figure>
                        <?php include('temps/ui/resp-photo-lg.php'); ?>
                        <div class="teaser">
                            <h3>10 great Bay Area brunch spots</h3>
                            <p class="excerpt">From the fresh fare of Berkeley's Venus to the Blue Monkey Pancakes at Palo Alto's St. Michael's, there's a brunch spot to suit every taste.</p>
                        </div>
                    </figure>
                  </div>
                  <div class="tab-pane fade" id="movies">
                    <figure>
                        <?php include('temps/ui/resp-photo-lg.php'); ?>
                        <div class="teaser">
                            <h3>Five great moments in Oz history: From Baum to Wicked</h3>
                            <p class="excerpt">As 'Oz the Great and Powerful' reminds us, when it comes to pop culture, there's no place like Oz.</p>
                        </div>
                    </figure>
                  </div>
                </div>
                <ul class="nav tabs four-up">
                  <li class="active"><a href="#television" data-toggle="tab">Television</a></li>
                  <li><a href="#music" data-toggle="tab">Music</a></li>
                  <li><a href="#restaurants" data-toggle="tab">Restaurants</a></li>
                  <li><a href="#movies" data-toggle="tab">Movies</a></li>
                </ul>
            </div> <!-- .tabbable -->
        </section>
        
        <?php include('temps/content/secondary-stories.php'); ?>
            
        <div class="row">
            <div class="col md-4">
                <img src="http://placehold.it/300x800&text=widget">
            </div>
            <div class="col md-8">
                <?php include('temps/content/story-feed-large.php'); ?>
            </div>
        </div>
    </div> <!-- .content-well -->
    <div class="right-rail">
        <?php include('temps/right-rail.php'); ?>
    </div> <!-- .right-rail -->
</div>

<?php include('temps/content/bottom-line.php'); ?>
<?php require_once('temps/footer.php'); // load in footer ?>