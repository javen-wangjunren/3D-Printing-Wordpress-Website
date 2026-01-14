<?php
if ( ! defined( 'ABSPATH' ) ) { exit; }

add_action( 'init', function() {
    register_taxonomy( 'material_characteristic', array( 'material' ), array(
        'label' => 'Material Characteristics',
        'public' => true,
        'hierarchical' => false,
        'rewrite' => array( 'slug' => 'material-characteristic' ),
        'show_admin_column' => true,
        'show_in_rest' => true,
    ) );

    register_taxonomy( 'material_process', array( 'material' ), array(
        'label' => 'Material Process',
        'public' => true,
        'hierarchical' => false,
        'rewrite' => array( 'slug' => 'material-process' ),
        'show_admin_column' => true,
        'show_in_rest' => true,
    ) );

    register_taxonomy( 'material_type', array( 'material' ), array(
        'label' => 'Material Type',
        'public' => true,
        'hierarchical' => false,
        'rewrite' => array( 'slug' => 'material-type' ),
        'show_admin_column' => true,
        'show_in_rest' => true,
    ) );

    $process_terms = array(
        array( 'slug' => 'sls',  'name' => 'SLS (Polymer)' ),
        array( 'slug' => 'mjf',  'name' => 'MJF (Polymer)' ),
        array( 'slug' => 'fdm',  'name' => 'FDM (Polymer)' ),
        array( 'slug' => 'dmls', 'name' => 'DMLS (Metal)' ),
        array( 'slug' => 'sla',  'name' => 'SLA (Resin)' ),
    );
    foreach ( $process_terms as $t ) {
        if ( ! term_exists( $t['slug'], 'material_process' ) ) {
            wp_insert_term( $t['name'], 'material_process', array( 'slug' => $t['slug'] ) );
        }
    }

    $type_terms = array(
        array( 'slug' => 'plastic', 'name' => 'Plastic / Polymer' ),
        array( 'slug' => 'metal',   'name' => 'Metal / Alloy' ),
        array( 'slug' => 'resin',   'name' => 'Resin / Liquid' ),
    );
    foreach ( $type_terms as $t ) {
        if ( ! term_exists( $t['slug'], 'material_type' ) ) {
            wp_insert_term( $t['name'], 'material_type', array( 'slug' => $t['slug'] ) );
        }
    }

    $characteristic_terms = array(
        array( 'slug' => 'general-purpose', 'name' => 'General Purpose' ),
        array( 'slug' => 'no-supports',     'name' => 'No Supports' ),
    );
    foreach ( $characteristic_terms as $t ) {
        if ( ! term_exists( $t['slug'], 'material_characteristic' ) ) {
            wp_insert_term( $t['name'], 'material_characteristic', array( 'slug' => $t['slug'] ) );
        }
    }
} );
