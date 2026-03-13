<?php
/**
 * Block: Surface Finish Comparison Table
 * 
 * Description: 
 * A dynamic table comparing all available Surface Finishes.
 * Features tabs filtering by Material (Taxonomy) and displays Capabilities, Lead Time, and Cost.
 * 
 * Data Sources:
 * - Page Options: Title, Description
 * - CPT (surface-finish): All row data
 * 
 * @package 3D_Printing
 */

// 1. Get Section Configuration (From Page Fields)
// --------------------------------------------------
$title = get_field('asf_table_title');
$desc  = get_field('asf_table_desc');

// Fallbacks
if ( empty($title) ) $title = 'Surface <span class="text-primary">Finishing</span>';
if ( empty($desc) )  $desc  = 'Explore our range of post-processing options to achieve the perfect functional and aesthetic requirements for your parts.';

// 2. Query Data (CPT: surface-finish)
// --------------------------------------------------
$args = array(
    'post_type'      => 'surface-finish',
    'posts_per_page' => -1,
    'post_status'    => 'publish',
    'orderby'        => 'menu_order', // Allow manual sorting
    'order'          => 'ASC',
);

$query = new WP_Query( $args );
$finishes = array();
$all_materials = array(); // For collecting tabs

if ( $query->have_posts() ) {
    while ( $query->have_posts() ) {
        $query->the_post();
        $id = get_the_ID();

        // A. Image (Clone: sf_hero -> hero_image)
        $img_id = get_field('sf_hero_hero_image');
        $img_url = $img_id ? wp_get_attachment_image_url($img_id, 'medium') : 'https://placehold.co/200x200?text=No+Image';

        // B. Description (Module: sf_table_desc)
        $short_desc = get_field('sf_table_desc');
        if ( empty($short_desc) ) {
            // Fallback to excerpt or first 15 words of content
            $short_desc = wp_trim_words( get_the_excerpt(), 15 );
        }

        // C. Materials (Taxonomy: material_type)
        $materials = array();
        $terms = get_the_terms( $id, 'material_type' );
        if ( ! empty($terms) && ! is_wp_error($terms) ) {
            foreach ( $terms as $term ) {
                $materials[] = $term->name;
                // Add to global tabs list (uppercase for consistency)
                $all_materials[ $term->slug ] = strtoupper( $term->name );
            }
        }

        // D. Capabilities (Relationship: related_capabilities)
        $caps = array();
        $related_caps = get_field('related_capabilities');
        if ( $related_caps ) {
            foreach ( $related_caps as $cap ) {
                $caps[] = array(
                    'name' => $cap->post_title,
                    'url'  => get_permalink($cap->ID)
                );
            }
        }

        // E. Commercial (Lead Time & Price)
        $lead_time = get_field('sf_lead_time') ?: 'N/A';
        $price_level = get_field('sf_price_level') ?: '1';
        
        // Generate Price HTML ($$$)
        $price_html = '';
        switch ($price_level) {
            case '1': $price_html = '$<span class=\'text-industrial/10\'>$$</span>'; break;
            case '2': $price_html = '$$<span class=\'text-industrial/10\'>$</span>'; break;
            case '3': $price_html = '$$$'; break;
            default:  $price_html = '<span class=\'text-industrial/10\'>$$$</span>';
        }

        // F. Build Data Object
        $finishes[] = array(
            'name'      => get_the_title(),
            'desc'      => $short_desc,
            'img'       => $img_url,
            'materials' => $materials, // Array of strings e.g. ['Plastic', 'Metal']
            'caps'      => $caps,      // Array of strings e.g. ['SLS', 'MJF']
            'leadTime'  => '[' . $lead_time . ']',
            'priceHtml' => $price_html,
            'link'      => get_permalink(), // For reveal arrow click
        );
    }
    wp_reset_postdata();
}

// 3. Process Tabs
// --------------------------------------------------
// Convert materials map to array for Alpine x-for
$tabs = array('ALL'); 
// Sort materials alphabetically if needed, or keep retrieval order
asort($all_materials);
foreach ($all_materials as $name) {
    $tabs[] = $name;
}

// 4. Pass Data to JS
// --------------------------------------------------
$js_data = array(
    'activeTab' => 'ALL',
    'finishes'  => $finishes,
    'tabs'      => $tabs
);
?>

<script>
    tailwind.config = {
        theme: {
            extend: {
                colors: {
                    primary: '#0047AB',
                    industrial: '#1D2938',
                    border: '#E4E7EC',
                    panel: '#F8F9FB'
                },
                fontFamily: {
                    sans: ['Inter', 'sans-serif'],
                    mono: ['JetBrains Mono', 'monospace']
                }
            }
        }
    }
</script>
<style>
    [x-cloak] { display: none !important; }
    .no-scrollbar::-webkit-scrollbar { display: none; }
</style>

<section class="py-24 bg-white" x-data='{
    ...<?php echo wp_json_encode( $js_data, JSON_HEX_APOS | JSON_HEX_QUOT ); ?>,
    showAll: false,
    filteredFinishes() {
        let filtered = [];
        if (this.activeTab === "ALL") {
            filtered = this.finishes;
        } else {
            filtered = this.finishes.filter(f => {
                return f.materials.some(m => m.toUpperCase() === this.activeTab);
            });
        }
        return this.showAll ? filtered : filtered.slice(0, 9);
    },
    totalCount() {
        if (this.activeTab === "ALL") {
            return this.finishes.length;
        }
        return this.finishes.filter(f => {
            return f.materials.some(m => m.toUpperCase() === this.activeTab);
        }).length;
    },
    hasMore() {
        return (this.activeTab === "ALL" || this.activeTab === "PLASTIC") && this.totalCount() > 9 && !this.showAll;
    },
    loadMore() {
        this.showAll = true;
    },
    switchTab(tab) {
        this.activeTab = tab;
        this.showAll = false;
    }
}'>
    <div class="w-[90%] lg:w-[80%] mx-auto">
        
        <!-- Header & Tabs -->
        <div class="flex flex-col lg:flex-row lg:items-end justify-between gap-8 mb-16">
            <div class="max-w-xl">
                <h2 class="text-heading">
                    <?php echo wp_kses_post( $title ); ?>
                </h2>
                <p class="text-body/60 text-[18px] font-medium leading-relaxed">
                    <?php echo esc_html( $desc ); ?>
                </p>
            </div>

            <!-- Tabs -->
            <div class="flex bg-panel p-1.5 rounded-xl border border-border overflow-x-auto">
                <template x-for="tab in tabs">
                    <button @click="switchTab(tab)"
                            :class="activeTab === tab ? 'bg-white shadow-sm text-primary' : 'text-industrial/40 hover:text-industrial/70'"
                            class="px-6 py-2.5 rounded-lg text-[12px] font-bold uppercase tracking-widest transition-all whitespace-nowrap"
                            x-text="tab">
                    </button>
                </template>
            </div>
        </div>

        <!-- Table -->
        <div class="overflow-x-auto no-scrollbar sm:pr-0 pr-4">
            <!-- 
                Table Styling Update:
                - Removed default borders using !border-0 on table, th, td.
                - Preserved horizontal dividers using divide-y and border-b.
             -->
            <table class="w-full border-collapse !border-0 min-w-[800px]">
                <thead>
                    <tr class="border-b border-industrial/10 text-left">
                        <th class="!border-0 pb-6 font-mono text-[13px] text-primary uppercase tracking-[1px] whitespace-nowrap">Name</th>
                        <th class="!border-0 pb-6 font-mono text-[13px] text-primary uppercase tracking-[1px] whitespace-nowrap">Description</th>
                        <th class="!border-0 pb-6 font-mono text-[13px] text-primary uppercase tracking-[1px] whitespace-nowrap">Material</th>
                        <th class="!border-0 pb-6 font-mono text-[13px] text-primary uppercase tracking-[1px] whitespace-nowrap">Capability</th>
                        <th class="!border-0 pb-6 font-mono text-[13px] text-primary uppercase tracking-[1px] whitespace-nowrap">Commercial</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-border">
                    <template x-for="finish in filteredFinishes()" :key="finish.name">
                        <tr class="align-middle transition-colors duration-200"
                            x-transition:enter="transition ease-out duration-300"
                            x-transition:enter-start="opacity-0 translate-y-2"
                            x-transition:enter-end="opacity-100 translate-y-0">
                            
                            <!-- Name & Image (Clickable) -->
                            <td class="!border-0 py-8 pr-8 cursor-pointer group w-[25%]" @click="window.location.href = finish.link">
                                <div class="flex items-center gap-6">
                                    <div class="w-20 h-20 rounded-xl overflow-hidden bg-panel border border-border flex-shrink-0 relative">
                                        <img loading="lazy" :src="finish.img" class="w-full h-full object-cover transform transition-transform duration-700 ease-out group-hover:scale-110" sizes="(min-width: 1024px) 800px, 100vw">                                    </div>
                                    <div class="flex items-center gap-3">
                                        <span class="font-extrabold text-[17px] tracking-tight text-industrial transition-colors duration-300 group-hover:text-primary" x-text="finish.name"></span>
                                        <!-- Reveal Arrow -->
                                        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round" class="text-primary opacity-0 -translate-x-4 transition-all duration-300 group-hover:opacity-100 group-hover:translate-x-0">
                                            <path d="M5 12h14"></path>
                                            <path d="m12 5 7 7-7 7"></path>
                                        </svg>
                                    </div>
                                </div>
                            </td>

                            <!-- Description -->
                            <td class="!border-0 py-8 pr-8 w-[35%]">
                                <p class="text-[14px] text-industrial/60 leading-relaxed font-medium" x-text="finish.desc"></p>
                            </td>

                            <!-- Materials -->
                            <td class="!border-0 py-8 pr-6 w-[15%]">
                                <div class="flex flex-wrap gap-2">
                                    <template x-for="mat in finish.materials">
                                        <span class="px-2 py-0.5 bg-panel text-industrial/60 border border-border rounded font-mono text-[15px] font-bold uppercase transition-colors hover:border-industrial/40 hover:text-industrial cursor-default" x-text="mat"></span>
                                    </template>
                                </div>
                            </td>

                            <!-- Capabilities -->
                            <td class="!border-0 py-8 pr-6 w-[15%]">
                                <div class="flex flex-wrap gap-2">
                                    <template x-for="cap in finish.caps">
                                        <a :href="cap.url" 
                                           class="px-2 py-0.5 bg-primary/5 text-primary border border-primary/20 rounded font-mono text-[15px] font-bold transition-colors hover:bg-primary hover:text-white cursor-pointer" 
                                           x-text="cap.name">
                                        </a>
                                    </template>
                                </div>
                            </td>

                            <!-- Commercial -->
                            <td class="!border-0 py-8 w-[10%]">
                                <div class="flex flex-col gap-1">
                                    <span class="font-mono text-[15px] text-primary font-bold" x-text="finish.leadTime"></span>
                                    <span class="font-mono text-[15px] text-industrial/30 font-bold" x-html="finish.priceHtml"></span>
                                </div>
                            </td>
                        </tr>
                    </template>
                </tbody>
            </table>
        </div>

        <!-- Load More Button -->
        <div x-show="hasMore()" x-cloak class="mt-12 flex justify-center">
            <button @click="loadMore" 
                    class="group inline-flex items-center gap-4 px-8 py-3 bg-white text-primary font-bold rounded-xl border-2 border-primary hover:bg-primary hover:text-white transition-all duration-300 shadow-md shadow-primary/10">
                <span class="text-[15px]">Load More Surface Finishes</span>
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 transition-transform group-hover:translate-y-0.5" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M14.707 12.707a1 1 0 01-1.414 0L10 9.414l-3.293 3.293a1 1 0 01-1.414-1.414l4-4a1 1 0 011.414 0l4 4a1 1 0 010 1.414z" clip-rule="evenodd" />
                </svg>
            </button>
        </div>

    </div>
</section>
