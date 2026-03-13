<?php
/**
 * Page: All Surface Finishes (ACF Configuration)
 * Path: inc/acf/pages/page-all-surface-finish.php
 * ==========================================================================
 * 文件作用:
 * 为 "All Surface Finishes" 页面模板定义专属的 ACF 字段组。
 *
 * 核心逻辑:
 * 1. 匹配规则: 当页面模板选择 "All Surface Finish" (templates/page-all-surface-finish.php) 时加载。
 * 2. 字段结构:
 *    - Tab 1: Hero Section (引用 group_hero_banner Clone)
 *    - Tab 2: Comparison Table (定义表格标题和描述)
 * 3. 界面优化: 隐藏默认的编辑器 (the_content)，强制使用结构化字段。
 *
 * 架构角色:
 * [Data Definition]
 * 定义了页面所需的数据模型，与 templates/page-all-surface-finish.php 配合使用。
 *
 * 🚨 避坑指南:
 * - Location Rule: 必须准确匹配模板路径 'templates/page-all-surface-finish.php'。
 * - Clone Prefix: Hero 区域使用了 prefix_name=1，前端调用需加 'asf_hero_' 前缀。
 * ==========================================================================
 * 
 * @package 3D_Printing
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

if ( function_exists( 'acf_add_local_field_group' ) ) {
    add_action( 'acf/init', function() {
        acf_add_local_field_group( array(
            'key'                   => 'group_page_all_surface_finish',
            'title'                 => __( 'All Surface Finishes Page', '3d-printing' ),
            'location'              => array(
                array(
                    array(
                        'param'    => 'page_template',
                        'operator' => '==',
                        'value'    => 'templates/page-all-surface-finish.php', // 修正: 包含子目录路径
                    ),
                ),
            ),
            'menu_order'            => 0,
            'position'              => 'normal',
            'style'                 => 'default',
            'label_placement'       => 'top',
            'instruction_placement' => 'label',
            'hide_on_screen'        => array(
                0 => 'the_content',
            ),
            'active'                => true,
            'description'           => 'Fields for the Surface Finish comparison page.',
            'fields'                => array(
                // ======================================================
                // TAB 1: HERO SECTION
                // ======================================================
                array(
                    'key'       => 'field_asf_tab_hero',
                    'label'     => 'Hero Section',
                    'type'      => 'tab',
                    'placement' => 'top',
                ),
                array(
                    'key'           => 'field_asf_hero_clone',
                    'label'         => 'Hero Banner',
                    'name'          => 'asf_hero',
                    'type'          => 'clone',
                    'clone'         => array(
                        0 => 'group_hero_banner',
                    ),
                    'display'       => 'group',
                    'prefix_label'  => 0,
                    'prefix_name'   => 1, // 开启前缀，字段名变为 asf_hero_hero_title 等
                ),

                // ======================================================
                // TAB 2: TABLE SECTION
                // ======================================================
                array(
                    'key'       => 'field_asf_tab_table',
                    'label'     => 'Comparison Table',
                    'type'      => 'tab',
                    'placement' => 'top',
                ),
                array(
                    'key'           => 'field_asf_table_title',
                    'label'         => 'Table Title',
                    'name'          => 'asf_table_title',
                    'type'          => 'text',
                    'default_value' => 'Surface <span class="text-primary">Finishing</span>',
                    'instructions'  => 'HTML supported. Use <span class="text-primary"> for blue highlight.',
                ),
                array(
                    'key'           => 'field_asf_table_desc',
                    'label'         => 'Table Description',
                    'name'          => 'asf_table_desc',
                    'type'          => 'textarea',
                    'rows'          => 2,
                    'default_value' => 'Explore our range of post-processing options to achieve the perfect functional and aesthetic requirements for your parts.',
                ),

            ),
        ) );
    } );
}
