<script type="text/javascript">
window.setInterval(function() {
  jQuery('img').on('contextmenu', function(e){
      return false;
  })},
1000);
</script>
<div class="clear"></div>
<?php $homesite = get_option('T_sitenamex'); ?>
<?php $blog_title = get_bloginfo('name'); ?>
</div>
</div>

<div id="footer-wrap">
<div id="footer">

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
<div class="clear"></div>
</div>
</div>

<?php wp_footer();
if ($_SESSION['siteconfig']['domain'] === 'denverpost'){
?>
 <script type="text/javascript">
//Chartbeat stuff
var _sf_async_config={};
_sf_async_config.uid = 2671;
_sf_async_config.domain = 'denverpost.com';
var cb_the_section = 'MediaCenter';
_sf_async_config.sections = cb_the_section; // set section to media center so it shows up in denverpost account as mediacetner
(function(){
function loadChartbeat() {
window._sf_endpt=(new Date()).getTime();
var e = document.createElement('script');
e.setAttribute('language', 'javascript');
e.setAttribute('type', 'text/javascript');
e.setAttribute('src',(('https:' == document.location.protocol) ? 'https://a248.e.akamai.net/chartbeat.download.akamai.com/102508/' : 'http://static.chartbeat.com/') + 'js/chartbeat.js');
document.body.appendChild(e);
}
var oldonload = window.onload;
window.onload = (typeof window.onload != 'function') ? loadChartbeat : function() { oldonload(); loadChartbeat(); };
})();
<?php }?>
</script>
</body>
</html>
