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
$headers         = get_field_value('headers', $block, $clone_name, $pfx, array()); // Group: h1..h5
$rows            = get_field_value('comparison_rows', $block, $clone_name, $pfx, array()); // Repeater: v1..v5
$highlight_idx   = get_field_value('highlight_index', $block, $clone_name, $pfx, 1);
$use_mono        = get_field_value('use_mono', $block, $clone_name, $pfx, false);
$mobile_compact  = get_field_value('comparison_mobile_compact_mode', $block, $clone_name, $pfx, false);
$anchor_id       = get_field_value('anchor_id', $block, $clone_name, $pfx, '');
$custom_class    = get_field_value('comparison_table_custom_class', $block, $clone_name, $pfx, '');

// 2. 数据预处理
// 确定有效列（检查表头是否有内容）
$valid_cols = array();
if ( $headers ) {
    foreach ( array( 'h1', 'h2', 'h3', 'h4', 'h5' ) as $k ) {
        if ( ! empty( $headers[ $k ] ) ) {
            $valid_cols[] = $k; // e.g., 'h1', 'h2'
        }
    }
}

// 如果没有数据，不渲染
if ( empty( $valid_cols ) || empty( $rows ) ) {
    if ( is_admin() ) {
        echo '<div class="p-4 border border-dashed text-gray-400">Please add table headers and rows.</div>';
    }
    return;
}

// ID与Class
$id_attr = $anchor_id ? 'id="' . esc_attr( $anchor_id ) . '"' : '';

// --- Dynamic Spacing Logic ---
$bg_color = get_field_value('comparison_table_background_color', $block, $clone_name, $pfx, '#ffffff');
$prev_bg = isset($GLOBALS['3dp_last_bg']) ? $GLOBALS['3dp_last_bg'] : '';
$pt_class = ($prev_bg && $prev_bg === $bg_color) ? 'pt-0' : 'pt-16 lg:pt-24';
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

// Alpine Config
$alpine_data = sprintf( '{ activeIndex: %d }', esc_attr( $highlight_idx ) );

?>

<section <?php echo $id_attr; ?> class="<?php echo esc_attr( $classes ); ?>" style="background-color: <?php echo esc_attr($bg_color); ?>;" x-data="<?php echo esc_attr( $alpine_data ); ?>">
    <div class="max-w-[1280px] mx-auto px-6 lg:px-[64px]">
        
        <?php if ( $title ) : ?>
        <div class="mb-12 flex justify-between items-end">
            <div>
                <h2 class="text-[36px] font-bold text-heading tracking-[-1.5px] mb-2 uppercase">
                    <?php echo esc_html( $title ); ?>
                </h2>
                <p class="text-body text-sm font-medium opacity-80">
                    <?php echo esc_html( $description ? $description : __( 'Precision Display: Uniform borders and dual-tone matrix.', '3d-printing' ) ); ?>
                </p>
            </div>
            <div class="hidden md:block border-2 border-primary/20 rounded-md px-3 py-1 rotate-12">
                <span class="text-[10px] font-mono font-bold text-primary/40 uppercase tracking-widest"><?php esc_html_e( 'NOW3DP Verified', '3d-printing' ); ?></span>
            </div>
        </div>
        <?php endif; ?>

        <div class="bg-white rounded-xl border border-border shadow-sm p-[3px] overflow-hidden">
            <div class="overflow-x-auto no-scrollbar">
                <table class="w-full text-left border-separate border-spacing-0 min-w-[1000px]">
                    <thead>
                        <tr class="bg-bg-table text-heading uppercase tracking-[2px] text-[11px] font-bold">
                            <?php 
                            $col_count = count( $valid_cols );
                            foreach ( $valid_cols as $index => $key ) : 
                                $is_first = $index === 0;
                                $is_last  = $index === ( $col_count - 1 );
                                $is_even  = ( $index + 1 ) % 2 === 0;
                                
                                // Header Styles
                                $th_class = $th_padding . ' border-b border-border';
                                if ( $is_first ) $th_class .= ' rounded-tl-lg';
                                if ( $is_last )  $th_class .= ' rounded-tr-lg';
                                if ( $is_even )  $th_class .= ' bg-bg-table/60';
                                ?>
                                <th class="<?php echo esc_attr( $th_class ); ?>">
                                    <?php echo esc_html( $headers[ $key ] ); ?>
                                </th>
                            <?php endforeach; ?>
                        </tr>
                    </thead>
                    
                    <tbody class="<?php echo esc_attr( $text_size ); ?>">
                        <?php 
                        foreach ( $rows as $row_idx => $row ) : 
                            // Alpine index matches loop index (1-based)
                            $current_idx = $row_idx + 1;
                            
                            // Row Logic hooks
                            // lock-row styles mapped to Tailwind arbitrary values
                            // relative z-10 after:absolute after:inset-0 after:border-[3px] after:border-primary after:rounded-xl after:pointer-events-none after:z-30 after:shadow-[0_12px_30px_-10px_rgba(0,71,171,0.3)]
                            $lock_row_cls = 'relative z-10 after:content-[\'\'] after:absolute after:inset-0 after:border-[3px] after:border-primary after:rounded-xl after:pointer-events-none after:z-30 after:shadow-[0_12px_30px_-10px_rgba(0,71,171,0.3)]';
                            ?>
                            <tr @click="activeIndex = <?php echo $current_idx; ?>"
                                :class="activeIndex === <?php echo $current_idx; ?> ? '<?php echo $lock_row_cls; ?>' : 'hover:bg-bg-table/40 cursor-pointer'"
                                class="transition-all duration-150 group">
                                
                                <?php 
                                foreach ( $valid_cols as $col_idx => $key ) : 
                                    // Map h1->v1, h2->v2...
                                    $val_key = str_replace( 'h', 'v', $key );
                                    $value   = isset( $row[ $val_key ] ) ? $row[ $val_key ] : '';
                                    
                                    $is_first_col = $col_idx === 0;
                                    $is_last_col  = $col_idx === ( $col_count - 1 );
                                    $is_even_col  = ( $col_idx + 1 ) % 2 === 0;
                                    
                                    // Cell Base Classes
                                    $td_base = $td_padding . ' border-b border-border transition-colors ' . ( $use_mono && ! $is_first_col ? 'font-mono' : '' );
                                    
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
                                    if ( $is_first_col ) $extra_active = 'rounded-l-xl';
                                    if ( $is_last_col )  $extra_active = 'rounded-r-xl';
                                    
                                    // Special: Lock row hides border bottom? Design says: .lock-row td { border-bottom-color: transparent !important; }
                                    // We can add border-transparent to active state
                                    $border_active = 'border-transparent';
                                    
                                    // Construct the Alpine ternary strings
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
        </div>
    </div>
</section>

<?php
// End of file
?>
