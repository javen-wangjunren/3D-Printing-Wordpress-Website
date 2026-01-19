<?php
/**
 * * 角色：Surface Finish Gallery (表面处理工艺库)
 * 功能：支持多重筛选、视觉对比展示、2x2 参数网格以及响应式交互切换
 * 备注：这个功能模块需要重做，现在过于复杂了，目前是用于all capabilities页面的
 */

if ( function_exists( 'acf_add_local_field_group' ) ) {

    add_action( 'acf/init', function() {

        // 2. 定义字段 Schema
        acf_add_local_field_group( array(
            'key' => 'group_3dp_surface_finish',
            'title' => 'Surface Finish Block (表面处理配置)',
            'fields' => array(
                
                // ==========================================
                // TAB 1: CONTENT (业务内容)
                // ==========================================
                array(
                    'key' => 'field_sf_tab_content',
                    'label' => 'Content',
                    'type' => 'tab',
                    'placement' => 'top',
                ),
                array(
                    'key' => 'field_sf_items',
                    'label' => 'Finish Items (表面处理工艺项)',
                    'name' => 'sf_items',
                    'type' => 'repeater',
                    'instructions' => '添加具体的表面处理工艺。建议每项都包含清晰的对比图。',
                    'collapsed' => 'field_sf_item_name',
                    'layout' => 'block', // 释放横向空间，防止拥挤
                    'button_label' => '＋ 添加工艺项',
                    'sub_fields' => array(
                        // 筛选逻辑层
                        array(
                            'key' => 'field_sf_tech_tags',
                            'label' => 'Technology Tags (一级筛选)',
                            'name' => 'tech_tags',
                            'type' => 'select',
                            'instructions' => '选择该表面处理适用的3D打印技术。',
                            'choices' => array(
                                'sla' => 'SLA (Resin)',
                                'dmls' => 'DMLS (Metal)',
                                'fdm' => 'FDM (Plastic)',
                                'cnc' => 'CNC Machining',
                            ),
                            'multiple' => 1,
                            'ui' => 1,
                            'wrapper' => array('width' => '50'),
                        ),
                        array(
                            'key' => 'field_sf_cat_tags',
                            'label' => 'Category Tags (二级筛选)',
                            'name' => 'category_tags',
                            'type' => 'select',
                            'choices' => array(
                                'enhanced' => 'Enhanced (Appearance)',
                                'protective' => 'Protective (Functional)',
                                'standard' => 'Standard (As-printed)',
                            ),
                            'multiple' => 1,
                            'ui' => 1,
                            'wrapper' => array('width' => '50'),
                        ),
                        // 视觉与基础层
                        array(
                            'key' => 'field_sf_item_name',
                            'label' => 'Finish Name',
                            'name' => 'name',
                            'type' => 'text',
                            'wrapper' => array('width' => '50'),
                        ),
                        array(
                            'key' => 'field_sf_item_image',
                            'label' => 'Finished Image (展示图)',
                            'name' => 'image',
                            'type' => 'image',
                            'wrapper' => array('width' => '50'),
                            'return_format' => 'id',
                        ),
                        // 参数网格 (响应式核心数据)
                        array(
                            'key' => 'field_sf_item_specs',
                            'label' => 'Technical Data Grid',
                            'name' => 'specs',
                            'type' => 'repeater',
                            'instructions' => '固定建议 4 项参数，以便在移动端形成 2x2 网格。',
                            'min' => 4,
                            'max' => 4,
                            'layout' => 'table',
                            'sub_fields' => array(
                                array(
                                    'key' => 'field_sf_spec_label',
                                    'label' => 'Label',
                                    'name' => 'label',
                                    'type' => 'text',
                                ),
                                array(
                                    'key' => 'field_sf_spec_value',
                                    'label' => 'Value',
                                    'name' => 'value',
                                    'type' => 'text',
                                ),
                            ),
                        ),
                        array(
                            'key' => 'field_sf_item_teaser',
                            'label' => 'Short Description',
                            'name' => 'teaser',
                            'type' => 'textarea',
                            'rows' => 2,
                        ),
                        array(
                            'key' => 'field_sf_quote_link',
                            'label' => 'Quote Link',
                            'name' => 'quote_link',
                            'type' => 'link',
                            'wrapper' => array('width' => '50'),
                        ),
                        array(
                            'key' => 'field_sf_more_link',
                            'label' => 'Learn More Link',
                            'name' => 'more_link',
                            'type' => 'link',
                            'wrapper' => array('width' => '50'),
                        ),
                    ),
                ),

                // ==========================================
                // TAB 2: DESIGN (视觉/响应式控制)
                // ==========================================
                array(
                    'key' => 'field_sf_tab_design',
                    'label' => 'Design',
                    'type' => 'tab',
                ),
                array(
                    'key' => 'field_sf_pc_columns',
                    'label' => 'PC Grid Columns',
                    'name' => 'pc_cols',
                    'type' => 'select',
                    'choices' => array(
                        'grid-cols-3' => '3 Columns (瀑布流)',
                        'grid-cols-4' => '4 Columns (紧凑型)',
                    ),
                    'default_value' => 'grid-cols-3',
                    'wrapper' => array('width' => '50'),
                ),
                array(
                    'key' => 'field_sf_mobile_mode',
                    'label' => 'Mobile Display Mode',
                    'name' => 'mobile_layout',
                    'type' => 'select',
                    'choices' => array(
                        'slider' => 'Interactive Slider (卡片滑动)',
                        'grid' => 'Compact Grid (紧凑网格)',
                    ),
                    'default_value' => 'slider', // 默认为交互感更强的滑动模式
                    'wrapper' => array('width' => '50'),
                ),
                array(
                    'key' => 'field_sf_hide_specs_mobile',
                    'label' => 'Mobile Content Control',
                    'name' => 'mobile_hide_specs',
                    'type' => 'true_false',
                    'instructions' => '在手机端是否隐藏参数网格以简化布局。',
                    'ui' => 1,
                    'default_value' => 0,
                ),

                // ==========================================
                // TAB 3: SETTINGS (SEO 与辅助)
                // ==========================================
                array(
                    'key' => 'field_sf_tab_settings',
                    'label' => 'Settings',
                    'type' => 'tab',
                ),
                array(
                    'key' => 'field_sf_anchor_id',
                    'label' => 'Block Anchor ID',
                    'name' => 'anchor_id',
                    'type' => 'text',
                    'instructions' => '设置 HTML ID 以便导航跳转。',
                    'wrapper' => array('width' => '50'),
                ),
                array(
                    'key' => 'field_sf_custom_class',
                    'label' => 'Custom CSS Class',
                    'name' => 'custom_class',
                    'type' => 'text',
                    'instructions' => '填入自定义 Tailwind 类名。',
                    'wrapper' => array('width' => '50'),
                ),
            ),
            'location' => array(
                array(
                    array(
                        'param' => 'block',
                        'operator' => '==',
                        'value' => 'acf/surface-finish',
                    ),
                ),
            ),
            'style' => 'seamless',
        ) );
    });
}