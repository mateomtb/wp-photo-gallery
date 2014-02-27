<?php require_once('inc/init.php'); // load in base objects ?>
<?php
    $page_type = 'home';
    $master_name = 'not found';
    $sub_name = 'not found';
?>
<?php require_once('temps/header.php'); // load in header ?>
    <section class="error-page">
	<div class="error-message">
		<h1>Your page was not found</h1>
        <p>This may have been the result of a broken link, an outdated search result, or we may have an error on our side. If you typed in the URL, try retyping the address and make sure it's all in lower case.</p>
        <hr />
        <h3>Or try searching for your article:</h3>
        <form id="site-search-404" action="#" class="col md-6 md-offset-3" method="get" role="search">
            <div class="input-group">
                <input id="search-field" type="text" name="s" class="form-control input-lg">
                <span class="input-group-btn">
                    <button id="search-button" class="btn primary lg" type="button"><span class="glyphicon glyphicon-search"><span class="sr-only">Search</span></span></button>
                </span>
            </div><!-- /input-group -->
        </form> <!-- #site-search -->
    </div> <!-- .search-area -->

        <div class="alternatives">
            <h3 class="page-header">Or try one of these alternatives:</h3>
            <div class="row">
                <div class="col md-4">
                    <h4>Latest news</h4>
                    <div class="link-list">
                        <ul>
                            <li><a href="">Denver police make arrest in theft of phone from paraplegic <span class="timestamp">12m</span></a></li>
                            <li><a href="">Wildfires sweep through Golden, kill 7, still 23 missing <span class="timestamp">22m</span></a></li>
                            <li><a href="">Large tornados take out huge swath of Denver County <span class="timestamp">26m</span></a></li>
                            <li><a href="">Dozens missing after earthquake strikes Colorado Springs <span class="timestamp">32m</span></a></li>
                            <li><a href="">Huge storm ﬂexing muscle; 3 feet of snow predicted <span class="timestamp">36m</span></a></li>
                            <li><a href="">Broncos rookie running back C.J. Anderson to make NFL debut Sunday <span class="timestamp">37m</span></a></li>
                        </ul>
                    </div><!-- .link-list -->
                </div> <!-- .col -->
                <div class="col md-4">
                    <h4>Most popular news</h4>
                    <div class="link-list">
                        <ul>
                            <li><a href="">Denver police make arrest in theft of phone from paraplegic <span class="timestamp">12m</span></a></li>
                            <li><a href="">Wildfires sweep through Golden, kill 7, still 23 missing <span class="timestamp">22m</span></a></li>
                            <li><a href="">Large tornados take out huge swath of Denver County <span class="timestamp">26m</span></a></li>
                            <li><a href="">Dozens missing after earthquake strikes Colorado Springs <span class="timestamp">32m</span></a></li>
                            <li><a href="">Huge storm ﬂexing muscle; 3 feet of snow predicted <span class="timestamp">36m</span></a></li>
                            <li><a href="">Broncos rookie running back C.J. Anderson to make NFL debut Sunday <span class="timestamp">37m</span></a></li>
                        </ul>
                    </div> <!-- .link-list -->
                </div> <!-- .col -->
                <div class="col md-4">
                    <h4>Need help?</h4>
                    <div class="link-list">
                        <ul>
                            <li><a href="">Contact us for site help</a></li>
                            <li><a href="">Manage your subscriptions</a></li>
                            <li><a href="">Vacation hold</a></li>
                            <li><a href="">Site FAQs</a></li>
                            <li><a href="">Submit a news tip</a></li>
                            <li><a href="">Submit a correction</a></li>
                            <li><a href="">Get home delivery</a></li>
                            <li><a href="">Download apps</a></li>
                            <li><a href="">Subscribe to an RSS feed</a></li>
                        </ul>
                    </div> <!-- .link-list -->
                </div> <!-- .col -->
            </div> <!-- .row -->
        </div> <!-- .alternatives -->
    </section>
</body>
<?php require_once('temps/footer.php'); // load in footer ?>