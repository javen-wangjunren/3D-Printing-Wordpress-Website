<?php

/**
 * 角色：Manufacturing Showcase (生产案例展示)
 * 备注：主要是在single material页面展示该材料的生产的实际案例
 * 是一个特色版块
 */
if ( function_exists( 'acf_add_local_field_group' ) ) {

    add_action( 'acf/init', function() {
        acf_add_local_field_group( array(
            'key' => 'group_3dp_manufacturing_showcase',
            'title' => 'Manufacturing Showcase (生产案例展示)',
            'fields' => array(

                // TAB: Content
                array(
                    'key' => 'field_mfs_tab_content',
                    'label' => 'Content',
                    'type' => 'tab',
                    'placement' => 'top',
                ),
                array(
                    'key' => 'field_mfs_title',
                    'label' => 'Section Title',
                    'name' => 'manufacturing_showcase_title',
                    'type' => 'text',
                    'instructions' => '如：Production Examples',
                    'required' => 1,
                    'wrapper' => array(
                        'width' => '50',
                    ),
                ),
                array(
                    'key' => 'field_mfs_subtitle',
                    'label' => 'Section Subtitle',
                    'name' => 'manufacturing_showcase_subtitle',
                    'type' => 'textarea',
                    'instructions' => '如：Real-world functional components manufactured with PA 12 Black.',
                    'rows' => 2,
                    'wrapper' => array(
                        'width' => '50',
                    ),
                ),

                // Repeater: Showcase Items
                array(
                    'key' => 'field_mfs_items',
                    'label' => 'Showcase Items',
                    'name' => 'manufacturing_showcase_items',
                    'type' => 'repeater',
                    'instructions' => '为每个生产案例配置图片与文案。',
                    'min' => 1,
                    'max' => 20,
                    'layout' => 'block',
                    'collapsed' => 'field_mfs_item_title',
                    'button_label' => '添加生产案例',
                    'sub_fields' => array(
                        array(
                            'key' => 'field_mfs_item_image',
                            'label' => 'Image',
                            'name' => 'item_image',
                            'type' => 'image',
                            'instructions' => '上传展示图片，如：Automotive Housing。',
                            'return_format' => 'id',
                            'preview_size' => 'medium',
                            'wrapper' => array(
                                'width' => '33',
                            ),
                        ),
                        array(
                            'key' => 'field_mfs_item_mobile_image',
                            'label' => 'Mobile Image',
                            'name' => 'item_mobile_image',
                            'type' => 'image',
                            'instructions' => '可选：移动端优化图片，不填则复用主图。',
                            'return_format' => 'id',
                            'preview_size' => 'medium',
                            'wrapper' => array(
                                'width' => '33',
                            ),
                        ),
                        array(
                            'key' => 'field_mfs_item_title',
                            'label' => 'Title',
                            'name' => 'item_title',
                            'type' => 'text',
                            'instructions' => '如：Automotive Housing、End-of-Arm Tooling。',
                            'required' => 1,
                            'wrapper' => array(
                                'width' => '34',
                            ),
                        ),
                        array(
                            'key' => 'field_mfs_item_badge',
                            'label' => 'Badge Label',
                            'name' => 'item_badge',
                            'type' => 'text',
                            'instructions' => '如：SLS PROCESS（卡片左上角徽标文案）。',
                            'wrapper' => array(
                                'width' => '33',
                            ),
                        ),
                        array(
                            'key' => 'field_mfs_item_subtitle',
                            'label' => 'Subtitle',
                            'name' => 'item_subtitle',
                            'type' => 'text',
                            'instructions' => '如：SLS / Matte Finish / High Temp。',
                            'wrapper' => array(
                                'width' => '50',
                            ),
                        ),
                        array(
                            'key' => 'field_mfs_item_description',
                            'label' => 'Description',
                            'name' => 'item_description',
                            'type' => 'wysiwyg',
                            'tabs' => 'visual',
                            'media_upload' => 0,
                            'delay' => 1,
                            'instructions' => '1-2 句精炼描述，移动端紧凑展示。',
                            'wrapper' => array(
                                'width' => '100',
                            ),
                        ),
                        array(
                            'key' => 'field_mfs_item_link',
                            'label' => 'Optional Link',
                            'name' => 'item_link',
                            'type' => 'link',
                            'instructions' => '可选：跳转到详情案例或相关能力页面。',
                            'wrapper' => array(
                                'width' => '50',
                            ),
                        ),
                    ),
                ),

                // TAB: Design
                array(
                    'key' => 'field_mfs_tab_design',
                    'label' => 'Design',
                    'type' => 'tab',
                    'placement' => 'top',
                ),
                array(
                    'key' => 'field_mfs_layout_mode',
                    'label' => 'Layout Mode',
                    'name' => 'manufacturing_showcase_layout_mode',
                    'type' => 'select',
                    'instructions' => '选择布局模式：滑块或静态网格。',
                    'choices' => array(
                        'slider' => 'Horizontal Slider (滑块)',
                        'grid'   => '3-Column Grid (三列网格)',
                    ),
                    'default_value' => 'slider',
                    'wrapper' => array(
                        'width' => '33',
                    ),
                ),
                array(
                    'key' => 'field_mfs_items_per_view',
                    'label' => 'Items per View (Desktop)',
                    'name' => 'manufacturing_showcase_items_per_view',
                    'type' => 'select',
                    'choices' => array(
                        2 => '2 Items',
                        3 => '3 Items',
                        4 => '4 Items',
                    ),
                    'default_value' => 3,
                    'wrapper' => array(
                        'width' => '33',
                    ),
                ),
                array(
                    'key' => 'field_mfs_show_nav',
                    'label' => 'Show Navigation Arrows',
                    'name' => 'manufacturing_showcase_show_nav',
                    'type' => 'true_false',
                    'ui' => 1,
                    'default_value' => 1,
                    'wrapper' => array(
                        'width' => '34',
                    ),
                ),
                array(
                    'key' => 'field_mfs_mobile_compact',
                    'label' => 'Mobile Compact Mode',
                    'name' => 'manufacturing_showcase_mobile_compact_mode',
                    'type' => 'true_false',
                    'instructions' => '开启后移动端使用“露一张半”的滑动模式。',
                    'ui' => 1,
                    'default_value' => 1,
                    'wrapper' => array(
                        'width' => '50',
                    ),
                ),

                // TAB: Settings
                array(
                    'key' => 'field_mfs_tab_settings',
                    'label' => 'Settings',
                    'type' => 'tab',
                    'placement' => 'top',
                ),
                array(
                    'key' => 'field_mfs_anchor',
                    'label' => 'Block Anchor ID',
                    'name' => 'manufacturing_showcase_anchor_id',
                    'type' => 'text',
                    'instructions' => '用于页面内导航锚点，如：production-examples。',
                    'wrapper' => array(
                        'width' => '50',
                    ),
                ),
                array(
                    'key' => 'field_mfs_css_class',
                    'label' => 'Additional CSS Class',
                    'name' => 'manufacturing_showcase_css_class',
                    'type' => 'text',
                    'instructions' => '可选：附加自定义CSS类名。',
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
                        'value' => 'acf/manufacturing-showcase',
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
