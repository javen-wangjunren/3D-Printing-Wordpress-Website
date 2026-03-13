<?php
/**
 * Module: Surface Finish Design Guide
 * Path: inc/acf/field/surface-finish-design-guide.php
 * 
 * 角色：用于定义 Surface Finish 的设计指南模块字段。
 * 逻辑：包含全局标题、描述、专家建议，以及核心的设计指南（Repeater -> Best Practice / Bad Practice）。
 * 
 * @package 3D_Printing
 */

if ( function_exists( 'acf_add_local_field_group' ) ) {
    add_action( 'acf/init', function() {
        acf_add_local_field_group( array(
            'key' => 'group_surface_finish_design_guide',
            'title' => 'Surface Finish Design Guide (后处理设计指南)',
            'fields' => array(
                
                // 1. Global Settings
                array(
                    'key' => 'field_sfdg_title',
                    'label' => 'Section Title',
                    'name' => 'sfdg_title',
                    'type' => 'text',
                    'default_value' => 'Post-Processing <span class="text-primary">DFM Guide</span>',
                    'wrapper' => array('width' => '50'),
                ),
                array(
                    'key' => 'field_sfdg_desc',
                    'label' => 'Section Description',
                    'name' => 'sfdg_description',
                    'type' => 'textarea',
                    'rows' => 3,
                    'default_value' => 'Optimizing your parts for post-processing ensures consistent surface quality and prevents damage during finishing operations.',
                    'wrapper' => array('width' => '50'),
                ),

                // 2. Design Guides Repeater
                array(
                    'key' => 'field_sfdg_guides',
                    'label' => 'Design Guides',
                    'name' => 'sfdg_guides',
                    'type' => 'repeater',
                    'layout' => 'block',
                    'button_label' => 'Add Design Guide',
                    'collapsed' => 'field_sfdg_guide_title',
                    'sub_fields' => array(
                        
                        // Guide Title (e.g., Minimum Wall Thickness)
                        array(
                            'key' => 'field_sfdg_guide_title',
                            'label' => 'Guide Parameter',
                            'name' => 'guide_title',
                            'type' => 'text',
                            'instructions' => '例如: Minimum Wall Thickness',
                            'required' => 1,
                        ),

                        // Best Practice (Green)
                        array(
                            'key' => 'field_sfdg_best_group',
                            'label' => 'Best Practice (Recommended)',
                            'name' => 'best_practice',
                            'type' => 'group',
                            'layout' => 'block',
                            'wrapper' => array('width' => '50'),
                            'sub_fields' => array(
                                array(
                                    'key' => 'field_sfdg_best_title',
                                    'label' => 'Title',
                                    'name' => 'title',
                                    'type' => 'text',
                                    'placeholder' => 'e.g., Reinforced Features',
                                ),
                                array(
                                    'key' => 'field_sfdg_best_desc',
                                    'label' => 'Description',
                                    'name' => 'description',
                                    'type' => 'textarea',
                                    'rows' => 3,
                                    'instructions' => '使用 [ value ] 来高亮数值，如：min [ 1.2mm ] thickness.',
                                ),
                            ),
                        ),

                        // Bad Practice (Red)
                        array(
                            'key' => 'field_sfdg_bad_group',
                            'label' => 'Bad Practice (Avoid)',
                            'name' => 'bad_practice',
                            'type' => 'group',
                            'layout' => 'block',
                            'wrapper' => array('width' => '50'),
                            'sub_fields' => array(
                                array(
                                    'key' => 'field_sfdg_bad_title',
                                    'label' => 'Title',
                                    'name' => 'title',
                                    'type' => 'text',
                                    'placeholder' => 'e.g., Ultra-thin structures',
                                ),
                                array(
                                    'key' => 'field_sfdg_bad_desc',
                                    'label' => 'Description',
                                    'name' => 'description',
                                    'type' => 'textarea',
                                    'rows' => 3,
                                    'instructions' => '使用 [ value ] 来高亮数值，如：under [ 0.8mm ] size.',
                                ),
                            ),
                        ),
                    ),
                ),

                // 3. Pro Tip
                array(
                    'key' => 'field_sfdg_pro_tip',
                    'label' => 'Pro Tip',
                    'name' => 'sfdg_pro_tip',
                    'type' => 'textarea',
                    'rows' => 2,
                    'default_value' => 'Always consult our engineering team for complex geometries requiring internal surface finishing.',
                ),

            ),
            'active' => false, // Set to false because this is a clone source
        ));
    });
}
