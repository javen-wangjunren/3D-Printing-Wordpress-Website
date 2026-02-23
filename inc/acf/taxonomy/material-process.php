<?php
/**
 * ACF Fields: Material Process Taxonomy
 * 
 * 用于定义 Material Process 分类法的 ACF 字段
 * 
 * @package 3D_Printing
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( function_exists( 'acf_add_local_field_group' ) ) :

	acf_add_local_field_group( array(
		'key' => 'group_material_process_details',
		'title' => 'Process Details',
		'fields' => array(
			array(
				'key' => 'field_tax_linked_capability',
				'label' => 'Linked Capability Page',
				'name' => 'taxonomy_linked_capability',
				'type' => 'post_object',
				'instructions' => 'Select the Capability page that corresponds to this process.',
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
				'allow_null' => 1,
				'multiple' => 0,
				'return_format' => 'object',
				'ui' => 1,
			),
		),
		'location' => array(
			array(
				array(
					'param' => 'taxonomy',
					'operator' => '==',
					'value' => 'material_process',
				),
			),
		),
		'menu_order' => 0,
		'position' => 'normal',
		'style' => 'seamless',
		'label_placement' => 'top',
		'instruction_placement' => 'label',
		'hide_on_screen' => '',
		'active' => true,
		'description' => '',
	) );

endif;
