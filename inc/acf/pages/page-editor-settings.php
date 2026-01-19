<?php

/**
 * 角色：Page Editor Settings (页面编辑器控制)
 * 备注：主要是用于控制页面是否开启Gutenberg编辑器或者传统的经典编辑器
 * 因为之前创建的模板，会出现后台还出现古腾堡的情况，所以在这里配置了一下
 */

if ( function_exists( 'acf_add_local_field_group' ) && function_exists( 'add_action' ) ) {

    add_action( 'acf/init', function() {

        acf_add_local_field_group( array(
            'key' => 'group_3dp_page_editor_settings',
            'title' => 'Page Editor Settings (页面编辑器控制)',
            'fields' => array(
                array(
                    'key' => 'field_3dp_pes_enable_content_editor',
                    'label' => 'Enable Content Editor (Gutenberg / Classic)',
                    'name' => 'page_enable_content_editor',
                    'type' => 'true_false',
                    'ui' => 1,
                    'default_value' => 1,
                    'wrapper' => array( 'width' => '100' ),
                ),
            ),
            'location' => array(
                array(
                    array(
                        'param' => 'post_type',
                        'operator' => '==',
                        'value' => 'page',
                    ),
                ),
            ),
            'position' => 'side',
            'style' => 'default',
            'label_placement' => 'top',
            'instruction_placement' => 'label',
            'active' => true,
            'show_in_rest' => 0,
        ) );
    } );
}
