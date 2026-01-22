<?php
/**
 * Surface Finish Block Render
 * Path: blocks/global/surface-finish/render.php
 */

// Prefix Support
$pfx = isset($block['prefix']) ? $block['prefix'] : '';
$block = isset( $block ) ? $block : array();
$block_id = _3dp_get_safe_block_id( $block, 'surface-finish' );

// --- Dynamic Spacing Logic ---
$bg_color = get_field_value('background_color', $block, $clone_name, $pfx, '#ffffff');
$prev_bg = isset($GLOBALS['3dp_last_bg']) ? $GLOBALS['3dp_last_bg'] : '';
$current_bg_for_state = $bg_color; 
$pt_remove = ($prev_bg && $prev_bg === $current_bg_for_state) ? 'pt-0' : '';

$pt_class = $pt_remove ? 'pt-0' : 'pt-16 lg:pt-24';
$pb_class = 'pb-16 lg:pb-24';
$section_spacing = $pt_class . ' ' . $pb_class;

// Set global state for next block
$GLOBALS['3dp_last_bg'] = $current_bg_for_state;

// Class Logic
$class_name = 'surface-finish-block w-full overflow-hidden ' . $section_spacing;
if ( ! empty( $block['className'] ) ) {
    $class_name .= ' ' . $block['className'];
}

$anchor_id = isset($block['anchor']) ? $block['anchor'] : $block_id;

// Fields (Placeholder)
$title = get_field_value('surface_finish_title', $block, $clone_name, $pfx, '');

?>
<section id="<?php echo esc_attr( $anchor_id ); ?>" class="<?php echo esc_attr( $class_name ); ?>" style="background-color: <?php echo esc_attr($bg_color); ?>;">
    <div class="max-w-container mx-auto px-container">
        <?php if ($title): ?>
            <h2 class="text-h2 font-bold text-heading tracking-tight mb-8"><?php echo esc_html($title); ?></h2>
        <?php endif; ?>
        <!-- Surface Finish Content -->
    </div>
</section>
