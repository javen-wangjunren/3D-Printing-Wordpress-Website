<?php
/**
 * Block: CTA
 * Path: blocks/global/cta/render.php
 * Description: Renders the CTA block with title, description, buttons and image.
 * 
 * @package 3D_Printing
 * @author Javen
 */
// Prefix Support
$pfx = isset($block['prefix']) ? $block['prefix'] : '';
$block = isset( $block ) ? $block : array();
$block_id = _3dp_get_safe_block_id( $block, 'cta' );

// 万能取数逻辑
// 确定克隆名
$clone_name = rtrim($pfx, '_');

// Init variables
$cta_title = '';
$cta_title_highlight = '';
$cta_description = '';
$cta_highlight_metric = '';
$cta_image = null;
$cta_button_group = array();
$cta_secondary_button = array();
$layout_reverse = false;
$bg_color = '#ffffff';

if ( empty( $pfx ) ) {
    // Global Settings Mode
    $global_data = get_field('global_cta', 'option');
    if ( $global_data ) {
        $cta_title = isset($global_data['cta_title']) ? (string)$global_data['cta_title'] : '';
        $cta_title_highlight = isset($global_data['cta_title_highlight']) ? (string)$global_data['cta_title_highlight'] : '';
        $cta_description = isset($global_data['cta_description']) ? (string)$global_data['cta_description'] : '';
        $cta_highlight_metric = isset($global_data['cta_highlight_metric']) ? (string)$global_data['cta_highlight_metric'] : '';
        $cta_image = isset($global_data['cta_image']) ? $global_data['cta_image'] : null;
        
        $cta_button_group = isset($global_data['cta_button_group']) ? $global_data['cta_button_group'] : array();
        $cta_secondary_button = isset($global_data['cta_secondary_button']) ? $global_data['cta_secondary_button'] : array();
        
        $layout_reverse = isset($global_data['layout_reverse']) ? (bool)$global_data['layout_reverse'] : false;
        $bg_color = isset($global_data['bg_color']) ? $global_data['bg_color'] : '#ffffff';
    }
} else {
    // Local/Page Builder Mode
    $cta_title             = (string) get_field_value('cta_title', $block, $clone_name, $pfx, '');
    $cta_title_highlight   = (string) get_field_value('cta_title_highlight', $block, $clone_name, $pfx, '');
    $cta_description       = (string) get_field_value('cta_description', $block, $clone_name, $pfx, '');
    $cta_highlight_metric  = (string) get_field_value('cta_highlight_metric', $block, $clone_name, $pfx, '');
    $cta_image             = get_field_value('cta_image', $block, $clone_name, $pfx, null);
    $cta_button_group      = get_field_value('cta_button_group', $block, $clone_name, $pfx, array());
    $cta_secondary_button  = get_field_value('cta_secondary_button', $block, $clone_name, $pfx, array());
    $layout_reverse        = (bool) get_field_value('layout_reverse', $block, $clone_name, $pfx, false);
    $bg_color              = get_field_value('bg_color', $block, $clone_name, $pfx, '#ffffff');
}

$primary_text   = isset( $cta_button_group['button_text'] ) ? (string) $cta_button_group['button_text'] : '';
$primary_url    = isset( $cta_button_group['button_link'] ) ? (string) $cta_button_group['button_link'] : '';
$primary_icon   = isset( $cta_button_group['button_icon'] ) ? (string) $cta_button_group['button_icon'] : 'none';
$has_primary    = $primary_text && $primary_url;

$secondary_text = isset( $cta_secondary_button['text'] ) ? (string) $cta_secondary_button['text'] : '';
$secondary_url  = isset( $cta_secondary_button['url'] ) ? (string) $cta_secondary_button['url'] : '';
$has_secondary  = $secondary_text && $secondary_url;

if ( ! $cta_title && ! $cta_description && ! $has_primary ) {
    return;
}

// --- Dynamic Spacing Logic ---
$prev_bg = isset($GLOBALS['3dp_last_bg']) ? $GLOBALS['3dp_last_bg'] : '';
$pt_class = ($prev_bg && $prev_bg === $bg_color) ? 'pt-0' : 'pt-16 lg:pt-24';
$pb_class = 'pb-16 lg:pb-24';

$text_order  = $layout_reverse ? 'order-2 lg:order-1' : 'order-1 lg:order-1';
$image_order = $layout_reverse ? 'order-1 lg:order-2' : 'order-2 lg:order-2';

$image_id  = 0;
$image_alt = '';
if ( is_array( $cta_image ) ) {
    $image_id  = isset( $cta_image['ID'] ) ? (int) $cta_image['ID'] : 0;
    $image_alt = isset( $cta_image['alt'] ) ? (string) $cta_image['alt'] : $cta_title;
}
?>

<section id="<?php echo esc_attr( $block_id ); ?>" class="cta-block w-full relative <?php echo esc_attr( $pt_class . ' ' . $pb_class ); ?>" style="background-color: <?php echo esc_attr( $bg_color ); ?>">
    <div class="mx-auto max-w-container px-6 lg:px-[64px]">
        <div class="relative bg-bg-section rounded-card overflow-hidden border border-border">
            <div class="grid lg:grid-cols-2 items-center gap-10 lg:gap-12 p-8 lg:p-16">
                <div class="z-10 text-center lg:text-left <?php echo esc_attr( $text_order ); ?>">
                    <?php if ( $cta_title || $cta_title_highlight ) : ?>
                        <h2 class="text-h2 font-bold text-heading tracking-tight mb-6 leading-tight">
                            <?php echo esc_html( $cta_title ); ?>
                            <?php if ( $cta_title_highlight ) : ?><br><span class="text-primary"><?php echo esc_html( $cta_title_highlight ); ?></span><?php endif; ?>
                        </h2>
                    <?php endif; ?>

                    <?php if ( $cta_description || $cta_highlight_metric ) : ?>
                        <p class="text-body text-small lg:text-body max-w-lg mx-auto lg:mx-0">
                            <?php if ( $cta_description ) : ?>
                                <?php echo nl2br( esc_html( $cta_description ) ); ?>
                            <?php endif; ?>
                            <?php if ( $cta_highlight_metric ) : ?>
                                <?php if ( $cta_description ) : ?>&nbsp;<?php endif; ?>
                                <span class="font-mono text-primary font-bold"><?php echo esc_html( $cta_highlight_metric ); ?></span>
                            <?php endif; ?>
                        </p>
                    <?php endif; ?>

                    <?php if ( $has_primary || $has_secondary ) : ?>
                        <div class="flex flex-wrap justify-center lg:justify-start gap-4 mt-5">
                            <?php if ( $has_primary ) : ?>
                                <a href="<?php echo esc_url( $primary_url ); ?>" class="bg-primary hover:bg-primary-hover text-inverse px-8 py-4 rounded-button font-bold text-small inline-flex items-center gap-2 transition-all shadow-lg shadow-primary/20 group">
                                    <?php if ( $primary_icon !== 'none' ) : ?>
                                        <?php if ( $primary_icon === 'arrow-right' ) : ?>
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
                                        <?php elseif ( $primary_icon === 'download' ) : ?>
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"/></svg>
                                        <?php elseif ( $primary_icon === 'external-link' ) : ?>
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/></svg>
                                        <?php elseif ( $primary_icon === 'envelope' ) : ?>
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4h16v16H4z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 8l8 5 8-5"/></svg>
                                        <?php elseif ( $primary_icon === 'phone' ) : ?>
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3l2 5-2 1a11 11 0 005 5l1-2 5 2v3a2 2 0 01-2 2h-1C9.82 19.76 4.24 14.18 3 7V5z"/></svg>
                                        <?php endif; ?>
                                    <?php endif; ?>
                                    <?php echo esc_html( $primary_text ); ?>
                                </a>
                            <?php endif; ?>

                            <?php if ( $has_secondary ) : ?>
                                <a href="<?php echo esc_url( $secondary_url ); ?>" class="bg-white border-[3px] border-border text-heading px-8 py-4 rounded-button font-bold text-small hover:border-primary transition-all">
                                    <?php echo esc_html( $secondary_text ); ?>
                                </a>
                            <?php endif; ?>
                        </div>
                    <?php endif; ?>
                </div>

                <div class="hidden lg:block relative h-full <?php echo esc_attr( $image_order ); ?>">
                    <?php if ( $image_id ) : ?>
                        <?php echo wp_get_attachment_image( $image_id, 'large', false, array( 'alt' => esc_attr( $image_alt ), 'class' => 'w-full h-full object-cover rounded-card opacity-80 mix-blend-multiply transition-transform duration-700 hover:scale-105', 'loading' => 'lazy' ) ); ?>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</section>

<?php
// Set global state for next block
$GLOBALS['3dp_last_bg'] = $bg_color;
?>