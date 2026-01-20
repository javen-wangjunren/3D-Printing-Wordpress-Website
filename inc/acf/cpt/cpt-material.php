<?php
/**
 * 角色：Material CPT 模块的字段 Schema 定义
 * 位置：/inc/acf/cpt/cpt-material.php
 * 说明：材料自定义post类型的字段逻辑
 */

if ( function_exists( 'acf_add_local_field_group' ) ) {

    add_action( 'acf/init', function() {
        acf_add_local_field_group( array(
            'key'   => 'group_cpt_material_fields',
            'title' => 'Material Fields',
            'fields' => array(
                array(
                    'key'       => 'field_mat_tab_overview',
                    'label'     => 'Overview',
                    'type'      => 'tab',
                    'placement' => 'top',
                ),
                array(
                    'key'          => 'field_mat_hero_clone',
                    'label'        => 'Hero Banner',
                    'name'         => 'mat_hero',
                    'type'         => 'clone',
                    'clone'        => array(
                        0 => 'group_hero_banner',
                    ),
                    'display'      => 'group',
                    'prefix_label' => 0,
                    'prefix_name'  => 1,
                    'wrapper'      => array( 'width' => '100' ),
                ),
                array(
                    'key'          => 'field_mat_mfs_clone',
                    'label'        => 'Manufacturing Showcase',
                    'name'         => 'mat_showcase',
                    'type'         => 'clone',
                    'clone'        => array(
                        0 => 'group_3dp_manufacturing_showcase',
                    ),
                    'display'      => 'group',
                    'prefix_label' => 0,
                    'prefix_name'  => 1,
                    'wrapper'      => array( 'width' => '100' ),
                ),

                array(
                    'key'       => 'field_mat_tab_tech',
                    'label'     => 'Technical Specs',
                    'type'      => 'tab',
                    'placement' => 'top',
                ),
                array(
                    'key'          => 'field_mat_ts_clone',
                    'label'        => 'Technical Specs',
                    'name'         => 'mat_tech_specs',
                    'type'         => 'clone',
                    'clone'        => array(
                        0 => 'group_3dp_technical_specs',
                    ),
                    'display'      => 'group',
                    'prefix_label' => 0,
                    'prefix_name'  => 1,
                    'wrapper'      => array( 'width' => '100' ),
                ),
                array(
                    'key'          => 'field_mat_mcap_clone',
                    'label'        => 'Manufacturing Capabilities',
                    'name'         => 'mat_capabilities',
                    'type'         => 'clone',
                    'clone'        => array(
                        0 => 'group_3dp_manufacturing_capabilities',
                    ),
                    'display'      => 'group',
                    'prefix_label' => 0,
                    'prefix_name'  => 1,
                    'wrapper'      => array( 'width' => '100' ),
                ),

                array(
                    'key'       => 'field_mat_tab_blog',
                    'label'     => 'Blog',
                    'type'      => 'tab',
                    'placement' => 'top',
                ),
                array(
                    'key'          => 'field_mat_related_blog_clone',
                    'label'        => 'Related Blog',
                    'name'         => 'mat_related_blog',
                    'type'         => 'clone',
                    'clone'        => array(
                        0 => 'group_related_blog',
                    ),
                    'display'      => 'group',
                    'prefix_label' => 0,
                    'prefix_name'  => 1,
                    'wrapper'      => array( 'width' => '100' ),
                ),

            ),
            'location' => array(
                array(
                    array(
                        'param'    => 'post_type',
                        'operator' => '==',
                        'value'    => 'material',
                    ),
                ),
            ),
            'menu_order'            => 0,
            'position'              => 'normal',
            'style'                 => 'default',
            'label_placement'       => 'top',
            'instruction_placement' => 'label',
            'active'                => true,
        ) );

    } );
}
