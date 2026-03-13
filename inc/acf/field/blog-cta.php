<?php

if ( function_exists( 'acf_add_local_field_group' ) ) {
	add_action( 'acf/init', function() {
		acf_add_local_field_group( array(
			'key'                   => 'group_3dp_blog_cta',
			'title'                 => 'Blog CTA (Global)',
			'fields'                => array(
				array(
					'key'   => 'field_blog_cta_tab_content',
					'label' => 'Content',
					'type'  => 'tab',
				),
				array(
					'key'           => 'field_blog_cta_enabled',
					'label'         => 'Enabled',
					'name'          => 'blog_cta_enabled',
					'type'          => 'true_false',
					'ui'            => 1,
					'default_value' => 1,
					'wrapper'       => array( 'width' => '25' ),
				),
				array(
					'key'           => 'field_blog_cta_eyebrow',
					'label'         => 'Eyebrow',
					'name'          => 'blog_cta_eyebrow',
					'type'          => 'text',
					'default_value' => 'Industrial Service',
					'wrapper'       => array( 'width' => '75' ),
				),
				array(
					'key'           => 'field_blog_cta_title',
					'label'         => 'Title',
					'name'          => 'blog_cta_title',
					'type'          => 'text',
					'default_value' => 'Ready to Scale Your Production?',
				),
				array(
					'key'           => 'field_blog_cta_button_text',
					'label'         => 'Button Text',
					'name'          => 'blog_cta_button_text',
					'type'          => 'text',
					'default_value' => 'Get A Quote',
					'wrapper'       => array( 'width' => '40' ),
				),
				array(
					'key'           => 'field_blog_cta_button_link',
					'label'         => 'Button Link',
					'name'          => 'blog_cta_button_link',
					'type'          => 'link',
					'return_format' => 'array',
					'wrapper'       => array( 'width' => '60' ),
				),
			),
			'location'              => array(
				array(
					array(
						'param'    => 'block',
						'operator' => '==',
						'value'    => 'acf/blog-cta',
					),
				),
			),
			'menu_order'            => 0,
			'position'              => 'normal',
			'style'                 => 'default',
			'label_placement'       => 'top',
			'instruction_placement' => 'label',
			'hide_on_screen'        => '',
			'active'                => true,
			'description'           => '',
		) );
	} );
}
