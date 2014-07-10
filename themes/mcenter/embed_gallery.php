<?php
header('Content-Type: application/javascript');
$the_path = get_template_directory();
$title = preg_replace('/[^a-zA-Z]/', '', $post->post_title);
$obj_name = $_REQUEST['obj_name'] ? preg_replace('/[^a-zA-Z_]/', '', $_REQUEST['obj_name']) : 'mc_embed_gallery';
// Caching Code
if (file_exists($the_path . '/embed_feeds_cache/embed_json_' . $_SERVER['HTTP_HOST'] . '_' . $title . '_' . $obj_name . '.txt')){
	$cached = 15 * 60; //cache this data every 15  mins
	//$cached = 0;
	if (time() - $cached > filemtime($the_path . '/embed_feeds_cache/embed_json_' . $_SERVER['HTTP_HOST'] . '_' . $title . '_' . $obj_name . '.txt')){
		ob_start();
		outputEmbedJson($post, $obj_name);
		$fp = fopen($the_path . '/embed_feeds_cache/embed_json_' . $_SERVER['HTTP_HOST'] . '_' . $title . '_' . $obj_name . '.txt', 'w');
		fwrite($fp, ob_get_contents());
		fclose($fp);
	}
	else {
		include $the_path . '/embed_feeds_cache/embed_json_' . $_SERVER['HTTP_HOST'] . '_' . $title . '_' . $obj_name . '.txt';
	}
}
else {
	ob_start();
	outputEmbedJson($post, $obj_name);
	$fp = fopen($the_path . '/embed_feeds_cache/embed_json_' . $_SERVER['HTTP_HOST'] . '_' . $title . '_' . $obj_name . '.txt', 'w');
	fwrite($fp, ob_get_contents());
	fclose($fp);
}
?>