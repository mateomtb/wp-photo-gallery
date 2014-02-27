<?php require_once('inc/init.php'); // load in base objects ?>
<?php
    $page_type = 'topic';
    $master_name = 'sports';
    $sub_name = 'peyton manning';
?>
<?php require_once('temps/header.php'); // load in header ?>
<div class="row">
    <div class="content-well">
        <div class="centerpiece row">
            <div class="col md-12">
                <?php include('temps/content/topic-centerpiece.php'); ?>
            </div>
        </div> <!-- .centerpiece -->
        <div class="down-page row">
            <div class="col md-9 md-push-3">
                <?php include('temps/content/story-feed-topic-large.php'); ?>
            </div>  <!-- .col md-9 -->
            <div class="left-rail col md-3 md-pull-9">
                <?php include('temps/content/story-feed-topic.php'); ?>
            </div> <!-- .left-rail -->
        </div> <!-- .down-page -->
    </div> <!-- .content-well -->
    <div class="right-rail">
        <?php include('temps/right-rail.php'); ?>
    </div> <!-- .right-rail -->
</div>

<?php include('temps/content/bottom-line.php'); ?>
<?php require_once('temps/footer.php'); // load in footer ?>