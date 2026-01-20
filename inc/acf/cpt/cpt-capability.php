<?php
/**
 * 为 Capability CPT 增加页面布局管理字段
 * 用于控制 single-capability.php 页面的模块内容和配置
 */

if ( function_exists( 'acf_add_local_field_group' ) ) {


    add_action( 'acf/init', function() {
        acf_add_local_field_group( array(
            'key' => 'group_3dp_capability_page_layout',
            'title' => 'Capability Page Content (页面内容配置)',
            'fields' => array(
                array(
                    'key' => 'field_cap_tab_hero',
                    'label' => 'Overview',
                    'type' => 'tab',
                    'placement' => 'top',
                ),
                array(
                    'key' => 'field_cap_hero_clone',
                    'label' => 'Hero Banner',
                    'name' => 'cap_hero',
                    'type' => 'clone',
                    'clone' => array(
                        0 => 'group_hero_banner',
                    ),
                    'display' => 'group',
                    'prefix_label' => 0,
                    'prefix_name' => 1,
                    'wrapper' => array('width' => '100'),
                ),
                array(
                    'key' => 'field_cap_hiw_clone',
                    'label' => 'Process (How It Works)',
                    'name' => 'cap_process',
                    'type' => 'clone',
                    'clone' => array(
                        0 => 'group_3dp_how_it_works',
                    ),
                    'display' => 'group',
                    'prefix_label' => 0,
                    'prefix_name' => 1,
                    'wrapper' => array('width' => '100'),
                ),

                array(
                    'key' => 'field_cap_tab_design_guide',
                    'label' => 'Design Guide',
                    'type' => 'tab',
                    'placement' => 'top',
                ),
                array(
                    'key' => 'field_cap_cdg_clone',
                    'label' => 'Design Guide',
                    'name' => 'cap_design_guide',
                    'type' => 'clone',
                    'clone' => array(
                        0 => 'group_3dp_capability_design_guide',
                    ),
                    'display' => 'group',
                    'prefix_label' => 0,
                    'prefix_name' => 1,
                    'wrapper' => array('width' => '100'),
                ),

                array(
                    'key' => 'field_cap_tab_tech_specs',
                    'label' => 'Technical Specs',
                    'type' => 'tab',
                    'placement' => 'top',
                ),
                array(
                    'key' => 'field_cap_ml_clone',
                    'label' => 'Material List',
                    'name' => 'cap_material_list',
                    'type' => 'clone',
                    'clone' => array(
                        0 => 'group_3dp_material_list',
                    ),
                    'display' => 'group',
                    'prefix_label' => 0,
                    'prefix_name' => 1,
                    'wrapper' => array('width' => '100'),
                ),
                array(
                    'key' => 'field_cap_ct_clone',
                    'label' => 'Comparison Table',
                    'name' => 'cap_comparison',
                    'type' => 'clone',
                    'clone' => array(
                        0 => 'group_3dp_comparison_table',
                    ),
                    'display' => 'group',
                    'prefix_label' => 0,
                    'prefix_name' => 1,
                    'wrapper' => array('width' => '100'),
                ),

                array(
                    'key' => 'field_cap_tab_blog',
                    'label' => 'Blog',
                    'type' => 'tab',
                    'placement' => 'top',
                ),
                array(
                    'key' => 'field_cap_related_blog_clone',
                    'label' => 'Related Blog',
                    'name' => 'cap_related_blog',
                    'type' => 'clone',
                    'clone' => array(
                        0 => 'group_related_blog',
                    ),
                    'display' => 'group',
                    'prefix_label' => 0,
                    'prefix_name' => 1,
                    'wrapper' => array('width' => '100'),
                ),
            ),
            'location' => array(
                array(
                    array(
                        'param' => 'post_type',
                        'operator' => '==',
                        'value' => 'capability',
                    ),
                ),
            ),
            'style' => 'default',
            'instruction_placement' => 'label',
        ) );
    });
}
