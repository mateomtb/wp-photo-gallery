<?php
/**
 * Plugin Name: DFM Wordpress Taxonomy
 * Description: Creates a central taxonomy that local sites can append.
 * Version: 1.0
 * Author: Brian Henderson
 * Author Contact : bhenderson@pioneerpress.com
 * License: TBD
**/



add_action ('admin_enqueue_scripts', 'dfm_taxonomy_js');
function dfm_taxonomy_js($hook){
	$screen = get_current_screen();
	if ($screen->taxonomy == 'category'){
	    wp_enqueue_script('dfm-wp-taxonomy' , plugins_url( '/js/dfm-wp-taxonomy.js' , __FILE__ ));
	}
}



add_action( 'category_add_form_fields', 'dfm_parent_category' );

function dfm_parent_category() {
	echo '<div class="form-field form-required">';
	echo '<label for="parent">' . _ex('DFM Parent Category', 'Taxonomy Parent') . '</label>';
	$dropdown_args = array(
		'hide_empty'       => 0,
		'hide_if_empty'    => false,
		'taxonomy'         => 'category',
		'name'             => 'parent',
		'orderby'          => 'name',
		'hierarchical'     => true,
		);

	$dropdown_args = apply_filters( 'taxonomy_parent_dropdown_args', $dropdown_args, 'category' );
	wp_dropdown_categories( $dropdown_args );
	echo '<p>New categories must be associated with an existing category from the DFM taxonomy.</p>';
    echo '</div>';
}


add_action('created_term', 'dfm_master_list');
 
function dfm_master_list($term_id){
    if( constant('DICTATOR') ){
        $dfm_categories = get_option( 'dfm_categories', array() );
        if ( ! in_array( $term_id, $dfm_categories ) ) {
            $dfm_categories[] = $term_id;
        }
    update_option( 'dfm_categories', $dfm_categories );
    }
}


// filter row-actions

add_filter( 'category_row_actions', 'dfm_tax_remove_row_actions', 10, 1 );

/**
* @desc	Hide row actions on DFM categories
*/
function dfm_tax_remove_row_actions ( $actions ){
	
    $cat_id = explode('=', $actions['view']);
    $cat_id = explode('"', $cat_id[2]);
    $cat_id = $cat_id[0];
    $dfm_categories = get_option( 'dfm_categories', array() );
    if(in_array($cat_id, $dfm_categories)) {
    	unset( $actions['inline hide-if-no-js'] );  // quick edit
		unset( $actions['edit'] );	// edit
		unset( $actions['delete'] );	// delete
	}
    	return $actions;
}


add_filter('bulk_actions-edit-category','dfm_tax_remove_bulk_actions');
 function dfm_tax_remove_bulk_actions($actions){
        unset( $actions['delete'] );
        return $actions;
    }
    

?>