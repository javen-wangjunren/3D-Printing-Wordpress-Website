<?php
/**
 * 推荐文件路径：inc/acf/field/capability-list.php
 * 角色：Capability List (工艺列表模块)
 * 逻辑：展示所有制造工艺，支持标签切换，显示工艺详情和可用材料
 */

if ( function_exists( 'acf_add_local_field_group' ) ) {

    add_action( 'acf/init', function() {

        // 定义字段 Schema
        acf_add_local_field_group( array(
            'key' => 'group_3dp_capability_list',
            'title' => 'Capability List Block (工艺列表配置)',
            'fields' => array(
                
                // ==========================================
                // TAB 1: CONTENT (业务内容)
                // ==========================================
                array(
                    'key' => 'field_cl_tab_content',
                    'label' => 'Content',
                    'type' => 'tab',
                    'placement' => 'top',
                ),
                array(
                    'key' => 'field_cl_section_title',
                    'label' => 'Section Title',
                    'name' => 'section_title',
                    'type' => 'text',
                    'default_value' => 'Manufacturing Capabilities',
                    'placeholder' => '例如：Manufacturing Capabilities',
                ),
                array(
                    'key' => 'field_cl_section_desc',
                    'label' => 'Section Description',
                    'name' => 'section_description',
                    'type' => 'textarea',
                    'rows' => 2,
                    'default_value' => 'Six industrial technologies optimized for prototyping and scalable production.',
                    'placeholder' => '例如：Six industrial technologies optimized for prototyping and scalable production.',
                ),
                
                // --- 工艺列表核心定义 --- 
                array(
                    'key' => 'field_cl_capabilities',
                    'label' => 'Manufacturing Capabilities',
                    'name' => 'capabilities',
                    'type' => 'repeater',
                    'collapsed' => 'field_cl_capability_name',
                    'layout' => 'block',
                    'button_label' => '添加工艺',
                    'sub_fields' => array(
                        // 基础标识
                        array(
                            'key' => 'field_cl_capability_id',
                            'label' => 'Capability ID',
                            'name' => 'capability_id',
                            'type' => 'text',
                            'instructions' => '用于标识工艺的唯一ID，如：sls, mjf, fdm',
                            'required' => 1,
                            'wrapper' => array('width' => '20'),
                        ),
                        array(
                            'key' => 'field_cl_capability_name',
                            'label' => 'Capability Name',
                            'name' => 'name',
                            'type' => 'text',
                            'required' => 1,
                            'instructions' => '工艺的完整名称，如：Selective Laser Sintering',
                            'wrapper' => array('width' => '40'),
                        ),
                        array(
                            'key' => 'field_cl_capability_short',
                            'label' => 'Short Name',
                            'name' => 'short_name',
                            'type' => 'text',
                            'instructions' => '工艺的简称，用于标签显示，如：SLS',
                            'wrapper' => array('width' => '20'),
                        ),
                        
                        // 工艺描述
                        array(
                            'key' => 'field_cl_capability_desc',
                            'label' => 'Description',
                            'name' => 'description',
                            'type' => 'textarea',
                            'rows' => 3,
                            'instructions' => '工艺的详细描述',
                        ),
                        
                        // 工艺参数
                        array(
                            'key' => 'field_cl_capability_specs',
                            'label' => 'Technical Specifications',
                            'name' => 'specs',
                            'type' => 'group',
                            'layout' => 'table',
                            'instructions' => '工艺的技术参数',
                            'sub_fields' => array(
                                array('key' => 'field_cl_spec_build', 'label' => 'Build Volume', 'name' => 'build_volume', 'type' => 'text'),
                                array('key' => 'field_cl_spec_layer', 'label' => 'Layer Height', 'name' => 'layer_height', 'type' => 'text'),
                                array('key' => 'field_cl_spec_tolerance', 'label' => 'Tolerance', 'name' => 'tolerance', 'type' => 'text'),
                                array('key' => 'field_cl_spec_lead', 'label' => 'Lead Time', 'name' => 'lead_time', 'type' => 'text'),
                            ),
                        ),
                        
                        // 可用材料（手动勾选）
                        array(
                            'key' => 'field_cl_capability_materials',
                            'label' => 'Available Materials',
                            'name' => 'materials',
                            'type' => 'relationship',
                            'instructions' => '选择该工艺可用的材料',
                            'post_type' => array('material'),
                            'taxonomy' => '',
                            'filters' => array(
                                0 => 'search',
                                1 => 'post_type',
                            ),
                            'elements' => array(
                                0 => 'featured_image',
                            ),
                            'min' => '',
                            'max' => '',
                            'return_format' => 'object',
                        ),
                        
                        // 设备信息
                        array(
                            'key' => 'field_cl_capability_equipment',
                            'label' => 'Equipment',
                            'name' => 'equipment',
                            'type' => 'text',
                            'instructions' => '使用的设备型号',
                            'placeholder' => '例如：EOS P396 Printer',
                        ),
                        array(
                            'key' => 'field_cl_capability_image',
                            'label' => 'Capability Image',
                            'name' => 'image',
                            'type' => 'image',
                            'return_format' => 'id',
                            'preview_size' => 'medium',
                            'instructions' => '工艺设备的图片',
                        ),
                        
                        // 按钮链接
                        array(
                            'key' => 'field_cl_capability_quote_link',
                            'label' => 'Quote Button Link',
                            'name' => 'quote_link',
                            'type' => 'link',
                            'instructions' => '获取报价按钮的链接',
                            'default_value' => array(
                                'url' => '/quote',
                                'title' => 'Get Instant Quote',
                                'target' => '',
                            ),
                        ),
                        array(
                            'key' => 'field_cl_capability_detail_link',
                            'label' => 'Details Button Link',
                            'name' => 'detail_link',
                            'type' => 'link',
                            'instructions' => '查看详情按钮的链接',
                            'default_value' => array(
                                'url' => '#',
                                'title' => 'Explore Details',
                                'target' => '',
                            ),
                        ),
                    ),
                ),
                
                // ==========================================
                // TAB 2: DESIGN (视觉/响应式)
                // ==========================================
                array(
                    'key' => 'field_cl_tab_design',
                    'label' => 'Design',
                    'type' => 'tab',
                ),
                array(
                    'key' => 'field_cl_bg_color',
                    'label' => 'Background Color',
                    'name' => 'bg_color',
                    'type' => 'color_picker',
                    'default_value' => '#ffffff',
                    'instructions' => '模块的背景颜色',
                    'wrapper' => array('width' => '33'),
                ),
                array(
                    'key' => 'field_cl_text_color',
                    'label' => 'Text Color',
                    'name' => 'text_color',
                    'type' => 'color_picker',
                    'default_value' => '#667085',
                    'instructions' => '模块的文本颜色',
                    'wrapper' => array('width' => '33'),
                ),
                array(
                    'key' => 'field_cl_accent_color',
                    'label' => 'Accent Color',
                    'name' => 'accent_color',
                    'type' => 'color_picker',
                    'default_value' => '#0047AB',
                    'instructions' => '模块的强调色（按钮、激活标签）',
                    'wrapper' => array('width' => '33'),
                ),
                
                // ==========================================
                // TAB 3: SETTINGS (SEO 与辅助)
                // ==========================================
                array(
                    'key' => 'field_cl_tab_settings',
                    'label' => 'Settings',
                    'type' => 'tab',
                ),
                array(
                    'key' => 'field_cl_anchor',
                    'label' => 'Block ID (Anchor)',
                    'name' => 'anchor_id',
                    'type' => 'text',
                    'instructions' => '用于锚点定位，如：#manufacturing-capabilities',
                    'wrapper' => array('width' => '50'),
                ),
            ),
            'location' => array(
                array(
                    array(
                        'param' => 'block',
                        'operator' => '==',
                        'value' => 'acf/capability-list',
                    ),
                ),
            ),
            'style' => 'seamless',
            'instruction_placement' => 'label',
        ) );
    });
}
