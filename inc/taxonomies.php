<?php
/**
 * 注册3个用于“材料（material）”内容的分类法：工艺、类型、特性
 * 在主题初始化时自动创建常用术语，保证后台筛选器和前台URL立即可用
 * 开启 REST 支持与后台列显示，方便后续在列表页筛选与接口使用
 * 
 * 注意点：
 * 这些分类都挂在自定义内容类型 material 上，请确保该 CPT 已注册
 * 非层级（hierarchical=false），更适合多标签组合筛选；如果将来要树状分类，可改为 true
 * 术语只会在不存在时插入，避免重复创建，适合生产环境安全初始化
 */
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
