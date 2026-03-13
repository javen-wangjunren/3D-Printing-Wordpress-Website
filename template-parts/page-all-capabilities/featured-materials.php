<?php
/**
 * Featured Materials Section (精选材料板块)
 * ==========================================================================
 * 文件作用:
 * 渲染 "All Capabilities" 页面中的 "Featured Materials" 板块。
 * 这是一个包含 PHP 数据处理 + Alpine.js 交互的复杂组件。
 *
 * 核心逻辑:
 * 1. 从 ACF 获取 'featured_materials' 字段组数据。
 * 2. 遍历 Tabs 和 Materials，构建供 Alpine.js 使用的 JSON 数据结构 ($js_tabs)。
 * 3. 前端使用 Alpine.js (x-data) 实现无刷新 Tab 切换。
 * 4. 展示材料图片、名称，并链接到单页。
 *
 * 架构角色:
 * 作为一个 Template Part，它被 `page-all-capabilities.php` 调用。
 * 虽然它只在一个页面使用，但为了保持父模板的整洁（Dispatcher 模式），
 * 我们将其从主模板中剥离出来，作为一个独立的局部视图文件。
 *
 * 🚨 避坑指南:
 * 1. 依赖 ACF 字段结构：`featured_materials` -> `tabs` -> `materials`。
 * 2. 图片获取逻辑：`mat_hero_hero_image` 是材料单页的 ACF 字段，需确保材料页数据完整。
 * 3. Alpine.js 数据传递：使用 `json_encode` 将 PHP 数组转为 JS 对象，注意 `esc_attr` 防止 XSS。
 * ==========================================================================
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly.
}

// 1. 获取 ACF 数据
$fm_group = get_field( 'featured_materials' );

// 如果没有数据，直接返回，不渲染任何 HTML
if ( ! $fm_group ) {
    return;
}

// 2. 解构数据
$fm_title     = $fm_group['title'] ?? '';
$fm_desc      = $fm_group['description'] ?? '';
$fm_tabs      = $fm_group['tabs'] ?? array();
$fm_btn_text  = $fm_group['btn_text'] ?? '';
$fm_btn_link  = $fm_group['btn_link'] ?? '/all-materials';
$fm_btn_count = $fm_group['btn_count'] ?? '';

// 3. 预处理数据供 Alpine.js 使用
$js_tabs = array();
$first_tab_name = '';

foreach ( $fm_tabs as $index => $tab ) {
    $tab_name = $tab['tab_name'] ?? '';
    // 记录第一个 Tab 的名称作为默认选中项
    if ( $index === 0 ) {
        $first_tab_name = $tab_name;
    }
    
    $mats = array();
    if ( ! empty( $tab['materials'] ) ) {
        foreach ( $tab['materials'] as $m_item ) {
            $post_id = $m_item['material_source'] ?? 0;
            if ( $post_id ) {
                // 获取材料页面的 Hero 图片 (注意：这是跨页面获取字段)
                $img_id = get_field( 'mat_hero_hero_image', $post_id );
                $img_url = $img_id ? wp_get_attachment_image_url( $img_id, 'large' ) : '';
                
                $mats[] = array(
                    'name' => get_the_title( $post_id ),
                    'img'  => $img_url,
                    'slug' => get_permalink( $post_id )
                );
            }
        }
    }
    $js_tabs[$tab_name] = $mats;
}
?>

<!-- 
  I. 组件容器 
  使用 pt-[100px] 制造呼吸感
-->
<div class="bg-white pt-[100px]">
    <section class="pt-[80px] pb-[120px] bg-[#f2f4f7] featured-materials" x-data="{ 
        activeTab: '<?php echo esc_attr( $first_tab_name ); ?>',
        materials: <?php echo esc_attr( json_encode( $js_tabs ) ); ?>
    }">
        <div class="max-w-[1440px] mx-auto px-6 lg:px-[80px]">
            
            <!-- II. 头部区域 (Header) -->
            <div class="text-center mb-16">
                <?php if ( $fm_title ) : ?>
                    <h2 class="text-heading">
                        <?php echo esc_html( $fm_title ); ?>
                    </h2>
                <?php endif; ?>
                <?php if ( $fm_desc ) : ?>
                    <p class="!text-[#667085] text-[16px] font-medium max-w-[700px] mx-auto leading-relaxed opacity-90">
                        <?php echo esc_html( $fm_desc ); ?>
                    </p>
                <?php endif; ?>
            </div>

            <!-- III. 分类选项卡 (Tabs) -->
            <div class="flex justify-center mb-16 border-b border-[#E4E7EC]">
                <div class="flex gap-12 overflow-x-auto no-scrollbar scroll-smooth">
                    <template x-for="cat in Object.keys(materials)" :key="cat">
                        <div @click="activeTab = cat"
                             :class="activeTab === cat ? 'border-primary text-primary border-b-[3px]' : 'text-[#667085] border-transparent hover:text-heading border-b-2'"
                             class="featured-material-tab pb-6 font-bold text-[16px] transition-all whitespace-nowrap flex items-center gap-3 cursor-pointer">
                            <span x-text="cat"></span>
                            <!-- 显示该分类下的数量 -->
                            <span class="font-mono text-[13px] opacity-50" x-text="'(' + (materials[cat] ? materials[cat].length : 0) + ')' "></span>
                        </div>
                    </template>
                </div>
            </div>

            <!-- IV. 材料网格 (Grid) -->
            <div class="grid grid-cols-2 sm:grid-cols-2 lg:grid-cols-4 gap-4 sm:gap-8 mb-12 lg:mb-16">
                <template x-for="item in materials[activeTab]" :key="item.name">
                    <a :href="item.slug" class="group block bg-white rounded-xl overflow-hidden border border-[#E4E7EC] hover:border-primary transition-all duration-500 hover:shadow-[0_20px_50px_rgba(0,71,171,0.08)]">
                        <!-- Image Wrapper (Lock 1:1 for larger visual) -->
                        <div class="aspect-square overflow-hidden bg-[#F8F9FB] relative">
                            <img loading="lazy" :src="item.img" :alt="item.name" class="w-full h-full object-cover transition-transform duration-1000 group-hover:scale-110" sizes="(min-width: 1024px) 800px, 100vw">                        </div>
                        <!-- Card Body (Reduced padding) -->
                        <div class="py-3 px-4 text-center border-t border-[#E4E7EC]">
                            <h3 class="text-[16px] font-bold text-heading group-hover:text-primary transition-colors leading-tight" x-text="item.name"></h3>
                        </div>
                    </a>
                </template>
            </div>

            <!-- V. 底部按钮 (Footer Action) -->
            <div class="flex justify-center">
                <a href="<?php echo esc_url( $fm_btn_link ); ?>" class="group inline-flex items-center gap-5 px-12 py-5 bg-[#0047AB] text-white font-bold rounded-xl border-2 border-[#0047AB] hover:bg-white hover:text-primary transition-all duration-300 shadow-lg shadow-primary/10">
                    <span class="text-[15px]"><?php echo esc_html( $fm_btn_text ); ?></span>
                    <span class="font-mono text-[13px] bg-white/20 px-2.5 py-0.5 rounded group-hover:bg-primary/10 transition-colors"><?php echo esc_html( $fm_btn_count ); ?></span>
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 transition-transform group-hover:translate-x-1.5" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M10.293 3.293a1 1 0 011.414 0l6 6a1 1 0 010 1.414l-6 6a1 1 0 01-1.414-1.414L14.586 11H3a1 1 0 110-2h11.586l-2.293-2.293a1 1 0 010-1.414z" clip-rule="evenodd" />
                    </svg>
                </a>
            </div>

        </div>
    </section>
</div>
