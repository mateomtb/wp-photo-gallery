
<?php $homesite = get_option('T_sitenamex'); ?>
<?php $blog_title = get_bloginfo('name'); ?>

<div id="c-footer-wrap">
	<div id="c-footer" style="position:relative;width:100%;height:550px;">
		<div class="c-footer-top"></div>	
		<div class="c-footer-bottom box-shadow">
			<div class="c-footer-ad">
			<?php //load bottom banner ad.
		switch ($_SESSION['parent_company']){
			case("jrc"):?>
				<script type="text/javascript" language="JavaScript">yld_mgr.place_ad_here("bottom_slot");</script>
			<?php break;
			case("mngi"):?>
				<script type="text/javascript" language="JavaScript">yld_mgr.place_ad_here("adPos14");</script>
				<?php break;
	}
?>
			</div>
		<div class="c-footer-content">
			<div class="c-wrap-content">
			<h3 class="sub"><?php echo $blog_title; ?></h3>
<?php
	//Footer Links in logo bar - Jason Armour 3.19.2012
	$footer_links = get_option('T_footer_links');
	if($footer_links) { include (THEMELIB . '/apps/footer_links.php'); }
?>
<p class="quiet">
		<a href="<?php echo get_settings('home'); ?>/feed/" class="feed">Subscribe to entries</a><br/>
		<!-- <a href="<?php echo get_settings('home'); ?>" class="feed">Subscribe to comments</a><br /> -->
		All content &copy; <?php echo date("Y"); ?> <?php echo $homesite; ?>
		<!-- <?php echo get_num_queries(); ?> queries. <?php timer_stop(1); ?> seconds. -->
</p>
			</div>

		</div>
		
		</div>
	</div>
</div>

<!-- Subtheme-specific footer content goes here -->
</body>
</html>

