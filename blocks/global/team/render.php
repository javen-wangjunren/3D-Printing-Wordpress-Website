<?php
/**
 * Team Block Template
 *
 * @package 3D_Printing
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// Prefix Support
$pfx = isset($block['prefix']) ? $block['prefix'] : '';
$block = isset( $block ) ? $block : array();
$clone_name = rtrim($pfx, '_');

// 1. Data Scope
$header      = get_field_value( 'team_header', $block, $clone_name, $pfx, [] );
$title       = isset($header['title']) ? $header['title'] : 'Our Leadership Team';
$highlight   = isset($header['highlight']) ? $header['highlight'] : '';
$description = isset($header['description']) ? $header['description'] : '';
$members     = get_field_value( 'team_members', $block, $clone_name, $pfx );

// 2. Visual Mapping & Layout Logic
$bg_style = get_field_value( 'background_style', $block, $clone_name, $pfx, 'industrial' );
$bg_color = ($bg_style === 'white') ? '#ffffff' : '#F2F4F7';

$section_classes = 'w-full relative overflow-hidden';
if ( $bg_style === 'industrial' ) {
	$section_classes .= ' industrial-grid-bg';
}

// Mobile Visibility
$mobile_hide = get_field_value( 'mobile_hide_content', $block, $clone_name, $pfx, false );
if ( $mobile_hide ) {
    $section_classes .= ' hidden lg:block';
}

// Dynamic Spacing Logic
$prev_bg  = isset( $GLOBALS['3dp_last_bg'] ) ? $GLOBALS['3dp_last_bg'] : '';
$section_spacing = ( $bg_color === $prev_bg ) ? 'pt-[100px] pb-16 lg:pb-24' : 'py-16 lg:py-24';

// Update Global State
$GLOBALS['3dp_last_bg'] = $bg_color;

$block_id = 'team-' . $block['id'];
if ( ! empty( $block['anchor'] ) ) {
	$block_id = $block['anchor'];
}

$section_classes .= ' ' . $section_spacing;
?>

<section id="<?php echo esc_attr( $block_id ); ?>" class="<?php echo esc_attr( $section_classes ); ?>" style="background-color: <?php echo esc_attr($bg_color); ?>;">
	<div class="max-w-container mx-auto px-5 lg:px-8">
		
		<!-- Header -->
		<div class="max-w-3xl mb-12 lg:mb-16">
			<h2 class="industrial-h2 text-[32px] lg:text-[40px] font-bold text-heading mb-4 leading-tight">
				<?php echo esc_html( $title ); ?> 
				<?php if ( $highlight ) : ?>
					<span class="text-primary"><?php echo esc_html( $highlight ); ?></span>
				<?php endif; ?>
			</h2>
			<?php if ( $description ) : ?>
				<div class="text-[16px] lg:text-[18px] text-body opacity-90 leading-relaxed">
					<?php echo wp_kses_post( $description ); ?>
				</div>
			<?php endif; ?>
		</div>

		<!-- Grid -->
		<?php if ( $members ) : ?>
			<div class="grid grid-cols-2 md:grid-cols-2 lg:grid-cols-3 gap-3 md:gap-6 lg:gap-8">
				<?php foreach ( $members as $member ) : ?>
					<?php
					$name      = isset($member['name']) ? $member['name'] : '';
					$role      = isset($member['role']) ? $member['role'] : '';
					$image_id  = isset($member['image']) ? $member['image'] : false;
					$exp       = isset($member['experience_years']) ? $member['experience_years'] : '';
					$linkedin  = isset($member['linkedin']) ? $member['linkedin'] : '';
					?>
					<div class="group bg-white rounded-card border border-border overflow-hidden hover:shadow-lg transition-all duration-300">
						<!-- Image Container -->
						<div class="relative aspect-[4/5] bg-gray-50 overflow-hidden">
							<?php if ( $image_id ) : ?>
								<?php echo wp_get_attachment_image( $image_id, 'medium_large', false, array( 'class' => 'w-full h-full object-cover transition-transform duration-500', 'loading' => 'lazy' ) ); ?>
							<?php else : ?>
								<div class="w-full h-full flex items-center justify-center text-gray-300">
									<svg class="w-16 h-16" fill="currentColor" viewBox="0 0 24 24"><path d="M24 20.993V24H0v-2.996A14.977 14.977 0 0112.004 15c4.904 0 9.26 2.354 11.996 5.993zM16.002 8.999a4 4 0 11-8 0 4 4 0 018 0z" /></svg>
								</div>
							<?php endif; ?>

							<!-- Floating Data Badge -->
							<?php if ( ! empty($exp) || $exp === '0' || $exp === 0 ) : ?>
								<div class="absolute bottom-2 right-2 md:bottom-4 md:right-4 z-20 bg-white/95 backdrop-blur-sm px-2 py-1 md:px-3 md:py-1.5 rounded-tag border border-border/50 flex items-center shadow-sm">
									<div class="font-mono text-[10px] font-bold text-heading leading-none">
										<span class="text-primary block text-[8px] md:text-[9px] mb-0.5 opacity-80 uppercase">Experience</span>
										<span class="text-[13px] md:text-[16px] tabular-nums tracking-tighter"><?php echo esc_html( $exp ); ?></span><span class="text-[9px] md:text-[10px] opacity-60 ml-0.5">YRS</span>
									</div>
								</div>
							<?php endif; ?>
						</div>

						<!-- Content -->
						<div class="p-3 md:p-5 lg:p-6">
							<h3 class="text-[15px] md:text-[20px] font-bold text-heading leading-tight mb-1"><?php echo esc_html( $name ); ?></h3>
							<div class="flex items-center justify-between mt-1 md:mt-2">
								<p class="text-[9px] md:text-[11px] font-mono text-body uppercase tracking-widest font-bold truncate pr-2"><?php echo esc_html( $role ); ?></p>
								
								<?php if ( $linkedin ) : ?>
									<a href="<?php echo esc_url( $linkedin ); ?>" target="_blank" rel="noopener noreferrer" class="text-primary hover:text-primary/80 transition-colors flex-shrink-0" aria-label="LinkedIn">
										<svg class="w-4 h-4 md:w-5 md:h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M19 0h-14c-2.761 0-5 2.239-5 5v14c0 2.761 2.239 5 5 5h14c2.762 0 5-2.239 5-5v-14c0-2.761-2.238-5-5-5zm-11 19h-3v-11h3v11zm-1.5-12.268c-.966 0-1.75-.79-1.75-1.764s.784-1.764 1.75-1.764 1.75.79 1.75 1.764-.783 1.764-1.75 1.764zm13.5 12.268h-3v-5.604c0-3.368-4-3.113-4 0v5.604h-3v-11h3v1.765c1.396-2.586 7-2.777 7 2.476v6.759z"/></svg>
									</a>
								<?php endif; ?>
							</div>
						</div>
					</div>
				<?php endforeach; ?>
			</div>
		<?php endif; ?>

	</div>
</section>

<style>
.industrial-h2 { letter-spacing: -0.5px; }
.rounded-card { border-radius: 12px; }
.rounded-tag { border-radius: 4px; }
</style>
