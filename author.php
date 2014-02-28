<?php require_once('inc/init.php'); // load in base objects ?>
<?php
    $page_type = 'section';
    $master_name = 'Staff profile';
    $sub_name = 'Staff profile';
?>
<?php require_once('temps/header.php'); // load in header ?>
<div class="row author-page">
    <div class="content-well">
        <h1 class="page-header">Stories by Author Name</h1>
			<div class="row">
				<div class="col md-3">
					<div class="media">
					  <a href="#">
					    <img class="media-object" src="http://placehold.it/320x400" alt="Picture of Author">
					  </a>
					  <div class="media-body">
					    <h4 class="media-heading">Author Name</h4>
						<p>Bio lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.</p>
						<ul>
					    	<li><a href=""><span class="glyphicon glyphicon-phone-alt"></span> Phone</a></li>
					    	<li><a href=""><span class="webicon mail xs"></span> E-mail</a></li>
					    	<li><a href=""><span class="webicon twitter xs"></span> Twitter</a></li>
					    </ul>
					  </div>
					</div>
				</div>
				<div class="col md-9">
					<?php include('temps/content/story-feed-author.php'); ?>
					<ul class="pagination">
					  <li class="active"><a href="#">&laquo;</a></li>
					  <li><a href="#">1</a></li>
					  <li><a href="#">2</a></li>
					  <li><a href="#">3</a></li>
					  <li><a href="#">4</a></li>
					  <li><a href="#">5</a></li>
					  <li><a href="#">&raquo;</a></li>
					</ul>
				</div>
			</div> <!-- .row -->
    </div> <!-- .content-well -->
    <div class="right-rail">
        <?php include('temps/right-rail.php'); ?>
    </div> <!-- .right-rail -->
</div>

<?php include('temps/content/bottom-line.php'); ?>
<?php require_once('temps/footer.php'); // load in footer ?>