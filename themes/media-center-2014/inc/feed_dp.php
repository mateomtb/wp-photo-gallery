<?php
if(isset($_REQUEST['feed'])) {
	$feed_url = "http://feeds.denverpost.com/" . $_REQUEST['feed'];
} else {
	$feed_url = 'http://feeds.denverpost.com/dp-news-breaking';
}

// RECEIVE FILE AND CLEAN
$source = file_get_contents( $feed_url );
$source = str_replace(":encoded", '', $source);
$source = str_replace(":creator", '', $source);
$source = str_replace(":content", '', $source);
$source = str_replace(":source", '', $source);

// LOAD VARS
$xml = simplexml_load_string($source, 'SimpleXMLElement', LIBXML_NOCDATA);
$section_title = $xml->channel->title;
$articles = array();

// PROCESS FEED
foreach ($xml->channel->item as $article) {
array_push($articles, 
	array( 'title' => trim($article->title), 
			'pub_date' => processTime($article->pubDate), 
			'byline' => getAuthorName($article->dc),
			'property' => getPropertyName($article->dc),
			'last_update' => processUpdateOld ($article->pubDate),
			'description' => processArticle($article->description),
			'excerpt' => processExcerpt($article->description),
			'link' => (string) $article->link, 
			'media' => (string) processMedia($article->enclosure['url'])
			)
	);
}
$json = '{ "articles" :' . json_encode($articles) . '}';

function getAuthorName($str) {
	$str = (string) $str;
	$str_arr = explode('<br>', $str);
	if(isset($str_arr[1])) {
		return strip_tags(str_replace('By ', '', $str_arr[0]));
	} else {
		$str_arr = explode('     ', $str);
		if(isset($str_arr[1])) {
			return strip_tags(ucwords(strtolower(str_replace('By ', '', $str_arr[0]))));
		}
		else {
			$str_arr = explode(',', $str);
			if(isset($str_arr[1])) {
				return strip_tags(ucwords(strtolower(str_replace('By ', '', $str_arr[0]))));
			}
			else {
				return '';
			}
		}
	}
}
function processMedia($str) {
	return ($str == '') ? '' : (string) $str;
}
function getPropertyName($str) {
	if (strpos($str,'Bloomberg')) {
		return 'Bloomberg News';
	}
	if (strpos($str,'Associated')) {
		return 'The Associated Press';
	}
	if (strpos($str,'AP')) {
		return 'The Associated Press';
	}
	$str = (string) $str;
	$str_arr = explode('<br>', $str);
	if(isset($str_arr[1])) {
		return strip_tags($str_arr[1]);
	} else {
		return 'Wire services';
	}
}
function processArticle( $str ) {
	$str = preg_replace("/<iframe[^>]+\>/i", "", $str);	
	return $str;
}
function processTime( $str ) {
	return date('m/j/y, g:ia', strtotime( $str ));
}
function processExcerpt($str) {
	$str = (string) $str;
	$str = str_replace("&mdash;",' — ',$str);
	$str_arr = explode('<', $str);
	return strip_tags($str_arr[0]);
}
function processUpdate( $str ) {
	$first = new DateTime();
	$first->setTimezone(new DateTimeZone('America/Denver'));
	$second = new DateTime(  $str );
	$second->setTimezone(new DateTimeZone('America/Denver'));
	$diff = $first->diff( $second );
	if($diff->days === 0) {
		if($diff->h === 0) {
			if($diff->i === 0) {
				$time = '1m';
			} else {
				$time = ($diff->i > 1) ? $diff->i . 'm' : '1m';
			}
		} else {
			$time = ($diff->h > 1) ? $diff->h . 'h' : '1h';
		}
	} else {
		$time = ($diff->days > 1) ? $diff->days . ' days' : '1 day';
	}
	return $time;
}
function processUpdateOld( $str ) {
	$first = strtotime("now");
	$second = strtotime($str);
	$diff = round(abs($first - $second) / 60, 0);
	if($diff > 1) {
		if($diff > 59) {
			if($diff > 1399) {
				if($diff > 2799) {
					$time = round($diff / 1400, 0) . ' days';
				}
				else {
					$time = '1 day';
				}
			}
			else {
				$time = round($diff / 60, 0) . 'h';
			}
		}
		else {
			$time = $diff . 'm';
		}
	} else {
		$time = '1m';
	}
	return $time;
}
function processSafeText ( $str ) {
	$str = str_replace("'",'&#39;',$str);
	$str = str_replace("*",'&#42;',$str);
	$str = str_replace("^",'&#94;',$str);
	$str = str_replace("@",'&#64;',$str);
	$str = str_replace("‘",'&lsquo;',$str);
	$str = str_replace("’",'&rsquo;',$str);
	$str = str_replace("'",'&#39;',$str);
	$str = str_replace('"','&quot;',$str);
	$str = str_replace('“','&quot;',$str);
	$str = str_replace('”','&quot;',$str);
	return $str;
}
// OUTPUT
echo $json;