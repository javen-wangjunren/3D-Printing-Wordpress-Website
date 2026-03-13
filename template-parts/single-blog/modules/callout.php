<?php
/**
 * Module: Callout
 */
$style   = get_sub_field( 'callout_style' );
$title   = get_sub_field( 'callout_title' );
$content = get_sub_field( 'callout_content' );

$bg_class = 'bg-bg-section';
$border_class = 'border-border';
$icon = '';

if ( $style === 'info' ) {
	$bg_class = 'bg-blue-50';
	$border_class = 'border-blue-200';
	$icon = '<svg class="w-5 h-5 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>';
} elseif ( $style === 'warning' ) {
	$bg_class = 'bg-yellow-50';
	$border_class = 'border-yellow-200';
	$icon = '<svg class="w-5 h-5 text-yellow-600" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" /></svg>';
} elseif ( $style === 'tip' ) {
	$bg_class = 'bg-green-50';
	$border_class = 'border-green-200';
	$icon = '<svg class="w-5 h-5 text-green-600" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>';
}
?>
<div class="my-8 p-6 rounded-card border <?php echo $border_class; ?> <?php echo $bg_class; ?> flex gap-4">
	<?php if ( $icon ) : ?>
		<div class="shrink-0 mt-1"><?php echo $icon; ?></div>
	<?php endif; ?>
	<div>
		<?php if ( $title ) : ?>
			<h5 class="text-base font-bold text-heading mb-2"><?php echo esc_html( $title ); ?></h5>
		<?php endif; ?>
		<div class="text-sm text-heading leading-relaxed">
			<?php echo wp_kses_post( $content ); ?>
		</div>
	</div>
</div>
