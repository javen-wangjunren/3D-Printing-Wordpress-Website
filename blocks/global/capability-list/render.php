<?php
/**
 * Capability List Block 渲染模板（Tailwind + Alpine 版本）
 *
 * 设计映射：
 * - 模块外层：bg/bg-section + py-section-y-small/lg:py-section-y，统一模块呼吸感
 * - 标题排版：text-h2 + text-heading，正文 text-body + text-body 颜色
 * - 工艺参数：font-mono 强调工业数据感，边界使用 border-border、primary/20
 * - 卡片与按钮：rounded-card / rounded-button，对应 12px / 8px 圆角规范
 */
// Prefix Support
$pfx = isset($block['prefix']) ? $block['prefix'] : '';


$block = isset( $block ) ? $block : array();
$block_id = _3dp_get_safe_block_id( $block, 'capability-list' );
$section_title       = (string) ( get_field($pfx . 'section_title' ) ?: 'Manufacturing Capabilities' );
$section_description = (string) ( get_field($pfx . 'section_description' ) ?: 'Six industrial technologies optimized for prototyping and scalable production.' );
$capabilities        = get_field($pfx . 'capabilities' ) ?: array();
$bg_color            = (string) ( get_field($pfx . 'cl_bg_color' ) ?: '#ffffff' );
$accent_color        = (string) ( get_field($pfx . 'cl_accent_color' ) ?: '#0047AB' );
$anchor_raw          = (string) ( get_field($pfx . 'cl_anchor_id' ) ?: '' );

if ( empty( $capabilities ) ) {
    return;
}

// 默认激活第一个工艺的 ID（Alpine activeTab 初始值）
$first_capability_id = '';
foreach ( $capabilities as $capability ) {
    if ( ! empty( $capability['capability_id'] ) ) {
        $first_capability_id = (string) $capability['capability_id'];
        break;
    }
}

if ( ! $first_capability_id && ! empty( $capabilities[0]['capability_id'] ) ) {
    $first_capability_id = (string) $capabilities[0]['capability_id'];
}

$anchor_id   = $anchor_raw ? 'id="' . esc_attr( $anchor_raw ) . '"' : '';
$bg_classes  = 'bg-white';
$bg_style    = '';

// 简单映射：如果是浅灰背景，使用设计系统 bg-bg-section；否则按自定义色做 inline 背景
if ( strtolower( $bg_color ) === '#f2f4f7' ) {
    $bg_classes = 'bg-bg-section';
} elseif ( strtolower( $bg_color ) !== '#ffffff' && strtolower( $bg_color ) !== '#fff' ) {
    $bg_style = 'style="background-color: ' . esc_attr( $bg_color ) . '"';
}
?>

<div <?php echo $anchor_id; ?> class="capability-list-block <?php echo esc_attr( $bg_classes ); ?>" <?php echo $bg_style; ?>
     x-data="{ activeTab: '<?php echo esc_attr( $first_capability_id ); ?>' }">
    <div class="mx-auto max-w-container px-container py-section-y-small lg:py-section-y">
        <div class="text-center mb-10 lg:mb-16">
            <h2 class="text-h2 text-heading tracking-[-0.02em] mb-4">
                <?php echo esc_html( $section_title ); ?>
            </h2>
            <?php if ( $section_description ) : ?>
                <p class="mx-auto max-w-2xl text-body">
                    <?php echo esc_html( $section_description ); ?>
                </p>
            <?php endif; ?>
        </div>

        <div class="flex justify-start lg:justify-center gap-2 mb-10 lg:mb-16 overflow-x-auto no-scrollbar pb-4 -mx-container px-container lg:mx-0 lg:px-0">
            <?php foreach ( $capabilities as $capability ) : ?>
                <?php
                $capability_id    = isset( $capability['capability_id'] ) ? (string) $capability['capability_id'] : '';
                $capability_name  = isset( $capability['name'] ) ? (string) $capability['name'] : '';
                $capability_short = isset( $capability['short_name'] ) ? (string) $capability['short_name'] : '';

                if ( ! $capability_id || ! $capability_name ) {
                    continue;
                }

                $tab_label = $capability_name . ( $capability_short ? ' (' . $capability_short . ')' : '' );
                ?>
                <button
                    type="button"
                    @click="activeTab = '<?php echo esc_attr( $capability_id ); ?>'"
                    :class="activeTab === '<?php echo esc_attr( $capability_id ); ?>' ? 'bg-primary text-inverse shadow-lg shadow-primary/20 border-primary' : 'bg-bg-section text-body hover:bg-border border-transparent'"
                    class="px-6 lg:px-8 py-2.5 lg:py-3 rounded-full text-[11px] lg:text-[12px] font-bold uppercase tracking-[0.14em] whitespace-nowrap border shrink-0 transition-all duration-300"
                    data-capability-id="<?php echo esc_attr( $capability_id ); ?>">
                    <?php echo esc_html( $tab_label ); ?>
                </button>
            <?php endforeach; ?>
        </div>

        <div class="grid lg:grid-cols-[1.2fr_1fr] gap-8 lg:gap-16 items-stretch">
            <div class="order-1 lg:order-2 relative aspect-[4/3] lg:aspect-auto lg:min-h-0">
                <div class="h-full rounded-card bg-bg-section border border-border overflow-hidden flex items-center justify-center p-6 lg:p-10 group transition-all duration-500">
                    <?php foreach ( $capabilities as $capability ) : ?>
                        <?php
                        $capability_id   = isset( $capability['capability_id'] ) ? (string) $capability['capability_id'] : '';
                        $capability_name = isset( $capability['name'] ) ? (string) $capability['name'] : '';
                        $capability_img  = isset( $capability['image'] ) ? $capability['image'] : '';
                        $equipment       = isset( $capability['equipment'] ) ? (string) $capability['equipment'] : '';

                        if ( ! $capability_id || ! $capability_name ) {
                            continue;
                        }
                        ?>
                        <div x-show="activeTab === '<?php echo esc_attr( $capability_id ); ?>'" x-transition.opacity.duration.300ms class="w-full h-full relative">
                            <?php if ( $capability_img ) : ?>
                                <?php echo wp_get_attachment_image( $capability_img, 'large', false, array( 'alt' => esc_attr( $capability_name ), 'class' => 'max-w-full max-h-full object-contain mix-blend-multiply mx-auto' ) ); ?>
                            <?php else : ?>
                                <div class="flex h-full items-center justify-center text-heading text-small font-semibold">
                                    <?php echo esc_html( $capability_name ); ?>
                                </div>
                            <?php endif; ?>

                            <?php if ( $equipment ) : ?>
                                <div class="absolute bottom-4 right-4 lg:bottom-6 lg:right-6 bg-white/90 backdrop-blur shadow-xl border border-border px-3 py-1.5 lg:px-4 lg:py-2 rounded-md">
                                    <span class="text-[9px] lg:text-[11px] font-mono font-bold text-heading uppercase tracking-tight">
                                        <?php echo esc_html( 'EQUIPMENT: ' . $equipment ); ?>
                                    </span>
                                </div>
                            <?php endif; ?>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>

            <div class="order-2 lg:order-1 flex flex-col">
                <div x-show="activeTab" x-transition.opacity.duration.300ms class="flex flex-col h-full pt-4 lg:pt-0">
                    <?php foreach ( $capabilities as $capability ) : ?>
                        <?php
                        $capability_id      = isset( $capability['capability_id'] ) ? (string) $capability['capability_id'] : '';
                        $capability_name    = isset( $capability['name'] ) ? (string) $capability['name'] : '';
                        $capability_desc    = isset( $capability['description'] ) ? (string) $capability['description'] : '';
                        $capability_specs   = isset( $capability['specs'] ) && is_array( $capability['specs'] ) ? $capability['specs'] : array();
                        $capability_materials = isset( $capability['materials'] ) && is_array( $capability['materials'] ) ? $capability['materials'] : array();
                        $capability_quote   = isset( $capability['quote_link'] ) && is_array( $capability['quote_link'] ) ? $capability['quote_link'] : array();
                        $capability_detail  = isset( $capability['detail_link'] ) && is_array( $capability['detail_link'] ) ? $capability['detail_link'] : array();

                        if ( ! $capability_id || ! $capability_name ) {
                            continue;
                        }
                        ?>

                        <div x-show="activeTab === '<?php echo esc_attr( $capability_id ); ?>'" x-transition.opacity.duration.300ms class="flex flex-col h-full">
                            <div class="mb-8">
                                <h3 class="text-h3 text-heading mb-4 leading-tight">
                                    <?php echo esc_html( $capability_name ); ?>
                                </h3>
                                <?php if ( $capability_desc ) : ?>
                                    <p class="text-body text-small lg:text-body leading-relaxed mb-6">
                                        <?php echo esc_html( $capability_desc ); ?>
                                    </p>
                                <?php endif; ?>
                            </div>

                            <?php
                            $has_build   = ! empty( $capability_specs['build_volume'] );
                            $has_layer   = ! empty( $capability_specs['layer_height'] );
                            $has_tol     = ! empty( $capability_specs['tolerance'] );
                            $has_lead    = ! empty( $capability_specs['lead_time'] );
                            $has_specs   = $has_build || $has_layer || $has_tol || $has_lead;
                            ?>

                            <?php if ( $has_specs ) : ?>
                                <div class="grid grid-cols-2 gap-y-6 lg:gap-y-8 gap-x-6 lg:gap-x-12 py-6 lg:py-8 border-y border-border mb-8">
                                    <?php if ( $has_build ) : ?>
                                        <div class="border-l-2 border-primary/20 pl-4">
                                            <span class="block text-[10px] font-bold text-muted uppercase tracking-[0.1em] mb-1.5">Build Volume</span>
                                            <span class="font-mono text-[14px] lg:text-[18px] font-bold text-heading leading-none">
                                                <?php echo esc_html( (string) $capability_specs['build_volume'] ); ?>
                                            </span>
                                        </div>
                                    <?php endif; ?>

                                    <?php if ( $has_layer ) : ?>
                                        <div class="border-l-2 border-primary/20 pl-4">
                                            <span class="block text-[10px] font-bold text-muted uppercase tracking-[0.1em] mb-1.5">Layer Height</span>
                                            <span class="font-mono text-[14px] lg:text-[18px] font-bold text-heading leading-none">
                                                <?php echo esc_html( (string) $capability_specs['layer_height'] ); ?>
                                            </span>
                                        </div>
                                    <?php endif; ?>

                                    <?php if ( $has_tol ) : ?>
                                        <div class="border-l-2 border-primary/20 pl-4">
                                            <span class="block text-[10px] font-bold text-muted uppercase tracking-[0.1em] mb-1.5">Tolerance</span>
                                            <span class="font-mono text-[14px] lg:text-[18px] font-bold text-heading leading-none">
                                                <?php echo esc_html( (string) $capability_specs['tolerance'] ); ?>
                                            </span>
                                        </div>
                                    <?php endif; ?>

                                    <?php if ( $has_lead ) : ?>
                                        <div class="border-l-2 border-primary/20 pl-4">
                                            <span class="block text-[10px] font-bold text-muted uppercase tracking-[0.1em] mb-1.5">Lead Time</span>
                                            <span class="font-mono text-[14px] lg:text-[18px] font-bold text-heading leading-none">
                                                <?php echo esc_html( (string) $capability_specs['lead_time'] ); ?>
                                            </span>
                                        </div>
                                    <?php endif; ?>
                                </div>
                            <?php endif; ?>

                            <?php if ( $capability_materials ) : ?>
                                <div class="mb-8">
                                    <h4 class="text-[11px] font-bold text-muted uppercase tracking-[0.12em] mb-4">Available Materials</h4>
                                    <div class="flex flex-wrap gap-2">
                                        <?php foreach ( $capability_materials as $material ) : ?>
                                            <?php if ( is_object( $material ) && isset( $material->ID ) ) : ?>
                                                <a href="<?php echo esc_url( get_permalink( $material->ID ) ); ?>" class="bg-bg-section border border-border/60 px-3 py-1.5 rounded-md text-[11px] lg:text-[12px] font-semibold text-heading hover:bg-primary hover:text-inverse transition-colors">
                                                    <?php echo esc_html( get_the_title( $material->ID ) ); ?>
                                                </a>
                                            <?php endif; ?>
                                        <?php endforeach; ?>
                                    </div>
                                </div>
                            <?php endif; ?>

                            <div class="mt-auto pt-4 flex flex-col sm:flex-row gap-4">
                                <?php if ( ! empty( $capability_quote['url'] ) ) : ?>
                                    <a href="<?php echo esc_url( $capability_quote['url'] ); ?>"
                                       class="bg-primary hover:bg-primary-hover text-inverse px-8 py-4 rounded-button font-bold text-[13px] uppercase tracking-[0.14em] text-center transition-all shadow-md"
                                       style="background-color: <?php echo esc_attr( $accent_color ); ?>;"
                                       <?php if ( ! empty( $capability_quote['target'] ) ) : ?>target="<?php echo esc_attr( $capability_quote['target'] ); ?>"<?php endif; ?>>
                                        <?php echo esc_html( $capability_quote['title'] ?: 'Get Instant Quote' ); ?>
                                    </a>
                                <?php endif; ?>

                                <?php if ( ! empty( $capability_detail['url'] ) ) : ?>
                                    <a href="<?php echo esc_url( $capability_detail['url'] ); ?>"
                                       class="border border-border text-heading hover:border-primary px-8 py-4 rounded-button font-bold text-[13px] uppercase tracking-[0.14em] text-center transition-all"
                                       <?php if ( ! empty( $capability_detail['target'] ) ) : ?>target="<?php echo esc_attr( $capability_detail['target'] ); ?>"<?php endif; ?>>
                                        <?php echo esc_html( $capability_detail['title'] ?: 'Explore Details' ); ?>
                                    </a>
                                <?php endif; ?>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
    </div>
</div>
