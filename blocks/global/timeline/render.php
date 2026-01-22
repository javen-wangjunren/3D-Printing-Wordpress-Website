<?php
/**
 * Timeline Block Template
 *
 * @package 3D_Printing
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// 1. Data Scope
$pfx = isset($block['prefix']) ? $block['prefix'] : '';
$clone_name = isset($clone_name) ? $clone_name : '';

// Header Group
$header = get_field_value('timeline_header', $block, $clone_name, $pfx, []);
// Fallback for flat structure
$prefix    = isset($header['prefix']) ? $header['prefix'] : (get_field_value('prefix', $block, $clone_name, $pfx, 'Evolution and'));
$highlight = isset($header['highlight']) ? $header['highlight'] : (get_field_value('highlight', $block, $clone_name, $pfx, 'Milestones'));

// Events Repeater (Support 'timeline_items' or legacy 'events')
$events = get_field_value('timeline_items', $block, $clone_name, $pfx, []);
if (empty($events)) {
    $events = get_field_value('events', $block, $clone_name, $pfx, []);
}

// 2. Visual Mapping
$bg_color = get_field_value('background_color', $block, $clone_name, $pfx, '#ffffff');

// Dynamic Spacing Logic
$prev_bg  = isset( $GLOBALS['3dp_last_bg'] ) ? $GLOBALS['3dp_last_bg'] : '';
$section_spacing = ( $bg_color === $prev_bg ) ? 'pt-0 pb-16 lg:pb-24' : 'py-16 lg:py-24';

// Update Global State
$GLOBALS['3dp_last_bg'] = $bg_color;

$block_id = 'timeline-' . $block['id'];
if ( ! empty( $block['anchor'] ) ) {
	$block_id = $block['anchor'];
}
?>

<section id="<?php echo esc_attr( $block_id ); ?>" class="w-full <?php echo esc_attr( $section_spacing ); ?> border-y border-border overflow-hidden" style="background-color: <?php echo esc_attr($bg_color); ?>;" x-data="{ 
	scrollNext() { this.$refs.scrollContainer.scrollBy({ left: 340, behavior: 'smooth' }) },
	scrollPrev() { this.$refs.scrollContainer.scrollBy({ left: -340, behavior: 'smooth' }) }
}">
	<div class="max-w-container mx-auto px-5 lg:px-8">
		
		<!-- Header & Controls -->
		<div class="flex flex-wrap items-end justify-between gap-6 mb-12 lg:mb-16">
			<div class="max-w-2xl">
				<h2 class="text-3xl lg:text-4xl font-bold text-heading leading-tight tracking-tight">
					<?php echo esc_html( $prefix ); ?> <span class="text-primary"><?php echo esc_html( $highlight ); ?></span>
				</h2>
			</div>
			
			<div class="flex gap-3">
				<button @click="scrollPrev()" class="w-12 h-12 rounded-full border-[3px] border-border flex items-center justify-center text-heading hover:border-primary hover:text-primary transition-all">
					<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-width="2.5" d="M15 19l-7-7 7-7"/></svg>
				</button>
				<button @click="scrollNext()" class="w-12 h-12 rounded-full border-[3px] border-border flex items-center justify-center text-heading hover:border-primary hover:text-primary transition-all">
					<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-width="2.5" d="M9 5l7 7-7 7"/></svg>
				</button>
			</div>
		</div>

		<!-- Timeline Scroll -->
		<div class="relative">
			<!-- Line -->
			<div class="absolute top-[23px] left-0 right-0 h-[2px] bg-border z-0"></div>

			<div x-ref="scrollContainer" class="flex gap-10 lg:gap-16 overflow-x-auto pb-12 snap-x hide-scrollbar z-10 relative">
				<?php if ( $events ) : ?>
					<?php foreach ( $events as $index => $event ) : ?>
						<div class="min-w-[280px] lg:min-w-[320px] snap-start flex flex-col group">
							<!-- Node -->
							<div class="w-[48px] h-[48px] rounded-full bg-white border-[3px] border-primary flex items-center justify-center text-primary font-bold z-10 mb-6 group-hover:scale-110 transition-transform shadow-sm">
								<div class="w-3 h-3 bg-primary rounded-full"></div>
							</div>
							
							<!-- Content -->
							<div>
								<span class="block text-4xl font-bold text-heading/20 mb-2 font-mono group-hover:text-primary/20 transition-colors">
									<?php echo esc_html( $event['year'] ); ?>
								</span>
								<h3 class="text-xl font-bold text-heading mb-3">
									<?php echo esc_html( $event['title'] ); ?>
								</h3>
								<p class="text-sm text-body/70 leading-relaxed">
									<?php echo esc_html( $event['description'] ); ?>
								</p>
							</div>
						</div>
					<?php endforeach; ?>
				<?php endif; ?>
			</div>
		</div>

	</div>
</section>

<style>
.hide-scrollbar::-webkit-scrollbar {
	display: none;
}
.hide-scrollbar {
	-ms-overflow-style: none;
	scrollbar-width: none;
}
</style>
