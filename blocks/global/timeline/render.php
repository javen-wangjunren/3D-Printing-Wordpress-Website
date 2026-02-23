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
$prefix      = isset($header['prefix']) ? $header['prefix'] : 'Evolution and';
$highlight   = isset($header['highlight']) ? $header['highlight'] : 'Milestones';
$description = isset($header['description']) ? $header['description'] : '';

// Events Repeater
$events = get_field_value('timeline_items', $block, $clone_name, $pfx, []);

// 2. Visual Mapping
$bg_color = get_field_value('background_color', $block, $clone_name, $pfx, '#ffffff');

// Dynamic Spacing Logic
$prev_bg  = isset( $GLOBALS['3dp_last_bg'] ) ? $GLOBALS['3dp_last_bg'] : '';
$section_spacing = ( $bg_color === $prev_bg ) ? 'pt-[100px] pb-16 lg:pb-24' : 'py-16 lg:py-24';

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
		<div class="mb-16 lg:mb-20 flex flex-col lg:flex-row items-start lg:items-end justify-between gap-6">
			<div class="max-w-2xl">
				<h2 class="text-[32px] lg:text-[40px] font-bold text-heading leading-tight mb-4">
					<?php echo esc_html( $prefix ); ?> <span class="text-primary"><?php echo esc_html( $highlight ); ?></span>
				</h2>
				<?php if ( $description ) : ?>
					<p class="text-[16px] lg:text-[18px] text-body opacity-90">
						<?php echo esc_html( $description ); ?>
					</p>
				<?php endif; ?>
			</div>
			
			<div class="hidden md:flex gap-3 mb-2">
				<button @click="scrollPrev()" class="w-12 h-12 rounded-full border-[3px] border-border bg-white flex items-center justify-center hover:border-primary text-heading transition-colors" aria-label="Previous milestone">
					←
				</button>
				<button @click="scrollNext()" class="w-12 h-12 rounded-full border-[3px] border-border bg-white flex items-center justify-center hover:border-primary text-heading transition-colors" aria-label="Next milestone">
					→
				</button>
			</div>
		</div>

		<!-- Timeline Scroll (Desktop) -->
		<div class="hidden lg:block relative">
			<div x-ref="scrollContainer" class="flex overflow-x-auto pb-12 snap-x no-scrollbar z-10 relative">
				<div class="inline-flex min-w-full relative py-10 items-stretch">
					
					<!-- Connecting Line (Solid) -->
					<div class="absolute top-[155px] left-0 right-0 h-[3px] bg-slate-300 z-0"></div>

					<?php if ( $events ) : ?>
						<?php foreach ( $events as $index => $event ) : 
							$is_active = isset($event['is_active']) && $event['is_active'];
							$metric_label = !empty($event['metric_label']) ? $event['metric_label'] : 'Metric';
							$metric_value = isset($event['metric_value']) ? $event['metric_value'] : '';
						?>
							<div class="w-[340px] flex-shrink-0 px-5 relative z-10 group snap-start flex flex-col">
								<!-- Year (Above) -->
								<div class="mb-12 h-14 flex items-end">
									<span class="font-mono text-[56px] font-bold leading-none transition-all duration-500 <?php echo $is_active ? 'text-primary opacity-100 scale-105 origin-left' : 'text-heading opacity-10 group-hover:opacity-40'; ?>">
										<?php echo esc_html( $event['year'] ); ?>
									</span>
								</div>

								<!-- Node (Center) -->
								<div class="relative mb-10 h-6 flex items-center">
									<div class="w-6 h-6 rounded-full border-4 border-white transition-all duration-500 <?php echo $is_active ? 'bg-primary shadow-[0_0_0_1px_#0047AB]' : 'bg-border group-hover:bg-primary shadow-[0_0_0_1px_#E4E7EC] group-hover:shadow-[0_0_0_1px_#0047AB]'; ?>"></div>
								</div>
								
								<!-- Card (Below) -->
								<div class="p-8 rounded-card border transition-all duration-500 flex-1 flex flex-col justify-between <?php echo $is_active ? 'bg-white border-primary shadow-xl shadow-primary/5 card-locked' : 'bg-gray-50/50 border-border hover:border-primary/50'; ?>">
									<div>
										<div class="flex justify-between items-start mb-4">
											<h4 class="text-[18px] font-bold text-heading leading-tight tracking-tight">
												<?php echo esc_html( $event['title'] ); ?>
											</h4>
											<?php if ($is_active) : ?>
												<span class="bg-primary text-white text-[9px] font-bold px-2 py-0.5 rounded-full uppercase tracking-widest shadow-sm">Active</span>
											<?php endif; ?>
										</div>
										<p class="text-[14px] text-body leading-relaxed opacity-90 font-sans">
											<?php echo esc_html( $event['description'] ); ?>
										</p>
									</div>

									<?php if ($metric_value) : ?>
										<div class="mt-8 pt-5 border-t border-border/60">
											<span class="font-mono text-[11px] font-bold text-primary uppercase tracking-wider">
												<?php echo esc_html($metric_label); ?>: <span class="text-heading ml-1"><?php echo esc_html($metric_value); ?></span>
											</span>
										</div>
									<?php endif; ?>
								</div>
							</div>
						<?php endforeach; ?>
					<?php endif; ?>
				</div>
			</div>
		</div>

		<!-- Timeline Vertical (Mobile) -->
		<div class="lg:hidden relative">
			<!-- Vertical Line -->
			<div class="absolute left-0 top-0 bottom-0 w-[2px] bg-border z-0"></div>
			
			<div class="space-y-10 pl-8 relative z-10">
				<?php if ( $events ) : ?>
					<?php foreach ( $events as $event ) : 
						$is_active = isset($event['is_active']) && $event['is_active'];
					?>
						<div class="relative">
							<!-- Node -->
							<div class="absolute -left-[39px] top-1.5 w-3.5 h-3.5 rounded-full border-4 border-white <?php echo $is_active ? 'bg-primary shadow-[0_0_0_1px_#0047AB]' : 'bg-border shadow-[0_0_0_1px_#E4E7EC]'; ?>"></div>
							
							<span class="font-mono text-[20px] font-bold block mb-3 <?php echo $is_active ? 'text-primary' : 'text-heading opacity-50'; ?>">
								<?php echo esc_html( $event['year'] ); ?>
							</span>
							
							<div class="p-6 rounded-card border transition-all duration-300 <?php echo $is_active ? 'bg-white border-primary shadow-lg shadow-primary/5' : 'bg-gray-50/50 border-border'; ?>">
								<h4 class="text-[16px] font-bold text-heading mb-2 leading-tight">
									<?php echo esc_html( $event['title'] ); ?>
								</h4>
								<p class="text-[13px] text-body opacity-90 leading-relaxed mb-4">
									<?php echo esc_html( $event['description'] ); ?>
								</p>
								<?php if (isset($event['metric_value']) && !empty($event['metric_value'])) : ?>
									<div class="pt-3 border-t border-border/60">
										<span class="font-mono text-[10px] font-bold text-primary uppercase">
											<?php echo esc_html(!empty($event['metric_label']) ? $event['metric_label'] : 'Metric'); ?>: <span class="text-heading ml-1"><?php echo esc_html($event['metric_value']); ?></span>
										</span>
									</div>
								<?php endif; ?>
							</div>
						</div>
					<?php endforeach; ?>
				<?php endif; ?>
			</div>
		</div>

	</div>
</section>

<style>
.no-scrollbar::-webkit-scrollbar {
	display: none;
}
.no-scrollbar {
	-ms-overflow-style: none;
	scrollbar-width: none;
}
.card-locked {
	border: 3px solid #0047AB !important;
}
</style>
