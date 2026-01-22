<?php
/**
 * Block Template: Mission & Vision
 * 
 * Path: blocks/global/mission/render.php
 * Description: Renders the Mission & Vision section with split-card layout.
 */
// Prefix Support
$pfx = isset($block['prefix']) ? $block['prefix'] : '';

// 1. 获取 Block 核心数据
$block = isset( $block ) ? $block : array();
$block_id = _3dp_get_safe_block_id( $block, 'mission' );
$is_preview = isset($is_preview) && $is_preview;

// 2. 万能取数逻辑
// 确定克隆名
$clone_name = rtrim($pfx, '_');

// 3. 获取 ACF 字段数据
$header         = get_field_value('mission_header', $block, $clone_name, $pfx);
$bg_style       = get_field_value('background_style', $block, $clone_name, $pfx);
$mobile_hide    = get_field_value('mobile_hide_content', $block, $clone_name, $pfx);
$anchor_id      = get_field_value('anchor_id', $block, $clone_name, $pfx);

// 2. Class Logic
$section_classes = 'border-y border-border relative';

// Background
$bg_color_hex = '#ffffff'; // Default
if ( $bg_style === 'grid' ) {
    $section_classes .= ' industrial-grid-bg';
    $bg_color_hex = '#ffffff'; // Assuming grid is on white
} elseif ( $bg_style === 'white' ) {
    $bg_color_hex = '#ffffff';
} elseif ( $bg_style === 'gray' ) {
    $bg_color_hex = '#F2F4F7';
}

// --- Dynamic Spacing Logic ---
$prev_bg = isset($GLOBALS['3dp_last_bg']) ? $GLOBALS['3dp_last_bg'] : '';
$current_bg_for_state = $bg_color_hex; 
$pt_remove = ($prev_bg && $prev_bg === $current_bg_for_state) ? 'pt-0' : '';

$pt_class = $pt_remove ? 'pt-0' : 'pt-16 lg:pt-24';
$pb_class = 'pb-16 lg:pb-24';
$section_spacing = $pt_class . ' ' . $pb_class;
$section_classes .= ' ' . $section_spacing;

// Set global state for next block
$GLOBALS['3dp_last_bg'] = $current_bg_for_state;

// Mobile Visibility
if ( $mobile_hide ) {
    $section_classes .= ' hidden lg:block';
}

// 获取mission items数据
$mission_items = get_field_value('mission_items', $block, $clone_name, $pfx, array());

// Anchor ID: 使用block_id作为主要ID，anchor_id作为覆盖
$final_id = $anchor_id ? $anchor_id : $block_id;
$id_attr = 'id="' . esc_attr($final_id) . '"';

?>

<section <?php echo $id_attr; ?> class="<?php echo esc_attr($section_classes); ?>" style="background-color: <?php echo esc_attr($bg_color_hex); ?>;">
    <div class="max-w-container mx-auto px-container">
        
        <?php if ( $header ) : ?>
        <div class="mb-20 text-center">
            <h2 class="text-[36px] font-bold text-heading tracking-tight mb-4 inline-block relative">
                <?php echo esc_html( $header['prefix'] ); ?> <span class="text-primary"><?php echo esc_html( $header['highlight'] ); ?></span>
                <span class="absolute -bottom-4 left-1/2 -translate-x-1/2 w-12 h-1 bg-primary"></span>
            </h2>
            <?php if ( ! empty( $header['description'] ) ) : ?>
            <p class="text-[18px] text-body max-w-2xl mx-auto mt-8 font-sans">
                <?php echo esc_html( $header['description'] ); ?>
            </p>
            <?php endif; ?>
        </div>
        <?php endif; ?>

        <div class="space-y-24">
            
            <?php 
            if ( !empty($mission_items) && is_array($mission_items) ) : 
                $i = 0;
                foreach ( $mission_items as $mission_item ) : 
                    $icon           = $mission_item['icon'];
                    $label          = $mission_item['label'];
                    $title          = $mission_item['title'];
                    $desc           = $mission_item['description'];
                    $image          = $mission_item['image'];
                    $mobile_image   = $mission_item['mobile_image']; // Optional usage logic if needed
                    
                    // Layout Logic: Even = Image Left; Odd = Image Right
                    $is_odd = ($i % 2 !== 0);
                    $i++;
            ?>
            
            <div class="grid lg:grid-cols-2 gap-12 items-center group">
                
                <!-- Image Column -->
                <div class="relative rounded-card overflow-hidden border border-border shadow-xl shadow-primary/5 tech-overlay h-[400px] lg:h-[480px] <?php echo $is_odd ? 'lg:order-last' : ''; ?>">
                    <!-- Scanline Animation (CSS in style.css) -->
                    <div class="scanline" style="<?php echo $is_odd ? 'animation-delay: 2s;' : ''; ?>"></div>
                    
                    <?php if ( $image ) : ?>
                        <img src="<?php echo esc_url($image['url']); ?>" 
                             width="<?php echo esc_attr($image['width']); ?>"
                             height="<?php echo esc_attr($image['height']); ?>"
                             alt="<?php echo esc_attr($image['alt']); ?>" 
                             class="w-full h-full object-cover scale-105 group-hover:scale-100 transition-transform duration-700 grayscale hover:grayscale-0"
                             loading="lazy">
                    <?php endif; ?>

                    <!-- Corner Accents -->
                    <?php if ( $is_odd ) : ?>
                        <div class="absolute bottom-4 left-4 w-4 h-4 border-b border-l border-primary/50"></div>
                        <div class="absolute bottom-4 right-4 w-4 h-4 border-b border-r border-primary/50"></div>
                    <?php else : ?>
                        <div class="absolute top-4 left-4 w-4 h-4 border-t border-l border-primary/50"></div>
                        <div class="absolute top-4 right-4 w-4 h-4 border-t border-r border-primary/50"></div>
                    <?php endif; ?>
                </div>

                <!-- Content Column -->
                <div class="<?php echo $is_odd ? 'lg:pr-8' : 'lg:pl-8'; ?>">
                    
                    <!-- Label & Icon -->
                    <div class="flex items-center gap-4 mb-6">
                        <div class="w-12 h-12 rounded-[8px] bg-primary/10 flex items-center justify-center text-primary overflow-hidden">
                            <?php if ( $icon ) : ?>
                                <img src="<?php echo esc_url($icon['url']); ?>" width="<?php echo esc_attr($icon['width']); ?>" height="<?php echo esc_attr($icon['height']); ?>" alt="<?php echo esc_attr($icon['alt']); ?>" class="w-6 h-6">
                            <?php endif; ?>
                        </div>
                        <span class="font-mono text-[12px] font-bold text-primary uppercase tracking-widest">
                            <?php echo esc_html( $label ); ?>
                        </span>
                    </div>

                    <!-- Headline -->
                    <h3 class="text-[30px] font-bold text-heading mb-6 leading-tight">
                        <?php echo esc_html( $title ); ?>
                    </h3>

                    <!-- Description -->
                    <p class="text-[16px] text-body leading-relaxed mb-10">
                        <?php echo esc_html( $desc ); ?>
                    </p>
                    
                    <!-- Data Points (Stats) -->
                    <?php if ( !empty($mission_item['stats']) && is_array($mission_item['stats']) ) : ?>
                    <div class="bg-white border-l-2 border-primary pl-6 py-4 grid grid-cols-2 gap-8">
                        <?php foreach ( $mission_item['stats'] as $stat ) : 
                            $stat_label = $stat['label'];
                            $stat_value = $stat['value'];
                            $stat_style = $stat['style'];
                        ?>
                        <div>
                            <p class="font-mono text-[10px] text-body/60 uppercase font-bold mb-1">
                                <?php echo esc_html( $stat_label ); ?>
                            </p>
                            
                            <?php if ( $stat_style === 'highlight' ) : ?>
                                <p class="font-mono text-[12px] font-bold text-primary mt-2">
                                    <?php echo esc_html( $stat_value ); ?>
                                </p>
                            <?php else : ?>
                                <p class="font-mono text-[24px] font-bold text-heading">
                                    <?php echo esc_html( $stat_value ); ?>
                                </p>
                            <?php endif; ?>
                        </div>
                        <?php endforeach; ?>
                    </div>
                    <?php endif; ?>

                </div>
            </div>

            <?php 
                endforeach; 
            endif; 
            ?>

        </div>
    </div>
</section>
