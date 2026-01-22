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
// Fallback logic for global modules
$heading = get_field_value('heading', $block, $clone_name, $pfx, get_field('global_industry_heading', 'option') ?: 'Industries We Serve');
$description = get_field_value('description', $block, $clone_name, $pfx, get_field('global_industry_description', 'option'));
$bg_color = get_field_value('bg_color', $block, $clone_name, $pfx, '#ffffff');

// --- 2. Dynamic Spacing Logic ---
// Auto-remove top padding if background matches previous block
$prev_bg = isset($GLOBALS['3dp_last_bg']) ? $GLOBALS['3dp_last_bg'] : '';
$pt_class = ($prev_bg && $prev_bg === $bg_color) ? 'pt-0' : 'pt-16 lg:pt-24';
$pb_class = 'pb-16 lg:pb-24';
$section_spacing = $pt_class . ' ' . $pb_class;

// --- 3. Query Logic ---
$args = [
    'post_type'      => 'industry',
    'posts_per_page' => -1,
    'post_status'    => 'publish',
];
$industry_query = new WP_Query($args);

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
                <button class="industry-prev w-12 h-12 rounded-full border-[3px] border-border bg-white flex items-center justify-center hover:border-primary text-heading transition-colors" aria-label="<?php esc_attr_e( 'Previous', '3d-printing' ); ?>">
                    &larr;
                </button>
                <button class="industry-next w-12 h-12 rounded-full border-[3px] border-border bg-white flex items-center justify-center hover:border-primary text-heading transition-colors" aria-label="<?php esc_attr_e( 'Next', '3d-printing' ); ?>">
                    &rarr;
                </button>
            </div>
        </div>

        <!-- Slider -->
        <?php if ($industry_query->have_posts()) : ?>
            <div class="swiper industry-swiper overflow-hidden">
                <div class="swiper-wrapper">
                    <?php while ($industry_query->have_posts()) : $industry_query->the_post(); 
                        $icon = get_field('icon'); 
                        $intro = get_field('intro_text');
                    ?>
                        <div class="swiper-slide h-auto">
                            <a href="<?php the_permalink(); ?>" class="group block h-full bg-white rounded-xl border border-border p-8 hover:border-primary transition-all duration-300 flex flex-col">
                                <?php if ($icon) : ?>
                                    <div class="w-12 h-12 mb-4 text-primary relative z-10">
                                        <?php echo wp_get_attachment_image($icon, 'thumbnail', false, ['class' => 'w-full h-full object-contain', 'loading' => 'lazy']); ?>
                                    </div>
                                <?php endif; ?>
                                
                                <h3 class="text-xl font-bold text-heading mb-3 group-hover:text-primary transition-colors">
                                    <?php the_title(); ?>
                                </h3>
                                
                                <?php if ($intro) : ?>
                                    <p class="text-body text-sm line-clamp-3 mb-6 flex-grow">
                                        <?php echo esc_html($intro); ?>
                                    </p>
                                <?php endif; ?>
                                
                                <span class="text-primary font-bold text-sm flex items-center mt-auto">
                                    <?php esc_html_e( 'View Application', '3d-printing' ); ?> 
                                    <svg class="w-4 h-4 ml-2 transform group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"></path></svg>
                                </span>
                            </a>
                        </div>
                    <?php endwhile; wp_reset_postdata(); ?>
                </div>
            </div>
        <?php else : ?>
            <div class="bg-gray-50 rounded-xl border border-border p-8 text-center text-body">
                <?php esc_html_e( 'No industry applications found.', '3d-printing' ); ?>
            </div>
        <?php endif; ?>

    </div>
</div>

<?php
// Set global state for next block
$GLOBALS['3dp_last_bg'] = $bg_color;
?>