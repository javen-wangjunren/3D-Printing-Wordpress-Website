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
                    'required'          => 0,
                    'default_value'     => __( 'Your Streamlined 3D Printing Service', '3d-printing' ),
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
                    'required'          => 0,
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
                            'key'           => 'field_button_link',
                            'label'         => __( 'Button Link', '3d-printing' ),
                            'name'          => 'button_link',
                            'type'          => 'link',
                            'required'      => 0,
                            'wrapper'       => array(
                                'width' => '60',
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
                            'required'      => 0,
                            'wrapper'       => array(
                                'width' => '40',
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
                    'required'          => 0,
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
            ),
        ) );
    } );
}
