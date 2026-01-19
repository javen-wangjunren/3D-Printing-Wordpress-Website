<?php
/**
 * Module: Team (Leadership Architects)
 * Template Parts
 * Location: inc/acf/field/team.php
 * Description: Backend fields for the Team/Leadership module (About Us Page).
 * Note: This is a Page Meta Box, NOT a Gutenberg Block.
 */

if ( function_exists('acf_add_local_field_group') ) 
{

    add_action('acf/init', function() {

        acf_add_local_field_group(array(
            'key' => 'group_team_module',
            'title' => 'Module: Leadership Team',
            'fields' => array(
                /* -------------------------------------------------------------------------- */
                /*                                 Tab: Content                               */
                /* -------------------------------------------------------------------------- */
                array(
                    'key' => 'field_team_tab_content',
                    'label' => 'Content',
                    'type' => 'tab',
                ),

                // Group: Header
                array(
                    'key' => 'field_team_header',
                    'label' => 'Header Section',
                    'name' => 'team_header',
                    'type' => 'group',
                    'layout' => 'block',
                    'sub_fields' => array(
                        array(
                            'key' => 'field_team_title',
                            'label' => 'Title',
                            'name' => 'title',
                            'type' => 'text',
                            'default_value' => 'Leadership',
                            'wrapper' => array('width' => '50'),
                        ),
                        array(
                            'key' => 'field_team_highlight',
                            'label' => 'Highlight Word',
                            'name' => 'highlight',
                            'type' => 'text',
                            'default_value' => 'Architects',
                            'wrapper' => array('width' => '50'),
                        ),
                        array(
                            'key' => 'field_team_desc',
                            'label' => 'Description',
                            'name' => 'description',
                            'type' => 'textarea',
                            'rows' => 3,
                            'default_value' => 'Engineering intelligence defined by parametric transparency and global manufacturing excellence.',
                        ),
                    ),
                ),

                // Repeater: Team Members
                array(
                    'key' => 'field_team_members',
                    'label' => 'Team Members',
                    'name' => 'team_members',
                    'type' => 'repeater',
                    'layout' => 'block', // Optimized for vertical space
                    'button_label' => 'Add Member',
                    'collapsed' => 'field_team_member_name',
                    'sub_fields' => array(
                        // Row 1: Basic Info
                        array(
                            'key' => 'field_team_member_img',
                            'label' => 'Portrait',
                            'name' => 'image',
                            'type' => 'image',
                            'return_format' => 'id',
                            'preview_size' => 'thumbnail',
                            'wrapper' => array('width' => '25'),
                        ),
                        array(
                            'key' => 'field_team_member_name',
                            'label' => 'Name',
                            'name' => 'name',
                            'type' => 'text',
                            'placeholder' => 'e.g. Mike Cannon-Brookes',
                            'wrapper' => array('width' => '40'),
                        ),
                        array(
                            'key' => 'field_team_member_role',
                            'label' => 'Role / Job Title',
                            'name' => 'role',
                            'type' => 'text',
                            'placeholder' => 'e.g. CEO & Co-Founder',
                            'wrapper' => array('width' => '35'),
                        ),
                        
                        // Row 2: Details
                        array(
                            'key' => 'field_team_member_exp',
                            'label' => 'Experience (Years)',
                            'name' => 'experience_years',
                            'type' => 'number',
                            'step' => '0.1',
                            'append' => 'YRS',
                            'wrapper' => array('width' => '50'),
                        ),
                        array(
                            'key' => 'field_team_member_linkedin',
                            'label' => 'LinkedIn URL',
                            'name' => 'linkedin',
                            'type' => 'url',
                            'placeholder' => 'https://linkedin.com/in/...',
                            'wrapper' => array('width' => '50'),
                        ),
                    ),
                ),

                /* -------------------------------------------------------------------------- */
                /*                                 Tab: Design                                */
                /* -------------------------------------------------------------------------- */
                array(
                    'key' => 'field_team_tab_design',
                    'label' => 'Design',
                    'type' => 'tab',
                ),
                array(
                    'key' => 'field_team_bg_style',
                    'label' => 'Background Style',
                    'name' => 'background_style',
                    'type' => 'select',
                    'choices' => array(
                        'white' => 'Clean White',
                        'industrial' => 'Industrial Grid (Light Gray)',
                    ),
                    'default_value' => 'industrial',
                    'ui' => 1,
                    'wrapper' => array('width' => '50'),
                ),
                array(
                    'key' => 'field_team_mobile_hide',
                    'label' => 'Mobile Visibility',
                    'name' => 'mobile_hide_content',
                    'type' => 'true_false',
                    'message' => 'Hide this section on mobile devices',
                    'default_value' => 0,
                    'ui' => 1,
                    'wrapper' => array('width' => '50'),
                ),

                /* -------------------------------------------------------------------------- */
                /*                                 Tab: Settings                              */
                /* -------------------------------------------------------------------------- */
                array(
                    'key' => 'field_team_tab_settings',
                    'label' => 'Settings',
                    'type' => 'tab',
                ),
                array(
                    'key' => 'field_team_id',
                    'label' => 'Section ID',
                    'name' => 'section_id',
                    'type' => 'text',
                    'instructions' => 'Optional. Used for anchor links (e.g., #team).',
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
    });
}
