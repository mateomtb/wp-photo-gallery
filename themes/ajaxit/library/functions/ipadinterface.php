<div id="backnavwindow" style="position:absolute;left:0px;top:0px;overflow:hidden;width:250px;height:100%;background-color:black;z-index:0;visibility:hidden;">
	<div id="nav_wrapper">
		<div id="nav_scroller">
			<ul id="nav_thelist">
				<div class="nav_header_text" style="">CATEGORIES</div>
				<?php
					$args=array( 'orderby' => 'name', 'order' => 'ASC' );
					$categories=get_categories($args);
					foreach($categories as $category) { ?>
						<a href="<?php echo get_category_link( $category->term_id ); ?>" onclick="event.returnValue=false;if ( !justClicked ) { hideBackNav();loadIndexData(this.href); }" >
							<li class="cat_listing" style="height:40px;" >
								<div class="list_image_title" style="margin-top:12px;font-size:14px;line-height:130%;"><?php echo $category->name ?> (<?php echo $category->count ?>)</div>
							</li>
						</a>
					<?php
					}
				?>
				<div class="nav_header_text" style="">OPTIONS</div>
				<a href="" onclick="event.returnValue=false;setDesktopVersionON();" >
					<li class="cat_listing" style="height:40px;" >
						<div class="list_image_title" style="margin-top:12px;font-size:14px;">SHOW DESKTOP VERSION</div>
					</li>
				</a>
			</ul>
		</div>
	</div>
</div><!-- /backnavwindow -->

<div id="content" style="opacity:1.0;color:white;position:relative;">
	<div id="toolbar_top" class="toolbar_top" >
		<div id="toolbar_sections_button" class="toolbar_sections_button" ontouchstart="toggle_section_nav_window()">
			<img id="toolbar_sections_image" class="toolbar_sections_image" src="<?php echo THEME ?>/css/images/iphone_sections_btn.png" />
		</div>
		<div id="toolbar_propertyname_text" class="toolbar_propertyname_text" ontouchend="clickNavBarLink(0);" ><?php echo get_bloginfo('name'); ?></div>
		<div id="toolbar_category_text" class="toolbar_category_text"></div>
	</div>
	
	<div id="mainframe_window_full" class="mainframe_window_full">
		<div id="wrapper">
			<div id="scroller">
				<ul id="thelist"></ul>
			</div>
		</div>
	</div><!-- /mainframe_window_full -->
	
	<div id="red_nav" style=""></div>
	<div id="index_ad" style=""></div>
	
	<div id="loading_container" class="loading_container">
		<div id="loading_window" class="loading_window">
			<div class="loading_text" >Loading</div>
			<div class="animation_block" >
				<div id="block_1" class="barlittle"></div>
				<div id="block_2" class="barlittle"></div>
				<div id="block_3" class="barlittle"></div>
				<div id="block_4" class="barlittle"></div>
				<div id="block_5" class="barlittle"></div>
			</div>
		</div>
	</div>
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	<div id="article_window_full" class="article_window_full">
		
		<div id="gallery_toplayer_container" class="gallery_toplayer_container" >
			
			<div id="gallery_toolbar_id" class="gallery_toolbar" >
				<div id="gallery_toolbar_xTitle" 	></div>
				<div id="gallery_toolbar_xCounter"	></div>
				<div class="iframeBackButton" ontouchstart="xGallery.closeGallery();"></div>
				<div id="gallery_toolbar_xBackButton" >BACK</div>
				<img id="gallery_toolbar_share_image" src="<?php echo THEME . '/css/' ?>images/toolbar_share_w_shdw.png" alt="22" ontouchend="toggleShare();" />
			</div>
		
			<div id="share_container" style="z-index:21;position:absolute;right:0px;top:-200px;width:150px;background-color:white;-webkit-transition:top 200ms;padding:25px;">
				<button id="twitter_button" style="width:150px;" ontouchend="clickShare(this);">Twitter</button>
				<button id="facebook_button" style="width:150px;" ontouchend="clickShare(this);">Facebook</button>
			</div>
			
			<div id="gallery_caption_container" class="gallery_caption_container">
				<div id="gallery_caption_text" class="gallery_caption_text"></div>
			</div>
			
		</div><!-- /gallery_toplayer_container -->

		<div id="gallery_content" style="opacity:1.0;-webkit-transition:opacity 1.25s;">
			<div id="gallery_wrapper">
				<div id="gallery_scroller" style="">
					<ul id="gallery_thelist" style="opacity:0.0;">
						<li style="background-color:none;" ontouchstart="xActiveTouch = 1;" ontouchmove="xActiveTouch = 0;" ontouchend="if (xActiveTouch) { toggleTopLayer(); }">
							
						</li>
					</ul>
				</div>
			</div>
		</div> <!-- gallery content -->
		
		<div id="article_content" style="float:left;opacity:1.0;position:absolute;left:0px;top:0px;right:0px;bottom:0px;background-color:#ddd;">
			<div id="article_wrapper" style="overflow:auto;position:absolute;top:40px;left:0px;right:0px;bottom:0px;">
				<div id="article_scroller" style="position:absolute; width:100%;padding:0;">
					<ul id="article_thelist" style="list-style:none;padding:0;margin:0;width:100%;text-align:left;">
						
							
					</ul>
				</div>
			</div>
		</div> <!-- article_content -->
		
		<div id="loading_container_gallery" class="loading_container"></div>
		
	</div><!-- /article_window_full -->
	
</div><!-- /content -->