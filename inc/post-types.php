<?php
/**
 * Register Custom Post Types (CPTs)
 *
 * @package 3D Printing
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

add_action( 'init', '_3dp_register_post_types' );

/**
 * Register all custom post types
 */
function _3dp_register_post_types() {
    // ==========================================
    // Capability CPT (制造工艺)
    // ==========================================
    register_post_type( 'capability', array(
        'labels' => array(
            'name'               => _x( 'Capabilities', 'post type general name', '3d-printing' ),
            'singular_name'      => _x( 'Capability', 'post type singular name', '3d-printing' ),
            'menu_name'          => _x( 'Capabilities', 'admin menu', '3d-printing' ),
            'name_admin_bar'     => _x( 'Capability', 'add new on admin bar', '3d-printing' ),
            'add_new'            => _x( 'Add New', 'capability', '3d-printing' ),
            'add_new_item'       => __( 'Add New Capability', '3d-printing' ),
            'new_item'           => __( 'New Capability', '3d-printing' ),
            'edit_item'          => __( 'Edit Capability', '3d-printing' ),
            'view_item'          => __( 'View Capability', '3d-printing' ),
            'all_items'          => __( 'All Capabilities', '3d-printing' ),
            'search_items'       => __( 'Search Capabilities', '3d-printing' ),
            'parent_item_colon'  => __( 'Parent Capabilities:', '3d-printing' ),
            'not_found'          => __( 'No capabilities found.', '3d-printing' ),
            'not_found_in_trash' => __( 'No capabilities found in Trash.', '3d-printing' )
        ),
        'public'             => true,
        'publicly_queryable' => true,
        'show_ui'            => true,
        'show_in_menu'       => true,
        'query_var'          => true,
        'rewrite'            => array( 'slug' => 'capability' ),
        'capability_type'    => 'post',
        'has_archive'        => true,
        'hierarchical'       => false,
        'menu_position'      => 5,
        'menu_icon'          => 'dashicons-building',
        'supports'           => array( 'title', 'thumbnail', 'excerpt', 'custom-fields' ),
        'taxonomies'         => array( 'category', 'post_tag' ),
    ) );

    // ==========================================
    // Material CPT (材料)
    // ==========================================
    register_post_type( 'material', array(
        'labels' => array(
            'name'               => _x( 'Materials', 'post type general name', '3d-printing' ),
            'singular_name'      => _x( 'Material', 'post type singular name', '3d-printing' ),
            'menu_name'          => _x( 'Materials', 'admin menu', '3d-printing' ),
            'name_admin_bar'     => _x( 'Material', 'add new on admin bar', '3d-printing' ),
            'add_new'            => _x( 'Add New', 'material', '3d-printing' ),
            'add_new_item'       => __( 'Add New Material', '3d-printing' ),
            'new_item'           => __( 'New Material', '3d-printing' ),
            'edit_item'          => __( 'Edit Material', '3d-printing' ),
            'view_item'          => __( 'View Material', '3d-printing' ),
            'all_items'          => __( 'All Materials', '3d-printing' ),
            'search_items'       => __( 'Search Materials', '3d-printing' ),
            'parent_item_colon'  => __( 'Parent Materials:', '3d-printing' ),
            'not_found'          => __( 'No materials found.', '3d-printing' ),
            'not_found_in_trash' => __( 'No materials found in Trash.', '3d-printing' )
        ),
        'public'             => true,
        'publicly_queryable' => true,
        'show_ui'            => true,
        'show_in_menu'       => true,
        'query_var'          => true,
        'rewrite'            => array( 'slug' => 'material' ),
        'capability_type'    => 'post',
        'has_archive'        => true,
        'hierarchical'       => false,
        'menu_position'      => 6,
        'menu_icon'          => 'dashicons-palmtree',
        'supports'           => array( 'title', 'thumbnail', 'excerpt', 'custom-fields' ),
        'taxonomies'         => array( 'category', 'post_tag' ),
    ) );
}
