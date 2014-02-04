<script type="text/javascript">
	// test for Adblade
	// if this is not a touch device, adblade will laod
	if (!Modernizr.touch) {
	  adblade_cid="3239-1115365505";
	  adblade_ad_width="600";
	  adblade_ad_height="250";
	  adblade_ad_host="web.adblade.com";
	  (function(){var a=window,b=("https:"==document.location.protocol?"https":"http")+"://"+(a.adblade_ad_host?a.adblade_ad_host:"web.adblade.com")+"/",b=b+"impsc.php?",c=a.adblade_ad_width,d=a.adblade_ad_height,e=escape(a.top.location==a.location?document.location:document.referrer),b=b+("cid="+a.adblade_cid),b=b+("&url="+e.substring(0,512)),b=b+(a.adblade_rtbid?"&rtbid="+a.adblade_rtbid:""),b=b+(a.adblade_subid?"&subid="+a.adblade_subid:""),b=b+("&rnd="+(new Date).getTime()),b=b+("&output="+(a.adblade_output? a.adblade_output:"html")),b=b+(a.adblade_tp_url?"&tpUrl="+a.adblade_tp_url:"");"adblade_tag_type"in a||(a.adblade_tag_type=1);1==a.adblade_tag_type?document.write('<iframe name="adblade_ad_iframe" width="'+c+'" height="'+d+'" frameborder="0" src="'+b+'" marginwidth="0" marginheight="0" vspace="0" hspace="0" allowtransparency="true" scrolling="no"></iframe>'):3==a.adblade_tag_type&&(document.write('<script src="'+b+'" />\x3c/script>'),a.adblade_tag_type=1)})();
	}
</script>