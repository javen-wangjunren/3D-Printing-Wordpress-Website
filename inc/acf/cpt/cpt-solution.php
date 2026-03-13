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
                    'key'          => 'field_sol_acc_hero',
                    'label'        => 'Hero',
                    'type'         => 'accordion',
                    'open'         => 1,
                    'multi_expand' => 0,
                    'endpoint'     => 0,
                ),
                array(
                    'key'          => 'field_sol_clone_hero',
                    'label'        => 'Hero',
                    'name'         => 'solution_hero',
                    'type'         => 'clone',
                    'required'     => 0,
                    'clone'        => array(
                        0 => 'group_application_hero',
                    ),
                    'display'      => 'seamless',
                    'layout'       => 'block',
                    'prefix_label' => 0,
                    'prefix_name'  => 0,
                ),
                array(
                    'key'      => 'field_sol_acc_hero_end',
                    'label'    => '',
                    'type'     => 'accordion',
                    'endpoint' => 1,
                ),

                array(
                    'key'          => 'field_sol_acc_technical_strength',
                    'label'        => 'Technical Strength',
                    'type'         => 'accordion',
                    'open'         => 0,
                    'multi_expand' => 0,
                    'endpoint'     => 0,
                ),
                array(
                    'key'          => 'field_sol_clone_technical_strength',
                    'label'        => 'Technical Strength',
                    'name'         => 'solution_technical_strength',
                    'type'         => 'clone',
                    'required'     => 0,
                    'clone'        => array(
                        0 => 'group_application_technical_strength',
                    ),
                    'display'      => 'seamless',
                    'layout'       => 'block',
                    'prefix_label' => 0,
                    'prefix_name'  => 0,
                ),
                array(
                    'key'      => 'field_sol_acc_technical_strength_end',
                    'label'    => '',
                    'type'     => 'accordion',
                    'endpoint' => 1,
                ),

                array(
                    'key'          => 'field_sol_acc_showcase',
                    'label'        => 'Showcase',
                    'type'         => 'accordion',
                    'open'         => 0,
                    'multi_expand' => 0,
                    'endpoint'     => 0,
                ),
                array(
                    'key'          => 'field_sol_clone_showcase',
                    'label'        => 'Showcase',
                    'name'         => 'solution_showcase',
                    'type'         => 'clone',
                    'required'     => 0,
                    'clone'        => array(
                        0 => 'group_application_showcase',
                    ),
                    'display'      => 'seamless',
                    'layout'       => 'block',
                    'prefix_label' => 0,
                    'prefix_name'  => 0,
                ),
                array(
                    'key'      => 'field_sol_acc_showcase_end',
                    'label'    => '',
                    'type'     => 'accordion',
                    'endpoint' => 1,
                ),

                array(
                    'key'          => 'field_sol_acc_recommendation',
                    'label'        => 'Recommendation',
                    'type'         => 'accordion',
                    'open'         => 0,
                    'multi_expand' => 0,
                    'endpoint'     => 0,
                ),
                array(
                    'key'          => 'field_sol_clone_recommendation',
                    'label'        => 'Recommendation',
                    'name'         => 'solution_recommendation',
                    'type'         => 'clone',
                    'required'     => 0,
                    'clone'        => array(
                        0 => 'group_application_recommendation',
                    ),
                    'display'      => 'seamless',
                    'layout'       => 'block',
                    'prefix_label' => 0,
                    'prefix_name'  => 0,
                ),
                array(
                    'key'      => 'field_sol_acc_recommendation_end',
                    'label'    => '',
                    'type'     => 'accordion',
                    'endpoint' => 1,
                ),

                array(
                    'key'          => 'field_sol_acc_certification',
                    'label'        => 'Certification',
                    'type'         => 'accordion',
                    'open'         => 0,
                    'multi_expand' => 0,
                    'endpoint'     => 0,
                ),
                array(
                    'key'          => 'field_sol_clone_certification',
                    'label'        => 'Certification',
                    'name'         => 'solution_certification',
                    'type'         => 'clone',
                    'required'     => 0,
                    'clone'        => array(
                        0 => 'group_application_certification',
                    ),
                    'display'      => 'seamless',
                    'layout'       => 'block',
                    'prefix_label' => 0,
                    'prefix_name'  => 0,
                ),
                array(
                    'key'      => 'field_sol_acc_certification_end',
                    'label'    => '',
                    'type'     => 'accordion',
                    'endpoint' => 1,
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
