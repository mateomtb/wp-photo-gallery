<?php
/**
 * Plugin Name: DFM Omniture
 * Plugin URI: 
 * Description: 
 * Version: 0.1
 * Author: Joe Murphy, Digital First Media
 * Author URI: http://digitalfirstmedia.com/
 * License: Apache-2
 */

/*
// TODOS:
// Usage:
*/


class DFMOmniture
{
    // We use this class to add the files Omniture requires onto any WP page.


    function __construct()
    {
        $url = array(
            'dev' => '//assets.adobedtm.com/891d1ce5446bbce2687a12c1b724985a8b1df83a/satelliteLib-3eed698e57f6ca79e34fb4a932c01f681d287698-staging.js',
            'prod' => '//assets.adobedtm.com/891d1ce5446bbce2687a12c1b724985a8b1df83a/satelliteLib-3eed698e57f6ca79e34fb4a932c01f681d287698.js'
        );
        $environment = 'dev';
        // wp_enqueue_script( $handle, $src, $deps, $ver, $in_footer );
        wp_enqueue_script('dtm', $url[$environment], false, '', false);
    }

}
$DFMOmniture = new DFMOmniture();
