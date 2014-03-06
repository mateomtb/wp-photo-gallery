<?php
/**
 * Plugin Name: DFM In-Article Teasers
 * Plugin URI: 
 * Description: Takes a WP link object and appends it in-article as a teaser to the destination. Requires Easy Custom Fields.
 * Version: 0.1
 * Author: Joe Murphy, Digital First Media
 * Author URI: http://digitalfirstmedia.com/
 * License: Apache-2
 */

// TODOS:
/*
// Usage:
*/

if ( !file_exists(WP_PLUGIN_DIR . '/easy-custom-fields/easy-custom-fields.php') ) die("Requires Easy Custom Fields plugin ( http://wordpress.org/plugins/easy-custom-fields/ )");

require_once( WP_PLUGIN_DIR . '/easy-custom-fields/easy-custom-fields.php' );

$slug = 'teaser';
$field_data = array (
        'Teaser' => array (
                'fields' => array (
                         $slug => array('label'=>'In-Article Teaser',
                                        'type'=>'linkselect',
                                        'input_class' => $slug,
                                        'class' => $slug,
                                        'id' => $slug
                                        ),
                ),
        ),
);

if ( !class_exists( "Easy_CF_Field_Link_Select" ) ) {
    class Easy_CF_Field_Linkselect extends Easy_CF_Field {
        public function print_form() {
            $class = ( empty( $this->_field_data['class'] ) ) ? $this->_field_data['id'] . '_class' :  $this->_field_data['class'];
            $input_class = ( empty( $this->_field_data['input_class'] ) ) ? $this->_field_data['id'] . '_input_class' :  $this->_field_data['input_class'];

            $id = ( empty( $this->_field_data['id'] ) ) ? $this->_field_data['id'] :  $this->_field_data['id'];
            $label = ( empty( $this->_field_data['label'] ) ) ? $this->_field_data['id'] :  $this->_field_data['label'];
            $value = $this->get();

            $items = array();
            if ( function_exists('get_bookmarks') )
                $items = get_bookmarks(array('category_name'=>'teaser'));

            $options = "\n<option value=\"\"></option>\n";
            $selected = '';

            foreach ( $items as $item ):
                if ( $item->link_id == $value ) $selected = 'selected';
                $options .= '<option value="' . intval($item->link_id) . '" ' . $selected . '>' . htmlspecialchars($item->link_name) . '</option>' . "\n";
                $selected = '';
            endforeach;

            $hint = ( empty( $this->_field_data['hint'] ) ) ? '' :  '<p><em>' . $this->_field_data['hint'] . '</em></p>';

            $label_format =
                '<div class="%s">'.
                '<p><label for="%s"><strong>%s</strong></label></p>'.
                '<p><select class="%s" style="width: 100%%;" name="%s">%s</select></p>'.
                '%s'.
                '</div>';
            printf( $label_format, $class, $id, $label, $input_class, $id, $options, $hint );
        }
    }
}
$easy_cf = new Easy_CF($field_data);

class DFMInArticleTeaser
{
    // We use this class to manage In-Article Teasers.
    // Yes, it's just a wrapper for get_bookmark,
    // but this allows us to build on the functionality here without
    // significant theme code rewrites.


    public function __construct($post)
    {
        $this->post = $post;
        $this->load_teaser();
    }

    public function load_teaser($post = 0)
    {
        // A teaser is a bookmark object we use for teasing its content in an article.
        // load_teaser takes a post object and gets the teaser custom field (a bookmark id),
        // and returns the bookmark object. It also assigns the bookmark object to itself.

        if ( $post == 0 ):
            $post = $this->post;
        else:
            $post = get_post($post);
        endif;

        $teaser = get_post_custom_values('teaser', $post->ID);
        $this->bookmark = get_bookmark($teaser[0]);
        return $this->bookmark;
    }

    public function load_feed($rss_url = '')
    {
        // Wrapper for WP's https://codex.wordpress.org/Function_Reference/fetch_feed
        // Returns a SimplePie feed object (see http://simplepie.org/wiki/ )

        if ( $rss_url == '' ):
            // If we're taking the url of the bookmark object, and we haven't
            // loaded the bookmark object yet, we load the bookmark object.
            if ( !isset($this->bookmark) )
                $this->load_teaser();

            $rss_url = $this->bookmark->link_rss;
        endif;

        if ( filter_var($rss_url, FILTER_VALIDATE_URL) === FALSE )
            return false;

        // Adjust feed caching time here. ***
        return fetch_feed($rss_url);
    }

    public function get_feed_items($limit = 5, $feed = '')
    {
        // Returns an array of feed item objects.
        if ( $feed == '' )
            $feed = $this->load_feed();

        if ( is_wp_error($feed) || $feed == false )
            return false;
        
        $max_items = $feed->get_item_quantity($limit);
        // We will need a way to distinguish between the different return-false's.
        if ( $max_items == 0 )
            return false;

        $raw_items = $feed->get_items(0, $max_items);
        $items = Array();

        // We take these attributes instead of the whole object for ease
        // of use within the timber templating system. This is a decision
        // that can be looked at.
        foreach ( $raw_items as $item ):
            $items[] = Array('date' => $item->get_date(),
                            'title' => $item->get_title(),
                            'permalink' => $item->get_permalink());
        endforeach;
        return $items;
    }
}
