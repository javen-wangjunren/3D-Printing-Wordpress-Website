<?php
/**
 * Admin Filters Customization
 * 自定义后台列表筛选器
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/**
 * 1. 在 Material 列表页增加 Material Process 和 Material Type 筛选器
 */
add_action( 'restrict_manage_posts', '_3dp_add_material_taxonomy_filters' );

function _3dp_add_material_taxonomy_filters( $post_type ) {
    // 仅针对 material 类型
    if ( 'material' !== $post_type ) {
        return;
    }

    // 定义要显示的分类法
    $taxonomies = array( 'material_process', 'material_type' );

    foreach ( $taxonomies as $taxonomy_slug ) {
        $taxonomy = get_taxonomy( $taxonomy_slug );
        if ( ! $taxonomy ) {
            continue;
        }

        // 获取当前选中的值
        $selected = isset( $_GET[ $taxonomy_slug ] ) ? $_GET[ $taxonomy_slug ] : '';

        wp_dropdown_categories( array(
            'show_option_all' => sprintf( __( 'All %s', '3d-printing' ), $taxonomy->label ),
            'taxonomy'        => $taxonomy_slug,
            'name'            => $taxonomy_slug, // name 属性必须匹配 query var
            'orderby'         => 'name',
            'selected'        => $selected,
            'show_count'      => false, // 隐藏数量（因默认仅统计 Published，会导致 Draft 计数为 0 产生误导）
            'hide_empty'      => false, // 即使为空也显示（可选，方便调试）
            'value_field'     => 'slug', // 使用 slug 作为 value，以便 URL 参数更友好
            'hierarchical'    => true,
        ) );
    }
}

/**
 * 2. 在 Material 列表页移除 "All dates" 筛选器
 */
add_filter( 'disable_months_dropdown', '_3dp_disable_months_dropdown', 10, 2 );

function _3dp_disable_months_dropdown( $disable, $post_type ) {
    if ( 'material' === $post_type ) {
        return true;
    }
    return $disable;
}
