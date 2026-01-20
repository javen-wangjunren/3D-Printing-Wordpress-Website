<?php
/**
 * 推荐文件路径：inc/acf/pages/page-all-capabilities.php
 * 角色：All Capabilities 页面字段定义
 * 功能：定义所有 capabilities 页面的完整字段结构，包含 Hero、技术对比、材料表面处理等模块
 */

// 确保函数在ACF可用时才执行
if ( function_exists( 'acf_add_local_field_group' ) ) {
    
    add_action('acf/init', function() {
        
        // 主字段组：All Capabilities Page
        acf_add_local_field_group(array(
            'key' => 'group_page_all_capabilities',
            'title' => 'All Capabilities Page (全工艺页面配置)',
            'fields' => array(
                
                // ======================================================
                // TAB 1: Hero Banner
                // ======================================================
                array(
                    'key' => 'field_allcaps_tab_hero',
                    'label' => 'Hero Banner',
                    'type' => 'tab',
                    'placement' => 'top',
                ),
                array(
                    'key' => 'field_allcaps_hero_clone',
                    'label' => 'Hero Banner',
                    'name' => 'all_caps_hero',
                    'type' => 'clone',
                    'clone' => array(
                        0 => 'group_hero_banner',
                    ),
                    'display' => 'group',
                    'prefix_label' => 0,
                    'prefix_name' => 1,
                    'wrapper' => array('width' => '100'),
                ),
                
                // ======================================================
                // TAB 2: Technology & Comparison
                // ======================================================
                array(
                    'key' => 'field_allcaps_tab_tech',
                    'label' => 'Technology & Comparison',
                    'type' => 'tab',
                    'placement' => 'top',
                ),
                array(
                    'key' => 'field_allcaps_capability_clone',
                    'label' => 'Capability List',
                    'name' => 'allcaps_capability_list',
                    'type' => 'clone',
                    'clone' => array(
                        0 => 'group_3dp_capability_list',
                    ),
                    'display' => 'group',
                    'prefix_label' => 0,
                    'prefix_name' => 1,
                    'wrapper' => array('width' => '100'),
                ),
                array(
                    'key' => 'field_allcaps_comparison_clone',
                    'label' => 'Comparison Table',
                    'name' => 'allcaps_comparison',
                    'type' => 'clone',
                    'clone' => array(
                        0 => 'group_3dp_comparison_table',
                    ),
                    'display' => 'group',
                    'prefix_label' => 0,
                    'prefix_name' => 1,
                    'wrapper' => array('width' => '100'),
                ),
                
                // ======================================================
                // TAB 3: Materials & Finishes
                // ======================================================
                array(
                    'key' => 'field_allcaps_tab_materials',
                    'label' => 'Materials & Finishes',
                    'type' => 'tab',
                    'placement' => 'top',
                ),
                // Material List 模块
                array(
                    'key' => 'field_allcaps_material_clone',
                    'label' => 'Material List',
                    'name' => 'allcaps_material_list',
                    'type' => 'clone',
                    'clone' => array(
                        0 => 'group_3dp_material_list',
                    ),
                    'display' => 'group',
                    'prefix_label' => 0,
                    'prefix_name' => 1,
                    'wrapper' => array('width' => '100'),
                ),
                
                // Surface Finish 模块
                array(
                    'key' => 'field_allcaps_surface_clone',
                    'label' => 'Surface Finish',
                    'name' => 'allcaps_surface_finish',
                    'type' => 'clone',
                    'clone' => array(
                        0 => 'group_3dp_surface_finish',
                    ),
                    'display' => 'group',
                    'prefix_label' => 0,
                    'prefix_name' => 1,
                    'wrapper' => array('width' => '100'),
                ),
                
                // ======================================================
                // TAB 4: Content Selection
                // ======================================================
                array(
                    'key' => 'field_allcaps_tab_content_selection',
                    'label' => 'Content Selection',
                    'type' => 'tab',
                    'placement' => 'top',
                ),
                // Related Blog 模块
                array(
                    'key' => 'field_allcaps_related_blog_clone',
                    'label' => 'Related Blog',
                    'name' => 'allcaps_related_blog',
                    'type' => 'clone',
                    'clone' => array(
                        0 => 'group_related_blog',
                    ),
                    'display' => 'group',
                    'prefix_label' => 0,
                    'prefix_name' => 1,
                    'wrapper' => array('width' => '100'),
                ),
            ),
            'location' => array(
                array(
                    array(
                        'param' => 'page_template',
                        'operator' => '==',
                        'value' => 'templates/page-all-capabilities.php',
                    ),
                ),
            
            ),
            'menu_order' => 0,
            'position' => 'normal',
            'style' => 'default',
            'label_placement' => 'top',
            'instruction_placement' => 'label',
            'hide_on_screen' => '',
            'active' => true,
            'description' => '',
            'show_in_rest' => 0,
        ));
        
    });
}
