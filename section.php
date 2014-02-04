<?php require_once('inc/init.php'); // load in base objects ?>
<?php
	$page_type = 'section';
	$master_name = 'business';
	$sub_name = 'business';
?>
<?php require_once('temps/header.php'); // load in header ?>
<div class="row">
	<div class="content-well">
		<div id="above-fold" class="row">
			<div class="col md-9 push-3">
				<div class="centerpiece">
					<h4 class="section-name hidden-md-up"><a href=""><?php echo $sub_name; ?></a></h4>
					<?php include('temps/content/section-centerpiece.php'); ?>
					<?php include('temps/content/secondary-stories.php'); ?>
				</div>
				<?php include('temps/content/story-feed-large.php'); ?>
			</div>
			<div class="left-rail col md-3 pull-9">
				<?php include('temps/content/story-feed-small.php'); ?>
				<?php include('temps/content/story-feed-photo.php'); ?>
			</div>
		</div> <!-- #above-fold -->
	</div> <!-- .content-well -->
	<div class="right-rail">
		<?php include('temps/right-rail.php'); ?>
	</div> <!-- .right-rail -->
</div>

<?php include('temps/content/bottom-line.php'); ?>
<?php require_once('temps/footer.php'); // load in footer ?>