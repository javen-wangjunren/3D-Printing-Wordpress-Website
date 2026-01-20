<?php


// Prefix Support
$pfx = isset($block['prefix']) ? $block['prefix'] : '';
$block = isset( $block ) ? $block : array();
$block_id = _3dp_get_safe_block_id( $block, 'capability-design-guide' );

$block_class = isset( $block['className'] ) ? $block['className'] : '';

$section_title = get_field($pfx . 'capability_design_guide_title' );

$core_specs = get_field($pfx . 'capability_design_guide_core_specs' ) ?: array();
$tech_list  = get_field($pfx . 'capability_design_guide_tech_list' ) ?: array();
$advice     = get_field($pfx . 'capability_design_guide_advice_group' ) ?: array();

if ( ! $section_title && ! $core_specs && ! $tech_list && ! $advice ) {
    return;
}

$mb_mode        = get_field($pfx . 'capability_design_guide_mb_mode' ) ?: 'grid';
$hide_advice_mb = (bool) get_field($pfx . 'capability_design_guide_hide_advice_mb' );

$grid_cols_class = 'grid-cols-2 lg:grid-cols-4';

if ( $mb_mode === 'stack' ) {
    $grid_cols_class = 'grid-cols-1 sm:grid-cols-2 lg:grid-cols-4';
}

$advice_title = isset( $advice['title'] ) ? $advice['title'] : '';
$advice_text  = isset( $advice['text'] ) ? $advice['text'] : '';

?>

<section id="<?php echo $block_id ? esc_attr( $block_id ) : ''; ?>" class="py-8 lg:py-16 bg-white">
    <div class="max-w-container mx-auto px-6 lg:px-[64px] <?php echo esc_attr( $block_class ); ?>">
        <?php if ( $section_title ) : ?>
            <div class="mb-8 lg:mb-12">
                <h2 class="text-h2 font-semibold text-heading tracking-[-0.04em] mb-3">
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
                            <div class="px-4 py-3 md:p-5 flex items-center text-[12px] font-bold text-heading uppercase tracking-[0.12em]">
                                <?php echo esc_html( $label ); ?>
                            </div>
                            <div class="px-4 py-3 md:p-5 flex items-center justify-end md:justify-start text-[13px] md:text-[14px] text-body md:font-mono">
                                <?php echo esc_html( $value ); ?>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>

        <?php if ( $advice_title || $advice_text ) : ?>
            <?php
            $advice_classes = 'flex flex-col gap-3 p-4 lg:p-6 bg-primary/[0.03] border-l-4 border-primary rounded-r-card';

            if ( $hide_advice_mb ) {
                $advice_classes = 'hidden md:flex flex-col gap-3 p-4 lg:p-6 bg-primary/[0.03] border-l-4 border-primary rounded-r-card';
            }
            ?>
            <div class="<?php echo esc_attr( $advice_classes ); ?>">
                <?php if ( $advice_title ) : ?>
                    <h4 class="text-[15px] lg:text-[16px] font-semibold text-heading">
                        <?php echo esc_html( $advice_title ); ?>
                    </h4>
                <?php endif; ?>
                <?php if ( $advice_text ) : ?>
                    <div class="text-[13px] lg:text-[14px] text-body leading-relaxed">
                        <?php echo wp_kses_post( $advice_text ); ?>
                    </div>
                <?php endif; ?>
            </div>
        <?php endif; ?>
    </div>
</section>
