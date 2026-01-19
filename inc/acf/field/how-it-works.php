<?php
/**
 * 推荐文件路径：inc/acf/specific-field/how-it-works.php
 * 角色：How It Works (工艺流程步骤模块)
 * 逻辑：进度感知 > 沉浸视觉 > 理性指标 > 专家建议
 * 备注：主要是单个工艺页面用的模块
 */

if ( function_exists( 'acf_add_local_field_group' ) ) {

    add_action( 'acf/init', function() {

        // 定义字段 Schema
        acf_add_local_field_group( array(
            'key' => 'group_3dp_how_it_works',
            'title' => 'How It Works Block (流程步骤配置)',
            'fields' => array(
                
                // ==========================================
                // TAB 1: CONTENT (业务内容)
                // ==========================================
                array(
                    'key' => 'field_hiw_tab_content',
                    'label' => 'Content',
                    'type' => 'tab',
                    'placement' => 'top',
                ),
                array(
                    'key' => 'field_hiw_title',
                    'label' => 'Section Title',
                    'name' => 'title',
                    'type' => 'text',
                    'wrapper' => array('width' => '50'),
                    'placeholder' => '例如：The SLS Manufacturing Process',
                ),
                array(
                    'key' => 'field_hiw_desc',
                    'label' => 'Section Description',
                    'name' => 'desc',
                    'type' => 'textarea',
                    'wrapper' => array('width' => '50'),
                    'rows' => 2,
                ),
                array(
                    'key' => 'field_hiw_steps',
                    'label' => 'Process Steps (生产步骤)',
                    'name' => 'steps',
                    'type' => 'repeater',
                    'collapsed' => 'field_hiw_step_title', // 默认折叠，显示步骤名
                    'layout' => 'block', // 释放横向空间
                    'button_label' => '＋ 添加生产步骤',
                    'sub_fields' => array(
                        // 第一行：基础标识
                        array(
                            'key' => 'field_hiw_qc_label',
                            'label' => 'QC Label (左上角标签)',
                            'name' => 'qc_label',
                            'type' => 'text',
                            'wrapper' => array('width' => '50'),
                            'placeholder' => '例如：Automated Powder Distribution',
                        ),
                        array(
                            'key' => 'field_hiw_step_title',
                            'label' => 'Step Title',
                            'name' => 'title',
                            'type' => 'text',
                            'wrapper' => array('width' => '50'),
                        ),
                        // 第二行：沉浸式视觉
                        array(
                            'key' => 'field_hiw_step_image',
                            'label' => 'Step Image (工厂实拍图)',
                            'name' => 'image',
                            'type' => 'image',
                            'return_format' => 'id',
                            'preview_size' => 'medium',
                            'instructions' => '建议使用高对比度深底实拍图。',
                        ),
                        // 第三行：步骤描述
                        array(
                            'key' => 'field_hiw_step_desc',
                            'label' => 'Step Description',
                            'name' => 'desc',
                            'type' => 'textarea',
                            'rows' => 3,
                        ),
                        // 第四行：数据仪表盘 (Data Dashboard)
                        array(
                            'key' => 'field_hiw_data_grid',
                            'label' => 'Data Dashboard (指标网格)',
                            'name' => 'data_grid',
                            'type' => 'repeater',
                            'instructions' => '固定 2 项参数。如：层厚、室温。',
                            'max' => 2,
                            'layout' => 'table', // 小规模数据使用 Table
                            'collapsed' => 'field_hiw_data_label',
                            'sub_fields' => array(
                                array(
                                    'key' => 'field_hiw_data_label',
                                    'label' => 'Label',
                                    'name' => 'label',
                                    'type' => 'text',
                                ),
                                array(
                                    'key' => 'field_hiw_data_value',
                                    'label' => 'Value',
                                    'name' => 'value',
                                    'type' => 'text',
                                ),
                            ),
                        ),
                        // 第五行：专家建议 (Pro Tip)
                        array(
                            'key' => 'field_hiw_pro_tip',
                            'label' => 'Pro Tip',
                            'name' => 'pro_tip',
                            'type' => 'wysiwyg',
                            'toolbar' => 'basic',
                            'media_upload' => 0,
                            'delay' => 1,
                            'placeholder' => '输入针对该步骤的专家建议...',
                        ),
                    ),
                ),

                // ==========================================
                // TAB 2: DESIGN (视觉/响应式)
                // ==========================================
                array(
                    'key' => 'field_hiw_tab_design',
                    'label' => 'Design',
                    'type' => 'tab',
                ),
                array(
                    'key' => 'field_hiw_mb_hide_tip',
                    'label' => 'Mobile Content Optimization',
                    'name' => 'mb_hide_tip',
                    'type' => 'true_false',
                    'instructions' => '手机端是否隐藏 Pro Tip 以保持简洁。',
                    'ui' => 1,
                    'wrapper' => array('width' => '50'),
                ),
                array(
                    'key' => 'field_hiw_mb_compact_mode',
                    'label' => 'Mobile Compact Mode',
                    'name' => 'mb_compact_mode',
                    'type' => 'true_false',
                    'instructions' => '开启后，手机端仅保留最关键信息，弱化大图和次要文案。',
                    'ui' => 1,
                    'wrapper' => array('width' => '50'),
                ),

                // ==========================================
                // TAB 3: SETTINGS (SEO 与辅助)
                // ==========================================
                array(
                    'key' => 'field_hiw_tab_settings',
                    'label' => 'Settings',
                    'type' => 'tab',
                ),
                array(
                    'key' => 'field_hiw_anchor',
                    'label' => 'Block ID (Anchor)',
                    'name' => 'anchor_id',
                    'type' => 'text',
                    'wrapper' => array('width' => '50'),
                ),
                array(
                    'key' => 'field_hiw_cta_label',
                    'label' => 'Primary Button Label',
                    'name' => 'cta_label',
                    'type' => 'text',
                    'wrapper' => array('width' => '50'),
                    'placeholder' => '例如：Get Quote',
                ),
                array(
                    'key' => 'field_hiw_cta_url',
                    'label' => 'Primary Button Link',
                    'name' => 'cta_url',
                    'type' => 'url',
                    'wrapper' => array('width' => '50'),
                    'instructions' => '留空则使用默认报价页面链接。',
                ),
            ),
            'location' => array( array( array( 'param' => 'block', 'operator' => '==', 'value' => 'acf/how-it-works' ) ) ),
            'style' => 'seamless',
            'instruction_placement' => 'label',
        ) );
    });
}
