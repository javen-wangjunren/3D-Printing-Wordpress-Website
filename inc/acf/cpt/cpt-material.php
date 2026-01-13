<?php
/**
 * 为 Material CPT 增加关联 Capability 的字段
 */

if ( function_exists( 'acf_add_local_field_group' ) ) {

    add_action( 'acf/init', function() {
        acf_add_local_field_group( array(
            'key' => 'group_3dp_material_relations',
            'title' => 'Material Associations (数据关联)',
            'fields' => array(
                array(
                    'key' => 'field_mat_rel_capability',
                    'label' => 'Belongs to Capability (所属工艺)',
                    'name' => 'related_capability',
                    'type' => 'relationship',
                    'instructions' => '选择该材料所适用的 3D 打印工艺（如：铝合金勾选 SLM）',
                    'post_type' => array( 'capability' ),
                    'filters' => array( 'search' ),
                    'elements' => array( 'featured_image' ),
                    'max' => 2, // 限制材料通常只属于 1-2 种工艺
                    'return_format' => 'id',
                ),
            ),
            'location' => array(
                array(
                    array(
                        'param' => 'post_type',
                        'operator' => '==',
                        'value' => 'material',
                    ),
                ),
            ),
        ) );
    });
}