<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$title    = get_field( 'showcase_title' );
$subtitle = get_field( 'showcase_subtitle' );
$cases    = get_field( 'showcase_cases' );

if ( ! is_array( $cases ) ) {
	$cases = array();
}

$placeholders = array(
	'https://images.unsplash.com/photo-1559757175-5700dde675bc?auto=format&fit=crop&q=80&w=800',
	'https://images.unsplash.com/photo-1581092160562-40aa08e78837?auto=format&fit=crop&q=80&w=800',
	'https://images.unsplash.com/photo-1576091160399-112ba8d25d1d?auto=format&fit=crop&q=80&w=800',
	'https://images.unsplash.com/photo-1581091226825-a6a2a5aee158?auto=format&fit=crop&q=80&w=800',
	'https://images.unsplash.com/photo-1562679299-266d23163f3e?auto=format&fit=crop&q=80&w=800',
);

$alpine_cases = array();
foreach ( $cases as $i => $case ) {
	$case_name     = isset( $case['case_name'] ) ? $case['case_name'] : '';
	$case_process  = isset( $case['case_process'] ) ? $case['case_process'] : '';
	$case_material = isset( $case['case_material'] ) ? $case['case_material'] : '';
	$image_id      = isset( $case['case_image'] ) ? (int) $case['case_image'] : 0;

	$image_url = $image_id ? wp_get_attachment_image_url( $image_id, 'full' ) : '';
	if ( ! $image_url ) {
		$image_url = isset( $placeholders[ $i ] ) ? $placeholders[ $i ] : $placeholders[0];
	}

	$alpine_cases[] = array(
		'title'    => $case_name,
		'process'  => $case_process,
		'material' => $case_material,
		'img'      => $image_url,
	);
}

$json_encode_fn = function_exists( 'wp_json_encode' ) ? 'wp_json_encode' : 'json_encode';
$x_data = $json_encode_fn( array( 'activeIndex' => null, 'cases' => $alpine_cases ) );

?>

<section class="py-16 lg:py-24 bg-white overflow-hidden"
	x-data='<?php echo esc_attr( $x_data ); ?>'>
	<div class="w-[90%] lg:w-[1280px] mx-auto px-6">
		<div class="mb-12 lg:mb-16 text-center">
			<?php if ( $title ) : ?>
				<h2 class="industrial-h2 text-[28px] lg:text-[36px] font-bold text-heading mb-3">
					<?php echo wp_kses_post( $title ); ?>
				</h2>
			<?php endif; ?>
			<?php if ( $subtitle ) : ?>
				<p class="text-body text-[15px] max-w-xl mx-auto"><?php echo esc_html( $subtitle ); ?></p>
			<?php endif; ?>
		</div>
		<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
			<template x-for="(item, index) in cases" :key="index">
				<div class="group cursor-pointer" @mouseenter="activeIndex = index" @mouseleave="activeIndex = null">
					<div class="relative aspect-[4/3] rounded-[12px] overflow-hidden bg-panel border border-border transition-all duration-300" :class="activeIndex === index ? 'border-primary border-[3px] shadow-lg shadow-primary/10' : ''">
						<img loading="lazy" :src="item.img" class="w-full h-full object-cover" :alt="item.title" sizes="(min-width: 1024px) 800px, 100vw">						<div class="absolute inset-0 bg-gradient-to-t from-industrial/70 via-industrial/15 to-transparent transition-opacity duration-300" :class="activeIndex === index ? 'opacity-90' : 'opacity-60'"></div>
						<div class="absolute bottom-0 left-0 right-0 p-5 transition-all duration-300" :class="activeIndex === index ? 'translate-y-0' : 'translate-y-4'">
							<h3 class="text-heading text-white font-bold text-[18px] mb-2" x-text="item.title"></h3>
							<div x-show="activeIndex === index" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 translate-y-2" x-transition:enter-end="opacity-100 translate-y-0" x-transition:leave="transition ease-in duration-200" x-transition:leave-start="opacity-100 translate-y-0" x-transition:leave-end="opacity-0 translate-y-2" class="font-mono text-[11px] text-white/90 space-y-1 pt-3 border-t border-white/20">
								<div class="flex items-center gap-2">
									<span class="text-white/60">Process:</span>
									<span class="font-semibold text-white" x-text="item.process"></span>
								</div>
								<div class="flex items-center gap-2">
									<span class="text-white/60">Material:</span>
									<span class="font-semibold text-white" x-text="item.material"></span>
								</div>
							</div>
						</div>
					</div>
				</div>
			</template>
		</div>
	</div>
</section>
