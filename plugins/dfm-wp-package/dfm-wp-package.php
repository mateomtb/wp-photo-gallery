<?php
/**
 * Plugin Name: Article Packages
 * Plugin URI: https://github.com/dfmedia/dfm-wp-package
 * Description: Publish hand-curated packages of related articles + media. This is done with tags (anything tagged "package-" is part of a package) and custom fields. The Easy Custom Fields plugin ( http://wordpress.org/plugins/easy-custom-fields/ ) is required.
 * Version: 0.1
 * Author: Joe Murphy, Digital First Media
 * Author URI: http://digitalfirstmedia.com/
 * License: Apache-2
 */

// TODOS:
// * Allow more than one package to be associated to a post.
/*
// Usage:
if ( class_exists('DFMPackage') ):
    $package = new DFMPackage($post);

    // Returns array:
    $package_name = $package->get_package();

    // Returns a collection of posts:
    $posts = $package->get_package_items();
endif;


// Usage (within the Timber templating system):
if ( class_exists('DFMPackage') ):
    $package = new DFMPackage($post);
    $package_name = $package->get_package();
    $context['package_name'] = $package_name[0];
    $context['package'] = $package->get_package_items();
endif;
*/

if ( !file_exists(WP_PLUGIN_DIR . '/easy-custom-fields/easy-custom-fields.php') ) die("Requires Easy Custom Fields plugin ( http://wordpress.org/plugins/easy-custom-fields/ )");

require_once( WP_PLUGIN_DIR . '/easy-custom-fields/easy-custom-fields.php' );

$field_data = array (
        'Packages' => array (
                'fields' => array (
                        'package' => array('label'=>'Package',
                                        'type'=>'tag_select'),
                ),
        ),
);

if ( !class_exists( "Easy_CF_Field_Tag_Select" ) ) {
    class Easy_CF_Field_Tag_Select extends Easy_CF_Field {
        public function print_form() {
            $class = ( empty( $this->_field_data['class'] ) ) ? $this->_field_data['id'] . '_class' :  $this->_field_data['class'];
            $input_class = ( empty( $this->_field_data['input_class'] ) ) ? $this->_field_data['id'] . '_input_class' :  $this->_field_data['input_class'];

            $id = ( empty( $this->_field_data['id'] ) ) ? $this->_field_data['id'] :  $this->_field_data['id'];
            $label = ( empty( $this->_field_data['label'] ) ) ? $this->_field_data['id'] :  $this->_field_data['label'];
            $value = $this->get();

            $tags = get_tags();
            $options = '<option value=""></option>';
            $selected = '';
            foreach ( $tags as $tag ):
                // We only list tags that have the word "Package" in them.
                if ( strpos(strtolower($tag->slug), 'package') !== FALSE ):
                    if ( $tag->slug == $value ) $selected = 'selected';
                    $options .= '<option value="' . $tag->slug . '" . ' . $selected . '>' . $tag->name . '</option>' . "\n";
                    $selected = '';
                endif;
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

class DFMPackage
{
    // We use this class to take a post or a post_id and look up a posts package.
    // If the package exists return either an array of post objects or an array of post link markup.

    var $post;

    function __construct($post)
    {
        switch ( gettype($post) ):
            case 'object':
                $this->post = $post;
                break;
            case 'integer':
                $this->post = get_post($post);
                break;
            case 'string':
                $this->post = get_post(intval($post));
                break;
        endswitch;
        $this->package=$this->get_package();
    }

    public function get_package($post_id=0)
    {
        // Returns the tag slug of the package for a particular post.
        // Takes a parameter, post_id, for manual lookups of post package field.
        if ( $post_id == 0 )
            $post_id = $post->ID;

        $package = get_post_custom_values('package', $post_id);
        
        return $package;
    }

    public function get_package_items()
    {
        // Returns an array of post objects in the package.
        $args = array(
            'tag' => $this->package[0],
            'limit' => 10,
            );
        $query = new WP_Query($args);
        if ( $query->have_posts() )
            return $query->posts;
        
        return false;
    }
}
