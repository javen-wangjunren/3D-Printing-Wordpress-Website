<?php

$anchor_field = get_field( 'material_list_anchor_id' );
$block_anchor = ! empty( $block['anchor'] ) ? $block['anchor'] : '';
$block_id     = $anchor_field ? $anchor_field : ( $block_anchor ? $block_anchor : ( isset( $block['id'] ) ? $block['id'] : '' ) );

$block_class = isset( $block['className'] ) ? $block['className'] : '';

$raw_processes = get_field( 'material_list_processes' ) ?: array();

if ( ! $raw_processes ) {
    return;
}

$display_single    = (bool) get_field( 'material_list_display_mode' );
$mobile_layout     = get_field( 'material_list_mobile_layout' ) ?: 'accordion';
$hide_image_mobile = (bool) get_field( 'material_list_hide_image_mobile' );
$bg_style          = get_field( 'material_list_bg_style' ) ?: 'bg-page';
$custom_class      = get_field( 'material_list_custom_class' ) ?: '';

if ( $display_single && $raw_processes ) {
    $raw_processes = array_slice( $raw_processes, 0, 1 );
}

$processes         = array();
$active_process    = '';
$first_material_id = '';

foreach ( $raw_processes as $process_row ) {
    $process_name = isset( $process_row['process_name'] ) ? (string) $process_row['process_name'] : '';
    $materials    = isset( $process_row['materials'] ) && is_array( $process_row['materials'] ) ? $process_row['materials'] : array();

    if ( ! $process_name || ! $materials ) {
        continue;
    }

    $first_slug = '';

    if ( $materials ) {
        $first_material = $materials[0];
        $first_name     = isset( $first_material['name'] ) ? (string) $first_material['name'] : '';

        if ( $first_name ) {
            $first_slug = strtolower( preg_replace( '/[^a-z0-9]+/', '-', strtolower( $first_name ) ) );
        }
    }

    if ( ! $active_process ) {
        $active_process    = $process_name;
        $first_material_id = $first_slug;
    }

    $processes[] = array(
        'name'          => $process_name,
        'materials'     => $materials,
        'first_mat_id'  => $first_slug,
    );
}

if ( ! $processes ) {
    return;
}

$bg_classes = $bg_style === 'bg-section' ? 'bg-bg-section' : 'bg-bg-page';

$alpine_state = array(
    'activeProcess'   => $active_process,
    'openMaterial'    => $first_material_id,
    'mobileLayout'    => $mobile_layout,
    'hideImageMobile' => (bool) $hide_image_mobile,
);

?>

<section id="<?php echo $block_id ? esc_attr( $block_id ) : ''; ?>" class="material-list-block <?php echo esc_attr( $bg_classes ); ?>" x-data='<?php echo json_encode( $alpine_state ); ?>'>
    <div class="mx-auto max-w-container px-container py-section-y-small lg:py-section-y <?php echo esc_attr( $block_class ); ?> <?php echo esc_attr( $custom_class ); ?>">
        <div class="mb-8 lg:mb-12">
            <h2 class="text-h2 font-semibold text-heading tracking-[-0.04em] mb-3">
                <?php echo esc_html( 'Explore ' ); ?><span class="text-primary"><?php echo esc_html( 'Manufacturing Materials' ); ?></span>
            </h2>
            <p class="text-body max-w-2xl text-small opacity-90 leading-snug">
                <?php echo esc_html( 'Compare engineering properties and lead times across our catalog to select the optimal solution for your project.' ); ?>
            </p>
        </div>

        <div class="flex flex-col lg:flex-row gap-6 items-start">
            <?php if ( ! $display_single && count( $processes ) > 1 ) : ?>
                <aside class="flex lg:flex-col gap-2 overflow-x-auto no-scrollbar pb-1 -mx-container px-container lg:mx-0 lg:px-0 lg:w-[150px] shrink-0 lg:border-r lg:border-border lg:pr-5 snap-x">
                    <?php foreach ( $processes as $process ) : ?>
                        <?php
                        $proc_name   = (string) $process['name'];
                        $first_mat   = isset( $process['first_mat_id'] ) ? (string) $process['first_mat_id'] : '';
                        ?>
                        <button
                            type="button"
                            @click='activeProcess = <?php echo json_encode( $proc_name ); ?>; openMaterial = <?php echo json_encode( $first_mat ); ?>'
                            :class='activeProcess === <?php echo json_encode( $proc_name ); ?> ? "bg-primary text-inverse shadow-md border-primary" : "bg-white text-body border-border hover:border-primary/50"'
                            class="whitespace-nowrap px-4 py-2.5 lg:w-full lg:text-left rounded-button border font-bold text-[11px] uppercase tracking-[0.14em] transition-all snap-start flex-shrink-0"
                        >
                            <?php echo esc_html( $proc_name ); ?>
                        </button>
                    <?php endforeach; ?>
                </aside>
            <?php endif; ?>

            <main class="flex-1 w-full">
                <div class="space-y-3">
                    <?php foreach ( $processes as $process ) : ?>
                        <?php
                        $proc_name = (string) $process['name'];
                        $materials = isset( $process['materials'] ) && is_array( $process['materials'] ) ? $process['materials'] : array();

                        if ( ! $materials ) {
                            continue;
                        }
                        ?>
                        <div x-show='activeProcess === <?php echo json_encode( $proc_name ); ?>' x-cloak>
                            <?php foreach ( $materials as $material ) : ?>
                                <?php
                                $mat_name        = isset( $material['name'] ) ? (string) $material['name'] : '';
                                $mat_badge       = isset( $material['badge'] ) ? (string) $material['badge'] : '';
                                $mat_image_id    = isset( $material['image'] ) ? $material['image'] : 0;
                                $mat_desc        = isset( $material['description'] ) ? $material['description'] : '';
                                $mat_specs       = isset( $material['spec_table'] ) && is_array( $material['spec_table'] ) ? $material['spec_table'] : array();
                                $quote_link      = isset( $material['quote_link'] ) ? $material['quote_link'] : array();
                                $specs_link      = isset( $material['specs_link'] ) ? $material['specs_link'] : array();
                                $material_id_key = '';

                                if ( $mat_name ) {
                                    $material_id_key = strtolower( preg_replace( '/[^a-z0-9]+/', '-', strtolower( $mat_name ) ) );
                                }

                                if ( ! $mat_name ) {
                                    continue;
                                }

                                $quote_url   = isset( $quote_link['url'] ) ? (string) $quote_link['url'] : '';
                                $quote_title = isset( $quote_link['title'] ) ? (string) $quote_link['title'] : '';
                                $quote_target = isset( $quote_link['target'] ) ? (string) $quote_link['target'] : '';

                                $specs_url   = isset( $specs_link['url'] ) ? (string) $specs_link['url'] : '';
                                $specs_title = isset( $specs_link['title'] ) ? (string) $specs_link['title'] : '';
                                $specs_target = isset( $specs_link['target'] ) ? (string) $specs_link['target'] : '';
                                ?>

                                <div
                                    class="border border-border rounded-card bg-white overflow-hidden shadow-sm"
                                    data-process="<?php echo esc_attr( $proc_name ); ?>"
                                    data-material="<?php echo esc_attr( $mat_name ); ?>"
                                >
                                    <button
                                        type="button"
                                        @click='openMaterial = (openMaterial === <?php echo json_encode( $material_id_key ); ?> ? "" : <?php echo json_encode( $material_id_key ); ?>)'
                                        class="w-full flex justify-between items-center p-4 lg:px-6 lg:py-5 bg-white hover:bg-bg-section/40 transition-colors text-left"
                                    >
                                        <div class="flex items-center gap-3">
                                            <span class="text-[15px] lg:text-[17px] font-semibold text-heading" ><?php echo esc_html( $mat_name ); ?></span>
                                            <?php if ( $mat_badge ) : ?>
                                                <span class="text-[8px] font-bold text-primary bg-primary/5 px-2 py-0.5 rounded uppercase tracking-[0.22em]">
                                                    <?php echo esc_html( $mat_badge ); ?>
                                                </span>
                                            <?php endif; ?>
                                        </div>
                                        <svg
                                            class="w-4 h-4 text-muted transition-transform duration-300"
                                            :class='openMaterial === <?php echo json_encode( $material_id_key ); ?> ? "rotate-180" : ""'
                                            fill="none"
                                            stroke="currentColor"
                                            viewBox="0 0 24 24"
                                        >
                                            <path stroke-width="2.5" d="M19 9l-7 7-7-7" />
                                        </svg>
                                    </button>

                                    <div x-show='openMaterial === <?php echo json_encode( $material_id_key ); ?>' x-cloak>
                                        <div class="p-5 lg:p-10 border-t border-border">
                                            <div class="grid lg:grid-cols-[1.15fr_320px] gap-8 lg:gap-12 items-stretch">
                                                <div class="flex flex-col justify-center h-full">
                                                    <?php if ( $mat_desc ) : ?>
                                                        <div class="text-small text-body leading-relaxed mb-8 lg:max-w-[95%]">
                                                            <?php echo wp_kses_post( $mat_desc ); ?>
                                                        </div>
                                                    <?php endif; ?>

                                                    <?php if ( $mat_specs ) : ?>
                                                        <div class="grid grid-cols-2 md:grid-cols-4 gap-2.5 mb-8">
                                                            <?php foreach ( $mat_specs as $spec ) : ?>
                                                                <?php
                                                                $spec_label = isset( $spec['label'] ) ? (string) $spec['label'] : '';
                                                                $spec_value = isset( $spec['value'] ) ? (string) $spec['value'] : '';

                                                                if ( ! $spec_label && ! $spec_value ) {
                                                                    continue;
                                                                }
                                                                ?>
                                                                <div class="bg-bg-section p-3 rounded border border-border/60 text-center lg:text-left">
                                                                    <?php if ( $spec_label ) : ?>
                                                                        <div class="text-[8px] text-muted uppercase font-bold mb-1 tracking-[0.22em]">
                                                                            <?php echo esc_html( $spec_label ); ?>
                                                                        </div>
                                                                    <?php endif; ?>
                                                                    <?php if ( $spec_value ) : ?>
                                                                        <div class="font-mono text-[13px] lg:text-[14px] font-bold text-heading">
                                                                            <?php echo esc_html( $spec_value ); ?>
                                                                        </div>
                                                                    <?php endif; ?>
                                                                </div>
                                                            <?php endforeach; ?>
                                                        </div>
                                                    <?php endif; ?>

                                                    <div class="flex flex-wrap gap-3">
                                                        <?php if ( $quote_url && $quote_title ) : ?>
                                                            <a
                                                                href="<?php echo esc_url( $quote_url ); ?>"
                                                                class="inline-flex items-center justify-center bg-primary text-inverse px-6 py-3 rounded-button font-bold text-[11px] uppercase tracking-[0.18em] hover:bg-primary-hover transition-all shadow-sm"
                                                                <?php echo $quote_target ? 'target="' . esc_attr( $quote_target ) . '" rel="noopener noreferrer"' : ''; ?>
                                                            >
                                                                <?php echo esc_html( $quote_title ); ?>
                                                            </a>
                                                        <?php endif; ?>

                                                        <?php if ( $specs_url && $specs_title ) : ?>
                                                            <a
                                                                href="<?php echo esc_url( $specs_url ); ?>"
                                                                class="inline-flex items-center justify-center border border-primary text-primary px-6 py-3 rounded-button font-bold text-[11px] uppercase tracking-[0.18em] hover:bg-primary/5 transition-all"
                                                                <?php echo $specs_target ? 'target="' . esc_attr( $specs_target ) . '" rel="noopener noreferrer"' : ''; ?>
                                                            >
                                                                <?php echo esc_html( $specs_title ); ?>
                                                            </a>
                                                        <?php endif; ?>
                                                    </div>
                                                </div>

                                                <?php if ( $mat_image_id ) : ?>
                                                    <div class="hidden lg:block shrink-0 h-full">
                                                        <div class="aspect-square w-[320px] bg-bg-section rounded-card border border-border overflow-hidden relative group">
                                                            <?php echo wp_get_attachment_image( $mat_image_id, 'large', false, array( 'class' => 'w-full h-full object-cover transition-transform duration-700 group-hover:scale-105' ) ); ?>
                                                        </div>
                                                    </div>

                                                    <?php if ( ! $hide_image_mobile ) : ?>
                                                        <div class="lg:hidden w-full aspect-video rounded-card overflow-hidden border border-border mt-3">
                                                            <?php echo wp_get_attachment_image( $mat_image_id, 'large', false, array( 'class' => 'w-full h-full object-cover' ) ); ?>
                                                        </div>
                                                    <?php endif; ?>
                                                <?php endif; ?>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    <?php endforeach; ?>
                </div>
            </main>
        </div>
    </div>
</section>
