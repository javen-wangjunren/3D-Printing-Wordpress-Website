<?php
if ( function_exists( 'acf_add_local_field_group' ) ) {

    add_action( 'acf/init', function() {
        acf_add_local_field_group( array(
            'key' => 'group_3dp_material_card',
            'title' => 'Material Card (材料卡片网格)',
            'fields' => array(
                array(
                    'key' => 'field_mc_tab_content',
                    'label' => 'Content',
                    'type' => 'tab',
                    'placement' => 'top',
                ),
                array(
                    'key' => 'field_mc_items',
                    'label' => 'Material Cards',
                    'name' => 'material_card_items',
                    'type' => 'repeater',
                    'layout' => 'block',
                    'collapsed' => 'field_mc_item_title',
                    'button_label' => '添加材料卡片',
                    'min' => 1,
                    'sub_fields' => array(
                        array(
                            'key' => 'field_mc_item_title',
                            'label' => 'Title',
                            'name' => 'title',
                            'type' => 'text',
                            'wrapper' => array('width' => '50'),
                        ),
                        array(
                            'key' => 'field_mc_item_process',
                            'label' => 'Process Tag',
                            'name' => 'process',
                            'type' => 'text',
                            'wrapper' => array('width' => '25'),
                        ),
                        array(
                            'key' => 'field_mc_item_type',
                            'label' => 'Material Type Tag',
                            'name' => 'type',
                            'type' => 'text',
                            'wrapper' => array('width' => '25'),
                        ),
                        array(
                            'key' => 'field_mc_item_image',
                            'label' => 'Image',
                            'name' => 'image',
                            'type' => 'image',
                            'return_format' => 'id',
                            'preview_size' => 'medium',
                            'wrapper' => array('width' => '50'),
                        ),
                        array(
                            'key' => 'field_mc_item_link',
                            'label' => 'Detail Link',
                            'name' => 'link',
                            'type' => 'link',
                            'wrapper' => array('width' => '50'),
                        ),
                        array(
                            'key' => 'field_mc_item_badges',
                            'label' => 'Badges',
                            'name' => 'badges',
                            'type' => 'repeater',
                            'layout' => 'table',
                            'button_label' => '添加勋章',
                            'sub_fields' => array(
                                array(
                                    'key' => 'field_mc_badge_label',
                                    'label' => 'Label',
                                    'name' => 'label',
                                    'type' => 'text',
                                ),
                                array(
                                    'key' => 'field_mc_badge_value',
                                    'label' => 'Value',
                                    'name' => 'value',
                                    'type' => 'text',
                                ),
                            ),
                        ),
                    ),
                ),

                array(
                    'key' => 'field_mc_tab_design',
                    'label' => 'Design',
                    'type' => 'tab',
                    'placement' => 'top',
                ),
                array(
                    'key' => 'field_mc_cols_desktop',
                    'label' => 'Columns (Desktop)',
                    'name' => 'material_card_columns_desktop',
                    'type' => 'select',
                    'choices' => array(
                        3 => '3',
                        4 => '4',
                    ),
                    'default_value' => 3,
                    'wrapper' => array('width' => '33'),
                ),
                array(
                    'key' => 'field_mc_cols_tablet',
                    'label' => 'Columns (Tablet)',
                    'name' => 'material_card_columns_tablet',
                    'type' => 'select',
                    'choices' => array(
                        2 => '2',
                        3 => '3',
                    ),
                    'default_value' => 2,
                    'wrapper' => array('width' => '33'),
                ),
                array(
                    'key' => 'field_mc_cols_mobile',
                    'label' => 'Columns (Mobile)',
                    'name' => 'material_card_columns_mobile',
                    'type' => 'select',
                    'choices' => array(
                        1 => '1',
                        2 => '2',
                    ),
                    'default_value' => 1,
                    'wrapper' => array('width' => '34'),
                ),
                array(
                    'key' => 'field_mc_use_mono',
                    'label' => 'Use Mono Font For Values',
                    'name' => 'material_card_use_mono_font',
                    'type' => 'true_false',
                    'ui' => 1,
                    'default_value' => 1,
                    'wrapper' => array('width' => '33'),
                ),

                array(
                    'key' => 'field_mc_tab_settings',
                    'label' => 'Settings',
                    'type' => 'tab',
                    'placement' => 'top',
                ),
                array(
                    'key' => 'field_mc_anchor',
                    'label' => 'Block Anchor ID',
                    'name' => 'material_card_anchor_id',
                    'type' => 'text',
                    'wrapper' => array('width' => '50'),
                ),
                array(
                    'key' => 'field_mc_css_class',
                    'label' => 'Additional CSS Class',
                    'name' => 'material_card_css_class',
                    'type' => 'text',
                    'wrapper' => array('width' => '50'),
                ),
            ),
            'location' => array(
                array(
                    array(
                        'param' => 'block',
                        'operator' => '==',
                        'value' => 'acf/material-card',
                    ),
                ),
            ),
            'menu_order' => 0,
            'position' => 'normal',
            'style' => 'seamless',
            'label_placement' => 'top',
            'instruction_placement' => 'label',
            'active' => true,
        ) );
    } );
}

