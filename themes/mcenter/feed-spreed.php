<?php
/**
 * RSS2 Feed Template for displaying RSS2 Posts feed.
 *
 * @package WordPress
 */
?>
<?php echo '<'.'?xml version="1.0" encoding="utf-8"?'.'>'."\n"; ?>
<SpreedContentFeed version="1.0">
<Channel>
<?php 
//$device_id = ($_GET["deviceid"]);
$numberofposts = ($_GET["numberofposts"]);
//gets the category name used in the category page query which is used to get multiple galleries from one category
$feedcat = get_query_var('cat');
//need the global query to get the post id, this is used in the query if it's a single post i.e. one gallery
global $wp_query;
$page_id = $wp_query->get_queried_object_id();

if (is_single()){
    // set query up for a single gallery i.e. a "post"    
    $featured_offset_query = new WP_Query( 'p=' . $page_id );
}
if (is_category()){
    // set query up to get multiple galleries i.e. "posts" from the specified category name
    $featured_offset_query = new WP_Query("cat=" . $feedcat . "&posts_per_page=" . $numberofposts);
}
$backup = $post; $i == 0;

while ($featured_offset_query->have_posts()) : $featured_offset_query->the_post(); $i++;

$smugdata = get_post_meta($post->ID, 'smugdata', true );
$sspdata= get_post_meta($post->ID, 'thumbnail', true );
//echo "smug " . $smugdata;
//echo "ssp" . $sspdata;
if ($smugdata) {
			//get custom field 'smugdata' from the current post
			
			//var_dump($smugdata);
			
                //parse smugthumb which is coming from the custom field in the post so we can get the AlbumID and AlbumKey
                $pq = parse_url($smugdata, PHP_URL_QUERY);
                $qatts = array();
                parse_str($pq, $qatts);
            
 			$smugvalues = getSmugApi($smugdata);//returns smug values for these images based on what instance they are in.
            //var_dump($smugvalues);
            $cachevarx = get_template_directory() . '/spreed_feeds_cache';
			$tokenarray = unserialize($smugvalues[0]['smug_token']);//setup the token value so we can use it as an array
		//	require_once('phpSmug.php');
			$f = new phpSmug("APIKey={$smugvalues[0]['smug_api_key']}", "AppName=DFM Photo Gallery 1.0", "OAuthSecret={$smugvalues[0]['smug_secret']}", "APIVer=1.3.0");
            //$f->enableCache("type=fs", "cache_dir={$cachevarx}", "cache_expire=1800" );
			$f->setToken( "id={$tokenarray['Token']['id']}", "Secret={$tokenarray['Token']['Secret']}" );
            //var_dump($f);
			$images = $f->images_get("AlbumID={$qatts["AlbumID"]}", "AlbumKey={$qatts["AlbumKey"]}", "Extras=X3LargeURL,id,MediumURL,Caption,FileName,ThumbURL,TinyURL,LastUpdated");
			$images = ( $f->APIVer == "1.3.0" ) ? $images['Images'] : $images;
			//var_dump($images);
			?>
<Gallery> 
            <Title><![CDATA[ <?php the_title_rss(); ?> ]]></Title> 
            <URL><![CDATA[ <?php permalink_single_rss(); ?>  ]]></URL> 
            <Description><![CDATA[ <?php the_excerpt_rss(); ?> ]]></Description> 
            <?php if (is_single()){ ?>
                <PublishDate><?php echo date("m/d/Y g:i:s A -0700", intval(strtotime ($images[0]["LastUpdated"]))); ?></PublishDate>
            <?php } ?>
            <?php if (is_category()){ ?>
            	<PublishDate><?php echo mysql2date('m/d/Y g:i:s A -0700', get_post_time('Y-m-d H:i:s', true), false); ?></PublishDate>
            <?php } ?>
            <LastUpdated><?php echo date("m/d/Y g:i:s A -0700", intval(strtotime ($images[0]["LastUpdated"]))); ?></LastUpdated> 
            <Author><![CDATA[ <?php the_author(); ?> ]]></Author> 
  			<ID><?php echo $qatts["AlbumID"] . "x";  ?></ID>
  			
  			<GalleryThumbnailImage device="original-image">
         		<Thumbnail size="extrasmall">
           		<URL><?php echo $images[0]["TinyURL"]; ?></URL>
           		<Width>64</Width>
           		<Height>56</Height>
         		</Thumbnail>
       		</GalleryThumbnailImage>
            
    <?php 
    $max_images = 29; //How many images should we return
	$count = 0; //Zero out the counter
    foreach ($images as $image): ?>                
        
		<ImageContainer>    
   			<Title><![CDATA[ <?php echo $image["FileName"]; ?> ]]></Title> 
                        <Copyright><![CDATA[ <?php echo ($_SESSION['siteconfig']['site_name']); ?> ]]></Copyright> 
                        <Caption><![CDATA[ <?php echo $image["Caption"]; ?> ]]></Caption> 
                        <Credit><![CDATA[ <?php echo ($_SESSION['siteconfig']['site_name']); ?> ]]></Credit>

                            <Image device="original-image"> 
                            <ID><?php echo $image["id"]; ?></ID> 
                            <URL><?php echo $image["X3LargeURL"]; ?></URL> 
                            <Width>1280</Width> 
                            <Height>960</Height>
                            </Image>

		</ImageContainer> 
	<?php 
	$count++; //increase the count
    if($count==$max_images) { 
    	break; //Break the loop after max_images value
	}
	endforeach;
	 ?>

</Gallery>

 <?php } 

if ($sspdata) { 

$sspdata= get_post_meta($post->ID, 'thumbnail', true );
$sspexploded = explode (',', $sspdata);
$album_id= $sspexploded[0];
$api= $sspexploded[1];
$director = setSSPcodes( $api );
//echo $album_id;
//echo "SSP!";
		
		# What sizes do we want?
	
	$director->format->add(array('name' => 'iphone_gal_extrasmall', 'width' => '166', 'height' => '93', 'crop' => 1, 'quality' => 85, 'sharpening' => 1));
	//$director->format->add(array('name' => 'iphone_thumb_extrasmall', 'width' => '64', 'height' => '56', 'crop' => 1, 'quality' => 85, 'sharpening' => 1));
	//$director->format->add(array('name' => 'iphone_main', 'width' => '480', 'height' => '320', 'crop' => 0, 'quality' => 85, 'sharpening' => 1));
	//$director->format->add(array('name' => 'ipad_large', 'width' => '352', 'height' => '198', 'crop' => 1, 'quality' => 85, 'sharpening' => 1));
	//$director->format->add(array('name' => 'ipad_small', 'width' => '166', 'height' => '93', 'crop' => 1, 'quality' => 85, 'sharpening' => 1));
	//$director->format->add(array('name' => 'ipad_main', 'width' => '1024', 'height' => '576', 'crop' => 0, 'quality' => 85, 'sharpening' => 1));
	$director->format->add(array('name' => 'spreed_og', 'width' => '1024', 'height' => '576', 'crop' => 0, 'quality' => 85, 'sharpening' => 1));

	$director->format->preview(array('width' => '598', 'height' => '200', 'crop' => 1, 'quality' => 85, 'sharpening' => 1));



	# Make API call using get_album method. Replace "1" with the numerical ID for your album
	$album = $director->album->get($album_id);

	# Set images variable for easy access

	$contents = $album->contents;
	$total_images = count($contents);
	//var_dump($contents);
	
	 ?>    
    
    <Gallery> 
			<Title><![CDATA[ <?php the_title_rss(); ?> ]]></Title> 
            <URL><![CDATA[ <?php permalink_single_rss(); ?>  ]]></URL>
            <Description><![CDATA[ <?php the_excerpt_rss(); ?> ]]></Description>
            <?php if (is_single()){ ?>
            	<PublishDate><?php echo date("m/d/Y g:i:s A -0700", intval($album->modified)); ?></PublishDate>
            <?php } ?>
            <?php if (is_category()){ ?>
            	<PublishDate><?php echo mysql2date('D, d M Y H:i:s -0700', get_post_time('Y-m-d H:i:s', true), false); ?></PublishDate>
            <?php } ?>
            <LastUpdated><?php echo date("m/d/Y g:i:s A -0700", intval($album->modified)); ?></LastUpdated> 
            <Author><![CDATA[ <?php the_author(); ?> ]]></Author> 
            
  
		
				<ID><?php echo $album->id . +33 ?></ID>
				<GalleryThumbnailImage device="original-image"> 
				<Thumbnail size="extrasmall"> 
				<URL><?php echo $contents[0]->iphone_gal_extrasmall->url . '&amp;.jpg';?></URL>
				<Width><?php echo round($contents[0]->iphone_gal_extrasmall->width); ?></Width> 
				<Height><?php echo round($contents[0]->iphone_gal_extrasmall->height); ?></Height> 
				</Thumbnail> 
				</GalleryThumbnailImage>
			

            
    <?php 
    $max_images = 29; //How many images should we return
	$count = 0; //Zero out the counter
    foreach ($contents as $sspimage): ?>                
        
		<ImageContainer>    
   			<Title><![CDATA[ <?php echo htmlspecialchars($sspimage->src); ?> ]]></Title> 
                        <Copyright><![CDATA[ <?php echo ($_SESSION['siteconfig']['site_name']); ?> ]]></Copyright> 
                        <Caption><![CDATA[ <?php echo $sspimage->caption; ?>]]></Caption> 
                        <Credit><![CDATA[ <?php echo ($_SESSION['siteconfig']['site_name']); ?> ]]></Credit>

                            <Image device="original-image"> 
                            <ID><?php echo $sspimage->id . +2 ?></ID> 
                            <URL><?php echo $sspimage->spreed_og->url . '&amp;.jpg'; ?></URL> 
                            <Width><?php echo round($sspimage->spreed_og->width); ?></Width> 
                            <Height><?php echo round($sspimage->spreed_og->height); ?></Height>
                            </Image> 

		</ImageContainer> 
<?php 
	$count++; //increase the count
    if($count==$max_images) { 
    	break; //Break the loop after max_images value
	}
endforeach; ?>

</Gallery>

<?php } ?>

<?php
$smugdata = "";
$sspdata= "";

endwhile;
$i == 0;
$post = $backup;  // copy it back
wp_reset_query(); // to use the original query again
?>
</Channel>
</SpreedContentFeed>
