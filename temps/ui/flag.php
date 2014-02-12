<div class="flag">
    <div class="container">
        <a class="menu-toggle">
            <span class="icon-bar" aria-hidden="true"></span>
            <span class="icon-bar" aria-hidden="true"></span>
            <span class="icon-bar" aria-hidden="true"></span>
            <span class="sr-only">Menu</a>
        </a>
        <button class="back-toggle"><span class="glyphicon glyphicon-chevron-left"><span class="sr-only">Back</span></span></button>
        <div class="page-id">
            <?php if($page_type === 'home'): ?>
            <h1 class="branding xl"><?php include('img/logo.svg');?><span class="sr-only">The Denver Post</span></h1>
            <?php else: ?>
            <a href="index.php" class="branding sm"><?php include('img/logo.svg');?><span class="sr-only">The Denver Post</span></a>
            <?php if($page_type !== 'article'): 
            // if it is a section (category.php) page: ?>
            <h1 class="section-name"><?php echo (isset($sub_name)) ? $sub_name : $master_name; ?></h1>
            <?php else:
            // it is an article (single.php or page.php) page
            ?> 
            <a href="your/section/url" class="section-name"><?php echo (isset($sub_name)) ? $sub_name : $master_name; ?></a>
            <?php endif; ?>
            <?php endif; ?>
        </div>
        <!-- <div class="header-tools"> -->
            <form id="site-search" action="#" class="search-bar" role="search">
                <button class="search-toggle"><span class="glyphicon glyphicon-search"><span class="sr-only">Search</span></span></button>
                <div class="input-group">
                    <input type="text" name="s" class="form-control">
                    <span class="input-group-btn">
                        <button class="btn primary" type="button"><span class="glyphicon glyphicon-search"><span class="sr-only">Search</span></span></button>
                    </span>
                </div><!-- /input-group -->
            </form> <!-- #site-search -->
        <!-- </div> --> <!-- .header-tools -->
        <!-- <ul class="top-bar-toggle list-inline">
            <li><a href="">Weather</a></li>
            <li><a href="">Traffic</a></li>
            <li><a href="">Markets</a></li>
        </ul> -->
    </div> <!-- .container -->
</div> <!-- .flag -->