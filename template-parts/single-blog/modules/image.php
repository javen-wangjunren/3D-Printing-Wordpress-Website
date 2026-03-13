<?php
/**
 * Module: Image
 */
$image   = get_sub_field( 'image_file' );
$caption = get_sub_field( 'image_caption' );
$size    = get_sub_field( 'image_size' ); // contained / wide

if ( $image ) :
	$wrapper_class = ( $size === 'wide' ) ? '-mx-6 lg:-mx-12 my-10' : 'my-8';
	?>
	<figure class="<?php echo esc_attr( $wrapper_class ); ?>">
		<img loading="lazy" src="<?php echo esc_url( $image['url'] ); ?>"  sizes="(min-width: 1024px) 800px, 100vw">			 alt="<?php echo esc_attr( $image['alt'] ); ?>" 
			 class="w-full h-auto rounded-card border border-border">
		<?php if ( $caption ) : ?>
			<figcaption class="mt-3 text-center text-xs text-heading/70 font-mono">
				<?php echo esc_html( $caption ); ?>
			</figcaption>
		<?php endif; ?>
	</figure>
	<?php
endif;
