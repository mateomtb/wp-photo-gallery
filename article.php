<?php 
	$page_type = 'article';
	$master_name = 'local news';
	$sub_name = "Denver &amp; The West";
?>
<?php require_once('inc/init.php'); // load in base objects ?>
<?php require_once('temps/header.php'); // load in header ?>

<div class="row">
	<div class="content-well">
			<?php include('temps/content/story1.php'); ?>
	</div> <!-- .content-well -->
	<div class="right-rail">
		<?php include('temps/right-rail.php'); ?>
	</div> <!-- .right-rail -->
</div>
<?php include('temps/content/bottom-line.php'); ?>
<?php require_once('temps/footer.php'); // load in footer ?>