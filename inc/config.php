<?php
/**
 *  @package    dfm-base
 *  @author     Jonathan Boho
 *  @copyright  (c) 2012
 *  @version    1.0
 *  @license    xxx
 */

// DB SETTINGS
$uri = explode('/', $_SERVER['REQUEST_URI']);
defined('DB_SERVER') ? null : define("DB_SERVER", '');
defined('DB_USER')   ? null : define("DB_USER", '');
defined('DB_PASS')   ? null : define("DB_PASS", '');
defined('DB_NAME')   ? null : define("DB_NAME", '');


// SERVER & URL SETTINGS
// make this bulletproof
defined('BASE_URL')  ? null : define("BASE_URL", (!empty($_SERVER['HTTPS'])) ? "https://" . DS . $_SERVER['SERVER_NAME'].$uri[1] : "http://".$_SERVER['SERVER_NAME'] . DS . $uri[1]);

defined('LOCAL_IP')  ? null : define("LOCAL_IP", $_SERVER['SERVER_ADDR']);
defined('THE_TITLE')  ? null : define("THE_TITLE", '');


// DIRECTORIES
defined('CACHE_DIR') ? null : define('CACHE_DIR', 'cache');
defined('IMG_DIR') ? null : define('IMG_DIR',   BASE_URL . DS . 'img');
defined('JS_DIR') ? null : define('JS_DIR',  BASE_URL . DS . 'js');
defined('XML_DIR') ? null : define('XML_DIR',  BASE_URL . DS . 'xml');
defined('ASSETS_DIR') ? null : define('ASSETS_DIR', BASE_URL . DS . 'assets');
defined('ASSETS_IMG') ? null : define('ASSETS_IMG', ASSETS_DIR . DS . 'images');
defined('ASSETS_DOC') ? null : define('ASSETS_DOC', ASSETS_DIR . DS . 'docs');
defined('ADMIN_HOME') ? null : define('ADMIN_HOME', BASE_URL . DS . 'admin');

// CACHING
defined('CACHE_EXT') ? null : define('CACHE_EXT', '.html');
defined('CACHE_TIME') ? null : define('CACHE_TIME', 120);

$cachefile = explode('.', basename($_SERVER['PHP_SELF']));
$cachefile = array_shift($cachefile);
$cachefile = ($_SERVER['QUERY_STRING'] !== '') ? $cachefile .= base64_encode($_SERVER['QUERY_STRING']) : $cachefile;
$cachefile = CACHE_DIR . DS . $cachefile . CACHE_EXT;


// COOKIES
defined('COOKIE_NAME') ? null : define('COOKIE_NAME', 'dfmv3');


// CONSTANTS
defined('MAX_FILE_SIZE') ? null : define("MAX_FILE_SIZE", 1048576);	// expressed in bytes
                                                                    //     10240 =  10 KB
                                                                    //    102400 = 100 KB
                                                                    //   1048576 =   1 MB
                                                                    //  10485760 =  10 MB
defined('MAX_DIMENSION') ? null : define("MAX_DIMENSION", 640);
defined('MAX_HEIGHT') ? null : define("MAX_HEIGHT", 480);
defined('MAX_WIDTH') ? null : define("MAX_WIDTH", 640);
defined('MIN_IMAGE_SIZE') ? null : define("MIN_SIZE", 400);
defined('THUMBNAIL_SIZE') ? null : define("THUMBNAIL_SIZE", 100);


// COMMON VARS TO MAKE LIFE A LITTLE EASIER

// current page url
$this_url = (!empty($_SERVER['HTTPS'])) ? 'https://'.$_SERVER['SERVER_NAME'].$_SERVER['REQUEST_URI'] : 'http://'.$_SERVER['SERVER_NAME'].$_SERVER['REQUEST_URI'];

$current_title = ''; // append this to title on given page


// DEVICE DETECTION
defined('USER_AGENT') ? null : define("USER_AGENT", $_SERVER['HTTP_USER_AGENT']);

$iPod    = (stripos(USER_AGENT,"ipod")) ? true : false;
$iPhone  = (stripos(USER_AGENT,"iphone")) ? true : false;
$iPad    = (stripos(USER_AGENT,"ipad")) ? true : false;
$Android = (stripos(USER_AGENT,"android")) ? true : false;
$webOS   = (stripos(USER_AGENT,"webos")) ? true : false;
$mobile  = (!stripos(USER_AGENT,"mobile") || $iPad) ? false : true;