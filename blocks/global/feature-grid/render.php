<?php
/**
 * Feature Grid Block Template
 * 
 * Industrial Tech Minimalist Design
 * 遵循 3dp-design-system.md 与 3dp-design-philosophy.md
 */

// Prefix Support
$pfx = isset($block['prefix']) ? $block['prefix'] : '';
$block = isset( $block ) ? $block : array();
$clone_name = rtrim($pfx, '_');

// --- 1. Data Scope ---
// Basic fields
$heading = get_field_value('heading', $block, $clone_name, $pfx, 'Feature Highlights');
$description = get_field_value('description', $block, $clone_name, $pfx);
$bg_color = get_field_value('bg_color', $block, $clone_name, $pfx, '#ffffff');
$features = get_field_value('features', $block, $clone_name, $pfx, []);
$columns = get_field_value('columns', $block, $clone_name, $pfx, '3');

// --- 2. Dynamic Spacing Logic ---
// Auto-remove top padding if background matches previous block
$prev_bg = isset($GLOBALS['3dp_last_bg']) ? $GLOBALS['3dp_last_bg'] : '';
$pt_class = ($prev_bg && $prev_bg === $bg_color) ? 'pt-0' : 'pt-16 lg:pt-24';
$pb_class = 'pb-16 lg:pb-24';
$section_spacing = $pt_class . ' ' . $pb_class;

// Grid column class
$grid_cols = 'lg:grid-cols-3';
if ($columns === '2') $grid_cols = 'lg:grid-cols-2';
if ($columns === '4') $grid_cols = 'lg:grid-cols-4';

// Update Global State
$GLOBALS['3dp_last_bg'] = $bg_color;
?>

<div id="<?php echo esc_attr( $block_id ); ?>" class="<?php echo esc_attr($section_spacing); ?> w-full transition-colors duration-300" style="background-color: <?php echo esc_attr($bg_color); ?>;">
    <div class="max-w-container mx-auto px-4 lg:px-8">
        
        <!-- Header -->
        <?php if ($heading || $description) : ?>
            <div class="text-center max-w-3xl mx-auto mb-16">
                <?php if ($heading) : ?>
                    <h2 class="text-3xl lg:text-4xl font-bold text-heading tracking-tight mb-4">
                        <?php echo esc_html($heading); ?>
                    </h2>
                <?php endif; ?>
                
                <?php if ($description) : ?>
                    <p class="text-body text-lg leading-relaxed">
                        <?php echo esc_html($description); ?>
                    </p>
                <?php endif; ?>
            </div>
        <?php endif; ?>

        <!-- Grid -->
        <?php if ($features) : ?>
            <div class="grid grid-cols-1 md:grid-cols-2 <?php echo esc_attr($grid_cols); ?> gap-8">
                <?php foreach ($features as $feature) : 
                    $icon = isset($feature['icon']) ? $feature['icon'] : '';
                    $title = isset($feature['title']) ? $feature['title'] : '';
                    $desc = isset($feature['description']) ? $feature['description'] : '';
                    $link = isset($feature['link']) ? $feature['link'] : '';
                ?>
                    <div class="bg-white border border-border p-8 rounded-xl hover:border-primary hover:shadow-lg transition-all duration-300 group h-full flex flex-col">
                        <?php if ($icon) : ?>
                            <div class="w-12 h-12 mb-6 text-primary">
                                <?php if (is_numeric($icon)) : ?>
                                    <?php echo wp_get_attachment_image($icon, 'thumbnail', false, ['class' => 'w-full h-full object-contain', 'loading' => 'lazy']); ?>
                                <?php else : ?>
                                    <img src="<?php echo esc_url($icon); ?>" alt="" class="w-full h-full object-contain" loading="lazy">
                                <?php endif; ?>
                            </div>
                        <?php endif; ?>

                        <?php if ($title) : ?>
                            <h3 class="text-xl font-bold text-heading mb-3 tracking-tight group-hover:text-primary transition-colors">
                                <?php echo esc_html($title); ?>
                            </h3>
                        <?php endif; ?>

                        <?php if ($desc) : ?>
                            <p class="text-body text-sm leading-relaxed mb-6 flex-grow">
                                <?php echo esc_html($desc); ?>
                            </p>
                        <?php endif; ?>

                        <?php if ($link) : 
                            $link_url = $link['url'];
                            $link_title = $link['title'] ?: 'Learn More';
                            $link_target = $link['target'] ?: '_self';
                        ?>
                            <a href="<?php echo esc_url($link_url); ?>" target="<?php echo esc_attr($link_target); ?>" class="inline-flex items-center text-primary font-bold text-sm mt-auto group/link">
                                <?php echo esc_html($link_title); ?>
                                <svg class="w-4 h-4 ml-2 transform group-hover/link:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"></path></svg>
                            </a>
                        <?php endif; ?>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>

    </div>
</div>

<?php
// Set global state for next block
$GLOBALS['3dp_last_bg'] = $bg_color;
?>