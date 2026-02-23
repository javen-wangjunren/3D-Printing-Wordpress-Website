<?php
/**
 * 推荐文件路径：inc/acf/field/capability-list.php
 * 角色：Capability List (工艺列表模块)
 * 逻辑：展示所有制造工艺，支持标签切换。
 *      采用 "Source of Truth" 模式：优先从关联的 Capability Post 读取数据，
 *      同时也允许手动覆盖 (Override)。
 * 位置： 首页介绍所有工艺
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
                    'wrapper' => array('width' => '50'),
                ),
                array(
                    'key' => 'field_cl_section_desc',
                    'label' => 'Section Description',
                    'name' => 'section_description',
                    'type' => 'textarea',
                    'rows' => 2,
                    'default_value' => 'Six industrial technologies optimized for prototyping and scalable production.',
                    'wrapper' => array('width' => '50'),
                ),
                
                // --- 工艺列表核心定义 --- 
                array(
                    'key' => 'field_cl_capabilities',
                    'label' => 'Manufacturing Capabilities',
                    'name' => 'capabilities',
                    'type' => 'repeater',
                    'collapsed' => 'field_cl_capability_source',
                    'layout' => 'block',
                    'button_label' => '添加工艺',
                    'sub_fields' => array(
                        
                        // 1. 数据源选择 (Source of Truth)
                        array(
                            'key' => 'field_cl_capability_source',
                            'label' => 'Capability Source',
                            'name' => 'capability_source',
                            'type' => 'post_object',
                            'post_type' => array('capability'),
                            'return_format' => 'object', 
                            'ui' => 1,
                            'required' => 1,
                            'instructions' => '<b>核心数据源：</b> 必须选择一个 Capability 页面。系统将自动同步其 Title (Tab Name), Description, 和 Materials。<br>Specs (参数) 和 Image (图片) 可以在下方自定义或覆盖。',
                            'wrapper' => array('width' => '50'),
                        ),

                        // 工艺参数 (Manual Only - Structure Refactor)
                        array(
                            'key' => 'field_cl_capability_specs',
                            'label' => 'Technical Specifications',
                            'name' => 'specs',
                            'type' => 'repeater',
                            'layout' => 'table',
                            'instructions' => '自定义技术参数（如 Build Volume, Tolerance 等）。建议 3-4 项。',
                            'button_label' => 'Add Spec',
                            'sub_fields' => array(
                                array(
                                    'key' => 'field_cl_spec_label',
                                    'label' => 'Label',
                                    'name' => 'label',
                                    'type' => 'text',
                                    'placeholder' => 'e.g. Build Volume',
                                ),
                                array(
                                    'key' => 'field_cl_spec_value',
                                    'label' => 'Value',
                                    'name' => 'value',
                                    'type' => 'text',
                                    'placeholder' => 'e.g. 340 x 340 x 600 mm',
                                ),
                            ),
                        ),
                        
                        // 图片 (Auto or Manual)
                        array(
                            'key' => 'field_cl_capability_image',
                            'label' => 'Capability Image',
                            'name' => 'image',
                            'type' => 'image',
                            'return_format' => 'id',
                            'preview_size' => 'medium',
                            'instructions' => '<b>[Override]</b> 强制比例 4:3 (建议 1200x900px)。留空则自动读取 Capability Hero 模块的 Desktop Image。',
                        ),
                        
                        // 按钮链接 (Manual usually, but Detail Link can be auto)
                        array(
                            'key' => 'field_cl_capability_quote_link',
                            'label' => 'Quote Button Link',
                            'name' => 'quote_link',
                            'type' => 'link',
                            'wrapper' => array('width' => '50'),
                            'default_value' => array(
                                'url' => '/quote',
                                'title' => 'Get Instant Quote',
                                'target' => '',
                            ),
                        ),
                        array(
                            'key' => 'field_cl_capability_detail_label',
                            'label' => 'Details Button Label',
                            'name' => 'detail_label',
                            'type' => 'text',
                            'wrapper' => array('width' => '50'),
                            'default_value' => 'Learn More',
                            'placeholder' => 'Learn More',
                            'instructions' => '设置按钮文字。URL 将自动指向所选的 Capability 页面。',
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
                    'key' => 'field_cl_mobile_layout',
                    'label' => 'Mobile Layout',
                    'name' => 'cl_mobile_layout',
                    'type' => 'select',
                    'choices' => array(
                        'tabs_scroll' => 'Horizontal Tabs (Scroll)',
                        'accordion' => 'Accordion (Stacked)',
                    ),
                    'default_value' => 'tabs_scroll',
                    'instructions' => '选择移动端下的交互形式。',
                    'wrapper' => array('width' => '50'),
                ),
                array(
                    'key' => 'field_cl_mobile_compact',
                    'label' => 'Mobile Compact Mode',
                    'name' => 'cl_mobile_compact',
                    'type' => 'true_false',
                    'ui' => 1,
                    'default_value' => 0,
                    'instructions' => '手机端减少内边距，使内容更紧凑。',
                    'wrapper' => array('width' => '50'),
                ),
                array(
                    'key' => 'field_cl_bg_color',
                    'label' => 'Background Color',
                    'name' => 'cl_bg_color',
                    'type' => 'color_picker',
                    'default_value' => '#ffffff',
                    'wrapper' => array('width' => '33'),
                ),
                array(
                    'key' => 'field_cl_text_color',
                    'label' => 'Text Color',
                    'name' => 'cl_text_color',
                    'type' => 'color_picker',
                    'default_value' => '#667085',
                    'wrapper' => array('width' => '33'),
                ),
                array(
                    'key' => 'field_cl_accent_color',
                    'label' => 'Accent Color',
                    'name' => 'cl_accent_color',
                    'type' => 'color_picker',
                    'default_value' => '#0047AB',
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
                    'name' => 'cl_anchor_id',
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
