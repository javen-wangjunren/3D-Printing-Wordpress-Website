<?php
/**
 * Module: Hero Banner
 * Path: inc/acf/field/hero-banner.php
 * 备注：有两种样式，左图右文，和背景大图两种样式可以切换，一般首页用第二种大气一些，其他的capability和 material用第一种
 */

if ( function_exists( 'acf_add_local_field_group' ) ) {
    add_action( 'acf/init', function() {
        acf_add_local_field_group( array(
            'key'                   => 'group_hero_banner',
            'title'                 => __( 'Hero Banner', '3d-printing' ),
            'location'              => array(
                array(
                    array(
                        'param'    => 'block',
                        'operator' => '==',
                        'value'    => 'acf/hero-banner',
                    ),
                ),
            ),
            'menu_order'            => 0,
            'position'              => 'normal',
            'style'                 => 'default',
            'label_placement'       => 'top',
            'instruction_placement' => 'label',
            'hide_on_screen'        => '',
            'active'                => true,
            'description'           => '',
            'show_in_rest'          => 0,
            'fields'                => array(
                // ======================================================
                // TAB 1: CONTENT
                // ======================================================
                array(
                    'key'               => 'field_hero_tab_content',
                    'label'             => __( 'Content', '3d-printing' ),
                    'type'              => 'tab',
                    'placement'         => 'top',
                ),
                array(
                    'key'               => 'field_hero_title',
                    'label'             => __( 'Main Title', '3d-printing' ),
                    'name'              => 'hero_title',
                    'type'              => 'text',
                    'instructions'      => __( 'The main headline of the banner.', '3d-printing' ),
                    'required'          => 1,
                    'default_value'     => __( 'Your Streamlined 3D Printing Service', '3d-printing' ),
                    'wrapper'           => array(
                        'width' => '100',
                    ),
                ),
                array(
                    'key'               => 'field_hero_subtitle',
                    'label'             => __( 'Subtitle', '3d-printing' ),
                    'name'              => 'hero_subtitle',
                    'type'              => 'text',
                    'instructions'      => __( 'A supporting sub-headline.', '3d-printing' ),
                    'required'          => 1,
                    'default_value'     => __( 'Get Quality Parts at the Best Price', '3d-printing' ),
                    'wrapper'           => array(
                        'width' => '100',
                    ),
                ),
                array(
                    'key'               => 'field_hero_description',
                    'label'             => __( 'Description', '3d-printing' ),
                    'name'              => 'hero_description',
                    'type'              => 'textarea',
                    'instructions'      => __( 'The main body text description.', '3d-printing' ),
                    'required'          => 1,
                    'rows'              => 4,
                    'new_lines'         => 'wpautop',
                    'default_value'     => __( "Compare manufacturers around the world in real time.\nOrder industrial-quality parts at the most competitive price.\nWe take care of everything, including your satisfaction.", '3d-printing' ),
                ),
                array(
                    'key'               => 'field_hero_buttons',
                    'label'             => __( 'Buttons', '3d-printing' ),
                    'name'              => 'hero_buttons',
                    'type'              => 'repeater',
                    'instructions'      => __( 'Add call-to-action buttons.', '3d-printing' ),
                    'collapsed'         => 'field_button_text',
                    'layout'            => 'block',
                    'button_label'      => __( 'Add Button', '3d-printing' ),
                    'sub_fields'        => array(
                        array(
                            'key'           => 'field_button_text',
                            'label'         => __( 'Button Text', '3d-printing' ),
                            'name'          => 'button_text',
                            'type'          => 'text',
                            'required'      => 1,
                            'wrapper'       => array(
                                'width' => '33',
                            ),
                        ),
                        array(
                            'key'           => 'field_button_url',
                            'label'         => __( 'Button URL', '3d-printing' ),
                            'name'          => 'button_url',
                            'type'          => 'url',
                            'required'      => 1,
                            'wrapper'       => array(
                                'width' => '50',
                            ),
                        ),
                        array(
                            'key'           => 'field_button_style',
                            'label'         => __( 'Style', '3d-printing' ),
                            'name'          => 'button_style',
                            'type'          => 'select',
                            'choices'       => array(
                                'primary'   => __( 'Primary (Solid)', '3d-printing' ),
                                'secondary' => __( 'Secondary (Outline)', '3d-printing' ),
                            ),
                            'default_value' => 'primary',
                            'required'      => 1,
                            'wrapper'       => array(
                                'width' => '17',
                            ),
                        ),
                    ),
                ),

                // ======================================================
                // TAB 2: DESIGN (Mobile First Optimized)
                // ======================================================
                array(
                    'key'               => 'field_hero_tab_design',
                    'label'             => __( 'Design', '3d-printing' ),
                    'type'              => 'tab',
                    'placement'         => 'top',
                ),
                array(
                    'key'               => 'field_hero_layout',
                    'label'             => __( 'Desktop Layout', '3d-printing' ),
                    'name'              => 'hero_layout',
                    'type'              => 'select',
                    'instructions'      => __( 'Choose the layout structure for desktop view.', '3d-printing' ),
                    'choices'           => array(
                        'split'    => __( 'Split (Text Left / Image Right)', '3d-printing' ),
                        'centered' => __( 'Centered (Text Center / Image Background)', '3d-printing' ),
                    ),
                    'default_value'     => 'split',
                    'wrapper'           => array(
                        'width' => '50',
                    ),
                ),
                array(
                    'key'               => 'field_hero_mobile_compact',
                    'label'             => __( 'Mobile Compact Mode', '3d-printing' ),
                    'name'              => 'hero_mobile_compact',
                    'type'              => 'true_false',
                    'instructions'      => __( 'Reduce padding and font sizes on mobile for a more compact view?', '3d-printing' ),
                    'ui'                => 1,
                    'wrapper'           => array(
                        'width' => '50',
                    ),
                ),
                array(
                    'key'               => 'field_hero_image',
                    'label'             => __( 'Desktop Image', '3d-printing' ),
                    'name'              => 'hero_image',
                    'type'              => 'image',
                    'instructions'      => __( '<b>Split Layout:</b> 1200x900px (4:3) - Occupies half screen.<br><b>Centered Layout:</b> 1920x1080px (16:9) - Fullscreen background. Subject off-center.', '3d-printing' ),
                    'return_format'     => 'id',
                    'preview_size'      => 'medium',
                    'library'           => 'all',
                    'required'          => 1,
                    'wrapper'           => array(
                        'width' => '50',
                    ),
                ),
                array(
                    'key'               => 'field_hero_mobile_image',
                    'label'             => __( 'Mobile Image', '3d-printing' ),
                    'name'              => 'hero_mobile_image',
                    'type'              => 'image',
                    'instructions'      => __( '<b>Split Layout:</b> 800x600px (4:3) or 800x800px (1:1).<br><b>Centered Layout:</b> 1080x1920px (9:16) - Vertical portrait mandatory.', '3d-printing' ),
                    'return_format'     => 'id',
                    'preview_size'      => 'medium',
                    'library'           => 'all',
                    'wrapper'           => array(
                        'width' => '50',
                    ),
                ),
                // Colors - Grouped for compactness
                array(
                    'key'               => 'field_hero_bg_color',
                    'label'             => __( 'Background', '3d-printing' ),
                    'name'              => 'hero_background_color',
                    'type'              => 'color_picker',
                    'default_value'     => '#ffffff',
                    'wrapper'           => array( 'width' => '25' ),
                ),
                array(
                    'key'               => 'field_hero_text_color',
                    'label'             => __( 'Text', '3d-printing' ),
                    'name'              => 'hero_text_color',
                    'type'              => 'color_picker',
                    'default_value'     => '#000000',
                    'wrapper'           => array( 'width' => '25' ),
                ),
                array(
                    'key'               => 'field_hero_btn_p_color',
                    'label'             => __( 'Btn Primary', '3d-printing' ),
                    'name'              => 'hero_primary_button_color',
                    'type'              => 'color_picker',
                    'default_value'     => '#0073aa',
                    'wrapper'           => array( 'width' => '25' ),
                ),
                array(
                    'key'               => 'field_hero_btn_s_color',
                    'label'             => __( 'Btn Secondary', '3d-printing' ),
                    'name'              => 'hero_secondary_button_color',
                    'type'              => 'color_picker',
                    'default_value'     => '#ffffff',
                    'wrapper'           => array( 'width' => '25' ),
                ),

                // ======================================================
                // TAB 3: SETTINGS & STATS
                // ======================================================
                array(
                    'key'               => 'field_hero_tab_settings',
                    'label'             => __( 'Settings', '3d-printing' ),
                    'type'              => 'tab',
                    'placement'         => 'top',
                ),
                array(
                    'key'               => 'field_hero_show_stats',
                    'label'             => __( 'Show Stats Bar', '3d-printing' ),
                    'name'              => 'hero_show_stats',
                    'type'              => 'true_false',
                    'ui'                => 1,
                    'default_value'     => 1,
                    'message'           => __( 'Display the statistics bar at the bottom?', '3d-printing' ),
                ),
                array(
                    'key'               => 'field_hero_stats',
                    'label'             => __( 'Statistics', '3d-printing' ),
                    'name'              => 'hero_stats',
                    'type'              => 'repeater',
                    'instructions'      => __( 'Add up to 4 stats. Desktop: 4 cols. Mobile: 2 cols.', '3d-printing' ),
                    'collapsed'         => 'field_stat_number',
                    'min'               => 0,
                    'max'               => 4,
                    'layout'            => 'table', // Table is cleaner for simple key-value pairs
                    'button_label'      => __( 'Add Stat', '3d-printing' ),
                    'conditional_logic' => array(
                        array(
                            array(
                                'field'    => 'field_hero_show_stats',
                                'operator' => '==',
                                'value'    => '1',
                            ),
                        ),
                    ),
                    'sub_fields'        => array(
                        array(
                            'key'           => 'field_stat_number',
                            'label'         => __( 'Number / Value', '3d-printing' ),
                            'name'          => 'stat_number',
                            'type'          => 'text',
                            'placeholder'   => 'e.g. 500+',
                            'required'      => 1,
                            'wrapper'       => array( 'width' => '40' ),
                        ),
                        array(
                            'key'           => 'field_stat_description',
                            'label'         => __( 'Label / Description', '3d-printing' ),
                            'name'          => 'stat_description',
                            'type'          => 'text',
                            'placeholder'   => 'e.g. Materials',
                            'required'      => 1,
                            'wrapper'       => array( 'width' => '60' ),
                        ),
                    ),
                ),
            ),
        ) );
    } );
}
