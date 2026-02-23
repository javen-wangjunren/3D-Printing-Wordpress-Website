<?php
/**
 * 角色：Universal Comparison Table 字段定义
 * 位置：通用的参数对比表，哪里需要就放哪里
 */

if ( function_exists( 'acf_add_local_field_group' ) ) {

    function _3dp_add_comparison_table_fields() {
        acf_add_local_field_group( array(
            'key' => 'group_3dp_comparison_table',
            'title' => 'Comparison Table (通用对比表配置)',
            'fields' => array(
                
                // ==========================================
                // TAB 1: CONTENT (数据建模)
                // ==========================================
                array(
                    'key' => 'field_ct_tab_content',
                    'label' => 'Content',
                    'type' => 'tab',
                    'placement' => 'top',
                ),
                array(
                    'key' => 'field_ct_title',
                    'label' => 'Table Title',
                    'name' => 'table_title',
                    'type' => 'text',
                    'instructions' => '如：SLS Materials Mechanical Properties Comparison',
                ),
                array(
                    'key' => 'field_ct_description',
                    'label' => 'Table Description',
                    'name' => 'table_description',
                    'type' => 'textarea',
                    'rows' => 2,
                    'instructions' => '显示在标题下方的补充描述文字。',
                ),
                // 旧版字段移除：表头与单列表数据已废弃
                // --- 第二层 (新版)：Data Tabs (分组数据) ---
                array(
                    'key' => 'field_ct_tabs',
                    'label' => 'Data Tabs (分组数据 - 推荐)',
                    'name' => 'comparison_tabs',
                    'type' => 'repeater',
                    'instructions' => '每个分组的“首行”即为该分组的表头（Col1-6）。其余行作为数据行。',
                    'layout' => 'block',
                    'collapsed' => 'field_ct_tab_label',
                    'button_label' => '＋ 添加分组 Tab',
                    'sub_fields' => array(
                        // Tab Label
                        array(
                            'key' => 'field_ct_tab_label',
                            'label' => 'Tab Label',
                            'name' => 'tab_label',
                            'type' => 'text',
                            'required' => 0,
                            'wrapper' => array('width' => '50'),
                        ),
                        array(
                            'key' => 'field_ct_tab_column_count',
                            'label' => 'Columns',
                            'name' => 'tab_column_count',
                            'type' => 'number',
                            'default_value' => 6,
                            'min' => 1,
                            'max' => 6,
                            'wrapper' => array('width' => '50'),
                        ),
                        // Tab Rows (Nested Repeater)
                        array(
                            'key' => 'field_ct_tab_rows',
                            'label' => 'Rows for this Tab',
                            'name' => 'tab_rows',
                            'type' => 'repeater',
                            'layout' => 'table',
                            'button_label' => '＋ 添加该分组下的行',
                            'wrapper' => array('width' => '100'),
                            'min' => 1,
                            'instructions' => '第1行作为表头（Col1-6），至少需要1行。',
                            'sub_fields' => array(
                                array( 'key' => 'field_ct_t_v1', 'label' => 'Val 1', 'name' => 'v1', 'type' => 'text' ),
                                array( 'key' => 'field_ct_t_v2', 'label' => 'Val 2', 'name' => 'v2', 'type' => 'text' ),
                                array( 'key' => 'field_ct_t_v3', 'label' => 'Val 3', 'name' => 'v3', 'type' => 'text' ),
                                array( 'key' => 'field_ct_t_v4', 'label' => 'Val 4', 'name' => 'v4', 'type' => 'text' ),
                                array( 'key' => 'field_ct_t_v5', 'label' => 'Val 5', 'name' => 'v5', 'type' => 'text' ),
                                array( 'key' => 'field_ct_t_v6', 'label' => 'Val 6', 'name' => 'v6', 'type' => 'text' ),
                            ),
                        ),
                    ),
                ),

                // ==========================================
                // TAB 2: DESIGN (视觉逻辑)
                // ==========================================
                array(
                    'key' => 'field_ct_tab_design',
                    'label' => 'Design',
                    'type' => 'tab',
                ),
                array(
                    'key' => 'field_ct_bg_color',
                    'label' => 'Background Color',
                    'name' => 'comparison_table_background_color',
                    'type' => 'color_picker',
                    'wrapper' => array('width' => '50'),
                    'default_value' => '#ffffff',
                ),
                array(
                    'key' => 'field_ct_highlight',
                    'label' => 'Highlight Row (行高亮)',
                    'name' => 'highlight_index',
                    'type' => 'number',
                    'instructions' => '输入需要重点突出的行号（如输入 1 则第一行变黄，模拟图 image_c9c545 效果）。',
                    'wrapper' => array('width' => '50'),
                ),
                array(
                    'key' => 'field_ct_use_mono',
                    'label' => 'Monospace Precision Font',
                    'name' => 'use_mono',
                    'type' => 'true_false',
                    'ui' => 1,
                    'instructions' => '开启后数据列将使用 JetBrains Mono 字体，增强工业严谨感。',
                    'wrapper' => array('width' => '50'),
                ),
                array(
                    'key' => 'field_ct_mobile_compact',
                    'label' => 'Mobile Compact Mode',
                    'name' => 'comparison_mobile_compact_mode',
                    'type' => 'true_false',
                    'ui' => 1,
                    'instructions' => '开启后在移动端减小表格行高和字体，优化阅读体验。',
                ),

                // ==========================================
                // TAB 3: SETTINGS (系统辅助)
                // ==========================================
                array(
                    'key' => 'field_ct_tab_settings',
                    'label' => 'Settings',
                    'type' => 'tab',
                ),
                array(
                    'key' => 'field_ct_anchor',
                    'label' => 'Block Anchor ID',
                    'name' => 'anchor_id',
                    'type' => 'text',
                    'instructions' => '用于锚点定位，如 #mechanical-properties。',
                ),
                array(
                    'key' => 'field_ct_custom_class',
                    'label' => 'Custom CSS Class',
                    'name' => 'comparison_table_custom_class',
                    'type' => 'text',
                    'instructions' => '添加额外的 CSS 类名，用于特殊样式定制。',
                ),
            ),
            'location' => array(
                array(
                    array(
                        'param' => 'block',
                        'operator' => '==',
                        'value' => 'acf/comparison-table',
                    ),
                ),
            ),
            'style' => 'default',
        ) );
    }

    add_action( 'acf/init', '_3dp_add_comparison_table_fields' );
}
