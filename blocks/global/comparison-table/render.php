<?php
/**
 * Comparison Table Block Template
 * 
 * @package GeneratePressChild
 */
// Prefix Support
$pfx = isset($block['prefix']) ? $block['prefix'] : '';


// 1. 获取数据作用域 (Data Scope)
$block = isset( $block ) ? $block : array();
$block_id = _3dp_get_safe_block_id( $block, 'comparison-table' );

// 万能取数逻辑
// 确定克隆名
$clone_name = rtrim($pfx, '_');

// 使用万能取数逻辑获取字段值
$title           = get_field_value('table_title', $block, $clone_name, $pfx, '');
$description     = get_field_value('table_description', $block, $clone_name, $pfx, '');
$tabs            = get_field_value('comparison_tabs', $block, $clone_name, $pfx, array()); // Repeater: Tabs (New)
$highlight_idx   = get_field_value('highlight_index', $block, $clone_name, $pfx, 1);
$use_mono        = get_field_value('use_mono', $block, $clone_name, $pfx, false);
$mobile_compact  = get_field_value('comparison_mobile_compact_mode', $block, $clone_name, $pfx, false);
$anchor_id       = get_field_value('anchor_id', $block, $clone_name, $pfx, '');
$custom_class    = get_field_value('comparison_table_custom_class', $block, $clone_name, $pfx, '');

// 统一数据结构：仅使用 Tabs
$render_tabs = array();
if ( is_array( $tabs ) ) {
    foreach ( $tabs as $t ) {
        $t_rows = isset( $t['tab_rows'] ) ? $t['tab_rows'] : array();
        if ( ! empty( $t_rows ) ) {
            $render_tabs[] = array(
                'label' => $t['tab_label'],
                'rows'  => $t_rows,
                'col_count' => isset($t['tab_column_count']) && !empty($t['tab_column_count']) ? (int)$t['tab_column_count'] : 6,
            );
        }
    }
}

// 如果没有数据，不渲染
if ( empty( $render_tabs ) ) {
    if ( function_exists('is_admin') && is_admin() ) {
        echo '<div class="p-4 border border-dashed text-gray-400">Please add Data Tabs with at least 1 row (header).</div>';
    }
    return;
}

// ID与Class
$id_attr = $anchor_id ? 'id="' . esc_attr( $anchor_id ) . '"' : '';

// --- Dynamic Spacing Logic ---
$bg_color = get_field_value('comparison_table_background_color', $block, $clone_name, $pfx, '#ffffff');
$prev_bg = isset($GLOBALS['3dp_last_bg']) ? $GLOBALS['3dp_last_bg'] : '';
$pt_class = ($prev_bg && $prev_bg === $bg_color) ? 'pt-[100px]' : 'pt-16 lg:pt-24'; // 增加 100px 以解决标题与边框过近的问题
$pb_class = 'pb-16 lg:pb-24';
$section_spacing = $pt_class . ' ' . $pb_class;

// Update Global State
$GLOBALS['3dp_last_bg'] = $bg_color;

$classes = $section_spacing . ( $custom_class ? ' ' . esc_attr( $custom_class ) : '' );

// 字体配置
$font_mono_class = $use_mono ? 'font-mono' : '';
// 移动端紧凑模式
$td_padding = $mobile_compact ? 'py-4 px-4 lg:py-6 lg:px-8' : 'py-6 px-8';
$th_padding = $mobile_compact ? 'py-3 px-4 lg:py-5 lg:px-8' : 'py-5 px-8';
$text_size  = $mobile_compact ? 'text-xs lg:text-sm' : 'text-sm';

// 是否展示 Tab 导航
// 1. 多个 Tab 肯定展示
// 2. 只有一个 Tab 时，如果 Label 为空则不展示
$show_tabs = count($render_tabs) > 1;
if (count($render_tabs) === 1 && !empty($render_tabs[0]['label'])) {
    $show_tabs = true;
}

// Alpine Config
// activeTab: 0 (default first tab)
// activeIndex: highlight_idx (default row highlight)
// We need to reset activeIndex when tab changes? Maybe set to 1.
$alpine_data = sprintf( '{ activeTab: 0, activeIndex: %d }', esc_attr( $highlight_idx ) );

?>

<section <?php echo $id_attr; ?> class="<?php echo esc_attr( $classes ); ?>" style="background-color: <?php echo esc_attr($bg_color); ?>;" x-data="<?php echo esc_attr( $alpine_data ); ?>">
    <div class="max-w-container mx-auto px-6 lg:px-8">
        
        <?php if ( $title ) : ?>
        <header class="<?php echo $show_tabs ? 'mb-6 lg:mb-8' : 'mb-12 lg:mb-16'; ?>">
            <h2 class="text-heading">
                <?php echo esc_html( $title ); ?>
            </h2>
            <?php if ( $description ) : ?>
                <p class="text-[14px] lg:text-[15px] max-w-2xl leading-relaxed opacity-90"><?php echo esc_html( $description ); ?></p>
            <?php endif; ?>
        </header>
        <?php endif; ?>
            
        <?php if ( $show_tabs ) : ?>
        <!-- Tab Navigation (Underline Style - Matches Technical Specs) -->
        <div class="flex flex-nowrap gap-1 border-b border-border mb-6 lg:mb-8 overflow-x-auto no-scrollbar">
            <?php foreach ( $render_tabs as $idx => $tab ) : ?>
                <div 
                    role="tab" aria-selected="false"
                    @click="activeTab = <?php echo $idx; ?>; activeIndex = 1"
                    class="whitespace-nowrap px-4 py-3 text-[13px] font-bold transition-colors !bg-transparent !border-t-0 !border-l-0 !border-r-0 !border-b-2 !shadow-none !ring-0 focus:!outline-none cursor-pointer"
                    :class="activeTab === <?php echo $idx; ?> ? '!border-primary text-primary' : '!border-transparent text-gray-500 hover:text-primary'"
                >
                    <?php echo esc_html( $tab['label'] ); ?>
                </div>
            <?php endforeach; ?>
        </div>
        <?php endif; ?>

        <!-- Table Container -->
        <div class="bg-white rounded-xl border border-border shadow-sm">
            <div class="overflow-x-auto no-scrollbar">
                
                <?php 
                // Loop through Tabs (or Single List)
                foreach ( $render_tabs as $tab_idx => $tab_data ) : 
                    $current_rows = $tab_data['rows'];
                    if ( empty( $current_rows ) ) continue;
                    $header_row = $current_rows[0];
                    $body_rows  = array_slice( $current_rows, 1 );
                    
                    // 计算有效列：根据 tab_column_count 设置
                    $limit_cols = isset($tab_data['col_count']) ? $tab_data['col_count'] : 6;
                    $all_keys   = array('v1','v2','v3','v4','v5','v6');
                    $valid_cols = array_slice($all_keys, 0, $limit_cols);
                    
                    $col_count = count( $valid_cols );
                    if ( $col_count === 0 ) continue;
                ?>
                <div x-show="activeTab === <?php echo $tab_idx; ?>" class="w-full">
                    <table class="w-full text-left border-separate border-spacing-0 min-w-[1000px] mb-0">
                        <thead>
                            <tr class="bg-bg-table text-heading tracking-tight text-[14px] font-bold">
                                <?php foreach ( $valid_cols as $index => $vk ) : 
                                    $is_first = $index === 0;
                                    $is_last  = $index === ( $col_count - 1 );
                                    $is_even  = ( $index + 1 ) % 2 === 0;
                                    $th_class = $th_padding . ' border-b border-border';
                                    if ( $is_first ) $th_class .= ' rounded-tl-lg';
                                    if ( $is_last )  $th_class .= ' rounded-tr-lg';
                                    if ( $is_even )  $th_class .= ' bg-bg-table/60';
                                ?>
                                    <th class="<?php echo esc_attr( $th_class ); ?>">
                                        <?php echo esc_html( $header_row[ $vk ] ); ?>
                                    </th>
                                <?php endforeach; ?>
                            </tr>
                        </thead>
                        
                        <tbody class="<?php echo esc_attr( $text_size ); ?>">
                            <?php 
                            foreach ( $body_rows as $row_idx => $row ) : 
                                // Alpine index (body) 从1开始
                                $current_idx = $row_idx + 1;
                                
                                // Row Logic hooks
                                // lock-row styles mapped to Tailwind arbitrary values
                                // relative z-10 after:absolute after:inset-0 after:border-[3px] after:border-primary after:pointer-events-none after:z-30 after:shadow-[0_12px_30px_-10px_rgba(0,71,171,0.3)]
                                $lock_row_cls = 'relative z-10 after:content-[\'\'] after:absolute after:inset-0 after:border-[3px] after:border-primary after:pointer-events-none after:z-30 after:shadow-[0_12px_30px_-10px_rgba(0,71,171,0.3)]';
                                ?>
                                <tr @click="activeIndex = <?php echo $current_idx; ?>"
                                    :class="activeIndex === <?php echo $current_idx; ?> ? '<?php echo $lock_row_cls; ?>' : 'hover:bg-bg-table/40 cursor-pointer'"
                                    class="transition-colors duration-150 group">
                                    
                                    <?php 
                                    foreach ( $valid_cols as $col_idx => $val_key ) : 
                                        $value   = isset( $row[ $val_key ] ) ? $row[ $val_key ] : '';
                                        
                                        $is_first_col = $col_idx === 0;
                                        $is_last_col  = $col_idx === ( $col_count - 1 );
                                        $is_even_col  = ( $col_idx + 1 ) % 2 === 0;
                                        $is_last_row  = ( $row_idx === count( $body_rows ) - 1 );
                                        
                                        // Corner Logic for Last Row
                                        $corner_class = '';
                                        if ( $is_last_row ) {
                                            if ( $is_first_col ) $corner_class = ' rounded-bl-lg';
                                            if ( $is_last_col )  $corner_class = ' rounded-br-lg';
                                        }
                                        
                                        // Cell Base Classes
                                        $td_base = $td_padding . ' border-b border-border transition-colors ' . ( $use_mono && ! $is_first_col ? 'font-mono' : '' ) . $corner_class;
                                        
                                        // Dynamic Classes for Active State
                                        // Need to construct the :class string for Alpine
                                        // Default State (Inactive)
                                        $bg_default = $is_even_col ? 'bg-bg-table/40' : 'bg-white';
                                        $text_default = $is_first_col ? 'text-heading font-bold' : 'text-body';
                                        if ( $is_last_col && ! $is_first_col ) $text_default = 'text-heading'; // Last col often bold/heading
                                        
                                        // Active State
                                        $bg_active = $is_even_col ? 'bg-[#DEEAFF]' : 'bg-[#EBF2FF]';
                                        $text_active = $is_first_col ? 'text-primary' : 'text-heading'; // Simplify: Active is always darker/primary
                                        if ( $is_even_col && ! $is_first_col ) $text_active = 'text-primary'; // Even cols active text
                                        
                                        // Corner rounding
                                        $extra_active = '';
                                        // if ( $is_first_col ) $extra_active = 'rounded-l-xl';
                                        // if ( $is_last_col )  $extra_active = 'rounded-r-xl';
                                        
                                        // Special: Lock row hides border bottom? Design says: .lock-row td { border-bottom-color: transparent !important; }
                                        // We can add border-transparent to active state
                                        $border_active = 'border-transparent';
                                        
                                        // Construct Alpine ternary strings
                                        $class_active   = "$bg_active $text_active $extra_active $border_active";
                                        $class_inactive = "$bg_default $text_default";
                                        ?>
                                        <td class="<?php echo esc_attr( $td_base ); ?>"
                                            :class="activeIndex === <?php echo $current_idx; ?> ? '<?php echo $class_active; ?>' : '<?php echo $class_inactive; ?>'">
                                            
                                            <?php if ( $is_first_col ) : ?>
                                                <!-- First Column: ID/Label -->
                                                <span><?php echo esc_html( $value ); ?></span>
                                            <?php elseif ( $is_even_col ) : ?>
                                                <!-- Even Column: With Dot Indicator -->
                                                <div class="flex items-center gap-2">
                                                    <span class="w-1.5 h-1.5 rounded-full" 
                                                          :class="activeIndex === <?php echo $current_idx; ?> ? 'bg-primary' : 'bg-primary/20'">
                                                    </span>
                                                    <span><?php echo esc_html( $value ); ?></span>
                                                </div>
                                            <?php else : ?>
                                                <!-- Regular Column -->
                                                <span class="opacity-90"><?php echo esc_html( $value ); ?></span>
                                            <?php endif; ?>
                                            
                                        </td>
                                    <?php endforeach; ?>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
                <?php endforeach; ?>

            </div>
        </div>
    </div>
</section>

<?php
// End of file
?>
