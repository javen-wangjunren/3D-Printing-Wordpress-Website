<?php
/**
 * Why Choose Us Block 的ACF字段定义
 * 包含左侧图片和右侧多个理由项
 * 备注：主要是用于首页和后续的about us页面的
 */

// 确保函数在ACF可用时才执行
if ( function_exists( 'acf_add_local_field_group' ) ) {
    /**
     * 注册 Why Choose Us 模块字段
     * 优化点：采用 Panel-to-Content 3:7 布局建模，支持双角色（Engineers/Procurement）内容对比
     */
    function _3dp_why_choose_us_fields() {
        acf_add_local_field_group( array(
            'key' => 'group_why_choose_us_new',
            'title' => 'Why Choose Us (B2B Logic)',
            'fields' => array(
                // Tab: Content
                array(
                    'key' => 'field_wcu_tab_content',
                    'label' => '内容配置',
                    'name' => '',
                    'type' => 'tab',
                    'placement' => 'top',
                    'endpoint' => 0,
                ),
                array(
                    'key' => 'field_wcu_main_title',
                    'label' => '模块全局标题',
                    'name' => 'wcu_main_title',
                    'type' => 'text',
                    'instructions' => '例如：Why Choose 3DPROTO',
                    'required' => 1,
                    'wrapper' => array('width' => '50'),
                    'default_value' => 'Why Choose 3DPROTO',
                ),
                array(
                    'key' => 'field_wcu_card_label',
                    'label' => '卡片顶部标签',
                    'name' => 'wcu_card_label',
                    'type' => 'text',
                    'instructions' => '展示在卡片左上角的蓝色数字化标签',
                    'required' => 0,
                    'wrapper' => array('width' => '50'),
                    'default_value' => 'CONSOLE / NAVIGATION',
                ),
                array(
                    'key' => 'field_wcu_tabs',
                    'label' => '选项卡内容 (Tabs)',
                    'name' => 'wcu_tabs',
                    'type' => 'repeater',
                    'instructions' => '定义左侧导航及右侧对应的内容块',
                    'required' => 1,
                    'collapsed' => 'field_wcu_tab_name',
                    'min' => 1,
                    'max' => 4,
                    'layout' => 'block',
                    'button_label' => '添加新选项卡',
                    'sub_fields' => array(
                        // Tab Basic Info
                        array(
                            'key' => 'field_wcu_tab_name',
                            'label' => 'Tab 标题',
                            'name' => 'tab_name',
                            'type' => 'text',
                            'instructions' => '例如：01 EFFICIENCY',
                            'required' => 1,
                            'wrapper' => array('width' => '50'),
                        ),
                        array(
                            'key' => 'field_wcu_tab_desc',
                            'label' => 'Tab 核心简述',
                            'name' => 'tab_desc',
                            'type' => 'textarea',
                            'instructions' => '展示在左侧导航标题下方的说明文字',
                            'required' => 1,
                            'rows' => 2,
                            'wrapper' => array('width' => '50'),
                        ),
                        array(
                            'key' => 'field_wcu_tab_image',
                            'label' => '主展示图片',
                            'name' => 'tab_image',
                            'type' => 'image',
                            'instructions' => '建议尺寸：1200x800px，工业感实拍图',
                            'required' => 1,
                            'return_format' => 'id',
                            'preview_size' => 'medium',
                            'wrapper' => array('width' => '100'),
                        ),
                        // Engineering Section
                        array(
                            'key' => 'field_wcu_eng_label',
                            'label' => '左侧角色名称',
                            'name' => 'eng_label',
                            'type' => 'text',
                            'default_value' => '01 / Engineering',
                            'required' => 1,
                            'wrapper' => array('width' => '50'),
                        ),
                        array(
                            'key' => 'field_wcu_eng_list',
                            'label' => 'Engineering 优势列表',
                            'name' => 'eng_list',
                            'type' => 'repeater',
                            'layout' => 'table',
                            'required' => 1,
                            'button_label' => '增加项',
                            'wrapper' => array('width' => '50'),
                            'sub_fields' => array(
                                array(
                                    'key' => 'field_wcu_eng_item',
                                    'label' => '优势描述',
                                    'name' => 'item',
                                    'type' => 'text',
                                    'required' => 1,
                                ),
                            ),
                        ),
                        // Procurement Section
                        array(
                            'key' => 'field_wcu_proc_label',
                            'label' => '右侧角色名称',
                            'name' => 'proc_label',
                            'type' => 'text',
                            'default_value' => '02 / Procurement',
                            'required' => 1,
                            'wrapper' => array('width' => '50'),
                        ),
                        array(
                            'key' => 'field_wcu_proc_list',
                            'label' => 'Procurement 优势列表',
                            'name' => 'proc_list',
                            'type' => 'repeater',
                            'layout' => 'table',
                            'required' => 1,
                            'button_label' => '增加项',
                            'wrapper' => array('width' => '50'),
                            'sub_fields' => array(
                                array(
                                    'key' => 'field_wcu_proc_item',
                                    'label' => '优势描述',
                                    'name' => 'item',
                                    'type' => 'text',
                                    'required' => 1,
                                ),
                            ),
                        ),
                    ),
                ),
                array(
                    'key' => 'field_wcu_cta_page',
                    'label' => '底部主按钮跳转页面',
                    'name' => 'wcu_cta_page',
                    'type' => 'page_link',
                    'required' => 1,
                    'wrapper' => array('width' => '50'),
                ),
                array(
                    'key' => 'field_wcu_cta_text',
                    'label' => '按钮文字',
                    'name' => 'wcu_cta_text',
                    'type' => 'text',
                    'default_value' => 'START YOUR PROJECT',
                    'required' => 1,
                    'wrapper' => array('width' => '50'),
                ),
                // Tab: Settings
                array(
                    'key' => 'field_wcu_tab_settings',
                    'label' => '高级设置',
                    'name' => '',
                    'type' => 'tab',
                    'placement' => 'top',
                    'endpoint' => 0,
                ),
                array(
                    'key' => 'field_wcu_anchor_id',
                    'label' => '模块锚点 ID',
                    'name' => 'wcu_anchor_id',
                    'type' => 'text',
                    'instructions' => '用于导航跳转，如：why-choose-us',
                    'wrapper' => array('width' => '50'),
                ),
                array(
                    'key' => 'field_wcu_custom_class',
                    'label' => '自定义 CSS 类',
                    'name' => 'wcu_custom_class',
                    'type' => 'text',
                    'wrapper' => array('width' => '50'),
                ),
            ),
            'location' => array(
                array(
                    array(
                        'param' => 'block',
                        'operator' => '==',
                        'value' => 'acf/why-choose-us',
                    ),
                ),
            ),
            'menu_order' => 0,
            'position' => 'normal',
            'style' => 'default',
            'label_placement' => 'top',
            'instruction_placement' => 'label',
            'active' => true,
        ));
    }
    add_action( 'acf/init', '_3dp_why_choose_us_fields' );
}
