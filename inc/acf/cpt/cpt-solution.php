<?php
/**
 * ACF Field Group: Solution (应用场景)
 * 
 * @package 3D Printing
 */

if ( function_exists( 'acf_add_local_field_group' ) ) {

    add_action( 'acf/init', function() {
        
        acf_add_local_field_group( array(
            'key' => 'group_solution_main',
            'title' => 'Solution Fields',
            'fields' => array(
                // ======================================================
                // TAB 1: Content
                // ======================================================
                array(
                    'key' => 'field_sol_tab_content',
                    'label' => 'Content',
                    'type' => 'tab',
                    'placement' => 'top',
                ),
                array(
                    'key' => 'field_sol_message',
                    'label' => 'Message',
                    'type' => 'message',
                    'message' => 'Please define fields for Solution CPT here.',
                ),
            ),
            'location' => array(
                array(
                    array(
                        'param' => 'post_type',
                        'operator' => '==',
                        'value' => 'solution',
                    ),
                ),
            ),
            'menu_order' => 0,
            'position' => 'normal',
            'style' => 'default',
            'label_placement' => 'top',
            'instruction_placement' => 'label',
            'active' => true,
        ) );

    } );
}
