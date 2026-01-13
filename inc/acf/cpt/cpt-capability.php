<?php
/**
 * 为 Capability CPT 增加页面布局管理字段
 * 用于控制 single-capability.php 页面的模块内容和配置
 */

if ( function_exists( 'acf_add_local_field_group' ) ) {

    add_action( 'acf/init', function() {
        acf_add_local_field_group( array(
            'key' => 'group_3dp_capability_page_layout',
            'title' => 'Capability Page Content (页面内容配置)',
            'fields' => array(
                // ======================================================
                // TAB 1: HERO BANNER (顶部横幅)
                // ======================================================
                array(
                    'key' => 'field_cap_tab_hero',
                    'label' => 'Hero Banner',
                    'type' => 'tab',
                    'placement' => 'top',
                ),
                
                // Hero Banner 内容
                array(
                    'key' => 'field_cap_hero_title',
                    'label' => 'Hero Banner Title',
                    'name' => 'hero_title',
                    'type' => 'text',
                    'default_value' => get_the_title(),
                    'instructions' => 'Hero Banner 的标题，留空则使用工艺名称',
                    'wrapper' => array('width' => '50'),
                ),
                array(
                    'key' => 'field_cap_hero_subtitle',
                    'label' => 'Hero Banner Subtitle',
                    'name' => 'hero_subtitle',
                    'type' => 'text',
                    'instructions' => 'Hero Banner 的副标题',
                    'wrapper' => array('width' => '50'),
                ),
                array(
                    'key' => 'field_cap_hero_content',
                    'label' => 'Hero Banner Content',
                    'name' => 'hero_content',
                    'type' => 'textarea',
                    'rows' => 3,
                    'instructions' => 'Hero Banner 的详细内容',
                ),
                array(
                    'key' => 'field_cap_hero_image',
                    'label' => 'Hero Banner Image',
                    'name' => 'hero_image',
                    'type' => 'image',
                    'return_format' => 'id',
                    'preview_size' => 'medium',
                    'instructions' => 'Hero Banner 的背景图片',
                    'wrapper' => array('width' => '50'),
                ),
                array(
                    'key' => 'field_cap_hero_mobile_image',
                    'label' => 'Hero Banner Mobile Image',
                    'name' => 'hero_mobile_image',
                    'type' => 'image',
                    'return_format' => 'id',
                    'preview_size' => 'medium',
                    'instructions' => 'Hero Banner 的移动端背景图片，留空则使用 PC 端图片',
                    'wrapper' => array('width' => '50'),
                ),
                
                // ======================================================
                // TAB 2: TECHNICAL SPECS (技术规格)
                // ======================================================
                array(
                    'key' => 'field_cap_tab_technical',
                    'label' => 'Technical Specs',
                    'type' => 'tab',
                    'placement' => 'top',
                ),
                
                // 设计指南内容
                array(
                    'key' => 'field_cap_design_guide',
                    'label' => 'Design Guide (设计指南)',
                    'name' => 'capability_design_sections',
                    'type' => 'repeater',
                    'collapsed' => 'field_cap_design_section_title',
                    'layout' => 'block',
                    'button_label' => '添加设计指南章节',
                    'sub_fields' => array(
                        array(
                            'key' => 'field_cap_design_section_title',
                            'label' => 'Section Title (章节标题)',
                            'name' => 'section_heading',
                            'type' => 'text',
                        ),
                        array(
                            'key' => 'field_cap_design_section_content',
                            'label' => 'Section Content (章节内容)',
                            'name' => 'section_content',
                            'type' => 'wysiwyg',
                            'tabs' => 'visual',
                            'media_upload' => 1,
                            'delay' => 1,
                            'instructions' => '设计指南章节的详细内容',
                        ),
                        array(
                            'key' => 'field_cap_design_section_image',
                            'label' => 'Section Image (章节图片)',
                            'name' => 'section_image',
                            'type' => 'image',
                            'return_format' => 'id',
                            'preview_size' => 'medium',
                            'instructions' => '设计指南章节的图片',
                        ),
                        array(
                            'key' => 'field_cap_design_section_tips',
                            'label' => 'Key Tips (关键提示)',
                            'name' => 'section_tips',
                            'type' => 'repeater',
                            'layout' => 'table',
                            'button_label' => '添加提示',
                            'sub_fields' => array(
                                array(
                                    'key' => 'field_cap_design_tip_text',
                                    'label' => 'Tip Text (提示内容)',
                                    'name' => 'tip_text',
                                    'type' => 'text',
                                ),
                            ),
                        ),
                    ),
                ),
                
                // ======================================================
                // TAB 3: MATERIAL LIST (材料列表)
                // ======================================================
                array(
                    'key' => 'field_cap_tab_material',
                    'label' => 'Material List',
                    'type' => 'tab',
                    'placement' => 'top',
                ),
                
                // 材料列表设置
                array(
                    'key' => 'field_cap_material_display_mode',
                    'label' => 'Material Display Mode',
                    'name' => 'material_display_mode',
                    'type' => 'select',
                    'choices' => array(
                        'single' => 'Single-Process Mode (单工艺模式)',
                        'tabs' => 'Multi-Process Mode (带侧边栏 Tab 切换)',
                    ),
                    'default_value' => 'single',
                    'instructions' => '选择材料列表的显示模式，单工艺模式将只显示当前工艺相关的材料',
                    'wrapper' => array('width' => '50'),
                ),
                
                // 材料对比表
                array(
                    'key' => 'field_cap_comparison_table',
                    'label' => 'Comparison Table (材料对比表)',
                    'name' => 'capability_comparison_table',
                    'type' => 'group',
                    'layout' => 'block',
                    'instructions' => '在此配置当前工艺的材料对比表内容',
                    'sub_fields' => array(
                        array(
                            'key' => 'field_cap_ct_title',
                            'label' => 'Table Title',
                            'name' => 'table_title',
                            'type' => 'text',
                            'instructions' => '如：SLS Materials Mechanical Properties Comparison',
                        ),
                        array(
                            'key' => 'field_cap_ct_headers',
                            'label' => 'Table Headers (定义列标题)',
                            'name' => 'headers',
                            'type' => 'group',
                            'layout' => 'table',
                            'instructions' => '在此定义表格的列名。例如：Material, Color, Tensile Strength 等。',
                            'sub_fields' => array(
                                array( 'key' => 'field_cap_ct_h1', 'label' => 'Col 1 (Fixed)', 'name' => 'h1', 'type' => 'text', 'default_value' => 'Material' ),
                                array( 'key' => 'field_cap_ct_h2', 'label' => 'Col 2', 'name' => 'h2', 'type' => 'text' ),
                                array( 'key' => 'field_cap_ct_h3', 'label' => 'Col 3', 'name' => 'h3', 'type' => 'text' ),
                                array( 'key' => 'field_cap_ct_h4', 'label' => 'Col 4', 'name' => 'h4', 'type' => 'text' ),
                                array( 'key' => 'field_cap_ct_h5', 'label' => 'Col 5', 'name' => 'h5', 'type' => 'text' ),
                            ),
                        ),
                        array(
                            'key' => 'field_cap_ct_rows',
                            'label' => 'Table Data Rows (数据行内容)',
                            'name' => 'comparison_rows',
                            'type' => 'repeater',
                            'instructions' => '对应上方定义的表头填入数值。例如在 Val 3 填入 "7.54 ksi"。',
                            'collapsed' => 'field_cap_ct_col1',
                            'layout' => 'table',
                            'button_label' => '添加数据行',
                            'sub_fields' => array(
                                array( 'key' => 'field_cap_ct_col1', 'label' => 'Val 1', 'name' => 'v1', 'type' => 'text' ),
                                array( 'key' => 'field_cap_ct_col2', 'label' => 'Val 2', 'name' => 'v2', 'type' => 'text' ),
                                array( 'key' => 'field_cap_ct_col3', 'label' => 'Val 3', 'name' => 'v3', 'type' => 'text' ),
                                array( 'key' => 'field_cap_ct_col4', 'label' => 'Val 4', 'name' => 'v4', 'type' => 'text' ),
                                array( 'key' => 'field_cap_ct_col5', 'label' => 'Val 5', 'name' => 'v5', 'type' => 'text' ),
                            ),
                        ),
                        array(
                            'key' => 'field_cap_ct_highlight',
                            'label' => 'Highlight Row (行高亮)',
                            'name' => 'highlight_index',
                            'type' => 'number',
                            'instructions' => '输入需要重点突出的行号（如输入 1 则第一行变黄）。',
                            'wrapper' => array('width' => '50'),
                        ),
                        array(
                            'key' => 'field_cap_ct_use_mono',
                            'label' => 'Monospace Precision Font',
                            'name' => 'use_mono',
                            'type' => 'true_false',
                            'ui' => 1,
                            'instructions' => '开启后数据列将使用等宽字体，增强工业严谨感。',
                            'wrapper' => array('width' => '50'),
                        ),
                    ),
                ),
                
                // ======================================================
                // TAB 4: PROCESS (工艺流程)
                // ======================================================
                array(
                    'key' => 'field_cap_tab_process',
                    'label' => 'Process',
                    'type' => 'tab',
                    'placement' => 'top',
                ),
                
                // 工艺流程内容
                array(
                    'key' => 'field_cap_process_title',
                    'label' => 'Process Title',
                    'name' => 'process_title',
                    'type' => 'text',
                    'default_value' => 'How It Works',
                    'instructions' => '工艺流程模块的标题',
                ),
                array(
                    'key' => 'field_cap_process_desc',
                    'label' => 'Process Description',
                    'name' => 'process_description',
                    'type' => 'textarea',
                    'rows' => 2,
                    'instructions' => '工艺流程模块的简短描述',
                ),
                array(
                    'key' => 'field_cap_process_steps',
                    'label' => 'Process Steps (生产步骤)',
                    'name' => 'process_steps',
                    'type' => 'repeater',
                    'collapsed' => 'field_cap_process_step_title',
                    'layout' => 'block',
                    'button_label' => '添加生产步骤',
                    'sub_fields' => array(
                        array(
                            'key' => 'field_cap_process_qc_label',
                            'label' => 'QC Label (左上角标签)',
                            'name' => 'qc_label',
                            'type' => 'text',
                            'wrapper' => array('width' => '50'),
                            'placeholder' => '例如：Automated Powder Distribution',
                        ),
                        array(
                            'key' => 'field_cap_process_step_title',
                            'label' => 'Step Title',
                            'name' => 'title',
                            'type' => 'text',
                            'wrapper' => array('width' => '50'),
                        ),
                        array(
                            'key' => 'field_cap_process_step_image',
                            'label' => 'Step Image (工厂实拍图)',
                            'name' => 'image',
                            'type' => 'image',
                            'return_format' => 'id',
                            'preview_size' => 'medium',
                            'instructions' => '建议使用高对比度深底实拍图。',
                        ),
                        array(
                            'key' => 'field_cap_process_step_desc',
                            'label' => 'Step Description',
                            'name' => 'description',
                            'type' => 'textarea',
                            'rows' => 3,
                        ),
                        array(
                            'key' => 'field_cap_process_data_grid',
                            'label' => 'Data Dashboard (指标网格)',
                            'name' => 'data_grid',
                            'type' => 'repeater',
                            'instructions' => '固定 2 项参数。如：层厚、室温。',
                            'max' => 2,
                            'layout' => 'table',
                            'sub_fields' => array(
                                array(
                                    'key' => 'field_cap_process_data_label',
                                    'label' => 'Label',
                                    'name' => 'label',
                                    'type' => 'text',
                                ),
                                array(
                                    'key' => 'field_cap_process_data_value',
                                    'label' => 'Value',
                                    'name' => 'value',
                                    'type' => 'text',
                                ),
                            ),
                        ),
                        array(
                            'key' => 'field_cap_process_pro_tip',
                            'label' => 'Pro Tip',
                            'name' => 'pro_tip',
                            'type' => 'textarea',
                            'rows' => 2,
                            'placeholder' => '输入针对该步骤的专家建议...',
                        ),
                    ),
                ),
            ),
            'location' => array(
                array(
                    array(
                        'param' => 'post_type',
                        'operator' => '==',
                        'value' => 'capability',
                    ),
                ),
            ),
            'style' => 'seamless',
            'instruction_placement' => 'label',
        ) );
    });
}
