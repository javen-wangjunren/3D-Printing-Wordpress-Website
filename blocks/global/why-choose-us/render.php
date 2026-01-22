<?php
/**
 * Block: Why Choose Us
 * Path: blocks/global/why-choose-us/render.php
 * Description: Renders the Why Choose Us block with image slider and reasons list.
 * 
 * @package 3D_Printing
 * @author Javen
 */
// Prefix Support
$pfx = isset($block['prefix']) ? $block['prefix'] : '';
$block = isset( $block ) ? $block : array();

// 万能取数逻辑
$clone_name = rtrim($pfx, '_');

// Initialize variables with defaults
$header_title = '';
$header_description = '';
$slides = array();
$fallback_image_id = 0;
$reasons = array();
$cta_link = array();
$layout_style = 'image-left';
$bg_color = '#ffffff'; // Default bg
$auto_rotate = true;
$rotate_interval = 5000;
$custom_class = '';

if ( empty( $pfx ) ) {
    // Global Settings Mode
    $global_data = get_field('global_why_choose_us', 'option');
    if ( $global_data ) {
        $header_title = isset($global_data['wcu_header_title']) ? (string)$global_data['wcu_header_title'] : '';
        $header_description = isset($global_data['wcu_header_description']) ? (string)$global_data['wcu_header_description'] : '';
        $slides = isset($global_data['wcu_slides']) ? $global_data['wcu_slides'] : array();
        $fallback_image_id = isset($global_data['why_choose_us_left_image']) ? (int)$global_data['why_choose_us_left_image'] : 0;
        $cta_link = isset($global_data['wcu_cta_link']) ? $global_data['wcu_cta_link'] : array();
        $layout_style = isset($global_data['why_choose_us_layout_style']) ? (string)$global_data['why_choose_us_layout_style'] : 'image-left';
        $auto_rotate = isset($global_data['wcu_auto_rotate']) ? (bool)$global_data['wcu_auto_rotate'] : true;
        $rotate_interval = isset($global_data['wcu_rotate_interval']) ? (int)$global_data['wcu_rotate_interval'] : 5000;
        $custom_class = isset($global_data['why_choose_us_custom_class']) ? (string)$global_data['why_choose_us_custom_class'] : '';
        $reasons = isset($global_data['why_choose_us_reasons']) ? $global_data['why_choose_us_reasons'] : array();
        $bg_color = isset($global_data['bg_color']) ? $global_data['bg_color'] : '#ffffff';
    }
} else {
    // Local Mode
    $header_title       = (string) get_field_value('wcu_header_title', $block, $clone_name, $pfx, '');
    $header_description = (string) get_field_value('wcu_header_description', $block, $clone_name, $pfx, '');
    $slides             = get_field_value('wcu_slides', $block, $clone_name, $pfx, array());
    $fallback_image_id  = (int) get_field_value('why_choose_us_left_image', $block, $clone_name, $pfx, 0);
    $reasons            = get_field_value('why_choose_us_reasons', $block, $clone_name, $pfx, array());
    $cta_link           = get_field_value('wcu_cta_link', $block, $clone_name, $pfx, array());
    $layout_style       = (string) get_field_value('why_choose_us_layout_style', $block, $clone_name, $pfx, 'image-left');
    $auto_rotate        = (bool) get_field_value('wcu_auto_rotate', $block, $clone_name, $pfx, true);
    $rotate_interval    = (int) get_field_value('wcu_rotate_interval', $block, $clone_name, $pfx, 5000);
    $custom_class       = (string) get_field_value('why_choose_us_custom_class', $block, $clone_name, $pfx, '');
    $bg_color           = get_field_value('bg_color', $block, $clone_name, $pfx, '#ffffff');
}

$block_id = _3dp_get_safe_block_id( $block, 'why-choose-us' );

if ( empty( $reasons ) ) return;

if ( empty( $slides ) && $fallback_image_id ) {
    $slides = array(
        array( 'image' => $fallback_image_id, 'alt' => $header_title ?: 'Factory View' ),
    );
}

$slides_count = is_array( $slides ) ? count( $slides ) : 0;

// --- Dynamic Spacing Logic ---
$prev_bg = isset($GLOBALS['3dp_last_bg']) ? $GLOBALS['3dp_last_bg'] : '';
$pt_class = ($prev_bg && $prev_bg === $bg_color) ? 'pt-0' : 'pt-16 lg:pt-24';
$pb_class = 'pb-16 lg:pb-24';

$left_order  = 'order-1 lg:order-2';
$right_order = 'order-2 lg:order-1';
if ( $layout_style === 'image-right' ) {
    $left_order  = 'order-2 lg:order-1';
    $right_order = 'order-1 lg:order-2';
}

$section_id_attr = $block_id ? 'id="' . esc_attr( $block_id ) . '"' : '';
?>

<section <?php echo $section_id_attr; ?> class="why-choose-us-block w-full relative <?php echo esc_attr( $custom_class . ' ' . $pt_class . ' ' . $pb_class ); ?>" style="background-color: <?php echo esc_attr($bg_color); ?>">
    <div class="mx-auto max-w-container px-6 lg:px-[64px]" x-data="{ activeSlide: 0, slidesCount: <?php echo (int) $slides_count; ?>, autoRotate: <?php echo $auto_rotate ? 'true' : 'false'; ?>, interval: <?php echo (int) $rotate_interval; ?> }" x-init="if (autoRotate && slidesCount > 1) { setInterval(() => { activeSlide = (activeSlide + 1) % slidesCount }, interval) }">
        <div class="grid lg:grid-cols-2 gap-10 lg:gap-16 items-stretch">

            <!-- Image/Slider Section -->
            <div class="relative rounded-card overflow-hidden border border-border h-full min-h-[320px] lg:min-h-0 <?php echo esc_attr( $left_order ); ?>">
                <?php foreach ( $slides as $index => $slide ) : ?>
                    <?php
                    $img_id = isset( $slide['image'] ) ? (int) $slide['image'] : 0;
                    $alt    = isset( $slide['alt'] ) ? (string) $slide['alt'] : ( $header_title ?: 'Factory View' );
                    ?>
                    <div x-show="activeSlide === <?php echo (int) $index; ?>" x-transition:enter="transition ease-out duration-700" x-transition:enter-start="opacity-0 scale-105" x-transition:enter-end="opacity-100 scale-100" class="absolute inset-0">
                        <?php if ( $img_id ) : ?>
                            <?php echo wp_get_attachment_image( $img_id, 'large', false, array( 'alt' => esc_attr( $alt ), 'class' => 'w-full h-full object-cover', 'loading' => 'lazy' ) ); ?>
                        <?php endif; ?>
                    </div>
                <?php endforeach; ?>

                <?php if ( $slides_count > 1 ) : ?>
                <div class="absolute bottom-4 left-1/2 -translate-x-1/2 flex gap-1.5 z-10">
                    <?php for ( $i = 0; $i < $slides_count; $i++ ) : ?>
                        <button @click="activeSlide = <?php echo (int) $i; ?>" :class="activeSlide === <?php echo (int) $i; ?> ? 'bg-white w-6' : 'bg-white/40 w-1.5'" class="h-1 rounded-full transition-all duration-300"></button>
                    <?php endfor; ?>
                </div>
                <?php endif; ?>
            </div>

            <!-- Content Section -->
            <div class="flex flex-col justify-center <?php echo esc_attr( $right_order ); ?>">
                <header class="mb-6 lg:mb-8">
                    <?php if ( $header_title ) : ?>
                        <h2 class="text-h2 font-bold text-heading tracking-tight leading-tight mb-4">
                            <?php echo esc_html( $header_title ); ?>
                        </h2>
                    <?php endif; ?>
                    <?php if ( $header_description ) : ?>
                        <p class="text-body text-small leading-relaxed">
                            <?php echo esc_html( $header_description ); ?>
                        </p>
                    <?php endif; ?>
                </header>

                <div class="space-y-2 lg:space-y-3">
                    <?php foreach ( $reasons as $reason ) : ?>
                        <?php
                        $r_title = isset( $reason['reason_title'] ) ? (string) $reason['reason_title'] : '';
                        $r_desc  = isset( $reason['reason_description'] ) ? (string) $reason['reason_description'] : '';
                        $r_badge = isset( $reason['reason_badge'] ) ? (string) $reason['reason_badge'] : '';
                        $r_svg   = isset( $reason['reason_icon_svg'] ) ? (string) $reason['reason_icon_svg'] : '';
                        if ( ! $r_title ) { continue; }
                        ?>
                        <div class="flex items-center gap-4 p-3 rounded-lg border border-transparent hover:border-border hover:bg-bg-section/40 transition-all group">
                            <div class="w-8 h-8 rounded bg-primary/10 flex items-center justify-center text-primary shrink-0 group-hover:bg-primary group-hover:text-inverse transition-colors">
                                <?php if ( $r_svg ) : ?>
                                    <?php echo wp_kses_post( $r_svg ); ?>
                                <?php else : ?>
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-width="2.5" d="M13 10V3L4 14h7v7l9-11h-7z"/></svg>
                                <?php endif; ?>
                            </div>
                            <div class="flex-1 flex items-center justify-between">
                                <div>
                                    <h4 class="text-[15px] font-bold text-heading group-hover:text-primary transition-colors mb-1"><?php echo esc_html( $r_title ); ?></h4>
                                    <?php if ( $r_desc ) : ?>
                                        <p class="text-[12px] text-body opacity-80"><?php echo esc_html( $r_desc ); ?></p>
                                    <?php endif; ?>
                                </div>
                                <?php if ( $r_badge ) : ?>
                                    <span class="font-mono text-[11px] font-bold text-primary bg-primary/5 px-2 py-0.5 rounded"><?php echo esc_html( $r_badge ); ?></span>
                                <?php endif; ?>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>

                <?php if ( ! empty( $cta_link['url'] ) ) : ?>
                <div class="mt-8">
                    <a href="<?php echo esc_url( $cta_link['url'] ); ?>" class="inline-flex items-center justify-center w-full bg-primary hover:bg-primary-hover text-inverse px-8 py-4 rounded-button font-bold text-small uppercase tracking-wider shadow-lg shadow-primary/20 transition-all group" <?php if ( ! empty( $cta_link['target'] ) ) : ?>target="<?php echo esc_attr( $cta_link['target'] ); ?>"<?php endif; ?>>
                        <?php echo esc_html( ! empty( $cta_link['title'] ) ? $cta_link['title'] : 'Get an Instant Quote' ); ?>
                        <svg class="ml-2 w-4 h-4 transition-transform group-hover:translate-x-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
                    </a>
                </div>
                <?php endif; ?>
            </div>

        </div>
    </div>
</section>

<?php
// Set global state for next block
$GLOBALS['3dp_last_bg'] = $bg_color;
?>