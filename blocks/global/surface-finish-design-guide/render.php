<?php
/**
 * Block: Surface Finish Design Guide
 * Path: blocks/global/surface-finish-design-guide/render.php
 * Description: Displays a list of DFM guides for surface finishing, comparing best and bad practices.
 * 
 * @package 3D_Printing
 */

// Prefix Support
$block = isset( $block ) ? $block : array();
$pfx   = isset( $block['prefix'] ) ? $block['prefix'] : '';
$clone_name = rtrim( $pfx, '_' );

// Data Retrieval
$title       = get_field_value( 'sfdg_title', $block, $clone_name, $pfx, 'Post-Processing <span class="text-primary">DFM Guide</span>' );
$description = get_field_value( 'sfdg_description', $block, $clone_name, $pfx );
$pro_tip     = get_field_value( 'sfdg_pro_tip', $block, $clone_name, $pfx );
$guides      = get_field_value( 'sfdg_guides', $block, $clone_name, $pfx );

/**
 * Helper: Highlight values in brackets [ 1.2mm ]
 */
function _3dp_sfdg_highlight_value( $text, $type = 'positive' ) {
    if ( empty( $text ) ) return '';
    
    $color_class = ( $type === 'positive' ) 
        ? 'font-mono text-primary font-bold bg-primary/5 px-1 rounded' 
        : 'font-mono text-rose-600 font-bold bg-rose-50 px-1 rounded';

    return preg_replace( '/\[(.*?)\]/', '<span class="' . $color_class . '">$1</span>', $text );
}
?>

<section class="py-24 bg-white">
    <div class="max-w-container mx-auto px-container">
        
        <!-- Header -->
        <div class="flex flex-col md:flex-row md:items-end justify-between mb-16 gap-6 border-b border-border pb-8">
            <div>
                <h2 class="text-heading">
                    <?php echo wp_kses_post( $title ); ?>
                </h2>
            </div>
            <?php if ( $description ) : ?>
            <p class="text-industrial/60 max-w-md text-sm leading-relaxed">
                <?php echo esc_html( $description ); ?>
            </p>
            <?php endif; ?>
        </div>

        <!-- Grid Layout -->
        <?php if ( ! empty( $guides ) ) : ?>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
            <?php foreach ( $guides as $index => $guide ) : 
                $guide_id = str_pad( $index + 1, 2, '0', STR_PAD_LEFT );
                $guide_title = isset( $guide['guide_title'] ) ? $guide['guide_title'] : '';
                
                $best = isset( $guide['best_practice'] ) ? $guide['best_practice'] : array();
                $bad  = isset( $guide['bad_practice'] ) ? $guide['bad_practice'] : array();
            ?>
                <div class="group relative bg-white border border-border rounded-xl p-8 hover:border-primary transition-all duration-300 hover:shadow-lg hover:-translate-y-1">
                    
                    <!-- Card Header -->
                    <div class="flex items-center justify-between mb-8 pb-4 border-b border-border border-dashed">
                        <h3 class="text-heading text-xl"><?php echo esc_html( $guide_title ); ?></h3>
                        <span class="font-mono text-primary/40 text-sm font-bold tracking-widest"><?php echo esc_html( $guide_id ); ?></span>
                    </div>

                    <!-- Content Stack -->
                    <div class="space-y-8">
                        
                        <!-- Positive (Do) -->
                        <?php if ( ! empty( $best['title'] ) || ! empty( $best['description'] ) ) : ?>
                        <div class="relative pl-6">
                            <!-- Indicator Line -->
                            <div class="absolute left-0 top-1 bottom-1 w-[3px] bg-emerald-500 rounded-full"></div>
                            
                            <div class="flex items-start justify-between mb-1">
                                <h4 class="text-heading text-base"><?php echo esc_html( $best['title'] ); ?></h4>
                                <div class="w-6 h-6 rounded-full bg-emerald-50 flex items-center justify-center text-emerald-600 shrink-0">
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path></svg>
                                </div>
                            </div>
                            
                            <p class="text-sm text-industrial/70 leading-relaxed">
                                <?php echo wp_kses_post( _3dp_sfdg_highlight_value( $best['description'], 'positive' ) ); ?>
                            </p>
                        </div>
                        <?php endif; ?>

                        <!-- Negative (Don't) -->
                        <?php if ( ! empty( $bad['title'] ) || ! empty( $bad['description'] ) ) : ?>
                        <div class="relative pl-6 opacity-80 group-hover:opacity-100 transition-opacity">
                            <!-- Indicator Line -->
                            <div class="absolute left-0 top-1 bottom-1 w-[3px] bg-rose-500/30 group-hover:bg-rose-500 rounded-full transition-colors"></div>
                            
                            <div class="flex items-start justify-between mb-1">
                                <h4 class="text-heading text-base"><?php echo esc_html( $bad['title'] ); ?></h4>
                                <div class="w-6 h-6 rounded-full bg-rose-50 flex items-center justify-center text-rose-600 shrink-0">
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M6 18L18 6M6 6l12 12"></path></svg>
                                </div>
                            </div>
                            
                            <p class="text-sm text-industrial/70 leading-relaxed">
                                <?php echo wp_kses_post( _3dp_sfdg_highlight_value( $bad['description'], 'negative' ) ); ?>
                            </p>
                        </div>
                        <?php endif; ?>

                    </div>
                    
                </div>
            <?php endforeach; ?>
        </div>
        <?php endif; ?>

        <!-- Footer Note -->
        <?php if ( $pro_tip ) : ?>
        <div class="mt-12 flex items-center gap-3 p-4 bg-panel rounded-lg border border-border border-dashed">
            <svg class="w-5 h-5 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
            <p class="text-sm font-medium text-industrial/80">
                <span class="font-bold text-industrial">Pro Tip:</span> <?php echo esc_html( $pro_tip ); ?>
            </p>
        </div>
        <?php endif; ?>

    </div>
</section>
