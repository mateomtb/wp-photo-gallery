<?php
/**
 * Plugin Name: DFM Article Sidebar Blurbs
 * Plugin URI: 
 * Description: 
 * Version: 0.1
 * Author: Joe Murphy, Digital First Media
 * Author URI: http://digitalfirstmedia.com/
 * License: Apache-2
 */

if ( !file_exists(WP_PLUGIN_DIR . '/easy-custom-fields/easy-custom-fields.php') ) die("Requires Easy Custom Fields plugin ( http://wordpress.org/plugins/easy-custom-fields/ )");

require_once( WP_PLUGIN_DIR . '/easy-custom-fields/easy-custom-fields.php' );
$field_data = array (
        'BylineOverride' => array (             // unique group id
                'fields' => array(             // array "fields" with field definitions
                        'Name'  => array(),      // globally unique field id
                        'Publication'  => array(),
                ),
        ),
        'Sidebar' => array (
                'fields' => array (
                        'sidebar_title' => array('label'=>'Sidebar Title'),
                        'sidebar_markup' => array('label'=>'Sidebar Content',
                                        'type'=>'textarea'),
                ),
        ),
);


if ( !class_exists( "Easy_CF_Field_Textarea" ) ) {
    class Easy_CF_Field_Textarea extends Easy_CF_Field {
        public function print_form() {
            $class = ( empty( $this->_field_data['class'] ) ) ? $this->_field_data['id'] . '_class' :  $this->_field_data['class'];
            $input_class = ( empty( $this->_field_data['input_class'] ) ) ? $this->_field_data['id'] . '_input_class' :  $this->_field_data['input_class'];

            $id = ( empty( $this->_field_data['id'] ) ) ? $this->_field_data['id'] :  $this->_field_data['id'];
            $label = ( empty( $this->_field_data['label'] ) ) ? $this->_field_data['id'] :  $this->_field_data['label'];
            $value = $this->get();
            $hint = ( empty( $this->_field_data['hint'] ) ) ? '' :  '<p><em>' . $this->_field_data['hint'] . '</em></p>';

            $label_format =
                '<div class="%s">'.
                '<p><label for="%s"><strong>%s</strong></label></p>'.
                '<p><textarea class="%s" style="width: 100%%;" type="text" name="%s">%s</textarea></p>'.
                '%s'.
                '</div>';
            printf( $label_format, $class, $id, $label, $input_class, $id, $value, $hint );
        }
    }
}
$easy_cf = new Easy_CF($field_data);
