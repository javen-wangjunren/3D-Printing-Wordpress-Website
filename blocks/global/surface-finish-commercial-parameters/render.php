<?php
/**
 * Block: Surface Finish Commercial Parameters
 * Path: blocks/global/surface-finish-commercial-parameters/render.php
 * Description: Displays procurement strategy guide with Value, Yield, and Cost metrics.
 * 
 * @package 3D_Printing
 */

// Prefix Support
$block = isset( $block ) ? $block : array();
$pfx   = isset( $block['prefix'] ) ? $block['prefix'] : '';
$clone_name = rtrim( $pfx, '_' );

// Data Retrieval
$title      = get_field_value( 'cp_title', $block, $clone_name, $pfx, 'Procurement <span class="text-primary">Strategy Guide</span>' );
$strategies = get_field_value( 'cp_strategies', $block, $clone_name, $pfx );

// Hardcoded Icons Configuration (Mapped by Index 0-2)
$icons = array(
    // 0: Value Addition (Lightning/Energy)
    0 => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>',
    // 1: Yield Assurance (Shield)
    1 => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>',
    // 2: Cost Efficiency (Currency/Coin)
    2 => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>',
);
?>

<section class="py-24 bg-[#f3f4f7]">
    <div class="max-w-container mx-auto px-container">
        
        <!-- Header -->
        <div class="mb-16">
            <h2 class="text-heading text-3xl md:text-4xl">
                <?php echo wp_kses_post( $title ); ?>
            </h2>
        </div>

        <?php if ( ! empty( $strategies ) ) : ?>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <?php foreach ( $strategies as $index => $strategy ) : 
                // Ensure index is within 0-2 range for icons
                $icon_svg = isset( $icons[$index] ) ? $icons[$index] : $icons[0];
                
                $s_title = isset( $strategy['title'] ) ? $strategy['title'] : '';
                $s_value = isset( $strategy['value'] ) ? $strategy['value'] : '';
                $s_desc  = isset( $strategy['description'] ) ? $strategy['description'] : '';

                // Check if this is the "Cost" card (Index 2) to apply specific formatting
                $is_cost_card = ( $index === 2 );
            ?>
                <div class="p-8 border border-border rounded-xl hover:border-primary hover:-translate-y-1 hover:shadow-lg transition-all duration-300 group flex flex-col bg-white">
                    
                    <!-- Icon & Label Row -->
                    <div class="flex items-center gap-4 mb-6">
                        <div class="w-10 h-10 rounded-lg bg-panel group-hover:bg-primary/10 flex items-center justify-center text-industrial/40 group-hover:text-primary transition-colors shrink-0">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <?php echo $icon_svg; // Auto-escaped SVG path ?>
                            </svg>
                        </div>
                        <h4 class="text-sm font-bold uppercase tracking-widest text-industrial/50 group-hover:text-primary/80 transition-colors"><?php echo esc_html( $s_title ); ?></h4>
                    </div>

                    <!-- Value -->
                    <div class="mb-4">
                        <?php if ( $is_cost_card ) : ?>
                            <!-- Cost Card Special Formatting ($$$) -->
                            <div class="flex items-center gap-1 font-mono text-2xl font-bold">
                                <span class="text-industrial group-hover:text-primary transition-colors"><?php echo esc_html( $s_value ); ?></span>
                                <span class="text-industrial/20">$$$</span>
                            </div>
                        <?php else : ?>
                            <!-- Standard Card Formatting -->
                            <span class="font-mono text-2xl font-bold text-industrial group-hover:text-primary transition-colors"><?php echo esc_html( $s_value ); ?></span>
                        <?php endif; ?>
                    </div>

                    <!-- Description -->
                    <p class="text-sm text-industrial/70 leading-relaxed">
                        <?php echo esc_html( $s_desc ); ?>
                    </p>
                </div>
            <?php endforeach; ?>
        </div>
        <?php endif; ?>

    </div>
</section>
