<?php
/**
 * Block: Technical Compatibility (Surface Finish)
 * 
 * Description: Displays supported processes and verified materials for a surface finish.
 * 
 * Data Sources:
 * 1. Title: 'compat_title' (ACF Field in this block)
 * 2. Supported Processes: 'related_capabilities' (ACF Field on the Post Object)
 * 3. Verified Materials: 'compat_materials' (ACF Field in this block)
 * 
 * @package 3D_Printing
 */

// Prefix Support
$block = isset( $block ) ? $block : array();
$pfx   = isset( $block['prefix'] ) ? $block['prefix'] : '';
$clone_name = rtrim( $pfx, '_' );

$title     = get_field_value( 'compat_title', $block, $clone_name, $pfx, 'Technical <span class="text-primary">Compatibility</span>' );
$materials = get_field_value( 'compat_materials', $block, $clone_name, $pfx );

// Note: Supported Processes data is fetched from the Post Object itself (related_capabilities),
// not from the block/module fields.
$processes = get_field( 'related_capabilities', get_the_ID() );

// If both empty, maybe return? Or just render empty sections? 
// Design implies specific layout, so we render the structure.
?>

<section class="pt-[90px] pb-24 bg-[#f3f4f7]">
    <div class="max-w-container mx-auto px-container">
        
        <!-- Header -->
        <div class="mb-12">
            <h2 class="text-heading">
                <?php echo wp_kses_post( $title ); ?>
            </h2>
        </div>

        <div class="flex flex-col gap-16">
            
            <!-- Section 1: Supported Processes -->
            <?php if ( ! empty( $processes ) ) : ?>
            <div>
                <div class="flex items-center gap-4 mb-6 border-b border-border pb-4">
                    <div class="w-2 h-2 bg-primary rounded-full"></div>
                    <h4 class="text-heading">Supported Processes</h4>
                </div>
                
                <!-- Grid: Auto-fit for processes -->
                <div class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-6 gap-4">
                    <?php foreach ( $processes as $process ) : 
                        $p_id = is_object($process) ? $process->ID : $process;
                        $p_title = get_the_title($p_id);
                        $p_link = get_permalink($p_id);
                    ?>
                        <a href="<?php echo esc_url( $p_link ); ?>" 
                           class="flex items-center justify-between px-6 py-4 border border-border rounded-lg hover:border-primary hover:bg-panel hover:-translate-y-1 transition-all duration-300 group bg-white shadow-sm">
                            <span class="font-extrabold text-lg tracking-tight text-industrial" ><?php echo esc_html( $p_title ); ?></span>
                            <svg class="w-5 h-5 text-primary opacity-40 group-hover:opacity-100 group-hover:translate-x-1 transition-all" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"></path></svg>
                        </a>
                    <?php endforeach; ?>
                </div>
            </div>
            <?php endif; ?>

            <!-- Section 2: Verified Materials -->
            <?php if ( ! empty( $materials ) ) : ?>
            <div>
                <div class="flex items-center gap-4 mb-6 border-b border-border pb-4">
                    <div class="w-2 h-2 bg-primary rounded-full"></div>
                    <h4 class="text-heading">Verified Materials</h4>
                </div>

                <!-- Grid: 3 Columns on Desktop -->
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
                    <?php foreach ( $materials as $material ) : 
                        $m_id = is_object($material) ? $material->ID : $material;
                        $m_title = get_the_title($m_id);
                        $m_link = get_permalink($m_id);
                    ?>
                        <a href="<?php echo esc_url( $m_link ); ?>" 
                           class="flex items-center gap-4 pl-5 pr-4 py-3 border border-border rounded-lg hover:border-primary hover:bg-panel hover:-translate-y-1 transition-all duration-300 group bg-white shadow-sm">
                            
                            <!-- Icon Box -->
                            <div class="w-10 h-10 rounded-md bg-panel group-hover:bg-primary/10 flex items-center justify-center transition-colors shrink-0">
                                <svg class="w-5 h-5 text-industrial/30 group-hover:text-primary transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.384-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z"></path></svg>
                            </div>

                            <!-- Material Name -->
                            <span class="text-[15px] font-bold text-industrial group-hover:text-primary transition-colors"><?php echo esc_html( $m_title ); ?></span>
                            
                            <!-- Arrow (Auto margin left to push to end) -->
                            <div class="ml-auto opacity-0 group-hover:opacity-100 transition-opacity">
                                <svg class="w-4 h-4 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                            </div>
                        </a>
                    <?php endforeach; ?>
                </div>
            </div>
            <?php endif; ?>

        </div>
    </div>
</section>
