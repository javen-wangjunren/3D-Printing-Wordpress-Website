<?php
/**
 * Material Comparison Block Render
 * 推荐文件路径：blocks/global/material-comparison/render.php
 * 该文件由ACF自动调用，用于渲染Material Comparison模块
 */
// Prefix Support
$pfx = isset($block['prefix']) ? $block['prefix'] : '';


// 获取块数据
$block = isset( $block ) ? $block : (isset($args['block']) ? $args['block'] : array());
$block_id = _3dp_get_safe_block_id( $block, 'comparison' );
$block_class = $block['className'] ?? '';
$anchor = $block['anchor'] ?? '';

// 获取字段数据
$title = get_field($pfx . 'material_comparison_title') ?? '';
$intro = get_field($pfx . 'material_comparison_intro') ?? '';
$tabs = get_field($pfx . 'material_comparison_tabs') ?? [];
$materials = get_field($pfx . 'material_comparison_materials') ?? [];
$property_table = get_field($pfx . 'material_comparison_property_table') ?? [];

// 获取设计和设置选项
$mobile_layout = get_field($pfx . 'material_comparison_mobile_layout') ?? 'list';
$hide_table_mobile = get_field($pfx . 'material_comparison_hide_table_mobile') ?? false;
$table_scrollable = get_field($pfx . 'material_comparison_table_scrollable') ?? true;

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

// --- Dynamic Spacing Logic ---
$clone_name = isset($clone_name) ? $clone_name : '';
$bg_color = get_field_value('material_comparison_background_color', $block, $clone_name, $pfx, '#ffffff');
$prev_bg = isset($GLOBALS['3dp_last_bg']) ? $GLOBALS['3dp_last_bg'] : '';
$current_bg_for_state = $bg_color; 
$pt_remove = ($prev_bg && $prev_bg === $current_bg_for_state) ? 'pt-0' : '';

$pt_class = $pt_remove ? 'pt-0' : 'pt-16 lg:pt-24';
$pb_class = 'pb-16 lg:pb-24';
$section_spacing = $pt_class . ' ' . $pb_class;

// Set global state for next block
$GLOBALS['3dp_last_bg'] = $current_bg_for_state;

// 渲染模块
?>
<section id="<?php echo esc_attr($anchor); ?>" class="w-full <?php echo esc_attr($section_spacing); ?> <?php echo esc_attr($class_string); ?>" style="background-color: <?php echo esc_attr($bg_color); ?>;">
    <div class="max-w-container mx-auto px-container">
        <?php if ($title): ?>
            <h2 class="text-h2 font-semibold text-heading tracking-tight mb-8"><?php echo esc_html($title); ?></h2>
        <?php endif; ?>
        
        <!-- Material Comparison 模块渲染内容 -->
        <!-- 由前端开发人员根据设计稿实现具体的HTML结构和样式 -->
        <!-- 数据已通过ACF字段获取，可直接使用 -->
        <?php if ($intro): ?>
            <div class="mb-8 text-body"><?php echo wp_kses_post($intro); ?></div>
        <?php endif; ?>
    </div>
</section>
