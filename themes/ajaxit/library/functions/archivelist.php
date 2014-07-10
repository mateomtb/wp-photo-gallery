<?php die('archivelist.php'); ?>
	<div id="content" style="opacity:0.0;-webkit-transition:opacity 1.25s;">
		<div id="main_window" style="">
			<div id="wrapper">
				<div id="scroller">
					<ul id="thelist">

						<li style="background-color:#333333;">
							<div style="border:1px solid none;-moz-column-count: 5;-moz-column-gap: 20px;-webkit-column-count: 4;-webkit-column-gap: 20px;column-count: 3;column-gap: 20px;font-family:Arial;font-weight:normal;font-size:15px;color:#a9a9a9;margin:30px;text-align:left;text-shadow: 2px 2px 1px rgba(0,0,0,0.8);" >
								<?php
									$args=array( 'orderby' => 'name', 'order' => 'ASC' );
									$categories=get_categories($args);
									foreach($categories as $category) { ?>
										<div style="margin-bottom:14px;text-indent: -1em;padding-left: 1em;line-height:110%;" >
											<a href="<?php echo get_category_link( $category->term_id ); ?>" >
												<img style="width:12px;" src="<?php echo THEME . '/css/images/' ?>dubarrows.png" />
												<?php echo $category->name ?> (<?php echo $category->count ?>)
											</a>
										</div>
									<?php
									}
								?>
								
								
								
								
								
								
								
								
							</div>
				        </li>            
						<li style="">
							<?php $xquery = 'cat='.$category_id.'&showposts=12&offset=12&tag=Photo'; include (THEMELIB . '/functions/querylist.php'); ?>
				        </li>
						<li style="background-color:#405055;">
								<a href="http://maps.google.com">The link to GOOGLE maps</a><BR>
				        </li>      
					</ul>
				</div>
			</div>

		</div><!-- /main_window -->

		<div id="red_nav" style=""></div>

		<div id="index_ad" style=""></div>

	</div><!-- /content -->
