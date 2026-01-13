<?php
/**
 * Material Comparison Block Render
 * 推荐文件路径：blocks/global/material-comparison/render.php
 * 该文件由ACF自动调用，用于渲染Material Comparison模块
 */

// 获取块数据
$block = $args['block'];
$block_id = $block['id'];
$block_class = $block['className'] ?? '';
$anchor = $block['anchor'] ?? '';

// 获取字段数据
$title = get_field('material_comparison_title') ?? '';
$intro = get_field('material_comparison_intro') ?? '';
$tabs = get_field('material_comparison_tabs') ?? [];
$materials = get_field('material_comparison_materials') ?? [];
$property_table = get_field('material_comparison_property_table') ?? [];

// 获取设计和设置选项
$mobile_layout = get_field('material_comparison_mobile_layout') ?? 'list';
$hide_table_mobile = get_field('material_comparison_hide_table_mobile') ?? false;
$table_scrollable = get_field('material_comparison_table_scrollable') ?? true;

// 构建CSS类
$classes = [
    'material-comparison',
    'block',
    'block-material-comparison',
    $block_class,
    "mobile-layout-{$mobile_layout}",
    $hide_table_mobile ? 'hide-table-mobile' : '',
    $table_scrollable ? 'table-scrollable' : '',
];
$classes = array_filter($classes);
$class_string = implode(' ', $classes);

// 渲染模块
?>
<div id="<?php echo esc_attr($anchor); ?>" class="<?php echo esc_attr($class_string); ?>">
    <!-- Material Comparison 模块渲染内容 -->
    <!-- 由前端开发人员根据设计稿实现具体的HTML结构和样式 -->
    <!-- 数据已通过ACF字段获取，可直接使用 -->
</div>
