<?php
if ( function_exists( 'acf_add_local_field_group' ) ) {

    add_action( 'acf/init', function() {
        acf_add_local_field_group( array(
            'key' => 'group_3dp_technical_specs',
            'title' => 'Technical Specs (技术规格面板)',
            'fields' => array(
                array(
                    'key' => 'field_ts_tab_content',
                    'label' => 'Content',
                    'type' => 'tab',
                    'placement' => 'top',
                ),
                array(
                    'key' => 'field_ts_material_label',
                    'label' => 'Material Label',
                    'name' => 'technical_specs_material_label',
                    'type' => 'text',
                    'wrapper' => array(
                        'width' => '50',
                    ),
                ),
                array(
                    'key' => 'field_ts_intro',
                    'label' => 'Introduction',
                    'name' => 'technical_specs_intro',
                    'type' => 'textarea',
                    'rows' => 3,
                    'wrapper' => array(
                        'width' => '50',
                    ),
                ),
                array(
                    'key' => 'field_ts_tabs',
                    'label' => 'Property Tabs',
                    'name' => 'technical_specs_tabs',
                    'type' => 'repeater',
                    'min' => 1,
                    'max' => 6,
                    'layout' => 'block',
                    'collapsed' => 'field_ts_tab_title',
                    'button_label' => '添加属性类别',
                    'sub_fields' => array(
                        array(
                            'key' => 'field_ts_tab_title',
                            'label' => 'Tab Title',
                            'name' => 'tab_title',
                            'type' => 'text',
                            'wrapper' => array(
                                'width' => '40',
                            ),
                        ),
                        array(
                            'key' => 'field_ts_tab_slug',
                            'label' => 'Tab Key',
                            'name' => 'tab_key',
                            'type' => 'text',
                            'wrapper' => array(
                                'width' => '30',
                            ),
                        ),
                        array(
                            'key' => 'field_ts_tab_tag',
                            'label' => 'Highlight Tag',
                            'name' => 'tab_tag',
                            'type' => 'text',
                            'wrapper' => array(
                                'width' => '30',
                            ),
                        ),
                        array(
                            'key' => 'field_ts_tab_highlights',
                            'label' => 'Highlight Cards',
                            'name' => 'tab_highlights',
                            'type' => 'repeater',
                            'min' => 1,
                            'max' => 4,
                            'layout' => 'block',
                            'collapsed' => 'field_ts_highlight_title',
                            'button_label' => '添加高亮指标',
                            'sub_fields' => array(
                                array(
                                    'key' => 'field_ts_highlight_title',
                                    'label' => 'Title',
                                    'name' => 'highlight_title',
                                    'type' => 'text',
                                    'wrapper' => array(
                                        'width' => '40',
                                    ),
                                ),
                                array(
                                    'key' => 'field_ts_highlight_value',
                                    'label' => 'Value',
                                    'name' => 'highlight_value',
                                    'type' => 'text',
                                    'wrapper' => array(
                                        'width' => '30',
                                    ),
                                ),
                                array(
                                    'key' => 'field_ts_highlight_unit',
                                    'label' => 'Unit',
                                    'name' => 'highlight_unit',
                                    'type' => 'text',
                                    'wrapper' => array(
                                        'width' => '30',
                                    ),
                                ),
                            ),
                        ),
                        array(
                            'key' => 'field_ts_tab_table_rows',
                            'label' => 'Table Rows',
                            'name' => 'tab_table_rows',
                            'type' => 'repeater',
                            'layout' => 'table',
                            'collapsed' => 'field_ts_row_label',
                            'button_label' => '添加参数行',
                            'sub_fields' => array(
                                array(
                                    'key' => 'field_ts_row_label',
                                    'label' => 'Measurement Label',
                                    'name' => 'row_label',
                                    'type' => 'text',
                                    'wrapper' => array(
                                        'width' => '40',
                                    ),
                                ),
                                array(
                                    'key' => 'field_ts_row_value',
                                    'label' => 'Value',
                                    'name' => 'row_value',
                                    'type' => 'text',
                                    'wrapper' => array(
                                        'width' => '30',
                                    ),
                                ),
                                array(
                                    'key' => 'field_ts_row_standard',
                                    'label' => 'Standard / Condition',
                                    'name' => 'row_standard',
                                    'type' => 'text',
                                    'wrapper' => array(
                                        'width' => '30',
                                    ),
                                ),
                            ),
                        ),
                    ),
                ),
                array(
                    'key' => 'field_ts_tab_design',
                    'label' => 'Design',
                    'type' => 'tab',
                    'placement' => 'top',
                ),
                array(
                    'key' => 'field_ts_table_mono',
                    'label' => 'Use Mono Font For Values',
                    'name' => 'technical_specs_use_mono_font',
                    'type' => 'true_false',
                    'ui' => 1,
                    'default_value' => 1,
                    'wrapper' => array(
                        'width' => '33',
                    ),
                ),
                array(
                    'key' => 'field_ts_mobile_hide_table',
                    'label' => 'Hide Table On Mobile',
                    'name' => 'technical_specs_hide_table_mobile',
                    'type' => 'true_false',
                    'ui' => 1,
                    'wrapper' => array(
                        'width' => '33',
                    ),
                ),
                array(
                    'key' => 'field_ts_table_scroll',
                    'label' => 'Enable Horizontal Scroll',
                    'name' => 'technical_specs_table_scrollable',
                    'type' => 'true_false',
                    'ui' => 1,
                    'default_value' => 1,
                    'wrapper' => array(
                        'width' => '34',
                    ),
                ),
                array(
                    'key' => 'field_ts_tab_settings',
                    'label' => 'Settings',
                    'type' => 'tab',
                    'placement' => 'top',
                ),
                array(
                    'key' => 'field_ts_anchor',
                    'label' => 'Block Anchor ID',
                    'name' => 'technical_specs_anchor_id',
                    'type' => 'text',
                    'wrapper' => array(
                        'width' => '50',
                    ),
                ),
                array(
                    'key' => 'field_ts_css_class',
                    'label' => 'Additional CSS Class',
                    'name' => 'technical_specs_css_class',
                    'type' => 'text',
                    'wrapper' => array(
                        'width' => '50',
                    ),
                ),
            ),
            'location' => array(
                array(
                    array(
                        'param' => 'block',
                        'operator' => '==',
                        'value' => 'acf/technical-specs',
                    ),
                ),
            ),
            'menu_order' => 0,
            'position' => 'normal',
            'style' => 'seamless',
            'label_placement' => 'top',
            'instruction_placement' => 'label',
            'hide_on_screen' => '',
            'active' => true,
            'description' => '',
        ) );
    } );
}

