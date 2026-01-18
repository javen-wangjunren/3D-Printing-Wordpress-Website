<?php
/**
 * 角色：Material CPT 模块的字段 Schema 定义
 * 位置：/inc/acf/cpt/cpt-material.php
 * 说明：材料自定义post类型的字段逻辑
 */

if ( function_exists( 'acf_add_local_field_group' ) ) {

    add_action( 'acf/init', function() {
        acf_add_local_field_group( array(
            'key'   => 'group_cpt_material_fields',
            'title' => 'Material Fields',
            'fields' => array(
                // ==========================================
                // TAB: Content
                // ==========================================
                array(
                    'key'       => 'field_mat_tab_content',
                    'label'     => 'Content',
                    'type'      => 'tab',
                    'placement' => 'top',
                ),

                // Hero Banner 内容（复用 Hero 模块 Schema）
                array(
                    'key'          => 'field_mat_hero_clone_content',
                    'label'        => 'Hero Content',
                    'name'         => 'mat_hero_content',
                    'type'         => 'clone',
                    'clone'        => array(
                        'field_hero_title',
                        'field_hero_subtitle',
                        'field_hero_description',
                        'field_hero_buttons',
                    ),
                    'display'      => 'seamless',
                    'prefix_label' => 0,
                    'prefix_name'  => 0,
                    'wrapper'      => array( 'width' => '100' ),
                ),

                // Manufacturing Showcase 内容（复用模块 Schema）
                array(
                    'key'          => 'field_mat_mfs_clone_content',
                    'label'        => 'Manufacturing Showcase Content',
                    'name'         => 'mat_mfs_content',
                    'type'         => 'clone',
                    'clone'        => array(
                        'field_mfs_title',
                        'field_mfs_subtitle',
                        'field_mfs_items',
                    ),
                    'display'      => 'seamless',
                    'prefix_label' => 0,
                    'prefix_name'  => 0,
                    'wrapper'      => array( 'width' => '100' ),
                ),

                // Technical Specs 内容（复用模块 Schema）
                array(
                    'key'          => 'field_mat_ts_clone_content',
                    'label'        => 'Technical Specs Content',
                    'name'         => 'mat_ts_content',
                    'type'         => 'clone',
                    'clone'        => array(
                        'field_ts_material_label',
                        'field_ts_intro',
                        'field_ts_tabs',
                    ),
                    'display'      => 'seamless',
                    'prefix_label' => 0,
                    'prefix_name'  => 0,
                    'wrapper'      => array( 'width' => '100' ),
                ),

                // Manufacturing Capabilities 内容（复用模块 Schema）
                array(
                    'key'          => 'field_mat_mcap_clone_content',
                    'label'        => 'Manufacturing Capabilities Content',
                    'name'         => 'mat_mcap_content',
                    'type'         => 'clone',
                    'clone'        => array(
                        'field_mcap_section_title',
                        'field_mcap_intro',
                        'field_mcap_tabs',
                    ),
                    'display'      => 'seamless',
                    'prefix_label' => 0,
                    'prefix_name'  => 0,
                    'wrapper'      => array( 'width' => '100' ),
                ),

                // ==========================================
                // TAB: Design
                // ==========================================
                array(
                    'key'       => 'field_mat_tab_design',
                    'label'     => 'Design',
                    'type'      => 'tab',
                    'placement' => 'top',
                ),

                // Hero 设计与统计条
                array(
                    'key'          => 'field_mat_hero_clone_design',
                    'label'        => 'Hero Design & Stats',
                    'name'         => 'mat_hero_design',
                    'type'         => 'clone',
                    'clone'        => array(
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
                    'display'      => 'seamless',
                    'prefix_label' => 0,
                    'prefix_name'  => 0,
                    'wrapper'      => array( 'width' => '100' ),
                ),

                // Manufacturing Showcase 设计
                array(
                    'key'          => 'field_mat_mfs_clone_design',
                    'label'        => 'Manufacturing Showcase Design',
                    'name'         => 'mat_mfs_design',
                    'type'         => 'clone',
                    'clone'        => array(
                        'field_mfs_layout_mode',
                        'field_mfs_items_per_view',
                        'field_mfs_show_nav',
                        'field_mfs_mobile_compact',
                    ),
                    'display'      => 'seamless',
                    'prefix_label' => 0,
                    'prefix_name'  => 0,
                    'wrapper'      => array( 'width' => '100' ),
                ),

                // Technical Specs 设计
                array(
                    'key'          => 'field_mat_ts_clone_design',
                    'label'        => 'Technical Specs Design',
                    'name'         => 'mat_ts_design',
                    'type'         => 'clone',
                    'clone'        => array(
                        'field_ts_table_mono',
                        'field_ts_mobile_hide_table',
                        'field_ts_table_scroll',
                    ),
                    'display'      => 'seamless',
                    'prefix_label' => 0,
                    'prefix_name'  => 0,
                    'wrapper'      => array( 'width' => '100' ),
                ),

                // Manufacturing Capabilities 设计
                array(
                    'key'          => 'field_mat_mcap_clone_design',
                    'label'        => 'Manufacturing Capabilities Design',
                    'name'         => 'mat_mcap_design',
                    'type'         => 'clone',
                    'clone'        => array(
                        'field_mcap_mobile_compact',
                        'field_mcap_use_mono_font',
                    ),
                    'display'      => 'seamless',
                    'prefix_label' => 0,
                    'prefix_name'  => 0,
                    'wrapper'      => array( 'width' => '100' ),
                ),

                // ==========================================
                // TAB: Settings
                // ==========================================
                array(
                    'key'       => 'field_mat_tab_settings',
                    'label'     => 'Settings',
                    'type'      => 'tab',
                    'placement' => 'top',
                ),

                // Manufacturing Showcase 设置
                array(
                    'key'          => 'field_mat_mfs_clone_settings',
                    'label'        => 'Manufacturing Showcase Settings',
                    'name'         => 'mat_mfs_settings',
                    'type'         => 'clone',
                    'clone'        => array(
                        'field_mfs_anchor',
                        'field_mfs_css_class',
                    ),
                    'display'      => 'seamless',
                    'prefix_label' => 0,
                    'prefix_name'  => 0,
                    'wrapper'      => array( 'width' => '100' ),
                ),

                // Technical Specs 设置
                array(
                    'key'          => 'field_mat_ts_clone_settings',
                    'label'        => 'Technical Specs Settings',
                    'name'         => 'mat_ts_settings',
                    'type'         => 'clone',
                    'clone'        => array(
                        'field_ts_anchor',
                        'field_ts_css_class',
                    ),
                    'display'      => 'seamless',
                    'prefix_label' => 0,
                    'prefix_name'  => 0,
                    'wrapper'      => array( 'width' => '100' ),
                ),

                // Manufacturing Capabilities 设置
                array(
                    'key'          => 'field_mat_mcap_clone_settings',
                    'label'        => 'Manufacturing Capabilities Settings',
                    'name'         => 'mat_mcap_settings',
                    'type'         => 'clone',
                    'clone'        => array(
                        'field_mcap_anchor',
                        'field_mcap_css_class',
                    ),
                    'display'      => 'seamless',
                    'prefix_label' => 0,
                    'prefix_name'  => 0,
                    'wrapper'      => array( 'width' => '100' ),
                ),

                // All Materials 列表筛选配置（保留在 Settings 分区）
                array(
                    'key'       => 'field_mat_msg_listing_filters',
                    'label'     => 'Listing Filters',
                    'type'      => 'message',
                    'message'   => '<h3>Listing Filters (Process / Type / Cost / Lead Time)</h3>',
                    'new_lines' => 'wpautop',
                ),
                array(
                    'key'           => 'field_mat_process',
                    'label'         => 'Process',
                    'name'          => 'material_process',
                    'type'          => 'select',
                    'choices'       => array(),
                    'allow_null'    => 0,
                    'multiple'      => 0,
                    'ui'            => 1,
                    'return_format' => 'value',
                    'wrapper'       => array( 'width' => '33' ),
                ),
                array(
                    'key'           => 'field_mat_type',
                    'label'         => 'Material Type',
                    'name'          => 'material_type',
                    'type'          => 'select',
                    'choices'       => array(),
                    'allow_null'    => 0,
                    'multiple'      => 0,
                    'ui'            => 1,
                    'return_format' => 'value',
                    'wrapper'       => array( 'width' => '33' ),
                ),
                array(
                    'key'           => 'field_mat_cost',
                    'label'         => 'Cost Level',
                    'name'          => 'material_cost_level',
                    'type'          => 'radio',
                    'choices'       => array(
                        '$'    => '$ (Economical)',
                        '$$'   => '$$ (Standard)',
                        '$$$'  => '$$$ (Premium)',
                        '$$$$' => '$$$$ (Enterprise)',
                    ),
                    'layout'        => 'horizontal',
                    'return_format' => 'value',
                    'wrapper'       => array( 'width' => '34' ),
                ),
                array(
                    'key'           => 'field_mat_lead_time',
                    'label'         => 'Lead Time',
                    'name'          => 'material_lead_time',
                    'type'          => 'select',
                    'choices'       => array(
                        'As fast as 1 business day' => 'As fast as 1 business day',
                        '1-2 Days'                   => '1-2 Days',
                        '3-5 Days'                   => '3-5 Days',
                        '7-10 Days'                  => '7-10 Days',
                    ),
                    'allow_null'    => 0,
                    'multiple'      => 0,
                    'ui'            => 0,
                    'return_format' => 'value',
                    'wrapper'       => array( 'width' => '50' ),
                ),
            ),
            'location' => array(
                array(
                    array(
                        'param'    => 'post_type',
                        'operator' => '==',
                        'value'    => 'material',
                    ),
                ),
            ),
            'menu_order'            => 0,
            'position'              => 'normal',
            'style'                 => 'seamless',
            'label_placement'       => 'top',
            'instruction_placement' => 'label',
            'active'                => true,
        ) );
    } );
}
