<div data-role="page" id="section_list" data-theme="a" style="-webkit-backface-visibility: hidden;">
	
	<div data-role="header">
		<h1>Sections</h1>
		<div id="close_sections_btn" class="ui-block-b" style="position:absolute;left:10px;top:9px;width:24px;"><a href="#home_page"><img src="<?php echo THEME . '/css/images/delete_w.png' ?>"/></a></div>
	</div><!-- /header -->

	<div data-role="content" data-theme="a">	
		<ul data-role="listview" data-inset="true" style="display: inline;">
			<?php wp_list_cats('sort_column=name&optioncount=0&hierarchical=0'); ?>
		</ul>

	</div><!-- /content -->
</div><!-- /page section_list -->
