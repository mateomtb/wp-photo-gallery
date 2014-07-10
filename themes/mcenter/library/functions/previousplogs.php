<div style="margin:10px 0 0 0;">
<?php
if ($_SESSION['siteconfig']["ad_server_on_mc"] == "apt") {
		switch ($_SESSION['parent_company']){
			case("jrc"):?>
				<div class="adElement" id="lrec_btf_slot"><script type="text/javascript" language="JavaScript">yld_mgr.place_ad_here("lrec_btf_slot");</script></div>
				<?php break;
			case("mngi"):?>
				<div class="adElement" id="adPosition9"><script type="text/javascript" language="JavaScript">yld_mgr.place_ad_here("adPos2");</script></div>
				<?php break;
        }
    } elseif ($_SESSION['siteconfig']["ad_server_on_mc"] == "dfp") {?>
    
    <!-- Beginning Sync AdSlot 1 [[300,250]]  -->
	<div id='cube1'>
	<script type='text/javascript'>
	googletag.display('cube1');
	</script>
	</div>
	<!-- End AdSlot 1 -->
    
    <?php } ?>
</div>      
<h3 class="sub preventries">Previous Entries</h3>
<?php $backup = $post; $i == 0; ?>
<?php
        $args = array(
            'posts_per_page' => 3,
            'post__not_in' => get_option( 'sticky_posts' ),
            'offset=1'
        );  
		$featured_offset_query = new WP_Query($args); ?>
	<?php while ($featured_offset_query->have_posts()) : $featured_offset_query->the_post(); $i++;
		$do_not_duplicate = $post->ID; ?>
			<div <?php if(function_exists('post_class')) : ?><?php post_class(); ?><?php else : ?>class="post post-<?php the_ID(); ?>"<?php endif; ?><?php if ($_SESSION['siteconfig']["domain"] == "denverpost"){echo 'data-vr-contentbox=""';}?>>
            <div class="previouswrapper">
			
	
<?php    
//  container that holds thumb markup and starts the process 
$thumb_markup = '';

if ( has_post_thumbnail()==true ) {
the_post_thumbnail('previous-thumbnail');
}

$thumb = get_post_meta($post->ID, 'thumbnail', true);
$smugthumb = get_post_meta($post->ID, 'smugdata', true);?>

<?php if (!empty($smugthumb)) {
$thumb_markup = getSmugThumb($smugthumb); /* this function is in the shared functions plugin */ ?>
<a href="<?php the_permalink() ?>" rel="bookmark" title="Permanent Link to <?php the_title_attribute(); ?>"><img class="archive-thumbnail"width=114 height=114 src="<?php echo $thumb_markup[0]["ThumbURL"];?>"></a>
<?php } elseif (empty($smugthumb) && !empty($thumb)) {
$thumb_markup = generate_thumb($thumb); /* this function is in the themes functions.php */ ?>
<a href="<?php the_permalink() ?>" rel="bookmark" title="Permanent Link to <?php the_title_attribute(); ?>"><img class="archive-thumbnail" src="<?php echo $thumb_markup['previous_url'];?></a>
<?php } ?>

			<h6><a href="<?php the_permalink() ?>" rel="bookmark" title="Permanent Link to <?php the_title_attribute(); ?>"><?php the_title() ?></a></h6>
			<a href="<?php the_permalink() ?>" rel="bookmark" title="Permanent Link to <?php the_title_attribute(); ?>"><p class="byline"><?php the_time('M d, Y') ?> | <?php $posttags = get_the_tags(); $mytag = getmy_tag($posttags); if ($mytag == "prep_championships") { ?></p><?php } else { ?><span class="tagcolor"><?php echo $mytag;//in functions php, returns the first tag name of a post ?></span></p><? } ?></a>
			<p><?php echo substr(get_the_excerpt(),0,115); ?></p> <!-- set lenght of text -->
            </div>
			</div>
            
			<?php if ($i < 3) { ?> <!-- number of recent posts returned-->
			<hr />
			<?php  } ?>
	<?php endwhile; ?>
	<?php $i == 0; ?>
<?php
$post = $backup;  // copy it back
wp_reset_query(); // to use the original query again
?>
