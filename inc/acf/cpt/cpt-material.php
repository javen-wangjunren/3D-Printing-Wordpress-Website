<?php
if ( function_exists( 'acf_add_local_field_group' ) ) {

    add_action( 'acf/init', function() {
        acf_add_local_field_group( array(
            'key' => 'group_cpt_material_fields',
            'title' => 'Material Fields',
            'fields' => array(
                // =================================================================
                // TAB 1: Hero Banner
                // =================================================================
                array(
                    'key' => 'field_cpt_mat_tab_hero',
                    'label' => 'Hero Banner',
                    'type' => 'tab',
                    'placement' => 'top',
                ),
                array(
                    'key' => 'field_cpt_mat_hero_title',
                    'label' => 'Hero Title',
                    'name' => 'hero_title',
                    'type' => 'text',
                    'required' => 1,
                    'wrapper' => array('width' => '50'),
                ),
                array(
                    'key' => 'field_cpt_mat_hero_subtitle',
                    'label' => 'Hero Subtitle',
                    'name' => 'hero_subtitle',
                    'type' => 'text',
                    'wrapper' => array('width' => '50'),
                ),
                array(
                    'key' => 'field_cpt_mat_hero_content',
                    'label' => 'Hero Content',
                    'name' => 'hero_content',
                    'type' => 'textarea', // Changed to textarea for simplicity, or wysiwyg
                    'rows' => 3,
                    'wrapper' => array('width' => '100'),
                ),
                array(
                    'key' => 'field_cpt_mat_hero_image',
                    'label' => 'Hero Image (Desktop)',
                    'name' => 'hero_image',
                    'type' => 'image',
                    'return_format' => 'id',
                    'preview_size' => 'medium',
                    'wrapper' => array('width' => '50'),
                ),
                array(
                    'key' => 'field_cpt_mat_hero_mobile_image',
                    'label' => 'Hero Image (Mobile)',
                    'name' => 'hero_mobile_image',
                    'type' => 'image',
                    'return_format' => 'id',
                    'preview_size' => 'medium',
                    'wrapper' => array('width' => '50'),
                ),
                array(
                    'key' => 'field_cpt_mat_hero_cta_btn',
                    'label' => 'Primary CTA Button',
                    'name' => 'hero_cta_button',
                    'type' => 'link',
                    'wrapper' => array('width' => '50'),
                ),
                array(
                    'key' => 'field_cpt_mat_hero_sec_btn',
                    'label' => 'Secondary Button',
                    'name' => 'hero_secondary_button',
                    'type' => 'link',
                    'wrapper' => array('width' => '50'),
                ),

                // =================================================================
                // TAB 2: Showcase
                // =================================================================
                array(
                    'key' => 'field_cpt_mat_tab_showcase',
                    'label' => 'Showcase',
                    'type' => 'tab',
                    'placement' => 'top',
                ),
                array(
                    'key' => 'field_cpt_mat_showcase_title',
                    'label' => 'Section Title',
                    'name' => 'manufacturing_showcase_title',
                    'type' => 'text',
                    'wrapper' => array('width' => '50'),
                ),
                array(
                    'key' => 'field_cpt_mat_showcase_subtitle',
                    'label' => 'Section Subtitle',
                    'name' => 'manufacturing_showcase_subtitle',
                    'type' => 'textarea',
                    'rows' => 2,
                    'wrapper' => array('width' => '50'),
                ),
                array(
                    'key' => 'field_cpt_mat_showcase_items',
                    'label' => 'Showcase Items',
                    'name' => 'manufacturing_showcase_items',
                    'type' => 'repeater',
                    'layout' => 'block',
                    'collapsed' => 'field_cpt_mat_item_title',
                    'button_label' => '添加展示案例',
                    'sub_fields' => array(
                        array(
                            'key' => 'field_cpt_mat_item_image',
                            'label' => 'Image',
                            'name' => 'item_image',
                            'type' => 'image',
                            'return_format' => 'id',
                            'wrapper' => array('width' => '33'),
                        ),
                        array(
                            'key' => 'field_cpt_mat_item_mob_img',
                            'label' => 'Mobile Image',
                            'name' => 'item_mobile_image',
                            'type' => 'image',
                            'return_format' => 'id',
                            'wrapper' => array('width' => '33'),
                        ),
                        array(
                            'key' => 'field_cpt_mat_item_title',
                            'label' => 'Title',
                            'name' => 'item_title',
                            'type' => 'text',
                            'required' => 1,
                            'wrapper' => array('width' => '34'),
                        ),
                        array(
                            'key' => 'field_cpt_mat_item_subtitle',
                            'label' => 'Subtitle',
                            'name' => 'item_subtitle',
                            'type' => 'text',
                            'wrapper' => array('width' => '50'),
                        ),
                        array(
                            'key' => 'field_cpt_mat_item_link',
                            'label' => 'Link',
                            'name' => 'item_link',
                            'type' => 'link',
                            'wrapper' => array('width' => '50'),
                        ),
                    ),
                ),

                // =================================================================
                // TAB 3: Specs & Capabilities
                // =================================================================
                array(
                    'key' => 'field_cpt_mat_tab_specs',
                    'label' => 'Specs & Capabilities',
                    'type' => 'tab',
                    'placement' => 'top',
                ),
                
                // --- Section: Technical Specs ---
                array(
                    'key' => 'field_cpt_mat_msg_specs',
                    'label' => 'Technical Specs',
                    'type' => 'message',
                    'message' => '<h3>Technical Specs Configuration</h3>',
                    'new_lines' => 'wpautop', // Fix: 'wpautop' not 'br'
                ),
                array(
                    'key' => 'field_cpt_mat_ts_label',
                    'label' => 'Material Label',
                    'name' => 'technical_specs_material_label',
                    'type' => 'text',
                    'wrapper' => array('width' => '50'),
                ),
                array(
                    'key' => 'field_cpt_mat_ts_intro',
                    'label' => 'Introduction',
                    'name' => 'technical_specs_intro',
                    'type' => 'textarea',
                    'rows' => 3,
                    'wrapper' => array('width' => '50'),
                ),
                array(
                    'key' => 'field_cpt_mat_ts_tabs',
                    'label' => 'Specs Tabs',
                    'name' => 'technical_specs_tabs',
                    'type' => 'repeater',
                    'layout' => 'block',
                    'collapsed' => 'field_cpt_mat_ts_tab_title',
                    'button_label' => '添加规格Tab',
                    'sub_fields' => array(
                        array(
                            'key' => 'field_cpt_mat_ts_tab_title',
                            'label' => 'Tab Title',
                            'name' => 'tab_title',
                            'type' => 'text',
                            'wrapper' => array('width' => '40'),
                        ),
                        array(
                            'key' => 'field_cpt_mat_ts_tab_key',
                            'label' => 'Tab Key',
                            'name' => 'tab_key',
                            'type' => 'text',
                            'wrapper' => array('width' => '30'),
                        ),
                        array(
                            'key' => 'field_cpt_mat_ts_tab_tag',
                            'label' => 'Highlight Tag',
                            'name' => 'tab_tag',
                            'type' => 'text',
                            'wrapper' => array('width' => '30'),
                        ),
                        // Highlights
                        array(
                            'key' => 'field_cpt_mat_ts_highlights',
                            'label' => 'Highlight Cards',
                            'name' => 'tab_highlights',
                            'type' => 'repeater',
                            'layout' => 'table',
                            'button_label' => '添加卡片',
                            'sub_fields' => array(
                                array(
                                    'key' => 'field_cpt_mat_ts_hl_title',
                                    'label' => 'Title',
                                    'name' => 'highlight_title',
                                    'type' => 'text',
                                ),
                                array(
                                    'key' => 'field_cpt_mat_ts_hl_val',
                                    'label' => 'Value',
                                    'name' => 'highlight_value',
                                    'type' => 'text',
                                ),
                                array(
                                    'key' => 'field_cpt_mat_ts_hl_unit',
                                    'label' => 'Unit',
                                    'name' => 'highlight_unit',
                                    'type' => 'text',
                                ),
                            ),
                        ),
                        // Table Rows
                        array(
                            'key' => 'field_cpt_mat_ts_rows',
                            'label' => 'Table Rows',
                            'name' => 'tab_table_rows',
                            'type' => 'repeater',
                            'layout' => 'table',
                            'button_label' => '添加行',
                            'sub_fields' => array(
                                array(
                                    'key' => 'field_cpt_mat_ts_row_lbl',
                                    'label' => 'Label',
                                    'name' => 'row_label',
                                    'type' => 'text',
                                ),
                                array(
                                    'key' => 'field_cpt_mat_ts_row_val',
                                    'label' => 'Value',
                                    'name' => 'row_value',
                                    'type' => 'text',
                                ),
                                array(
                                    'key' => 'field_cpt_mat_ts_row_std',
                                    'label' => 'Standard',
                                    'name' => 'row_standard',
                                    'type' => 'text',
                                ),
                            ),
                        ),
                    ),
                ),

                // --- Section: Listing Filters (for All Materials page) ---
                array(
                    'key' => 'field_cpt_mat_msg_listing_filters',
                    'label' => 'Listing Filters',
                    'type' => 'message',
                    'message' => '<h3>Listing Filters (Process / Type / Cost / Lead Time)</h3>',
                    'new_lines' => 'wpautop',
                ),
                array(
                    'key' => 'field_cpt_mat_process',
                    'label' => 'Process',
                    'name' => 'material_process',
                    'type' => 'select',
                    'choices' => array(),
                    'allow_null' => 0,
                    'multiple' => 0,
                    'ui' => 1,
                    'return_format' => 'value',
                    'wrapper' => array('width' => '33'),
                ),
                array(
                    'key' => 'field_cpt_mat_type',
                    'label' => 'Material Type',
                    'name' => 'material_type',
                    'type' => 'select',
                    'choices' => array(),
                    'allow_null' => 0,
                    'multiple' => 0,
                    'ui' => 1,
                    'return_format' => 'value',
                    'wrapper' => array('width' => '33'),
                ),
                array(
                    'key' => 'field_cpt_mat_cost',
                    'label' => 'Cost Level',
                    'name' => 'material_cost_level',
                    'type' => 'radio',
                    'choices' => array(
                        '$'    => '$ (Economical)',
                        '$$'   => '$$ (Standard)',
                        '$$$'  => '$$$ (Premium)',
                        '$$$$' => '$$$$ (Enterprise)',
                    ),
                    'layout' => 'horizontal',
                    'return_format' => 'value',
                    'wrapper' => array('width' => '34'),
                ),
                array(
                    'key' => 'field_cpt_mat_lead_time',
                    'label' => 'Lead Time',
                    'name' => 'material_lead_time',
                    'type' => 'select',
                    'choices' => array(
                        'As fast as 1 business day' => 'As fast as 1 business day',
                        '1-2 Days' => '1-2 Days',
                        '3-5 Days' => '3-5 Days',
                        '7-10 Days' => '7-10 Days',
                    ),
                    'allow_null' => 0,
                    'multiple' => 0,
                    'ui' => 0,
                    'return_format' => 'value',
                    'wrapper' => array('width' => '50'),
                ),

                // --- Section: Manufacturing Capabilities ---
                array(
                    'key' => 'field_cpt_mat_msg_mcap',
                    'label' => 'Manufacturing Capabilities',
                    'type' => 'message',
                    'message' => '<h3>Manufacturing Capabilities Configuration</h3>',
                    'new_lines' => 'wpautop',
                ),
                array(
                    'key' => 'field_cpt_mat_mcap_title',
                    'label' => 'Section Title',
                    'name' => 'manufacturing_capabilities_title',
                    'type' => 'text',
                    'default_value' => 'Manufacturing Capabilities',
                    'wrapper' => array('width' => '50'),
                ),
                array(
                    'key' => 'field_cpt_mat_mcap_intro',
                    'label' => 'Introduction',
                    'name' => 'manufacturing_capabilities_intro',
                    'type' => 'textarea',
                    'rows' => 3,
                    'wrapper' => array('width' => '50'),
                ),
                array(
                    'key' => 'field_cpt_mat_mcap_tabs',
                    'label' => 'Capability Tabs',
                    'name' => 'manufacturing_capabilities_tabs',
                    'type' => 'repeater',
                    'layout' => 'block',
                    'collapsed' => 'field_cpt_mat_mcap_tab_title',
                    'button_label' => '添加能力Tab',
                    'sub_fields' => array(
                        array(
                            'key' => 'field_cpt_mat_mcap_tab_title',
                            'label' => 'Tab Title',
                            'name' => 'tab_title',
                            'type' => 'text',
                            'wrapper' => array('width' => '40'),
                        ),
                        array(
                            'key' => 'field_cpt_mat_mcap_tab_key',
                            'label' => 'Tab Key',
                            'name' => 'tab_key',
                            'type' => 'text',
                            'wrapper' => array('width' => '30'),
                        ),
                        array(
                            'key' => 'field_cpt_mat_mcap_machine',
                            'label' => 'Machine Model',
                            'name' => 'machine_model',
                            'type' => 'text',
                            'wrapper' => array('width' => '30'),
                        ),
                        // Hub Info
                        array(
                            'key' => 'field_cpt_mat_mcap_hub_title',
                            'label' => 'Hub Title',
                            'name' => 'hub_title',
                            'type' => 'text',
                            'wrapper' => array('width' => '50'),
                        ),
                        array(
                            'key' => 'field_cpt_mat_mcap_hub_desc',
                            'label' => 'Hub Description',
                            'name' => 'hub_desc',
                            'type' => 'textarea',
                            'rows' => 3,
                            'wrapper' => array('width' => '50'),
                        ),
                        // Highlights
                        array(
                            'key' => 'field_cpt_mat_mcap_hls',
                            'label' => 'Highlight Cards',
                            'name' => 'highlights',
                            'type' => 'repeater',
                            'layout' => 'table', // Compact layout
                            'button_label' => '添加高亮',
                            'sub_fields' => array(
                                array(
                                    'key' => 'field_cpt_mat_mcap_hl_ti',
                                    'label' => 'Title',
                                    'name' => 'title',
                                    'type' => 'text',
                                ),
                                array(
                                    'key' => 'field_cpt_mat_mcap_hl_val',
                                    'label' => 'Value',
                                    'name' => 'value',
                                    'type' => 'text',
                                ),
                                array(
                                    'key' => 'field_cpt_mat_mcap_hl_un',
                                    'label' => 'Unit',
                                    'name' => 'unit',
                                    'type' => 'text',
                                ),
                                array(
                                    'key' => 'field_cpt_mat_mcap_hl_tag',
                                    'label' => 'Tag',
                                    'name' => 'tag',
                                    'type' => 'text',
                                ),
                            ),
                        ),
                        // Tags
                        array(
                            'key' => 'field_cpt_mat_mcap_tags',
                            'label' => 'Finishing Tags',
                            'name' => 'finishing_tags',
                            'type' => 'repeater',
                            'layout' => 'table',
                            'button_label' => '添加标签',
                            'sub_fields' => array(
                                array(
                                    'key' => 'field_cpt_mat_mcap_tag_txt',
                                    'label' => 'Tag',
                                    'name' => 'text',
                                    'type' => 'text',
                                ),
                            ),
                        ),
                        // CTA & Image
                        array(
                            'key' => 'field_cpt_mat_mcap_cta',
                            'label' => 'CTA Link',
                            'name' => 'cta_link',
                            'type' => 'link',
                            'wrapper' => array('width' => '50'),
                        ),
                        array(
                            'key' => 'field_cpt_mat_mcap_img',
                            'label' => 'Image',
                            'name' => 'image',
                            'type' => 'image',
                            'return_format' => 'id',
                            'wrapper' => array('width' => '25'),
                        ),
                        array(
                            'key' => 'field_cpt_mat_mcap_mob_img',
                            'label' => 'Mobile Image',
                            'name' => 'mobile_image',
                            'type' => 'image',
                            'return_format' => 'id',
                            'wrapper' => array('width' => '25'),
                        ),
                    ),
                ),
            ),
            'location' => array(
                array(
                    array(
                        'param' => 'post_type',
                        'operator' => '==',
                        'value' => 'material',
                    ),
                ),
            ),
            'menu_order' => 0,
            'position' => 'normal',
            'style' => 'default',
            'label_placement' => 'top',
            'instruction_placement' => 'label',
            'active' => true,
        ));
    });
}
