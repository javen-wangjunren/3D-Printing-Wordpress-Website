<?php
/**
 * Register Custom Post Types (CPTs) - 自定义文章类型注册
 * ==========================================================================
 * 文件作用:
 * 注册网站所需的所有自定义内容类型 (Custom Post Types)。
 * 目前包括:
 * 1. Capability (制造工艺) - 如 SLS, FDM
 * 2. Material (材料) - 如 Nylon PA12, PLA
 * 3. Surface Finish (表面处理) - 如 Polishing, Painting
 * 4. Solution (应用场景/解决方案) - 如 Automotive, Medical
 *
 * 核心逻辑:
 * - 挂载到 `init` 钩子。
 * - 使用 `register_post_type` 函数。
 * - 启用 `show_in_rest` 以支持 Gutenberg 编辑器。
 * - 配置 `supports` 以决定编辑界面显示哪些模块 (标题, 缩略图, Excerpt 等)。
 *
 * 架构角色:
 * [Model Layer - Data Definition]
 * 这是网站内容架构的基石。所有 ACF 字段组、Template 模板、Query 查询都基于
 * 这里定义的 post_type key (如 'material', 'capability')。
 *
 * 🚨 避坑指南:
 * 1. Slug 修改: 如果修改了 `rewrite` -> `slug`，必须去后台 "设置 -> 固定链接" 点击保存，
 *    否则前台页面会报 404。
 * 2. `has_archive`: 设置为 true 会自动生成 `/slug/` 的归档页，需要对应的 `archive-{post_type}.php` 模板。
 * ==========================================================================
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
    
    // ==========================================================================
    // 1. Capability CPT (制造工艺)
    // ==========================================================================
    // 对应模板: single-capability.php, page-all-capabilities.php (Custom Page)
    // URL结构: /capability/sls-printing/
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
        'menu_icon'          => 'dashicons-building', // 图标: 建筑/工厂
        'show_in_nav_menus'  => true,
        'supports'           => array( 'title', 'thumbnail', 'excerpt', 'custom-fields' ), // 不支持 editor，因为主要靠 ACF
        'show_in_rest'       => true, // 开启 REST API 支持 (虽然主要用 ACF，但开启也没坏处)
    ) );

    // ==========================================================================
    // 2. Material CPT (材料)
    // ==========================================================================
    // 对应模板: single-material.php, templates/page-all-materials.php (Custom Page)
    // URL结构: /material/nylon-pa12/
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
        'menu_icon'          => 'dashicons-palmtree', // 图标: 自然/材料
        'show_in_nav_menus'  => true,
        'supports'           => array( 'title', 'thumbnail', 'excerpt', 'custom-fields' ), // 同样主要靠 ACF
        'show_in_rest'       => true,
    ) );

    // ==========================================================================
    // 3. Surface Finish CPT (表面处理)
    // ==========================================================================
    // 对应模板: single-surface-finish.php (如果需要)
    // URL结构: /surface-finish/polishing/
    register_post_type( 'surface-finish', array(
        'labels' => array(
            'name'               => _x( 'Surface Finishes', 'post type general name', '3d-printing' ),
            'singular_name'      => _x( 'Surface Finish', 'post type singular name', '3d-printing' ),
            'menu_name'          => _x( 'Surface Finishes', 'admin menu', '3d-printing' ),
            'name_admin_bar'     => _x( 'Surface Finish', 'add new on admin bar', '3d-printing' ),
            'add_new'            => _x( 'Add New', 'surface-finish', '3d-printing' ),
            'add_new_item'       => __( 'Add New Surface Finish', '3d-printing' ),
            'new_item'           => __( 'New Surface Finish', '3d-printing' ),
            'edit_item'          => __( 'Edit Surface Finish', '3d-printing' ),
            'view_item'          => __( 'View Surface Finish', '3d-printing' ),
            'all_items'          => __( 'All Surface Finishes', '3d-printing' ),
            'search_items'       => __( 'Search Surface Finishes', '3d-printing' ),
            'parent_item_colon'  => __( 'Parent Surface Finishes:', '3d-printing' ),
            'not_found'          => __( 'No surface finishes found.', '3d-printing' ),
            'not_found_in_trash' => __( 'No surface finishes found in Trash.', '3d-printing' )
        ),
        'public'             => true,
        'publicly_queryable' => true,
        'show_ui'            => true,
        'show_in_menu'       => true,
        'show_in_nav_menus'  => true,
        'query_var'          => true,
        'rewrite'            => array( 'slug' => 'surface-finish' ),
        'capability_type'    => 'post',
        'has_archive'        => true,
        'hierarchical'       => false,
        'menu_position'      => 7,
        'menu_icon'          => 'dashicons-art', // 图标: 艺术/表面
        'supports'           => array( 'title', 'editor', 'thumbnail', 'excerpt', 'custom-fields' ), // 支持 Editor 方便写简单描述
        'show_in_rest'       => true,
    ) );

    // ==========================================================================
    // 4. Solution CPT (应用场景)
    // ==========================================================================
    // 对应模板: single-solution.php (如果需要)
    // URL结构: /solution/automotive/
    register_post_type( 'solution', array(
        'labels' => array(
            'name'               => _x( 'Solutions', 'post type general name', '3d-printing' ),
            'singular_name'      => _x( 'Solution', 'post type singular name', '3d-printing' ),
            'menu_name'          => _x( 'Solutions', 'admin menu', '3d-printing' ),
            'name_admin_bar'     => _x( 'Solution', 'add new on admin bar', '3d-printing' ),
            'add_new'            => _x( 'Add New', 'solution', '3d-printing' ),
            'add_new_item'       => __( 'Add New Solution', '3d-printing' ),
            'new_item'           => __( 'New Solution', '3d-printing' ),
            'edit_item'          => __( 'Edit Solution', '3d-printing' ),
            'view_item'          => __( 'View Solution', '3d-printing' ),
            'all_items'          => __( 'All Solutions', '3d-printing' ),
            'search_items'       => __( 'Search Solutions', '3d-printing' ),
            'parent_item_colon'  => __( 'Parent Solutions:', '3d-printing' ),
            'not_found'          => __( 'No solutions found.', '3d-printing' ),
            'not_found_in_trash' => __( 'No solutions found in Trash.', '3d-printing' )
        ),
        'public'             => true,
        'publicly_queryable' => true,
        'show_ui'            => true,
        'show_in_menu'       => true,
        'show_in_nav_menus'  => true,
        'query_var'          => true,
        'rewrite'            => array( 'slug' => 'solution' ),
        'capability_type'    => 'post',
        'has_archive'        => true,
        'hierarchical'       => false,
        'menu_position'      => 8,
        'menu_icon'          => 'dashicons-lightbulb', // 图标: 解决方案/灯泡
        'supports'           => array( 'title', 'editor', 'thumbnail', 'excerpt', 'custom-fields' ),
        'show_in_rest'       => true,
    ) );
}
