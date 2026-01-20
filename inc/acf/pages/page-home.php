<?php

if ( function_exists( 'acf_add_local_field_group' ) ) {

    add_action( 'acf/init', function() {

        acf_add_local_field_group( array(
            'key' => 'group_page_home',
            'title' => 'Home Page (首页配置)',
            'fields' => array(
                array(
                    'key' => 'field_home_tab_overview',
                    'label' => 'Overview',
                    'type' => 'tab',
                    'placement' => 'top',
                ),
                array(
                    'key' => 'field_home_overview_hero_clone_v2',
                    'label' => 'Hero Banner',
                    'name' => 'home_hero',
                    'type' => 'clone',
                    'clone' => array(
                        0 => 'group_hero_banner',
                    ),
                    'display' => 'group',
                    'layout' => 'block',
                    'prefix_label' => 0,
                    'prefix_name' => 1,
                ),
                array(
                    'key' => 'field_home_tab_capability',
                    'label' => 'Capability',
                    'type' => 'tab',
                    'placement' => 'top',
                ),
                array(
                    'key' => 'field_home_capability_clone_v2',
                    'label' => 'Capability List',
                    'name' => 'home_cap',
                    'type' => 'clone',
                    'clone' => array(
                        0 => 'group_3dp_capability_list',
                    ),
                    'display' => 'group',
                    'layout' => 'block',
                    'prefix_label' => 0,
                    'prefix_name' => 1,
                ),
                array(
                    'key' => 'field_home_tab_review',
                    'label' => 'Review',
                    'type' => 'tab',
                    'placement' => 'top',
                ),
                array(
                    'key' => 'field_home_review_clone_v2',
                    'label' => 'Review Grid',
                    'name' => 'home_rev',
                    'type' => 'clone',
                    'clone' => array(
                        0 => 'group_66e2a0c0f0c8b0b',
                    ),
                    'display' => 'group',
                    'layout' => 'block',
                    'prefix_label' => 0,
                    'prefix_name' => 1,
                ),
                array(
                    'key' => 'field_home_tab_blog',
                    'label' => 'Blog',
                    'type' => 'tab',
                    'placement' => 'top',
                ),
                array(
                    'key' => 'field_home_blog_clone_v2',
                    'label' => 'Related Blog',
                    'name' => 'home_blog',
                    'type' => 'clone',
                    'clone' => array(
                        0 => 'group_related_blog',
                    ),
                    'display' => 'group',
                    'layout' => 'block',
                    'prefix_label' => 0,
                    'prefix_name' => 1,
                ),
            ),
            'location' => array(
                array(
                    array(
                        'param' => 'page_template',
                        'operator' => '==',
                        'value' => 'templates/page-home.php',
                    ),
                ),
            ),
            'menu_order' => 0,
            'position' => 'normal',
            'style' => 'group',
            'label_placement' => 'top',
            'instruction_placement' => 'label',
            'active' => true,
        ) );
    } );
}
