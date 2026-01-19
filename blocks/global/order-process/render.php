<?php
/**
 * Order Process Block 渲染模板
 *
 * 使用区块自身的 ACF 字段渲染对称订单流程，适配桌面端网格和移动端垂直流程。
 */

$block = isset( $block ) ? $block : array();

$block_id = _3dp_get_safe_block_id( $block, 'order-process' );
$custom_class = (string) get_field( 'order_process_custom_class' ) ?: '';
$bg_style     = (string) get_field( 'order_process_bg_style' ) ?: 'bg-white';

$title        = (string) get_field( 'order_process_title' ) ?: '';
$description  = (string) get_field( 'order_process_description' ) ?: '';

$steps        = get_field( 'order_process_steps' );
$steps        = is_array( $steps ) ? $steps : array();

$cta_group    = get_field( 'order_process_cta' );
$cta_group    = is_array( $cta_group ) ? $cta_group : array();

$cta_text     = isset( $cta_group['text'] ) ? (string) $cta_group['text'] : '';
$cta_link     = isset( $cta_group['link'] ) && is_array( $cta_group['link'] ) ? $cta_group['link'] : array();

$active_step  = (int) get_field( 'order_process_active_step' );
if ( $active_step < 1 ) {
	$active_step = 1;
}

if ( ! $steps ) {
	return;
}

// 根容器样式：背景 + 垂直间距
$root_classes = trim( implode( ' ', array_filter( array(
	'order-process-block',
	$bg_style,
) ) ) );
?>

<div id="<?php echo $anchor_id ? esc_attr( $anchor_id ) : ''; ?>" class="<?php echo esc_attr( $root_classes ); ?>">
	<div class="mx-auto max-w-container px-container py-section-y-small lg:py-section-y <?php echo esc_attr( $custom_class ); ?>">
		<?php if ( $title || $description ) : ?>
			<div class="text-center mb-10 lg:mb-16">
				<?php if ( $title ) : ?>
					<h2 class="text-h2 font-semibold text-heading tracking-[-0.04em] mb-3">
						<?php echo esc_html( $title ); ?>
					</h2>
				<?php endif; ?>
				<?php if ( $description ) : ?>
					<p class="text-body max-w-2xl mx-auto text-small opacity-90 leading-snug">
						<?php echo esc_html( $description ); ?>
					</p>
				<?php endif; ?>
			</div>
		<?php endif; ?>

		<?php
		$steps_count = count( $steps );
		?>

		<div class="relative max-w-[1100px] mx-auto">
			<div class="absolute top-7 left-[12.5%] right-[12.5%] h-px bg-border hidden lg:block"></div>
			<div class="absolute left-7 top-4 bottom-4 w-px bg-border lg:hidden"></div>

			<div class="grid grid-cols-1 lg:grid-cols-4 gap-8 lg:gap-0 relative z-10">
				<?php foreach ( $steps as $index => $step ) : ?>
					<?php
					$step_title       = isset( $step['title'] ) ? (string) $step['title'] : '';
					$step_description = isset( $step['description'] ) ? (string) $step['description'] : '';
					$step_icon        = isset( $step['icon'] ) ? (string) $step['icon'] : '';
					$step_number      = $index + 1;
					if ( ! $step_title ) {
						continue;
					}

					$is_active = ( $step_number === $active_step );
					?>

					<div class="flex lg:flex-col items-start lg:items-center text-left lg:text-center gap-3 lg:gap-4">
						<div class="w-14 h-14 rounded-full border bg-white flex flex-col items-center justify-center shrink-0 mb-0 lg:mb-6 mr-4 lg:mr-0 transition-all <?php echo $is_active ? 'border-primary' : 'border-border'; ?>">
							<?php if ( $step_icon ) : ?>
								<div class="w-5 h-5 text-primary mb-0.5">
									<?php echo $step_icon; // SVG 原样输出以保持图标结构 ?>
								</div>
							<?php endif; ?>
							<span class="font-mono text-[9px] text-muted leading-none">
								<?php echo esc_html( sprintf( '%02d', $step_number ) ); ?>
							</span>
						</div>

						<div class="pt-1 lg:pt-0">
							<h3 class="text-[17px] lg:text-[19px] font-semibold text-heading mb-2 lg:mb-3 leading-tight tracking-[-0.02em]">
								<?php echo esc_html( $step_title ); ?>
							</h3>
							<?php if ( $step_description ) : ?>
								<p class="text-[13px] lg:text-[14px] leading-relaxed opacity-85 lg:max-w-[220px] lg:mx-auto">
									<?php echo esc_html( $step_description ); ?>
								</p>
							<?php endif; ?>
						</div>
					</div>
				<?php endforeach; ?>
			</div>
		</div>

		<?php
		$cta_url   = isset( $cta_link['url'] ) ? (string) $cta_link['url'] : '';
		$cta_title = isset( $cta_link['title'] ) ? (string) $cta_link['title'] : '';
		$cta_target = isset( $cta_link['target'] ) ? (string) $cta_link['target'] : '';
		?>

		<?php if ( $cta_text && $cta_url ) : ?>
			<div class="mt-12 lg:mt-16 text-center">
				<a
					class="inline-flex items-center justify-center bg-primary text-white px-8 py-3 lg:px-10 lg:py-3.5 rounded-[12px] font-semibold text-[13px] lg:text-[14px] tracking-[0.12em] uppercase hover:bg-[#003A8C] transition-colors"
					href="<?php echo esc_url( $cta_url ); ?>"
					<?php echo $cta_target ? 'target="' . esc_attr( $cta_target ) . '"' : ''; ?>
				>
					<?php echo esc_html( $cta_text ); ?>
					<svg class="w-4 h-4 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
						<path stroke-width="2.5" d="M13 7l5 5m0 0l-5 5m5-5H6" />
					</svg>
				</a>
			</div>
		<?php endif; ?>
	</div>
</div>
