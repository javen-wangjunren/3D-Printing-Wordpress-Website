<?php
/**
 * Module: Technical Compatibility (Surface Finish)
 * Path: inc/acf/field/surface-finish-compatibility.php
 * 
 * 用于定义 Surface Finish 的技术兼容性模块字段。
 * 包含：
 * 1. 标题设置 (Title)
 * 2. 关联材料 (Verified Materials - Relationship)
 * 
 * 注意：Supported Processes 数据直接复用 CPT 根级别的 'related_capabilities' 字段，
 * 无需在此处重新定义，但在 Render 时会自动调用。
 * 
 * @package 3D_Printing
 */

if ( function_exists( 'acf_add_local_field_group' ) ) {
    add_action( 'acf/init', function() {
        acf_add_local_field_group( array(
            'key' => 'group_technical_compatibility',
            'title' => 'Technical Compatibility Module',
            'fields' => array(
                // 1. Title
                array(
                    'key' => 'field_compat_title',
                    'label' => 'Section Title',
                    'name' => 'compat_title',
                    'type' => 'text',
                    'default_value' => 'Technical <span class="text-primary">Compatibility</span>',
                ),

                // 2. Verified Materials (Relationship)
                array(
                    'key' => 'field_compat_materials',
                    'label' => 'Verified Materials',
                    'name' => 'compat_materials',
                    'type' => 'relationship',
                    'instructions' => 'Select the materials that are compatible with this surface finish.',
                    'post_type' => array(
                        0 => 'material',
                    ),
                    'taxonomy' => '',
                    'filters' => array(
                        0 => 'search',
                        1 => 'post_type',
                        2 => 'taxonomy',
                    ),
                    'elements' => '',
                    'min' => '',
                    'max' => '',
                    'return_format' => 'object', // Return WP_Post objects for easy data access
                ),
            ),
            'active' => false, // Set to false because this is a clone source
        ));
    });
}
