<?php
/**
 * 备注：这个模块已经不用了，被通用的对比表替代
 * 之前是考虑放在材料页做对比用的
 */


if ( function_exists( 'acf_add_local_field_group' ) ) {
    // 挂载钩子
    add_action('acf/init', function() {
        acf_add_local_field_group( array(
            'key' => 'group_3dp_material_comparison',
            'title' => 'Material Comparison (材料对比配置)',
            'fields' => array(
                
                // ==========================================
                // TAB 1: CONTENT (业务内容)
                // ==========================================
                array(
                    'key' => 'field_mc_tab_content',
                    'label' => 'Content',
                    'type' => 'tab',
                    'placement' => 'top',
                ),
                array(
                    'key' => 'field_mc_title',
                    'label' => 'Section Title',
                    'name' => 'material_comparison_title',
                    'type' => 'text',
                    'instructions' => '如：SLS 3D Printing Materials Comparison',
                    'required' => 1,
                ),
                array(
                    'key' => 'field_mc_intro',
                    'label' => 'Introduction Text',
                    'name' => 'material_comparison_intro',
                    'type' => 'textarea',
                    'instructions' => '简短介绍该工艺的材料选择',
                    'rows' => 3,
                ),
                
                // 顶部导航标签
                array(
                    'key' => 'field_mc_tabs',
                    'label' => 'Material Tabs (材料标签)',
                    'name' => 'material_comparison_tabs',
                    'type' => 'repeater',
                    'instructions' => '定义顶部导航标签，每个标签对应一种材料',
                    'min' => 1,
                    'max' => 10,
                    'layout' => 'block',
                    'collapsed' => 'field_mc_tab_name',
                    'button_label' => '添加标签',
                    'sub_fields' => array(
                        array(
                            'key' => 'field_mc_tab_name',
                            'label' => 'Tab Name',
                            'name' => 'tab_name',
                            'type' => 'text',
                            'instructions' => '材料名称，如：PA12',
                            'required' => 1,
                            'wrapper' => array(
                                'width' => '50',
                            ),
                        ),
                        array(
                            'key' => 'field_mc_tab_slug',
                            'label' => 'Tab Slug',
                            'name' => 'tab_slug',
                            'type' => 'text',
                            'instructions' => '用于URL锚点和CSS类，如：pa12',
                            'required' => 1,
                            'wrapper' => array(
                                'width' => '50',
                            ),
                        ),
                    ),
                ),
                
                // 材料列表
                array(
                    'key' => 'field_mc_materials',
                    'label' => 'Material List (材料列表)',
                    'name' => 'material_comparison_materials',
                    'type' => 'repeater',
                    'instructions' => '定义每种材料的详细信息',
                    'min' => 1,
                    'max' => 10,
                    'layout' => 'block',
                    'collapsed' => 'field_mc_material_name',
                    'button_label' => '添加材料',
                    'sub_fields' => array(
                        array(
                            'key' => 'field_mc_material_name',
                            'label' => 'Material Name',
                            'name' => 'material_name',
                            'type' => 'text',
                            'instructions' => '材料名称，如：PA12 (Nylon 12)',
                            'required' => 1,
                            'wrapper' => array(
                                'width' => '33',
                            ),
                        ),
                        array(
                            'key' => 'field_mc_material_image',
                            'label' => 'Material Image',
                            'name' => 'material_image',
                            'type' => 'image',
                            'instructions' => '材料样本图片',
                            'required' => 1,
                            'return_format' => 'id',
                            'preview_size' => 'medium',
                            'wrapper' => array(
                                'width' => '33',
                            ),
                        ),
                        array(
                            'key' => 'field_mc_material_mobile_image',
                            'label' => 'Mobile Image',
                            'name' => 'material_mobile_image',
                            'type' => 'image',
                            'instructions' => '移动端优化的材料样本图片',
                            'required' => 0,
                            'return_format' => 'id',
                            'preview_size' => 'medium',
                            'wrapper' => array(
                                'width' => '33',
                            ),
                        ),
                        array(
                            'key' => 'field_mc_material_description',
                            'label' => 'Material Description',
                            'name' => 'material_description',
                            'type' => 'textarea',
                            'instructions' => '材料的详细描述',
                            'rows' => 4,
                            'new_lines' => 'wpautop',
                        ),
                        array(
                            'key' => 'field_mc_material_keywords',
                            'label' => 'Key Properties',
                            'name' => 'material_keywords',
                            'type' => 'repeater',
                            'instructions' => '材料的关键属性标签',
                            'min' => 1,
                            'max' => 10,
                            'layout' => 'table',
                            'button_label' => '添加属性',
                            'sub_fields' => array(
                                array(
                                    'key' => 'field_mc_keyword_text',
                                    'label' => 'Keyword',
                                    'name' => 'keyword_text',
                                    'type' => 'text',
                                    'instructions' => '如：High Strength, Heat Resistant',
                                    'required' => 1,
                                ),
                            ),
                        ),
                        array(
                            'key' => 'field_mc_material_applications',
                            'label' => 'Typical Applications',
                            'name' => 'material_applications',
                            'type' => 'textarea',
                            'instructions' => '材料的典型应用场景',
                            'rows' => 3,
                        ),
                    ),
                ),
                
                // 材料属性对比表
                array(
                    'key' => 'field_mc_property_table',
                    'label' => 'Material Properties Table (材料属性对比表)',
                    'name' => 'material_comparison_property_table',
                    'type' => 'repeater',
                    'instructions' => '定义对比表的每一行属性',
                    'min' => 1,
                    'max' => 20,
                    'layout' => 'block',
                    'collapsed' => 'field_mc_property_name',
                    'button_label' => '添加属性行',
                    'sub_fields' => array(
                        array(
                            'key' => 'field_mc_property_name',
                            'label' => 'Property Name',
                            'name' => 'property_name',
                            'type' => 'text',
                            'instructions' => '如：Tensile Strength, Flexural Modulus',
                            'required' => 1,
                            'wrapper' => array(
                                'width' => '30',
                            ),
                        ),
                        array(
                            'key' => 'field_mc_property_unit',
                            'label' => 'Unit',
                            'name' => 'property_unit',
                            'type' => 'text',
                            'instructions' => '如：MPa, °C',
                            'wrapper' => array(
                                'width' => '10',
                            ),
                        ),
                        array(
                            'key' => 'field_mc_property_values',
                            'label' => 'Material Values',
                            'name' => 'property_values',
                            'type' => 'repeater',
                            'instructions' => '为每种材料填写该属性的值',
                            'min' => 1,
                            'max' => 10,
                            'layout' => 'table',
                            'button_label' => '添加材料值',
                            'sub_fields' => array(
                                array(
                                    'key' => 'field_mc_value_material',
                                    'label' => 'Material',
                                    'name' => 'value_material',
                                    'type' => 'text',
                                    'instructions' => '对应材料名称，如：PA12',
                                    'required' => 1,
                                    'wrapper' => array(
                                        'width' => '40',
                                    ),
                                ),
                                array(
                                    'key' => 'field_mc_value',
                                    'label' => 'Value',
                                    'name' => 'value',
                                    'type' => 'text',
                                    'instructions' => '属性值，如：45',
                                    'required' => 1,
                                    'wrapper' => array(
                                        'width' => '40',
                                    ),
                                ),
                                array(
                                    'key' => 'field_mc_value_notes',
                                    'label' => 'Notes',
                                    'name' => 'value_notes',
                                    'type' => 'text',
                                    'instructions' => '额外说明，如：(ISO 527)',
                                    'wrapper' => array(
                                        'width' => '20',
                                    ),
                                ),
                            ),
                        ),
                    ),
                ),

                // ==========================================
                // TAB 2: DESIGN (响应式与视觉控制)
                // ==========================================
                array(
                    'key' => 'field_mc_tab_design',
                    'label' => 'Design',
                    'type' => 'tab',
                    'placement' => 'top',
                ),
                array(
                    'key' => 'field_mc_mobile_layout',
                    'label' => 'Mobile Layout',
                    'name' => 'material_comparison_mobile_layout',
                    'type' => 'select',
                    'instructions' => '移动端材料列表布局',
                    'choices' => array(
                        'grid' => '2 Column Grid (两列网格)',
                        'list' => 'Vertical List (垂直列表)',
                    ),
                    'default_value' => 'list',
                ),
                array(
                    'key' => 'field_mc_hide_comparison_table_mobile',
                    'label' => 'Hide Comparison Table on Mobile',
                    'name' => 'material_comparison_hide_table_mobile',
                    'type' => 'true_false',
                    'instructions' => '在移动端是否隐藏对比表',
                    'ui' => 1,
                    'default_value' => 0,
                ),
                array(
                    'key' => 'field_mc_table_scrollable',
                    'label' => 'Make Table Scrollable',
                    'name' => 'material_comparison_table_scrollable',
                    'type' => 'true_false',
                    'instructions' => '在小屏幕上是否允许表格横向滚动',
                    'ui' => 1,
                    'default_value' => 1,
                ),

                // ==========================================
                // TAB 3: SETTINGS (系统设置)
                // ==========================================
                array(
                    'key' => 'field_mc_tab_settings',
                    'label' => 'Settings',
                    'type' => 'tab',
                    'placement' => 'top',
                ),
                array(
                    'key' => 'field_mc_anchor',
                    'label' => 'Block Anchor ID',
                    'name' => 'material_comparison_anchor_id',
                    'type' => 'text',
                    'instructions' => '用于页面内导航',
                    'wrapper' => array(
                        'width' => '50',
                    ),
                ),
            ),
            'location' => array(
                array(
                    array(
                        'param' => 'block',
                        'operator' => '==',
                        'value' => 'acf/material-comparison',
                    ),
                ),
            ),
            'menu_order' => 0,
            'position' => 'normal',
            'style' => 'seamless',
            'label_placement' => 'top',
            'instruction_placement' => 'label',
            'hide_on_screen' => '',
            'active' => true,
            'description' => '',
        ) );
    });
}
