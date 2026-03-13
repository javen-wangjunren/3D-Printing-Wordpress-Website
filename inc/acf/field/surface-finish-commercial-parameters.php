<?php
/**
 * Module: Surface Finish Commercial Parameters
 * Path: inc/acf/field/surface-finish-commercial-parameters.php
 * 
 * 角色：用于定义 Surface Finish 的商业参数模块字段 (Procurement Strategy Guide)。
 * 逻辑：包含全局标题，以及核心的三个策略卡片（Value, Yield, Cost）。
 * 
 * @package 3D_Printing
 */

if ( function_exists( 'acf_add_local_field_group' ) ) {
    add_action( 'acf/init', function() {
        acf_add_local_field_group( array(
            'key' => 'group_surface_finish_commercial_params',
            'title' => 'Surface Finish Commercial Parameters (商业采购策略)',
            'fields' => array(
                
                // 1. Global Settings
                array(
                    'key' => 'field_cp_title',
                    'label' => 'Section Title',
                    'name' => 'cp_title',
                    'type' => 'text',
                    'default_value' => 'Procurement <span class="text-primary">Strategy Guide</span>',
                    'wrapper' => array('width' => '50'),
                ),

                // 2. Strategy Repeater
                array(
                    'key' => 'field_cp_strategies',
                    'label' => 'Strategy Guides',
                    'name' => 'cp_strategies',
                    'type' => 'repeater',
                    'layout' => 'row', // 使用 Row 布局更紧凑
                    'button_label' => 'Add Strategy (Max 3)',
                    'min' => 3,
                    'max' => 3, // 锁定为3个，对应固定的 Value, Yield, Cost 图标逻辑
                    'instructions' => '请严格按照顺序配置：1. Value Addition, 2. Yield Assurance, 3. Cost Efficiency',
                    'sub_fields' => array(
                        
                        array(
                            'key' => 'field_cp_strat_title',
                            'label' => 'Strategy Title',
                            'name' => 'title',
                            'type' => 'text',
                            'placeholder' => 'e.g., Value Addition',
                            'wrapper' => array('width' => '30'),
                        ),
                        array(
                            'key' => 'field_cp_strat_value',
                            'label' => 'Value / Metric',
                            'name' => 'value',
                            'type' => 'text',
                            'placeholder' => 'e.g., HIGH IMPACT or $$',
                            'wrapper' => array('width' => '30'),
                        ),
                        array(
                            'key' => 'field_cp_strat_desc',
                            'label' => 'Description',
                            'name' => 'description',
                            'type' => 'textarea',
                            'rows' => 2,
                            'placeholder' => 'Short description...',
                            'wrapper' => array('width' => '40'),
                        ),

                    ),
                ),
            ),
            'active' => false, // Set to false because this is a clone source
        ));
    });
}
