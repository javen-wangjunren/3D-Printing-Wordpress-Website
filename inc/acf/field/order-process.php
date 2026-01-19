<?php
/**
 * 推荐文件路径：inc/acf/specific-field/order-process.php
 * 工业级 Order Process Block 后端定义
 * 包含：线性步骤流 + 工业风格节点 + 响应式布局控制
 * 备注：全局模块，下单的流程
 */

if ( function_exists( 'acf_add_local_field_group' ) ) {

    add_action( 'acf/init', function() {
        
        acf_add_local_field_group( array(
            'key' => 'group_3dp_order_process',
            'title' => 'Order Process Block (订单流程模块)',
            'fields' => array(
                
                // ======================================================
                // TAB 1: CONTENT (内容建模)
                // ======================================================
                array(
                    'key' => 'field_op_tab_content',
                    'label' => 'Content',
                    'type' => 'tab',
                    'placement' => 'top',
                ),
                array(
                    'key' => 'field_op_section_title',
                    'label' => 'Section Title',
                    'name' => 'order_process_title',
                    'type' => 'text',
                    'instructions' => '如：Prototypes and Parts Made Easy',
                ),
                array(
                    'key' => 'field_op_section_desc',
                    'label' => 'Section Description',
                    'name' => 'order_process_description',
                    'type' => 'textarea',
                    'rows' => 3,
                    'instructions' => '如：Steam guides your engineering team from CAD upload to global delivery with transparent pricing and precision DFM insight.',
                ),
                array(
                    'key' => 'field_op_steps',
                    'label' => 'Process Steps (流程步骤)',
                    'name' => 'order_process_steps',
                    'type' => 'repeater',
                    'instructions' => '添加订单流程的步骤，系统会自动生成带编号的步骤节点。',
                    'collapsed' => 'field_op_step_title',
                    'layout' => 'block',
                    'button_label' => '＋ 添加步骤',
                    'min' => 2,
                    'max' => 6,
                    'sub_fields' => array(
                        array(
                            'key' => 'field_op_step_title',
                            'label' => 'Step Title',
                            'name' => 'title',
                            'type' => 'text',
                            'instructions' => '如：Upload CAD Files',
                            'wrapper' => array('width' => '50'),
                        ),
                        array(
                            'key' => 'field_op_step_icon',
                            'label' => 'Step Icon (SVG)',
                            'name' => 'icon',
                            'type' => 'textarea',
                            'rows' => 4,
                            'instructions' => '请输入完整的 SVG 代码，建议使用 24x24 尺寸。',
                            'wrapper' => array('width' => '50'),
                        ),
                        array(
                            'key' => 'field_op_step_desc',
                            'label' => 'Step Description',
                            'name' => 'description',
                            'type' => 'textarea',
                            'rows' => 3,
                            'instructions' => '如：Securely drag-and-drop STEP, STL, or IGES files for instant versioning and metadata analysis.',
                            'wrapper' => array('width' => '100'),
                        ),
                    ),
                ),
                array(
                    'key' => 'field_op_cta_group',
                    'label' => 'CTA Button (行动号召按钮)',
                    'name' => 'order_process_cta',
                    'type' => 'group',
                    'layout' => 'block',
                    'sub_fields' => array(
                        array(
                            'key' => 'field_op_cta_text',
                            'label' => 'Button Text',
                            'name' => 'text',
                            'type' => 'text',
                            'instructions' => '如：Start Your Instant Quote',
                            'wrapper' => array('width' => '50'),
                        ),
                        array(
                            'key' => 'field_op_cta_link',
                            'label' => 'Button Link',
                            'name' => 'link',
                            'type' => 'link',
                            'wrapper' => array('width' => '50'),
                        ),
                    ),
                ),

                // ======================================================
                // TAB 2: DESIGN (视觉与响应式控制)
                // ======================================================
                array(
                    'key' => 'field_op_tab_design',
                    'label' => 'Design',
                    'type' => 'tab',
                    'placement' => 'top',
                ),
                array(
                    'key' => 'field_op_bg_style',
                    'label' => 'Background Style',
                    'name' => 'order_process_bg_style',
                    'type' => 'select',
                    'choices' => array(
                        'bg-white' => '白色背景',
                        'bg-light' => '浅灰背景 (与页面区分)',
                    ),
                    'default_value' => 'bg-white',
                ),
                array(
                    'key' => 'field_op_active_step',
                    'label' => 'Active Step (默认高亮步骤)',
                    'name' => 'order_process_active_step',
                    'type' => 'number',
                    'instructions' => '输入步骤编号（从1开始），该步骤将在页面加载时默认高亮。',
                    'min' => 1,
                    'default_value' => 1,
                    'wrapper' => array('width' => '50'),
                ),

                // ======================================================
                // TAB 3: SETTINGS (开发者与 SEO)
                // ======================================================
                array(
                    'key' => 'field_op_tab_settings',
                    'label' => 'Settings',
                    'type' => 'tab',
                    'placement' => 'top',
                ),
                array(
                    'key' => 'field_op_anchor_id',
                    'label' => 'Block ID',
                    'name' => 'order_process_anchor_id',
                    'type' => 'text',
                    'instructions' => '用于锚点跳转（如 #order-process）。',
                    'wrapper' => array('width' => '50'),
                ),
                array(
                    'key' => 'field_op_custom_class',
                    'label' => 'Custom Class',
                    'name' => 'order_process_custom_class',
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
                        'value' => 'acf/order-process',
                    ),
                ),
            ),
            'style' => 'seamless',
        ) );
    });
}
