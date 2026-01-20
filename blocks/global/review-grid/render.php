<?php
/**
 * Review Grid Block Template.
 * 
 * Industrial Tech Minimalist Design
 * 遵循 3dp-design-system.md 与 3dp-design-philosophy.md
 */
// Prefix Support
$pfx = isset($block['prefix']) ? $block['prefix'] : '';


// Step 1: 确定数据作用域 (Data Scope)
$title_main      = get_field($pfx . 'title_main' ) ?: 'Global Partner';
$title_highlight = get_field($pfx . 'title_highlight' ) ?: 'Trust';
$subtitle        = get_field($pfx . 'reviews_subtitle' );
$reviews         = get_field($pfx . 'reviews_list' ) ?: array();
$columns         = get_field($pfx . 'review_columns_count' ) ?: 3;
$spacing         = get_field($pfx . 'review_spacing' ) ?: 'medium';
$card_style      = get_field($pfx . 'review_card_style' ) ?: 'default';
$mobile_compact  = get_field($pfx . 'mobile_compact_mode' );
$mobile_hide_txt = get_field($pfx . 'mobile_hide_content' );

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
$block = isset( $block ) ? $block : array();
$block_id = _3dp_get_safe_block_id( $block, 'review-grid' );

$class_name = 'review-grid-block py-section-y bg-bg-section/40 overflow-hidden';
if ( ! empty( $block['className'] ) ) {
    $class_name .= ' ' . $block['className'];
}
if ( ! empty( get_field($pfx . 'review_grid_custom_class' ) ) ) {
    $class_name .= ' ' . get_field($pfx . 'review_grid_custom_class' );
}

// 计算总数以便 JS 使用
$total_reviews = count( $reviews );

// 移动端/桌面端断点逻辑
// 桌面端显示 $columns 列，移动端强制 1 列
?>

<div id="<?php echo esc_attr( $block_id ); ?>" class="<?php echo esc_attr( $class_name ); ?>">
    
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
         class="max-w-[1280px] mx-auto px-6 lg:px-[64px]">

        <!-- Header Section -->
        <div class="flex flex-col md:flex-row justify-between items-end mb-16 gap-8">
            <div class="max-w-xl">
                <!-- Step 2: 注入视觉规范 - Heading & Subtitle -->
                <h2 class="text-h2 font-bold text-heading tracking-[-1px] mb-4">
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
                        class="w-12 h-12 rounded-lg border border-border flex items-center justify-center hover:bg-white hover:border-primary text-heading hover:text-primary transition-all group"
                        aria-label="Previous review">
                    <svg class="w-5 h-5 group-hover:-translate-x-0.5 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7"/></svg>
                </button>
                <button @click="next" 
                        class="w-12 h-12 rounded-lg border border-border flex items-center justify-center hover:bg-white hover:border-primary text-heading hover:text-primary transition-all group"
                        aria-label="Next review">
                    <svg class="w-5 h-5 group-hover:translate-x-0.5 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/></svg>
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
                        $photo     = $review['user_photo'];
                        $name      = $review['user_name'];
                        $title     = $review['user_title'];
                        $stars     = intval( $review['stars_count'] );
                        $verified  = $review['verified'];
                        $text      = $review['review_text'];
                        
                        // 计算宽度类名：在 Alpine 中我们用百分比控制，这里只需设为 w-full md:w-1/N
                        // 注意：为了配合 flex transform 逻辑，这里的宽度必须是精确的百分比，
                        // 但在 Tailwind 中动态类名较难，我们直接用内联 style 或标准类配合 Alpine 计算的逻辑。
                        // 实际上，flex 容器内的 items 宽度应该是 100% / visible_count。
                        // 为了简化，我们使用 flex-shrink-0 和基于父容器宽度的计算。
                        // 在 demo 中： w-full md:w-1/2 lg:w-1/3
                        
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
                                        <span class="bg-green-50 text-green-700 text-[10px] font-mono font-bold px-2 py-0.5 rounded border border-green-100 uppercase tracking-wider">Verified</span>
                                    <?php endif; ?>
                                </div>

                                <!-- Review Text -->
                                <div class="flex-1 mb-10">
                                    <p class="text-body italic leading-relaxed text-[15px] <?php echo $mobile_compact ? 'max-md:text-sm max-md:line-clamp-4' : ''; ?>">
                                        "<?php echo esc_html( $text ); ?>"
                                    </p>
                                </div>

                                <!-- User Info -->
                                <div class="flex items-center gap-4 pt-6 border-t border-border/50">
                                    <!-- Photo -->
                                    <?php if ( ! empty( $photo ) ) : ?>
                                        <div class="w-10 h-10 rounded-lg overflow-hidden shrink-0 bg-gray-100">
                                            <?php echo wp_get_attachment_image( $photo['id'], 'thumbnail', false, array( 'class' => 'w-full h-full object-cover' ) ); ?>
                                        </div>
                                    <?php else : ?>
                                        <!-- Fallback Initial -->
                                        <div class="w-10 h-10 bg-primary/10 rounded-lg flex items-center justify-center font-bold text-primary shrink-0 font-mono">
                                            <?php echo esc_html( substr( $name, 0, 1 ) ); ?>
                                        </div>
                                    <?php endif; ?>
                                    
                                    <!-- Meta -->
                                    <div class="overflow-hidden">
                                        <span class="block text-[14px] font-bold text-heading truncate">
                                            <?php echo esc_html( $name ); ?>
                                        </span>
                                        <span class="block text-[12px] text-muted truncate font-medium">
                                            <?php echo esc_html( $title ); ?>
                                        </span>
                                    </div>
                                </div>
                                
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php else : ?>
                    <div class="w-full text-center text-muted py-8">Please add reviews in the editor.</div>
                <?php endif; ?>
                
            </div>
        </div>

        <!-- Mobile Dots Navigation -->
        <?php if ( $total_reviews > 1 ) : ?>
        <div class="mt-12 flex justify-center gap-2 md:hidden">
            <?php for ( $i = 0; $i < $total_reviews; $i++ ) : ?>
                <button @click="active = <?php echo $i; ?>" 
                        :class="active === <?php echo $i; ?> ? 'bg-primary w-8' : 'bg-border w-2'"
                        class="h-1.5 rounded-full transition-all duration-300"
                        aria-label="Go to slide <?php echo $i + 1; ?>"></button>
            <?php endfor; ?>
        </div>
        <?php endif; ?>

    </div>
</div>
