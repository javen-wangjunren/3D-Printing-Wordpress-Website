<?php
/**
 * ACF Options Page Configuration (全局设置页配置)
 * ==========================================================================
 * 文件作用:
 * 注册 ACF 全局设置页面 (Options Page)，用于管理全站通用的静态内容。
 * 包括页眉(Header)、页脚(Footer)以及通用的全局模块(Global Modules)。
 *
 * 核心逻辑:
 * 1. 注册父级菜单 "Global Settings"。
 * 2. 注册子菜单 "Header", "Footer", "Global Modules"。
 * 3. 定义 "Global Modules" 的字段组，使用 ACF Clone 功能复用已有的 Block 字段组。
 *
 * 架构角色:
 * [Global Data Store]
 * 作为全站通用数据的存储中心。模板文件 (Templates) 或 局部模板 (Partials) 在渲染
 * 通用模块（如 CTA, Why Choose Us）时，如果当前页面没有特定内容，
 * 会回退 (Fallback) 读取此处的全局数据。
 *
 * 🚨 避坑指南:
 * 1. 字段名冲突: 为了防止多个 Clone 字段组中的同名字段（如 title, description）冲突，
 *    我们采用了 "Group Wrapping" 策略：每个 Clone 都在一个独立的 Group 字段中。
 *    例如: global_why_choose_us (Group) -> wcu_clone (Clone)。
 *    这样数据存储结构为: options_global_why_choose_us['title']，避免了扁平化存储导致的覆盖。
 * 2. Menu Slug: 子页面的 menu_slug 必须显式定义，确保与 Location Rules 中的判断一致。
 * ==========================================================================
 *
 * @package GeneratePress_Child
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

// ==========================================================================
// I. 注册设置页面 (Options Pages)
// ==========================================================================
if ( function_exists( 'acf_add_options_page' ) ) {
	add_action( 'acf/init', function() {
		
		// 1. 父级菜单: Global Settings
		acf_add_options_page( array(
			'page_title'    => 'Global Settings',
			'menu_title'    => 'Global Settings',
			'menu_slug'     => 'acf-options-global-settings',
			'capability'    => 'edit_posts',
			'redirect'      => true, // 点击父菜单重定向到第一个子菜单
			'icon_url'      => 'dashicons-admin-generic',
			'position'      => 59 // 出现在外观菜单附近
		) );

		// 2. 子菜单: Header
		acf_add_options_sub_page( array(
			'page_title'  => 'Header Settings',
			'menu_title'  => 'Header',
			'parent_slug' => 'acf-options-global-settings',
			'menu_slug'   => 'acf-options-header', // 显式定义 slug
		) );

		// 3. 子菜单: Footer
		acf_add_options_sub_page( array(
			'page_title'  => 'Footer Settings',
			'menu_title'  => 'Footer',
			'parent_slug' => 'acf-options-global-settings',
			'menu_slug'   => 'acf-options-footer', // 显式定义 slug
		) );

		// 4. 子菜单: Global Modules (通用模块内容)
		acf_add_options_sub_page( array(
			'page_title'  => 'Global Modules Content',
			'menu_title'  => 'Global Modules',
			'parent_slug' => 'acf-options-global-settings',
			'menu_slug'   => 'acf-options-global-modules', // 显式定义 slug，对应 Location Rule
		) );
	} );
}

// ==========================================================================
// II. 注册字段组 (Field Groups)
// ==========================================================================
if ( function_exists( 'acf_add_local_field_group' ) ) {
	
	add_action( 'acf/init', function() {
        
        /**
         * 字段组: Global Modules
         * 策略: 使用 Clone 字段引入已有的 Block 字段组。
         * 注意: 每个 Clone 都包裹在独立的 Group 字段中，作为命名空间 (Namespace)，
         * 防止字段名冲突 (如多个模块都有 title 字段)。
         */
		acf_add_local_field_group( array(
			'key' => 'group_3dp_global_modules',
			'title' => 'Global Modules (全局通用模块)',
			'fields' => array(
                
                // --------------------------------------------------
                // 1. Why Choose Us
                // --------------------------------------------------
                array(
                    'key' => 'field_global_why_choose_us',
                    'label' => 'Why Choose Us',
                    'name' => 'global_why_choose_us', // 数据存储键名: options_global_why_choose_us
                    'type' => 'group', // 使用 Group 包裹
                    'layout' => 'block',
                    'sub_fields' => array(
                        array(
                            'key' => 'field_global_wcu_clone',
                            'label' => 'Why Choose Us Fields',
                            'name' => 'wcu_clone',
                            'type' => 'clone',
                            'clone' => array(
                                0 => 'group_why_choose_us_new', // 引用原始字段组 Key
                            ),
                            'display' => 'seamless', // 无缝显示，直接展示字段
                            'layout' => 'block',
                            'prefix_label' => 0,
                            'prefix_name' => 0, // 不加前缀，因为外层已经是 Group 了
                        ),
                    ),
                ),
                
                // --------------------------------------------------
                // 2. Order Process
                // --------------------------------------------------
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
                
                // --------------------------------------------------
                // 3. CTA (Call to Action)
                // --------------------------------------------------
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
                
                // --------------------------------------------------
                // 4. Trusted By
                // --------------------------------------------------
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
                
                // --------------------------------------------------
                // 5. Industry Slider
                // --------------------------------------------------
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
						'value' => 'acf-options-global-modules', // 必须匹配上面定义的 menu_slug
					),
				),
			),
            'menu_order' => 0,
            'position' => 'normal',
            'style' => 'default',
            'label_placement' => 'top',
            'instruction_placement' => 'label',
            'hide_on_screen' => '',
            'active' => true,
            'description' => '',
		) );

	} );
}
