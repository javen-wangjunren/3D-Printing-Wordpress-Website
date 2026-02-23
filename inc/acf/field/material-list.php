<?php
/**
 * 推荐文件路径：inc/acf/field/material-list.php
 * * 工业级 Material List Block 后端定义
 * 包含：三级嵌套内容建模 + 响应式布局控制 + 开发者设置
 * 备注：这个名字起的不那么有辨识度，主要是 all capability 和 single capability 展示该工艺的材料用的
 */

if ( function_exists( 'acf_add_local_field_group' ) ) {

    add_action( 'acf/init', function() {
        
        acf_add_local_field_group( array(
            'key' => 'group_3dp_material_list',
            'title' => 'Material List Block (材料总览模块)',
            'fields' => array(
                
                // ======================================================
                // TAB 1: CONTENT (内容建模)
                // ======================================================
                array(
                    'key' => 'field_ml_tab_content',
                    'label' => 'Content',
                    'type' => 'tab',
                    'placement' => 'top',
                ),
                // --- 全局统一设置 (Global Settings) ---
                array(
                    'key' => 'field_ml_global_quote',
                    'label' => 'Global Quote Link',
                    'name' => 'global_quote_link',
                    'type' => 'link',
                    'instructions' => '整个模块统一的 Quote Link (通常指向 Contact 页面)。',
                    'wrapper' => array('width' => '50'),
                ),
                array(
                    'key' => 'field_ml_global_specs_text',
                    'label' => 'Global Specs Link Text',
                    'name' => 'global_specs_link_text',
                    'type' => 'text',
                    'default_value' => 'View More Technical Specs',
                    'instructions' => '整个模块统一的详情页链接文案。',
                    'wrapper' => array('width' => '50'),
                ),
                array(
                    'key' => 'field_ml_process_list',
                    'label' => 'Process List (工艺大类)',
                    'name' => 'material_list_processes',
                    'type' => 'repeater',
                    'instructions' => '添加 3D 打印工艺分类（如 DMLS, SLA）。若使用单工艺模式，系统将仅显示第一个工艺的内容。',
                    'collapsed' => 'field_ml_process_name',
                    'layout' => 'block', // 释放横向空间
                    'button_label' => '＋ 添加新工艺',
                    'sub_fields' => array(
                        array(
                            'key' => 'field_ml_process_name',
                            'label' => 'Tab Name',
                            'name' => 'process_name',
                            'type' => 'text',
                            'required' => 1,
                            'placeholder' => '例如：DMLS (Metal 3D)',
                        ),
                        array(
                            'key' => 'field_ml_material_items',
                            'label' => 'Materials (材料列表)',
                            'name' => 'materials',
                            'type' => 'repeater',
                            'collapsed' => 'field_ml_mat_specs_link',
                            'layout' => 'block',
                            'button_label' => '＋ 添加材料项',
                            'sub_fields' => array(
                                // --- 第一行：核心数据源 & 基础信息 ---
                                array(
                                    'key' => 'field_ml_mat_specs_link',
                                    'label' => 'Material Source',
                                    'name' => 'specs_link',
                                    'type' => 'post_object',
                                    'instructions' => '选择关联的 Material 页面，将自动填充标题，图片和描述。',
                                    'post_type' => array(
                                        0 => 'material',
                                    ),
                                    'return_format' => 'id',
                                    'ui' => 1,
                                    'wrapper' => array('width' => '50'),
                                ),
                                array(
                                    'key' => 'field_ml_mat_badge',
                                    'label' => 'Badge',
                                    'name' => 'badge',
                                    'type' => 'text',
                                    'instructions' => '材料的特点。',
                                    'wrapper' => array('width' => '50'),
                                ),
                                // Image & Description 字段已隐藏，由 render.php 自动处理
                                // 但为了数据结构兼容性，我们不删除它们，而是用 display: none 或者干脆移除字段定义
                                // 根据需求“后台我们就不展示Image, Description”，直接移除字段定义是最干净的。
                                // 如果 render.php 强依赖这些 key 存在，我们在 render.php 里处理 isset 即可（已处理）。
                                
                                // --- 第二行：参数键值对 ---
                                array(
                                    'key' => 'field_ml_mat_specs',
                                    'label' => 'Technical Specs (技术参数)',
                                    'name' => 'spec_table',
                                    'type' => 'repeater',
                                    'instructions' => '建议 1-4 个参数，用于移动端 2x2 网格展示。',
                                    'layout' => 'table',
                                    'wrapper' => array('width' => '100'),
                                    'sub_fields' => array(
                                        array(
                                            'key' => 'field_ml_spec_label',
                                            'label' => 'Label',
                                            'name' => 'label',
                                            'type' => 'text',
                                        ),
                                        array(
                                            'key' => 'field_ml_spec_value',
                                            'label' => 'Value',
                                            'name' => 'value',
                                            'type' => 'text',
                                        ),
                                    ),
                                ),
                            ),
                        ),
                    ),
                ),

                // ======================================================
                // TAB 2: DESIGN (视觉与响应式控制)
                // ======================================================
                array(
                    'key' => 'field_ml_tab_design',
                    'label' => 'Design',
                    'type' => 'tab',
                    'placement' => 'top',
                ),
                array(
                    'key' => 'field_ml_mobile_layout',
                    'label' => 'Mobile Layout (移动端布局)',
                    'name' => 'material_list_mobile_layout',
                    'type' => 'select',
                    'instructions' => '选择移动端下的交互形式。',
                    'choices' => array(
                        'accordion' => '手风琴列表 (上下堆叠)',
                        'tabs_scroll' => '顶部滑动 Tab + 内容区',
                    ),
                    'default_value' => 'accordion',
                    'wrapper' => array('width' => '50'),
                ),
                array(
                    'key' => 'field_ml_display_mode',
                    'label' => 'Single-Process Mode (单工艺模式)',
                    'name' => 'material_list_display_mode',
                    'type' => 'true_false',
                    'instructions' => '勾选后进入单工艺模式：隐藏侧边栏Tab，仅展示第一个工艺的材料列表。适用于特定工艺详情页（如SLS页面）。',
                    'ui' => true,
                    'default_value' => false,
                    'wrapper' => array('width' => '50'),
                ),
                array(
                    'key' => 'field_ml_mobile_hide_image',
                    'label' => 'Mobile Image Visibility',
                    'name' => 'material_list_hide_image_mobile',
                    'type' => 'true_false',
                    'instructions' => '手机端是否隐藏材料图片以节省空间。',
                    'ui' => 1,
                    'default_value' => 0,
                    'wrapper' => array('width' => '50'),
                ),
                array(
                    'key' => 'field_ml_bg_color',
                    'label' => 'Background Style',
                    'name' => 'material_list_bg_style',
                    'type' => 'select',
                    'choices' => array(
                        'bg-page' => '白色背景',
                        'bg-section' => '浅灰背景 (与页面区分)',
                    ),
                    'default_value' => 'bg-page',
                ),

                // ======================================================
                // TAB 3: SETTINGS (开发者与 SEO)
                // ======================================================
                array(
                    'key' => 'field_ml_tab_settings',
                    'label' => 'Settings',
                    'type' => 'tab',
                    'placement' => 'top',
                ),
                array(
                    'key' => 'field_ml_anchor_id',
                    'label' => 'Block ID',
                    'name' => 'material_list_anchor_id',
                    'type' => 'text',
                    'instructions' => '用于锚点跳转（如 #materials-section）。',
                    'wrapper' => array('width' => '50'),
                ),
                array(
                    'key' => 'field_ml_custom_class',
                    'label' => 'Custom Class',
                    'name' => 'material_list_custom_class',
                    'type' => 'text',
                    'instructions' => '填入额外的 Tailwind 类名。',
                    'wrapper' => array('width' => '50'),
                ),
            ),
            'location' => array(
                array(
                    array(
                        'param' => 'block',
                        'operator' => '==',
                        'value' => 'acf/material-list',
                    ),
                ),
            ),
            'style' => 'default',
        ) );
    });
}
