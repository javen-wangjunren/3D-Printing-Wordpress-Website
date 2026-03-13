<?php
/**
 * Module: Surface Finish Table Summary
 * Path: inc/acf/field/surface-finish-table-summary.php
 * Description: 用于 Surface Finish CPT 的表格摘要数据字段
 */

if ( function_exists( 'acf_add_local_field_group' ) ) {
    add_action( 'acf/init', function() {
        acf_add_local_field_group( array(
            'key'                   => 'group_sf_table_summary',
            'title'                 => __( 'Surface Finish Table Summary', '3d-printing' ),
            'location'              => array(
                array(
                    array(
                        'param'    => 'block', // 仅作为 Clone 源，不直接显示
                        'operator' => '==',
                        'value'    => 'acf/sf-table-summary', // 虚拟值
                    ),
                ),
            ),
            'active'                => true,
            'description'           => 'Clone source for Surface Finish Table Data',
            'fields'                => array(
                array(
                    'key'           => 'field_sf_table_desc',
                    'label'         => __( 'Short Description', '3d-printing' ),
                    'name'          => 'sf_table_desc',
                    'type'          => 'textarea',
                    'instructions'  => __( 'A concise description for the comparison table (max 150 chars).', '3d-printing' ),
                    'required'      => 0,
                    'rows'          => 3,
                    'maxlength'     => 150,
                ),
                array(
                    'key'           => 'field_sf_lead_time',
                    'label'         => __( 'Lead Time', '3d-printing' ),
                    'name'          => 'sf_lead_time',
                    'type'          => 'text',
                    'instructions'  => __( 'e.g., "+ 1 DAY" or "0 DAYS"', '3d-printing' ),
                    'required'      => 0,
                    'wrapper'       => array(
                        'width' => '50',
                    ),
                ),
                array(
                    'key'           => 'field_sf_price_level',
                    'label'         => __( 'Price Level', '3d-printing' ),
                    'name'          => 'sf_price_level',
                    'type'          => 'select',
                    'instructions'  => __( 'Select the cost tier.', '3d-printing' ),
                    'required'      => 0,
                    'choices'       => array(
                        '1' => '$ (Low)',
                        '2' => '$$ (Medium)',
                        '3' => '$$$ (High)',
                    ),
                    'wrapper'       => array(
                        'width' => '50',
                    ),
                ),
            ),
        ) );
    } );
}
