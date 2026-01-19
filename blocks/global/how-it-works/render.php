<?php

$block = isset( $block ) ? $block : array();
$block_id = _3dp_get_safe_block_id( $block, 'how-it-works' );

$block_class = isset( $block['className'] ) ? $block['className'] : '';

$section_title = get_field( 'title' ) ?: '';
$section_desc  = get_field( 'desc' ) ?: '';

$steps_field = get_field( 'steps' );

if ( ! $steps_field || ! is_array( $steps_field ) || ! count( $steps_field ) ) {
    return;
}

$mb_hide_tip = (bool) get_field( 'mb_hide_tip' );
$mb_compact  = (bool) get_field( 'mb_compact_mode' );

$cta_label = get_field( 'cta_label' );
$cta_url   = get_field( 'cta_url' );

if ( ! $cta_label ) {
    $cta_label = 'Get Quote';
}

if ( ! $cta_url ) {
    $cta_url = '/quote';
}

$steps_state = array();

foreach ( $steps_field as $step ) {
    $step_title = isset( $step['title'] ) ? sanitize_text_field( $step['title'] ) : '';

    if ( ! $step_title ) {
        continue;
    }

    $qc_label  = isset( $step['qc_label'] ) ? sanitize_text_field( $step['qc_label'] ) : '';
    $step_desc = isset( $step['desc'] ) ? sanitize_textarea_field( $step['desc'] ) : '';

    $image_id   = isset( $step['image'] ) ? intval( $step['image'] ) : 0;
    $image_url  = $image_id ? esc_url_raw( wp_get_attachment_image_url( $image_id, 'large' ) ) : '';
    $image_alt  = $image_id ? get_post_meta( $image_id, '_wp_attachment_image_alt', true ) : '';
    $image_alt  = $image_alt ? sanitize_text_field( $image_alt ) : '';

    $specs = array();

    if ( ! empty( $step['data_grid'] ) && is_array( $step['data_grid'] ) ) {
        foreach ( $step['data_grid'] as $row ) {
            $label = isset( $row['label'] ) ? sanitize_text_field( $row['label'] ) : '';
            $value = isset( $row['value'] ) ? sanitize_text_field( $row['value'] ) : '';

            if ( ! $label && ! $value ) {
                continue;
            }

            $specs[] = array(
                'label' => $label,
                'value' => $value,
            );
        }
    }

    $tip_raw = isset( $step['pro_tip'] ) ? $step['pro_tip'] : '';
    $tip     = $tip_raw ? wp_kses_post( $tip_raw ) : '';

    $steps_state[] = array(
        'qc_label' => $qc_label,
        'title'    => $step_title,
        'desc'     => $step_desc,
        'image'    => $image_url,
        'image_alt'=> $image_alt,
        'specs'    => $specs,
        'tip'      => $tip,
    );
}

if ( ! count( $steps_state ) ) {
    return;
}

$total_steps = count( $steps_state );

$state = array(
    'steps'     => $steps_state,
    'current'   => 0,
    'total'     => $total_steps,
    'ctaUrl'    => esc_url_raw( $cta_url ),
    'ctaLabel'  => sanitize_text_field( $cta_label ),
    'mbHideTip' => $mb_hide_tip,
    'mbCompact' => $mb_compact,
);

?>

<section id="<?php echo esc_attr( $block_id ); ?>" class="py-16 lg:py-24 bg-bg-section/50">
    <div class="max-w-container mx-auto px-6 lg:px-[64px]">
        <div class="text-center mb-8 lg:mb-12">
            <?php if ( $section_title ) : ?>
                <h2 class="text-h2 font-semibold text-heading tracking-[-0.04em] mb-2 uppercase">
                    <?php echo esc_html( $section_title ); ?>
                </h2>
            <?php endif; ?>

            <?php if ( $section_desc ) : ?>
                <p class="text-body text-sm lg:text-base max-w-2xl mx-auto italic text-body/80">
                    <?php echo esc_html( $section_desc ); ?>
                </p>
            <?php endif; ?>
        </div>

        <div
            x-data='<?php echo wp_json_encode( $state ); ?>'
            class="bg-white rounded-card border border-border shadow-lg overflow-hidden grid lg:grid-cols-[1fr_1.1fr] items-stretch <?php echo esc_attr( $block_class ); ?>"
        >
            <div class="relative bg-bg-dark aspect-video lg:aspect-auto lg:min-h-0 overflow-hidden">
                <template x-if="steps[current].image">
                    <img
                        :src="steps[current].image"
                        :alt="steps[current].image_alt"
                        class="w-full h-full object-cover opacity-90 transition-opacity duration-700"
                    />
                </template>

                <div class="absolute inset-0 bg-gradient-to-t from-black/60 via-black/30 to-transparent"></div>

                <div class="absolute top-4 left-4 bg-primary text-white px-3 py-1.5 rounded-md shadow-lg z-10">
                    <span
                        class="text-[11px] font-mono font-bold uppercase tracking-[0.16em]"
                        x-text="'Step ' + String(current + 1).padStart(2, '0')"
                    ></span>
                </div>
            </div>

            <div class="p-6 lg:p-10 flex flex-col justify-between">
                <div>
                    <div class="flex justify-between items-end mb-2">
                        <span
                            class="text-[10px] font-mono font-bold text-muted uppercase tracking-[0.16em]"
                            x-text="'Step ' + (current + 1) + ' of ' + total"
                        ></span>
                    </div>

                    <div class="flex gap-1.5 mb-8 lg:mb-10">
                        <template x-for="(step, index) in steps" :key="index">
                            <div class="h-1 flex-1 bg-border rounded-full overflow-hidden">
                                <div
                                    class="h-full bg-primary transition-all duration-500"
                                    :class="current >= index ? 'w-full' : 'w-0'"
                                ></div>
                            </div>
                        </template>
                    </div>

                    <div class="mb-6 lg:mb-8">
                        <div
                            class="inline-flex items-center gap-2 text-[10px] font-bold text-primary uppercase tracking-[0.16em] mb-3 px-2 py-0.5 bg-primary/5 rounded-md"
                            x-show="steps[current].qc_label"
                        >
                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-width="3" d="M5 13l4 4L19 7" />
                            </svg>
                            <span x-text="steps[current].qc_label"></span>
                        </div>

                        <h3
                            class="text-h3 font-semibold text-heading leading-tight mb-4"
                            x-text="steps[current].title"
                        ></h3>

                        <p
                            class="text-body text-[14px] lg:text-[15px] leading-relaxed mb-6"
                            x-text="steps[current].desc"
                        ></p>
                    </div>

                    <div
                        class="grid grid-cols-2 gap-4 p-4 bg-bg-section border border-border rounded-card mb-6"
                        :class="mbCompact ? 'hidden lg:grid' : ''"
                        x-show="steps[current].specs && steps[current].specs.length"
                    >
                        <template x-for="(spec, index) in steps[current].specs" :key="index">
                            <div class="border-l-2 border-primary/20 pl-3">
                                <span
                                    class="block text-[9px] font-bold text-muted uppercase tracking-[0.16em] mb-1"
                                    x-text="spec.label"
                                ></span>
                                <span
                                    class="font-mono text-[16px] font-bold text-heading"
                                    x-text="spec.value"
                                ></span>
                            </div>
                        </template>
                    </div>

                    <div
                        class="flex gap-3 p-4 bg-primary/[0.03] border-l-4 border-primary rounded-r-md mb-6"
                        :class="(mbHideTip || mbCompact) ? 'hidden lg:flex' : 'flex'"
                        x-show="steps[current].tip"
                    >
                        <svg class="w-4 h-4 text-primary shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        <p
                            class="text-[13px] text-heading leading-snug"
                            x-html="steps[current].tip"
                        ></p>
                    </div>
                </div>

                <div class="flex gap-3 pt-6 border-t border-border/50">
                    <button
                        type="button"
                        class="flex-1 h-12 border border-border text-heading rounded-button font-bold text-[12px] uppercase tracking-[0.16em] hover:bg-bg-section transition-all disabled:opacity-30 disabled:cursor-not-allowed"
                        :disabled="current === 0"
                        @click="if (current > 0) current--"
                    >
                        Prev
                    </button>

                    <button
                        type="button"
                        class="flex-[1.5] h-12 bg-primary text-white rounded-button font-bold text-[12px] uppercase tracking-[0.16em] hover:bg-primary-hover transition-all flex items-center justify-center gap-2 group"
                        @click="if (current < total - 1) { current++; } else if (ctaUrl) { window.location.href = ctaUrl; }"
                    >
                        <span
                            x-text="current === total - 1 ? ctaLabel : 'Next Step'"
                        ></span>
                        <svg class="w-3.5 h-3.5 transition-transform group-hover:translate-x-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-width="2.5" d="M9 5l7 7-7 7" />
                        </svg>
                    </button>
                </div>
            </div>
        </div>
    </div>
</section>
