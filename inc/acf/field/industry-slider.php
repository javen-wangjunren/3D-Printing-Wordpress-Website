<?php
/**
 * 推荐文件路径：inc/acf/specific-field/industry-slider.php
 * 角色：Industry Slider (行业解决方案轮播)
 * 逻辑：身份识别 > 视觉实证 > 技术背书 > 场景描述 > 路径导流
 */

if ( function_exists( 'acf_add_local_field_group' ) ) {

    add_action( 'acf/init', function() {

        // 1. 注册积木身份
        acf_register_block_type( array(
            'name'              => 'industry-slider',
            'title'             => __( 'Industry Slider', '3d-printing' ),
            'description'       => __( '展示行业应用案例，包含技术标签背书与解决方案导流。', '3d-printing' ),
            'render_template'   => 'blocks/global/industry-slider/render.php',
            'category'          => 'layout',
            'icon'              => 'images-alt2',
            'keywords'          => array( 'industry', 'slider', 'solutions', 'sls', 'applications' ),
            'mode'              => 'auto', // 宽阔内容区编辑模式
            'align'             => 'full',
            'supports'          => array(
                'align'     => array( 'full' ),
                'anchor'    => true,
                'mode'      => true,
            ),
        ) );

        // 2. 定义字段 Schema
        acf_add_local_field_group( array(
            'key' => 'group_3dp_industry_slider',
            'title' => 'Industry Slider Block (行业应用配置)',
            'fields' => array(
                
                // ==========================================
                // TAB 1: CONTENT (业务内容)
                // ==========================================
                array(
                    'key' => 'field_is_tab_content',
                    'label' => 'Content',
                    'type' => 'tab',
                    'placement' => 'top',
                ),
                array(
                    'key' => 'field_is_section_title',
                    'label' => 'Section Title',
                    'name' => 'title',
                    'type' => 'text',
                    'placeholder' => '例如：SLS Applications Across Industries',
                    'wrapper' => array('width' => '50'),
                ),
                array(
                    'key' => 'field_is_section_desc',
                    'label' => 'Section Description',
                    'name' => 'desc',
                    'type' => 'textarea',
                    'rows' => 2,
                    'wrapper' => array('width' => '50'),
                ),
                array(
                    'key' => 'field_is_items',
                    'label' => 'Industry Items (行业项)',
                    'name' => 'items',
                    'type' => 'repeater',
                    'collapsed' => 'field_is_item_name', // 初始折叠，显示行业名
                    'layout' => 'block', // 释放横向空间
                    'button_label' => '＋ 添加行业案例',
                    'sub_fields' => array(
                        // 第一行：身份与视觉
                        array(
                            'key' => 'field_is_item_name',
                            'label' => 'Industry Name',
                            'name' => 'name',
                            'type' => 'text',
                            'wrapper' => array('width' => '50'),
                        ),
                        array(
                            'key' => 'field_is_item_image',
                            'label' => 'Industry Image',
                            'name' => 'image',
                            'type' => 'image',
                            'return_format' => 'id',
                            'preview_size' => 'medium',
                            'wrapper' => array('width' => '50'),
                        ),
                        // 第二行：技术背书 (嵌套 Repeater)
                        array(
                            'key' => 'field_is_item_tags',
                            'label' => 'Tech Tags (胶囊标签)',
                            'name' => 'tags',
                            'type' => 'repeater',
                            'instructions' => '添加应用类型或性能指标标签。建议 2-3 个。',
                            'layout' => 'table', // 小规模键值对使用 Table 布局
                            'max' => 4,
                            'sub_fields' => array(
                                array(
                                    'key' => 'field_is_tag_text',
                                    'label' => 'Tag Text',
                                    'name' => 'text',
                                    'type' => 'text',
                                ),
                                array(
                                    'key' => 'field_is_tag_type',
                                    'label' => 'Tag Type',
                                    'name' => 'type',
                                    'type' => 'select',
                                    'choices' => array(
                                        'blue' => 'Application (Blue)',
                                        'green' => 'Performance (Green)',
                                    ),
                                ),
                            ),
                        ),
                        // 第三行：描述与导流
                        array(
                            'key' => 'field_is_item_teaser',
                            'label' => 'Scenario Narrative (场景描述)',
                            'name' => 'teaser',
                            'type' => 'textarea',
                            'rows' => 2,
                        ),
                        array(
                            'key' => 'field_is_item_link',
                            'label' => 'CTA Link',
                            'name' => 'link',
                            'type' => 'link',
                        ),
                    ),
                ),

                // ==========================================
                // TAB 2: DESIGN (视觉/响应式)
                // ==========================================
                array(
                    'key' => 'field_is_tab_design',
                    'label' => 'Design',
                    'type' => 'tab',
                ),
                array(
                    'key' => 'field_is_pc_cols',
                    'label' => 'PC Grid Columns',
                    'name' => 'pc_cols',
                    'type' => 'select',
                    'choices' => array(
                        'grid-cols-3' => '3 Columns',
                        'grid-cols-4' => '4 Columns',
                    ),
                    'default_value' => 'grid-cols-4',
                    'wrapper' => array('width' => '50'),
                ),
                array(
                    'key' => 'field_is_mb_hide_teaser',
                    'label' => 'Mobile Style Control',
                    'name' => 'mb_hide_teaser',
                    'type' => 'true_false',
                    'instructions' => '手机端是否隐藏场景描述文案。',
                    'ui' => 1,
                    'wrapper' => array('width' => '50'),
                ),

                // ==========================================
                // TAB 3: SETTINGS (SEO 与辅助)
                // ==========================================
                array(
                    'key' => 'field_is_tab_settings',
                    'label' => 'Settings',
                    'type' => 'tab',
                ),
                array(
                    'key' => 'field_is_anchor',
                    'label' => 'Block ID (Anchor)',
                    'name' => 'anchor_id',
                    'type' => 'text',
                    'wrapper' => array('width' => '50'),
                ),
                array(
                    'key' => 'field_is_class',
                    'label' => 'Custom Class',
                    'name' => 'custom_class',
                    'type' => 'text',
                    'wrapper' => array('width' => '50'),
                ),
            ),
            'location' => array( array( array( 'param' => 'block', 'operator' => '==', 'value' => 'acf/industry-slider' ) ) ),
            'style' => 'seamless',
        ) );
    });
}