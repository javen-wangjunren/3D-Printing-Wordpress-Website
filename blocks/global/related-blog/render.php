<?php
$title            = get_field( 'blog_title' ) ?: '';
$title_highlight  = get_field( 'blog_title_highlight' ) ?: '';
$subtitle         = get_field( 'blog_subtitle' );
$posts_mode       = get_field( 'posts_mode' ) ?: 'latest';
$select_category  = get_field( 'select_category' );
$manual_posts     = get_field( 'manual_posts' );
$posts_count      = (int) get_field( 'posts_count' );
$posts_count      = $posts_count > 0 ? $posts_count : 3;
$posts_per_row    = (int) get_field( 'posts_per_row' );
$posts_per_row    = $posts_per_row > 0 ? $posts_per_row : 3;
$show_excerpt     = (bool) get_field( 'show_excerpt' );
$mobile_compact   = (bool) get_field( 'mobile_compact_mode' );
$mobile_hide_sub  = (bool) get_field( 'mobile_hide_subtitle' );
$button_text      = get_field( 'button_text' ) ?: '';
$button_link      = get_field( 'button_link' ) ?: '';
$custom_class     = get_field( 'related_blog_custom_class' );

$block = isset( $block ) ? $block : array();
$block_id = _3dp_get_safe_block_id( $block, 'related-blog' );

// 1. 优先检查外部传入的“手动指定文章”
if ( ! empty( $block['related_blog_posts'] ) && is_array( $block['related_blog_posts'] ) ) {
    $posts_mode   = 'manual';
    $manual_posts = $block['related_blog_posts'];
}

// 2. 优先检查外部传入的“当前工艺” (用于自动匹配)
if ( ! empty( $block['current_capability'] ) ) {
    // 这里可以根据 capability 获取 tag 或 category，暂时保留逻辑扩展点
    // $current_capability = $block['current_capability'];
    // $posts_mode = 'category'; 
    // ...
}

if ( ! empty( $block['anchor'] ) ) {
    $block_id = $block['anchor'];
}

$class_name = 'related-blog-block py-section-y bg-white overflow-hidden';
if ( ! empty( $block['className'] ) ) {
    $class_name .= ' ' . $block['className'];
}
if ( ! empty( $custom_class ) ) {
    $class_name .= ' ' . $custom_class;
}

$query_args = array(
    'post_type'           => 'post',
    'posts_per_page'      => $posts_count,
    'ignore_sticky_posts' => true,
);

if ( $posts_mode === 'category' && $select_category ) {
    $query_args['tax_query'] = array(
        array(
            'taxonomy' => 'category',
            'field'    => 'term_id',
            'terms'    => $select_category,
        ),
    );
} elseif ( $posts_mode === 'manual' && ! empty( $manual_posts ) && is_array( $manual_posts ) ) {
    $query_args['post__in']       = $manual_posts;
    $query_args['orderby']        = 'post__in';
    $query_args['posts_per_page'] = count( $manual_posts );
}

$read_time = function ( $post_id ) {
    return '';
};

$cards_query = new WP_Query( $query_args );

$width_mobile  = 'w-[85%]';
$width_tablet  = 'md:w-[45%]';
$width_desktop = $posts_per_row === 4 ? 'lg:w-[23%]' : 'lg:w-[31%]';
$card_width    = $width_mobile . ' ' . $width_tablet . ' ' . $width_desktop;

?>

<div id="<?php echo esc_attr( $block_id ); ?>" class="<?php echo esc_attr( $class_name ); ?>">
    <div x-data="{ scrollNext(){ const el = $refs.slider; if(el){ el.scrollBy({ left: el.offsetWidth * 0.8, behavior: 'smooth' }); } }, scrollPrev(){ const el = $refs.slider; if(el){ el.scrollBy({ left: -el.offsetWidth * 0.8, behavior: 'smooth' }); } } }" class="max-w-[1280px] mx-auto px-6 lg:px-[64px]">
        <div class="flex flex-col md:flex-row justify-between items-end mb-16 gap-8">
            <div class="max-w-xl text-left">
                <?php if ( $title || $title_highlight ) : ?>
                    <h2 class="text-h2 font-bold text-heading tracking-[-0.04em] mb-4">
                        <?php echo esc_html( $title ); ?><?php if ( $title_highlight ) : ?> <span class="text-primary"><?php echo esc_html( $title_highlight ); ?></span><?php endif; ?>
                    </h2>
                <?php endif; ?>
                <?php if ( $subtitle ) : ?>
                    <p class="text-body text-base <?php echo $mobile_hide_sub ? 'hidden md:block' : ''; ?>">
                        <?php echo wp_kses_post( $subtitle ); ?>
                    </p>
                <?php endif; ?>
            </div>
            <div class="flex flex-col items-end gap-3 pb-2 md:flex-row md:items-center">
                <?php if ( $button_text && $button_link ) : ?>
                    <a href="<?php echo esc_url( $button_link ); ?>" class="inline-flex items-center justify-center px-4 py-2 rounded-button border border-border text-sm font-semibold text-primary hover:bg-primary hover:text-white transition-colors">
                        <span><?php echo esc_html( $button_text ); ?></span>
                        <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/></svg>
                    </a>
                <?php endif; ?>
                <?php if ( $cards_query->have_posts() ) : ?>
                    <div class="hidden md:flex gap-3">
                        <button type="button" @click="scrollPrev" class="w-11 h-11 rounded-full border border-border flex items-center justify-center hover:bg-bg-section transition-all">
                            <svg class="w-5 h-5 text-heading" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7"/></svg>
                        </button>
                        <button type="button" @click="scrollNext" class="w-11 h-11 rounded-full border border-border flex items-center justify-center hover:bg-bg-section transition-all">
                            <svg class="w-5 h-5 text-heading" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/></svg>
                        </button>
                    </div>
                <?php endif; ?>
            </div>
        </div>

        <div class="relative">
            <div x-ref="slider" class="flex gap-6 overflow-x-auto no-scrollbar pb-10 scroll-smooth" style="scroll-snap-type: x mandatory;">
                <?php if ( $cards_query->have_posts() ) : ?>
                    <?php while ( $cards_query->have_posts() ) : $cards_query->the_post(); ?>
                        <?php
                        $post_id    = get_the_ID();
                        $categories = array();
                        $tag_label  = '';
                        $date_label = '';
                        $read_label = '';
                        ?>
                        <div class="<?php echo esc_attr( $card_width ); ?> flex-shrink-0" style="scroll-snap-align: start;">
                            <a href="<?php echo esc_url( get_permalink( $post_id ) ); ?>" class="group block bg-white rounded-card border border-border overflow-hidden hover:border-primary transition-all duration-300 h-full flex flex-col shadow-sm">
                                <div class="aspect-[16/10] overflow-hidden relative">
                                    <?php if ( has_post_thumbnail( $post_id ) ) : ?>
                                        <?php echo get_the_post_thumbnail( $post_id, 'large', array( 'class' => 'w-full h-full object-cover transition-transform duration-700 group-hover:scale-105' ) ); ?>
                                    <?php else : ?>
                                        <div class="w-full h-full bg-bg-section"></div>
                                    <?php endif; ?>
                                    <?php if ( $tag_label ) : ?>
                                        <div class="absolute top-4 left-4">
                                            <span class="bg-white/90 backdrop-blur px-3 py-1 rounded-full text-[10px] font-bold text-primary uppercase tracking-[0.16em]">
                                                <?php echo esc_html( $tag_label ); ?>
                                            </span>
                                        </div>
                                    <?php endif; ?>
                                </div>
                                <div class="p-6 lg:p-8 flex flex-col flex-1 <?php echo $mobile_compact ? 'max-md:p-5' : ''; ?>">
                                    <h3 class="text-[18px] lg:text-[20px] font-bold text-heading mb-4 leading-tight line-clamp-2 group-hover:text-primary transition-colors">
                                        <?php the_title(); ?>
                                    </h3>
                                    <?php if ( $show_excerpt ) : ?>
                                        <p class="text-body text-sm leading-relaxed mb-8 line-clamp-3"></p>
                                    <?php endif; ?>
                                    <div class="mt-auto pt-6 border-t border-border/60 flex justify-between items-center text-[12px] font-mono text-muted uppercase">
                                        <?php if ( $date_label ) : ?>
                                            <span><?php echo esc_html( $date_label ); ?></span>
                                        <?php endif; ?>
                                        <?php if ( $read_label ) : ?>
                                            <span><?php echo esc_html( $read_label ); ?></span>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </a>
                        </div>
                    <?php endwhile; ?>
                    <?php wp_reset_postdata(); ?>
                <?php else : ?>
                    <div class="w-full text-center text-muted py-8"></div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>
