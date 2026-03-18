<?php
/**
 * ACF Field Definition: FAQ Module
 * --------------------------------------------------------------------------
 * Path: inc/acf/field/faq.php
 * Style: Industrial 4.0 / Flat Data Structure
 * --------------------------------------------------------------------------
 */

if ( function_exists( 'acf_add_local_field_group' ) ) :

    acf_add_local_field_group( array(
        'key'                   => 'group_module_faq',
        'title'                 => 'Module: FAQ (工业级问答模块)',
        'fields'                => array(
            // TAB: Content
            array(
                'key'               => 'field_faq_tab_content',
                'label'             => '基础内容',
                'name'              => '',
                'type'              => 'tab',
                'placement'         => 'top',
                'endpoint'          => 0,
            ),
            array(
                'key'               => 'field_faq_title',
                'label'             => '模块主标题',
                'name'              => 'faq_title',
                'type'              => 'text',
                'instructions'      => '支持使用 &lt;br&gt; 或 &lt;span class="italic"&gt; 进行样式微调',
                'default_value'     => 'Frequently asked questions',
                'required'          => 0,
            ),
            array(
                'key'               => 'field_faq_desc',
                'label'             => '引导描述文案',
                'name'              => 'faq_desc',
                'type'              => 'textarea',
                'rows'              => 3,
                'new_lines'         => 'br',
                'instructions'      => '建议 2-3 行，用于引导客户提问或说明支持范围',
            ),
            array(
                'key'               => 'field_faq_link',
                'label'             => 'CTA 按钮',
                'name'              => 'faq_link',
                'type'              => 'link',
                'return_format'     => 'array',
                'instructions'      => '左侧底部的主要行动按钮',
            ),

            // TAB: List
            array(
                'key'               => 'field_faq_tab_list',
                'label'             => '问答列表',
                'name'              => '',
                'type'              => 'tab',
                'placement'         => 'top',
                'endpoint'          => 0,
            ),
            array(
                'key'               => 'field_faq_items',
                'label'             => 'FAQ 列表详情',
                'name'              => 'faq_items',
                'type'              => 'repeater',
                'instructions'      => '点击右侧按钮添加新的问答条目',
                'collapsed'         => 'field_faq_question',
                'min'               => 1,
                'layout'            => 'block', // 工业级规范：Block 布局更适合长文本录入
                'button_label'      => '添加问答条目',
                'sub_fields'        => array(
                    array(
                        'key'           => 'field_faq_question',
                        'label'         => '问题',
                        'name'          => 'question',
                        'type'          => 'text',
                        'required'      => 0,
                        'placeholder'   => '例如：How does Tenor support institutional players?',
                    ),
                    array(
                        'key'           => 'field_faq_answer',
                        'label'         => '回答内容',
                        'name'          => 'answer',
                        'type'          => 'textarea',
                        'required'      => 0,
                        'rows'          => 4,
                        'new_lines'     => 'br', // 允许简单换行，保持纯净输出
                        'placeholder'   => '输入详细的解答内容...',
                    ),
                ),
            ),
        ),
        'location'              => array(
            array(
                array(
                    'param'    => 'post_type',
                    'operator' => '==',
                    'value'    => 'acf-field-group', // 仅在 ACF 内部可见，不直接挂载到页面
                ),
            ),
        ),
        'menu_order'            => 0,
        'position'              => 'normal',
        'style'                 => 'default',
        'label_placement'       => 'top',
        'instruction_placement' => 'label',
        'active'                => true,
        'description'           => '遵循 Industrial 4.0 审美，提供扁平化 FAQ 数据结构。',
    ) );

endif;
