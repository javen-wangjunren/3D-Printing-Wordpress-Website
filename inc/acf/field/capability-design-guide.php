<?php
/**
 * 角色：Capability Design Guide 模块的字段 Schema 定义
 * 逻辑：金字塔排布 - 核心指标 > 深度规格 > 专家建议
 * 位置：single-capability介绍某个特定工艺的参数信息
 */

if ( function_exists( 'acf_add_local_field_group' ) ) {

    add_action( 'acf/init', function() {

        acf_add_local_field_group( array(
            'key' => 'group_3dp_capability_design_guide',
            'title' => 'Capability Design Guide (工艺参数指南配置)',
            'fields' => array(
                
                // ==========================================
                // TAB 1: CONTENT (业务内容)
                // ==========================================
                array(
                    'key' => 'field_cdg_tab_content',
                    'label' => 'Content',
                    'type' => 'tab',
                    'placement' => 'top',
                ),
                array(
                    'key' => 'field_cdg_title',
                    'label' => 'Section Title',
                    'name' => 'capability_design_guide_title',
                    'type' => 'text',
                    'instructions' => '如：SLS 3D Printing Capabilities',
                    'wrapper' => array('width' => '50'),
                ),
                // 第一层：核心指标金字塔 (4大卡片)
                array(
                    'key' => 'field_cdg_core_specs',
                    'label' => 'Core Metrics Grid (核心指标网格)',
                    'name' => 'capability_design_guide_core_specs',
                    'type' => 'repeater',
                    'instructions' => '放置最大尺寸、层厚、公差等核心决策数据。固定 4 项。',
                    'min' => 4,
                    'max' => 4,
                    'layout' => 'table', // 核心指标建议横向紧凑排列
                    'collapsed' => 'field_cdg_core_label',
                    'sub_fields' => array(
                        array(
                            'key' => 'field_cdg_core_label',
                            'label' => 'Label',
                            'name' => 'label',
                            'type' => 'text',
                            'wrapper' => array('width' => '30'),
                        ),
                        array(
                            'key' => 'field_cdg_core_value',
                            'label' => 'Value',
                            'name' => 'value',
                            'type' => 'text',
                            'instructions' => '前端将强制等宽字体显示',
                            'wrapper' => array('width' => '40'),
                        ),
                        array(
                            'key' => 'field_cdg_core_unit',
                            'label' => 'Unit',
                            'name' => 'unit',
                            'type' => 'text',
                            'wrapper' => array('width' => '30'),
                        ),
                    ),
                ),
                // 第二层：深度规格列表 (详情区)
                array(
                    'key' => 'field_cdg_tech_list',
                    'label' => 'Technical Specs List (详情规格列表)',
                    'name' => 'capability_design_guide_tech_list',
                    'type' => 'repeater',
                    'instructions' => '放置壁厚、特征尺寸等次级技术细节。',
                    'collapsed' => 'field_cdg_tech_label',
                    'layout' => 'table',
                    'button_label' => '＋ 添加技术细节',
                    'sub_fields' => array(
                        array(
                            'key' => 'field_cdg_tech_label',
                            'label' => 'Parameter',
                            'name' => 'label',
                            'type' => 'text',
                        ),
                        array(
                            'key' => 'field_cdg_tech_value',
                            'label' => 'Value',
                            'name' => 'value',
                            'type' => 'text',
                        ),
                    ),
                ),
                // 第三层：交互式专家建议框
                array(
                    'key' => 'field_cdg_advice_group',
                    'label' => 'Expert Advice (工程师建议)',
                    'name' => 'capability_design_guide_advice_group',
                    'type' => 'group',
                    'layout' => 'block',
                    'sub_fields' => array(
                        array(
                            'key' => 'field_cdg_advice_title',
                            'label' => 'Advice Title',
                            'name' => 'title',
                            'type' => 'text',
                            'placeholder' => '如：Design Advice for Deformation Control',
                        ),
                        array(
                            'key' => 'field_cdg_advice_text',
                            'label' => 'Advice Content',
                            'name' => 'text',
                            'type' => 'wysiwyg',
                            'toolbar' => 'basic',
                            'media_upload' => 0,
                            'delay' => 1,
                        ),
                    ),
                ),

                // ==========================================
                // TAB 2: DESIGN (响应式与视觉控制)
                // ==========================================
                array(
                    'key' => 'field_cdg_tab_design',
                    'label' => 'Design',
                    'type' => 'tab',
                ),
                array(
                    'key' => 'field_cdg_mb_mode',
                    'label' => 'Mobile Display Mode',
                    'name' => 'capability_design_guide_mb_mode',
                    'type' => 'select',
                    'choices' => array(
                        'grid' => '2x2 Magnet Grid (磁铁网格)',
                        'stack' => 'Vertical Stack (垂直堆叠)',
                    ),
                    'default_value' => 'grid', // 对应你设计的 2x2 磁铁布局
                    'wrapper' => array('width' => '50'),
                ),
                array(
                    'key' => 'field_cdg_hide_advice_mb',
                    'label' => 'Hide Advice on Mobile',
                    'name' => 'capability_design_guide_hide_advice_mb',
                    'type' => 'true_false',
                    'ui' => 1,
                    'instructions' => '手机端是否隐藏专家建议模块（桌面端仍显示）。',
                    'wrapper' => array('width' => '50'),
                ),

                // ==========================================
                // TAB 3: SETTINGS (SEO 与系统)
                // ==========================================
                array(
                    'key' => 'field_cdg_tab_settings',
                    'label' => 'Settings',
                    'type' => 'tab',
                ),
                array(
                    'key' => 'field_cdg_anchor',
                    'label' => 'Block Anchor ID',
                    'name' => 'capability_design_guide_anchor_id',
                    'type' => 'text',
                    'instructions' => '用于页面内导航',
                    'wrapper' => array('width' => '50'),
                ),
            ),
            'location' => array(
                array(
                    array(
                        'param' => 'block',
                        'operator' => '==',
                        'value' => 'acf/capability-design-guide', // 与 blocks.php 注册名匹配
                    ),
                ),
            ),
            'style' => 'default',
            'instruction_placement' => 'label',
        ) );
    });
}
