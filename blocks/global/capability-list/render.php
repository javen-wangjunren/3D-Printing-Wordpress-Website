<?php
/**
 * Capability List Block 渲染模板（Tailwind + Alpine 版本 - 单视图数据绑定模式）
 *
 * 设计映射：
 * - 模块外层：bg/bg-section + py-section-y-small/lg:py-section-y
 * - 模式：Single View Data Binding (SVDB) - 只渲染一个 DOM 结构，数据由 Alpine 动态驱动
 * - 优势：彻底解决 CSS 布局冲突（flex/hidden），减少 DOM 节点，提升性能
 */

// Prefix Support
$pfx = isset($block['prefix']) ? $block['prefix'] : '';
$block = isset( $block ) ? $block : array();
$block_id = _3dp_get_safe_block_id( $block, 'capability-list' );

// 1. 万能取数逻辑
$clone_name = rtrim($pfx, '_');
$section_title       = (string) get_field_value('section_title', $block, $clone_name, $pfx, 'Manufacturing Capabilities');
$section_description = (string) get_field_value('section_description', $block, $clone_name, $pfx, 'Six industrial technologies optimized for prototyping and scalable production.');
$raw_capabilities    = get_field_value('capabilities', $block, $clone_name, $pfx, array());
$bg_color            = (string) get_field_value('cl_bg_color', $block, $clone_name, $pfx, '#F8F9FB');
$text_color          = (string) get_field_value('cl_text_color', $block, $clone_name, $pfx, '#667085');
$accent_color        = (string) get_field_value('cl_accent_color', $block, $clone_name, $pfx, '#0047AB');
$anchor_raw          = (string) get_field_value('cl_anchor_id', $block, $clone_name, $pfx, '');

// Layout & Design Settings
$mobile_layout       = (string) get_field_value('cl_mobile_layout', $block, $clone_name, $pfx, 'tabs_scroll'); // tabs_scroll | accordion
$mobile_compact      = (bool) get_field_value('cl_mobile_compact', $block, $clone_name, $pfx, false);

if ( empty( $raw_capabilities ) ) {
    return;
}

// 2. 数据清洗与构建 (Source of Truth Logic)
$tabs_data = array();

foreach ( $raw_capabilities as $cap ) {
    
    // --- Step 1: Determine Source ---
    $source_obj = isset($cap['capability_source']) ? $cap['capability_source'] : null;
    $source_id  = $source_obj ? $source_obj->ID : 0;
    
    // --- Step 2: Fetch Data (Auto vs Manual) ---
    
    // 2.1 Name
    $manual_name = isset($cap['name']) ? $cap['name'] : '';
    $final_name  = $manual_name ? $manual_name : ($source_id ? get_the_title($source_id) : '');
    
    if ( ! $final_name ) continue; // Skip if no name

    // 2.2 Description
    $manual_desc = isset($cap['description']) ? $cap['description'] : '';
    $auto_desc   = $source_id ? get_field('cap_hero_hero_description', $source_id) : '';
    $final_desc  = $manual_desc ? $manual_desc : $auto_desc;
    // Strip tags to avoid <p> appearing in x-text
    $final_desc = $final_desc ? wp_strip_all_tags($final_desc) : '';

    // 2.3 Image
    $manual_img = isset($cap['image']) ? $cap['image'] : 0;
    $auto_img   = $source_id ? get_field('cap_hero_hero_image', $source_id) : 0;
    $final_img_id = $manual_img ? $manual_img : $auto_img;
    
    $img_url = '';
    $img_width = '';
    $img_height = '';
    
    if ( $final_img_id ) {
        $img_data = wp_get_attachment_image_src( $final_img_id, 'large' );
        if ( is_array($img_data) ) {
            $img_url    = $img_data[0];
            $img_width  = $img_data[1];
            $img_height = $img_data[2];
        }
    }

    // 2.4 Specs (Manual Repeater)
    // Structure: array( array('label' => '...', 'value' => '...') )
    $specs_raw = isset($cap['specs']) ? $cap['specs'] : array();
    $specs = array();
    if ( is_array($specs_raw) ) {
        foreach ( $specs_raw as $s ) {
            if ( ! empty($s['label']) && ! empty($s['value']) ) {
                $specs[] = array(
                    'label' => $s['label'],
                    'value' => $s['value']
                );
            }
        }
    }

    // 2.5 Materials (Relationship vs Auto-Fetch)
    $manual_mats = isset($cap['materials']) && is_array($cap['materials']) ? $cap['materials'] : array();
    $materials = array();
    
    if ( ! empty($manual_mats) ) {
        // Use Manual Selection
        foreach ( $manual_mats as $mat ) {
            if ( is_object($mat) ) {
                $materials[] = array(
                    'title' => get_the_title($mat->ID),
                    'url'   => get_permalink($mat->ID)
                );
            }
        }
    } elseif ( $source_id ) {
        // Auto-Fetch via Taxonomy Relation
        // Logic: Find 'material_process' terms linked to this Capability Post, then find materials in those terms.
        
        // A. Find linked terms
        $linked_terms = get_terms( array(
            'taxonomy'   => 'material_process',
            'hide_empty' => true,
            'meta_query' => array(
                array(
                    'key'     => 'taxonomy_linked_capability',
                    'value'   => $source_id,
                    'compare' => '='
                )
            )
        ) );
        
        if ( ! empty($linked_terms) && ! is_wp_error($linked_terms) ) {
            $term_ids = wp_list_pluck( $linked_terms, 'term_id' );
            
            // B. Find materials
            $auto_mats = get_posts( array(
                'post_type'   => 'material',
                'numberposts' => 10, // Limit to 10 to avoid overload
                'tax_query'   => array(
                    array(
                        'taxonomy' => 'material_process',
                        'field'    => 'term_id',
                        'terms'    => (array) $term_ids,
                    )
                )
            ) );
            
            foreach ( $auto_mats as $mat ) {
                $materials[] = array(
                    'title' => $mat->post_title,
                    'url'   => get_permalink($mat->ID)
                );
            }
        }
    }

    // 2.6 Links
    $quote_link = isset( $cap['quote_link'] ) ? $cap['quote_link'] : array();
    
    // Details Link (Auto-generated)
    $detail_label = isset( $cap['detail_label'] ) && !empty( $cap['detail_label'] ) ? $cap['detail_label'] : 'Learn More';
    $detail_link  = array(
        'title'  => $detail_label,
        'url'    => $source_id ? get_permalink($source_id) : '',
        'target' => ''
    );

    $tabs_data[] = array(
        'name'        => $final_name,
        'description' => $final_desc,
        'image'       => $img_url,
        'width'       => $img_width,
        'height'      => $img_height,
        'specs'       => $specs,
        'materials'   => $materials,
        'cta_quote'   => array(
            'title'  => ! empty( $quote_link['title'] ) ? $quote_link['title'] : 'Get Instant Quote',
            'url'    => ! empty( $quote_link['url'] ) ? $quote_link['url'] : '',
            'target' => ! empty( $quote_link['target'] ) ? $quote_link['target'] : '',
        ),
        'cta_detail'  => array(
            'title'  => ! empty( $detail_link['title'] ) ? $detail_link['title'] : 'Explore Details',
            'url'    => ! empty( $detail_link['url'] ) ? $detail_link['url'] : '',
            'target' => ! empty( $detail_link['target'] ) ? $detail_link['target'] : '',
        ),
    );
}

if ( empty( $tabs_data ) ) return;

// 3. 准备 Alpine State
$alpine_state = array(
    'active' => 0,
    'tabs'   => $tabs_data,
);

// 更新全局背景状态
$GLOBALS['3dp_last_bg'] = $bg_color;

$anchor_id = $anchor_raw ? 'id="' . esc_attr( $anchor_raw ) . '"' : '';

// --- Dynamic Spacing & Layout Classes ---
$prev_bg = isset($GLOBALS['3dp_last_bg']) ? $GLOBALS['3dp_last_bg'] : '';
$pt_class = ($prev_bg && $prev_bg === $bg_color) ? 'pt-[100px]' : 'pt-[164px] lg:pt-[196px]'; // 增加 100px 以解决标题重叠问题
$pb_class = 'pb-16 lg:pb-24';

// Compact Mode Adjustments
if ($mobile_compact) {
    $pt_class = str_replace('pt-16', 'pt-8', $pt_class);
    $pb_class = str_replace('pb-16', 'pb-8', $pb_class);
}

// Layout Control
// Tabs View: Visible on Desktop always. On Mobile only if 'tabs_scroll'
$tabs_view_class = ($mobile_layout === 'accordion') ? 'hidden lg:block' : 'block';

// Accordion View: Hidden on Desktop. On Mobile only if 'accordion'
$accordion_view_class = ($mobile_layout === 'accordion') ? 'block lg:hidden' : 'hidden';

$bg_style  = 'style="background-color: ' . esc_attr( $bg_color ) . '"';
$text_style = 'style="color: ' . esc_attr( $text_color ) . '"';

?>

<style>
    [x-cloak] { display: none !important; }
</style>

<section <?php echo $anchor_id; ?> class="capability-list-block w-full transition-colors duration-300 <?php echo esc_attr( $pt_class . ' ' . $pb_class ); ?>" <?php echo $bg_style; ?>
     x-data="<?php echo esc_attr( wp_json_encode( $alpine_state ) ); ?>">
    
    <div class="mx-auto max-w-container px-container">
        <!-- 标题区域 -->
        <div class="text-center mb-10 lg:mb-16">
            <h2 class="text-heading">
                <?php echo esc_html( $section_title ); ?>
            </h2>
            <?php if ( $section_description ) : ?>
                <p class="mx-auto max-w-2xl text-body" <?php echo $text_style; ?>>
                    <?php echo esc_html( $section_description ); ?>
                </p>
            <?php endif; ?>
        </div>

        <!-- ==========================
             VIEW 1: DESKTOP / TABS 
             (SVDB Mode)
             ========================== -->
        <div class="<?php echo esc_attr($tabs_view_class); ?>">
            
            <!-- Tab 导航栏 -->
            <div class="flex justify-start lg:justify-center gap-2 mb-10 lg:mb-16 overflow-x-auto no-scrollbar pb-4 -mx-container px-container lg:mx-0 lg:px-0">
                <template x-for="(tab, index) in tabs" :key="index">
                    <button
                        type="button"
                        @click="active = index"
                        :class="active === index ? 'bg-primary text-white shadow-lg shadow-primary/20' : 'text-body hover:bg-border border-transparent'"
                        :style="active === index ? 'background-color: <?php echo esc_attr($accent_color); ?>' : 'background-color: #F2F4F7;'"
                        class="px-8 py-3 rounded-full text-[12px] font-bold transition-all duration-300 uppercase tracking-[2px] whitespace-nowrap border shrink-0"
                    >
                        <span x-text="tab.name"></span>
                    </button>
                </template>
            </div>

            <!-- 内容区域 (Single View) -->
            <div class="grid lg:grid-cols-[1.2fr_1fr] gap-8 lg:gap-16 items-stretch" x-show="tabs.length" x-cloak>
                
                <!-- 左侧：图片 -->
                <div class="order-1 lg:order-2 relative w-full aspect-[4/3] lg:min-h-0">
                    <div class="h-full group transition-all duration-500">
                        <div class="w-full h-full relative" x-key="active">
                            <template x-if="tabs[active].image">
                                <img 
                                    :src="tabs[active].image" 
                                    :width="tabs[active].width"
                                    :height="tabs[active].height"
                                    :alt="tabs[active].name"
                                    class="w-full h-full object-cover transition-opacity duration-300 opacity-100"
                                    x-transition:enter="transition ease-out duration-300"
                                    x-transition:enter-start="opacity-0 scale-95"
                                    x-transition:enter-end="opacity-100 scale-100"
                                    loading="lazy"
                                >
                            </template>
                            
                            <!-- 无图片占位 -->
                            <template x-if="!tabs[active].image">
                                <div class="flex h-full items-center justify-center bg-bg-section text-heading text-small font-semibold">
                                    <span x-text="tabs[active].name"></span>
                                </div>
                            </template>
                        </div>
                    </div>
                </div>

                <!-- 右侧：文本信息 -->
                <div class="order-2 lg:order-1 flex flex-col h-full pt-4 lg:pt-0">
                    
                    <!-- 标题与描述 -->
                    <div class="mb-8 transition-opacity duration-300" x-key="active">
                        <h3 class="text-h3 text-heading mb-4 leading-tight" x-text="tabs[active].name"></h3>
                        <p class="text-body text-small lg:text-body leading-relaxed mb-6" x-show="tabs[active].description" x-text="tabs[active].description" <?php echo $text_style; ?>></p>
                    </div>

                    <!-- 规格参数 Grid (L-shape info flow) -->
                    <div class="grid grid-cols-2 lg:grid-cols-3 gap-3 mb-8" x-show="tabs[active].specs && tabs[active].specs.length">
                        <template x-for="(spec, idx) in tabs[active].specs" :key="idx">
                            <div class="bg-bg-section p-3 rounded border border-border/60 text-center lg:text-left">
                                <span class="block text-[11px] font-bold text-muted tracking-wide mb-1" x-text="spec.label"></span>
                                <span class="font-mono text-[13px] lg:text-[14px] font-bold text-heading leading-none" x-text="spec.value"></span>
                            </div>
                        </template>
                    </div>

                    <!-- 可用材料 -->
                    <div class="mb-8" x-show="tabs[active].materials && tabs[active].materials.length">
                        <h4 class="text-[11px] font-bold text-muted uppercase tracking-[0.12em] mb-4">Available Materials</h4>
                        <div class="flex flex-wrap gap-2">
                            <template x-for="(mat, m_idx) in tabs[active].materials" :key="m_idx">
                                <a :href="mat.url" class="bg-bg-section border border-border/60 px-3 py-1.5 rounded-md text-[11px] lg:text-[12px] font-semibold text-heading hover:bg-primary hover:text-inverse transition-colors" x-text="mat.title"></a>
                            </template>
                        </div>
                    </div>

                    <!-- 按钮组 -->
                    <div class="mt-auto pt-4 flex flex-col sm:flex-row gap-4">
                        <template x-if="tabs[active].cta_quote && tabs[active].cta_quote.url">
                            <a :href="tabs[active].cta_quote.url"
                               class="bg-primary hover:bg-primary-hover text-inverse px-8 py-4 rounded-button font-bold text-[13px] uppercase tracking-[0.14em] text-center transition-all shadow-md"
                               style="background-color: <?php echo esc_attr( $accent_color ); ?>;"
                               :target="tabs[active].cta_quote.target"
                               x-text="tabs[active].cta_quote.title">
                            </a>
                        </template>

                        <template x-if="tabs[active].cta_detail && tabs[active].cta_detail.url">
                            <a :href="tabs[active].cta_detail.url"
                               class="border-[3px] border-border text-heading hover:border-primary px-8 py-4 rounded-button font-bold text-[13px] uppercase tracking-[0.14em] text-center transition-all"
                               :target="tabs[active].cta_detail.target"
                               x-text="tabs[active].cta_detail.title">
                            </a>
                        </template>
                    </div>
                </div>
            </div>
        </div>

        <!-- ==========================
             VIEW 2: MOBILE ACCORDION
             (Stacked List Mode)
             ========================== -->
        <div class="<?php echo esc_attr($accordion_view_class); ?> space-y-6">
            <template x-for="(tab, idx) in tabs" :key="idx">
                <div class="bg-white rounded-card border border-border overflow-hidden">
                    <!-- Image Area -->
                    <div class="relative aspect-[4/3] bg-bg-section border-b border-border p-6 flex items-center justify-center">
                         <template x-if="tab.image">
                            <img :src="tab.image" class="max-w-full max-h-full object-contain mix-blend-multiply">
                         </template>
                         <template x-if="!tab.image">
                             <span class="text-small font-bold text-muted" x-text="tab.name"></span>
                         </template>
                    </div>
                    
                    <!-- Content Area -->
                    <div class="p-6">
                        <h3 class="text-h3 text-heading mb-3" x-text="tab.name"></h3>
                        <p class="text-body text-small mb-6 line-clamp-3" x-text="tab.description"></p>
                        
                        <!-- Mini Specs -->
                        <div class="grid grid-cols-2 gap-4 mb-6" x-show="tab.specs.length">
                             <template x-for="(spec, s_idx) in tab.specs.slice(0, 4)" :key="s_idx">
                                <div>
                                    <span class="block text-[10px] font-bold text-muted uppercase tracking-wider mb-1" x-text="spec.label"></span>
                                    <span class="font-mono text-[13px] font-bold text-heading" x-text="spec.value"></span>
                                </div>
                             </template>
                        </div>
                        
                        <!-- Action -->
                        <template x-if="tab.cta_detail.url">
                             <a :href="tab.cta_detail.url" class="block w-full text-center border-2 border-border py-3 rounded-button font-bold text-[12px] uppercase text-heading" x-text="tab.cta_detail.title">
                             </a>
                        </template>
                    </div>
                </div>
            </template>
        </div>

    </div>
</section>
