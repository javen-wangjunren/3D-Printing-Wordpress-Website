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
$bg_color            = (string) get_field_value('cl_bg_color', $block, $clone_name, $pfx, '#ffffff');
$accent_color        = (string) get_field_value('cl_accent_color', $block, $clone_name, $pfx, '#0047AB');
$anchor_raw          = (string) get_field_value('cl_anchor_id', $block, $clone_name, $pfx, '');

if ( empty( $raw_capabilities ) ) {
    return;
}

// 2. 数据清洗与构建 (构建纯净的 JSON 数据源)
$tabs_data = array();

foreach ( $raw_capabilities as $cap ) {
    $name = isset( $cap['name'] ) ? (string) $cap['name'] : '';
    if ( ! $name ) continue;

    // 处理图片
    $img_id  = isset( $cap['image'] ) ? $cap['image'] : 0;
    $img_data = $img_id ? wp_get_attachment_image_src( $img_id, 'large' ) : null;
    $img_url = $img_data ? $img_data[0] : '';
    $img_width = $img_data ? $img_data[1] : '';
    $img_height = $img_data ? $img_data[2] : '';

    // 处理规格参数 (转为 kv 数组方便 x-for 遍历)
    $specs_raw = isset( $cap['specs'] ) ? $cap['specs'] : array();
    $specs = array();
    $spec_map = array(
        'build_volume' => 'Build Volume',
        'layer_height' => 'Layer Height',
        'tolerance'    => 'Tolerance',
        'lead_time'    => 'Lead Time'
    );
    foreach ( $spec_map as $key => $label ) {
        if ( ! empty( $specs_raw[ $key ] ) ) {
            $specs[] = array( 'label' => $label, 'value' => $specs_raw[ $key ] );
        }
    }

    // 处理材料列表
    $materials_raw = isset( $cap['materials'] ) && is_array( $cap['materials'] ) ? $cap['materials'] : array();
    $materials = array();
    foreach ( $materials_raw as $mat ) {
        if ( is_object( $mat ) && isset( $mat->ID ) ) {
            $materials[] = array(
                'title' => get_the_title( $mat->ID ),
                'url'   => get_permalink( $mat->ID )
            );
        }
    }

    // 处理链接
    $quote_link = isset( $cap['quote_link'] ) ? $cap['quote_link'] : array();
    $detail_link = isset( $cap['detail_link'] ) ? $cap['detail_link'] : array();

    $tabs_data[] = array(
        'name'        => $name,
        'description' => isset( $cap['description'] ) ? (string) $cap['description'] : '',
        'equipment'   => isset( $cap['equipment'] ) ? (string) $cap['equipment'] : '',
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

$anchor_id = $anchor_raw ? 'id="' . esc_attr( $anchor_raw ) . '"' : '';

// --- Dynamic Spacing Logic ---
$prev_bg = isset($GLOBALS['3dp_last_bg']) ? $GLOBALS['3dp_last_bg'] : '';
// Check if current block has same bg as previous
$pt_class = ($prev_bg && $prev_bg === $bg_color) ? 'pt-0' : 'pt-16 lg:pt-24';
$pb_class = 'pb-16 lg:pb-24';

$bg_style  = 'style="background-color: ' . esc_attr( $bg_color ) . '"';

?>

<style>
    [x-cloak] { display: none !important; }
</style>

<section <?php echo $anchor_id; ?> class="capability-list-block w-full transition-colors duration-300 <?php echo esc_attr( $pt_class . ' ' . $pb_class ); ?>" <?php echo $bg_style; ?>
     x-data="<?php echo esc_attr( wp_json_encode( $alpine_state ) ); ?>">
    
    <div class="mx-auto max-w-container px-6 lg:px-8">
        <!-- 标题区域 -->
        <div class="text-center mb-10 lg:mb-16">
            <h2 class="text-h2 text-heading tracking-tight mb-4">
                <?php echo esc_html( $section_title ); ?>
            </h2>
            <?php if ( $section_description ) : ?>
                <p class="mx-auto max-w-2xl text-body">
                    <?php echo esc_html( $section_description ); ?>
                </p>
            <?php endif; ?>
        </div>

        <!-- Tab 导航栏 -->
        <div class="flex justify-start lg:justify-center gap-2 mb-10 lg:mb-16 overflow-x-auto no-scrollbar pb-4 -mx-container px-container lg:mx-0 lg:px-0">
            <template x-for="(tab, index) in tabs" :key="index">
                <button
                    type="button"
                    @click="active = index"
                    :class="active === index ? 'bg-primary text-white shadow-lg shadow-primary/20' : 'text-body hover:bg-border border-transparent'"
                    :style="active === index ? '' : 'background-color: #F2F4F7;'"
                    class="px-8 py-3 rounded-full text-[12px] font-bold transition-all duration-300 uppercase tracking-[2px] whitespace-nowrap border shrink-0"
                >
                    <span x-text="tab.name"></span>
                </button>
            </template>
        </div>

        <!-- 内容区域 (Single View) -->
        <!-- x-show="tabs.length" 确保数据加载后再显示，防止闪烁 -->
        <div class="grid lg:grid-cols-[1.2fr_1fr] gap-8 lg:gap-16 items-stretch" x-show="tabs.length" x-cloak>
            
            <!-- 左侧：图片 (Desktop Order 2) -->
            <!-- 移动端 Order 1 -->
            <div class="order-1 lg:order-2 relative aspect-[4/3] lg:aspect-auto lg:min-h-0">
                <div class="h-full rounded-card bg-bg-section border border-border overflow-hidden flex items-center justify-center p-6 lg:p-10 group transition-all duration-500">
                    
                    <!-- 图片容器：使用 x-show + x-transition 实现平滑切换效果 -->
                    <!-- 注意：这里为了实现淡入淡出，还是需要用 key 来触发重新渲染，或者简单的 src 替换 -->
                    <!-- 简单 src 替换最稳健，配合 transition class -->
                    
                    <div class="w-full h-full relative" x-key="active">
                        <template x-if="tabs[active].image">
                            <img 
                                :src="tabs[active].image" 
                                :width="tabs[active].width"
                                :height="tabs[active].height"
                                :alt="tabs[active].name"
                                class="max-w-full max-h-full object-contain mix-blend-multiply mx-auto transition-opacity duration-300 opacity-100"
                                x-transition:enter="transition ease-out duration-300"
                                x-transition:enter-start="opacity-0 scale-95"
                                x-transition:enter-end="opacity-100 scale-100"
                                loading="lazy"
                            >
                        </template>
                        
                        <!-- 无图片占位 -->
                        <template x-if="!tabs[active].image">
                            <div class="flex h-full items-center justify-center text-heading text-small font-semibold">
                                <span x-text="tabs[active].name"></span>
                            </div>
                        </template>

                        <!-- 设备标签 -->
                        <template x-if="tabs[active].equipment">
                            <div class="absolute bottom-4 right-4 lg:bottom-6 lg:right-6 bg-white/90 backdrop-blur shadow-xl border border-border px-3 py-1.5 lg:px-4 lg:py-2 rounded-md transition-all duration-300">
                                <span class="text-[9px] lg:text-[11px] font-mono font-bold text-heading uppercase tracking-tight" x-text="'EQUIPMENT: ' + tabs[active].equipment"></span>
                            </div>
                        </template>
                    </div>
                </div>
            </div>

            <!-- 右侧：文本信息 (Desktop Order 1) -->
            <!-- 移动端 Order 2 -->
            <div class="order-2 lg:order-1 flex flex-col h-full pt-4 lg:pt-0">
                
                <!-- 标题与描述 -->
                <div class="mb-8 transition-opacity duration-300" x-key="active">
                    <h3 class="text-h3 text-heading mb-4 leading-tight" x-text="tabs[active].name"></h3>
                    <p class="text-body text-small lg:text-body leading-relaxed mb-6" x-show="tabs[active].description" x-text="tabs[active].description"></p>
                </div>

                <!-- 规格参数 Grid -->
                <div class="grid grid-cols-2 gap-y-6 lg:gap-y-8 gap-x-6 lg:gap-x-12 py-6 lg:py-8 border-y border-border mb-8" x-show="tabs[active].specs && tabs[active].specs.length">
                    <template x-for="(spec, idx) in tabs[active].specs" :key="idx">
                        <div class="border-l-2 border-primary/20 pl-4">
                            <span class="block text-[10px] font-bold text-muted uppercase tracking-[0.1em] mb-1.5" x-text="spec.label"></span>
                            <span class="font-mono text-[14px] lg:text-[18px] font-bold text-heading leading-none" x-text="spec.value"></span>
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
</section>