<?php
/**
 * 推荐文件路径：inc/acf/specific-field/material-list.php
 * * 工业级 Material List Block 后端定义
 * 包含：三级嵌套内容建模 + 响应式布局控制 + 开发者设置
 */

if ( function_exists( 'acf_add_local_field_group' ) ) {

    add_action( 'acf/init', function() {
        
        acf_add_local_field_group( array(
            'key' => 'group_3dp_material_list',
            'title' => 'Material List Block (材料总览模块)',
            'fields' => array(
                
                // ======================================================
                // TAB 1: CONTENT (内容建模)
                // ======================================================
                array(
                    'key' => 'field_ml_tab_content',
                    'label' => 'Content',
                    'type' => 'tab',
                    'placement' => 'top',
                ),
                array(
                    'key' => 'field_ml_process_list',
                    'label' => 'Process List (工艺大类)',
                    'name' => 'material_list_processes',
                    'type' => 'repeater',
                    'instructions' => '添加 3D 打印工艺分类（如 DMLS, SLA）。',
                    'collapsed' => 'field_ml_process_name',
                    'layout' => 'block', // 释放横向空间
                    'button_label' => '＋ 添加新工艺',
                    'sub_fields' => array(
                        array(
                            'key' => 'field_ml_process_name',
                            'label' => 'Process Name',
                            'name' => 'process_name',
                            'type' => 'text',
                            'required' => 1,
                            'placeholder' => '例如：DMLS (Metal 3D)',
                        ),
                        array(
                            'key' => 'field_ml_material_items',
                            'label' => 'Materials (材料列表)',
                            'name' => 'materials',
                            'type' => 'repeater',
                            'collapsed' => 'field_ml_mat_name',
                            'layout' => 'block',
                            'button_label' => '＋ 添加材料项',
                            'sub_fields' => array(
                                // --- 第一行：基础属性 ---
                                array(
                                    'key' => 'field_ml_mat_name',
                                    'label' => 'Material Name',
                                    'name' => 'name',
                                    'type' => 'text',
                                    'wrapper' => array('width' => '33'),
                                ),
                                array(
                                    'key' => 'field_ml_mat_badge',
                                    'label' => 'Badge',
                                    'name' => 'badge',
                                    'type' => 'text',
                                    'wrapper' => array('width' => '33'),
                                    'instructions' => '如 "AEROSPACE GRADE"',
                                ),
                                array(
                                    'key' => 'field_ml_mat_image',
                                    'label' => 'Image',
                                    'name' => 'image',
                                    'type' => 'image',
                                    'wrapper' => array('width' => '34'),
                                    'return_format' => 'id',
                                    'preview_size' => 'thumbnail',
                                ),
                                // --- 第二行：参数键值对 ---
                                array(
                                    'key' => 'field_ml_mat_specs',
                                    'label' => 'Technical Specs (技术参数)',
                                    'name' => 'spec_table',
                                    'type' => 'repeater',
                                    'instructions' => '建议 1-4 个参数，用于移动端 2x2 网格展示。',
                                    'layout' => 'table',
                                    'wrapper' => array('width' => '100'),
                                    'sub_fields' => array(
                                        array(
                                            'key' => 'field_ml_spec_label',
                                            'label' => 'Label',
                                            'name' => 'label',
                                            'type' => 'text',
                                        ),
                                        array(
                                            'key' => 'field_ml_spec_value',
                                            'label' => 'Value',
                                            'name' => 'value',
                                            'type' => 'text',
                                        ),
                                    ),
                                ),
                                // --- 第三行：详情描述 ---
                                array(
                                    'key' => 'field_ml_mat_content',
                                    'label' => 'Description',
                                    'name' => 'description',
                                    'type' => 'wysiwyg',
                                    'tabs' => 'visual',
                                    'media_upload' => 0,
                                    'delay' => 1,
                                ),
                                // --- 第四行：转化链接 ---
                                array(
                                    'key' => 'field_ml_mat_quote',
                                    'label' => 'Quote Link',
                                    'name' => 'quote_link',
                                    'type' => 'link',
                                    'wrapper' => array('width' => '50'),
                                ),
                                array(
                                    'key' => 'field_ml_mat_specs_link',
                                    'label' => 'Specs Link',
                                    'name' => 'specs_link',
                                    'type' => 'link',
                                    'wrapper' => array('width' => '50'),
                                ),
                            ),
                        ),
                    ),
                ),

                // ======================================================
                // TAB 2: DESIGN (视觉与响应式控制)
                // ======================================================
                array(
                    'key' => 'field_ml_tab_design',
                    'label' => 'Design',
                    'type' => 'tab',
                    'placement' => 'top',
                ),
                array(
                    'key' => 'field_ml_mobile_layout',
                    'label' => 'Mobile Layout (移动端布局)',
                    'name' => 'material_list_mobile_layout',
                    'type' => 'select',
                    'instructions' => '选择移动端下的交互形式。',
                    'choices' => array(
                        'accordion' => '手风琴列表 (上下堆叠)',
                        'tabs_scroll' => '顶部滑动 Tab + 内容区',
                    ),
                    'default_value' => 'accordion',
                    'wrapper' => array('width' => '50'),
                ),
                array(
                    'key' => 'field_ml_mobile_hide_image',
                    'label' => 'Mobile Image Visibility',
                    'name' => 'material_list_hide_image_mobile',
                    'type' => 'true_false',
                    'instructions' => '手机端是否隐藏材料图片以节省空间。',
                    'ui' => 1,
                    'default_value' => 0,
                    'wrapper' => array('width' => '50'),
                ),
                array(
                    'key' => 'field_ml_bg_color',
                    'label' => 'Background Style',
                    'name' => 'material_list_bg_style',
                    'type' => 'select',
                    'choices' => array(
                        'bg-page' => '白色背景',
                        'bg-section' => '浅灰背景 (与页面区分)',
                    ),
                    'default_value' => 'bg-page',
                ),

                // ======================================================
                // TAB 3: SETTINGS (开发者与 SEO)
                // ======================================================
                array(
                    'key' => 'field_ml_tab_settings',
                    'label' => 'Settings',
                    'type' => 'tab',
                    'placement' => 'top',
                ),
                array(
                    'key' => 'field_ml_anchor_id',
                    'label' => 'Block ID',
                    'name' => 'material_list_anchor_id',
                    'type' => 'text',
                    'instructions' => '用于锚点跳转（如 #materials-section）。',
                    'wrapper' => array('width' => '50'),
                ),
                array(
                    'key' => 'field_ml_custom_class',
                    'label' => 'Custom Class',
                    'name' => 'material_list_custom_class',
                    'type' => 'text',
                    'instructions' => '填入额外的 Tailwind 类名。',
                    'wrapper' => array('width' => '50'),
                ),
            ),
            'location' => array(
                array(
                    array(
                        'param' => 'block',
                        'operator' => '==',
                        'value' => 'acf/material-list',
                    ),
                ),
            ),
            'style' => 'seamless',
        ) );
    });
}