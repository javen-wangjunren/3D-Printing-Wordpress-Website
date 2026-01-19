<?php
/**
 * Page: About Us
 * Location: inc/acf/pages/page-about.php
 * Description: ACF Field Group for the About Us page template.
 * Structure:
 * - Tab 1: Hero Banner (Clone)
 * - Tab 2: About (Mission, Timeline, Team - Clones)
 * - Tab 3: Factory (Factory Image - Clone)
 */

if ( function_exists( 'acf_add_local_field_group' ) ) {

    add_action( 'acf/init', function() {

        acf_add_local_field_group( array(
            'key' => 'group_page_about',
            'title' => 'Page: About Us (关于我们)',
            'fields' => array(
                // ======================================================
                // TAB 1: HERO BANNER
                // ======================================================
                array(
                    'key' => 'field_about_tab_hero',
                    'label' => 'Hero Banner',
                    'type' => 'tab',
                    'placement' => 'top',
                ),
                array(
                    'key' => 'field_about_hero_clone',
                    'label' => 'Hero Banner',
                    'name' => '',
                    'type' => 'clone',
                    'clone' => array(
                        'field_hero_title',
                        'field_hero_subtitle',
                        'field_hero_description',
                        'field_hero_buttons',
                        'field_hero_layout',
                        'field_hero_mobile_compact',
                        'field_hero_image',
                        'field_hero_mobile_image',
                        'field_hero_bg_color',
                        'field_hero_text_color',
                        'field_hero_btn_p_color',
                        'field_hero_btn_s_color',
                        'field_hero_show_stats',
                        'field_hero_stats',
                    ),
                    'display' => 'group',
                    'layout' => 'block',
                    'prefix_label' => 0,
                    'prefix_name' => 0,
                ),

                // ======================================================
                // TAB 2: ABOUT MODULES (Mission, Timeline, Team)
                // ======================================================
                array(
                    'key' => 'field_about_tab_modules',
                    'label' => 'About',
                    'type' => 'tab',
                    'placement' => 'top',
                ),
                
                // Module: Mission
                array(
                    'key' => 'field_about_mission_clone',
                    'label' => 'Mission & Vision',
                    'name' => '',
                    'type' => 'clone',
                    'clone' => array(
                        'field_mission_header_group',
                        'field_mission_items',
                        'field_mission_mobile_hide',
                        'field_mission_bg_style',
                        'field_mission_anchor',
                    ),
                    'display' => 'group',
                    'layout' => 'block',
                    'prefix_label' => 0,
                    'prefix_name' => 0,
                ),

                // Module: Timeline
                array(
                    'key' => 'field_about_timeline_clone',
                    'label' => 'Timeline & History',
                    'name' => '',
                    'type' => 'clone',
                    'clone' => array(
                        'field_timeline_header_group',
                        'field_timeline_items',
                        'field_timeline_bg_style',
                        'field_timeline_anchor',
                    ),
                    'display' => 'group',
                    'layout' => 'block',
                    'prefix_label' => 0,
                    'prefix_name' => 0,
                ),

                // Module: Team
                array(
                    'key' => 'field_about_team_clone',
                    'label' => 'Leadership Team',
                    'name' => '',
                    'type' => 'clone',
                    'clone' => array(
                        'field_team_header',
                        'field_team_members',
                        'field_team_bg_style',
                        'field_team_mobile_hide',
                        'field_team_id',
                    ),
                    'display' => 'group',
                    'layout' => 'block',
                    'prefix_label' => 0,
                    'prefix_name' => 0,
                ),

                // ======================================================
                // TAB 3: FACTORY
                // ======================================================
                array(
                    'key' => 'field_about_tab_factory',
                    'label' => 'Factory',
                    'type' => 'tab',
                    'placement' => 'top',
                ),
                array(
                    'key' => 'field_about_factory_clone',
                    'label' => 'Factory Image Grid',
                    'name' => '',
                    'type' => 'clone',
                    'clone' => array(
                        'field_factory_image_header',
                        'field_factory_image_items',
                        'field_factory_image_bg',
                        'field_factory_image_mobile_opt',
                        'field_factory_image_id',
                        'field_factory_image_class',
                    ),
                    'display' => 'group',
                    'layout' => 'block',
                    'prefix_label' => 0,
                    'prefix_name' => 0,
                ),
            ),
            'location' => array(
                array(
                    array(
                        'param' => 'page_template',
                        'operator' => '==',
                        'value' => 'templates/page-about.php',
                    ),
                ),
            ),
            'menu_order' => 0,
            'position' => 'normal',
            'style' => 'seamless',
            'label_placement' => 'top',
            'instruction_placement' => 'label',
            'active' => true,
        ) );
    } );
}
