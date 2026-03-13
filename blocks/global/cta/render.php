<?php
/**
 * Block: Call to Action (CTA)
 * Path: blocks/global/cta/render.php
 * ==========================================================================
 * 文件作用:
 * 渲染全站通用的 CTA (行动号召) 模块。通常位于页面底部，包含标题、高亮文字、
 * 主按钮以及信任背书（Metrics/Certifications）。
 *
 * 核心逻辑 (Dual-Mode Rendering):
 * 1. 自动判断模式: 根据是否传入 `prefix` 参数来决定数据源。
 * 2. 全局模式 (Global Mode): 若无 `prefix`，从 Options Page 读取全局默认数据。
 * 3. 局部模式 (Local Mode): 若有 `prefix`，从当前 Post/Page 读取特定数据。
 *
 * 架构角色:
 * [Smart Renderer]
 * 这是一个 "智能渲染器"，它解耦了数据源和视图。
 * 只要数据结构（Schema）一致，它可以渲染来自任何地方（Global Options 或 Post Meta）的数据。
 *
 * 🚨 避坑指南:
 * 1. 字段名一致性: Local 字段和 Global Clone 字段的子字段名必须完全一致。
 * 2. 数据回退: 目前逻辑是"非此即彼"。如果未来需要"局部为空则回退到全局"，需要修改逻辑。
 * ==========================================================================
 * 
 * @package 3D_Printing
 * @author Javen
 */

// ==========================================================================
// I. 初始化与上下文 (Initialization)
// ==========================================================================
$block    = isset( $block ) ? $block : array();
$block_id = _3dp_get_safe_block_id( $block, 'cta' );
$pfx      = isset($block['prefix']) ? $block['prefix'] : '';
$clone_name = rtrim($pfx, '_'); // 用于万能取数函数的 clone key

// 初始化默认值
$data = array(
    'title'           => '',
    'title_highlight' => '',
    'button_group'    => array(),
    'metrics'         => array(),
    'bg_color'        => '#F2F4F7'
);

// ==========================================================================
// II. 数据获取策略 (Data Fetching Strategy)
// ==========================================================================

if ( empty( $pfx ) ) {
    /**
     * [策略 A] 全局模式 (Global Mode)
     * 场景: 首页、About页等通用位置
     * 动作: 从 Options Page 读取 'global_cta' 组数据
     */
    $global_raw = get_field('global_cta', 'option');
    
    if ( $global_raw ) {
        $cta_data = ( isset( $global_raw['cta_clone'] ) && is_array( $global_raw['cta_clone'] ) ) ? $global_raw['cta_clone'] : $global_raw;
        // 映射 Global 数据到标准结构
        // 注意: 这里的键名必须与 inc/options-page.php 中定义的结构一致
        $data['title']           = isset($cta_data['cta_title']) ? $cta_data['cta_title'] : '';
        $data['title_highlight'] = isset($cta_data['cta_title_highlight']) ? $cta_data['cta_title_highlight'] : '';
        $data['button_group']    = isset($cta_data['cta_button_group']) ? $cta_data['cta_button_group'] : array();
        $data['metrics']         = isset($cta_data['cta_metrics']) ? $cta_data['cta_metrics'] : array();
        $data['bg_color']        = isset($cta_data['bg_color']) ? $cta_data['bg_color'] : '#F2F4F7';
    } else {
        // Fallback: legacy flat fields (before group wrapper was added)
        $data['title']           = get_field( 'cta_title', 'option' ) ?: $data['title'];
        $data['title_highlight'] = get_field( 'cta_title_highlight', 'option' ) ?: $data['title_highlight'];
        $buttons_flat            = get_field( 'cta_button_group', 'option' );
        $data['button_group']    = is_array( $buttons_flat ) ? $buttons_flat : $data['button_group'];
        $metrics_flat            = get_field( 'cta_metrics', 'option' );
        $data['metrics']         = is_array( $metrics_flat ) ? $metrics_flat : $data['metrics'];
        $data['bg_color']        = get_field( 'cta_bg_color', 'option' ) ?: $data['bg_color'];
    }
} else {
    /**
     * [策略 B] 局部模式 (Local Mode)
     * 场景: 特定的着陆页或服务页，需要定制 CTA
     * 动作: 使用 get_field_value 辅助函数从当前 Post 读取带前缀的字段
     */
    $data['title']           = (string) get_field_value('cta_title', $block, $clone_name, $pfx, '');
    $data['title_highlight'] = (string) get_field_value('cta_title_highlight', $block, $clone_name, $pfx, '');
    $data['button_group']    = get_field_value('cta_button_group', $block, $clone_name, $pfx, array());
    $data['metrics']         = get_field_value('cta_metrics', $block, $clone_name, $pfx, array());
    $data['bg_color']        = get_field_value('bg_color', $block, $clone_name, $pfx, '#F2F4F7');
}

// ==========================================================================
// III. 数据处理与验证 (Processing & Validation)
// ==========================================================================

// 解析按钮数据
$btn_text    = isset( $data['button_group']['button_text'] ) ? $data['button_group']['button_text'] : '';
$btn_link_id = isset( $data['button_group']['button_link'] ) ? $data['button_group']['button_link'] : 0;
$btn_url     = $btn_link_id ? get_permalink($btn_link_id) : '';
$has_button  = $btn_text && $btn_url;

// 卫语句: 如果没有标题且没有按钮，则不渲染任何内容
if ( ! $data['title'] && ! $has_button ) {
    return;
}

// 动态间距逻辑 (Smart Spacing)
// 如果当前背景色与上一个模块相同，移除顶部内边距，实现视觉融合
$prev_bg  = isset($GLOBALS['3dp_last_bg']) ? $GLOBALS['3dp_last_bg'] : '';
$pt_class = ($prev_bg && $prev_bg === $data['bg_color']) ? 'pt-0' : 'pt-16 lg:pt-24';
$pb_class = 'pb-16 lg:pb-24';

// ==========================================================================
// IV. 视图渲染 (View Rendering)
// ==========================================================================
?>

<section id="<?php echo esc_attr( $block_id ); ?>" 
         class="cta-block w-full relative <?php echo esc_attr( $pt_class . ' ' . $pb_class ); ?>" 
         style="background-color: <?php echo esc_attr( $data['bg_color'] ); ?>">
         
    <div class="max-w-container mx-auto px-container text-center">
        
        <!-- 1. Heading -->
        <?php if ( $data['title'] ) : ?>
            <h2 class="text-heading text-[42px] md:text-[64px] font-[800] leading-[1.1] mb-12 tracking-[-1.5px]">
                <?php echo esc_html( $data['title'] ); ?>
                <?php if ( $data['title_highlight'] ) : ?>
                    <br><span class="text-primary"><?php echo esc_html( $data['title_highlight'] ); ?></span>
                <?php endif; ?>
            </h2>
        <?php endif; ?>
        
        <!-- 2. Primary Button -->
        <?php if ( $has_button ) : ?>
            <div class="flex flex-col sm:flex-row justify-center items-center gap-6 mt-12 mb-24">
                <a href="<?php echo esc_url( $btn_url ); ?>" 
                   class="group relative inline-flex items-center justify-center px-10 py-5 bg-primary text-white font-bold rounded-xl shadow-lg shadow-primary/20 transition-all hover:-translate-y-1 hover:shadow-xl overflow-hidden whitespace-nowrap">
                    <span class="relative z-10 tracking-[1px] text-[16px]"><?php echo esc_html( $btn_text ); ?></span>
                    <div class="absolute inset-0 bg-[#003A8C] translate-y-full group-hover:translate-y-0 transition-transform duration-300"></div>
                </a>
            </div>
        <?php endif; ?>

        <!-- 3. Metrics / Certifications -->
        <?php if ( ! empty( $data['metrics'] ) ) : ?>
            <div class="mt-24 pt-10 border-t border-[#E4E7EC] flex flex-wrap justify-center items-center gap-x-12 gap-y-6">
                <?php foreach ( $data['metrics'] as $metric ) : 
                    $label = isset( $metric['label'] ) ? $metric['label'] : '';
                    $subtitle = isset( $metric['subtitle'] ) ? $metric['subtitle'] : '';
                    if ( ! $label ) continue;
                ?>
                    <div class="flex flex-col items-center gap-1">
                        <span class="font-mono text-[13px] font-bold text-[#1D2938]"><?php echo esc_html( $label ); ?></span>
                        <?php if ( $subtitle ) : ?>
                            <span class="text-[10px] text-[#667085] uppercase tracking-widest"><?php echo esc_html( $subtitle ); ?></span>
                        <?php endif; ?>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>

    </div>
</section>

<?php
// 更新全局状态，供下一个 Block 判断间距
$GLOBALS['3dp_last_bg'] = $data['bg_color'];
?>
