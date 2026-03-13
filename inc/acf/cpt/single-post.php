<?php
/**
 * Single Post Content Builder Fields
 * 
 * Implements Flexible Content for Blog Posts to enforce Design System.
 * Replaces standard Gutenberg content when 'post_use_builder' is true.
 * 
 * Location: inc/acf/cpt/single-post.php
 */

if ( function_exists( 'acf_add_local_field_group' ) ) :

	acf_add_local_field_group( array(
		'key' => 'group_single_post_builder',
		'title' => 'Post Content Builder',
		'fields' => array(
			// 1. Builder Toggle
			array(
				'key' => 'field_post_use_builder',
				'label' => 'Use Content Builder',
				'name' => 'post_use_builder',
				'type' => 'true_false',
				'instructions' => 'Enable to use structured modules instead of standard editor.',
				'default_value' => 1,
				'ui' => 1,
			),

			// 2. Flexible Content Body
			array(
				'key' => 'field_post_body',
				'label' => 'Content Modules',
				'name' => 'post_body',
				'type' => 'flexible_content',
				'instructions' => 'Add modules to build your post content.',
				'conditional_logic' => array(
					array(
						array(
							'field' => 'field_post_use_builder',
							'operator' => '==',
							'value' => '1',
						),
					),
				),
				'layouts' => array(
					
					// Layout: Rich Text
					'layout_richtext' => array(
						'key' => 'layout_post_richtext',
						'name' => 'richtext',
						'label' => 'Rich Text',
						'display' => 'block',
						'sub_fields' => array(
							array(
								'key' => 'field_post_richtext_content',
								'label' => 'Content',
								'name' => 'richtext_content',
								'type' => 'wysiwyg',
								'tabs' => 'visual',
								'toolbar' => 'basic', // Limit toolbar to enforce style
								'media_upload' => 0, // Force use of Image Module
							),
						),
					),

					// Layout: Table
					'layout_table' => array(
						'key' => 'layout_post_table',
						'name' => 'table',
						'label' => 'Table',
						'display' => 'block',
						'sub_fields' => array(
							array(
								'key' => 'field_post_table_caption',
								'label' => 'Caption',
								'name' => 'table_caption',
								'type' => 'text',
							),
							array(
								'key' => 'field_post_table_data',
								'label' => 'Table Data (CSV)',
								'name' => 'table_data',
								'type' => 'textarea',
								'instructions' => 'Enter table data in CSV format. First row = headers. Example: Column 1,Column 2,Column 3\nRow 1 Data,Row 1 Data,Row 1 Data',
								'rows' => 8,
								'new_lines' => '',
							),
						),
					),

					// Layout: CTA
					'layout_cta' => array(
						'key' => 'layout_post_cta',
						'name' => 'cta',
						'label' => 'CTA',
						'display' => 'block',
						'sub_fields' => array(
							array(
								'key' => 'field_post_cta_type',
								'label' => 'Type',
								'name' => 'cta_type',
								'type' => 'select',
								'choices' => array(
									'global' => 'Global Sidebar Style',
									'inline' => 'Inline Text Link',
									'card'   => 'Card Style (Custom)',
								),
								'default_value' => 'global',
							),
							// Custom fields for 'card' type could go here
							array(
								'key' => 'field_post_cta_title',
								'label' => 'Title',
								'name' => 'cta_title',
								'type' => 'text',
								'conditional_logic' => array(
									array(
										array(
											'field' => 'field_post_cta_type',
											'operator' => '==',
											'value' => 'card',
										),
									),
								),
							),
							array(
								'key' => 'field_post_cta_link',
								'label' => 'Link',
								'name' => 'cta_link',
								'type' => 'link',
								'conditional_logic' => array(
									array(
										array(
											'field' => 'field_post_cta_type',
											'operator' => '!=',
											'value' => 'global',
										),
									),
								),
							),
						),
					),

					// Layout: Image
					'layout_image' => array(
						'key' => 'layout_post_image',
						'name' => 'image',
						'label' => 'Image',
						'display' => 'block',
						'sub_fields' => array(
							array(
								'key' => 'field_post_image_file',
								'label' => 'Image',
								'name' => 'image_file',
								'type' => 'image',
								'return_format' => 'array',
							),
							array(
								'key' => 'field_post_image_caption',
								'label' => 'Caption',
								'name' => 'image_caption',
								'type' => 'text',
							),
							array(
								'key' => 'field_post_image_size',
								'label' => 'Size',
								'name' => 'image_size',
								'type' => 'select',
								'choices' => array(
									'contained' => 'Contained (Standard)',
									'wide'      => 'Wide (Breakout)',
								),
								'default_value' => 'contained',
							),
						),
					),

					// Layout: Callout
					'layout_callout' => array(
						'key' => 'layout_post_callout',
						'name' => 'callout',
						'label' => 'Callout',
						'display' => 'block',
						'sub_fields' => array(
							array(
								'key' => 'field_post_callout_style',
								'label' => 'Style',
								'name' => 'callout_style',
								'type' => 'select',
								'choices' => array(
									'info'    => 'Info (Blue)',
									'warning' => 'Warning (Yellow)',
									'tip'     => 'Pro Tip (Green)',
								),
							),
							array(
								'key' => 'field_post_callout_title',
								'label' => 'Title',
								'name' => 'callout_title',
								'type' => 'text',
							),
							array(
								'key' => 'field_post_callout_content',
								'label' => 'Content',
								'name' => 'callout_content',
								'type' => 'textarea',
								'rows' => 3,
							),
						),
					),
				),
			),
		),
		'location' => array(
			array(
				array(
					'param' => 'post_type',
					'operator' => '==',
					'value' => 'post',
				),
			),
		),
		'menu_order' => 0,
		'position' => 'acf_after_title', // High priority
		'style' => 'default',
		'label_placement' => 'top',
		'instruction_placement' => 'label',
		'hide_on_screen' => array(
			// Hide standard editor if possible, but we keep it for now as toggle is dynamic
			// 'the_content', 
		),
	));

endif;
