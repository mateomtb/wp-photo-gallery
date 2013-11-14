<?php
/**
 *  @package    dfm-base
 *  @author     Jonathan Boho
 *  @copyright  (c) 2012
 *  @version    1.0
 *  @license    xxx
 */

// DIRECTORY_SEPARATOR is a PHP pre-defined constant
// (\ for Windows, / for Unix)
defined('DS') ? null : define('DS', DIRECTORY_SEPARATOR);
ini_set('session.use_trans_sid', '0'); // stops session ID from appearing in links
//error_reporting(0); // supresses errors

// load core files
require_once 'config.php';
require_once 'functions.php';
require_once 'check.php';
require_once 'modernizr-server.php';