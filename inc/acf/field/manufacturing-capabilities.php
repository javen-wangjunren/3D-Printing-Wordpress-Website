<?php

/**
 * 角色：Manufacturing Capabilities (制造能力枢纽)
 * 备注：主要是在single material页面展示该材料，支持的工艺和表面处理有哪些
 * 是一个特色版块
 */
if ( function_exists( 'acf_add_local_field_group' ) ) {

    add_action( 'acf/init', function() {
        acf_add_local_field_group( array(
            'key' => 'group_3dp_manufacturing_capabilities',
            'title' => 'Manufacturing Capabilities (制造能力枢纽)',
            'fields' => array(
                array(
                    'key' => 'field_mcap_tab_content',
                    'label' => 'Content',
                    'type' => 'tab',
                    'placement' => 'top',
                ),
                array(
                    'key' => 'field_mcap_section_title',
                    'label' => 'Section Title',
                    'name' => 'manufacturing_capabilities_title',
                    'type' => 'text',
                    'default_value' => 'Manufacturing Capabilities',
                    'wrapper' => array('width' => '50'),
                ),
                array(
                    'key' => 'field_mcap_intro',
                    'label' => 'Introduction',
                    'name' => 'manufacturing_capabilities_intro',
                    'type' => 'textarea',
                    'rows' => 3,
                    'wrapper' => array('width' => '50'),
                ),

                // Tabs (DMLS / SLS ...)
                array(
                    'key' => 'field_mcap_tabs',
                    'label' => 'Capability Tabs',
                    'name' => 'manufacturing_capabilities_tabs',
                    'type' => 'repeater',
                    'layout' => 'block',
                    'collapsed' => 'field_mcap_tab_title',
                    'button_label' => '添加能力标签',
                    'min' => 1,
                    'max' => 8,
                    'sub_fields' => array(
                        array(
                            'key' => 'field_mcap_tab_title',
                            'label' => 'Tab Title',
                            'name' => 'tab_title',
                            'type' => 'text',
                            'wrapper' => array('width' => '40'),
                        ),
                        array(
                            'key' => 'field_mcap_tab_key',
                            'label' => 'Tab Key',
                            'name' => 'tab_key',
                            'type' => 'text',
                            'instructions' => '机器可读key，如：dmls / sls',
                            'wrapper' => array('width' => '30'),
                        ),
                        array(
                            'key' => 'field_mcap_machine',
                            'label' => 'Machine Model',
                            'name' => 'machine_model',
                            'type' => 'text',
                            'default_value' => '',
                            'wrapper' => array('width' => '30'),
                        ),

                        // 左侧信息区：标题/描述
                        array(
                            'key' => 'field_mcap_hub_title',
                            'label' => 'Hub Title',
                            'name' => 'hub_title',
                            'type' => 'text',
                            'wrapper' => array('width' => '50'),
                        ),
                        array(
                            'key' => 'field_mcap_hub_desc',
                            'label' => 'Hub Description',
                            'name' => 'hub_desc',
                            'type' => 'textarea',
                            'rows' => 3,
                            'wrapper' => array('width' => '50'),
                        ),

                        // 高亮指标卡片（3个）
                        array(
                            'key' => 'field_mcap_highlights',
                            'label' => 'Highlight Cards',
                            'name' => 'highlights',
                            'type' => 'repeater',
                            'layout' => 'block',
                            'collapsed' => 'field_mcap_hl_title',
                            'min' => 1,
                            'max' => 4,
                            'button_label' => '添加高亮指标',
                            'sub_fields' => array(
                                array(
                                    'key' => 'field_mcap_hl_title',
                                    'label' => 'Title',
                                    'name' => 'title',
                                    'type' => 'text',
                                    'wrapper' => array('width' => '40'),
                                ),
                                array(
                                    'key' => 'field_mcap_hl_value',
                                    'label' => 'Value',
                                    'name' => 'value',
                                    'type' => 'text',
                                    'wrapper' => array('width' => '30'),
                                ),
                                array(
                                    'key' => 'field_mcap_hl_unit',
                                    'label' => 'Unit',
                                    'name' => 'unit',
                                    'type' => 'text',
                                    'wrapper' => array('width' => '30'),
                                ),
                                array(
                                    'key' => 'field_mcap_hl_tag',
                                    'label' => 'Small Tag',
                                    'name' => 'tag',
                                    'type' => 'text',
                                    'instructions' => '卡片左上角类别标签，如：DMLS / SLS',
                                    'wrapper' => array('width' => '30'),
                                ),
                            ),
                        ),

                        // 可用后处理标签
                        array(
                            'key' => 'field_mcap_tags',
                            'label' => 'Available Finishing Tags',
                            'name' => 'finishing_tags',
                            'type' => 'repeater',
                            'layout' => 'table',
                            'collapsed' => 'field_mcap_tag_text',
                            'button_label' => '添加标签',
                            'sub_fields' => array(
                                array(
                                    'key' => 'field_mcap_tag_text',
                                    'label' => 'Tag Text',
                                    'name' => 'text',
                                    'type' => 'text',
                                ),
                            ),
                        ),

                        // 跳转链接
                        array(
                            'key' => 'field_mcap_link',
                            'label' => 'CTA Link',
                            'name' => 'cta_link',
                            'type' => 'link',
                            'wrapper' => array('width' => '50'),
                        ),

                        // 右侧大图（含移动端）
                        array(
                            'key' => 'field_mcap_image',
                            'label' => 'Right Image',
                            'name' => 'image',
                            'type' => 'image',
                            'return_format' => 'id',
                            'preview_size' => 'medium',
                            'wrapper' => array('width' => '50'),
                        ),
                        array(
                            'key' => 'field_mcap_mobile_image',
                            'label' => 'Mobile Image',
                            'name' => 'mobile_image',
                            'type' => 'image',
                            'instructions' => '可选：移动端专用图片，不填则复用主图',
                            'return_format' => 'id',
                            'preview_size' => 'medium',
                            'wrapper' => array('width' => '50'),
                        ),
                    ),
                ),

                array(
                    'key' => 'field_mcap_tab_design',
                    'label' => 'Design',
                    'type' => 'tab',
                    'placement' => 'top',
                ),
                array(
                    'key' => 'field_mcap_bg_color',
                    'label' => 'Background Color',
                    'name' => 'manufacturing_capabilities_background_color',
                    'type' => 'color_picker',
                    'wrapper' => array('width' => '50'),
                    'default_value' => '#ffffff',
                ),
                array(
                    'key' => 'field_mcap_mobile_compact',
                    'label' => 'Mobile Compact Mode',
                    'name' => 'manufacturing_capabilities_mobile_compact_mode',
                    'type' => 'true_false',
                    'ui' => 1,
                    'default_value' => 1,
                    'wrapper' => array('width' => '50'),
                ),
                array(
                    'key' => 'field_mcap_use_mono_font',
                    'label' => 'Use Mono Font For Values',
                    'name' => 'manufacturing_capabilities_use_mono_font',
                    'type' => 'true_false',
                    'ui' => 1,
                    'default_value' => 1,
                    'wrapper' => array('width' => '50'),
                ),

                array(
                    'key' => 'field_mcap_tab_settings',
                    'label' => 'Settings',
                    'type' => 'tab',
                    'placement' => 'top',
                ),
                array(
                    'key' => 'field_mcap_anchor',
                    'label' => 'Block Anchor ID',
                    'name' => 'manufacturing_capabilities_anchor_id',
                    'type' => 'text',
                    'wrapper' => array('width' => '50'),
                ),
                array(
                    'key' => 'field_mcap_css_class',
                    'label' => 'Additional CSS Class',
                    'name' => 'manufacturing_capabilities_css_class',
                    'type' => 'text',
                    'wrapper' => array('width' => '50'),
                ),
            ),
            'location' => array(
                array(
                    array(
                        'param' => 'block',
                        'operator' => '==',
                        'value' => 'acf/manufacturing-capabilities',
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
        ) );
    } );
}

