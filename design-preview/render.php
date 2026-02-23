<?php

// Prefix Support
$pfx = isset($block['prefix']) ? $block['prefix'] : '';
$block = isset( $block ) ? $block : array();
$block_id = _3dp_get_safe_block_id( $block, 'manufacturing-showcase' );

// 万能取数逻辑
// 确定克隆名
$clone_name = rtrim($pfx, '_');

// 使用万能取数逻辑获取字段值
$custom_class = (string) get_field_value('manufacturing_showcase_css_class', $block, $clone_name, $pfx, '' );
$title       = (string) get_field_value('manufacturing_showcase_title', $block, $clone_name, $pfx, 'Manufacturing Showcase' );
$layout_mode = (string) get_field_value('manufacturing_showcase_layout_mode', $block, $clone_name, $pfx, 'slider' );
$items_per   = (int) get_field_value('manufacturing_showcase_items_per_view', $block, $clone_name, $pfx, 3 );
$items_per   = $items_per > 0 ? $items_per : 3;
$show_nav    = (bool) get_field_value('manufacturing_showcase_show_nav', $block, $clone_name, $pfx, false );
$compact     = (bool) get_field_value('manufacturing_showcase_mobile_compact_mode', $block, $clone_name, $pfx, false );

$lg_card_w = $items_per === 2 ? 'lg:w-[calc(50%-16px)]' : ( $items_per === 4 ? 'lg:w-[calc(25%-16px)]' : 'lg:w-[calc(33.333%-16px)]' );
$mb_card_w = $compact ? 'w-[85%]' : 'w-full';

// 获取 Gallery IDs
$showcase_ids = array();

// 优先级 A: Group 模式嵌套
if (isset($block[$clone_name]) && isset($block[$clone_name]['manufacturing_showcase_gallery'])) {
    $showcase_ids = $block[$clone_name]['manufacturing_showcase_gallery'];
} 
// 优先级 B: 直接存在于 block 中
elseif (isset($block['manufacturing_showcase_gallery'])) {
    $showcase_ids = $block['manufacturing_showcase_gallery'];
} 
// 优先级 C: 从数据库读取
elseif ( $db_items = get_field($pfx . 'manufacturing_showcase_gallery') ) {
    $showcase_ids = $db_items;
}

// 兼容旧数据 (如果用户之前用 Repeater 存了数据，这里尝试读取并转换)
// 注意：这只是为了防止报错，实际上因为字段名变了，旧数据可能读不到。
// 如果非常需要兼容，需要去读 'manufacturing_showcase_items' 并手动提取图片 ID。
if ( empty($showcase_ids) ) {
    $old_repeater = get_field($pfx . 'manufacturing_showcase_items');
    if ( is_array($old_repeater) ) {
        $showcase_ids = array();
        foreach ( $old_repeater as $row ) {
            if ( !empty($row['item_image']) ) {
                $showcase_ids[] = $row['item_image'];
            }
        }
    }
}

// 确保是数组
$showcase_ids = is_array($showcase_ids) ? $showcase_ids : array();

// 动态背景样式
$bg_color = get_field_value('manufacturing_showcase_background_color', $block, $clone_name, $pfx, '#ffffff');
$bg_style_attr = 'style="background-color: ' . esc_attr( $bg_color ) . '"';

// --- Dynamic Spacing Logic ---
$prev_bg = isset($GLOBALS['3dp_last_bg']) ? $GLOBALS['3dp_last_bg'] : '';
$current_bg_for_state = $bg_color; 
$pt_remove = ($prev_bg && $prev_bg === $current_bg_for_state) ? 'pt-0' : '';

$pt_class = $pt_remove ? 'pt-0' : 'pt-16 lg:pt-24';
$pb_class = 'pb-16 lg:pb-24';
$section_spacing = $pt_class . ' ' . $pb_class;

// Set global state for next block
$GLOBALS['3dp_last_bg'] = $current_bg_for_state;

// 获取锚点ID
$anchor_id = get_field_value('manufacturing_showcase_anchor_id', $block, $clone_name, $pfx, '' );

if ( empty( $showcase_ids ) ) { return; }
?>

<div id="<?php echo $anchor_id ? esc_attr($anchor_id) : ''; ?>" class="overflow-hidden <?php echo esc_attr($section_spacing); ?>"<?php echo $bg_style_attr; ?>>
    <div class="mx-auto max-w-container px-container <?php echo esc_attr($custom_class); ?>">
        <?php if ( $title ) : ?>
            <div class="text-center mb-10 lg:mb-14">
                <h2 class="text-h2 font-semibold text-heading tracking-tight mb-3"><?php echo esc_html($title); ?></h2>
            </div>
        <?php endif; ?>

        <?php if ( $layout_mode === 'slider' ) : ?>
            <div x-data="{scrollSlider(dir){const t=this.$refs.track;const amt=t.offsetWidth*0.8;t.scrollBy({left:dir*amt,behavior:'smooth'});}}" class="relative">
                <?php if ( $show_nav ) : ?>
                    <div class="hidden lg:flex gap-4 absolute -top-[84px] right-0 z-20">
                        <button @click="scrollSlider(-1)" class="industry-prev w-12 h-12 rounded-full border-[3px] border-border bg-white flex items-center justify-center hover:border-primary text-heading transition-colors" aria-label="<?php echo esc_attr( __( 'Previous', '3d-printing' ) ); ?>">
                            ←
                        </button>
                        <button @click="scrollSlider(1)" class="industry-next w-12 h-12 rounded-full border-[3px] border-border bg-white flex items-center justify-center hover:border-primary text-heading transition-colors" aria-label="<?php echo esc_attr( __( 'Next', '3d-printing' ) ); ?>">
                            →
                        </button>
                    </div>
                <?php endif; ?>

                <div x-ref="track" class="flex gap-6 overflow-x-auto no-scrollbar scroll-smooth snap-x snap-mandatory pb-8">
                    <?php foreach ( $showcase_ids as $img_id ) : ?>
                        <?php
                        $img_id = (int) $img_id;
                        if ( !$img_id ) continue;

                        // Get image data with dimensions
                        $img_data = function_exists('wp_get_attachment_image_src') ? wp_get_attachment_image_src( $img_id, 'large' ) : null;
                        $src_url  = $img_data ? $img_data[0] : '';
                        $width    = $img_data ? $img_data[1] : '';
                        $height   = $img_data ? $img_data[2] : '';
                        
                        // Try to get alt text from attachment
                        $alt_text = get_post_meta($img_id, '_wp_attachment_image_alt', true);
                        if (!$alt_text) $alt_text = 'Manufacturing Showcase';
                        ?>
                        <div class="flex-none <?php echo esc_attr($mb_card_w); ?> <?php echo esc_attr($lg_card_w); ?> snap-start">
                            <div class="relative aspect-[4/3] rounded-card overflow-hidden border border-border bg-bg-section group cursor-pointer">
                                <?php if ( $src_url ) : ?>
                                    <img src="<?php echo esc_attr($src_url); ?>" width="<?php echo esc_attr($width); ?>" height="<?php echo esc_attr($height); ?>" alt="<?php echo esc_attr($alt_text); ?>" class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-105" loading="lazy" />
                                <?php endif; ?>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        <?php else : ?>
            <div class="grid grid-cols-1 lg:grid-cols-<?php echo esc_attr((string) $items_per); ?> gap-6">
                <?php foreach ( $showcase_ids as $img_id ) : ?>
                    <?php
                    $img_id = (int) $img_id;
                    if ( !$img_id ) continue;

                    // Get image data with dimensions
                    $img_data = function_exists('wp_get_attachment_image_src') ? wp_get_attachment_image_src( $img_id, 'large' ) : null;
                    $src_url  = $img_data ? $img_data[0] : '';
                    $width    = $img_data ? $img_data[1] : '';
                    $height   = $img_data ? $img_data[2] : '';
                    
                    $alt_text = get_post_meta($img_id, '_wp_attachment_image_alt', true);
                    if (!$alt_text) $alt_text = 'Manufacturing Showcase';
                    ?>
                    <div>
                        <div class="relative aspect-[4/3] rounded-card overflow-hidden border border-border bg-bg-section group cursor-pointer">
                            <?php if ( $src_url ) : ?>
                                <img src="<?php echo esc_attr($src_url); ?>" width="<?php echo esc_attr($width); ?>" height="<?php echo esc_attr($height); ?>" alt="<?php echo esc_attr($alt_text); ?>" class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-105" loading="lazy" />
                            <?php endif; ?>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </div>
</div>
