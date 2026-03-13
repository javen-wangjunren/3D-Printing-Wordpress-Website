<?php

if ( function_exists( 'acf_add_local_field_group' ) ) {

	add_action( 'acf/init', function() {

		acf_add_local_field_group( array(
			'key'                   => 'group_application_showcase',
			'title'                 => __( 'Module: Showcase (Application)', '3d-printing' ),
			'fields'                => array(
				array(
					'key'          => 'field_application_showcase_title',
					'label'        => __( 'Title', '3d-printing' ),
					'name'         => 'showcase_title',
					'type'         => 'textarea',
					'required'     => 0,
					'rows'         => 2,
					'new_lines'    => '',
					'instructions' => __( '允许写入高亮标记，例如：Typical Use <span class="text-primary">Cases</span>', '3d-printing' ),
				),
				array(
					'key'       => 'field_application_showcase_subtitle',
					'label'     => __( 'Subtitle', '3d-printing' ),
					'name'      => 'showcase_subtitle',
					'type'      => 'textarea',
					'required'  => 0,
					'rows'      => 3,
					'new_lines' => '',
				),
				array(
					'key'          => 'field_application_showcase_cases',
					'label'        => __( 'Cases', '3d-printing' ),
					'name'         => 'showcase_cases',
					'type'         => 'repeater',
					'required'     => 0,
					'layout'       => 'block',
					'button_label' => __( 'Add Case', '3d-printing' ),
					'collapsed'    => 'field_application_showcase_case_name',
					'min'          => 1,
					'max'          => 6,
					'sub_fields'   => array(
						array(
							'key'          => 'field_application_showcase_case_name',
							'label'        => __( 'Case Name', '3d-printing' ),
							'name'         => 'case_name',
							'type'         => 'text',
							'required'     => 0,
							'wrapper'      => array( 'width' => '50' ),
						),
						array(
							'key'           => 'field_application_showcase_case_image',
							'label'         => __( 'Case Image', '3d-printing' ),
							'name'          => 'case_image',
							'type'          => 'image',
							'required'      => 0,
							'return_format' => 'id',
							'preview_size'  => 'medium',
							'library'       => 'all',
							'wrapper'       => array( 'width' => '50' ),
						),
						array(
							'key'      => 'field_application_showcase_case_process',
							'label'    => __( 'Process', '3d-printing' ),
							'name'     => 'case_process',
							'type'     => 'text',
							'required' => 0,
							'wrapper'  => array( 'width' => '50' ),
						),
						array(
							'key'      => 'field_application_showcase_case_material',
							'label'    => __( 'Material', '3d-printing' ),
							'name'     => 'case_material',
							'type'     => 'text',
							'required' => 0,
							'wrapper'  => array( 'width' => '50' ),
						),
					),
				),
			),
			'location'              => array(
				array(
					array(
						'param'    => 'post_type',
						'operator' => '==',
						'value'    => '__acf_library',
					),
				),
			),
			'menu_order'            => 0,
			'position'              => 'normal',
			'style'                 => 'default',
			'label_placement'       => 'top',
			'instruction_placement' => 'label',
			'hide_on_screen'        => '',
			'active'                => false,
			'description'           => '',
			'show_in_rest'          => 0,
		) );
	} );
}
