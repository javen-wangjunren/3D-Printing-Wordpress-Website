<?php

if ( function_exists( 'acf_add_local_field_group' ) ) {

	add_action( 'acf/init', function() {

		acf_add_local_field_group( array(
			'key'                   => 'group_application_technical_strength',
			'title'                 => __( 'Module: Technical Strength (Application)', '3d-printing' ),
			'fields'                => array(
				array(
					'key'          => 'field_application_ts_title',
					'label'        => __( 'Title', '3d-printing' ),
					'name'         => 'technical_strength_title',
					'type'         => 'textarea',
					'required'     => 0,
					'rows'         => 2,
					'new_lines'    => '',
					'instructions' => __( '允许写入高亮标记，例如：The Lifecycle of a <span class="text-primary">Breakthrough</span>', '3d-printing' ),
				),
				array(
					'key'       => 'field_application_ts_subtitle',
					'label'     => __( 'Subtitle', '3d-printing' ),
					'name'      => 'technical_strength_subtitle',
					'type'      => 'textarea',
					'required'  => 0,
					'rows'      => 3,
					'new_lines' => '',
				),
				array(
					'key'          => 'field_application_ts_steps',
					'label'        => __( 'Steps', '3d-printing' ),
					'name'         => 'technical_strength_steps',
					'type'         => 'repeater',
					'required'     => 0,
					'layout'       => 'block',
					'button_label' => __( 'Add Step', '3d-printing' ),
					'collapsed'    => 'field_application_ts_step_title',
					'min'          => 4,
					'max'          => 4,
					'sub_fields'   => array(
						array(
							'key'      => 'field_application_ts_step_title',
							'label'    => __( 'Step Title', '3d-printing' ),
							'name'     => 'step_title',
							'type'     => 'text',
							'required' => 0,
						),
						array(
							'key'      => 'field_application_ts_step_desc',
							'label'    => __( 'Step Description', '3d-printing' ),
							'name'     => 'step_desc',
							'type'     => 'textarea',
							'required' => 0,
							'rows'     => 3,
						),
						array(
							'key'           => 'field_application_ts_step_image',
							'label'         => __( 'Step Image', '3d-printing' ),
							'name'          => 'step_image',
							'type'          => 'image',
							'required'      => 0,
							'return_format' => 'id',
							'preview_size'  => 'medium',
							'library'       => 'all',
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
