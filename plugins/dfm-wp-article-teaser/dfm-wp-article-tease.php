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

$field_data = array (
        'Teaser' => array (
                'fields' => array (
                        'package' => array('label'=>'Teaser',
                                        'type'=>'link_select'),
                ),
        ),
);

if ( !class_exists( "Easy_CF_Field_Link_Select" ) ) {
    class Easy_CF_Field_Link_Select extends Easy_CF_Field {
        public function print_form() {
            $class = ( empty( $this->_field_data['class'] ) ) ? $this->_field_data['id'] . '_class' :  $this->_field_data['class'];
            $input_class = ( empty( $this->_field_data['input_class'] ) ) ? $this->_field_data['id'] . '_input_class' :  $this->_field_data['input_class'];

            $id = ( empty( $this->_field_data['id'] ) ) ? $this->_field_data['id'] :  $this->_field_data['id'];
            $label = ( empty( $this->_field_data['label'] ) ) ? $this->_field_data['id'] :  $this->_field_data['label'];
            $value = $this->get();

            //$items = get_tags();
            $options = '<option value=""></option>';
            $selected = '';

            foreach ( $items as $item ):
                if ( $tag->slug == $value ) $selected = 'selected';
                $options .= '<option value="' . $tag->slug . '" . ' . $selected . '>' . $tag->name . '</option>' . "\n";
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
    // We use this class to manage In-Article Teasers


    function __construct($post, $collection_type = 'package')
    {
    }

    public function get_collection($post_id=0)
    {
        // Returns the tag slug of the collection for a particular post.
    }

    public function get_collection_items()
    {
        // Returns an array of post objects in the collection.
        $args = array(
            'tag' => $this->collection[0],
            'limit' => 10,
            );
        $query = new WP_Query($args);
        if ( $query->have_posts() )
            return $query->posts;
        
        return false;
    }
}
