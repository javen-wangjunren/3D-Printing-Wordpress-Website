<?php
/**
 * Manufacturing Capabilities Block Template
 * 
 * @package GeneratePress Child
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

// 1. 获取 ACF 字段数据
$section_title  = get_field( 'manufacturing_capabilities_title' );
$section_title  = $section_title ? $section_title : 'Manufacturing Capabilities';
$section_intro  = get_field( 'manufacturing_capabilities_intro' );

// 获取 Tab 数据
$tabs_raw = get_field( 'manufacturing_capabilities_tabs' );
$tabs_raw = is_array( $tabs_raw ) ? $tabs_raw : array();

// 配置开关 (保留用于后续扩展，目前主要依赖 CSS 类)
$mobile_compact = (bool) get_field( 'manufacturing_capabilities_mobile_compact_mode' );
$use_mono       = (bool) get_field( 'manufacturing_capabilities_use_mono_font' );
$anchor_id      = get_field( 'manufacturing_capabilities_anchor_id' );
$extra_class    = get_field( 'manufacturing_capabilities_css_class' );

// 2. 数据清洗与结构化
$tabs = array();
foreach ( $tabs_raw as $tab ) {
    // 处理高亮参数 (Highlights)
    $highlights = array();
    if ( ! empty( $tab['highlights'] ) && is_array( $tab['highlights'] ) ) {
        foreach ( $tab['highlights'] as $hl ) {
            $highlights[] = array(
                'title' => isset( $hl['title'] ) ? (string) $hl['title'] : '',
                'value' => isset( $hl['value'] ) ? (string) $hl['value'] : '',
                'unit'  => isset( $hl['unit'] ) ? (string) $hl['unit'] : '',
                'tag'   => isset( $hl['tag'] ) ? (string) $hl['tag'] : '',
            );
        }
    }

    // 处理后处理标签 (Finishing Tags)
    $finishing_tags = array();
    if ( ! empty( $tab['finishing_tags'] ) && is_array( $tab['finishing_tags'] ) ) {
        foreach ( $tab['finishing_tags'] as $ft ) {
            if ( isset( $ft['text'] ) && $ft['text'] !== '' ) {
                $finishing_tags[] = (string) $ft['text'];
            }
        }
    }

    // 处理 CTA 按钮
    $cta = array(
        'url'    => '',
        'label'  => '',
        'target' => '',
    );
    if ( ! empty( $tab['cta_link'] ) && is_array( $tab['cta_link'] ) ) {
        $cta['url']    = isset( $tab['cta_link']['url'] ) ? (string) $tab['cta_link']['url'] : '';
        $cta['label']  = isset( $tab['cta_link']['title'] ) ? (string) $tab['cta_link']['title'] : '';
        $cta['target'] = isset( $tab['cta_link']['target'] ) ? (string) $tab['cta_link']['target'] : '';
    }

    // 处理图片
    $image_id        = isset( $tab['image'] ) ? (int) $tab['image'] : 0;
    $mobile_image_id = isset( $tab['mobile_image'] ) ? (int) $tab['mobile_image'] : 0;
    $image_url       = $image_id ? wp_get_attachment_image_url( $image_id, 'large' ) : '';
    $mobile_url      = $mobile_image_id ? wp_get_attachment_image_url( $mobile_image_id, 'large' ) : '';

    // 构建 Tab 数据单元
    $tabs[] = array(
        'title'          => isset( $tab['tab_title'] ) ? (string) $tab['tab_title'] : '',
        'short_title'    => isset( $tab['tab_short_title'] ) ? (string) $tab['tab_short_title'] : '', // 新增：移动端短标题
        'key'            => isset( $tab['tab_key'] ) ? (string) $tab['tab_key'] : '',
        'machine'        => isset( $tab['machine_model'] ) ? (string) $tab['machine_model'] : '',
        'hub_title'      => isset( $tab['hub_title'] ) ? (string) $tab['hub_title'] : '',
        'hub_desc'       => isset( $tab['hub_desc'] ) ? (string) $tab['hub_desc'] : '',
        'highlights'     => $highlights,
        'finishing_tags' => $finishing_tags,
        'cta'            => $cta,
        'image'          => array(
            'desktop' => $image_url ? $image_url : '',
            'mobile'  => $mobile_url ? $mobile_url : $image_url,
        ),
    );
}

// 3. 构建 Alpine.js 配置
$config = array(
    'active'   => 0,
    'tabs'     => $tabs,
    'useMono'  => $use_mono,
);

$json_config = wp_json_encode( $config );

// 4. 类名与 ID 处理
$root_id = $anchor_id ? $anchor_id : 'manufacturing-capabilities-' . uniqid();
$root_class = 'py-12 lg:py-20 bg-white'; // 基础内边距与背景
if ( ! empty( $block['className'] ) ) {
    $root_class .= ' ' . $block['className'];
}
if ( $extra_class ) {
    $root_class .= ' ' . $extra_class;
}

?>

<section id="<?php echo esc_attr( $root_id ); ?>" class="<?php echo esc_attr( $root_class ); ?>">
    <div class="max-w-[1280px] mx-auto px-5 lg:px-8" x-data='<?php echo $json_config; ?>'>
        
        <!-- Header & Tabs -->
        <header class="text-center mb-10 lg:mb-16">
            <h2 class="text-[28px] lg:text-[36px] font-bold text-heading mb-6 tracking-tight">
                <?php echo esc_html( $section_title ); ?>
            </h2>
            <?php if ( $section_intro ) : ?>
                <p class="text-body mb-6 max-w-2xl mx-auto"><?php echo esc_html( $section_intro ); ?></p>
            <?php endif; ?>
            
            <div class="flex gap-2 justify-center" x-show="tabs.length > 1">
                <template x-for="(tab, index) in tabs" :key="index">
                    <button 
                        @click="active = index"
                        class="px-6 py-2.5 rounded-[8px] border text-[13px] font-bold transition-all shadow-sm"
                        :class="active === index 
                            ? 'bg-primary text-white border-primary shadow-md' 
                            : 'bg-white text-body border-border hover:border-primary/50'"
                    >
                        <!-- 移动端优先显示短标题，桌面端显示全称 -->
                        <span class="lg:hidden" x-text="tab.short_title || tab.title"></span>
                        <span class="hidden lg:inline" x-text="tab.title"></span>
                    </button>
                </template>
            </div>
        </header>

        <!-- Main Content Grid -->
        <div class="grid lg:grid-cols-[1.1fr_1fr] gap-6 lg:gap-12 items-center" x-show="tabs.length" x-cloak>
            
            <!-- Text Column (Order 2 on mobile, 1 on desktop) -->
            <div class="flex flex-col justify-center order-2 lg:order-1 pr-0 lg:pr-4">
                <div class="opacity-100 transition-opacity duration-300">
                    <h3 class="text-[18px] lg:text-[24px] font-bold text-heading mb-2 tracking-tight" x-text="tabs[active].hub_title"></h3>
                    <p class="text-[13px] lg:text-[15px] leading-relaxed mb-6 lg:mb-8 max-w-xl text-body" x-text="tabs[active].hub_desc"></p>

                    <!-- Highlights Grid (3 cols on mobile) -->
                    <div class="grid grid-cols-3 gap-2 lg:gap-4 mb-6 lg:mb-8">
                        <template x-for="(item, idx) in tabs[active].highlights" :key="idx">
                            <div class="p-2 lg:p-6 border border-border rounded-[12px] bg-white hover:border-primary/50 transition-all text-center lg:text-left flex flex-col justify-center h-full">
                                <span class="hidden lg:inline-block text-[8px] font-bold text-primary uppercase tracking-widest mb-1.5 opacity-80" x-text="item.tag || tabs[active].key"></span>
                                <h3 class="text-[9px] lg:text-[14px] font-bold text-heading mb-0.5 lg:mb-2 truncate w-full" x-text="item.title"></h3>
                                <div class="font-mono text-[15px] lg:text-[22px] font-bold text-heading leading-tight" :class="useMono ? 'font-mono' : ''">
                                    <span x-text="item.value"></span><span class="text-[8px] lg:text-[11px] font-medium text-muted ml-0.5" x-text="item.unit"></span>
                                </div>
                            </div>
                        </template>
                    </div>

                    <!-- Finishing Tags -->
                    <div class="mb-6 lg:mb-8" x-show="tabs[active].finishing_tags && tabs[active].finishing_tags.length">
                        <span class="text-[9px] font-bold text-muted uppercase tracking-[1.5px] block mb-2 lg:mb-3">Available Finishing</span>
                        <div class="flex flex-wrap gap-2">
                            <template x-for="(tag, t_idx) in tabs[active].finishing_tags" :key="t_idx">
                                <span class="bg-[#F8F9FB] border border-border px-2.5 py-1 rounded text-[11px] font-medium text-body" x-text="tag"></span>
                            </template>
                        </div>
                    </div>
                </div>

                <!-- CTA Button -->
                <div x-show="tabs[active].cta && tabs[active].cta.url">
                    <a :href="tabs[active].cta.url" :target="tabs[active].cta.target || '_self'" class="inline-flex items-center gap-2 bg-primary text-white px-6 py-3 lg:px-8 lg:py-3.5 rounded-[8px] font-bold text-[11px] lg:text-[12px] uppercase tracking-wider hover:bg-[#003A8C] transition-all shadow-lg shadow-primary/10 group">
                        <span x-text="tabs[active].cta.label || 'Technical Details'"></span>
                        <svg class="w-3.5 h-3.5 lg:w-4 lg:h-4 transition-transform group-hover:translate-x-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-width="2.5" d="M13 7l5 5m0 0l-5 5m5-5H6"/></svg>
                    </a>
                </div>
            </div>

            <!-- Image Column (Order 1 on mobile, 2 on desktop) -->
            <div class="aspect-[4/3] lg:aspect-auto lg:h-auto order-1 lg:order-2">
                <div class="h-full relative rounded-[12px] overflow-hidden border border-border bg-[#F8F9FB] group shadow-sm">
                    <img :src="tabs[active].image.desktop || tabs[active].image.mobile" class="w-full h-full object-cover opacity-90 group-hover:scale-105 transition-transform duration-700" alt="Manufacturing System">
                    <div class="absolute bottom-0 right-0 bg-primary/90 backdrop-blur-sm px-3 py-1.5 lg:px-4 lg:py-2 text-[9px] lg:text-[10px] font-mono font-bold text-white tracking-widest uppercase rounded-tl-[12px]" x-text="tabs[active].machine"></div>
                </div>
            </div>

        </div>
    </div>
</section>