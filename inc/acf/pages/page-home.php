<?php
if ( function_exists( 'acf_add_local_field_group' ) ) {

    add_action( 'acf/init', function() {

        acf_add_local_field_group( array(
            'key' => 'group_page_home',
            'title' => 'Home Page (首页配置)',
            'fields' => array(
                array(
                    'key' => 'field_home_tab_sections',
                    'label' => 'Sections',
                    'type' => 'tab',
                    'placement' => 'top',
                ),
                array(
                    'key' => 'field_home_acc_hero',
                    'label' => 'Hero Banner',
                    'type' => 'accordion',
                    'open' => 1,
                    'multi_expand' => 0,
                    'endpoint' => 0,
                ),
                array(
                    'key' => 'field_home_hero_clone',
                    'label' => 'Hero Banner',
                    'name' => 'home_hero',
                    'type' => 'clone',
                    'required' => 0,
                    'clone' => array(
                        0 => 'group_hero_banner',
                    ),
                    'display' => 'group',
                    'layout' => 'block',
                    'prefix_label' => 0,
                    'prefix_name' => 1,
                ),
                array(
                    'key' => 'field_home_acc_hero_end',
                    'label' => '',
                    'type' => 'accordion',
                    'endpoint' => 1,
                ),
                array(
                    'key' => 'field_home_acc_capability',
                    'label' => 'Capability List',
                    'type' => 'accordion',
                    'open' => 0,
                    'multi_expand' => 0,
                    'endpoint' => 0,
                ),
                array(
                    'key' => 'field_home_capability_clone',
                    'label' => 'Capability List',
                    'name' => 'home_cap',
                    'type' => 'clone',
                    'required' => 0,
                    'clone' => array(
                        0 => 'group_3dp_capability_list',
                    ),
                    'display' => 'group',
                    'layout' => 'block',
                    'prefix_label' => 0,
                    'prefix_name' => 1,
                ),
                array(
                    'key' => 'field_home_acc_capability_end',
                    'label' => '',
                    'type' => 'accordion',
                    'endpoint' => 1,
                ),
                array(
                    'key' => 'field_home_acc_review',
                    'label' => 'Review Grid',
                    'type' => 'accordion',
                    'open' => 0,
                    'multi_expand' => 0,
                    'endpoint' => 0,
                ),
                array(
                    'key' => 'field_home_review_clone',
                    'label' => 'Review Grid',
                    'name' => 'home_rev',
                    'type' => 'clone',
                    'required' => 0,
                    'clone' => array(
                        0 => 'group_66e2a0c0f0c8b0b',
                    ),
                    'display' => 'group',
                    'layout' => 'block',
                    'prefix_label' => 0,
                    'prefix_name' => 1,
                ),
                array(
                    'key' => 'field_home_acc_review_end',
                    'label' => '',
                    'type' => 'accordion',
                    'endpoint' => 1,
                ),
                array(
                    'key' => 'field_home_tab_blog',
                    'label' => 'Blog',
                    'type' => 'tab',
                    'placement' => 'top',
                ),
                array(
                    'key' => 'field_home_acc_blog',
                    'label' => 'Related Blog',
                    'type' => 'accordion',
                    'open' => 0,
                    'multi_expand' => 0,
                    'endpoint' => 0,
                ),
                array(
                    'key' => 'field_home_blog_clone',
                    'label' => 'Related Blog',
                    'name' => 'home_blog',
                    'type' => 'clone',
                    'required' => 0,
                    'clone' => array(
                        0 => 'group_related_blog',
                    ),
                    'display' => 'group',
                    'layout' => 'block',
                    'prefix_label' => 0,
                    'prefix_name' => 1,
                ),
                array(
                    'key' => 'field_home_acc_blog_end',
                    'label' => '',
                    'type' => 'accordion',
                    'endpoint' => 1,
                ),
            ),
            'location' => array(
                array(
                    array(
                        'param' => 'page_type',
                        'operator' => '==',
                        'value' => 'front_page',
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
