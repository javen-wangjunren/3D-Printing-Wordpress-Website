<?php
/**
 * Block: Trusted By
 * Path: blocks/global/trusted-by/render.php
 * Description: Renders the Trusted By block with logo slider.
 * 
 * @package 3D_Printing
 * @author Javen
 */
// Prefix Support
$pfx = isset($block['prefix']) ? $block['prefix'] : '';
$block = isset( $block ) ? $block : array();
$block_id = _3dp_get_safe_block_id( $block, 'trusted-by' );
$block_class = isset($block['className']) ? $block['className'] : '';

// 万能取数逻辑
// 确定克隆名
$clone_name = rtrim($pfx, '_');

// 初始化变量
$title = '';
$description = '';
$logos = array();
$bg_color = '#ffffff';
$title_color = '#1D2938';
$enable_animation = false;
$animation_speed = 'normal';
$pause_on_hover = false;

// 处理全局设置模式
if ( empty( $pfx ) ) {
    // Global Settings Mode
    $global_data = get_field('global_trusted_by', 'option');
    
    if ( $global_data ) {
        // Get the cloned fields from tb_clone subarray
        $tb_data = isset($global_data['tb_clone']) ? $global_data['tb_clone'] : $global_data;
        
        $title = isset($tb_data['trusted_by_title']) ? $tb_data['trusted_by_title'] : '';
        $description = isset($tb_data['trusted_by_description']) ? $tb_data['trusted_by_description'] : '';
        
        $bg_color = isset($tb_data['trusted_by_background_color']) ? $tb_data['trusted_by_background_color'] : '#ffffff';
        $title_color = isset($tb_data['trusted_by_title_color']) ? $tb_data['trusted_by_title_color'] : '#1D2938';
        
        $enable_animation = isset($tb_data['trusted_by_enable_animation']) ? $tb_data['trusted_by_enable_animation'] : true;
        $animation_speed = isset($tb_data['trusted_by_animation_speed']) ? $tb_data['trusted_by_animation_speed'] : 'normal';
        $pause_on_hover = isset($tb_data['trusted_by_pause_on_hover']) ? $tb_data['trusted_by_pause_on_hover'] : true;
        
        // Map global logos to render format
        $raw_logos = isset($tb_data['trusted_by_logos']) ? $tb_data['trusted_by_logos'] : array();
        if ( is_array($raw_logos) ) {
            foreach ($raw_logos as $logo) {
                $logos[] = array(
                    'logo_image' => isset($logo['logo_image']) ? $logo['logo_image'] : '',
                    'logo_label' => isset($logo['logo_label']) ? $logo['logo_label'] : '',
                    'logo_alt_text' => isset($logo['logo_alt_text']) ? $logo['logo_alt_text'] : '',
                );
            }
        }
    }
} else {
    // 使用万能取数逻辑获取字段值
    $title = get_field_value('trusted_by_title', $block, $clone_name, $pfx, '');
    $description = get_field_value('trusted_by_description', $block, $clone_name, $pfx, '');
    $logos = get_field_value('trusted_by_logos', $block, $clone_name, $pfx, array());
    
    $bg_color = get_field_value('trusted_by_background_color', $block, $clone_name, $pfx, '#ffffff');
    $title_color = get_field_value('trusted_by_title_color', $block, $clone_name, $pfx, '#1D2938');
    
    $enable_animation = get_field_value('trusted_by_enable_animation', $block, $clone_name, $pfx, false);
    $animation_speed = get_field_value('trusted_by_animation_speed', $block, $clone_name, $pfx, 'normal');
    $pause_on_hover = get_field_value('trusted_by_pause_on_hover', $block, $clone_name, $pfx, false);
}

if (empty($logos)) {
    return;
}

$section_classes = array(
    'py-[96px]',
    'border-b',
    'border-border',
    'overflow-hidden',
    $block_class,
);

$section_classes = array_filter($section_classes);
$section_class_attr = implode(' ', $section_classes);

// Calculate animation duration based on speed setting
$duration = '30s';
if ($animation_speed === 'slow') {
    $duration = '45s';
} elseif ($animation_speed === 'fast') {
    $duration = '15s';
}
?>

<style>
    /* --- Infinite Scroll Animation --- */
    @keyframes scroll {
        0% { transform: translateX(0); }
        100% { transform: translateX(calc((-250px - 3rem) * <?php echo count($logos); ?>)); } /* 250px item + 3rem gap */
    }

    .animate-logo-cloud {
        animation: scroll <?php echo $duration; ?> linear infinite;
    }

    /* Pause on hover */
    .slider-container[data-pause-on-hover="1"]:hover .animate-logo-cloud {
        animation-play-state: paused;
    }

    /* Mask fade */
    .mask-fade {
        mask-image: linear-gradient(to right, transparent, black 15%, black 85%, transparent);
        -webkit-mask-image: linear-gradient(to right, transparent, black 15%, black 85%, transparent);
    }
</style>

<div id="<?php echo esc_attr($block_id); ?>" class="<?php echo esc_attr($section_class_attr); ?>" style="background-color: <?php echo esc_attr($bg_color); ?>;">
    <div class="max-w-[1280px] mx-auto px-6 lg:px-[24px]">
        <div class="text-center mb-16">
            <?php if ($title) : ?>
                <h3 class="text-[28px] font-bold text-heading tracking-[-0.5px] mb-4" style="color: <?php echo esc_attr($title_color); ?>;">
                    <?php echo esc_html($title); ?>
                </h3>
            <?php endif; ?>
            <?php if ($description) : ?>
                <p class="text-[16px] text-body max-w-2xl mx-auto">
                    <?php echo wp_kses_post($description); ?>
                </p>
            <?php endif; ?>
        </div>

        <div
            class="slider-container relative"
            data-animation-enabled="<?php echo $enable_animation ? '1' : '0'; ?>"
            data-animation-speed="<?php echo esc_attr($animation_speed); ?>"
            data-pause-on-hover="<?php echo $pause_on_hover ? '1' : '0'; ?>"
        >
            <div class="mask-fade">
                <div class="flex items-center gap-12 w-[max-content]<?php echo $enable_animation ? ' animate-logo-cloud' : ''; ?>">
                    <?php foreach ($logos as $logo) : ?>
                        <?php
                        $logo_id = isset($logo['logo_image']) ? $logo['logo_image'] : 0;
                        if (!$logo_id) {
                            continue;
                        }
                        $logo_label = isset($logo['logo_label']) ? $logo['logo_label'] : '';
                        $logo_alt = isset($logo['logo_alt_text']) && $logo['logo_alt_text'] ? $logo['logo_alt_text'] : $logo_label;
                        ?>
                        <div class="flex items-center justify-center w-[250px] grayscale hover:grayscale-0 transition-all duration-300">
                            <?php echo wp_get_attachment_image($logo_id, 'medium', false, array(
                                'class' => 'h-8 lg:h-10 w-auto object-contain opacity-40 hover:opacity-100 transition-opacity',
                                'alt'   => esc_attr($logo_alt),
                            )); ?>
                        </div>
                    <?php endforeach; ?>

                    <?php if ($enable_animation) : ?>
                        <?php foreach ($logos as $logo) : ?>
                            <?php
                            $logo_id = isset($logo['logo_image']) ? $logo['logo_image'] : 0;
                            if (!$logo_id) {
                                continue;
                            }
                            $logo_label = isset($logo['logo_label']) ? $logo['logo_label'] : '';
                            $logo_alt = isset($logo['logo_alt_text']) && $logo['logo_alt_text'] ? $logo['logo_alt_text'] : $logo_label;
                            ?>
                            <div class="flex items-center justify-center w-[250px] grayscale hover:grayscale-0 transition-all duration-300">
                                <?php echo wp_get_attachment_image($logo_id, 'medium', false, array(
                                    'class' => 'h-8 lg:h-10 w-auto object-contain opacity-40 hover:opacity-100 transition-opacity',
                                    'alt'   => esc_attr($logo_alt),
                                )); ?>
                            </div>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>
