<?php
/**
 * Page: Contact
 * Path: inc/acf/pages/page-contact.php
 */

if ( function_exists( 'acf_add_local_field_group' ) ) {
    add_action( 'acf/init', function() {
        acf_add_local_field_group( array(
            'key'                   => 'group_page_contact',
            'title'                 => __( 'Page: Contact', '3d-printing' ),
            'location'              => array(
                array(
                    array(
                        'param'    => 'page_template',
                        'operator' => '==',
                        'value'    => 'templates/page-contact.php',
                    ),
                ),
            ),
            'menu_order'            => 0,
            'position'              => 'normal',
            'style'                 => 'seamless', // Seamless to allow tabs from cloned group to merge
            'label_placement'       => 'top',
            'instruction_placement' => 'label',
            'active'                => true,
            'fields'                => array(
                // ======================================================
                // TAB 1-3: HERO BANNER (Cloned)
                // ======================================================
                // The Hero Banner group already contains 3 tabs: Content, Design, Settings.
                // We clone it seamlessly so these tabs appear directly.
                array(
                    'key'           => 'field_contact_hero_clone',
                    'label'         => 'Hero Banner',
                    'name'          => 'contact_hero_clone',
                    'type'          => 'clone',
                    'clone'         => array(
                        0 => 'group_hero_banner',
                    ),
                    'display'       => 'seamless',
                    'layout'        => 'block',
                    'prefix_label'  => 0,
                    'prefix_name'   => 0, // Keep original field names (hero_title, etc.)
                ),

                // ======================================================
                // TAB 4: FORM
                // ======================================================
                array(
                    'key'       => 'field_contact_tab_form',
                    'label'     => __( 'Contact Form', '3d-printing' ),
                    'type'      => 'tab',
                    'placement' => 'top',
                ),
                array(
                    'key'           => 'field_contact_form_title',
                    'label'         => __( 'Form Section Title', '3d-printing' ),
                    'name'          => 'contact_form_title',
                    'type'          => 'text',
                    'default_value' => __( 'Send us a message', '3d-printing' ),
                    'wrapper'       => array( 'width' => '50' ),
                ),
                array(
                    'key'           => 'field_contact_form_shortcode',
                    'label'         => __( 'Fluent Form Shortcode', '3d-printing' ),
                    'name'          => 'contact_form_shortcode',
                    'type'          => 'text',
                    'default_value' => '[fluentform id="1"]',
                    'instructions'  => __( 'Enter the Fluent Form shortcode.', '3d-printing' ),
                    'required'      => 1,
                    'wrapper'       => array( 'width' => '50' ),
                ),
            ),
        ) );
    } );
}
