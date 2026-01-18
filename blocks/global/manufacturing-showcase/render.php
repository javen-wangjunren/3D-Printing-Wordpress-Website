<?php
$anchor_id   = (string) get_field('manufacturing_showcase_anchor_id') ?: '';
$custom_class = (string) get_field('manufacturing_showcase_css_class') ?: '';
$title       = (string) get_field('manufacturing_showcase_title') ?: '';
$subtitle    = (string) get_field('manufacturing_showcase_subtitle') ?: '';
$layout_mode = (string) get_field('manufacturing_showcase_layout_mode') ?: 'slider';
$items_per   = (int) get_field('manufacturing_showcase_items_per_view');
if ( ! $items_per ) { $items_per = 3; }
$show_nav    = (bool) get_field('manufacturing_showcase_show_nav');
$compact     = (bool) get_field('manufacturing_showcase_mobile_compact_mode');

$lg_card_w = $items_per === 2 ? 'lg:w-[calc(50%-16px)]' : ( $items_per === 4 ? 'lg:w-[calc(25%-16px)]' : 'lg:w-[calc(33.333%-16px)]' );
$mb_card_w = $compact ? 'w-[85%]' : 'w-full';

if ( ! have_rows('manufacturing_showcase_items') ) { return; }
?>

<div id="<?php echo $anchor_id ? esc_attr($anchor_id) : ''; ?>" class="bg-white overflow-hidden">
    <div class="mx-auto max-w-container px-container py-section-y-small lg:py-section-y <?php echo esc_attr($custom_class); ?>">
        <?php if ( $title || $subtitle ) : ?>
            <div class="text-center mb-10 lg:mb-14">
                <?php if ( $title ) : ?>
                    <h2 class="text-h2 font-semibold text-heading tracking-[-0.5px] mb-3"><?php echo esc_html($title); ?></h2>
                <?php endif; ?>
                <?php if ( $subtitle ) : ?>
                    <p class="text-body max-w-2xl mx-auto text-small opacity-90 leading-snug"><?php echo esc_html($subtitle); ?></p>
                <?php endif; ?>
            </div>
        <?php endif; ?>

        <?php if ( $layout_mode === 'slider' ) : ?>
            <div x-data="{scrollSlider(dir){const t=this.$refs.track;const amt=t.offsetWidth*0.8;t.scrollBy({left:dir*amt,behavior:'smooth'});}}" class="relative">
                <?php if ( $show_nav ) : ?>
                    <button @click="scrollSlider(-1)" class="hidden lg:flex absolute left-[-24px] top-1/3 z-20 w-12 h-12 bg-white border border-border rounded-full items-center justify-center text-heading hover:bg-primary hover:text-inverse transition-colors">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-width="2.5" d="M15 18l-6-6 6-6"/></svg>
                    </button>
                    <button @click="scrollSlider(1)" class="hidden lg:flex absolute right-[-24px] top-1/3 z-20 w-12 h-12 bg-white border border-border rounded-full items-center justify-center text-heading hover:bg-primary hover:text-inverse transition-colors">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-width="2.5" d="M9 18l6-6-6-6"/></svg>
                    </button>
                <?php endif; ?>

                <div x-ref="track" class="flex gap-6 overflow-x-auto no-scrollbar scroll-smooth snap-x snap-mandatory pb-8">
                    <?php while ( have_rows('manufacturing_showcase_items') ) : the_row(); ?>
                        <?php
                        $img_id   = (int) get_sub_field('item_image');
                        $mob_id   = (int) get_sub_field('item_mobile_image');
                        $title_i  = (string) get_sub_field('item_title') ?: '';
                        $badge_i  = (string) get_sub_field('item_badge') ?: '';
                        $sub_i    = (string) get_sub_field('item_subtitle') ?: '';
                        $desc_i   = (string) get_sub_field('item_description') ?: '';
                        $link_i   = get_sub_field('item_link');
                        $link_i   = is_array($link_i) ? $link_i : array();
                        $src_id   = $img_id ?: $mob_id;
                        $src_url  = $src_id ? (string) wp_get_attachment_image_url( $src_id, 'large' ) : '';
                        $alt_text = $title_i;
                        ?>
                        <div class="flex-none <?php echo esc_attr($mb_card_w); ?> <?php echo esc_attr($lg_card_w); ?> snap-start">
                            <div class="relative aspect-[4/3] rounded-card overflow-hidden border border-border bg-bg-section">
                                <?php if ( $src_url ) : ?>
                                    <img src="<?php echo esc_attr($src_url); ?>" alt="<?php echo esc_attr($alt_text ?: $title_i); ?>" class="w-full h-full object-cover" />
                                <?php endif; ?>
                                <?php if ( $badge_i ) : ?>
                                    <div class="absolute top-4 left-4">
                                        <span class="font-mono text-[10px] font-bold bg-white/95 px-2.5 py-1 rounded text-primary border border-primary/30 tracking-tight"><?php echo esc_html($badge_i); ?></span>
                                    </div>
                                <?php endif; ?>
                            </div>
                            <div class="mt-6 text-center lg:text-left">
                                <?php if ( $title_i ) : ?>
                                    <h4 class="text-[18px] lg:text-[20px] font-semibold text-heading mb-1 tracking-[-0.02em]"><?php echo esc_html($title_i); ?></h4>
                                <?php endif; ?>
                                <?php if ( $sub_i ) : ?>
                                    <div class="text-[12px] text-body opacity-80 mb-1"><?php echo esc_html($sub_i); ?></div>
                                <?php endif; ?>
                                <?php if ( $desc_i ) : ?>
                                    <p class="text-[13px] lg:text-[14px] leading-relaxed text-body opacity-90"><?php echo esc_html( strip_tags( $desc_i ) ); ?></p>
                                <?php endif; ?>
                                <?php if ( isset($link_i['url'], $link_i['title']) && $link_i['url'] && $link_i['title'] ) : ?>
                                    <div class="mt-3">
                                        <a href="<?php echo esc_attr((string) $link_i['url']); ?>" <?php echo isset($link_i['target']) && $link_i['target'] ? 'target="' . esc_attr((string) $link_i['target']) . '"' : ''; ?> class="text-primary text-[12px] font-semibold"><?php echo esc_html((string) $link_i['title']); ?></a>
                                    </div>
                                <?php endif; ?>
                            </div>
                        </div>
                    <?php endwhile; ?>
                </div>
            </div>
        <?php else : ?>
            <div class="grid grid-cols-1 lg:grid-cols-<?php echo esc_attr((string) $items_per); ?> gap-6">
                <?php while ( have_rows('manufacturing_showcase_items') ) : the_row(); ?>
                    <?php
                    $img_id   = (int) get_sub_field('item_image');
                    $title_i  = (string) get_sub_field('item_title') ?: '';
                    $badge_i  = (string) get_sub_field('item_badge') ?: '';
                    $sub_i    = (string) get_sub_field('item_subtitle') ?: '';
                    $desc_i   = (string) get_sub_field('item_description') ?: '';
                    $link_i   = get_sub_field('item_link');
                    $link_i   = is_array($link_i) ? $link_i : array();
                    $src_url  = $img_id ? (string) wp_get_attachment_image_url( $img_id, 'large' ) : '';
                    $alt_text = $title_i;
                    ?>
                    <div>
                        <div class="relative aspect-[4/3] rounded-card overflow-hidden border border-border bg-bg-section">
                            <?php if ( $src_url ) : ?>
                                <img src="<?php echo esc_attr($src_url); ?>" alt="<?php echo esc_attr($alt_text ?: $title_i); ?>" class="w-full h-full object-cover" />
                            <?php endif; ?>
                            <?php if ( $badge_i ) : ?>
                                <div class="absolute top-4 left-4">
                                    <span class="font-mono text-[10px] font-bold bg-white/95 px-2.5 py-1 rounded text-primary border border-primary/30 tracking-tight"><?php echo esc_html($badge_i); ?></span>
                                </div>
                            <?php endif; ?>
                        </div>
                        <div class="mt-6 text-center lg:text-left">
                            <?php if ( $title_i ) : ?>
                                <h4 class="text-[18px] lg:text-[20px] font-semibold text-heading mb-1 tracking-[-0.02em]"><?php echo esc_html($title_i); ?></h4>
                            <?php endif; ?>
                            <?php if ( $sub_i ) : ?>
                                <div class="text-[12px] text-body opacity-80 mb-1"><?php echo esc_html($sub_i); ?></div>
                            <?php endif; ?>
                            <?php if ( $desc_i ) : ?>
                                <p class="text-[13px] lg:text-[14px] leading-relaxed text-body opacity-90"><?php echo esc_html( strip_tags( $desc_i ) ); ?></p>
                            <?php endif; ?>
                            <?php if ( isset($link_i['url'], $link_i['title']) && $link_i['url'] && $link_i['title'] ) : ?>
                                <div class="mt-3">
                                    <a href="<?php echo esc_attr((string) $link_i['url']); ?>" <?php echo isset($link_i['target']) && $link_i['target'] ? 'target="' . esc_attr((string) $link_i['target']) . '"' : ''; ?> class="text-primary text-[12px] font-semibold"><?php echo esc_html((string) $link_i['title']); ?></a>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                <?php endwhile; ?>
            </div>
        <?php endif; ?>
    </div>
</div>
