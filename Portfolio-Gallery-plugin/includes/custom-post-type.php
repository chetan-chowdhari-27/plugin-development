<?php

// Register Custom Post Type: Portfolio
function create_portfolio_post_type() {

    $labels = array(
        'name'                  => _x( 'Portfolios', 'Post Type General Name', 'portfolio-plugin' ),
        'singular_name'         => _x( 'Portfolio', 'Post Type Singular Name', 'portfolio-plugin' ),
        'menu_name'             => __( 'Portfolio', 'portfolio-plugin' ),
        'name_admin_bar'        => __( 'Portfolio', 'portfolio-plugin' ),
        'archives'              => __( 'Portfolio Archives', 'portfolio-plugin' ),
        'attributes'            => __( 'Portfolio Attributes', 'portfolio-plugin' ),
        'parent_item_colon'     => __( 'Parent Portfolio:', 'portfolio-plugin' ),
        'all_items'             => __( 'All Portfolios', 'portfolio-plugin' ),
        'add_new_item'          => __( 'Add New Portfolio', 'portfolio-plugin' ),
        'add_new'               => __( 'Add New', 'portfolio-plugin' ),
        'new_item'              => __( 'New Portfolio', 'portfolio-plugin' ),
        'edit_item'             => __( 'Edit Portfolio', 'portfolio-plugin' ),
        'update_item'           => __( 'Update Portfolio', 'portfolio-plugin' ),
        'view_item'             => __( 'View Portfolio', 'portfolio-plugin' ),
        'view_items'            => __( 'View Portfolios', 'portfolio-plugin' ),
        'search_items'          => __( 'Search Portfolio', 'portfolio-plugin' ),
        'not_found'             => __( 'Not found', 'portfolio-plugin' ),
        'not_found_in_trash'    => __( 'Not found in Trash', 'portfolio-plugin' ),
        'featured_image'        => __( 'Featured Image', 'portfolio-plugin' ),
        'set_featured_image'    => __( 'Set featured image', 'portfolio-plugin' ),
        'remove_featured_image' => __( 'Remove featured image', 'portfolio-plugin' ),
        'use_featured_image'    => __( 'Use as featured image', 'portfolio-plugin' ),
        'insert_into_item'      => __( 'Insert into portfolio', 'portfolio-plugin' ),
        'uploaded_to_this_item' => __( 'Uploaded to this portfolio', 'portfolio-plugin' ),
        'items_list'            => __( 'Portfolios list', 'portfolio-plugin' ),
        'items_list_navigation' => __( 'Portfolios list navigation', 'portfolio-plugin' ),
        'filter_items_list'     => __( 'Filter portfolios list', 'portfolio-plugin' ),
    );
    $args = array(
        'label'                 => __( 'Portfolio', 'portfolio-plugin' ),
        'description'           => __( 'A custom post type for portfolios', 'portfolio-plugin' ),
        'labels'                => $labels,
        'supports'              => array( 'title', 'editor', 'thumbnail', 'excerpt', 'custom-fields' ),
        'taxonomies'            => array( 'portfolio_category' ), 
        'hierarchical'          => false,
        'public'                => true,
        'show_ui'               => true,
        'show_in_menu'          => true,
        'menu_position'         => 5,
        'menu_icon'             => 'dashicons-portfolio',
        'show_in_admin_bar'     => true,
        'show_in_nav_menus'     => true,
        'can_export'            => true,
        'has_archive'           => true,
        'exclude_from_search'   => false,
        'publicly_queryable'    => true,
        'capability_type'       => 'post',
        'show_in_rest'          => true,
    );
    register_post_type( 'portfolio', $args );
}
add_action( 'init', 'create_portfolio_post_type', 0 );


// Register Custom Taxonomy: Portfolio Categories
function create_portfolio_taxonomy() {

    $labels = array(
        'name'                       => _x( 'Portfolio Categories', 'Taxonomy General Name', 'portfolio-plugin' ),
        'singular_name'              => _x( 'Portfolio Category', 'Taxonomy Singular Name', 'portfolio-plugin' ),
        'menu_name'                  => __( 'Portfolio Categories', 'portfolio-plugin' ),
        'all_items'                  => __( 'All Categories', 'portfolio-plugin' ),
        'parent_item'                => __( 'Parent Category', 'portfolio-plugin' ),
        'parent_item_colon'          => __( 'Parent Category:', 'portfolio-plugin' ),
        'new_item_name'              => __( 'New Category Name', 'portfolio-plugin' ),
        'add_new_item'               => __( 'Add New Category', 'portfolio-plugin' ),
        'edit_item'                  => __( 'Edit Category', 'portfolio-plugin' ),
        'update_item'                => __( 'Update Category', 'portfolio-plugin' ),
        'view_item'                  => __( 'View Category', 'portfolio-plugin' ),
        'separate_items_with_commas' => __( 'Separate categories with commas', 'portfolio-plugin' ),
        'add_or_remove_items'        => __( 'Add or remove categories', 'portfolio-plugin' ),
        'choose_from_most_used'      => __( 'Choose from the most used', 'portfolio-plugin' ),
        'popular_items'              => __( 'Popular Categories', 'portfolio-plugin' ),
        'search_items'               => __( 'Search Categories', 'portfolio-plugin' ),
        'not_found'                  => __( 'Not Found', 'portfolio-plugin' ),
        'no_terms'                   => __( 'No categories', 'portfolio-plugin' ),
        'items_list'                 => __( 'Categories list', 'portfolio-plugin' ),
        'items_list_navigation'      => __( 'Categories list navigation', 'portfolio-plugin' ),
    );
    $args = array(
        'labels'                     => $labels,
        'hierarchical'               => true,
        'public'                     => true,
        'show_ui'                    => true,
        'show_admin_column'          => true,
        'show_in_nav_menus'          => true,
        'show_tagcloud'              => true,
        'show_in_rest'               => true,
    );
    register_taxonomy( 'portfolio_category', array( 'portfolio' ), $args );
}
add_action( 'init', 'create_portfolio_taxonomy', 0 );
?>
