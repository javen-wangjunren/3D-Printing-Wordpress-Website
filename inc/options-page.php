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
                            'key' => 'field_global_wcu_title',
                            'label' => 'Title',
                            'name' => 'title',
                            'type' => 'text',
                        ),
                        array(
                            'key' => 'field_global_wcu_list',
                            'label' => 'Features List',
                            'name' => 'features_list',
                            'type' => 'repeater',
                            'collapsed' => 'field_global_wcu_feature_title',
                            'layout' => 'block',
                            'sub_fields' => array(
                                array(
                                    'key' => 'field_global_wcu_feature_title',
                                    'label' => 'Feature Title',
                                    'name' => 'title',
                                    'type' => 'text',
                                ),
                                array(
                                    'key' => 'field_global_wcu_feature_desc',
                                    'label' => 'Feature Description',
                                    'name' => 'description',
                                    'type' => 'textarea',
                                    'rows' => 2,
                                ),
                            ),
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
                            'key' => 'field_global_op_title',
                            'label' => 'Title',
                            'name' => 'title',
                            'type' => 'text',
                        ),
                        array(
                            'key' => 'field_global_op_steps',
                            'label' => 'Steps',
                            'name' => 'steps',
                            'type' => 'repeater',
                            'collapsed' => 'field_global_op_step_title',
                            'layout' => 'block',
                            'sub_fields' => array(
                                array(
                                    'key' => 'field_global_op_step_title',
                                    'label' => 'Step Title',
                                    'name' => 'title',
                                    'type' => 'text',
                                ),
                                array(
                                    'key' => 'field_global_op_step_desc',
                                    'label' => 'Step Description',
                                    'name' => 'description',
                                    'type' => 'textarea',
                                    'rows' => 2,
                                ),
                                array(
                                    'key' => 'field_global_op_step_icon',
                                    'label' => 'Step Icon (SVG)',
                                    'name' => 'icon',
                                    'type' => 'textarea',
                                    'rows' => 4,
                                ),
                            ),
                        ),
                        array(
                            'key' => 'field_global_op_cta',
                            'label' => 'CTA Button',
                            'name' => 'cta_button',
                            'type' => 'link',
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
                            'key' => 'field_global_cta_title',
                            'label' => 'Title',
                            'name' => 'title',
                            'type' => 'text',
                        ),
                        array(
                            'key' => 'field_global_cta_desc',
                            'label' => 'Description',
                            'name' => 'description',
                            'type' => 'textarea',
                            'rows' => 3,
                        ),
                        array(
                            'key' => 'field_global_cta_button',
                            'label' => 'Button',
                            'name' => 'button',
                            'type' => 'link',
                        ),
                        array(
                            'key' => 'field_global_cta_image',
                            'label' => 'Background Image',
                            'name' => 'background_image',
                            'type' => 'image',
                            'return_format' => 'id',
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
                            'key' => 'field_global_tb_title',
                            'label' => 'Title',
                            'name' => 'title',
                            'type' => 'text',
                        ),
                        array(
                            'key' => 'field_global_tb_logos',
                            'label' => 'Partner Logos',
                            'name' => 'logos',
                            'type' => 'repeater',
                            'collapsed' => 'field_global_tb_logo_name',
                            'layout' => 'block',
                            'button_label' => 'Add Partner Logo',
                            'sub_fields' => array(
                                array(
                                    'key' => 'field_global_tb_logo_name',
                                    'label' => 'Partner Name',
                                    'name' => 'name',
                                    'type' => 'text',
                                    'wrapper' => array('width' => '50'),
                                ),
                                array(
                                    'key' => 'field_global_tb_logo_image',
                                    'label' => 'Logo Image',
                                    'name' => 'image',
                                    'type' => 'image',
                                    'return_format' => 'id',
                                    'preview_size' => 'medium',
                                    'wrapper' => array('width' => '50'),
                                ),
                                array(
                                    'key' => 'field_global_tb_logo_link',
                                    'label' => 'Partner Link',
                                    'name' => 'link',
                                    'type' => 'link',
                                    'default_value' => array('url' => '#', 'title' => '', 'target' => ''),
                                ),
                            ),
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
                            'key' => 'field_global_is_title',
                            'label' => 'Title',
                            'name' => 'title',
                            'type' => 'text',
                        ),
                        array(
                            'key' => 'field_global_is_desc',
                            'label' => 'Description',
                            'name' => 'description',
                            'type' => 'textarea',
                            'rows' => 3,
                        ),
                        array(
                            'key' => 'field_global_is_cases',
                            'label' => 'Industry Cases',
                            'name' => 'cases',
                            'type' => 'repeater',
                            'collapsed' => 'field_global_is_case_title',
                            'layout' => 'block',
                            'button_label' => 'Add Industry Case',
                            'sub_fields' => array(
                                array(
                                    'key' => 'field_global_is_case_title',
                                    'label' => 'Case Title',
                                    'name' => 'title',
                                    'type' => 'text',
                                ),
                                array(
                                    'key' => 'field_global_is_case_desc',
                                    'label' => 'Case Description',
                                    'name' => 'description',
                                    'type' => 'textarea',
                                    'rows' => 3,
                                ),
                                array(
                                    'key' => 'field_global_is_case_image',
                                    'label' => 'Case Image',
                                    'name' => 'image',
                                    'type' => 'image',
                                    'return_format' => 'id',
                                    'preview_size' => 'medium',
                                ),
                            ),
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
