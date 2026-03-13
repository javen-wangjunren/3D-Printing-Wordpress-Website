<?php
if ( function_exists( 'acf_add_local_field_group' ) ) :

	acf_add_local_field_group(
		array(
			'key'                   => 'group_blog_archive_settings',
			'title'                 => 'Page: Blog Archive Settings',
			'fields'                => array(
				array(
					'key'               => 'field_blog_archive_title',
					'label'             => 'Archive Title',
					'name'              => 'blog_archive_title',
					'type'              => 'text',
					'instructions'      => 'Main title for the blog archive page (e.g., "Manufacturing Knowledge Base").',
					'required'          => 1,
					'conditional_logic' => 0,
					'wrapper'           => array(
						'width' => '50',
						'class' => '',
						'id'    => '',
					),
					'default_value'     => 'Manufacturing Knowledge Base',
					'placeholder'       => '',
					'prepend'           => '',
					'append'            => '',
					'maxlength'         => '',
				),
				array(
					'key'               => 'field_blog_archive_desc',
					'label'             => 'Archive Description',
					'name'              => 'blog_archive_desc',
					'type'              => 'textarea',
					'instructions'      => 'Introductory text below the title.',
					'required'          => 0,
					'conditional_logic' => 0,
					'wrapper'           => array(
						'width' => '50',
						'class' => '',
						'id'    => '',
					),
					'default_value'     => 'Expert insights on industrial 3D printing materials, design guidelines, and post-processing techniques.',
					'placeholder'       => '',
					'maxlength'         => '',
					'rows'              => 3,
					'new_lines'         => 'br', // Render <br> tags automatically
				),
			),
			'location'              => array(
				array(
					array(
						'param'    => 'page_type',
						'operator' => '==',
						'value'    => 'posts_page', // Apply to whatever page is set as "Posts Page" in Settings > Reading
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
			'description'           => 'Settings for the Blog Archive page.',
		)
	);

endif;
