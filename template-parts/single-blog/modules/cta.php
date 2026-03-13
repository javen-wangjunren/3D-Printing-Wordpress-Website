<?php
/**
 * Module: CTA
 */
$type = get_sub_field( 'cta_type' );

if ( $type === 'global' ) {
	// Reuse Global Blog CTA logic
	echo '<div class="my-10">';
	get_template_part( 'blocks/global/blog-cta/render' );
	echo '</div>';
} elseif ( $type === 'card' ) {
	$title = get_sub_field( 'cta_title' );
	$link  = get_sub_field( 'cta_link' );
	if ( $link ) :
		$url   = $link['url'];
		$label = $link['title'] ?: 'Learn More';
		?>
		<div class="my-10 p-8 bg-primary rounded-card text-center text-white">
			<h4 class="text-2xl font-bold mb-6"><?php echo esc_html( $title ); ?></h4>
			<a href="<?php echo esc_url( $url ); ?>" class="inline-block px-6 py-3 bg-white text-primary font-bold rounded-button hover:bg-white/90 transition-colors">
				<?php echo esc_html( $label ); ?>
			</a>
		</div>
		<?php
	endif;
} elseif ( $type === 'inline' ) {
	// Inline link logic...
}
