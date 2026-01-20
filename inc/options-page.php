<?php
/**
 * ACF Options Page 注册
 * 创建全局设置页，用于存储通用模块内容
 */

if ( function_exists( 'acf_add_options_page' ) ) {
	add_action( 'acf/init', function() {
		acf_add_options_page( array(
			'page_title'    => 'Global Settings',
			'menu_title'    => 'Global Settings',
			'menu_slug'     => 'acf-options-global-settings',
			'capability'    => 'edit_posts',
			'redirect'      => true,
			'icon_url'      => 'dashicons-admin-generic'
		) );

		acf_add_options_sub_page( array(
			'page_title'  => 'Header',
			'menu_title'  => 'Header',
			'parent_slug' => 'acf-options-global-settings',
		) );

		acf_add_options_sub_page( array(
			'page_title'  => 'Footer',
			'menu_title'  => 'Footer',
			'parent_slug' => 'acf-options-global-settings',
		) );

		acf_add_options_sub_page( array(
			'page_title'  => 'Global Modules',
			'menu_title'  => 'Global Modules',
			'parent_slug' => 'acf-options-global-settings',
		) );
	} );
}

// 注册全局模块的ACF字段组
if ( function_exists( 'acf_add_local_field_group' ) ) {
	
	add_action( 'acf/init', function() {
        
        // ======================================================
        // 全局模块字段组
        // ======================================================
		acf_add_local_field_group( array(
			'key' => 'group_3dp_global_modules',
			'title' => 'Global Modules (全局通用模块)',
			'fields' => array(
                // Why Choose Us
                array(
                    'key' => 'field_global_why_choose_us',
                    'label' => 'Why Choose Us',
                    'name' => 'global_why_choose_us',
                    'type' => 'group',
                    'layout' => 'block',
                    'sub_fields' => array(
                        array(
                            'key' => 'field_global_wcu_clone',
                            'label' => 'Why Choose Us Fields',
                            'name' => 'wcu_clone',
                            'type' => 'clone',
                            'clone' => array(
                                0 => 'group_66e1c0f0c8b0b',
                            ),
                            'display' => 'seamless',
                            'layout' => 'block',
                            'prefix_label' => 0,
                            'prefix_name' => 0,
                        ),
                    ),
                ),
                
                // Order Process
                array(
                    'key' => 'field_global_order_process',
                    'label' => 'Order Process',
                    'name' => 'global_order_process',
                    'type' => 'group',
                    'layout' => 'block',
                    'sub_fields' => array(
                        array(
                            'key' => 'field_global_op_clone',
                            'label' => 'Order Process Fields',
                            'name' => 'op_clone',
                            'type' => 'clone',
                            'clone' => array(
                                0 => 'group_3dp_order_process',
                            ),
                            'display' => 'seamless',
                            'layout' => 'block',
                            'prefix_label' => 0,
                            'prefix_name' => 0,
                        ),
                    ),
                ),
                
                // CTA
                array(
                    'key' => 'field_global_cta',
                    'label' => 'CTA',
                    'name' => 'global_cta',
                    'type' => 'group',
                    'layout' => 'block',
                    'sub_fields' => array(
                        array(
                            'key' => 'field_global_cta_clone',
                            'label' => 'CTA Fields',
                            'name' => 'cta_clone',
                            'type' => 'clone',
                            'clone' => array(
                                0 => 'group_66e4c0c0f0c8b0b',
                            ),
                            'display' => 'seamless',
                            'layout' => 'block',
                            'prefix_label' => 0,
                            'prefix_name' => 0,
                        ),
                    ),
                ),
                
                // Trusted By
                array(
                    'key' => 'field_global_trusted_by',
                    'label' => 'Trusted By',
                    'name' => 'global_trusted_by',
                    'type' => 'group',
                    'layout' => 'block',
                    'sub_fields' => array(
                        array(
                            'key' => 'field_global_tb_clone',
                            'label' => 'Trusted By Fields',
                            'name' => 'tb_clone',
                            'type' => 'clone',
                            'clone' => array(
                                0 => 'group_trusted_by',
                            ),
                            'display' => 'seamless',
                            'layout' => 'block',
                            'prefix_label' => 0,
                            'prefix_name' => 0,
                        ),
                    ),
                ),
                
                // Industry Slider
                array(
                    'key' => 'field_global_industry_slider',
                    'label' => 'Industry Slider',
                    'name' => 'global_industry_slider',
                    'type' => 'group',
                    'layout' => 'block',
                    'sub_fields' => array(
                        array(
                            'key' => 'field_global_is_clone',
                            'label' => 'Industry Slider Fields',
                            'name' => 'is_clone',
                            'type' => 'clone',
                            'clone' => array(
                                0 => 'group_3dp_industry_slider',
                            ),
                            'display' => 'seamless',
                            'layout' => 'block',
                            'prefix_label' => 0,
                            'prefix_name' => 0,
                        ),
                    ),
                ),
			),
			'location' => array(
				array(
					array(
						'param' => 'options_page',
						'operator' => '==',
						'value' => 'acf-options-global-modules',
					),
				),
			),
		) );

	} );
}
