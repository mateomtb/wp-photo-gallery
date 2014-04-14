<?php
/**
 * Plugin Name: DFM Wordpress Taxonomy
 * Description: Creates a central taxonomy that local sites can append.
 * Version: 0.1
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


add_action( 'admin_init', 'dfm_ad_taxonomy' );

function dfm_ad_taxonomy() {
    if (class_exists("Fieldmanager_Group")){
        $fm = new Fieldmanager_Select( array(
            'name' => 'adtaxonomy',            
            'datasource' => new Fieldmanager_Datasource_Term( array(
                'taxonomy' => 'adtaxonomy'
            ) ),   
        ) );    
    $fm->add_term_form( 'Ad Taxonomy', array('category'));
    }    
}     

add_action( 'add_category', array( $this, 'dfm_save_ad_taxonomy_field' ), 10, 1 );
add_action( 'edit_category', array( $this, 'dfm_save_ad_taxonomy_field' ), 10, 1 );

function dfm_save_ad_taxonomy_field($term_id) {
    if (isset($_POST['adtaxonomy'])) {
        $t_id = $term_id;
        $term_meta = get_option("adtaxonomy_$t_id");
        $cat_keys = array_keys($_POST['adtaxonomy']);
        foreach ($cat_keys as $key) {
            if (isset($_POST['adtaxonomy'][$key])) {
                $term_meta[$key] = $_POST['adtaxonomy'][$key];
            }
        }
        update_option("adtaxonomy_$t_id", $term_meta);
    }
}


// Register Custom Taxonomy
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

// Hook into the 'init' action
add_action( 'init', 'dfm_register_ad_taxonomy', 0 );



/**
* @desc Assigns any categories that are imported by Dictator to an array in the dfm_categories option. The 'DICTATOR' constant is set in dictator.php. 
*/
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

add_filter( 'category_row_actions', 'dfm_tax_remove_row_actions', 10, 1 );

/**
* @desc	Filter to remove "Edit", "Quick Edit" and "Delete" mouseover links on the category page.
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

add_action( 'init', function() {
    if (class_exists("Fieldmanager_Group")){
        $fm = new Fieldmanager_Group( array(
            'name' => 'dfmpostcategories',
            'add_more_label' => 'Add another category',
            'limit' => 0,
            'one_label_per_item' => False,
            'children' => array(                
                    'localcats' => new Fieldmanager_Autocomplete( 'Category', array(
                        'limit' => 1,
                        'one_label_per_item' => False,                   
                        'datasource' => new Fieldmanager_Datasource_Term( array(
                        'taxonomy' => 'category'
                    ) ),                
                ) ),
            'primarycategory' => new Fieldmanager_Checkbox('Main Category?'),
            ),
        ) );
        $fm->add_meta_box( 'Categories', array( 'post' ) );
    }
} );

/**
* @desc Allow users to hide categories on the post page
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