<?php 
include 'functions.php';
//include( $_SERVER['DOCUMENT_ROOT'] . '/wp-blog-header.php');
$finalmix = array(); 
$testSSD=dfmMatrix(); 
$testPC = DetermineParentCompany($testSSD); 
$siteconfig= $_SESSION['siteconfig'];
//var_dump($siteconfig);
//$domain = $_SERVER['QUERY_STRING'];

if (!isset($_SESSION['tout_token'])) {
	$postdata = http_build_query(
	    array(
			'client_id' => 'd6e060aabc12d374819073279d58bb731634dda07dedabb8b037a5300fb32a24',
			'client_secret' => 'cbc716bd04a138556db1341ee591269a00414bf1211d11f5d2b69413ddcafc15',
			'grant_type' => 'client_credentials'
	    )
	);

	$opts = array('http' =>
	    array(
	        'method'  => 'POST',
	        'header'  => 'Content-type: application/x-www-form-urlencoded',
	        'content' => $postdata
	    )
	);

	$context  = stream_context_create($opts);

	$result = json_decode(file_get_contents('https://www.tout.com/oauth/token', false, $context));
  	$_SESSION['tout_token'] = $result->access_token;
}
// get some touts
if (isset($_SESSION['siteconfig']['tout_id'])) {
	$widgetJSON = json_decode(file_get_contents('http://www.tout.com/widgets/' . $_SESSION['siteconfig']['tout_id'] . '.json'));
	$stream = $widgetJSON->widget->stream_uid;
	$results = json_decode(file_get_contents('https://api.tout.com/api/v1/streams/'.$stream.'/touts?access_token='.$_SESSION['tout_token']));		
}

//var_dump($results);
echo '<?'.'xml version="1.0" encoding="utf-8"'.'?>';
 ?>


<rss version="2.0">
      <channel>
           <title>Tout Video Feed</title>
           <link><?php echo $siteconfig['url'];?></link>
           <description><![CDATA[<?php echo $siteconfig['site_name'];?> : Tout  Video ]]></description>
           <language>en-ca</language>
           <copyright><![CDATA[<?php echo $siteconfig['site_name'];?>]]></copyright>
           <category>news</category>
            
<?php foreach($results->touts as $video) {?>
           <item>
                <title><![CDATA[<?php echo $video->tout->text ?>]]></title>
                <link><?php echo $video->tout->video->mp4->http_url; ?></link>
                <guid isPermaLink="true"><?php echo $video->tout->video->mp4->http_url; ?></guid>
                <meta id="multimediaId"><?php echo $video->tout->uid; ?></meta>                
                <enclosure url="<?php echo $video->tout->video->mp4->http_url; ?>" length="None" type="video/mp4"/>               
                <meta id="creditline"><![CDATA[<?php echo $video->tout->user->fullname; ?>]]></meta>
                <description><![CDATA[<?php echo $video->tout->text ?>]]></description>                
                <meta id="caption"><![CDATA[ ]]></meta>
                <author><![CDATA[ <?php echo $video->tout->user->fullname; ?> ]]></author>
                <pubDate><?php echo date(DATE_RFC2822, intval(strtotime ($video->tout->created_at)));  ?></pubDate>
                <lastUpdated><?php echo date(DATE_RFC2822, intval(strtotime ($video->tout->created_at))); ?></lastUpdated>
                <meta id="thumbnail">
                    <url><?php echo $video->tout->image->thumbnail->http_url; ?></url>
                    <width>240</width>                       
                    <height>180</height>
                </meta>:w

          </item>

<?php        }?>  
      </channel>
 </rss>

