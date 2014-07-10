<?php
/**
 * @package WordPress
 * @subpackage DFM-Media-Center
 * @since DFM-Media-Center 0.1
 */
?>
<?php get_header(); ?>
    
<div class="row">
    <div class="container">
        <div class="col md-9" role="content">
            <h2><?php _e('Error 404 - Page Not Found'); ?></h2>
        </div><!-- end col-md-9 -->

        <aside class="col md-3" id="right-sidebar">
            <?php get_sidebar(); ?>
        </aside><!-- end col-md-3 -->
    </div><!-- end container -->
</div>

<?php get_footer(); ?>
