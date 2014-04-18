<?php
/**
 * Plugin Name: DFM Wordpress Taxonomy
 * Description: Creates a central taxonomy that local sites can append.
 * Version: 0.1
 * Author: Brian Henderson
 * Author Contact : bhenderson@pioneerpress.com
 * License: TBD
**/

/**
* @desc Enqueues a js file that hides the default parent and description fields on the category edit page.
*/

add_action ('admin_enqueue_scripts', 'dfm_enqueue_taxonomy_js');
function dfm_enqueue_taxonomy_js($hook){
	$screen = get_current_screen();
	if ($screen->taxonomy == 'category'){
	    wp_enqueue_script('dfm-wp-taxonomy' , plugins_url( '/js/dfm-wp-taxonomy.js' , __FILE__ ));
	}
}

/**
* @desc Adds 2 dropdowns to the category page. 
* 1. DFM Parent Category - Pulls the current list of categories and forces any new categories to be the child of an existing category.
* 2. Ad taxonomy - Pulls the ad taxonomy and allows the creator to assign a value for ad tags to the description field. 
*/

add_action( 'category_add_form_fields', 'dfm_add_parent_category_dropdown' );
function dfm_add_parent_category_dropdown() {
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

add_action( 'category_add_form_fields', 'dfm_add_ad_taxonomy_dropdown' );
function dfm_add_ad_taxonomy_dropdown() {
    echo '<div class="form-field form-required">';
    echo '<label for="adtaxonomy">' . _ex('Ad taxonomy', 'Ad Taxonomy') . '</label>';
    $adtaxonomy = get_terms('adtaxonomy', array('hide_empty'    => false));
    if ($adtaxonomy){
        echo '<select name="description" class="postform">';
        foreach ($adtaxonomy as $adtaxitem) {
             echo '<option value = "' . $adtaxitem->name . '">' . $adtaxitem->name . '</option>';
        }
        echo '</select>';
    }    
    echo '</div>';
}

/**
* @desc Register a custom taxonomy to handle ad taxonomy values.
*/

add_action( 'init', 'dfm_register_ad_taxonomy', 0 );
function dfm_register_ad_taxonomy() {
    $labels = array(
        'name'                       => _x( 'Ad Taxonomies', 'Taxonomy General Name', 'text_domain' ),
        'singular_name'              => _x( 'Ad Taxonomy', 'Taxonomy Singular Name', 'text_domain' ),
        'menu_name'                  => __( 'Ad Taxonomy', 'text_domain' ),
        'all_items'                  => __( 'All Items', 'text_domain' ),
        'parent_item'                => __( 'Parent Item', 'text_domain' ),
        'parent_item_colon'          => __( 'Parent Item:', 'text_domain' ),
        'new_item_name'              => __( 'New Item Name', 'text_domain' ),
        'add_new_item'               => __( 'Add New Item', 'text_domain' ),
        'edit_item'                  => __( 'Edit Item', 'text_domain' ),
        'update_item'                => __( 'Update Item', 'text_domain' ),
        'separate_items_with_commas' => __( 'Separate items with commas', 'text_domain' ),
        'search_items'               => __( 'Search Items', 'text_domain' ),
        'add_or_remove_items'        => __( 'Add or remove items', 'text_domain' ),
        'choose_from_most_used'      => __( 'Choose from the most used items', 'text_domain' ),
        'not_found'                  => __( 'Not Found', 'text_domain' ),
    );
    $args = array(
        'labels'                     => $labels,
        'hierarchical'               => false,
        'public'                     => true,
        'show_ui'                    => true,
        'show_admin_column'          => true,
        'show_in_nav_menus'          => true,
        'show_tagcloud'              => true,
    );
    register_taxonomy( 'adtaxonomy', array( 'post' ), $args );

}

/**
* @desc Assigns any categories that are imported by Dictator to an array in the dfm_categories option. The 'DICTATOR' constant is set in dictator.php. 
*/
add_action('created_term', 'dfm_add_to_master_list');
 
function dfm_add_to_master_list($term_id){
    if( constant('DICTATOR') ){
        $dfm_categories = get_option( 'dfm_categories', array() );
        if ( ! in_array( $term_id, $dfm_categories ) ) {
            $dfm_categories[] = $term_id;
        }
    update_option( 'dfm_categories', $dfm_categories );
    }
}

/**
* @desc Filter to remove "Edit", "Quick Edit" and "Delete" mouseover links on the category page.
*/
add_filter( 'category_row_actions', 'dfm_tax_remove_row_actions', 10, 1 );

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

/**
* @desc Remove the bulk actions dropdown too.
*/

add_filter('bulk_actions-edit-category','dfm_tax_remove_bulk_actions');
 function dfm_tax_remove_bulk_actions($actions){
        unset( $actions['delete'] );
        return $actions;
    }

/**
* @desc Gets the hidden categories option and adds the values within to the exclusions on the editpost page.
*/

function dfm_filter_terms( $exclusions, $args ){
    // IDs of terms to be excluded
    $exclude = get_option('hiddencategories'); 
     
    // Generation of exclusion SQL code
    $exterms = wp_parse_id_list( $exclude );
    foreach ( $exterms as $exterm ) {
            if ( empty($exclusions) )
                    $exclusions = ' AND ( t.term_id <> ' . intval($exterm) . ' ';
            else
                    $exclusions .= ' AND t.term_id <> ' . intval($exterm) . ' ';
    }
         
    if ( !empty($exclusions) )
        $exclusions .= ')';
     
    return $exclusions;
}
 
add_action( 'current_screen' , function($thescreen){
    if( $thescreen->base == 'post' ) {
        add_filter( 'list_terms_exclusions', 'dfm_filter_terms', 10, 2 );
    }
} );

/**
* @desc Adds a screen of checkboxes that allow editors to hide categories on the edit post page of a site.
*/


add_action('init', function (){
    if (class_exists("Fieldmanager_Group")){
        $fm = new Fieldmanager_Checkboxes( array(
            'name' => 'hiddencategories',
            'limit' => 1,
            'starting_count' => 0,
            'multiple' => true,
            'required' => false,
            
            'one_label_per_item' => False,                    
            'datasource' => new Fieldmanager_Datasource_Term( array(
                'taxonomy' => 'category',
                'taxonomy_hierarchical' => true,
            ) ),        
        ) );
        $fm->add_submenu_page( 'options-general.php', 'DFM Local Taxonomy - Hide Categories');
    }   
});

/**
* @desc Add a page to manage local labels to the WP Admin.
*/

add_action('init', function(){
    if (class_exists("Fieldmanager_Group")){
        $fm = new Fieldmanager_Group( array(
            'name' => 'locallabels',
            'limit' => 0,
            'label' => 'New Label',
            'label_macro' => array( 'Label: %s', 'title' ),
            'add_more_label' => 'Add another label',
            'collapsed' => True,
            'sortable' => True,
            'required' => false,
            'children' => array(
                'title' => new Fieldmanager_Textfield( 'Local Label' ),
                'posts' => new Fieldmanager_Autocomplete( 'DFM Taxonomy Name', array(
                    'limit' => 1,
                    'one_label_per_item' => False,                
                    'datasource' => new Fieldmanager_Datasource_Term( array(
                        'taxonomy' => 'category',                    
                    ) ),
                ) ),
            ),
        ) );
        $fm->add_submenu_page( 'options-general.php', 'DFM Local Taxonomy - Local Labels');
    }
});
?>