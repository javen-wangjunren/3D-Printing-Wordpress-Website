<?php

/**
 * 角色：Filter Sidebar 模块的字段 Schema 定义--Template Part
 * 位置：/inc/acf/field/filter-sidebar.php
 * 说明：all materials的侧边筛选栏的字段逻辑
 */



if ( function_exists( 'acf_add_local_field_group' ) ) {

    add_action( 'acf/init', function() {

        acf_add_local_field_group( array(
            'key' => 'group_3dp_filter_sidebar',
            'title' => 'Filter Sidebar Block (材料筛选侧边栏)',
            'fields' => array(

                array(
                    'key' => 'field_fs_tab_content',
                    'label' => 'Content',
                    'type' => 'tab',
                    'placement' => 'top',
                ),
                array(
                    'key' => 'field_fs_section_title',
                    'label' => 'Section Title',
                    'name' => 'filter_sidebar_title',
                    'type' => 'text',
                    'instructions' => '如：Material Library',
                    'wrapper' => array(
                        'width' => '50',
                    ),
                ),
                array(
                    'key' => 'field_fs_section_subtitle',
                    'label' => 'Section Subtitle',
                    'name' => 'filter_sidebar_subtitle',
                    'type' => 'text',
                    'instructions' => '如：37 professional materials available.',
                    'wrapper' => array(
                        'width' => '50',
                    ),
                ),
                array(
                    'key' => 'field_fs_search_placeholder',
                    'label' => 'Search Placeholder',
                    'name' => 'filter_sidebar_search_placeholder',
                    'type' => 'text',
                    'instructions' => '如：Search by name...',
                    'wrapper' => array(
                        'width' => '50',
                    ),
                ),

                array(
                    'key' => 'field_fs_process_label',
                    'label' => 'Process Group Label',
                    'name' => 'filter_sidebar_process_label',
                    'type' => 'text',
                    'instructions' => '用于「Process」过滤组标题，前端将从 material_process 分类法中拉取选项。',
                    'default_value' => 'Process',
                    'wrapper' => array(
                        'width' => '33',
                    ),
                ),
                array(
                    'key' => 'field_fs_type_label',
                    'label' => 'Material Type Group Label',
                    'name' => 'filter_sidebar_type_label',
                    'type' => 'text',
                    'instructions' => '用于「Type」过滤组标题，前端将从 material_type 分类法中拉取选项。',
                    'default_value' => 'Type',
                    'wrapper' => array(
                        'width' => '33',
                    ),
                ),
                array(
                    'key' => 'field_fs_cost_label',
                    'label' => 'Cost Group Label',
                    'name' => 'filter_sidebar_cost_label',
                    'type' => 'text',
                    'instructions' => '用于「Cost」过滤组标题，前端将从材料 Cost Level 字段中聚合选项。',
                    'default_value' => 'Cost',
                    'wrapper' => array(
                        'width' => '34',
                    ),
                ),
                array(
                    'key' => 'field_fs_show_process',
                    'label' => 'Show Process Filter',
                    'name' => 'filter_sidebar_show_process',
                    'type' => 'true_false',
                    'ui' => 1,
                    'default_value' => 1,
                    'wrapper' => array(
                        'width' => '33',
                    ),
                ),
                array(
                    'key' => 'field_fs_show_type',
                    'label' => 'Show Material Type Filter',
                    'name' => 'filter_sidebar_show_type',
                    'type' => 'true_false',
                    'ui' => 1,
                    'default_value' => 1,
                    'wrapper' => array(
                        'width' => '33',
                    ),
                ),
                array(
                    'key' => 'field_fs_show_cost',
                    'label' => 'Show Cost Filter',
                    'name' => 'filter_sidebar_show_cost',
                    'type' => 'true_false',
                    'ui' => 1,
                    'default_value' => 1,
                    'wrapper' => array(
                        'width' => '34',
                    ),
                ),

                array(
                    'key' => 'field_fs_extra_filters',
                    'label' => 'Additional Filter Groups',
                    'name' => 'filter_sidebar_extra_filters',
                    'type' => 'repeater',
                    'instructions' => '可选：为未来的「Characteristics」等维度预留额外过滤组占位，仅用于文案与分组标题，不负责具体选项数据。',
                    'collapsed' => 'field_fs_extra_label',
                    'layout' => 'block',
                    'button_label' => '＋ 添加附加过滤组',
                    'sub_fields' => array(
                        array(
                            'key' => 'field_fs_extra_label',
                            'label' => 'Group Label',
                            'name' => 'label',
                            'type' => 'text',
                            'wrapper' => array(
                                'width' => '50',
                            ),
                        ),
                        array(
                            'key' => 'field_fs_extra_key',
                            'label' => 'Filter Key',
                            'name' => 'key',
                            'type' => 'text',
                            'instructions' => '用于前端 data 属性或 JS 过滤逻辑（如 characteristic）。',
                            'wrapper' => array(
                                'width' => '50',
                            ),
                        ),
                    ),
                ),

                array(
                    'key' => 'field_fs_tab_design',
                    'label' => 'Design',
                    'type' => 'tab',
                    'placement' => 'top',
                ),
                array(
                    'key' => 'field_fs_bg_style',
                    'label' => 'Background Style',
                    'name' => 'filter_sidebar_bg_style',
                    'type' => 'select',
                    'choices' => array(
                        'bg-page' => '白色背景（与页面同色）',
                        'bg-section' => '浅灰背景（与内容区形成分区）',
                    ),
                    'default_value' => 'bg-page',
                    'wrapper' => array(
                        'width' => '50',
                    ),
                ),
                array(
                    'key' => 'field_fs_mobile_compact',
                    'label' => 'Mobile Compact Mode',
                    'name' => 'filter_sidebar_mobile_compact_mode',
                    'type' => 'true_false',
                    'instructions' => '开启后，在移动端将侧边栏折叠为顶部「Filters」手风琴面板。',
                    'ui' => 1,
                    'default_value' => 1,
                    'wrapper' => array(
                        'width' => '50',
                    ),
                ),
                array(
                    'key' => 'field_fs_mobile_hide_summary',
                    'label' => 'Mobile Hide Subtitle',
                    'name' => 'filter_sidebar_mobile_hide_subtitle',
                    'type' => 'true_false',
                    'instructions' => '移动端隐藏副标题文案，仅保留主标题与过滤控件。',
                    'ui' => 1,
                    'default_value' => 0,
                    'wrapper' => array(
                        'width' => '50',
                    ),
                ),

                array(
                    'key' => 'field_fs_tab_settings',
                    'label' => 'Settings',
                    'type' => 'tab',
                    'placement' => 'top',
                ),
                array(
                    'key' => 'field_fs_anchor_id',
                    'label' => 'Block ID',
                    'name' => 'filter_sidebar_anchor_id',
                    'type' => 'text',
                    'instructions' => '用于锚点跳转（如 #materials-filter）。',
                    'wrapper' => array(
                        'width' => '50',
                    ),
                ),
                array(
                    'key' => 'field_fs_custom_class',
                    'label' => 'Custom Class',
                    'name' => 'filter_sidebar_custom_class',
                    'type' => 'text',
                    'instructions' => '填入额外的实用类名，方便前端精准控制布局。',
                    'wrapper' => array(
                        'width' => '50',
                    ),
                ),
            ),
            'location' => array(
                array(
                    array(
                        'param' => 'block',
                        'operator' => '==',
                        'value' => 'acf/filter-sidebar',
                    ),
                ),
            ),
            'style' => 'seamless',
            'instruction_placement' => 'label',
        ) );
    } );
}
