<?php

if ( function_exists( 'acf_add_local_field_group' ) ) {

	add_action( 'acf/init', function() {

		acf_add_local_field_group( array(
			'key'                   => 'group_application_hero',
			'title'                 => __( 'Module: Hero (Application)', '3d-printing' ),
			'fields'                => array(
				array(
					'key'               => 'field_application_hero_title',
					'label'             => __( 'Title', '3d-printing' ),
					'name'              => 'hero_title',
					'type'              => 'textarea',
					'required'          => 0,
					'rows'              => 2,
					'new_lines'         => '',
					'instructions'      => __( '允许写入高亮标记，例如：3D Printing Solutions for <span class="text-primary">Automotive</span>', '3d-printing' ),
				),
				array(
					'key'               => 'field_application_hero_benefits',
					'label'             => __( 'Benefits', '3d-printing' ),
					'name'              => 'hero_benefits',
					'type'              => 'repeater',
					'required'          => 0,
					'layout'            => 'block',
					'button_label'      => __( 'Add Benefit', '3d-printing' ),
					'collapsed'         => 'field_application_hero_benefits_text',
					'sub_fields'        => array(
						array(
							'key'          => 'field_application_hero_benefits_text',
							'label'        => __( 'Text', '3d-printing' ),
							'name'         => 'hero_benefits_text',
							'type'         => 'text',
							'required'     => 0,
							'wrapper'      => array( 'width' => '100' ),
						),
					),
				),
				array(
					'key'               => 'field_application_hero_metrics',
					'label'             => __( 'Metrics', '3d-printing' ),
					'name'              => 'hero_metrics',
					'type'              => 'repeater',
					'required'          => 0,
					'layout'            => 'block',
					'button_label'      => __( 'Add Metric', '3d-printing' ),
					'collapsed'         => 'field_application_hero_metrics_label',
					'sub_fields'        => array(
						array(
							'key'          => 'field_application_hero_metrics_label',
							'label'        => __( 'Label', '3d-printing' ),
							'name'         => 'hero_metrics_label',
							'type'         => 'text',
							'required'     => 0,
							'wrapper'      => array( 'width' => '50' ),
						),
						array(
							'key'          => 'field_application_hero_metrics_value',
							'label'        => __( 'Value', '3d-printing' ),
							'name'         => 'hero_metrics_value',
							'type'         => 'text',
							'required'     => 0,
							'wrapper'      => array( 'width' => '50' ),
						),
					),
				),
				array(
					'key'               => 'field_application_hero_cta_label',
					'label'             => __( 'CTA Label', '3d-printing' ),
					'name'              => 'hero_cta_label',
					'type'              => 'text',
					'required'          => 0,
					'wrapper'           => array( 'width' => '50' ),
				),
				array(
					'key'               => 'field_application_hero_cta_url',
					'label'             => __( 'CTA URL', '3d-printing' ),
					'name'              => 'hero_cta_url',
					'type'              => 'link',
					'required'          => 0,
					'wrapper'           => array( 'width' => '50' ),
				),
				array(
					'key'               => 'field_application_hero_image',
					'label'             => __( 'Image', '3d-printing' ),
					'name'              => 'hero_image',
					'type'              => 'image',
					'required'          => 0,
					'return_format'     => 'id',
					'preview_size'      => 'medium',
					'library'           => 'all',
					'wrapper'           => array( 'width' => '50' ),
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
