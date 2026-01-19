<?php
/**
 * ACF Field: Timeline (Template Part)
 * -用于template-part 不用与古腾堡
 * Path: inc/acf/field/timeline.php
 * Description: Defines fields for the Timeline/Milestones section.--用于template-part 不用与古腾堡
 * Note: This is a Template Part, not a Gutenberg Block.
 */

if ( function_exists('acf_add_local_field_group') ) :

    acf_add_local_field_group(array(
        'key' => 'group_timeline_module',
        'title' => 'Module: Timeline & History',
        'fields' => array(
            /* -------------------------------------------------------------------------- */
            /*                                 Tab: Content                               */
            /* -------------------------------------------------------------------------- */
            array(
                'key' => 'field_timeline_tab_content',
                'label' => 'Content',
                'type' => 'tab',
            ),
            
            // Section Header
            array(
                'key' => 'field_timeline_header_group',
                'label' => 'Section Header',
                'name' => 'timeline_header',
                'type' => 'group',
                'layout' => 'block',
                'sub_fields' => array(
                    array(
                        'key' => 'field_timeline_title_prefix',
                        'label' => 'Title Prefix',
                        'name' => 'prefix',
                        'type' => 'text',
                        'default_value' => 'Evolution and',
                        'wrapper' => array('width' => '50'),
                    ),
                    array(
                        'key' => 'field_timeline_title_highlight',
                        'label' => 'Title Highlight',
                        'name' => 'highlight',
                        'type' => 'text',
                        'default_value' => 'Milestones',
                        'wrapper' => array('width' => '50'),
                    ),
                    array(
                        'key' => 'field_timeline_description',
                        'label' => 'Description',
                        'name' => 'description',
                        'type' => 'textarea',
                        'rows' => 3,
                        'default_value' => 'A quantitative journey from a single production line to a global digital manufacturing hub.',
                    ),
                ),
            ),

            // Milestones Repeater
            array(
                'key' => 'field_timeline_items',
                'label' => 'Milestones',
                'name' => 'timeline_items',
                'type' => 'repeater',
                'layout' => 'block',
                'button_label' => 'Add Milestone',
                'collapsed' => 'field_timeline_item_year',
                'sub_fields' => array(
                    // Row 1: Year & State
                    array(
                        'key' => 'field_timeline_item_year',
                        'label' => 'Year',
                        'name' => 'year',
                        'type' => 'text',
                        'placeholder' => '2019',
                        'wrapper' => array('width' => '50'),
                    ),
                    array(
                        'key' => 'field_timeline_item_active',
                        'label' => 'Is Current/Active?',
                        'name' => 'is_active',
                        'type' => 'true_false',
                        'ui' => 1,
                        'message' => 'Highlight as current milestone (Blue Border)',
                        'wrapper' => array('width' => '50'),
                    ),

                    // Row 2: Content
                    array(
                        'key' => 'field_timeline_item_title',
                        'label' => 'Title',
                        'name' => 'title',
                        'type' => 'text',
                        'placeholder' => 'Founded and Setup',
                    ),
                    array(
                        'key' => 'field_timeline_item_desc',
                        'label' => 'Description',
                        'name' => 'description',
                        'type' => 'textarea',
                        'rows' => 3,
                    ),

                    // Row 3: Metric (Data Point)
                    array(
                        'key' => 'field_timeline_item_metric_label',
                        'label' => 'Metric Label',
                        'name' => 'metric_label',
                        'type' => 'text',
                        'placeholder' => 'Metric',
                        'wrapper' => array('width' => '50'),
                    ),
                    array(
                        'key' => 'field_timeline_item_metric_value',
                        'label' => 'Metric Value',
                        'name' => 'metric_value',
                        'type' => 'text',
                        'placeholder' => '1st Line Live',
                        'wrapper' => array('width' => '50'),
                    ),
                ),
            ),

            /* -------------------------------------------------------------------------- */
            /*                                 Tab: Design                                */
            /* -------------------------------------------------------------------------- */
            array(
                'key' => 'field_timeline_tab_design',
                'label' => 'Design',
                'type' => 'tab',
            ),
            array(
                'key' => 'field_timeline_bg_style',
                'label' => 'Background Style',
                'name' => 'background_style',
                'type' => 'select',
                'choices' => array(
                    'grid' => 'Industrial Grid (Blue)',
                    'white' => 'Clean White',
                ),
                'default_value' => 'grid',
            ),

            /* -------------------------------------------------------------------------- */
            /*                                Tab: Settings                               */
            /* -------------------------------------------------------------------------- */
            array(
                'key' => 'field_timeline_tab_settings',
                'label' => 'Settings',
                'type' => 'tab',
            ),
            array(
                'key' => 'field_timeline_anchor',
                'label' => 'Section Anchor ID',
                'name' => 'anchor_id',
                'type' => 'text',
            ),
        ),
        'location' => array(
            // Library: No location, cloned only
        ),
        'menu_order' => 10,
        'position' => 'normal',
        'style' => 'seamless',
        'label_placement' => 'top',
        'instruction_placement' => 'label',
        'active' => true,
    ));

endif;
