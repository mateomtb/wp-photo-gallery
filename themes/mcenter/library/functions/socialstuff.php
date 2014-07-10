<ul class="sociallinks">


<?php if($_SESSION['siteconfig']['addthis'] != "N/A") { ?>
<!-- AddThis Button BEGIN -->
<div class="addthis_toolbox addthis_default_style ">
<a class="addthis_button_facebook_like" fb:like:layout="button_count"></a>
<a class="addthis_button_tweet"></a>
<a class="addthis_button_pinterest_pinit"></a>
<a class="addthis_counter addthis_pill_style"></a>
</div>
<script type="text/javascript">var addthis_config = {"data_track_addressbar":false};</script>
<script type="text/javascript" src="//s7.addthis.com/js/300/addthis_widget.js#pubid=<?php echo $_SESSION['siteconfig']['addthis']; ?>"></script>
<!-- AddThis Button END -->
<?php } 


else{
?>



<li>
<a href="http://twitter.com/share?url=<?php the_permalink(); ?>"
class="twitter-share-button">Tweet</a><script type="text/javascript"
src="http://platform.twitter.com/widgets.js"></script>
</li>
<li style="margin:-3px 0px 0px 0px;">
<iframe src="http://www.facebook.com/plugins/like.php?href=<?php the_permalink() ?>&amp;layout=standard&amp;show_faces=true&amp;width=450&amp;action=recommend&amp;colorscheme=light&amp;height=80" scrolling="no" frameborder="0" style="border:none; overflow:hidden; width:300px; height:80px;" allowTransparency="true"></iframe>
</li>

<?php } ?>

</ul>
