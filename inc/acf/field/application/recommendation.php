<?php

if ( function_exists( 'acf_add_local_field_group' ) ) {

	add_action( 'acf/init', function() {

		acf_add_local_field_group( array(
			'key'                   => 'group_application_recommendation',
			'title'                 => __( 'Module: Recommendation (Application)', '3d-printing' ),
			'fields'                => array(
				array(
					'key'          => 'field_application_reco_title',
					'label'        => __( 'Title', '3d-printing' ),
					'name'         => 'recommendation_title',
					'type'         => 'textarea',
					'required'     => 0,
					'rows'         => 2,
					'new_lines'    => '',
					'instructions' => __( '允许写入高亮标记，例如：Recommended <span class="text-primary">Processes</span> & Materials', '3d-printing' ),
				),
				array(
					'key'       => 'field_application_reco_subtitle',
					'label'     => __( 'Subtitle', '3d-printing' ),
					'name'      => 'recommendation_subtitle',
					'type'      => 'textarea',
					'required'  => 0,
					'rows'      => 3,
					'new_lines' => '',
				),
				array(
					'key'          => 'field_application_reco_rows',
					'label'        => __( 'Table Rows', '3d-printing' ),
					'name'         => 'recommendation_rows',
					'type'         => 'repeater',
					'required'     => 0,
					'layout'       => 'block',
					'button_label' => __( 'Add Row', '3d-printing' ),
					'collapsed'    => 'field_application_reco_ap_name',
					'min'          => 1,
					'sub_fields'   => array(
						array(
							'key'           => 'field_application_reco_ap_image',
							'label'         => __( 'Application Image', '3d-printing' ),
							'name'          => 'recommend_ap_image',
							'type'          => 'image',
							'required'      => 0,
							'return_format' => 'id',
							'preview_size'  => 'medium',
							'library'       => 'all',
							'wrapper'       => array( 'width' => '50' ),
						),
						array(
							'key'      => 'field_application_reco_ap_name',
							'label'    => __( 'Application Name', '3d-printing' ),
							'name'     => 'recommend_ap_name',
							'type'     => 'text',
							'required' => 0,
							'wrapper'  => array( 'width' => '50' ),
						),
						array(
							'key'           => 'field_application_reco_process',
							'label'         => __( 'Recommended Process', '3d-printing' ),
							'name'          => 'recommend_process',
							'type'          => 'post_object',
							'required'      => 0,
							'post_type'     => array( 'capability' ),
							'taxonomy'      => array(),
							'allow_null'    => 0,
							'multiple'      => 1,
							'return_format' => 'id',
							'ui'            => 1,
							'wrapper'       => array( 'width' => '50' ),
						),
						array(
							'key'           => 'field_application_reco_material',
							'label'         => __( 'Key Material', '3d-printing' ),
							'name'          => 'recommend_material',
							'type'          => 'post_object',
							'required'      => 0,
							'post_type'     => array( 'material' ),
							'taxonomy'      => array(),
							'allow_null'    => 0,
							'multiple'      => 1,
							'return_format' => 'id',
							'ui'            => 1,
							'wrapper'       => array( 'width' => '50' ),
						),
						array(
							'key'      => 'field_application_reco_benefit',
							'label'    => __( 'Benefit', '3d-printing' ),
							'name'     => 'recommend_benefit',
							'type'     => 'text',
							'required' => 0,
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
