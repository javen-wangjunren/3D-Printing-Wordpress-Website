<?php
/**
 * Module: Team (Leadership Architects)
 * Location: blocks/global/team/render.php
 * Description: Frontend render template for the Team module.
 * 
 * Note: This template is used by including it in page-about.php or via get_template_part().
 * It relies on ACF fields being available for the current post.
 */
// Prefix Support
$pfx = isset($block['prefix']) ? $block['prefix'] : '';


// Retrieve fields
$header     = get_field($pfx . 'team_header');
$members    = get_field($pfx . 'team_members');
$bg_style   = get_field($pfx . 'background_style');
$section_id = get_field($pfx . 'section_id');
$mobile_hide = get_field($pfx . 'mobile_hide_content');

// Defaults
$title     = $header['title'] ?? 'Leadership';
$highlight = $header['highlight'] ?? 'Architects';
$desc      = $header['description'] ?? '';

// Background Class
$section_classes = 'py-16 lg:py-24';
if ( $mobile_hide ) {
    $section_classes .= ' hidden md:block';
}

if ( $bg_style === 'industrial' ) {
    $section_classes .= ' industrial-grid-bg';
} else {
    $section_classes .= ' bg-white';
}

// ID Attribute
$id_attr = $section_id ? 'id="' . esc_attr($section_id) . '"' : '';

?>
<section <?php echo $id_attr; ?> class="<?php echo esc_attr($section_classes); ?>">
    <div class="max-w-[1280px] mx-auto px-6">
        
        <!-- Header -->
        <div class="mb-12 lg:mb-16 flex flex-col lg:flex-row justify-between items-end gap-6">
            <div class="max-w-2xl">
                <h2 class="industrial-h2 text-[32px] lg:text-[40px] font-bold text-heading mb-4 leading-tight">
                    <?php echo esc_html($title); ?> 
                    <?php if ( $highlight ) : ?>
                        <span class="text-primary"><?php echo esc_html($highlight); ?></span>
                    <?php endif; ?>
                </h2>
                <?php if ( $desc ) : ?>
                    <p class="text-[16px] lg:text-[18px] text-body opacity-90 leading-relaxed">
                        <?php echo esc_html($desc); ?>
                    </p>
                <?php endif; ?>
            </div>
        </div>

        <!-- Grid -->
        <?php if ( $members ) : ?>
            <div class="grid grid-cols-2 md:grid-cols-2 lg:grid-cols-3 gap-3 md:gap-6 lg:gap-8">
                <?php foreach ( $members as $member ) : 
                    $img_id = $member['image'];
                    $name = $member['name'];
                    $role = $member['role'];
                    $exp = $member['experience_years'];
                    $linkedin = $member['linkedin'];
                ?>
                    <!-- Card -->
                    <div class="team-card group">
                        <!-- Image Container -->
                        <div class="relative aspect-[4/5] bg-bg-subtle overflow-hidden">
                            <?php 
                            if ( $img_id ) {
                                echo wp_get_attachment_image($img_id, 'full', false, array('class' => 'w-full h-full object-cover')); 
                            } else {
                                // Fallback placeholder
                                echo '<div class="w-full h-full bg-gray-200 flex items-center justify-center text-gray-400">No Image</div>';
                            }
                            ?>
                            
                            <!-- Floating Data Badge (Static) -->
                            <?php if ( $exp ) : ?>
                                <div class="absolute bottom-2 right-2 md:bottom-4 md:right-4 z-20 bg-white/95 backdrop-blur-sm px-2 py-1 md:px-3 md:py-1.5 rounded-tag border border-border/50 flex items-center shadow-sm">
                                    <div class="font-mono text-[10px] font-bold text-heading leading-none">
                                        <span class="text-primary block text-[8px] md:text-[9px] mb-0.5 opacity-80">EXPERIENCE</span>
                                        <span class="text-[13px] md:text-[16px] mono-stat"><?php echo esc_html($exp); ?></span><span class="text-[9px] md:text-[10px] opacity-60 ml-0.5">YRS</span>
                                    </div>
                                </div>
                            <?php endif; ?>
                        </div>

                        <!-- Content (No Border Top) -->
                        <div class="p-3 md:p-5 lg:p-6 bg-white">
                            <h3 class="text-[15px] md:text-[20px] font-bold text-heading leading-tight mb-1"><?php echo esc_html($name); ?></h3>
                            <div class="flex items-center justify-between mt-1 md:mt-2">
                                <p class="text-[9px] md:text-[11px] font-mono text-body uppercase tracking-widest font-bold truncate pr-2"><?php echo esc_html($role); ?></p>
                                <!-- Social Icon (Always Visible) -->
                                <?php if ( $linkedin ) : ?>
                                    <a href="<?php echo esc_url($linkedin); ?>" target="_blank" class="text-primary hover:text-primary-hover transition-colors flex-shrink-0" aria-label="LinkedIn">
                                        <svg class="w-4 h-4 md:w-5 md:h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M19 0h-14c-2.761 0-5 2.239-5 5v14c0 2.761 2.239 5 5 5h14c2.762 0 5-2.239 5-5v-14c0-2.761-2.238-5-5-5zm-11 19h-3v-11h3v11zm-1.5-12.268c-.966 0-1.75-.79-1.75-1.764s.784-1.764 1.75-1.764 1.75.79 1.75 1.764-.783 1.764-1.75 1.764zm13.5 12.268h-3v-5.604c0-3.368-4-3.113-4 0v5.604h-3v-11h3v1.765c1.396-2.586 7-2.777 7 2.476v6.759z"/></svg>
                                    </a>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
        
    </div>
</section>
