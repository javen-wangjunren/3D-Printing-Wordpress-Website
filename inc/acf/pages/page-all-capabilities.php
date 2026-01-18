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
                    'key' => 'field_allcaps_hero_content_clone',
                    'label' => 'Hero Content',
                    'name' => 'hero_content',
                    'type' => 'clone',
                    'clone' => array(
                        'field_hero_title',
                        'field_hero_subtitle',
                        'field_hero_description',
                        'field_hero_buttons',
                    ),
                    'display' => 'seamless',
                    'prefix_label' => 0,
                    'prefix_name' => 0,
                    'wrapper' => array('width' => '100'),
                ),
                array(
                    'key' => 'field_allcaps_hero_design_clone',
                    'label' => 'Hero Design & Settings',
                    'name' => 'hero_design_settings',
                    'type' => 'clone',
                    'clone' => array(
                        'field_hero_layout',
                        'field_hero_mobile_compact',
                        'field_hero_image',
                        'field_hero_mobile_image',
                        'field_hero_bg_color',
                        'field_hero_text_color',
                        'field_hero_btn_p_color',
                        'field_hero_btn_s_color',
                        'field_hero_show_stats',
                        'field_hero_stats',
                    ),
                    'display' => 'seamless',
                    'prefix_label' => 0,
                    'prefix_name' => 0,
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
                    'key' => 'field_allcaps_capability_clone_content',
                    'label' => 'Capability List Content',
                    'name' => 'capability_list_content',
                    'type' => 'clone',
                    'clone' => array(
                        'field_cl_section_title',
                        'field_cl_section_desc',
                        'field_cl_capabilities',
                    ),
                    'display' => 'seamless',
                    'prefix_label' => 0,
                    'prefix_name' => 0,
                    'wrapper' => array('width' => '100'),
                ),
                array(
                    'key' => 'field_allcaps_capability_clone_design',
                    'label' => 'Capability List Design & Settings',
                    'name' => 'capability_list_design',
                    'type' => 'clone',
                    'clone' => array(
                        'field_cl_bg_color',
                        'field_cl_text_color',
                        'field_cl_accent_color',
                        'field_cl_anchor',
                    ),
                    'display' => 'seamless',
                    'prefix_label' => 0,
                    'prefix_name' => 0,
                    'wrapper' => array('width' => '100'),
                ),
                array(
                    'key' => 'field_allcaps_comparison_clone',
                    'label' => 'Comparison Table',
                    'name' => 'comparison_table_block',
                    'type' => 'clone',
                    'clone' => array(
                        'field_ct_title',
                        'field_ct_header_group',
                        'field_ct_rows',
                        'field_ct_highlight',
                        'field_ct_use_mono',
                        'field_ct_mobile_compact',
                        'field_ct_anchor',
                        'field_ct_custom_class',
                    ),
                    'display' => 'seamless',
                    'prefix_label' => 0,
                    'prefix_name' => 0,
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
                    'key' => 'field_allcaps_material_clone_content',
                    'label' => 'Material List Content',
                    'name' => 'material_list_content',
                    'type' => 'clone',
                    'clone' => array(
                        'field_ml_process_list',
                    ),
                    'display' => 'seamless',
                    'prefix_label' => 0,
                    'prefix_name' => 0,
                    'wrapper' => array('width' => '100'),
                ),
                array(
                    'key' => 'field_allcaps_material_clone_design',
                    'label' => 'Material List Design',
                    'name' => 'material_list_design',
                    'type' => 'clone',
                    'clone' => array(
                        'field_ml_mobile_layout',
                        'field_ml_display_mode',
                        'field_ml_mobile_hide_image',
                        'field_ml_bg_color',
                    ),
                    'display' => 'seamless',
                    'prefix_label' => 0,
                    'prefix_name' => 0,
                    'wrapper' => array('width' => '100'),
                ),
                
                // Surface Finish 模块
                array(
                    'key' => 'field_allcaps_surface_clone_content',
                    'label' => 'Surface Finish Content',
                    'name' => 'surface_finish_content',
                    'type' => 'clone',
                    'clone' => array(
                        'field_sf_items',
                    ),
                    'display' => 'seamless',
                    'prefix_label' => 0,
                    'prefix_name' => 0,
                    'wrapper' => array('width' => '100'),
                ),
                array(
                    'key' => 'field_allcaps_surface_clone_design',
                    'label' => 'Surface Finish Design',
                    'name' => 'surface_finish_design',
                    'type' => 'clone',
                    'clone' => array(
                        'field_sf_pc_columns',
                        'field_sf_mobile_mode',
                        'field_sf_hide_specs_mobile',
                    ),
                    'display' => 'seamless',
                    'prefix_label' => 0,
                    'prefix_name' => 0,
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
                    'key' => 'field_allcaps_related_blog_clone_content',
                    'label' => 'Related Blog Content',
                    'name' => 'related_blog_content',
                    'type' => 'clone',
                    'clone' => array(
                        'field_66e3b0c0f0c8b1f', // blog_title
                        'field_blog_title_highlight',
                        'field_66e3b0c0f0c8b29', // blog_subtitle
                        'field_66e3b0c0f0c8b33', // posts_mode
                        'field_66e3b0c0f0c8b3d', // select_category
                        'field_66e3b0c0f0c8b47', // manual_posts
                        'field_66e3b0c0f0c8b51', // posts_count
                        'field_66e3b0c0f0c8b5b', // button_text
                        'field_66e3b0c0f0c8b65', // button_link
                    ),
                    'display' => 'seamless',
                    'prefix_label' => 0,
                    'prefix_name' => 0,
                    'wrapper' => array('width' => '100'),
                ),
                array(
                    'key' => 'field_allcaps_related_blog_clone_design',
                    'label' => 'Related Blog Design',
                    'name' => 'related_blog_design',
                    'type' => 'clone',
                    'clone' => array(
                        'field_66e3b0c0f0c8b79', // posts_per_row
                        'field_66e3b0c0f0c8b83', // show_excerpt
                        'field_related_blog_mobile_compact',
                        'field_related_blog_mobile_hide_subtitle',
                    ),
                    'display' => 'seamless',
                    'prefix_label' => 0,
                    'prefix_name' => 0,
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
