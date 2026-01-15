<?php

if ( function_exists( 'acf_add_local_field_group' ) ) {

	add_action( 'acf/init', function() {
		acf_add_local_field_group( array(
			'key'    => 'group_3dp_header_settings',
			'title'  => 'Header Settings',
			'fields' => array(
				array(
					'key'   => 'field_header_tab_content',
					'label' => 'Content',
					'type'  => 'tab',
				),
				array(
					'key'   => 'field_header_brand_group',
					'label' => 'Brand & Global',
					'name'  => 'header_brand_global',
					'type'  => 'group',
					'layout' => 'block',
					'sub_fields' => array(
						array(
							'key'           => 'field_header_logo_image',
							'label'         => 'Logo Image',
							'name'          => 'logo_image',
							'type'          => 'image',
							'return_format' => 'id',
							'preview_size'  => 'medium',
							'wrapper'       => array( 'width' => '50' ),
						),
						array(
							'key'           => 'field_header_logo_width',
							'label'         => 'Logo Display Width',
							'name'          => 'logo_width',
							'type'          => 'number',
							'suffix'        => 'px',
							'min'           => 16,
							'max'           => 320,
							'wrapper'       => array( 'width' => '25' ),
						),
						array(
							'key'           => 'field_header_cta_button',
							'label'         => 'Primary CTA Button',
							'name'          => 'cta_button',
							'type'          => 'link',
							'wrapper'       => array( 'width' => '25' ),
						),
					),
				),
				array(
					'key'   => 'field_header_capabilities_tab',
					'label' => 'Capabilities Dropdown',
					'type'  => 'tab',
				),
				array(
					'key'          => 'field_header_capabilities_items',
					'label'        => 'Capabilities Items',
					'name'         => 'header_capabilities_items',
					'type'         => 'repeater',
					'layout'       => 'block',
					'collapsed'    => 'field_header_capabilities_tech_name',
					'button_label' => 'Add Capability',
					'sub_fields'   => array(
						array(
							'key'     => 'field_header_capabilities_tech_name',
							'label'   => 'Tech Name',
							'name'    => 'tech_name',
							'type'    => 'text',
							'wrapper' => array( 'width' => '35' ),
						),
						array(
							'key'     => 'field_header_capabilities_subtitle',
							'label'   => 'Subtitle',
							'name'    => 'subtitle',
							'type'    => 'text',
							'wrapper' => array( 'width' => '40' ),
						),
						array(
							'key'     => 'field_header_capabilities_tag',
							'label'   => 'Tag',
							'name'    => 'tag',
							'type'    => 'text',
							'wrapper' => array( 'width' => '15' ),
						),
						array(
							'key'     => 'field_header_capabilities_link',
							'label'   => 'Link',
							'name'    => 'link',
							'type'    => 'link',
							'wrapper' => array( 'width' => '10' ),
						),
					),
				),
				array(
					'key'   => 'field_header_materials_tab',
					'label' => 'Materials Dropdown',
					'type'  => 'tab',
				),
				array(
					'key'          => 'field_header_material_columns',
					'label'        => 'Material Columns',
					'name'         => 'header_material_columns',
					'type'         => 'repeater',
					'layout'       => 'block',
					'collapsed'    => 'field_header_material_column_title',
					'button_label' => 'Add Column',
					'sub_fields'   => array(
						array(
							'key'   => 'field_header_material_column_title',
							'label' => 'Column Title',
							'name'  => 'title',
							'type'  => 'text',
						),
						array(
							'key'          => 'field_header_material_column_links',
							'label'        => 'Links',
							'name'         => 'links',
							'type'         => 'repeater',
							'layout'       => 'block',
							'collapsed'    => 'field_header_material_link_label',
							'button_label' => 'Add Link',
							'sub_fields'   => array(
								array(
									'key'   => 'field_header_material_link_label',
									'label' => 'Label',
									'name'  => 'label',
									'type'  => 'text',
								),
								array(
									'key'   => 'field_header_material_link_url',
									'label' => 'URL',
									'name'  => 'url',
									'type'  => 'url',
								),
							),
						),
					),
				),
			),
			'location' => array(
				array(
					array(
						'param'    => 'options_page',
						'operator' => '==',
						'value'    => 'acf-options-header',
					),
				),
			),
			'menu_order'            => 0,
			'position'              => 'normal',
			'active'                => true,
			'style'                 => 'default',
			'label_placement'       => 'top',
			'instruction_placement' => 'label',
		) );
	} );
}
