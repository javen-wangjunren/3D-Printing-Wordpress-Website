<?php
/**
 * Block: Hero Banner
 * Path: blocks/global/hero-banner/render.php
 * Description: Renders the Hero Banner with Split or Centered layout options.
 * 
 * @package 3D_Printing
 * @author Javen
 */
// Prefix Support
$pfx = isset($block['prefix']) ? $block['prefix'] : '';

// 1. 获取 Block 核心数据
$block       = isset( $block ) ? $block : array();
$block_id    = _3dp_get_safe_block_id( $block, 'hero' );
$block_class = isset( $block['className'] ) ? $block['className'] : '';
$is_preview  = isset($is_preview) && $is_preview;

// 2. 万能取数逻辑
// 确定克隆名
$clone_name = rtrim($pfx, '_');

// 3. 获取 ACF 字段数据
// Content
$title       = get_field_value('hero_title', $block, $clone_name, $pfx, 'Your Streamlined 3D Printing Service');
$subtitle    = get_field_value('hero_subtitle', $block, $clone_name, $pfx, 'Get Quality Parts at the Best Price');
$description = get_field_value('hero_description', $block, $clone_name, $pfx);
$buttons     = get_field_value('hero_buttons', $block, $clone_name, $pfx);

// Design & Layout
$layout          = get_field_value('hero_layout', $block, $clone_name, $pfx, 'split');
$mobile_compact  = get_field_value('hero_mobile_compact', $block, $clone_name, $pfx);
$desktop_img_id  = get_field_value('hero_image', $block, $clone_name, $pfx);
$mobile_img_id   = get_field_value('hero_mobile_image', $block, $clone_name, $pfx, $desktop_img_id);

// Colors
$bg_color    = get_field_value('hero_background_color', $block, $clone_name, $pfx, '#ffffff');
$text_color  = get_field_value('hero_text_color', $block, $clone_name, $pfx, '#000000');
$btn_p_color = get_field_value('hero_primary_button_color', $block, $clone_name, $pfx, '#0073aa');
$btn_s_color = get_field_value('hero_secondary_button_color', $block, $clone_name, $pfx, '#ffffff');

// 3. 预处理类名与样式
// Base classes
$section_classes = ['relative'];
$section_classes[] = $block_class;

// Layout specific classes
if ($layout === 'centered') {
    $section_classes[] = 'min-h-[600px] lg:min-h-[700px] flex items-center pt-32 pb-32 lg:pb-24'; // Reduced bottom padding
} else {
    // Split layout
    $section_classes[] = 'pt-20 pb-20 lg:pt-32 lg:pb-24'; // Reduced bottom padding to prevent huge gap
}

// Compact mode for mobile
if ($mobile_compact) {
    $section_classes[] = 'mobile-compact'; // Use this hook for specific CSS adjustments if needed
}

// Inline Styles for custom colors
$inline_styles = [];
if ($bg_color) {
    $inline_styles[] = "background-color: {$bg_color}";
}
if ($text_color) {
    $inline_styles[] = "color: {$text_color}";
}
$style_attr = !empty($inline_styles) ? ' style="' . implode('; ', $inline_styles) . '"' : '';

// --- Dynamic Spacing Logic ---
$prev_bg = isset($GLOBALS['3dp_last_bg']) ? $GLOBALS['3dp_last_bg'] : '';
// Determine current bg for comparison. Hero usually has its own bg. 
// If bg_color is set, use it. If not, maybe it's an image?
// If it's an image, we probably shouldn't collapse padding unless the previous one was also that image (unlikely).
// But we should Set the global state for the NEXT block.
$current_bg_for_state = $bg_color ? $bg_color : 'hero-image-bg'; 

// Apply dynamic padding logic only if not centered (Centered has specific padding)
// But user said "Default vertical spacing...". Hero is special. 
// I will keep Hero's specific padding but add the top-padding removal if applicable.
// Logic: If previous block has same BG color, remove top padding.
$pt_remove = ($prev_bg && $prev_bg === $current_bg_for_state) ? 'pt-0' : '';

if ($pt_remove) {
    // Remove existing pt classes and add pt-0
    $section_classes = array_diff($section_classes, ['pt-20', 'lg:pt-32', 'pt-32']);
    $section_classes[] = 'pt-0';
}
?>

<section id="<?php echo esc_attr($block_id); ?>" class="<?php echo esc_attr(implode(' ', $section_classes)); ?>"<?php echo $style_attr; ?>>

    <?php 
    // ==========================================
    // LAYOUT: CENTERED (Style 2)
    // ==========================================
    if ($layout === 'centered') {
    ?>
        <!-- Background Image Layer -->
        <div class="absolute inset-0 z-0">
            <picture>
                <?php if ($mobile_img_id): 
                    $m_img = wp_get_attachment_image_src($mobile_img_id, 'large');
                    if ($m_img): ?>
                    <source media="(max-width: 767px)" srcset="<?php echo esc_url($m_img[0]); ?>" width="<?php echo esc_attr($m_img[1]); ?>" height="<?php echo esc_attr($m_img[2]); ?>">
                    <?php endif; 
                endif; ?>
                <?php echo wp_get_attachment_image($desktop_img_id, 'full', false, ['class' => 'w-full h-full object-cover']); ?>
            </picture>
            <!-- Overlay -->
            <div class="absolute inset-0 bg-heading/70 mix-blend-multiply"></div>
        </div>

        <!-- Content Layer -->
        <div class="relative z-10 max-w-container mx-auto px-6 lg:px-8 text-center">
            
            <?php if ($subtitle): ?>
            <span class="inline-block mb-6 px-4 py-1.5 bg-white/10 border border-white/20 rounded-full text-[12px] font-mono font-bold text-white uppercase tracking-wider backdrop-blur-md">
                <?php echo esc_html($subtitle); ?>
            </span>
            <?php endif; ?>
            
            <?php if ($title): ?>
            <h1 class="text-h1 text-white tracking-tight mb-6 drop-shadow-sm">
                <?php echo esc_html($title); ?>
            </h1>
            <?php endif; ?>
            
            <?php if ($description): ?>
            <div class="text-white/80 text-[18px] max-w-2xl mx-auto mb-10 leading-relaxed font-medium prose-p:mb-0">
                <?php echo wp_kses_post($description); ?>
            </div>
            <?php endif; ?>

            <?php if (is_array($buttons) || is_object($buttons)): ?>
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
    } 
    // ==========================================
    // LAYOUT: SPLIT (Style 1)
    // ==========================================
    else { 
    ?>
        <div class="max-w-container mx-auto px-6 lg:px-8">
            <div class="grid lg:grid-cols-2 gap-12 items-stretch">
                
                <!-- Left: Text Content -->
                <div class="z-10 flex flex-col justify-center py-6">
                    <?php if ($title): ?>
                    <h1 class="text-h1 text-heading tracking-tight mb-6">
                        <?php echo esc_html($title); ?>
                    </h1>
                    <?php endif; ?>

                    <?php if ($subtitle): ?>
                    <h2 class="text-[20px] font-semibold text-primary mb-4 uppercase tracking-tight">
                        <?php echo esc_html($subtitle); ?>
                    </h2>
                    <?php endif; ?>

                    <?php if ($description): ?>
                    <div class="text-body max-w-lg mb-10 leading-relaxed prose-p:mb-0">
                        <?php echo wp_kses_post($description); ?>
                    </div>
                    <?php endif; ?>

                    <?php if (is_array($buttons) || is_object($buttons)): ?>
                    <div class="flex flex-wrap gap-4">
                        <?php foreach ($buttons as $btn): 
                            $style = $btn['button_style'];
                            $b_url = $btn['button_url'];
                            $b_text = $btn['button_text'];
                            
                            $btn_classes = $style === 'primary' 
                                ? 'bg-primary hover:bg-primary-hover text-white shadow-lg shadow-primary/10' 
                                : 'bg-white border-[3px] border-border text-heading hover:border-primary';
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
                            <?php if ($mobile_img_id): 
                                $m_img_split = wp_get_attachment_image_src($mobile_img_id, 'large');
                                if ($m_img_split): ?>
                                <source media="(max-width: 767px)" srcset="<?php echo esc_url($m_img_split[0]); ?>" width="<?php echo esc_attr($m_img_split[1]); ?>" height="<?php echo esc_attr($m_img_split[2]); ?>">
                                <?php endif; 
                            endif; ?>
                            <?php echo wp_get_attachment_image($desktop_img_id, 'full', false, ['class' => 'w-full h-full object-cover opacity-95 absolute inset-0', 'loading' => 'eager']); ?>
                        </picture>
                    </div>
                </div>
            </div>
        </div>
    <?php 
    } 
    ?>

</section>

<?php
// Set global state for next block
$GLOBALS['3dp_last_bg'] = $current_bg_for_state;
?>
