<?php

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

$title      = get_field( 'hero_title' );
$benefits   = get_field( 'hero_benefits' );
$metrics    = get_field( 'hero_metrics' );
$cta_label  = get_field( 'hero_cta_label' );
$cta_link   = get_field( 'hero_cta_url' );
$image_id   = (int) get_field( 'hero_image' );

if ( ! is_array( $benefits ) ) {
    $benefits = array();
}

if ( ! is_array( $metrics ) ) {
    $metrics = array();
}

$cta_url = is_array( $cta_link ) && isset( $cta_link['url'] ) ? $cta_link['url'] : '#';

$image_url = $image_id ? wp_get_attachment_image_url( $image_id, 'full' ) : 'https://images.unsplash.com/photo-1581091226825-a6a2a5aee158?auto=format&fit=crop&q=80&w=1200';
$image_alt = $title ? esc_attr( $title ) : 'Application';
?>

<section class="py-20 lg:py-32 bg-white overflow-hidden">
    <div class="mx-auto max-w-6xl px-4 lg:px-0 grid grid-cols-1 lg:grid-cols-2 gap-12 lg:gap-16 items-center">
        <div class="flex flex-col justify-center max-w-xl">
            <?php if ( $title ) : ?>
            <h1 class="text-heading text-[34px] sm:text-[40px] lg:text-[48px] font-extrabold tracking-[-0.02em] leading-[1.1] mb-6">
                <?php echo wp_kses_post( $title ); ?>
            </h1>
            <?php endif; ?>

            <?php if ( ! empty( $benefits ) ) : ?>
            <ul class="space-y-3 mb-8 ml-0 pl-0 list-none">
                <?php foreach ( $benefits as $benefit ) : ?>
                    <?php $benefit_text = isset( $benefit['hero_benefits_text'] ) ? $benefit['hero_benefits_text'] : ''; ?>
                    <?php if ( $benefit_text ) : ?>
                    <li class="flex items-start gap-3">
                        <div class="hidden sm:flex mt-1 w-4 h-4 rounded-full border border-border flex-shrink-0 items-center justify-center">
                            <svg class="w-3 h-3 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                        </div>
                        <span class="text-[15px] font-medium text-body leading-snug"><?php echo esc_html( $benefit_text ); ?></span>
                    </li>
                    <?php endif; ?>
                <?php endforeach; ?>
            </ul>
            <?php endif; ?>

            <?php if ( ! empty( $metrics ) ) : ?>
            <div class="grid grid-cols-2 sm:grid-cols-4 gap-x-8 gap-y-4 py-6 border-y border-border mb-8">
                <?php foreach ( $metrics as $metric ) : ?>
                    <?php
                    $metric_label = isset( $metric['hero_metrics_label'] ) ? $metric['hero_metrics_label'] : '';
                    $metric_value = isset( $metric['hero_metrics_value'] ) ? $metric['hero_metrics_value'] : '';
                    ?>
                    <?php if ( $metric_label || $metric_value ) : ?>
                    <div class="min-w-0">
                        <?php if ( $metric_label ) : ?>
                        <div class="text-[12px] font-semibold tracking-[-0.5px] text-industrial/70"><?php echo esc_html( $metric_label ); ?></div>
                        <?php endif; ?>
                        <?php if ( $metric_value ) : ?>
                        <div class="mt-1 font-mono text-[20px] font-bold text-primary leading-none"><?php echo esc_html( $metric_value ); ?></div>
                        <?php endif; ?>
                    </div>
                    <?php endif; ?>
                <?php endforeach; ?>
            </div>
            <?php endif; ?>

            <?php if ( $cta_label ) : ?>
            <div class="flex flex-wrap gap-3">
                <a href="<?php echo esc_url( $cta_url ); ?>" class="inline-flex items-center justify-center rounded-button bg-primary px-6 py-3 text-[14px] font-semibold text-white transition-colors hover:bg-primary-hover">
                    <?php echo esc_html( $cta_label ); ?>
                </a>
            </div>
            <?php endif; ?>
        </div>

        <div class="relative">
            <div class="aspect-[4/3] rounded-card overflow-hidden bg-panel border border-border">
                <img loading="lazy" src="<?php echo esc_url( $image_url ); ?>" class="w-full h-full object-cover" alt="<?php echo $image_alt; ?>" sizes="(min-width: 1024px) 800px, 100vw">            </div>
        </div>
    </div>
</section>
