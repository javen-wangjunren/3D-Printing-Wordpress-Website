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
$title       = get_field_value( 'title', $block, $clone_name, $pfx, 'Our Leadership Team' );
$highlight   = get_field_value( 'highlight', $block, $clone_name, $pfx ); // e.g., "Experts"
$description = get_field_value( 'description', $block, $clone_name, $pfx );
$members     = get_field_value( 'members', $block, $clone_name, $pfx );

// 2. Visual Mapping & Layout Logic
$bg_color = get_field_value( 'background_color', $block, $clone_name, $pfx, '#ffffff' );

// Dynamic Spacing Logic
$prev_bg  = isset( $GLOBALS['3dp_last_bg'] ) ? $GLOBALS['3dp_last_bg'] : '';
$section_spacing = ( $bg_color === $prev_bg ) ? 'pt-0 pb-16 lg:pb-24' : 'py-16 lg:py-24';

// Update Global State
$GLOBALS['3dp_last_bg'] = $bg_color;

$block_id = 'team-' . $block['id'];
if ( ! empty( $block['anchor'] ) ) {
	$block_id = $block['anchor'];
}

$section_classes = sprintf(
	'w-full %s relative overflow-hidden',
	esc_attr( $section_spacing )
);

?>

<section id="<?php echo esc_attr( $block_id ); ?>" class="<?php echo esc_attr( $section_classes ); ?>" style="background-color: <?php echo esc_attr($bg_color); ?>;">
	<div class="max-w-container mx-auto px-5 lg:px-8">
		
		<!-- Header -->
		<div class="max-w-3xl mb-12 lg:mb-16">
			<h2 class="text-3xl lg:text-4xl font-bold text-heading mb-4 tracking-tight">
				<?php echo esc_html( $title ); ?> 
				<?php if ( $highlight ) : ?>
					<span class="text-primary"><?php echo esc_html( $highlight ); ?></span>
				<?php endif; ?>
			</h2>
			<?php if ( $description ) : ?>
				<div class="text-lg text-body/80 leading-relaxed">
					<?php echo wp_kses_post( $description ); ?>
				</div>
			<?php endif; ?>
		</div>

		<!-- Grid -->
		<?php if ( $members ) : ?>
			<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 lg:gap-8">
				<?php foreach ( $members as $member ) : ?>
					<?php
					$name      = $member['name'];
					$role      = $member['role'];
					$image_id  = $member['image'];
					$bio       = $member['bio'];
					$linkedin  = $member['linkedin'];
					?>
					<div class="group bg-white rounded-xl border border-border p-6 hover:shadow-lg transition-all duration-300 hover:-translate-y-1">
						<div class="mb-6 relative aspect-square rounded-lg overflow-hidden bg-gray-50">
							<?php if ( $image_id ) : ?>
								<?php echo wp_get_attachment_image( $image_id, 'medium_large', false, array( 'class' => 'w-full h-full object-cover group-hover:scale-105 transition-transform duration-500', 'loading' => 'lazy' ) ); ?>
							<?php else : ?>
								<div class="w-full h-full flex items-center justify-center text-gray-300">
									<svg class="w-16 h-16" fill="currentColor" viewBox="0 0 24 24"><path d="M24 20.993V24H0v-2.996A14.977 14.977 0 0112.004 15c4.904 0 9.26 2.354 11.996 5.993zM16.002 8.999a4 4 0 11-8 0 4 4 0 018 0z" /></svg>
								</div>
							<?php endif; ?>
						</div>

						<h3 class="text-xl font-bold text-heading mb-1"><?php echo esc_html( $name ); ?></h3>
						<p class="text-primary font-medium text-sm mb-4 font-mono"><?php echo esc_html( $role ); ?></p>
						
						<?php if ( $bio ) : ?>
							<p class="text-sm text-body/70 mb-6 line-clamp-3">
								<?php echo esc_html( $bio ); ?>
							</p>
						<?php endif; ?>

						<?php if ( $linkedin ) : ?>
							<a href="<?php echo esc_url( $linkedin ); ?>" target="_blank" rel="noopener noreferrer" class="inline-flex items-center text-body hover:text-primary transition-colors">
								<svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M19 0h-14c-2.761 0-5 2.239-5 5v14c0 2.761 2.239 5 5 5h14c2.762 0 5-2.239 5-5v-14c0-2.761-2.238-5-5-5zm-11 19h-3v-11h3v11zm-1.5-12.268c-.966 0-1.75-.79-1.75-1.764s.784-1.764 1.75-1.764 1.75.79 1.75 1.764-.783 1.764-1.75 1.764zm13.5 12.268h-3v-5.604c0-3.368-4-3.113-4 0v5.604h-3v-11h3v1.765c1.396-2.586 7-2.777 7 2.476v6.759z"/></svg>
							</a>
						<?php endif; ?>
					</div>
				<?php endforeach; ?>
			</div>
		<?php endif; ?>

	</div>
</section>
