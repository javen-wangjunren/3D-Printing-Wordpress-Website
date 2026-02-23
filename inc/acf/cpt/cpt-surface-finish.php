<?php
/**
 * ACF Fields: Surface Finish
 * 
 * 用于定义 Surface Finish CPT 的 ACF 字段组
 * 
 * @package 3D_Printing
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( function_exists( 'acf_add_local_field_group' ) ) :

	acf_add_local_field_group( array(
		'key' => 'group_surface_finish_details',
		'title' => 'Surface Finish Details',
		'fields' => array(
			array(
				'key' => 'field_sf_related_capabilities',
				'label' => 'Applicable Capabilities',
				'name' => 'related_capabilities',
				'type' => 'relationship',
				'instructions' => 'Select the capabilities (processes) this surface finish is applicable to.',
				'required' => 0,
				'conditional_logic' => 0,
				'wrapper' => array(
					'width' => '',
					'class' => '',
					'id' => '',
				),
				'post_type' => array(
					0 => 'capability',
				),
				'taxonomy' => '',
				'filters' => array(
					0 => 'search',
				),
				'elements' => '',
				'min' => '',
				'max' => '',
				'return_format' => 'object',
			),
		),
		'location' => array(
			array(
				array(
					'param' => 'post_type',
					'operator' => '==',
					'value' => 'surface-finish',
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

endif;
