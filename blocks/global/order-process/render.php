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
$bg_color = '#ffffff'; // 固化为白色背景，移除字段依赖
$anchor_id = '';

if ( empty( $pfx ) ) {
    // Global Settings Mode
    $global_data = get_field('global_order_process', 'option');
    if ( $global_data ) {
        $title = isset($global_data['order_process_title']) ? (string)$global_data['order_process_title'] : '';
        $description = isset($global_data['order_process_description']) ? (string)$global_data['order_process_description'] : '';
        $steps = isset($global_data['order_process_steps']) ? $global_data['order_process_steps'] : array();
        
        $anchor_id = isset($global_data['order_process_anchor_id']) ? (string)$global_data['order_process_anchor_id'] : '';
        $custom_class = isset($global_data['order_process_custom_class']) ? (string)$global_data['order_process_custom_class'] : '';
    }
} else {
    // Local/Page Builder Mode
    $custom_class = (string) get_field_value('order_process_custom_class', $block, $clone_name, $pfx, '');
    
    $title        = (string) get_field_value('order_process_title', $block, $clone_name, $pfx, '');
    $description  = (string) get_field_value('order_process_description', $block, $clone_name, $pfx, '');
    
    $steps        = get_field_value('order_process_steps', $block, $clone_name, $pfx, array());
    $steps        = is_array( $steps ) ? $steps : array();
    
    $anchor_id    = (string) get_field_value('order_process_anchor_id', $block, $clone_name, $pfx, '');
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
					<h2 class="text-heading">
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

		<div class="relative max-w-[1200px] mx-auto">
			<div class="grid grid-cols-1 lg:grid-cols-<?php echo $steps_count; ?> gap-12 lg:gap-0 relative z-10">
				<?php foreach ( $steps as $index => $step ) : ?>
					<?php
					$step_title       = isset( $step['title'] ) ? (string) $step['title'] : '';
					$step_description = isset( $step['description'] ) ? (string) $step['description'] : '';
					$step_icon        = isset( $step['icon'] ) ? (string) $step['icon'] : '';
					$step_number      = $index + 1;
					if ( ! $step_title ) {
						continue;
					}
					?>

					<div class="flex lg:flex-col items-start lg:items-center text-left lg:text-center px-4">
						<!-- Icon Only (Circle Removed) -->
						<?php if ( $step_icon ) : ?>
							<div class="w-12 h-12 lg:w-16 lg:h-16 text-primary flex items-center justify-center shrink-0 mb-0 lg:mb-8 mr-6 lg:mr-0">
								<?php echo $step_icon; ?>
							</div>
						<?php endif; ?>

						<!-- Text Content -->
						<div class="flex-1 pt-2 lg:pt-0">
							<!-- Step Number -->
							<div class="font-mono text-primary font-bold text-lg lg:text-xl mb-1 leading-none tracking-tight">
								<?php echo esc_html( sprintf( '%02d', $step_number ) ); ?>
							</div>

							<!-- Title -->
							<h3 class="text-[17px] lg:text-[19px] font-bold text-heading mb-2 lg:mb-3 leading-tight tracking-[-0.02em]">
								<?php echo esc_html( $step_title ); ?>
							</h3>

							<!-- Description -->
							<?php if ( $step_description ) : ?>
								<p class="text-[13px] lg:text-[14px] leading-relaxed text-slate-500 lg:max-w-[240px] lg:mx-auto">
									<?php echo esc_html( $step_description ); ?>
								</p>
							<?php endif; ?>
						</div>
					</div>
				<?php endforeach; ?>
			</div>
		</div>
	</div>
</div>
<?php
// Set global state for next block
$GLOBALS['3dp_last_bg'] = $bg_color;
?>
