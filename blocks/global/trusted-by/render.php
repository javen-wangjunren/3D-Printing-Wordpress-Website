<?php
$block = isset( $block ) ? $block : array();
$block_id = _3dp_get_safe_block_id( $block, 'trusted-by' );
$block_class = isset($block['className']) ? $block['className'] : '';

$title = get_field('trusted_by_title') ?: '';
$description = get_field('trusted_by_description') ?: '';
$logos = get_field('trusted_by_logos') ?: array();

$bg_color = get_field('trusted_by_background_color') ?: '#ffffff';
$title_color = get_field('trusted_by_title_color') ?: '#1D2938';

$enable_animation = get_field('trusted_by_enable_animation');
$animation_speed = get_field('trusted_by_animation_speed') ?: 'normal';
$pause_on_hover = get_field('trusted_by_pause_on_hover');

if (empty($logos)) {
    return;
}

$section_classes = array(
    'py-[96px]',
    'border-b',
    'border-border',
    'overflow-hidden',
    'bg-white',
    $block_class,
);

$section_classes = array_filter($section_classes);
$section_class_attr = implode(' ', $section_classes);
?>

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
                                'class' => 'h-8 lg:h-10 opacity-40 hover:opacity-100 transition-opacity',
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
                                    'class' => 'h-8 lg:h-10 opacity-40 hover:opacity-100 transition-opacity',
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
