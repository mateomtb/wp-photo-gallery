<?php require_once('inc/init.php'); // load in base objects ?>
<?php 
	$page_type = 'home';
	$master_name = 'home'; 
?>
<?php require_once('temps/header.php'); // load in header ?>
<div class="row">
	<div class="content-well">
		<div id="above-fold" class="row">
			<div class="centerpiece col md-9 md-push-3">
				<?php include('temps/content/home-centerpiece.php'); ?>
				<?php include('temps/content/secondary-stories.php'); ?>
			</div>
			<div class="left-rail col md-3 md-pull-9">
				<?php include('temps/content/story-feed-small.php'); ?>
			</div>
		</div> <!-- #above-fold -->
		<div id="middle-row">
			<div class="col md-3">
				<?php include('temps/content/poll.php'); ?>
			</div>
			<div class="col md-9">
				<?php include('temps/content/media-center-widget.php'); ?>
			</div>
		</div> <!-- #middle-row -->
		<div id="bottom-row">
		<div class="col md-12">
				<?php include('temps/content/slider-promo.php'); ?>
		</div>
			<div class="col md-6">
			<?php 
				if ($mostpop == 'true'):
					include('temps/ui/popular-widget.php');
				else:
					include('temps/content/section-promo.php');
				endif;
			?>
			<?php include('temps/content/section-promo.php');?>
			</div>
			<div class="col md-6">
			<?php include('temps/content/section-promo.php');?>
			<?php include('temps/content/section-promo.php');?>
			</div>
		</div><!-- #bottom-row -->
	</div> <!-- .content-well -->
	<div class="right-rail">
		<?php include('temps/right-rail.php'); ?>
	</div> <!-- .right-rail -->
</div>

<?php include('temps/content/bottom-line.php'); ?>
<?php require_once('temps/footer.php'); // load in footer ?>