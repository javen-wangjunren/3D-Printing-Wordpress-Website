<?php
/**
 * Capability Design Guide Block Template
 *
 * @package 3D_Printing
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// Prefix Support
$pfx = isset($block['prefix']) ? $block['prefix'] : '';
$block = isset( $block ) ? $block : array();
$block_id = _3dp_get_safe_block_id( $block, 'capability-design-guide' );

$block_class = isset( $block['className'] ) ? $block['className'] : '';

// 万能取数逻辑
// 确定克隆名
$clone_name = rtrim($pfx, '_');

// 使用万能取数逻辑获取字段值
$section_title = get_field_value('capability_design_guide_title', $block, $clone_name, $pfx, '' );

$core_specs = get_field_value('capability_design_guide_core_specs', $block, $clone_name, $pfx, array() );
$tech_list  = get_field_value('capability_design_guide_tech_list', $block, $clone_name, $pfx, array() );
$advice     = get_field_value('capability_design_guide_advice_group', $block, $clone_name, $pfx, array() );

if ( ! $section_title && ! $core_specs && ! $tech_list && ! $advice ) {
    return;
}

$mb_mode        = get_field_value('capability_design_guide_mb_mode', $block, $clone_name, $pfx, 'grid' );
$hide_advice_mb = (bool) get_field_value('capability_design_guide_hide_advice_mb', $block, $clone_name, $pfx, false );

$grid_cols_class = 'grid-cols-2 lg:grid-cols-4';

if ( $mb_mode === 'stack' ) {
    $grid_cols_class = 'grid-cols-1 sm:grid-cols-2 lg:grid-cols-4';
}

$advice_title = isset( $advice['title'] ) ? $advice['title'] : '';
$advice_text  = isset( $advice['text'] ) ? $advice['text'] : '';

// Visual Mapping & Layout Logic
$bg_color = get_field_value('background_color', $block, $clone_name, $pfx, '#ffffff');

// Dynamic Spacing Logic
$prev_bg  = isset( $GLOBALS['3dp_last_bg'] ) ? $GLOBALS['3dp_last_bg'] : '';
$section_spacing = ( $bg_color === $prev_bg ) ? 'pt-0 pb-16 lg:pb-24' : 'py-16 lg:py-24';

// Update Global State
$GLOBALS['3dp_last_bg'] = $bg_color;

?>

<section id="<?php echo $block_id ? esc_attr( $block_id ) : ''; ?>" class="w-full <?php echo esc_attr( $section_spacing ); ?>" style="background-color: <?php echo esc_attr($bg_color); ?>;">
    <div class="max-w-container mx-auto px-5 lg:px-8 <?php echo esc_attr( $block_class ); ?>">
        <?php if ( $section_title ) : ?>
            <div class="mb-8 lg:mb-12">
                <h2 class="text-h2 font-semibold text-heading tracking-tight mb-3">
                    <?php echo esc_html( $section_title ); ?>
                </h2>
                <div class="h-1 w-12 bg-primary rounded-full"></div>
            </div>
        <?php endif; ?>

        <?php if ( $core_specs ) : ?>
            <div class="grid <?php echo esc_attr( $grid_cols_class ); ?> gap-3 lg:gap-6 mb-8 lg:mb-12">
                <?php foreach ( $core_specs as $item ) : ?>
                    <?php
                    $label = isset( $item['label'] ) ? $item['label'] : '';
                    $value = isset( $item['value'] ) ? $item['value'] : '';
                    $unit  = isset( $item['unit'] ) ? $item['unit'] : '';

                    if ( ! $label && ! $value && ! $unit ) {
                        continue;
                    }
                    ?>
                    <div class="bg-bg-section border border-border p-3 lg:p-6 rounded-card relative overflow-hidden group">
                        <div class="absolute left-0 top-0 bottom-0 w-1 bg-primary/15 group-hover:bg-primary transition-colors"></div>
                        <?php if ( $label ) : ?>
                            <div class="text-[11px] font-bold text-muted uppercase tracking-[0.18em] mb-2">
                                <?php echo esc_html( $label ); ?>
                            </div>
                        <?php endif; ?>
                        <div class="font-mono text-[18px] lg:text-[20px] font-bold text-heading flex items-baseline gap-1">
                            <?php if ( $value ) : ?>
                                <span><?php echo esc_html( $value ); ?></span>
                            <?php endif; ?>
                            <?php if ( $unit ) : ?>
                                <span class="text-[11px] lg:text-[13px] font-medium text-muted">
                                    <?php echo esc_html( $unit ); ?>
                                </span>
                            <?php endif; ?>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>

        <?php if ( $tech_list ) : ?>
            <div class="border border-border rounded-card overflow-hidden mb-6 lg:mb-10 shadow-sm">
                <?php foreach ( $tech_list as $index => $row ) : ?>
                    <?php
                    $label = isset( $row['label'] ) ? $row['label'] : '';
                    $value = isset( $row['value'] ) ? $row['value'] : '';

                    if ( ! $label && ! $value ) {
                        continue;
                    }

                    $row_bg = $index % 2 === 0 ? 'bg-white' : 'bg-bg-section/40';
                    ?>
                    <div class="border-b border-border last:border-b-0 <?php echo esc_attr( $row_bg ); ?>">
                        <div class="flex md:grid md:grid-cols-[minmax(0,220px)_1fr]">
                            <div class="px-4 py-3 md:p-5 flex items-center text-[12px] font-bold text-heading uppercase tracking-[0.12em] border-r border-border min-w-[140px] md:min-w-0">
                                <?php echo esc_html( $label ); ?>
                            </div>
                            <div class="px-4 py-3 md:p-5 flex items-center text-sm text-body leading-relaxed">
                                <?php echo esc_html( $value ); ?>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>

        <?php if ( $advice_title || $advice_text ) : ?>
            <div class="<?php echo $hide_advice_mb ? 'hidden lg:flex' : 'flex'; ?> bg-blue-50/50 border border-blue-100 rounded-card p-4 lg:p-6 gap-4 items-start">
                <div class="shrink-0 w-8 h-8 rounded-full bg-blue-100 flex items-center justify-center text-primary">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                </div>
                <div>
                    <?php if ( $advice_title ) : ?>
                        <h4 class="font-bold text-heading text-sm mb-1"><?php echo esc_html( $advice_title ); ?></h4>
                    <?php endif; ?>
                    <?php if ( $advice_text ) : ?>
                        <p class="text-sm text-body/80 leading-relaxed"><?php echo esc_html( wp_strip_all_tags( $advice_text ) ); ?></p>
                    <?php endif; ?>
                </div>
            </div>
        <?php endif; ?>

    </div>
</section>
