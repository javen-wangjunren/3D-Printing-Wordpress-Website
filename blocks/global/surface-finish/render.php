<?php
/**
 * Surface Finish Block Render
 * Path: blocks/global/surface-finish/render.php
 */

// Prefix Support
$pfx = isset($block['prefix']) ? $block['prefix'] : '';
$clone_name = rtrim($pfx, '_'); // Fix: Define clone_name
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

// Fields
$title = get_field_value('surface_finish_title', $block, $clone_name, $pfx, '');
$items = get_field_value('sf_items', $block, $clone_name, $pfx, array());

?>
<section id="<?php echo esc_attr( $anchor_id ); ?>" class="<?php echo esc_attr( $class_name ); ?>" style="background-color: <?php echo esc_attr($bg_color); ?>;" x-data="{ activeTab: 0 }">
    <div class="max-w-container mx-auto px-container">
        <?php if ($title): ?>
            <h2 class="text-heading"><?php echo esc_html($title); ?></h2>
        <?php endif; ?>
        
        <?php if ( ! empty( $items ) ) : ?>
            <div class="flex flex-col lg:flex-row gap-8 lg:gap-16">
                <!-- Side Tab Navigation -->
                <!-- Width locked to 160px for desktop as per design guidelines -->
                <div class="w-full lg:w-[160px] flex-shrink-0 flex lg:flex-col gap-3 overflow-x-auto pb-4 lg:pb-0 hide-scrollbar" role="tablist">
                    <?php foreach ($items as $index => $item): ?>
                        <button 
                            @click="activeTab = <?php echo $index; ?>"
                            :class="activeTab === <?php echo $index; ?> ? 'border-[#0047AB] bg-white text-[#0047AB] font-bold shadow-sm' : 'border-transparent text-gray-500 hover:text-gray-900 hover:bg-gray-50'"
                            class="relative flex-shrink-0 lg:w-full text-left px-4 py-3 border-[3px] rounded-lg text-sm transition-all duration-200 focus:outline-none"
                            role="tab"
                            :aria-selected="activeTab === <?php echo $index; ?>"
                        >
                            <span class="block truncate"><?php echo esc_html($item['name']); ?></span>
                        </button>
                    <?php endforeach; ?>
                </div>

                <!-- Content Area -->
                <div class="flex-1 min-h-[400px]">
                    <?php foreach ($items as $index => $item): 
                        $specs = isset($item['specs']) ? $item['specs'] : array();
                        $img_id = isset($item['image']) ? $item['image'] : 0;
                        $img_url = $img_id ? wp_get_attachment_image_url($img_id, 'large') : '';
                        $teaser = isset($item['teaser']) ? $item['teaser'] : '';
                        $quote_link = isset($item['quote_link']) ? $item['quote_link'] : null;
                    ?>
                        <div 
                            x-show="activeTab === <?php echo $index; ?>"
                            x-transition:enter="transition ease-out duration-300"
                            x-transition:enter-start="opacity-0 translate-y-4"
                            x-transition:enter-end="opacity-100 translate-y-0"
                            class="grid lg:grid-cols-12 gap-8 lg:gap-12 items-center"
                            role="tabpanel"
                            style="display: none;" 
                            :style="activeTab === <?php echo $index; ?> ? '' : 'display: none;'"
                        >
                            <!-- Left: Info Flow (L-Shape) - Spans 5 columns -->
                            <div class="lg:col-span-5 flex flex-col justify-center h-full order-2 lg:order-1">
                                <h3 class="text-h3 font-bold text-heading tracking-tight mb-4">
                                    <?php echo esc_html($item['name']); ?>
                                </h3>
                                
                                <?php if ($teaser): ?>
                                    <div class="prose text-body text-sm mb-8 leading-relaxed">
                                        <?php echo wp_kses_post($teaser); ?>
                                    </div>
                                <?php endif; ?>

                                <!-- 1x4 Parameter Matrix -->
                                <?php if (!empty($specs)): ?>
                                    <div class="grid grid-cols-2 gap-3 mb-8">
                                        <?php foreach ($specs as $spec): ?>
                                            <div class="bg-gray-50 p-3 rounded-lg border border-gray-100 group hover:border-gray-200 transition-colors">
                                                <div class="text-[10px] text-gray-500 uppercase tracking-wider mb-1 font-medium">
                                                    <?php echo esc_html($spec['label']); ?>
                                                </div>
                                                <div class="font-mono text-sm font-semibold text-gray-900 group-hover:text-[#0047AB] transition-colors">
                                                    <?php echo esc_html($spec['value']); ?>
                                                </div>
                                            </div>
                                        <?php endforeach; ?>
                                    </div>
                                <?php endif; ?>

                                <!-- Conversion Button -->
                                <?php if ($quote_link && isset($quote_link['url'])): ?>
                                    <a href="<?php echo esc_url($quote_link['url']); ?>" target="<?php echo esc_attr($quote_link['target'] ? $quote_link['target'] : '_self'); ?>" class="inline-flex items-center justify-center rounded-md bg-[#0047AB] px-6 py-3 text-sm font-semibold text-white shadow-sm hover:bg-[#003580] focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-[#0047AB] transition-all w-fit">
                                        <?php echo esc_html($quote_link['title']); ?>
                                        <svg class="ml-2 -mr-1 h-4 w-4" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5L21 12m0 0l-7.5 7.5M21 12H3" />
                                        </svg>
                                    </a>
                                <?php endif; ?>
                            </div>

                            <!-- Right: Visual Sample - Spans 7 columns -->
                            <div class="lg:col-span-7 relative order-1 lg:order-2">
                                <div class="aspect-[4/3] w-full rounded-2xl overflow-hidden bg-gray-100 relative shadow-sm border border-gray-100">
                                    <?php if ($img_url): ?>
                                        <img loading="lazy" src="<?php echo esc_url($img_url); ?>" alt="<?php echo esc_attr($item['name']); ?>" class="absolute inset-0 w-full h-full object-cover" sizes="(min-width: 1024px) 800px, 100vw">                                    <?php else: ?>
                                        <div class="absolute inset-0 flex items-center justify-center text-gray-400">
                                            <span class="font-mono text-xs">NO IMAGE</span>
                                        </div>
                                    <?php endif; ?>
                                    
                                    <!-- Optional: Technology Tags Overlay -->
                                    <?php if (!empty($item['tech_tags'])): ?>
                                        <div class="absolute top-4 left-4 flex flex-wrap gap-2">
                                            <?php foreach ($item['tech_tags'] as $tag): ?>
                                                <span class="inline-flex items-center rounded-full bg-white/90 backdrop-blur px-2.5 py-0.5 text-xs font-medium text-gray-800 shadow-sm border border-gray-200">
                                                    <?php echo esc_html(strtoupper($tag)); ?>
                                                </span>
                                            <?php endforeach; ?>
                                        </div>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        <?php endif; ?>
    </div>
</section>
