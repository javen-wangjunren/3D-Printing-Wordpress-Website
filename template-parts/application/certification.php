<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$title   = get_field( 'certification_title' );
$images  = get_field( 'certification_images' );
$desc    = get_field( 'certification_desc' );
$desc    = $desc ? $desc : 'All materials and processes meet international quality standards for industrial applications.';

if ( ! is_array( $images ) ) {
	$images = array();
}

$placeholders = array(
	'https://images.unsplash.com/photo-1560472355-536de3962603?auto=format&fit=crop&q=90&w=1200',
	'https://images.unsplash.com/photo-1554224155-6726b3ff858f?auto=format&fit=crop&q=90&w=1200',
	'https://images.unsplash.com/photo-1576091160550-2173dba999ef?auto=format&fit=crop&q=90&w=1200',
);

?>

<section class="py-12 lg:py-16 bg-bg-subtle overflow-hidden">
	<div class="w-[90%] lg:w-[1280px] mx-auto px-6">
		<div class="mb-8 text-center">
			<?php if ( $title ) : ?>
				<h2 class="industrial-h2 text-heading text-[24px] lg:text-[28px] font-bold">
					<?php echo wp_kses_post( $title ); ?>
				</h2>
			<?php endif; ?>
		</div>

		<div class="grid grid-cols-1 md:grid-cols-3 gap-8 lg:gap-12">
			<?php for ( $i = 0; $i < 3; $i++ ) : ?>
				<?php
				$row      = isset( $images[ $i ] ) ? $images[ $i ] : array();
				$image_id = isset( $row['image'] ) ? (int) $row['image'] : 0;
				$src      = $image_id ? wp_get_attachment_image_url( $image_id, 'full' ) : ( isset( $placeholders[ $i ] ) ? $placeholders[ $i ] : $placeholders[0] );
				$alt      = '';
				$post_meta_fn = function_exists( 'get_post_meta' ) ? 'get_post_meta' : null;
				$alt = ( $image_id && $post_meta_fn ) ? $post_meta_fn( $image_id, '_wp_attachment_image_alt', true ) : '';
				?>
				<div class="rounded-[12px] border border-border overflow-hidden">
					<img loading="lazy" src="<?php echo esc_url( $src ); ?>" alt="<?php echo esc_attr( $alt ); ?>" class="block w-full h-[350px] lg:h-[450px] object-cover" sizes="(min-width: 1024px) 800px, 100vw" />				</div>
			<?php endfor; ?>
		</div>

		<p class="mt-8 text-center text-muted text-[13px]">
			<?php echo esc_html( $desc ); ?>
		</p>
	</div>
</section>
