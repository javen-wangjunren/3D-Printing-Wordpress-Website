<?php
/**
 * Order Process Block 渲染模板
 *
 * 使用区块自身的 ACF 字段渲染对称订单流程，适配桌面端网格和移动端垂直流程。
 */
// Prefix Support
$pfx = isset($block['prefix']) ? $block['prefix'] : '';


$block = isset( $block ) ? $block : array();

$block_id = _3dp_get_safe_block_id( $block, 'order-process' );

// 万能取数逻辑
// 确定克隆名
$clone_name = rtrim($pfx, '_');

// Init variables
$custom_class = '';
$title = '';
$description = '';
$steps = array();
$cta_group = array();
$active_step = 1;
$bg_color = '';
$anchor_id = '';

if ( empty( $pfx ) ) {
    // Global Settings Mode
    $global_data = get_field('global_order_process', 'option');
    if ( $global_data ) {
        $title = isset($global_data['order_process_title']) ? (string)$global_data['order_process_title'] : '';
        $description = isset($global_data['order_process_description']) ? (string)$global_data['order_process_description'] : '';
        $steps = isset($global_data['order_process_steps']) ? $global_data['order_process_steps'] : array();
        
        $cta_group = isset($global_data['order_process_cta']) ? $global_data['order_process_cta'] : array();
        
        $bg_color = isset($global_data['order_process_bg_style']) ? (string)$global_data['order_process_bg_style'] : '#ffffff';
        $active_step = isset($global_data['order_process_active_step']) ? (int)$global_data['order_process_active_step'] : 1;
        $anchor_id = isset($global_data['order_process_anchor_id']) ? (string)$global_data['order_process_anchor_id'] : '';
        $custom_class = isset($global_data['order_process_custom_class']) ? (string)$global_data['order_process_custom_class'] : '';
    }
} else {
    // Local/Page Builder Mode
    $custom_class = (string) get_field_value('order_process_custom_class', $block, $clone_name, $pfx, '');
    $bg_color     = (string) get_field_value('order_process_bg_style', $block, $clone_name, $pfx, '#ffffff');
    
    $title        = (string) get_field_value('order_process_title', $block, $clone_name, $pfx, '');
    $description  = (string) get_field_value('order_process_description', $block, $clone_name, $pfx, '');
    
    $steps        = get_field_value('order_process_steps', $block, $clone_name, $pfx, array());
    $steps        = is_array( $steps ) ? $steps : array();
    
    $cta_group    = get_field_value('order_process_cta', $block, $clone_name, $pfx, array());
    $cta_group    = is_array( $cta_group ) ? $cta_group : array();
    
    $active_step  = (int) get_field_value('order_process_active_step', $block, $clone_name, $pfx, 1);
    $anchor_id    = (string) get_field_value('order_process_anchor_id', $block, $clone_name, $pfx, '');
}

$cta_text     = isset( $cta_group['text'] ) ? (string) $cta_group['text'] : '';
$cta_link     = isset( $cta_group['link'] ) && is_array( $cta_group['link'] ) ? $cta_group['link'] : array();

if ( $active_step < 1 ) {
	$active_step = 1;
}

if ( ! $steps ) {
	return;
}

// 根容器样式：垂直间距，背景色使用动态样式
$root_classes = 'order-process-block';

// 动态背景样式
$bg_style = 'style="background-color: ' . esc_attr( $bg_color ) . '"';

// --- Dynamic Spacing Logic ---
$prev_bg = isset($GLOBALS['3dp_last_bg']) ? $GLOBALS['3dp_last_bg'] : '';
$pt_class = ($prev_bg && $prev_bg === $bg_color) ? 'pt-0' : 'pt-16 lg:pt-24';
$pb_class = 'pb-16 lg:pb-24';
$section_spacing = $pt_class . ' ' . $pb_class;

// Update Global State
$GLOBALS['3dp_last_bg'] = $bg_color;
?>

<div id="<?php echo $anchor_id ? esc_attr( $anchor_id ) : ''; ?>" class="<?php echo esc_attr( $root_classes ); ?>"<?php echo $bg_style; ?>>
	<div class="mx-auto max-w-container px-container <?php echo esc_attr( $section_spacing ); ?> <?php echo esc_attr( $custom_class ); ?>">
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

<?php
// Set global state for next block
$GLOBALS['3dp_last_bg'] = $bg_color;
?>
