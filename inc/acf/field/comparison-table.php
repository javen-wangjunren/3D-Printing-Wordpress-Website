<?php
/**
 * 角色：Universal Comparison Table 字段定义
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
                // --- 第一层：定义表头标签 (动态表头核心) ---
                array(
                    'key' => 'field_ct_header_group',
                    'label' => 'Table Headers (定义列标题)',
                    'name' => 'headers',
                    'type' => 'group',
                    'layout' => 'table', // 表头定义采用紧凑表格布局
                    'instructions' => '在此定义表格的列名。例如：Material, Color, Tensile Strength 等。',
                    'sub_fields' => array(
                        array( 'key' => 'field_ct_h1', 'label' => 'Col 1 (Fixed)', 'name' => 'h1', 'type' => 'text', 'default_value' => 'Material' ),
                        array( 'key' => 'field_ct_h2', 'label' => 'Col 2', 'name' => 'h2', 'type' => 'text' ),
                        array( 'key' => 'field_ct_h3', 'label' => 'Col 3', 'name' => 'h3', 'type' => 'text' ),
                        array( 'key' => 'field_ct_h4', 'label' => 'Col 4', 'name' => 'h4', 'type' => 'text' ),
                        array( 'key' => 'field_ct_h5', 'label' => 'Col 5', 'name' => 'h5', 'type' => 'text' ),
                    ),
                ),
                // --- 第二层：填入行数据 ---
                array(
                    'key' => 'field_ct_rows',
                    'label' => 'Table Data Rows (数据行内容)',
                    'name' => 'comparison_rows',
                    'type' => 'repeater',
                    'instructions' => '对应上方定义的表头填入数值。例如在 Val 3 填入 "7.54 ksi"。',
                    'collapsed' => 'field_ct_col1',
                    'layout' => 'table', // 每一行在后台也横向显示，模拟真实表格
                    'button_label' => '＋ 添加数据行',
                    'sub_fields' => array(
                        array( 'key' => 'field_ct_col1', 'label' => 'Val 1', 'name' => 'v1', 'type' => 'text' ),
                        array( 'key' => 'field_ct_col2', 'label' => 'Val 2', 'name' => 'v2', 'type' => 'text' ),
                        array( 'key' => 'field_ct_col3', 'label' => 'Val 3', 'name' => 'v3', 'type' => 'text' ),
                        array( 'key' => 'field_ct_col4', 'label' => 'Val 4', 'name' => 'v4', 'type' => 'text' ),
                        array( 'key' => 'field_ct_col5', 'label' => 'Val 5', 'name' => 'v5', 'type' => 'text' ),
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
            'style' => 'seamless',
        ) );
    }

    add_action( 'acf/init', '_3dp_add_comparison_table_fields' );
}