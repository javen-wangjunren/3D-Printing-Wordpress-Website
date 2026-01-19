<?php
/**
 * Block: Timeline (Evolution Track)
 * 
 * Logic:
 * 1. Fetch ACF fields.
 * 2. Separate logic for 'Active' vs 'Past' milestones.
 * 3. Render Desktop (Horizontal) and Mobile (Vertical) layouts.
 */

$header = get_field('timeline_header');
$prefix = $header['prefix'] ?? 'Evolution and';
$highlight = $header['highlight'] ?? 'Milestones';
$desc = $header['description'] ?? '';

$bg_style = get_field('background_style') ?: 'grid';
$bg_class = ($bg_style === 'grid') ? 'industrial-grid-bg' : 'bg-white';
$anchor = get_field('anchor_id') ? 'id="' . esc_attr(get_field('anchor_id')) . '"' : '';

$items = get_field('timeline_items'); // Get all items as array
?>

<section <?php echo $anchor; ?> class="py-16 lg:py-24 <?php echo esc_attr($bg_class); ?> border-y border-border overflow-hidden" x-data="{ 
    scrollNext() { this.$refs.scrollContainer.scrollBy({ left: 340, behavior: 'smooth' }) },
    scrollPrev() { this.$refs.scrollContainer.scrollBy({ left: -340, behavior: 'smooth' }) }
}">
    <div class="max-w-[1280px] mx-auto px-6">
        
        <!-- Header -->
        <div class="mb-16 lg:mb-20 flex flex-col lg:flex-row items-start lg:items-end justify-between gap-6">
            <div class="max-w-2xl">
                <h2 class="text-[32px] lg:text-[40px] font-bold text-heading leading-tight mb-4 tracking-tight">
                    <?php echo esc_html($prefix); ?> <span class="text-primary"><?php echo esc_html($highlight); ?></span>
                </h2>
                <?php if ($desc): ?>
                <p class="text-[16px] lg:text-[18px] text-body opacity-90">
                    <?php echo esc_html($desc); ?>
                </p>
                <?php endif; ?>
            </div>
            
            <!-- Desktop Nav Controls -->
            <?php if ($items && count($items) > 3): // Only show nav if enough items ?>
            <div class="hidden lg:flex gap-3 mb-2">
                <button @click="scrollPrev()" class="w-12 h-12 rounded-full border border-border flex items-center justify-center text-heading hover:border-primary hover:text-primary transition-all">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-width="2.5" d="M15 19l-7-7 7-7"/></svg>
                </button>
                <button @click="scrollNext()" class="w-12 h-12 rounded-full border border-border flex items-center justify-center text-heading hover:border-primary hover:text-primary transition-all">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-width="2.5" d="M9 5l7 7-7 7"/></svg>
                </button>
            </div>
            <?php endif; ?>
        </div>

        <?php if ($items): ?>
        
        <!-- Desktop View (Horizontal) -->
        <div class="hidden lg:block relative">
            <div class="overflow-x-auto no-scrollbar pb-12" x-ref="scrollContainer">
                <div class="inline-flex min-w-full relative py-10">
                    
                    <!-- Connection Line -->
                    <div class="absolute top-[148px] left-0 right-0 h-[2px] bg-border z-0"></div>

                    <?php foreach ($items as $item): 
                        $is_active = $item['is_active'];
                        $year = $item['year'];
                        $title = $item['title'];
                        $description = $item['description'];
                        $metric_label = $item['metric_label'];
                        $metric_value = $item['metric_value'];
                    ?>
                    <div class="w-[340px] flex-shrink-0 px-5 relative z-10 group">
                        <!-- Year -->
                        <div class="mb-12">
                            <span class="font-mono text-[56px] font-bold leading-none transition-opacity <?php echo $is_active ? 'text-primary' : 'text-heading opacity-10 group-hover:opacity-100'; ?>">
                                <?php echo esc_html($year); ?>
                            </span>
                        </div>
                        
                        <!-- Dot -->
                        <div class="w-6 h-6 rounded-full border-4 border-white mb-10 transition-all <?php echo $is_active ? 'bg-primary shadow-[0_0_0_1px_#0047AB]' : 'bg-border group-hover:bg-primary shadow-[0_0_0_1px_#E4E7EC] group-hover:shadow-[0_0_0_1px_#0047AB]'; ?>"></div>
                        
                        <!-- Card -->
                        <div class="p-8 rounded-card transition-all min-h-[220px] flex flex-col justify-between <?php echo $is_active ? 'bg-white !border-[3px] !border-primary shadow-xl shadow-primary/5' : 'bg-bg-subtle border border-border hover:border-primary/50'; ?>">
                            <div>
                                <?php if ($is_active): ?>
                                <div class="flex justify-between items-start mb-3">
                                    <h4 class="text-[18px] font-bold text-heading"><?php echo esc_html($title); ?></h4>
                                    <span class="bg-primary text-white text-[8px] font-bold px-2 py-0.5 rounded-full uppercase tracking-widest">Active</span>
                                </div>
                                <?php else: ?>
                                <h4 class="text-[18px] font-bold text-heading mb-3"><?php echo esc_html($title); ?></h4>
                                <?php endif; ?>
                                
                                <p class="text-[14px] text-body leading-relaxed"><?php echo esc_html($description); ?></p>
                            </div>
                            
                            <?php if ($metric_value): ?>
                            <div class="mt-6 pt-4 border-t border-border/50">
                                <span class="font-mono text-[11px] font-bold text-primary uppercase">
                                    <?php echo esc_html($metric_label ?: 'Metric'); ?>: <span class="text-heading"><?php echo esc_html($metric_value); ?></span>
                                </span>
                            </div>
                            <?php endif; ?>
                        </div>
                    </div>
                    <?php endforeach; ?>

                </div>
            </div>
        </div>

        <!-- Mobile View (Vertical) -->
        <div class="lg:hidden relative">
            <div class="absolute left-0 top-0 bottom-0 w-[2px] bg-border z-0"></div>
            <div class="space-y-8 pl-8 relative z-10">
                <?php foreach ($items as $item): 
                    $is_active = $item['is_active'];
                ?>
                <div class="relative">
                    <!-- Dot -->
                    <div class="absolute -left-[39px] top-1.5 w-3.5 h-3.5 rounded-full border-4 border-white bg-primary shadow-[0_0_0_1px_#0047AB]"></div>
                    
                    <!-- Year -->
                    <span class="font-mono text-[20px] font-bold block mb-2 <?php echo $is_active ? 'text-primary' : 'text-heading opacity-50'; ?>">
                        <?php echo esc_html($item['year']); ?>
                    </span>
                    
                    <!-- Card -->
                    <div class="p-5 rounded-card <?php echo $is_active ? 'bg-white !border-[3px] !border-primary' : 'bg-bg-subtle border border-border'; ?>">
                        <h4 class="text-[16px] font-bold text-heading mb-2"><?php echo esc_html($item['title']); ?></h4>
                        <p class="text-[13px] text-body"><?php echo esc_html($item['description']); ?></p>
                        <?php if ($item['metric_value']): ?>
                         <div class="mt-3 pt-3 border-t border-border/50">
                            <span class="font-mono text-[10px] font-bold text-primary uppercase">
                                <?php echo esc_html($item['metric_label'] ?: 'Metric'); ?>: <span class="text-heading"><?php echo esc_html($item['metric_value']); ?></span>
                            </span>
                        </div>
                        <?php endif; ?>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
        </div>

        <?php endif; ?>

    </div>
</section>
