<?php
/**
 * Block: Factory Image (Factory Tour)
 * Location: inc/acf/field/factory-image.php
 * Description: Backend fields for the Industrial Factory Image Grid module.
 */

if ( function_exists('acf_add_local_field_group') ) {

    add_action('acf/init', function() {

        acf_add_local_field_group(array(
            'key' => 'group_factory_image',
            'title' => 'Module: Factory Image Grid',
            'fields' => array(
                /* -------------------------------------------------------------------------- */
                /*                                 Tab: Content                               */
                /* -------------------------------------------------------------------------- */
                array(
                    'key' => 'field_factory_image_tab_content',
                    'label' => 'Content',
                    'type' => 'tab',
                ),
                
                // Group: Header Section
                array(
                    'key' => 'field_factory_image_header',
                    'label' => 'Header Section',
                    'name' => 'header_group',
                    'type' => 'group',
                    'layout' => 'block',
                    'sub_fields' => array(
                        array(
                            'key' => 'field_factory_image_title',
                            'label' => 'Main Title',
                            'name' => 'title',
                            'type' => 'text',
                            'default_value' => 'Step Inside Our Facility',
                            'wrapper' => array('width' => '50'),
                        ),
                        array(
                            'key' => 'field_factory_image_highlight',
                            'label' => 'Highlight Word',
                            'name' => 'highlight_word',
                            'type' => 'text',
                            'default_value' => 'Facility',
                            'instructions' => 'This word will be colored in Primary Blue.',
                            'wrapper' => array('width' => '50'),
                        ),
                        array(
                            'key' => 'field_factory_image_desc',
                            'label' => 'Description',
                            'name' => 'description',
                            'type' => 'textarea',
                            'rows' => 3,
                            'default_value' => 'Explore our 3,700m² intelligent manufacturing hub...',
                        ),
                        array(
                            'key' => 'field_factory_image_cta',
                            'label' => 'CTA Button',
                            'name' => 'cta_link',
                            'type' => 'link',
                            'return_format' => 'array',
                        ),
                    ),
                ),

                // Repeater: Gallery Grid
                array(
                    'key' => 'field_factory_image_items',
                    'label' => 'Gallery Grid Items',
                    'name' => 'gallery_items',
                    'type' => 'repeater',
                    'instructions' => 'Please add exactly 5 items. The first item will be the Large Hero (2x2). The other 4 will be Detail Shots (1x1).',
                    'min' => 1,
                    'max' => 5,
                    'layout' => 'block',
                    'button_label' => 'Add Image Card',
                    'collapsed' => 'field_factory_image_item_title',
                    'sub_fields' => array(
                        // Row 1: Images
                        array(
                            'key' => 'field_factory_image_item_img',
                            'label' => 'Desktop Image',
                            'name' => 'image',
                            'type' => 'image',
                            'return_format' => 'id',
                            'preview_size' => 'medium',
                            'wrapper' => array('width' => '50'),
                        ),
                        array(
                            'key' => 'field_factory_image_item_mobile_img',
                            'label' => 'Mobile Image',
                            'name' => 'mobile_image',
                            'type' => 'image',
                            'return_format' => 'id',
                            'preview_size' => 'medium',
                            'instructions' => 'Optional. If empty, Desktop Image will be used.',
                            'wrapper' => array('width' => '50'),
                        ),
                        
                        // Row 2: Tag & Content
                        array(
                            'key' => 'field_factory_image_item_tag',
                            'label' => 'Corner Tag (Mono)',
                            'name' => 'tag_text',
                            'type' => 'text',
                            'placeholder' => 'Area: 3,700 SQM',
                            'instructions' => 'Top-left monospace tag.',
                            'wrapper' => array('width' => '33'),
                        ),
                        array(
                            'key' => 'field_factory_image_item_title',
                            'label' => 'Card Title',
                            'name' => 'item_title',
                            'type' => 'text',
                            'placeholder' => 'Main Production Floor',
                            'wrapper' => array('width' => '33'),
                        ),
                        array(
                            'key' => 'field_factory_image_item_sub',
                            'label' => 'Subtitle / Desc',
                            'name' => 'item_subtitle',
                            'type' => 'text',
                            'placeholder' => 'ISO 9001 Certified Environment',
                            'instructions' => 'Visible on Hover or for Hero item.',
                            'wrapper' => array('width' => '33'),
                        ),
                    ),
                ),

                /* -------------------------------------------------------------------------- */
                /*                                 Tab: Design                                */
                /* -------------------------------------------------------------------------- */
                array(
                    'key' => 'field_factory_image_tab_design',
                    'label' => 'Design',
                    'type' => 'tab',
                ),
                array(
                    'key' => 'field_factory_image_bg',
                    'label' => 'Background Style',
                    'name' => 'background_style',
                    'type' => 'select',
                    'choices' => array(
                        'industrial' => 'Industrial Grid (Light Gray)',
                        'white' => 'Plain White',
                        'none' => 'Transparent',
                    ),
                    'default_value' => 'industrial',
                    'wrapper' => array('width' => '50'),
                ),
                array(
                    'key' => 'field_factory_image_mobile_opt',
                    'label' => 'Mobile Optimization',
                    'name' => 'mobile_options',
                    'type' => 'checkbox',
                    'choices' => array(
                        'hide_content' => 'Hide Description Text on Mobile',
                        'compact_grid' => 'Force Compact Grid (2 Cols)',
                    ),
                    'default_value' => array('compact_grid'),
                    'wrapper' => array('width' => '50'),
                ),

                /* -------------------------------------------------------------------------- */
                /*                                Tab: Settings                               */
                /* -------------------------------------------------------------------------- */
                array(
                    'key' => 'field_factory_image_tab_settings',
                    'label' => 'Settings',
                    'type' => 'tab',
                ),
                array(
                    'key' => 'field_factory_image_id',
                    'label' => 'Block ID',
                    'name' => 'block_id',
                    'type' => 'text',
                    'instructions' => 'HTML ID attribute for anchor links.',
                    'wrapper' => array('width' => '50'),
                ),
                array(
                    'key' => 'field_factory_image_class',
                    'label' => 'Custom Class',
                    'name' => 'custom_class',
                    'type' => 'text',
                    'instructions' => 'Additional CSS classes.',
                    'wrapper' => array('width' => '50'),
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
    });
}
