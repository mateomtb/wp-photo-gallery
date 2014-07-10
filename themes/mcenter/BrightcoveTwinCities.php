<?php 
echo '<'.'?xml version="1.0" encoding="utf-8"?'.'>';
$jsonCall = 'http://api.brightcove.com/services/library?command=find_all_videos&token=OUgjQsPN--7XwaWXPssptPjUqhbgM4ucs_pe4phTmtI.&sort_by=PUBLISH_DATE&media_delivery=HTTP';
$BCfeed = json_decode(file_get_contents($jsonCall));
$BCfeed = $BCfeed->items;
//var_dump($BCfeed);

$newurl = preg_split("/\?/", $items->{"FLVURL"}, -1, PREG_SPLIT_NO_EMPTY);
          

 ?>


<rss version="2.0">
      <channel>
           <title>Video</title>
           <link>http://photos.twincities.com/category/video/</link>
           <description><![CDATA[Video from the St. Paul Pioneer Press]]></description>
           <language>en-ca</language>
           <copyright><![CDATA[St. Paul Pioneer Press]]></copyright>
           <category>news</category>
            
<?php foreach($BCfeed as $video) {?>
           <item>
                <title><![CDATA[<?php echo $video->name ?>]]></title>
                <link>http://photos.twincities.com/</link>
                <guid isPermaLink="true">http://photos.twincities.com/</guid>
                <meta id="multimediaId"><?php echo $video->id ?></meta>                
                <enclosure url="<?php $videoURL = str_replace("&", "&amp;", $video->FLVURL); echo $videoURL; ?>" length="None" type="video/mp4"/>               
                <meta id="creditline"><![CDATA[ ]]></meta>
                <description><![CDATA[<?php echo $video->shortDescription ?>]]></description>                
                <meta id="caption"><![CDATA[ ]]></meta>
                <author><![CDATA[ ]]></author>
                <pubDate><?php echo date(DATE_RFC2822,(($video->publishedDate)/1000)); ?></pubDate>
                <lastUpdated><?php echo date(DATE_RFC2822,(($video->lastModifiedDate)/1000));?></lastUpdated>
                <meta id="thumbnail">
                    <url><?php echo $video->videoStillURL ?></url>
                    <width>240</width>                       
                    <height>180</height>
                </meta>
          </item>
<?php        }?>  
      </channel>
 </rss>     
           
