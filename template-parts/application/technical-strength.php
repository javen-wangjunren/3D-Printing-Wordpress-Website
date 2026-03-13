<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$title    = get_field( 'technical_strength_title' );
$subtitle = get_field( 'technical_strength_subtitle' );
$steps    = get_field( 'technical_strength_steps' );

if ( ! is_array( $steps ) ) {
	$steps = array();
}

$placeholders = array(
	'https://images.unsplash.com/photo-1581091226825-a6a2a5aee158?auto=format&fit=crop&q=80&w=600',
	'https://images.unsplash.com/photo-1565793298595-6a879b1d9492?auto=format&fit=crop&q=80&w=600',
	'https://images.unsplash.com/photo-1531482615713-2afd69097998?auto=format&fit=crop&q=80&w=600',
	'https://images.unsplash.com/photo-1562679299-266d23163f3e?auto=format&fit=crop&q=80&w=600',
);

?>

<section class="py-16 lg:py-24 bg-bg-subtle overflow-hidden">
	<div class="w-[90%] lg:w-[1280px] mx-auto">
		<div class="text-center mb-16">
			<?php if ( $title ) : ?>
				<h2 class="industrial-h2 text-heading text-[28px] lg:text-[36px] font-bold leading-tight mb-4">
					<?php echo wp_kses_post( $title ); ?>
				</h2>
			<?php endif; ?>

			<?php if ( $subtitle ) : ?>
				<p class="text-body text-[16px] max-w-2xl mx-auto">
					<?php echo esc_html( $subtitle ); ?>
				</p>
			<?php endif; ?>
		</div>

		<div class="relative">
			<div class="hidden lg:block absolute top-[120px] left-0 right-0 h-[2px]" style="background: linear-gradient(to right, #E4E7EC 0%, #0047AB 50%, #E4E7EC 100%);"></div>

			<div class="grid grid-cols-1 lg:grid-cols-4 gap-8 lg:gap-4">
				<?php foreach ( $steps as $i => $step ) : ?>
					<?php
					$index = (int) $i + 1;

					$step_title = isset( $step['step_title'] ) ? $step['step_title'] : '';
					$step_desc  = isset( $step['step_desc'] ) ? $step['step_desc'] : '';
					$image_id   = isset( $step['step_image'] ) ? (int) $step['step_image'] : 0;

					$image_url = $image_id ? wp_get_attachment_image_url( $image_id, 'full' ) : '';
					if ( ! $image_url ) {
						$image_url = isset( $placeholders[ $i ] ) ? $placeholders[ $i ] : $placeholders[0];
					}

					$number_bg = ( 2 === $index ) ? 'bg-industrial' : 'bg-primary';
					$frame_cls = ( 4 === $index ) ? 'border-2 border-primary' : 'border border-border';
					$img_cls   = ( 4 === $index ) ? 'w-full h-full object-cover' : 'w-full h-full object-cover opacity-80';
					?>

					<div class="relative">
						<div class="aspect-[4/3] rounded-[12px] overflow-hidden bg-panel <?php echo esc_attr( $frame_cls ); ?> mb-6 relative">
							<?php if ( $image_url ) : ?>
								<img loading="lazy" src="<?php echo esc_url( $image_url ); ?>" class="<?php echo esc_attr( $img_cls ); ?>" alt="" sizes="(min-width: 1024px) 800px, 100vw">							<?php endif; ?>
						</div>

						<div class="text-center">
							<div class="w-12 h-12 rounded-full <?php echo esc_attr( $number_bg ); ?> text-white font-bold text-[14px] flex items-center justify-center mx-auto mb-4"><?php echo esc_html( sprintf( '%02d', $index ) ); ?></div>

							<?php if ( $step_title ) : ?>
								<h3 class="text-heading text-[18px] font-bold mb-2"><?php echo esc_html( $step_title ); ?></h3>
							<?php endif; ?>

							<?php if ( $step_desc ) : ?>
								<p class="text-body text-[13px]"><?php echo esc_html( $step_desc ); ?></p>
							<?php endif; ?>
						</div>
					</div>
				<?php endforeach; ?>
			</div>
		</div>
	</div>
</section>
