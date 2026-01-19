<?php
/**
 * Block Template: Mission & Vision
 * 
 * Path: blocks/global/mission/render.php
 * Description: Renders the Mission & Vision section with split-card layout.
 */

// 1. Data Retrieval
$header         = get_field('mission_header');
$bg_style       = get_field('background_style');
$mobile_hide    = get_field('mobile_hide_content');
$anchor_id      = get_field('anchor_id');

// 2. Class Logic
$section_classes = 'py-[96px] border-y border-border relative';

// Background
if ( $bg_style === 'grid' ) {
    $section_classes .= ' industrial-grid-bg';
} elseif ( $bg_style === 'white' ) {
    $section_classes .= ' bg-white';
} elseif ( $bg_style === 'gray' ) {
    $section_classes .= ' bg-[#F2F4F7]';
}

// Mobile Visibility
if ( $mobile_hide ) {
    $section_classes .= ' hidden lg:block';
}

// Anchor ID
$id_attr = $anchor_id ? 'id="' . esc_attr($anchor_id) . '"' : '';

?>

<section <?php echo $id_attr; ?> class="<?php echo esc_attr($section_classes); ?>">
    <div class="max-w-[1280px] mx-auto px-6">
        
        <?php if ( $header ) : ?>
        <div class="mb-20 text-center">
            <h2 class="text-[36px] font-bold text-heading tracking-[-0.5px] mb-4 inline-block relative">
                <?php echo esc_html( $header['prefix'] ); ?> <span class="text-primary"><?php echo esc_html( $header['highlight'] ); ?></span>
                <span class="absolute -bottom-4 left-1/2 -translate-x-1/2 w-12 h-1 bg-primary"></span>
            </h2>
            <?php if ( ! empty( $header['description'] ) ) : ?>
            <p class="text-[18px] text-body max-w-2xl mx-auto mt-8 font-sans">
                <?php echo esc_html( $header['description'] ); ?>
            </p>
            <?php endif; ?>
        </div>
        <?php endif; ?>

        <div class="space-y-24">
            
            <?php 
            if ( have_rows('mission_items') ) : 
                $i = 0;
                while ( have_rows('mission_items') ) : the_row(); 
                    $icon           = get_sub_field('icon');
                    $label          = get_sub_field('label');
                    $title          = get_sub_field('title');
                    $desc           = get_sub_field('description');
                    $image          = get_sub_field('image');
                    $mobile_image   = get_sub_field('mobile_image'); // Optional usage logic if needed
                    
                    // Layout Logic: Even = Image Left; Odd = Image Right
                    $is_odd = ($i % 2 !== 0);
                    $i++;
            ?>
            
            <div class="grid lg:grid-cols-2 gap-12 items-center group">
                
                <!-- Image Column -->
                <div class="relative rounded-card overflow-hidden border border-border shadow-xl shadow-primary/5 tech-overlay h-[400px] lg:h-[480px] <?php echo $is_odd ? 'lg:order-last' : ''; ?>">
                    <!-- Scanline Animation (CSS in style.css) -->
                    <div class="scanline" style="<?php echo $is_odd ? 'animation-delay: 2s;' : ''; ?>"></div>
                    
                    <?php if ( $image ) : ?>
                        <img src="<?php echo esc_url($image['url']); ?>" 
                             alt="<?php echo esc_attr($image['alt']); ?>" 
                             class="w-full h-full object-cover scale-105 group-hover:scale-100 transition-transform duration-700 grayscale hover:grayscale-0">
                    <?php endif; ?>

                    <!-- Corner Accents -->
                    <?php if ( $is_odd ) : ?>
                        <div class="absolute bottom-4 left-4 w-4 h-4 border-b border-l border-primary/50"></div>
                        <div class="absolute bottom-4 right-4 w-4 h-4 border-b border-r border-primary/50"></div>
                    <?php else : ?>
                        <div class="absolute top-4 left-4 w-4 h-4 border-t border-l border-primary/50"></div>
                        <div class="absolute top-4 right-4 w-4 h-4 border-t border-r border-primary/50"></div>
                    <?php endif; ?>
                </div>

                <!-- Content Column -->
                <div class="<?php echo $is_odd ? 'lg:pr-8' : 'lg:pl-8'; ?>">
                    
                    <!-- Label & Icon -->
                    <div class="flex items-center gap-4 mb-6">
                        <div class="w-12 h-12 rounded-[8px] bg-primary/10 flex items-center justify-center text-primary overflow-hidden">
                            <?php if ( $icon ) : ?>
                                <img src="<?php echo esc_url($icon['url']); ?>" alt="<?php echo esc_attr($icon['alt']); ?>" class="w-6 h-6">
                            <?php endif; ?>
                        </div>
                        <span class="font-mono text-[12px] font-bold text-primary uppercase tracking-widest">
                            <?php echo esc_html( $label ); ?>
                        </span>
                    </div>

                    <!-- Headline -->
                    <h3 class="text-[30px] font-bold text-heading mb-6 leading-tight">
                        <?php echo esc_html( $title ); ?>
                    </h3>

                    <!-- Description -->
                    <p class="text-[16px] text-body leading-relaxed mb-10">
                        <?php echo esc_html( $desc ); ?>
                    </p>
                    
                    <!-- Data Points (Stats) -->
                    <?php if ( have_rows('stats') ) : ?>
                    <div class="bg-white border-l-2 border-primary pl-6 py-4 grid grid-cols-2 gap-8">
                        <?php while ( have_rows('stats') ) : the_row(); 
                            $stat_label = get_sub_field('label');
                            $stat_value = get_sub_field('value');
                            $stat_style = get_sub_field('style');
                        ?>
                        <div>
                            <p class="font-mono text-[10px] text-body/60 uppercase font-bold mb-1">
                                <?php echo esc_html( $stat_label ); ?>
                            </p>
                            
                            <?php if ( $stat_style === 'highlight' ) : ?>
                                <p class="font-mono text-[12px] font-bold text-primary mt-2">
                                    <?php echo esc_html( $stat_value ); ?>
                                </p>
                            <?php else : ?>
                                <p class="font-mono text-[24px] font-bold text-heading">
                                    <?php echo esc_html( $stat_value ); ?>
                                </p>
                            <?php endif; ?>
                        </div>
                        <?php endwhile; ?>
                    </div>
                    <?php endif; ?>

                </div>
            </div>

            <?php 
                endwhile; 
            endif; 
            ?>

        </div>
    </div>
</section>
