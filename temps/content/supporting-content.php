<section class="supporting-content" role="complementary">
	<div class="supporting-media single-img">
		<figure id="photo-id-goes-here">
			<img src="<?php echo ASSETS_IMG; ?>/gosling.jpg" alt="">
			<figcaption>This is a picture of Ryan Gosling. He is in no way related to this story. Instead, he is simply a placeholder for this photo position. <span class="photographer">File photo</span></figcaption>
		</figure>
	</div>
	<ul class="share-tools sm">
		<li><span class="glyphicon glyphicon-comment"></span> <a href="">Comment</a></li>
		<li><span class="glyphicon glyphicon-envelope"></span> <a href="">E-mail</a></li>
		<li><span class="glyphicon glyphicon-print"></span> <a href="">Print</a></li>
		<li><span class="glyphicon glyphicon-bookmark"></span> <a href="">Bookmark</a></li>
		<li><span class="glyphicon glyphicon-star"></span> <a href="">Recommend</a></li>
	</ul> <!-- .share-tools -->
	<div id="more-media" class="link-list no-anim">
		<h4>More media</h4>
		<ul>
			<li><a href=""><strong>Video:</strong> Watch a couple talk about narrowly escaping the wildfire.</a></li>
			<li><a href=""><strong>Gallery:</strong> View more Denver Post images of the Lower North Fork Fire.</a></li>
			<li><a href=""><strong>Blog: </strong>Follow for the latest updates as we get them.</a></li>
		</ul>
	</div> <!-- #more-media -->
	<div class="supporting-media google-map">
		<h4>Map</h4>
		<p><small>Click to enlarge</small></p>
		<a href="#myModal" role="button" data-toggle="modal"><img src="<?php echo ASSETS_IMG; ?>/test_map.png" alt=""></a>
	</div>
	<div id="related-stories" class="link-list no-anim">
		<h4>Related</h4>
		<ul>
			<li><a href="">Colorado wildfire victim Ann Appel remembered as selfless, excelling in artistic endeavors</a></li>
			<li><a href="">Handling of 911 calls in metro Denver spurs look at training, policies</a></li>
			<li><a href="">Area in foothills near Denver was deemed OK for controlled burn that grew into deadly wildfire</a></li>
		</ul>
	</div> <!-- #related-stories -->
    <?php include('temps/content/poll.php'); ?>
</section>
<div id="myModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title">Static map example</h4>
      </div>
      <div class="modal-body">
        <img border="0" src="//maps.googleapis.com/maps/api/staticmap?center=Brooklyn+Bridge,New+York,NY&amp;zoom=13&amp;size=600x300&amp;maptype=roadmap&amp;markers=color:blue%7Clabel:S%7C40.702147,-74.015794&amp;markers=color:green%7Clabel:G%7C40.711614,-74.012318&amp;markers=color:red%7Clabel:C%7C40.718217,-73.998284&amp;sensor=false" alt="Points of Interest in Lower Manhattan">
      </div>
      <div class="modal-footer">
        <button type="button" class="btn default" data-dismiss="modal" aria-hidden="true">Close</button>
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->