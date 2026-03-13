<?php

if ( function_exists( 'acf_add_local_field_group' ) ) {

	add_action( 'acf/init', function() {

		acf_add_local_field_group( array(
			'key'                   => 'group_application_certification',
			'title'                 => __( 'Module: Certification (Application)', '3d-printing' ),
			'fields'                => array(
				array(
					'key'          => 'field_application_cert_title',
					'label'        => __( 'Title', '3d-printing' ),
					'name'         => 'certification_title',
					'type'         => 'textarea',
					'required'     => 0,
					'rows'         => 2,
					'new_lines'    => '',
					'instructions' => __( '允许写入高亮标记，例如：Certification <span class="text-primary">&</span> Quality Assurance', '3d-printing' ),
				),
				array(
					'key'          => 'field_application_cert_images',
					'label'        => __( 'Certification Images', '3d-printing' ),
					'name'         => 'certification_images',
					'type'         => 'repeater',
					'required'     => 0,
					'layout'       => 'block',
					'button_label' => __( 'Add Image', '3d-printing' ),
					'collapsed'    => 'field_application_cert_image',
					'min'          => 3,
					'max'          => 3,
					'sub_fields'   => array(
						array(
							'key'           => 'field_application_cert_image',
							'label'         => __( 'Image', '3d-printing' ),
							'name'          => 'image',
							'type'          => 'image',
							'instructions'  => __( '推荐尺寸：4:3 比例，至少 1200×900px；请确保主体居中，避免被裁切。', '3d-printing' ),
							'required'      => 0,
							'return_format' => 'id',
							'preview_size'  => 'medium',
							'library'       => 'all',
						),
					),
				),
				array(
					'key'           => 'field_application_cert_desc',
					'label'         => __( 'Description', '3d-printing' ),
					'name'          => 'certification_desc',
					'type'          => 'text',
					'required'      => 0,
					'default_value' => 'All materials and processes meet international quality standards for industrial applications.',
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
