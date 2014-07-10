<?php
class DFMUtils {
	public static function templating($html, $replacementArray){
		foreach($replacementArray as $k => $v) {
			$html = str_replace($k, $v, $html);
		}
		return $html;
	}
	
	public static function tagLinks(){
		$posttags = get_the_tags();
		$count = 0;
		if ($posttags) {
			foreach($posttags as $tag) {
				if ($count === 0) {
					echo '<a href="#">' . $tag->name . '</a>'; 
				}
				else {
					echo ', <a href="#">' . $tag->name . '<a/>';
				}
			}
		}
	}
}
?>