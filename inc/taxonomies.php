<?php
/**
 * Material Taxonomies Registration (材料分类法注册)
 * ==========================================================================
 * 文件作用:
 * 注册与 "Material" (材料) 自定义文章类型 (CPT) 相关的三个核心分类法：
 * 1. Material Process (工艺)
 * 2. Material Type (类型)
 * 3. Material Features (特性)
 *
 * 核心逻辑:
 * - 挂载到 `init` 钩子。
 * - 使用 `register_taxonomy` 注册三个分类法。
 * - 启用 REST API 支持 (`show_in_rest`)，以便在 Gutenberg 编辑器和前端 JS 筛选中使用。
 * - 启用 `hierarchical` (层级结构)，使其行为类似“分类目录”而非“标签”，方便父子关系管理。
 *
 * 架构角色:
 * [Model Layer - Taxonomy]
 * 这些分类法是 "All Materials" 页面筛选功能的基础数据结构。
 * 它们与 ACF 字段配合，实现了前台的多维度筛选 (Facet Search)。
 *
 * 🚨 避坑指南:
 * 1. Rewrite Slug: 修改 `rewrite` 中的 `slug` 后，必须去后台 "设置 -> 固定链接" 点击保存，
 *    否则会出现 404 错误。
 * 2. Hierarchical: 设置为 `true` 允许父子层级，这对于 "Process" (如 3D Printing -> SLS) 很重要。
 * ==========================================================================
 * 
 * @package GeneratePress
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

add_action( 'init', function() {
    
    // ==========================================================================
    // 1. Material Features (材料特性)
    // ==========================================================================
    // 用途: 描述材料的物理/化学特性 (如: 耐高温, 高强度, 柔性)
    // 筛选: 用于 All Materials 页面的侧边栏筛选
    register_taxonomy( 'material_feature', array( 'material' ), array(
        'labels' => array(
            'name'          => 'Material Features',
            'singular_name' => 'Material Feature',
            'menu_name'     => 'Features',
            'all_items'     => 'All Features',
            'edit_item'     => 'Edit Feature',
            'view_item'     => 'View Feature',
            'update_item'   => 'Update Feature',
            'add_new_item'  => 'Add New Feature',
            'new_item_name' => 'New Feature Name',
            'search_items'  => 'Search Features',
        ),
        'public'             => false,
        'publicly_queryable' => false,
        'rewrite'            => false,
        'show_ui'            => true,
        'show_in_menu'       => true,
        'show_in_rest'       => true,
        'query_var'          => true,
        'hierarchical'       => true, // 允许父子级，方便归类
        'show_admin_column' => true, // 在文章列表页显示列
    ) );

    // ==========================================================================
    // 2. Material Process (成型工艺)
    // ==========================================================================
    // 用途: 描述材料适用的 3D 打印工艺 (如: SLS, FDM, SLA)
    // 关键: 此分类法通过 ACF 字段 `taxonomy_linked_capability` 关联到 Capability 文章
    register_taxonomy( 'material_process', array( 'material' ), array(
        'labels' => array(
            'name'          => 'Material Process',
            'singular_name' => 'Material Process',
            'menu_name'     => 'Process',
            'all_items'     => 'All Processes',
            'edit_item'     => 'Edit Process',
            'view_item'     => 'View Process',
            'update_item'   => 'Update Process',
            'add_new_item'  => 'Add New Process',
            'new_item_name' => 'New Process Name',
            'search_items'  => 'Search Processes',
        ),
        'public'             => false,
        'publicly_queryable' => false,
        'rewrite'            => false,
        'show_ui'            => true,
        'show_in_menu'       => true,
        'show_in_rest'       => true,
        'query_var'          => true,
        'hierarchical'       => true,
        'show_admin_column'  => true,
    ) );

    // ==========================================================================
    // 3. Material Type (材料类型)
    // ==========================================================================
    // 用途: 描述材料的化学分类 (如: Nylon, Resin, Metal)
    register_taxonomy( 'material_type', array( 'material', 'surface-finish' ), array(
        'labels' => array(
            'name'          => 'Material Type',
            'singular_name' => 'Material Type',
            'menu_name'     => 'Type',
            'all_items'     => 'All Types',
            'edit_item'     => 'Edit Type',
            'view_item'     => 'View Type',
            'update_item'   => 'Update Type',
            'add_new_item'  => 'Add New Type',
            'new_item_name' => 'New Type Name',
            'search_items'  => 'Search Types',
        ),
        'public'             => false,
        'publicly_queryable' => false,
        'rewrite'            => false,
        'show_ui'            => true,
        'show_in_menu'       => true,
        'show_in_rest'       => true,
        'query_var'          => true,
        'hierarchical'       => true,
        'show_admin_column'  => true,
    ) );

} );
