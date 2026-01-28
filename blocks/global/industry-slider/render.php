<?php
/**
 * Industry Slider Block Template
 * 
 * Industrial Tech Minimalist Design
 * 遵循 3dp-design-system.md 与 3dp-design-philosophy.md
 */
// Prefix Support
$pfx = isset($block['prefix']) ? $block['prefix'] : '';
$block = isset( $block ) ? $block : array();
$block_id = _3dp_get_safe_block_id( $block, 'industry-slider' );
$clone_name = rtrim($pfx, '_');

// --- 1. Data Scope ---
// Fetch Global Options Data
$global_data = get_field('global_industry_slider', 'option');

// Priority: Local Block Data > Global Options Data
$heading = get_field('title') ?: ($global_data['title'] ?? 'Industries We Serve');
$description = get_field('desc') ?: ($global_data['desc'] ?? '');
$items = get_field('items') ?: ($global_data['items'] ?? []);

$bg_color = get_field_value('bg_color', $block, $clone_name, $pfx, '#ffffff');

// --- 2. Dynamic Spacing Logic ---
// Auto-remove top padding if background matches previous block
$prev_bg = isset($GLOBALS['3dp_last_bg']) ? $GLOBALS['3dp_last_bg'] : '';
$pt_class = ($prev_bg && $prev_bg === $bg_color) ? 'pt-0' : 'pt-16 lg:pt-24';
$pb_class = 'pb-16 lg:pb-24';
$section_spacing = $pt_class . ' ' . $pb_class;

// Update Global State
$GLOBALS['3dp_last_bg'] = $bg_color;
?>

<div id="<?php echo esc_attr( $block_id ); ?>" class="<?php echo esc_attr($section_spacing); ?> w-full transition-colors duration-300" style="background-color: <?php echo esc_attr($bg_color); ?>;">
    <div class="max-w-container mx-auto px-4 lg:px-8">
        
        <!-- Header -->
        <div class="flex flex-col md:flex-row justify-between items-end mb-12 border-b border-border pb-8">
            <div class="max-w-2xl">
                <h2 class="text-3xl lg:text-4xl font-bold text-heading tracking-tight mb-4">
                    <?php echo esc_html($heading); ?>
                </h2>
                <?php if ($description) : ?>
                    <p class="text-body text-lg max-w-xl">
                        <?php echo esc_html($description); ?>
                    </p>
                <?php endif; ?>
            </div>
            
            <!-- Navigation Controls -->
            <div class="flex gap-4 mt-6 md:mt-0">
                <button class="industry-prev w-12 h-12 rounded-full border-[3px] border-border bg-white flex items-center justify-center hover:border-primary text-heading transition-colors" aria-label="<?php echo esc_attr( __( 'Previous', '3d-printing' ) ); ?>">
                    ←
                </button>
                <button class="industry-next w-12 h-12 rounded-full border-[3px] border-border bg-white flex items-center justify-center hover:border-primary text-heading transition-colors" aria-label="<?php echo esc_attr( __( 'Next', '3d-printing' ) ); ?>">
                    →
                </button>
            </div>
        </div>

        <!-- Slider -->
        <?php if (!empty($items)) : ?>
            <div class="swiper industry-swiper overflow-visible">
                <div class="swiper-wrapper">
                    <?php foreach ($items as $item) : 
                        $name = $item['name'];
                        $image_id = $item['image'];
                        $teaser = $item['teaser'];
                        $link = $item['link'];
                        $tags = $item['tags'];
                        
                        $link_url = is_array($link) ? $link['url'] : '';
                        $link_target = (is_array($link) && $link['target']) ? $link['target'] : '_self';
                        $link_title = (is_array($link) && $link['title']) ? $link['title'] : 'View Solution';
                        
                        // Tag Colors Map (Matches Design System)
                        // Usage (Blue): bg-[#E0EAFF] text-[#0047AB]
                        // Feature (Green): bg-[#ECFDF3] text-[#027A48]
                        $tag_colors = [
                            'blue' => 'bg-[#E0EAFF] text-[#0047AB]',
                            'green' => 'bg-[#ECFDF3] text-[#027A48]',
                        ];
                    ?>
                        <div class="swiper-slide !h-full">
                            <a href="<?php echo esc_url($link_url); ?>" target="<?php echo esc_attr($link_target); ?>" class="group/card block h-full bg-white rounded-xl border border-border hover:border-primary hover:shadow-lg transition-all duration-300 flex flex-col overflow-hidden">
                                
                                <!-- Visual Area (Fixed Height) -->
                                <div class="h-[260px] bg-gray-50 overflow-hidden relative border-b border-gray-100">
                                    <?php if ($image_id) : ?>
                                        <?php echo wp_get_attachment_image($image_id, 'large', false, ['class' => 'w-full h-full object-cover transition-transform duration-500 group-hover/card:scale-105']); ?>
                                    <?php else: ?>
                                        <div class="w-full h-full flex items-center justify-center text-gray-300 bg-gray-50">
                                            <svg class="w-12 h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                        </div>
                                    <?php endif; ?>
                                </div>

                                <!-- Body Area -->
                                <div class="p-6 lg:p-8 flex flex-col flex-grow">
                                    
                                    <!-- Tags (Top of Body) -->
                                    <?php if (!empty($tags)) : ?>
                                        <div class="flex flex-wrap gap-2 mb-4">
                                            <?php foreach ($tags as $tag) : 
                                                $color_class = isset($tag_colors[$tag['type']]) ? $tag_colors[$tag['type']] : 'bg-gray-100 text-gray-800';
                                            ?>
                                                <span class="inline-block px-2.5 py-1 text-[11px] uppercase font-bold tracking-wider rounded <?php echo $color_class; ?>">
                                                    <?php echo esc_html($tag['text']); ?>
                                                </span>
                                            <?php endforeach; ?>
                                        </div>
                                    <?php endif; ?>

                                    <!-- Title -->
                                    <h3 class="text-xl font-bold text-heading mb-0 group-hover/card:text-primary transition-colors">
                                        <?php echo esc_html($name); ?>
                                    </h3>
                                    
                                    <!-- Description -->
                                    <?php if ($teaser) : ?>
                                        <p class="text-body text-[15px] leading-relaxed line-clamp-3 mt-[15px] mb-6">
                                            <?php echo esc_html($teaser); ?>
                                        </p>
                                    <?php endif; ?>
                                    
                                    <!-- CTA -->
                                    <span class="text-primary font-bold text-sm flex items-center mt-auto pt-2 group-hover/card:underline decoration-2 underline-offset-4">
                                        <?php echo esc_html($link_title); ?> 
                                        <svg class="w-4 h-4 ml-2 transform group-hover/card:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"></path></svg>
                                    </span>
                                </div>
                            </a>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        <?php else: ?>
             <div class="py-12 text-center border border-dashed border-border rounded-xl bg-gray-50">
                <p class="text-gray-500 font-mono text-sm">No industry applications configured in Global Options or Local Block.</p>
            </div>
        <?php endif; ?>

    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    if (typeof Swiper !== 'undefined') {
        new Swiper('#<?php echo $block_id; ?> .industry-swiper', {
            slidesPerView: 1.2,
            spaceBetween: 16,
            loop: false,
            navigation: {
                nextEl: '#<?php echo $block_id; ?> .industry-next',
                prevEl: '#<?php echo $block_id; ?> .industry-prev',
            },
            breakpoints: {
                640: {
                    slidesPerView: 2,
                    spaceBetween: 24,
                },
                1024: {
                    slidesPerView: 4,
                    spaceBetween: 32,
                },
            }
        });
    }
});
</script>

<?php
// Set global state for next block
$GLOBALS['3dp_last_bg'] = $bg_color;
?>