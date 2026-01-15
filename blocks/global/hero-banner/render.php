<?php
/**
 * Block: Hero Banner
 * Path: blocks/global/hero-banner/render.php
 * Description: Renders the Hero Banner with Split or Centered layout options.
 * 
 * @package 3D_Printing
 * @author Javen
 */

// 1. 获取 Block 核心数据
$block_id    = $block['id'];
$block_class = isset($block['className']) ? $block['className'] : '';
$is_preview  = isset($is_preview) && $is_preview;

// 2. 获取 ACF 字段数据
// Content
$title       = get_field('hero_title') ?: 'Your Streamlined 3D Printing Service';
$subtitle    = get_field('hero_subtitle') ?: 'Get Quality Parts at the Best Price';
$description = get_field('hero_description');
$buttons     = get_field('hero_buttons');

// Design & Layout
$layout          = get_field('hero_layout') ?: 'split'; // split | centered
$mobile_compact  = get_field('hero_mobile_compact');
$desktop_img_id  = get_field('hero_image');
$mobile_img_id   = get_field('hero_mobile_image') ?: $desktop_img_id; // Fallback to desktop image

// Colors
$bg_color    = get_field('hero_background_color') ?: '#ffffff';
$text_color  = get_field('hero_text_color') ?: '#000000';
$btn_p_color = get_field('hero_primary_button_color') ?: '#0073aa';
$btn_s_color = get_field('hero_secondary_button_color') ?: '#ffffff';

// Stats
$show_stats = get_field('hero_show_stats');
$stats      = get_field('hero_stats');

// 3. 预处理类名与样式
// Base classes
$section_classes = ['relative', 'overflow-visible']; // overflow-visible for stats bar
$section_classes[] = $block_class;

// Layout specific classes
if ($layout === 'centered') {
    $section_classes[] = 'min-h-[600px] lg:min-h-[700px] flex items-center pt-32 pb-48 lg:pb-32';
} else {
    // Split layout
    $section_classes[] = 'bg-bg-section pt-20 pb-32 lg:pt-32 lg:pb-48';
}

// Compact mode for mobile
if ($mobile_compact) {
    $section_classes[] = 'mobile-compact'; // Use this hook for specific CSS adjustments if needed
}

// Inline Styles for custom colors (mainly for text/bg overrides if not using Tailwind presets)
// Note: We prioritize Tailwind classes from the design system, but custom colors need style tags or inline styles.
// For this implementation, we'll rely on the structure mapping to the HTML templates provided.
?>

<section id="<?php echo esc_attr($block_id); ?>" class="<?php echo esc_attr(implode(' ', $section_classes)); ?>">

    <?php 
    // ==========================================
    // LAYOUT: CENTERED (Style 2)
    // ==========================================
    if ($layout === 'centered'): 
    ?>
        <!-- Background Image Layer -->
        <div class="absolute inset-0 z-0">
            <picture>
                <?php if ($mobile_img_id): ?>
                    <source media="(max-width: 767px)" srcset="<?php echo esc_url(wp_get_attachment_image_url($mobile_img_id, 'large')); ?>">
                <?php endif; ?>
                <?php echo wp_get_attachment_image($desktop_img_id, 'full', false, ['class' => 'w-full h-full object-cover']); ?>
            </picture>
            <!-- Overlay -->
            <div class="absolute inset-0 bg-heading/70 mix-blend-multiply"></div>
        </div>

        <!-- Content Layer -->
        <div class="relative z-10 max-w-container mx-auto px-6 lg:px-[64px] text-center">
            
            <?php if ($subtitle): ?>
            <span class="inline-block mb-6 px-4 py-1.5 bg-white/10 border border-white/20 rounded-full text-[12px] font-mono font-bold text-white uppercase tracking-wider backdrop-blur-md">
                <?php echo esc_html($subtitle); ?>
            </span>
            <?php endif; ?>
            
            <?php if ($title): ?>
            <h1 class="text-h1 text-white tracking-[-1px] mb-6 drop-shadow-sm">
                <?php echo esc_html($title); ?>
            </h1>
            <?php endif; ?>
            
            <?php if ($description): ?>
            <div class="text-white/80 text-[18px] max-w-2xl mx-auto mb-10 leading-relaxed font-medium prose-p:mb-0">
                <?php echo wp_kses_post($description); ?>
            </div>
            <?php endif; ?>

            <?php if ($buttons): ?>
            <div class="flex flex-wrap justify-center gap-4">
                <?php foreach ($buttons as $btn): 
                    $style = $btn['button_style'];
                    $b_url = $btn['button_url'];
                    $b_text = $btn['button_text'];
                    
                    $btn_classes = $style === 'primary' 
                        ? 'bg-primary hover:bg-primary-hover text-white shadow-lg shadow-primary/20' 
                        : 'bg-transparent border-2 border-white/30 text-white hover:bg-white/10';
                ?>
                    <a href="<?php echo esc_url($b_url); ?>" class="<?php echo esc_attr($btn_classes); ?> px-8 py-4 rounded-button font-bold text-sm inline-flex items-center gap-2 transition-all">
                        <?php if ($style === 'primary'): // Icon for primary ?>
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"/></svg>
                        <?php endif; ?>
                        <?php echo esc_html($b_text); ?>
                    </a>
                <?php endforeach; ?>
            </div>
            <?php endif; ?>
        </div>

    <?php 
    // ==========================================
    // LAYOUT: SPLIT (Style 1)
    // ==========================================
    else: 
    ?>
        <div class="max-w-container mx-auto px-6 lg:px-[64px]">
            <div class="grid lg:grid-cols-2 gap-12 items-stretch">
                
                <!-- Left: Text Content -->
                <div class="z-10 flex flex-col justify-center py-6">
                    <?php if ($title): ?>
                    <h1 class="text-h1 text-heading tracking-[-1px] mb-6">
                        <?php echo esc_html($title); ?>
                    </h1>
                    <?php endif; ?>

                    <?php if ($subtitle): ?>
                    <h2 class="text-[20px] font-semibold text-primary mb-4 uppercase tracking-wide">
                        <?php echo esc_html($subtitle); ?>
                    </h2>
                    <?php endif; ?>

                    <?php if ($description): ?>
                    <div class="text-body max-w-lg mb-10 leading-relaxed prose-p:mb-0">
                        <?php echo wp_kses_post($description); ?>
                    </div>
                    <?php endif; ?>

                    <?php if ($buttons): ?>
                    <div class="flex flex-wrap gap-4">
                        <?php foreach ($buttons as $btn): 
                            $style = $btn['button_style'];
                            $b_url = $btn['button_url'];
                            $b_text = $btn['button_text'];
                            
                            $btn_classes = $style === 'primary' 
                                ? 'bg-primary hover:bg-primary-hover text-white shadow-lg shadow-primary/10' 
                                : 'bg-white border border-border text-heading hover:border-primary';
                        ?>
                            <a href="<?php echo esc_url($b_url); ?>" class="<?php echo esc_attr($btn_classes); ?> px-8 py-4 rounded-button font-bold text-sm inline-flex items-center gap-2 transition-all">
                                <?php if ($style === 'primary'): ?>
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"/></svg>
                                <?php endif; ?>
                                <?php echo esc_html($b_text); ?>
                            </a>
                        <?php endforeach; ?>
                    </div>
                    <?php endif; ?>
                </div>

                <!-- Right: Image Content -->
                <div class="relative min-h-[360px] lg:min-h-0">
                    <div class="h-full rounded-card overflow-hidden bg-white border border-border shadow-sm relative">
                        <picture>
                            <?php if ($mobile_img_id): ?>
                                <source media="(max-width: 767px)" srcset="<?php echo esc_url(wp_get_attachment_image_url($mobile_img_id, 'large')); ?>">
                            <?php endif; ?>
                            <?php echo wp_get_attachment_image($desktop_img_id, 'full', false, ['class' => 'w-full h-full object-cover opacity-95 absolute inset-0']); ?>
                        </picture>
                    </div>
                </div>
            </div>
        </div>
    <?php endif; ?>


    <?php 
    // ==========================================
    // SHARED: STATS BAR
    // ==========================================
    if ($show_stats && $stats): 
        // 动态计算列数逻辑：
        // Desktop: 如果是 5 个数据就分 5 列，默认 4 个分 4 列。为了安全起见，我们使用 flex 布局自动分配，或者 grid。
        // 根据 Design Demo，使用 Flex wrap 且 justify-center，min-w-[140px]
    ?>
    <div class="absolute bottom-0 left-1/2 -translate-x-1/2 translate-y-1/2 w-full max-w-container px-6 lg:px-[64px] z-20">
        <div class="bg-white border border-border rounded-card shadow-[0_20px_40px_-15px_rgba(0,0,0,0.1)] py-8 px-6 lg:px-10">
            
            <!-- Mobile: Grid 2 cols, Desktop: Flex Row -->
            <div class="grid grid-cols-2 gap-y-8 gap-x-4 lg:flex lg:flex-wrap lg:justify-center lg:items-center lg:gap-x-16">
                <?php foreach ($stats as $stat): ?>
                <div class="text-center min-w-[100px] lg:min-w-[140px]">
                    <strong class="block font-mono text-[24px] lg:text-[28px] text-heading font-bold mb-1 tracking-tight">
                        <?php echo esc_html($stat['stat_number']); ?>
                    </strong> 
                    <span class="text-[10px] lg:text-[11px] text-muted font-bold uppercase tracking-wider">
                        <?php echo esc_html($stat['stat_description']); ?>
                    </span>
                </div>
                <?php endforeach; ?>
            </div>

        </div>
    </div>
    <?php endif; ?>

</section>
