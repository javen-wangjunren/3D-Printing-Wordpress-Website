<?php
/**
 * ACF Field: Mission & Vision (Template Part)
 * -用于template-part 不用与古腾堡
 * Path: inc/acf/field/mission.php
 * Description: Defines fields for the Mission/Vision section on About Us page.
 * Note: This is a Template Part, not a Gutenberg Block.
 */

if ( function_exists('acf_add_local_field_group') ) :

    acf_add_local_field_group(array(
        'key' => 'group_mission_module',
        'title' => 'Module: Mission & Vision',
        'fields' => array(
            /* -------------------------------------------------------------------------- */
            /*                                 Tab: Content                               */
            /* -------------------------------------------------------------------------- */
            array(
                'key' => 'field_mission_tab_content',
                'label' => 'Content',
                'type' => 'tab',
            ),
            
            // Section Header
            array(
                'key' => 'field_mission_header_group',
                'label' => 'Section Header',
                'name' => 'mission_header',
                'type' => 'group',
                'layout' => 'block',
                'sub_fields' => array(
                    array(
                        'key' => 'field_mission_title_prefix',
                        'label' => 'Title Prefix',
                        'name' => 'prefix',
                        'type' => 'text',
                        'default_value' => 'Strategic',
                        'wrapper' => array('width' => '50'),
                    ),
                    array(
                        'key' => 'field_mission_title_highlight',
                        'label' => 'Title Highlight',
                        'name' => 'highlight',
                        'type' => 'text',
                        'default_value' => 'Alignment',
                        'wrapper' => array('width' => '50'),
                    ),
                    array(
                        'key' => 'field_mission_description',
                        'label' => 'Description',
                        'name' => 'description',
                        'type' => 'textarea',
                        'rows' => 3,
                        'default_value' => '将工业级制造能力转化为客户的竞争优势。我们的战略基于两个核心支柱：加速创新与全球可靠性。',
                    ),
                ),
            ),

            // Main Items Repeater (Mission / Vision)
            array(
                'key' => 'field_mission_items',
                'label' => 'Mission & Vision Items',
                'name' => 'mission_items',
                'type' => 'repeater',
                'layout' => 'block', // Block layout to save horizontal space
                'button_label' => 'Add Item',
                'collapsed' => 'field_mission_item_label', // Collapsed by Label
                'sub_fields' => array(
                    
                    // Row 1: Identity
                    array(
                        'key' => 'field_mission_item_icon',
                        'label' => 'Icon (SVG)',
                        'name' => 'icon',
                        'type' => 'image',
                        'instructions' => 'Upload a small SVG icon (displayed inside the square box).',
                        'return_format' => 'array', // Array allows access to URL, Alt, etc.
                        'preview_size' => 'thumbnail',
                        'library' => 'all',
                        'mime_types' => 'svg,png', // Prefer SVG
                        'wrapper' => array('width' => '20'),
                    ),
                    array(
                        'key' => 'field_mission_item_label',
                        'label' => 'Label',
                        'name' => 'label',
                        'type' => 'text',
                        'instructions' => 'e.g., Our Mission',
                        'default_value' => 'Our Mission',
                        'wrapper' => array('width' => '40'),
                    ),
                    array(
                        'key' => 'field_mission_item_title',
                        'label' => 'Headline',
                        'name' => 'title',
                        'type' => 'text',
                        'instructions' => 'e.g., Accelerate Global Innovation',
                        'wrapper' => array('width' => '40'),
                    ),

                    // Row 2: Description
                    array(
                        'key' => 'field_mission_item_desc',
                        'label' => 'Description',
                        'name' => 'description',
                        'type' => 'textarea',
                        'rows' => 4,
                    ),

                    // Row 3: Main Image
                    array(
                        'key' => 'field_mission_item_image',
                        'label' => 'Feature Image',
                        'name' => 'image',
                        'type' => 'image',
                        'return_format' => 'array',
                        'preview_size' => 'medium',
                        'library' => 'all',
                        'wrapper' => array('width' => '50'),
                    ),
                    array(
                        'key' => 'field_mission_item_image_mobile',
                        'label' => 'Mobile Image (Optional)',
                        'name' => 'mobile_image',
                        'type' => 'image',
                        'return_format' => 'array',
                        'preview_size' => 'medium',
                        'library' => 'all',
                        'instructions' => 'Upload a portrait or square version for mobile if needed.',
                        'wrapper' => array('width' => '50'),
                    ),

                    // Row 4: Data Points (Stats)
                    array(
                        'key' => 'field_mission_item_stats',
                        'label' => 'Data Points',
                        'name' => 'stats',
                        'type' => 'repeater',
                        'layout' => 'table', // Table layout for simple key-value pairs
                        'max' => 2, // Limit to 2 as per design
                        'button_label' => 'Add Stat',
                        'sub_fields' => array(
                            array(
                                'key' => 'field_mission_stat_label',
                                'label' => 'Label',
                                'name' => 'label',
                                'type' => 'text',
                                'placeholder' => 'R&D LEAD TIME',
                            ),
                            array(
                                'key' => 'field_mission_stat_value',
                                'label' => 'Value',
                                'name' => 'value',
                                'type' => 'text',
                                'placeholder' => '< 48 HRS',
                            ),
                            array(
                                'key' => 'field_mission_stat_style',
                                'label' => 'Style',
                                'name' => 'style',
                                'type' => 'select',
                                'choices' => array(
                                    'default' => 'Big Heading (Default)',
                                    'highlight' => 'Small Primary (Highlight)',
                                ),
                                'default_value' => 'default',
                                'ui' => 0, // Simple select
                            ),
                        ),
                    ),
                ),
            ),

            /* -------------------------------------------------------------------------- */
            /*                                 Tab: Design                                */
            /* -------------------------------------------------------------------------- */
            array(
                'key' => 'field_mission_tab_design',
                'label' => 'Design',
                'type' => 'tab',
            ),
            array(
                'key' => 'field_mission_mobile_hide',
                'label' => 'Hide on Mobile',
                'name' => 'mobile_hide_content',
                'type' => 'true_false',
                'ui' => 1,
                'wrapper' => array('width' => '50'),
            ),
            array(
                'key' => 'field_mission_bg_style',
                'label' => 'Background Style',
                'name' => 'background_style',
                'type' => 'select',
                'choices' => array(
                    'grid' => 'Industrial Grid (Blue)',
                    'white' => 'Clean White',
                    'gray' => 'Light Gray',
                ),
                'default_value' => 'grid',
                'wrapper' => array('width' => '50'),
            ),

            /* -------------------------------------------------------------------------- */
            /*                                Tab: Settings                               */
            /* -------------------------------------------------------------------------- */
            array(
                'key' => 'field_mission_tab_settings',
                'label' => 'Settings',
                'type' => 'tab',
            ),
            array(
                'key' => 'field_mission_anchor',
                'label' => 'Section Anchor ID',
                'name' => 'anchor_id',
                'type' => 'text',
                'instructions' => 'Enter a unique ID for anchor links (e.g., mission-section).',
            ),
        ),
        'location' => array(
            // Library: No location, cloned only
        ),
        'menu_order' => 0,
        'position' => 'normal',
        'style' => 'seamless',
        'label_placement' => 'top',
        'instruction_placement' => 'label',
        'active' => true,
    ));

endif;
