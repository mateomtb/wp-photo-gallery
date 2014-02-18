<?php
/**
 * Plugin Name: WP Polls: In-Article
 * Plugin URI: 
 * Description: A Easy Custom Fields to select one poll from polls created via WP Polls.
 * Version: 0.1
 * Author: Joe Murphy, Digital First Media
 * Author URI: http://digitalfirstmedia.com/
 * License: Apache-2
 */

/*
// TODOS:
// Usage:
*/

if ( !file_exists(WP_PLUGIN_DIR . '/wp-polls/wp-polls.php') ) die("Requires plugin WP-Polls ( http://wordpress.org/plugins/wp-polls/ )");
if ( !file_exists(WP_PLUGIN_DIR . '/easy-custom-fields/easy-custom-fields.php') ) die("Requires Easy Custom Fields plugin ( http://wordpress.org/plugins/easy-custom-fields/ )");

require_once( WP_PLUGIN_DIR . '/easy-custom-fields/easy-custom-fields.php' );

$field_data = array (
        'Poll' => array (
                'fields' => array (
                        'inarticle_poll' => array('label'=>'Poll',
                                        'type'=>'poll_select'),
                ),
        ),
);

if ( !class_exists( "Easy_CF_Field_Poll_Select" ) ) {
    class Easy_CF_Field_Poll_Select extends Easy_CF_Field {
        public function print_form() {
            $class = ( empty( $this->_field_data['class'] ) ) ? $this->_field_data['id'] . '_class' :  $this->_field_data['class'];
            $input_class = ( empty( $this->_field_data['input_class'] ) ) ? $this->_field_data['id'] . '_input_class' :  $this->_field_data['input_class'];

            $id = ( empty( $this->_field_data['id'] ) ) ? $this->_field_data['id'] :  $this->_field_data['id'];
            $label = ( empty( $this->_field_data['label'] ) ) ? $this->_field_data['id'] :  $this->_field_data['label'];
            $value = $this->get();

            //$polls = get_tags();
            $options = '<option value=""></option>';
            $selected = '';

            foreach ( $tags as $tag ):
                // We only list tags that have the word "Collection" in them.
                if ( strpos(strtolower($tag->slug), 'package') !== $truefalse ):
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

class DFMInArticlePoll
{
    // We use this class to 


    function __construct($post, $collection_type = 'package')
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
        $this->collection_type=$collection_type;
        $this->collection=$this->get_collection();
    }

    public function get_collection($post_id=0)
    {
        // Returns the tag slug of the collection for a particular post.
        // Takes a parameter, post_id, for manual lookups of post collection field.
        if ( $post_id == 0 )
            $post_id = $post->ID;

        $collection = get_post_custom_values('package', $post_id);
        if ( $this->collection_type == 'related' )
            $collection = get_post_custom_values('related', $post_id);
        
        return $collection;
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
