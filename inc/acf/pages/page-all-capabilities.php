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
                // Hero Banner 字段组（复用 hero-banner.php 的字段结构）
                array(
                    'key' => 'field_allcaps_hero_title',
                    'label' => '主标题',
                    'name' => 'hero_title',
                    'type' => 'text',
                    'required' => 1,
                    'default_value' => 'Your Streamlined 3D Printing Service',
                    'wrapper' => array('width' => '100'),
                ),
                array(
                    'key' => 'field_allcaps_hero_subtitle',
                    'label' => '副标题',
                    'name' => 'hero_subtitle',
                    'type' => 'text',
                    'required' => 1,
                    'default_value' => 'Get Quality Parts at the Best Price',
                    'wrapper' => array('width' => '100'),
                ),
                array(
                    'key' => 'field_allcaps_hero_description',
                    'label' => '描述文本',
                    'name' => 'hero_description',
                    'type' => 'textarea',
                    'required' => 1,
                    'rows' => 4,
                    'default_value' => 'Compare manufacturers around the world in real time.
Order industrial-quality parts at the most competitive price.
We take care of everything, including your satisfaction.',
                    'wrapper' => array('width' => '100'),
                ),
                array(
                    'key' => 'field_allcaps_hero_buttons',
                    'label' => '按钮组',
                    'name' => 'hero_buttons',
                    'type' => 'repeater',
                    'collapsed' => 'field_allcaps_button_text',
                    'min' => 0,
                    'max' => 2,
                    'layout' => 'block',
                    'button_label' => '添加按钮',
                    'sub_fields' => array(
                        array(
                            'key' => 'field_allcaps_button_text',
                            'label' => '按钮文本',
                            'name' => 'button_text',
                            'type' => 'text',
                            'required' => 1,
                            'wrapper' => array('width' => '33'),
                        ),
                        array(
                            'key' => 'field_allcaps_button_url',
                            'label' => '按钮链接',
                            'name' => 'button_url',
                            'type' => 'url',
                            'required' => 1,
                            'wrapper' => array('width' => '50'),
                        ),
                        array(
                            'key' => 'field_allcaps_button_style',
                            'label' => '按钮样式',
                            'name' => 'button_style',
                            'type' => 'select',
                            'choices' => array(
                                'primary' => '主要',
                                'secondary' => '次要',
                            ),
                            'default_value' => 'primary',
                            'wrapper' => array('width' => '17'),
                        ),
                    ),
                ),
                array(
                    'key' => 'field_allcaps_hero_image',
                    'label' => '右侧图片',
                    'name' => 'hero_image',
                    'type' => 'image',
                    'required' => 1,
                    'return_format' => 'id',
                    'preview_size' => 'medium',
                    'wrapper' => array('width' => '50'),
                ),
                array(
                    'key' => 'field_allcaps_hero_mobile_image',
                    'label' => '移动端图片',
                    'name' => 'hero_mobile_image',
                    'type' => 'image',
                    'return_format' => 'id',
                    'preview_size' => 'medium',
                    'instructions' => '可选：移动端专用的图片，如不设置则使用主图片',
                    'wrapper' => array('width' => '50'),
                ),
                // Hero 设计设置
                array(
                    'key' => 'field_allcaps_hero_layout',
                    'label' => '布局样式',
                    'name' => 'hero_layout',
                    'type' => 'select',
                    'choices' => array(
                        'split' => '左文右图',
                        'centered' => '文字居中 + 背景大图',
                    ),
                    'default_value' => 'split',
                    'wrapper' => array('width' => '50'),
                ),
                array(
                    'key' => 'field_allcaps_hero_background_color',
                    'label' => '背景颜色',
                    'name' => 'hero_background_color',
                    'type' => 'color_picker',
                    'default_value' => '#ffffff',
                    'enable_opacity' => 1,
                    'wrapper' => array('width' => '25'),
                ),
                array(
                    'key' => 'field_allcaps_hero_text_color',
                    'label' => '文本颜色',
                    'name' => 'hero_text_color',
                    'type' => 'color_picker',
                    'default_value' => '#000000',
                    'enable_opacity' => 1,
                    'wrapper' => array('width' => '25'),
                ),
                array(
                    'key' => 'field_allcaps_mobile_hide_content',
                    'label' => '移动端隐藏内容',
                    'name' => 'hero_mobile_hide_content',
                    'type' => 'true_false',
                    'ui' => 1,
                    'default_value' => 0,
                    'wrapper' => array('width' => '50'),
                ),
                // Hero 统计数据
                array(
                    'key' => 'field_allcaps_hero_show_stats',
                    'label' => '显示统计数据',
                    'name' => 'hero_show_stats',
                    'type' => 'true_false',
                    'ui' => 1,
                    'default_value' => 1,
                    'wrapper' => array('width' => '50'),
                ),
                array(
                    'key' => 'field_allcaps_hero_stats',
                    'label' => '统计数据',
                    'name' => 'hero_stats',
                    'type' => 'repeater',
                    'conditional_logic' => array(
                        array(
                            array(
                                'field' => 'field_allcaps_hero_show_stats',
                                'operator' => '==',
                                'value' => '1',
                            ),
                        ),
                    ),
                    'collapsed' => 'field_allcaps_stat_number',
                    'min' => 0,
                    'max' => 5,
                    'layout' => 'table',
                    'button_label' => '添加统计数据',
                    'sub_fields' => array(
                        array(
                            'key' => 'field_allcaps_stat_number',
                            'label' => '统计数字',
                            'name' => 'stat_number',
                            'type' => 'text',
                            'required' => 1,
                            'wrapper' => array('width' => '50'),
                        ),
                        array(
                            'key' => 'field_allcaps_stat_description',
                            'label' => '统计描述',
                            'name' => 'stat_description',
                            'type' => 'text',
                            'required' => 1,
                            'wrapper' => array('width' => '50'),
                        ),
                    ),
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
                // Capability List 模块
                array(
                    'key' => 'field_allcaps_capability_section_title',
                    'label' => '工艺列表标题',
                    'name' => 'capability_section_title',
                    'type' => 'text',
                    'default_value' => 'Manufacturing Capabilities',
                    'wrapper' => array('width' => '100'),
                ),
                array(
                    'key' => 'field_allcaps_capability_section_desc',
                    'label' => '工艺列表描述',
                    'name' => 'capability_section_description',
                    'type' => 'textarea',
                    'rows' => 2,
                    'default_value' => 'Six industrial technologies optimized for prototyping and scalable production.',
                    'wrapper' => array('width' => '100'),
                ),
                array(
                    'key' => 'field_allcaps_capabilities',
                    'label' => '制造工艺列表',
                    'name' => 'capabilities',
                    'type' => 'repeater',
                    'collapsed' => 'field_allcaps_capability_name',
                    'layout' => 'block',
                    'button_label' => '添加工艺',
                    'sub_fields' => array(
                        array(
                            'key' => 'field_allcaps_capability_id',
                            'label' => '工艺ID',
                            'name' => 'capability_id',
                            'type' => 'text',
                            'required' => 1,
                            'instructions' => '用于标识工艺的唯一ID，如：sls, mjf, fdm',
                            'wrapper' => array('width' => '20'),
                        ),
                        array(
                            'key' => 'field_allcaps_capability_name',
                            'label' => '工艺名称',
                            'name' => 'capability_name',
                            'type' => 'text',
                            'required' => 1,
                            'instructions' => '工艺的完整名称，如：Selective Laser Sintering',
                            'wrapper' => array('width' => '40'),
                        ),
                        array(
                            'key' => 'field_allcaps_capability_short',
                            'label' => '简称',
                            'name' => 'capability_short_name',
                            'type' => 'text',
                            'instructions' => '工艺的简称，用于标签显示，如：SLS',
                            'wrapper' => array('width' => '20'),
                        ),
                        array(
                            'key' => 'field_allcaps_capability_desc',
                            'label' => '工艺描述',
                            'name' => 'capability_description',
                            'type' => 'textarea',
                            'rows' => 3,
                            'instructions' => '工艺的详细描述',
                            'wrapper' => array('width' => '100'),
                        ),
                        // 技术参数
                        array(
                            'key' => 'field_allcaps_capability_specs',
                            'label' => '技术参数',
                            'name' => 'capability_specs',
                            'type' => 'group',
                            'layout' => 'table',
                            'sub_fields' => array(
                                array('key' => 'field_allcaps_spec_build', 'label' => '成型体积', 'name' => 'build_volume', 'type' => 'text', 'wrapper' => array('width' => '25')),
                                array('key' => 'field_allcaps_spec_layer', 'label' => '层厚', 'name' => 'layer_height', 'type' => 'text', 'wrapper' => array('width' => '25')),
                                array('key' => 'field_allcaps_spec_tolerance', 'label' => '公差', 'name' => 'tolerance', 'type' => 'text', 'wrapper' => array('width' => '25')),
                                array('key' => 'field_allcaps_spec_lead', 'label' => '交付时间', 'name' => 'lead_time', 'type' => 'text', 'wrapper' => array('width' => '25')),
                            ),
                        ),
                        // 可用材料
                        array(
                            'key' => 'field_allcaps_capability_materials',
                            'label' => '可用材料',
                            'name' => 'capability_materials',
                            'type' => 'relationship',
                            'instructions' => '选择该工艺可用的材料',
                            'post_type' => array('material'),
                            'filters' => array('search', 'post_type'),
                            'elements' => array('featured_image'),
                            'return_format' => 'object',
                        ),
                        // 设备信息
                        array(
                            'key' => 'field_allcaps_capability_equipment',
                            'label' => '设备型号',
                            'name' => 'capability_equipment',
                            'type' => 'text',
                            'placeholder' => '例如：EOS P396 Printer',
                            'wrapper' => array('width' => '50'),
                        ),
                        array(
                            'key' => 'field_allcaps_capability_image',
                            'label' => '工艺图片',
                            'name' => 'capability_image',
                            'type' => 'image',
                            'return_format' => 'id',
                            'preview_size' => 'medium',
                            'wrapper' => array('width' => '50'),
                        ),
                        // 按钮链接
                        array(
                            'key' => 'field_allcaps_capability_quote_link',
                            'label' => '获取报价链接',
                            'name' => 'capability_quote_link',
                            'type' => 'link',
                            'wrapper' => array('width' => '50'),
                        ),
                        array(
                            'key' => 'field_allcaps_capability_detail_link',
                            'label' => '查看详情链接',
                            'name' => 'capability_detail_link',
                            'type' => 'link',
                            'wrapper' => array('width' => '50'),
                        ),
                    ),
                ),
                // Comparison Table 模块
                array(
                    'key' => 'field_allcaps_comparison_title',
                    'label' => '对比表标题',
                    'name' => 'comparison_table_title',
                    'type' => 'text',
                    'default_value' => 'SLS Materials Mechanical Properties Comparison',
                    'wrapper' => array('width' => '100'),
                ),
                // 表头定义
                array(
                    'key' => 'field_allcaps_comparison_headers',
                    'label' => '表头定义',
                    'name' => 'comparison_headers',
                    'type' => 'group',
                    'layout' => 'table',
                    'instructions' => '定义表格的列名',
                    'sub_fields' => array(
                        array('key' => 'field_allcaps_h1', 'label' => '列1 (固定)', 'name' => 'h1', 'type' => 'text', 'default_value' => 'Material', 'wrapper' => array('width' => '20')),
                        array('key' => 'field_allcaps_h2', 'label' => '列2', 'name' => 'h2', 'type' => 'text', 'wrapper' => array('width' => '20')),
                        array('key' => 'field_allcaps_h3', 'label' => '列3', 'name' => 'h3', 'type' => 'text', 'wrapper' => array('width' => '20')),
                        array('key' => 'field_allcaps_h4', 'label' => '列4', 'name' => 'h4', 'type' => 'text', 'wrapper' => array('width' => '20')),
                        array('key' => 'field_allcaps_h5', 'label' => '列5', 'name' => 'h5', 'type' => 'text', 'wrapper' => array('width' => '20')),
                    ),
                ),
                // 数据行
                array(
                    'key' => 'field_allcaps_comparison_rows',
                    'label' => '数据行',
                    'name' => 'comparison_rows',
                    'type' => 'repeater',
                    'collapsed' => 'field_allcaps_col1',
                    'layout' => 'table',
                    'button_label' => '添加数据行',
                    'sub_fields' => array(
                        array('key' => 'field_allcaps_col1', 'label' => '值1', 'name' => 'v1', 'type' => 'text', 'wrapper' => array('width' => '20')),
                        array('key' => 'field_allcaps_col2', 'label' => '值2', 'name' => 'v2', 'type' => 'text', 'wrapper' => array('width' => '20')),
                        array('key' => 'field_allcaps_col3', 'label' => '值3', 'name' => 'v3', 'type' => 'text', 'wrapper' => array('width' => '20')),
                        array('key' => 'field_allcaps_col4', 'label' => '值4', 'name' => 'v4', 'type' => 'text', 'wrapper' => array('width' => '20')),
                        array('key' => 'field_allcaps_col5', 'label' => '值5', 'name' => 'v5', 'type' => 'text', 'wrapper' => array('width' => '20')),
                    ),
                ),
                // 对比表设计选项
                array(
                    'key' => 'field_allcaps_comparison_highlight',
                    'label' => '高亮行号',
                    'name' => 'comparison_highlight_row',
                    'type' => 'number',
                    'instructions' => '输入需要重点突出的行号（如输入 1 则第一行高亮）',
                    'wrapper' => array('width' => '50'),
                ),
                array(
                    'key' => 'field_allcaps_comparison_mono_font',
                    'label' => '等宽字体',
                    'name' => 'comparison_use_mono_font',
                    'type' => 'true_false',
                    'ui' => 1,
                    'instructions' => '开启后数据列将使用等宽字体，增强工业严谨感',
                    'wrapper' => array('width' => '50'),
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
                    'key' => 'field_allcaps_material_processes',
                    'label' => '工艺材料列表',
                    'name' => 'material_processes',
                    'type' => 'repeater',
                    'collapsed' => 'field_allcaps_process_name',
                    'layout' => 'block',
                    'button_label' => '添加新工艺',
                    'sub_fields' => array(
                        array(
                            'key' => 'field_allcaps_process_name',
                            'label' => '工艺名称',
                            'name' => 'process_name',
                            'type' => 'text',
                            'required' => 1,
                            'placeholder' => '例如：DMLS (Metal 3D)',
                            'wrapper' => array('width' => '50'),
                        ),
                        array(
                            'key' => 'field_allcaps_material_items',
                            'label' => '材料列表',
                            'name' => 'material_items',
                            'type' => 'repeater',
                            'collapsed' => 'field_allcaps_mat_name',
                            'layout' => 'block',
                            'button_label' => '添加材料项',
                            'sub_fields' => array(
                                // 基础信息
                                array(
                                    'key' => 'field_allcaps_mat_name',
                                    'label' => '材料名称',
                                    'name' => 'material_name',
                                    'type' => 'text',
                                    'wrapper' => array('width' => '33'),
                                ),
                                array(
                                    'key' => 'field_allcaps_mat_badge',
                                    'label' => '标签',
                                    'name' => 'material_badge',
                                    'type' => 'text',
                                    'placeholder' => '如 "AEROSPACE GRADE"',
                                    'wrapper' => array('width' => '33'),
                                ),
                                array(
                                    'key' => 'field_allcaps_mat_image',
                                    'label' => '材料图片',
                                    'name' => 'material_image',
                                    'type' => 'image',
                                    'return_format' => 'id',
                                    'preview_size' => 'thumbnail',
                                    'wrapper' => array('width' => '34'),
                                ),
                                // 技术参数
                                array(
                                    'key' => 'field_allcaps_mat_specs',
                                    'label' => '技术参数',
                                    'name' => 'material_specs',
                                    'type' => 'repeater',
                                    'instructions' => '建议 1-4 个参数，用于移动端 2x2 网格展示',
                                    'min' => 1,
                                    'max' => 4,
                                    'layout' => 'table',
                                    'sub_fields' => array(
                                        array('key' => 'field_allcaps_spec_label', 'label' => '标签', 'name' => 'spec_label', 'type' => 'text', 'wrapper' => array('width' => '50')),
                                        array('key' => 'field_allcaps_spec_value', 'label' => '值', 'name' => 'spec_value', 'type' => 'text', 'wrapper' => array('width' => '50')),
                                    ),
                                ),
                                // 描述和链接
                                array(
                                    'key' => 'field_allcaps_mat_description',
                                    'label' => '材料描述',
                                    'name' => 'material_description',
                                    'type' => 'wysiwyg',
                                    'tabs' => 'visual',
                                    'media_upload' => 0,
                                    'delay' => 1,
                                ),
                                array(
                                    'key' => 'field_allcaps_mat_quote_link',
                                    'label' => '获取报价链接',
                                    'name' => 'material_quote_link',
                                    'type' => 'link',
                                    'wrapper' => array('width' => '50'),
                                ),
                                array(
                                    'key' => 'field_allcaps_mat_specs_link',
                                    'label' => '规格链接',
                                    'name' => 'material_specs_link',
                                    'type' => 'link',
                                    'wrapper' => array('width' => '50'),
                                ),
                            ),
                        ),
                    ),
                ),
                // Material List 设计设置
                array(
                    'key' => 'field_allcaps_material_mobile_layout',
                    'label' => '移动端布局',
                    'name' => 'material_mobile_layout',
                    'type' => 'select',
                    'choices' => array(
                        'accordion' => '手风琴列表 (上下堆叠)',
                        'tabs_scroll' => '顶部滑动 Tab + 内容区',
                    ),
                    'default_value' => 'accordion',
                    'wrapper' => array('width' => '50'),
                ),
                array(
                    'key' => 'field_allcaps_material_display_mode',
                    'label' => '单工艺模式',
                    'name' => 'material_display_mode',
                    'type' => 'true_false',
                    'ui' => 1,
                    'instructions' => '勾选后进入单工艺模式：隐藏侧边栏Tab，仅展示第一个工艺的材料列表',
                    'wrapper' => array('width' => '50'),
                ),
                array(
                    'key' => 'field_allcaps_material_hide_image_mobile',
                    'label' => '移动端隐藏图片',
                    'name' => 'material_hide_image_mobile',
                    'type' => 'true_false',
                    'ui' => 1,
                    'default_value' => 0,
                    'wrapper' => array('width' => '50'),
                ),
                array(
                    'key' => 'field_allcaps_material_bg_style',
                    'label' => '背景样式',
                    'name' => 'material_bg_style',
                    'type' => 'select',
                    'choices' => array(
                        'bg-page' => '白色背景',
                        'bg-section' => '浅灰背景 (与页面区分)',
                    ),
                    'default_value' => 'bg-page',
                    'wrapper' => array('width' => '50'),
                ),
                
                // Surface Finish 模块
                array(
                    'key' => 'field_allcaps_surface_items',
                    'label' => '表面处理工艺',
                    'name' => 'surface_finish_items',
                    'type' => 'repeater',
                    'collapsed' => 'field_allcaps_surface_name',
                    'layout' => 'block',
                    'button_label' => '添加工艺项',
                    'sub_fields' => array(
                        // 筛选标签
                        array(
                            'key' => 'field_allcaps_surface_tech_tags',
                            'label' => '适用技术',
                            'name' => 'surface_tech_tags',
                            'type' => 'select',
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
                            'key' => 'field_allcaps_surface_cat_tags',
                            'label' => '工艺分类',
                            'name' => 'surface_category_tags',
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
                        // 基础信息
                        array(
                            'key' => 'field_allcaps_surface_name',
                            'label' => '工艺名称',
                            'name' => 'surface_name',
                            'type' => 'text',
                            'wrapper' => array('width' => '50'),
                        ),
                        array(
                            'key' => 'field_allcaps_surface_image',
                            'label' => '展示图片',
                            'name' => 'surface_image',
                            'type' => 'image',
                            'return_format' => 'id',
                            'wrapper' => array('width' => '50'),
                        ),
                        // 技术参数网格
                        array(
                            'key' => 'field_allcaps_surface_specs',
                            'label' => '技术参数',
                            'name' => 'surface_specs',
                            'type' => 'repeater',
                            'instructions' => '固定建议 4 项参数，以便在移动端形成 2x2 网格',
                            'min' => 4,
                            'max' => 4,
                            'layout' => 'table',
                            'sub_fields' => array(
                                array('key' => 'field_allcaps_surface_spec_label', 'label' => '标签', 'name' => 'spec_label', 'type' => 'text', 'wrapper' => array('width' => '50')),
                                array('key' => 'field_allcaps_surface_spec_value', 'label' => '值', 'name' => 'spec_value', 'type' => 'text', 'wrapper' => array('width' => '50')),
                            ),
                        ),
                        // 描述和链接
                        array(
                            'key' => 'field_allcaps_surface_description',
                            'label' => '简短描述',
                            'name' => 'surface_description',
                            'type' => 'textarea',
                            'rows' => 2,
                        ),
                        array(
                            'key' => 'field_allcaps_surface_quote_link',
                            'label' => '获取报价链接',
                            'name' => 'surface_quote_link',
                            'type' => 'link',
                            'wrapper' => array('width' => '50'),
                        ),
                        array(
                            'key' => 'field_allcaps_surface_more_link',
                            'label' => '了解更多链接',
                            'name' => 'surface_more_link',
                            'type' => 'link',
                            'wrapper' => array('width' => '50'),
                        ),
                    ),
                ),
                // Surface Finish 设计设置
                array(
                    'key' => 'field_allcaps_surface_pc_columns',
                    'label' => 'PC端列数',
                    'name' => 'surface_pc_columns',
                    'type' => 'select',
                    'choices' => array(
                        'grid-cols-3' => '3列 (瀑布流)',
                        'grid-cols-4' => '4列 (紧凑型)',
                    ),
                    'default_value' => 'grid-cols-3',
                    'wrapper' => array('width' => '50'),
                ),
                array(
                    'key' => 'field_allcaps_surface_mobile_mode',
                    'label' => '移动端显示模式',
                    'name' => 'surface_mobile_mode',
                    'type' => 'select',
                    'choices' => array(
                        'slider' => '交互滑动 (卡片滑动)',
                        'grid' => '紧凑网格 (紧凑网格)',
                    ),
                    'default_value' => 'slider',
                    'wrapper' => array('width' => '50'),
                ),
                array(
                    'key' => 'field_allcaps_surface_hide_specs_mobile',
                    'label' => '移动端隐藏参数',
                    'name' => 'surface_hide_specs_mobile',
                    'type' => 'true_false',
                    'ui' => 1,
                    'default_value' => 0,
                    'instructions' => '在手机端是否隐藏参数网格以简化布局',
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
                // Related Blog 模块 - 特殊实现方式
                array(
                    'key' => 'field_allcaps_related_blog_title',
                    'label' => '相关博客标题',
                    'name' => 'related_blog_title',
                    'type' => 'text',
                    'default_value' => 'Related Resources',
                    'wrapper' => array('width' => '100'),
                ),
                array(
                    'key' => 'field_allcaps_related_blog_description',
                    'label' => '相关博客描述',
                    'name' => 'related_blog_description',
                    'type' => 'textarea',
                    'rows' => 2,
                    'default_value' => 'Learn more about 3D printing technologies and applications',
                    'wrapper' => array('width' => '100'),
                ),
                // 关键：手动挑选博文的 Relationship 字段
                array(
                    'key' => 'field_allcaps_related_blog_posts',
                    'label' => '选择相关博文',
                    'name' => 'related_blog_posts',
                    'type' => 'relationship',
                    'instructions' => '手动挑选要在该页面显示的相关博文',
                    'post_type' => array('post'),
                    'taxonomy' => array(),
                    'filters' => array(
                        0 => 'search',
                        1 => 'taxonomy',
                    ),
                    'elements' => array(
                        0 => 'featured_image',
                    ),
                    'min' => '',
                    'max' => 6,
                    'return_format' => 'object',
                ),
                // Related Blog 显示设置
                array(
                    'key' => 'field_allcaps_related_blog_columns',
                    'label' => '显示列数',
                    'name' => 'related_blog_columns',
                    'type' => 'select',
                    'choices' => array(
                        '3' => '3列',
                        '4' => '4列',
                    ),
                    'default_value' => '3',
                    'wrapper' => array('width' => '50'),
                ),
                array(
                    'key' => 'field_allcaps_related_blog_show_date',
                    'label' => '显示发布日期',
                    'name' => 'related_blog_show_date',
                    'type' => 'true_false',
                    'ui' => 1,
                    'default_value' => 1,
                    'wrapper' => array('width' => '50'),
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
