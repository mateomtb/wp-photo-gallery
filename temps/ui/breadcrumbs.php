<ul class="breadcrumb block sm visible-md-up">
	<li><a href="index.php">Home</a></li>
<?php if(!isset($sub_name)): ?>
	<li class="active"><?php echo ucwords($master_name); ?></li>
<?php endif; ?>
<?php if(isset($sub_name)): ?>
	<li><a href="#"><?php echo ucwords($master_name); ?></a></li>
	<li><a href="#"><?php echo ucwords($sub_name); ?></a></li>
	<li class="active">Story</li>
<?php endif; ?>
</ul>

<?php if($page_type === 'article'): ?>
<h4 class="section-name visible-sm-down"><a href=""><?php echo $sub_name; ?></a></h4>
<?php endif; ?>
