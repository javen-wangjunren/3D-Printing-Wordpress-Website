<?php
/**
 * Block: Why Choose Us (B2B Logic)
 * Path: blocks/global/why-choose-us/render.php
 * Description: 100% 还原设计稿的工业级分栏模块，支持双角色内容对比。
 */

$block_id = !empty($block['anchor']) ? $block['anchor'] : 'why-choose-us-' . $block['id'];

// 获取字段数据，优先从区块获取，若为空则从全局设置获取
$main_title = get_field('wcu_main_title');
$card_label = get_field('wcu_card_label');
$tabs = get_field('wcu_tabs');
$cta_page = get_field('wcu_cta_page');
$cta_text = get_field('wcu_cta_text');
$anchor_id = get_field('wcu_anchor_id');
$custom_class = get_field('wcu_custom_class');

if (empty($tabs)) {
    $global_data = get_field('global_why_choose_us', 'option');
    if ($global_data) {
        $wcu_data = ( isset( $global_data['wcu_clone'] ) && is_array( $global_data['wcu_clone'] ) ) ? $global_data['wcu_clone'] : $global_data;
        $main_title = $main_title ?: ($wcu_data['wcu_main_title'] ?? '');
        $card_label = $card_label ?: ($wcu_data['wcu_card_label'] ?? '');
        $tabs = $tabs ?: ($wcu_data['wcu_tabs'] ?? array());
        $cta_page = $cta_page ?: ($wcu_data['wcu_cta_page'] ?? '');
        $cta_text = $cta_text ?: ($wcu_data['wcu_cta_text'] ?? '');
        $anchor_id = $anchor_id ?: ($wcu_data['wcu_anchor_id'] ?? '');
        $custom_class = $custom_class ?: ($wcu_data['wcu_custom_class'] ?? '');
    } else {
        // Fallback for legacy flat option fields
        $main_title = $main_title ?: ( get_field('wcu_main_title', 'option') ?: '' );
        $card_label = $card_label ?: ( get_field('wcu_card_label', 'option') ?: '' );
        $tabs_flat  = get_field('wcu_tabs', 'option');
        $tabs       = $tabs ?: ( is_array($tabs_flat) ? $tabs_flat : array() );
        $cta_page   = $cta_page ?: ( get_field('wcu_cta_page', 'option') ?: '' );
        $cta_text   = $cta_text ?: ( get_field('wcu_cta_text', 'option') ?: '' );
        $anchor_id  = $anchor_id ?: ( get_field('wcu_anchor_id', 'option') ?: '' );
        $custom_class = $custom_class ?: ( get_field('wcu_custom_class', 'option') ?: '' );
    }
}

$block_id = $anchor_id ?: $block_id;
$main_title = $main_title ?: 'Why Choose 3DPROTO';
$card_label = $card_label ?: 'CONSOLE / NAVIGATION';
$cta_text = $cta_text ?: 'START YOUR PROJECT';
$tabs = $tabs ?: array();
$custom_class = $custom_class ?: '';

if (empty($tabs)) return;

// 预处理 Alpine.js 数据
$alpine_content = array();
foreach ($tabs as $index => $tab) {
    $tab_name = $tab['tab_name'];
    $img_url = wp_get_attachment_image_url($tab['tab_image'], 'full');
    
    $eng_points = array();
    if (!empty($tab['eng_list'])) {
        foreach ($tab['eng_list'] as $item) {
            $eng_points[] = $item['item'];
        }
    }

    $proc_points = array();
    if (!empty($tab['proc_list'])) {
        foreach ($tab['proc_list'] as $item) {
            $proc_points[] = $item['item'];
        }
    }

    $alpine_content[$tab_name] = array(
        'title' => $tab['tab_name'],
        'desc'  => $tab['tab_desc'],
        'img'   => $img_url,
        'engLabel' => $tab['eng_label'],
        'engPoints' => $eng_points,
        'procLabel' => $tab['proc_label'],
        'procPoints' => $proc_points
    );
}

$initial_tab = !empty($tabs) ? $tabs[0]['tab_name'] : '';

// 更新全局背景状态 (WCU 是纯白底)
$GLOBALS['3dp_last_bg'] = '#ffffff';
?>

<section id="<?php echo esc_attr($block_id); ?>" class="py-16 lg:pt-24 lg:pb-40 bg-white relative overflow-hidden <?php echo esc_attr($custom_class); ?>">
    
    <div class="max-w-container mx-auto px-container relative z-10">
        
        <div class="flex flex-col lg:flex-row gap-8 lg:gap-12 min-h-[700px] lg:min-h-[800px]" 
             x-data="{ 
                activeTab: '<?php echo esc_attr($initial_tab); ?>',
                content: <?php echo htmlspecialchars(json_encode($alpine_content), ENT_QUOTES, 'UTF-8'); ?>
             }">
            
            <!-- Left Rail: Console Controls (Fixed Width: 380px) -->
            <div class="lg:w-[380px] bg-panel border border-border rounded-xl p-8 lg:p-10 flex flex-col relative overflow-hidden">
                
                <!-- Global Section Header (Moved inside Left Rail for alignment) -->
                <div class="mb-12 lg:mb-16 relative z-20">
                    <h2 class="text-heading text-[32px] lg:text-[40px] font-extrabold tracking-[-1px] leading-tight">
                        <?php 
                        // 处理标题中的品牌色
                        $title_html = esc_html($main_title);
                        if (strpos($title_html, '3DPROTO') !== false) {
                            $title_html = str_replace('3DPROTO', '<span class="text-primary">3DPROTO</span>', $title_html);
                        }
                        echo $title_html;
                        ?>
                    </h2>
                </div>

                <!-- Grid Overlay (Only inside the left rail area) -->
                <div class="absolute inset-0 opacity-[0.3] pointer-events-none" style="background-image: radial-gradient(circle, #D0D5DD 1px, transparent 1px); background-size: 24px 24px;"></div>
                
                <div class="relative z-10 mb-10">
                    <h4 class="font-mono text-[13px] font-bold text-primary uppercase tracking-wider mb-3 flex items-center gap-2">
                        <span class="w-1.5 h-1.5 bg-primary rounded-full"></span>
                        <?php echo esc_html($card_label); ?>
                    </h4>
                </div>
                
                <nav class="relative z-10 flex-1 space-y-4 lg:space-y-6">
                    <template x-for="(data, tab) in content" :key="tab">
                        <button @click="activeTab = tab"
                                :class="activeTab === tab ? 'border-l-primary bg-white shadow-sm' : 'border-l-transparent opacity-60 hover:opacity-100'"
                                class="w-full text-left transition-all duration-300 group border-l-[3px] border-y-0 border-r-0 pl-6 py-4 outline-none rounded-r-xl">
                            <div class="flex flex-col gap-1.5">
                                <div class="flex items-center gap-3">
                                    <span :class="activeTab === tab ? 'text-primary' : 'text-body opacity-40'" 
                                          class="font-mono text-[11px] font-bold">
                                        <span x-text="'0' + (Object.keys(content).indexOf(tab) + 1)"></span>
                                    </span>
                                    <h3 :class="activeTab === tab ? 'text-industrial' : 'text-body'" 
                                        class="font-bold uppercase tracking-[1.2px] text-[14px] m-0" 
                                        x-text="tab"></h3>
                                </div>
                                <div x-show="activeTab === tab" 
                                     x-cloak
                                     x-transition:enter="transition ease-out duration-300"
                                     x-transition:enter-start="opacity-0 -translate-y-2"
                                     class="mt-2">
                                    <p class="text-[13px] text-body/80 leading-relaxed pr-4 m-0" 
                                       x-text="data.desc"></p>
                                </div>
                            </div>
                        </button>
                    </template>
                </nav>
            </div>

            <!-- Right Content: Information Matrix -->
            <div class="flex-1 bg-white border border-border rounded-xl p-8 lg:p-12 flex flex-col">
                <!-- Visual Asset -->
                <div class="h-[300px] lg:h-[450px] overflow-hidden rounded-[20px] bg-industrial relative shadow-inner">
                    <img loading="lazy" :src="content[activeTab].img" class="w-full h-full object-cover grayscale-[20%] hover:grayscale-0 transition-all duration-1000" sizes="(min-width: 1024px) 800px, 100vw">                    <div class="absolute inset-0 bg-gradient-to-t from-industrial/40 to-transparent"></div>
                </div>

                <!-- Data Matrix -->
                <div class="py-12 lg:py-16 flex-1 flex flex-col justify-center">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-12 lg:gap-20">
                        
                        <!-- Persona 01: Engineers -->
                        <div x-show="activeTab" x-transition:enter="transition ease-out duration-500 delay-100" x-transition:enter-start="opacity-0 translate-y-4">
                            <div class="flex items-center gap-4 mb-8">
                                <span class="font-mono text-[13px] font-bold text-primary uppercase tracking-wider" x-text="content[activeTab].engLabel"></span>
                                <div class="relative h-[1px] flex-1 bg-border/60">
                                    <div class="absolute right-0 top-1/2 -translate-y-1/2 w-[1px] h-3 bg-border"></div>
                                </div>
                            </div>
                            <ul class="space-y-5 m-0 p-0 list-none">
                                <template x-for="point in content[activeTab].engPoints">
                                    <li class="flex items-start gap-4">
                                        <div class="w-1.5 h-1.5 rounded-full bg-primary mt-2 flex-shrink-0"></div>
                                        <p class="text-[15px] lg:text-[16px] text-industrial font-bold tracking-tight leading-relaxed m-0" x-text="point"></p>
                                    </li>
                                </template>
                            </ul>
                        </div>

                        <!-- Persona 02: Procurement -->
                        <div x-show="activeTab" x-transition:enter="transition ease-out duration-500 delay-200" x-transition:enter-start="opacity-0 translate-y-4">
                            <div class="flex items-center gap-4 mb-8">
                                <span class="font-mono text-[13px] font-bold text-primary uppercase tracking-wider" x-text="content[activeTab].procLabel"></span>
                                <div class="relative h-[1px] flex-1 bg-border/60">
                                    <div class="absolute right-0 top-1/2 -translate-y-1/2 w-[1px] h-3 bg-border"></div>
                                </div>
                            </div>
                            <ul class="space-y-5 m-0 p-0 list-none">
                                <template x-for="point in content[activeTab].procPoints">
                                    <li class="flex items-start gap-4">
                                        <div class="w-1.5 h-1.5 rounded-full bg-primary mt-2 flex-shrink-0"></div>
                                        <p class="text-[15px] lg:text-[16px] text-industrial font-bold tracking-tight leading-relaxed m-0" x-text="point"></p>
                                    </li>
                                </template>
                            </ul>
                        </div>

                    </div>

                    <!-- Action Link -->
                    <div class="mt-12 lg:mt-16 pt-10 border-t border-border flex justify-end items-center">
                        <?php if ($cta_page) : ?>
                        <a href="<?php echo esc_url($cta_page); ?>" class="group bg-primary text-white px-10 py-4 rounded-button text-[13px] font-bold uppercase tracking-widest flex items-center gap-2 hover:bg-primary-hover transition-all duration-300 shadow-lg shadow-primary/10">
                            <?php echo esc_html($cta_text); ?>
                            <svg class="w-4 h-4 transition-transform group-hover:translate-x-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M17 8l4 4m0 0l-4 4m4-4H3"></path></svg>
                        </a>
                        <?php endif; ?>
                    </div>
                </div>
            </div>

        </div>
    </div>
</section>
