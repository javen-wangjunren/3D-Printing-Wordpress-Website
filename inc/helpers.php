<?php
if ( ! function_exists( 'get_post_type' ) ) {
    function get_post_type( $post = null ) { return ''; }
}

if ( ! function_exists( 'wp_set_object_terms' ) ) {
    function wp_set_object_terms( $object_id, $terms, $taxonomy, $append = false ) { return array(); }
}

add_filter( 'acf/load_field/name=material_process', function( $field ) {
    $terms = get_terms( array( 'taxonomy' => 'material_process', 'hide_empty' => false ) );
    $choices = array();
    if ( ! is_wp_error( $terms ) ) {
        foreach ( $terms as $term ) {
            $choices[ $term->slug ] = $term->name;
        }
    }
    $field['choices'] = $choices;
    return $field;
} );

add_filter( 'acf/load_field/name=material_type', function( $field ) {
    $terms = get_terms( array( 'taxonomy' => 'material_type', 'hide_empty' => false ) );
    $choices = array();
    if ( ! is_wp_error( $terms ) ) {
        foreach ( $terms as $term ) {
            $choices[ $term->slug ] = $term->name;
        }
    }
    $field['choices'] = $choices;
    return $field;
} );

add_action( 'acf/save_post', function( $post_id ) {
    if ( ! is_numeric( $post_id ) ) {
        return;
    }

    if ( get_post_type( (int) $post_id ) !== 'material' ) {
        return;
    }

    $process_slug = (string) ( get_field( 'material_process', (int) $post_id ) ?: '' );
    $type_slug = (string) ( get_field( 'material_type', (int) $post_id ) ?: '' );

    if ( $process_slug ) {
        wp_set_object_terms( (int) $post_id, array( $process_slug ), 'material_process', false );
    } else {
        wp_set_object_terms( (int) $post_id, array(), 'material_process', false );
    }

    if ( $type_slug ) {
        wp_set_object_terms( (int) $post_id, array( $type_slug ), 'material_type', false );
    } else {
        wp_set_object_terms( (int) $post_id, array(), 'material_type', false );
    }
}, 20 );
