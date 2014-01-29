<?php
/**
 * Plugin Name: DFM Article Comments
 * Plugin URI: https://github.com/dfmedia/bt-wp
 * Description: Configure article comments for a DFM site.
 * Version: 0.1
 * Author: Digital First Media
 * Author URI: http://
 * License: 
 */


class options_page {
    function __construct() 
    {
        $this->slug = 'update-json';
        add_action( 'admin_menu', array( $this, 'admin_menu' ) );
    }
    
    function admin_menu () 
    {
        add_options_page( 'Page Title','Manage Commenting','manage_options',$this->slug, array( $this, 'settings_page' ) );
    }
