<?php
/**
 * Block: Factory Image (Factory Tour)
 * Description: Frontend render template for the Industrial Factory Image Grid module.
 */
// Prefix Support
$pfx = isset($block['prefix']) ? $block['prefix'] : '';

// 1. 获取 Block 核心数据
$block = isset( $block ) ? $block : array();
$block_id = _3dp_get_safe_block_id( $block, 'factory-image' );
$is_preview = isset($is_preview) && $is_preview;

// 2. 万能取数逻辑
// 确定克隆名
$clone_name = rtrim($pfx, '_');

// 3. 获取 ACF 字段数据
$header_group   = get_field_value('header_group', $block, $clone_name, $pfx);
$items          = get_field_value('gallery_items', $block, $clone_name, $pfx, array());
$bg_style       = get_field_value('background_style', $block, $clone_name, $pfx, 'industrial');
$mobile_opts    = get_field_value('mobile_options', $block, $clone_name, $pfx, array());
$custom_block_id = get_field_value('block_id', $block, $clone_name, $pfx);
$custom_class   = get_field_value('custom_class', $block, $clone_name, $pfx, '');

// 2. Process Header Data
$title          = isset($header_group['title']) ? $header_group['title'] : '';
$highlight      = isset($header_group['highlight_word']) ? $header_group['highlight_word'] : '';
$description    = isset($header_group['description']) ? $header_group['description'] : '';
$cta_link       = isset($header_group['cta_link']) ? $header_group['cta_link'] : null;

// Process Title Highlight
if ( $title && $highlight ) {
    $title_html = str_replace(
        $highlight, 
        '<span class="text-primary">' . esc_html($highlight) . '</span>', 
        esc_html($title)
    );
} else {
    $title_html = esc_html($title);
}

// Background Logic
$bg_color_class = 'bg-white';
$bg_class_to_add = 'bg-white';
if ( $bg_style === 'industrial' ) {
    $bg_class_to_add = 'industrial-grid-bg';
    $bg_color_class = 'industrial-grid-bg';
} elseif ( $bg_style === 'white' ) {
    $bg_class_to_add = 'bg-white';
    $bg_color_class = 'bg-white';
}

// Dynamic Spacing
$prev_bg = isset($GLOBALS['3dp_last_bg']) ? $GLOBALS['3dp_last_bg'] : '';
$pt_class = ($prev_bg && $prev_bg === $bg_color_class) ? 'pt-0' : 'pt-16 lg:pt-24';
$pb_class = 'pb-16 lg:pb-24';

// 3. Determine Classes
$section_classes = "$pt_class $pb_class relative $custom_class $bg_class_to_add";

// 确定最终ID：使用custom_block_id作为覆盖，否则使用block_id
$final_id = $custom_block_id ? $custom_block_id : $block_id;

// Mobile Options
$is_compact_mobile = in_array('compact_grid', $mobile_opts);
$hide_mobile_desc  = in_array('hide_content', $mobile_opts);

?>

<section id="<?php echo esc_attr($final_id); ?>" class="<?php echo esc_attr($section_classes); ?>" x-data="{ 
    showFactoryLightbox: false, 
    activeImg: '', 
    activeTitle: '',
    activeWidth: '',
    activeHeight: '',
    openImg(url, title, w, h) {
        this.activeImg = url;
        this.activeTitle = title;
        this.activeWidth = w;
        this.activeHeight = h;
        this.showFactoryLightbox = true;
    }
}">
    <div class="max-w-container mx-auto px-6 lg:px-8">
        
        <!-- Header -->
        <div class="mb-12 lg:mb-16 flex flex-col lg:flex-row justify-between items-end gap-6">
            <div class="max-w-2xl text-left">
                <?php if ( $title ) : ?>
                    <h2 class="industrial-h2 text-[32px] lg:text-[40px] font-bold text-heading mb-4 leading-tight">
                        <?php echo wp_kses_post($title_html); ?>
                    </h2>
                <?php endif; ?>
                
                <?php if ( $description ) : ?>
                    <p class="text-body text-[16px] lg:text-[18px] opacity-90 leading-relaxed">
                        <?php echo esc_html($description); ?>
                    </p>
                <?php endif; ?>
            </div>

            <?php if ( $cta_link ) : 
                $cta_url = $cta_link['url'];
                $cta_title = $cta_link['title'];
                $cta_target = $cta_link['target'] ? $cta_link['target'] : '_self';
            ?>
                <a href="<?php echo esc_url($cta_url); ?>" target="<?php echo esc_attr($cta_target); ?>" class="hidden lg:inline-flex items-center gap-2 bg-primary text-white px-8 py-3.5 rounded-[8px] font-bold text-[13px] uppercase tracking-wider hover:bg-[#003A8C] transition-all shadow-lg shadow-primary/10 group">
                    <?php echo esc_html($cta_title); ?>
                    <svg class="w-4 h-4 transition-transform group-hover:translate-x-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-width="2.5" d="M13 7l5 5m0 0l-5 5m5-5H6"/></svg>
                </a>
            <?php endif; ?>
        </div>

        <!-- Bento Grid Layout -->
        <?php if ( $items ) : ?>
            <div class="grid grid-cols-2 lg:grid-cols-4 lg:grid-rows-2 gap-4 lg:gap-6 h-auto lg:h-[640px]">
                
                <?php foreach ( $items as $index => $item ) : 
                    // Data Extraction
                    $img_id         = $item['image'];
                    $mobile_img_id  = $item['mobile_image'];
                    $tag_text       = $item['tag_text'];
                    $item_title     = $item['item_title'];
                    $item_sub       = $item['item_subtitle'];

                    // Image URL Logic (Prefer Desktop, no complex picture tag to keep DOM simple as per design)
                    // But we can check if it's mobile view in CSS or just use object-cover. 
                    // Let's use the Desktop image URL for the lightbox and main display for simplicity, 
                    // unless we want to do a <picture> tag. 
                    // Given the constraint "Pixel-Perfect", let's stick to simple <img> but use the main image.
                    $img_data = wp_get_attachment_image_src($img_id, 'full'); 
                    $img_url = $img_data ? $img_data[0] : '';
                    $img_w = $img_data ? $img_data[1] : '';
                    $img_h = $img_data ? $img_data[2] : '';

                    $img_alt = get_post_meta($img_id, '_wp_attachment_image_alt', true) ?: $item_title;

                    // Layout Logic
                    $is_hero = ($index === 0);
                    
                    // Class Logic
                    // Hero: col-span-2 lg:col-span-2 lg:row-span-2 (Desktop 2x2, Mobile 2x1)
                    // Detail: col-span-1 (Desktop 1x1, Mobile 1x1)
                    $card_classes = 'bento-card group tech-overlay relative overflow-hidden cursor-zoom-in';
                    
                    if ( $is_hero ) {
                        $card_classes .= ' col-span-2 lg:col-span-2 lg:row-span-2 h-[280px] lg:h-auto';
                    } else {
                        $card_classes .= ' col-span-1 h-[180px] lg:h-auto';
                    }
                ?>
                    <div class="<?php echo esc_attr($card_classes); ?>"
                         @click="openImg('<?php echo esc_url($img_url); ?>', '<?php echo esc_js($item_title); ?>', '<?php echo esc_attr($img_w); ?>', '<?php echo esc_attr($img_h); ?>')">
                        
                        <?php if ( $tag_text ) : ?>
                            <span class="mono-tag <?php echo $is_hero ? '' : 'text-[9px] lg:text-[11px]'; ?>">
                                <?php echo esc_html($tag_text); ?>
                            </span>
                        <?php endif; ?>

                        <!-- Image -->
                        <?php echo wp_get_attachment_image($img_id, 'full', false, array('class' => 'w-full h-full object-cover')); ?>

                        <!-- Overlay & Info -->
                        <?php if ( $is_hero ) : ?>
                            <!-- Hero: Mobile visible, Desktop hover (handled by CSS) -->
                            <div class="card-overlay opacity-100 lg:opacity-0"></div>
                            <div class="card-info opacity-100 lg:opacity-0 lg:translate-y-2">
                                <h4 class="text-lg font-bold leading-tight"><?php echo esc_html($item_title); ?></h4>
                                <?php if ( $item_sub ) : ?>
                                    <p class="text-sm opacity-90 font-mono mt-1"><?php echo esc_html($item_sub); ?></p>
                                <?php endif; ?>
                            </div>
                        <?php else : ?>
                            <!-- Detail: Hover only (handled by CSS) -->
                            <div class="card-overlay"></div>
                            <div class="card-info">
                                <h4 class="text-xs lg:text-md font-bold leading-tight"><?php echo esc_html($item_title); ?></h4>
                            </div>
                        <?php endif; ?>
                    </div>
                <?php endforeach; ?>
                
            </div>
        <?php endif; ?>
    </div>

    <!-- Lightbox (Alpine.js) -->
    <template x-teleport="body">
        <div x-show="showFactoryLightbox" 
             x-cloak
             x-transition:enter="transition ease-out duration-300"
             x-transition:enter-start="opacity-0"
             x-transition:enter-end="opacity-100"
             x-transition:leave="transition ease-in duration-200"
             x-transition:leave-start="opacity-100"
             x-transition:leave-end="opacity-0"
             :class="{ 'flex': showFactoryLightbox }"
             class="fixed inset-0 z-[9999] bg-[#1D2938]/95 backdrop-blur-sm items-center justify-center p-4"
             style="display: none;">
            
            <div class="absolute inset-0" @click="showFactoryLightbox = false"></div>

            <button @click="showFactoryLightbox = false" class="absolute top-6 right-6 text-white/70 hover:text-white transition-colors z-50">
                <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
            </button>

            <div class="max-w-6xl w-full flex flex-col items-center relative z-10 pointer-events-none">
                <img :src="activeImg" :width="activeWidth" :height="activeHeight" class="max-h-[80vh] w-auto object-contain rounded-lg shadow-2xl pointer-events-auto border border-white/10" loading="lazy">
                <h5 class="text-white mt-6 text-xl font-bold font-mono tracking-tight pointer-events-auto" x-text="activeTitle"></h5>
            </div>
        </div>
    </template>

</section>

<?php
// Set global state for next block
$GLOBALS['3dp_last_bg'] = $bg_color_class;
?>
