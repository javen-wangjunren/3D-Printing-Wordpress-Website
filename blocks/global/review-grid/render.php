<?php
/**
 * Review Grid Block Template.
 * 
 * Industrial Tech Minimalist Design
 * 遵循 3dp-design-system.md 与 3dp-design-philosophy.md
 */
// Prefix Support
$pfx = isset($block['prefix']) ? $block['prefix'] : '';
$block = isset( $block ) ? $block : array();

// 万能取数逻辑
$clone_name = rtrim($pfx, '_');

// 使用万能取数逻辑获取字段值
$title_main      = get_field_value('title_main', $block, $clone_name, $pfx, 'Global Partner');
$title_highlight = get_field_value('title_highlight', $block, $clone_name, $pfx, 'Trust');
$subtitle        = get_field_value('reviews_subtitle', $block, $clone_name, $pfx, '');
$reviews         = get_field_value('reviews_list', $block, $clone_name, $pfx, array());
$columns         = get_field_value('review_columns_count', $block, $clone_name, $pfx, 3);
$spacing         = get_field_value('review_spacing', $block, $clone_name, $pfx, 'medium');
$card_style      = get_field_value('review_card_style', $block, $clone_name, $pfx, 'default');
$mobile_compact  = get_field_value('mobile_compact_mode', $block, $clone_name, $pfx, false);
$mobile_hide_txt = get_field_value('mobile_hide_content', $block, $clone_name, $pfx, false);
$bg_color        = get_field_value('bg_color', $block, $clone_name, $pfx, '#ffffff');

// 样式映射
$spacing_map = array(
    'small'  => 'px-4',
    'medium' => 'px-3', // 对应 demo 的 gutter
    'large'  => 'px-6',
);
$gutter_class = isset( $spacing_map[ $spacing ] ) ? $spacing_map[ $spacing ] : 'px-3';

// 卡片样式映射
$card_base_class = 'bg-white border border-border rounded-xl h-full flex flex-col transition-all duration-300';
$card_style_map = array(
    'default'  => 'shadow-sm hover:shadow-md',
    'shadow'   => 'shadow-md hover:shadow-lg',
    'bordered' => 'border-2 border-border hover:border-primary/20',
);
$card_class = $card_base_class . ' ' . ( isset( $card_style_map[ $card_style ] ) ? $card_style_map[ $card_style ] : $card_style_map['default'] );

// Block ID & Classes
$block_id = _3dp_get_safe_block_id( $block, 'review-grid' );

$custom_class = get_field_value('review_grid_custom_class', $block, $clone_name, $pfx, '');

// 计算总数以便 JS 使用
$total_reviews = count( $reviews );

// --- Dynamic Spacing Logic ---
$prev_bg = isset($GLOBALS['3dp_last_bg']) ? $GLOBALS['3dp_last_bg'] : '';
$pt_class = ($prev_bg && $prev_bg === $bg_color) ? 'pt-0' : 'pt-16 lg:pt-24';
$pb_class = 'pb-16 lg:pb-24';
?>

<section id="<?php echo esc_attr( $block_id ); ?>" class="review-grid-block w-full relative overflow-hidden <?php echo esc_attr( $pt_class . ' ' . $pb_class . ' ' . $custom_class ); ?>" style="background-color: <?php echo esc_attr($bg_color); ?>">
    
    <!-- Step 3: 埋入交互钩子 (Logic Hooks) - Alpine.js State -->
    <div x-data="{ 
            active: 0,
            total: <?php echo intval( $total_reviews ); ?>,
            columns: <?php echo intval( $columns ); ?>,
            get visible() { return window.innerWidth >= 1024 ? this.columns : 1 },
            get maxIndex() { return this.total - this.visible },
            next() { 
                // 循环逻辑：如果到达末尾，回到开头
                if (this.active >= this.maxIndex) {
                    this.active = 0;
                } else {
                    this.active++;
                }
            },
            prev() { 
                if (this.active <= 0) {
                    this.active = this.maxIndex;
                } else {
                    this.active--;
                }
            }
         }"
         @resize.window="active = Math.min(active, maxIndex)"
         class="max-w-container mx-auto px-6 lg:px-[64px]">

        <!-- Header Section -->
        <div class="flex flex-col md:flex-row justify-between items-end mb-16 gap-8">
            <div class="max-w-xl">
                <!-- Step 2: 注入视觉规范 - Heading & Subtitle -->
                <h2 class="text-h2 font-bold text-heading tracking-tight mb-4">
                    <?php echo esc_html( $title_main ); ?> 
                    <span class="text-primary"><?php echo esc_html( $title_highlight ); ?></span>
                </h2>
                <?php if ( $subtitle ) : ?>
                    <div class="text-body leading-relaxed <?php echo $mobile_hide_txt ? 'hidden md:block' : ''; ?>">
                        <?php echo wp_kses_post( $subtitle ); ?>
                    </div>
                <?php endif; ?>
            </div>
            
            <!-- Desktop Navigation -->
            <?php if ( $total_reviews > $columns ) : ?>
            <div class="hidden md:flex gap-3">
                <button @click="prev" 
                        class="w-12 h-12 rounded-full border-[3px] border-border bg-white flex items-center justify-center hover:border-primary text-heading transition-colors"
                        aria-label="<?php esc_attr_e( 'Previous review', '3d-printing' ); ?>">
                    &larr;
                </button>
                <button @click="next" 
                        class="w-12 h-12 rounded-full border-[3px] border-border bg-white flex items-center justify-center hover:border-primary text-heading transition-colors"
                        aria-label="<?php esc_attr_e( 'Next review', '3d-printing' ); ?>">
                    &rarr;
                </button>
            </div>
            <?php endif; ?>
        </div>

        <!-- Slider Track -->
        <div class="relative">
            <div class="flex transition-transform duration-500 ease-in-out will-change-transform"
                 :style="`transform: translateX(-${active * (100 / visible)}%)`">
                
                <?php 
                if ( ! empty( $reviews ) ) : 
                    foreach ( $reviews as $index => $review ) :
                        $photo     = isset($review['user_photo']) ? $review['user_photo'] : '';
                        $name      = isset($review['user_name']) ? $review['user_name'] : '';
                        $title     = isset($review['user_title']) ? $review['user_title'] : '';
                        $stars     = isset($review['stars_count']) ? intval( $review['stars_count'] ) : 5;
                        $verified  = isset($review['verified']) ? $review['verified'] : false;
                        $text      = isset($review['review_text']) ? $review['review_text'] : '';
                        
                        // 动态列宽类
                        $col_class_map = array(
                            1 => 'lg:w-full',
                            2 => 'lg:w-1/2',
                            3 => 'lg:w-1/3',
                            4 => 'lg:w-1/4',
                        );
                        $lg_width_class = isset( $col_class_map[ $columns ] ) ? $col_class_map[ $columns ] : 'lg:w-1/3';
                        ?>
                        
                        <div class="w-full <?php echo esc_attr( $lg_width_class ); ?> flex-shrink-0 <?php echo esc_attr( $gutter_class ); ?>"
                             <?php if ( $mobile_compact ) echo ':class="{\'px-1\': window.innerWidth < 768}"'; ?>>
                            
                            <div class="<?php echo esc_attr( $card_class ); ?> p-8 <?php echo $mobile_compact ? 'max-md:p-5' : ''; ?>">
                                
                                <!-- Stars & Verified -->
                                <div class="flex justify-between items-center mb-6">
                                    <div class="flex gap-1 text-primary">
                                        <?php for ( $i = 0; $i < $stars; $i++ ) : ?>
                                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                                        <?php endfor; ?>
                                        <?php // 补齐空星（可选，保持极简暂时不补，demo也没补） ?>
                                    </div>
                                    
                                    <?php if ( $verified ) : ?>
                                        <span class="bg-green-50 text-green-700 text-[10px] font-mono font-bold px-2 py-0.5 rounded border border-green-100 uppercase tracking-wider"><?php esc_html_e( 'Verified', '3d-printing' ); ?></span>
                                    <?php endif; ?>
                                </div>

                                <!-- Review Text -->
                                <div class="flex-1 mb-10">
                                    <p class="text-body italic leading-relaxed text-[15px] <?php echo $mobile_compact ? 'max-md:text-sm max-md:line-clamp-4' : ''; ?>">
                                        "<?php echo esc_html( strip_tags( $text ) ); ?>"
                                    </p>
                                </div>

                                <!-- User Info -->
                                <div class="flex items-center gap-4 pt-6 border-t border-border/50">
                                    <!-- Photo -->
                                    <?php if ( ! empty( $photo ) ) : ?>
                                        <div class="w-10 h-10 rounded-lg overflow-hidden shrink-0 bg-gray-100">
                                            <?php echo wp_get_attachment_image( $photo['id'], 'thumbnail', false, array( 'class' => 'w-full h-full object-cover', 'loading' => 'lazy' ) ); ?>
                                        </div>
                                    <?php else : ?>
                                        <!-- Fallback Initial -->
                                        <div class="w-10 h-10 bg-primary/10 rounded-lg flex items-center justify-center font-bold text-primary shrink-0 font-mono">
                                            <?php echo esc_html( substr( $name, 0, 1 ) ); ?>
                                        </div>
                                    <?php endif; ?>
                                    
                                    <!-- Meta -->
                                    <div class="overflow-hidden">
                                        <span class="block text-[14px] font-bold text-heading truncate"><?php echo esc_html( $name ); ?></span>
                                        <span class="block text-[12px] text-body truncate"><?php echo esc_html( $title ); ?></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>
        </div>
    </div>
</section>

<?php
// Set global state for next block
$GLOBALS['3dp_last_bg'] = $bg_color;
?>