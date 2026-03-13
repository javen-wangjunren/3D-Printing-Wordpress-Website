<?php
/**
 * CTA Block 的ACF字段定义
 * 包含号召性用语模块的标题、描述、图片、按钮和设计选项
 * 位置：全局模块，很多页面都在用
 */

// 确保函数在ACF可用时才执行
if ( function_exists( 'acf_add_local_field_group' ) ) {
	add_action( 'acf/init', function() {
		acf_add_local_field_group( array(
            'key' => 'group_66e4c0c0f0c8b0b',
            'title' => 'CTA Block',
            'fields' => array(
                // Content Tab
                array(
                    'key' => 'field_66e4c0c0f0c8b16',
                    'label' => 'Content',
                    'name' => '',
                    'type' => 'tab',
                    'instructions' => '',
                    'required' => 0,
                    'conditional_logic' => 0,
                    'wrapper' => array(
                        'width' => '',
                        'class' => '',
                        'id' => '',
                    ),
                    'placement' => 'top',
                    'endpoint' => 0,
                ),
                array(
                    'key' => 'field_66e4c0c0f0c8b1f',
                    'label' => 'CTA Title',
                    'name' => 'cta_title',
                    'type' => 'text',
                    'instructions' => '输入CTA模块的主标题（支持加粗或颜色高亮）',
                    'required' => 0,
                    'conditional_logic' => 0,
                    'wrapper' => array(
                        'width' => '100',
                        'class' => '',
                        'id' => '',
                    ),
                    'default_value' => 'You have the idea - we make it a reality',
                    'placeholder' => '例如：Start your 3D printing journey today',
                    'prepend' => '',
                    'append' => '',
                    'maxlength' => '',
                ),
                array(
                    'key' => 'field_cta_title_highlight',
                    'label' => 'CTA Title Highlight',
                    'name' => 'cta_title_highlight',
                    'type' => 'text',
                    'instructions' => '标题中需要用品牌色高亮的部分，例如：a reality',
                    'required' => 0,
                    'conditional_logic' => 0,
                    'wrapper' => array(
                        'width' => '100',
                        'class' => '',
                        'id' => '',
                    ),
                    'default_value' => '',
                    'placeholder' => '',
                    'prepend' => '',
                    'append' => '',
                    'maxlength' => '',
                ),
                array(
                    'key' => 'field_cta_button_group',
                    'label' => 'CTA Button',
                    'name' => 'cta_button_group',
                    'type' => 'group',
                    'instructions' => '配置CTA按钮的文字、链接和图标',
                    'required' => 1,
                    'conditional_logic' => 0,
                    'wrapper' => array(
                        'width' => '100',
                        'class' => '',
                        'id' => '',
                    ),
                    'layout' => 'block',
                    'sub_fields' => array(
                        array(
                            'key' => 'field_cta_button_text',
                            'label' => 'Button Text',
                            'name' => 'button_text',
                            'type' => 'text',
                            'instructions' => '输入按钮文字',
                            'required' => 1,
                            'wrapper' => array(
                                'width' => '50',
                            ),
                            'default_value' => 'Get Instant Quote',
                        ),
                        array(
                            'key' => 'field_cta_button_link',
                            'label' => 'Button Link (Select Page)',
                            'name' => 'button_link',
                            'type' => 'post_object',
                            'instructions' => '选择按钮跳转的目标页面',
                            'required' => 1,
                            'post_type' => array(
                                0 => 'page',
                                1 => 'post',
                            ),
                            'taxonomy' => '',
                            'allow_null' => 0,
                            'multiple' => 0,
                            'return_format' => 'id',
                            'ui' => 1,
                            'wrapper' => array(
                                'width' => '50',
                            ),
                        ),
                    ),
                ),
                array(
                    'key' => 'field_cta_metrics',
                    'label' => 'CTA Metrics',
                    'name' => 'cta_metrics',
                    'type' => 'repeater',
                    'instructions' => '添加底部的认证或参数（建议添加4个）',
                    'required' => 0,
                    'conditional_logic' => 0,
                    'wrapper' => array(
                        'width' => '100',
                        'class' => '',
                        'id' => '',
                    ),
                    'collapsed' => '',
                    'min' => 0,
                    'max' => 4,
                    'layout' => 'table',
                    'button_label' => '添加项',
                    'sub_fields' => array(
                        array(
                            'key' => 'field_cta_metric_label',
                            'label' => 'Label (e.g. ISO 9001:2015)',
                            'name' => 'label',
                            'type' => 'text',
                            'required' => 1,
                        ),
                        array(
                            'key' => 'field_cta_metric_subtitle',
                            'label' => 'Subtitle (e.g. QUALITY MGMT)',
                            'name' => 'subtitle',
                            'type' => 'text',
                            'required' => 1,
                        ),
                    ),
                ),
                // Design Tab
                array(
                    'key' => 'field_66e4c0c0f0c8b65',
                    'label' => 'Design',
                    'name' => '',
                    'type' => 'tab',
                    'instructions' => '',
                    'required' => 0,
                    'conditional_logic' => 0,
                    'wrapper' => array(
                        'width' => '',
                        'class' => '',
                        'id' => '',
                    ),
                    'placement' => 'top',
                    'endpoint' => 0,
                ),
                array(
                    'key' => 'field_66e4c0c0f0c8b79',
                    'label' => 'Background Color',
                    'name' => 'bg_color',
                    'type' => 'color_picker',
                    'instructions' => '设置模块的背景颜色',
                    'required' => 0,
                    'conditional_logic' => 0,
                    'wrapper' => array(
                        'width' => '50',
                        'class' => '',
                        'id' => '',
                    ),
                    'default_value' => '#F2F4F7',
                    'enable_opacity' => 1,
                    'return_format' => 'rgba',
                ),
            ),
            'location' => array(
                array(
                    array(
                        'param' => 'block',
                        'operator' => '==',
                        'value' => 'acf/cta',
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
            'show_in_rest' => 0,
        ) );
	} );
}
