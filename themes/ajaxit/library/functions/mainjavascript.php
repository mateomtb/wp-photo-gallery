<script>
<?php die('mainjavascript.php'); ?>
var myScroll;
alert( 'error, mainjavascript called');

function iframeLoaded() {
	//------------IFRAME LAYER : Only runs if page is loaded in IFRAME
	//alert( 44 );
	//setCSSsizes();
	//changeContentWindowSize()
	processMainImageSizes();
	
	<?php
		if ($xcat=='all') { ?>
			processArchiveLinks( 'content' );
		<?php } else { ?>
			processLinks( 'content' );
		<?php
		}
	?>
	//window.parent.processLinks( 'mainframe_window_full' );
	showContent();
	
	document.getElementById('scroller').style.width = ( window.parent.innerWidth * 3 ) +"px";
	
	myScroll = new iScroll('wrapper', {
			snap: true,
			momentum: false,
			hScrollbar: false,
			onScrollEnd: function () {
				//document.querySelector('#indicator > li.active').className = '';
				//document.querySelector('#indicator > li:nth-child(' + (this.currPageX+1) + ')').className = 'active';
			}
		 });
	//myScroll.scrollToPage(0, 0);
	//window.addEventListener('orientationchange', function (e) { alert(987); }, false);
}

function iframeOrientationChange() {
	if ( window.parent.xOrientation == 'landscape' ) {
		document.getElementById('cssfile1').href = "<?php echo THEME . '/css/' ?>ipad_landscape.css";
		document.getElementById('cssfile2').href = "<?php echo THEME . '/css/' ?>ipad_landscape.css";
	} else {
		document.getElementById('cssfile1').href = "<?php echo THEME . '/css/' ?>ipad_portrait.css";
		document.getElementById('cssfile2').href = "<?php echo THEME . '/css/' ?>ipad_portrait.css";
	}
	
	document.getElementById('content').style.width = window.parent.innerWidth +"px";
	document.getElementById('content').style.height = window.parent.innerHeight+"px";
	processMainImageSizes();
	
	document.getElementById('scroller').style.width = ( window.parent.innerWidth * 3 ) +"px";
	myScroll._resize(); 
	setTimeout("myScroll.scrollToPage(myScroll.currPageX, 0);", 200);
}

function InterfaceLoaded() {
	//alert( 1 );
	//------------INTERFACE LAYER : Calls only when we build the interface loading this page
	loadUrlInMainFrame( document.URL );									//now load the content in the mainframe
}



/*
window.onorientationchange = function (){
	
}
*/

//
</script>