<?php
/**
 * Template Name: All Materials (材料库总览页)
 * ==========================================================================
 * 文件作用:
 * 渲染 "All Materials" 页面。
 * 包含一个独特的 Hero Banner (Collage Layout) 和一个带筛选功能的材料网格。
 *
 * 核心逻辑:
 * 1. 调度 Hero Banner: 使用 `get_template_part` 加载定制的 Hero 局部模板。
 * 2. 核心查询 (Main Query): 使用 `_3dp_build_material_query()` 获取数据。
 * 3. 布局结构: 左侧筛选 Sidebar + 右侧材料 Grid + 分页。
 *
 * 架构角色:
 * 这是一个复杂的列表页模板，结合了 Template Part (Hero/Pagination) 和 Block (Sidebar, Cards)。
 *
 * 🚨 避坑指南:
 * 1. Hero Banner 的逻辑已抽离到 `template-parts/page-all-materials/hero-banner.php`。
 * 2. 查询逻辑已抽离到 `inc/template-functions.php` -> `_3dp_build_material_query()`。
 * 3. 分页逻辑已抽离到 `template-parts/components/pagination-materials.php`。
 * ==========================================================================
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly.
}

get_header();

/**
 * I. 首屏区域 (Hero Banner - Custom Collage)
 * ==========================================================================
 */
get_template_part( 'template-parts/page-all-materials/hero-banner' );

// 2. 获取核心查询数据
// 所有的筛选逻辑、排序、分页都在此函数中处理
$material_query = _3dp_build_material_query();

// 3. 获取其他配置
$material_count      = (int) $material_query->found_posts;
$seo_copy            = get_field( 'all_materials_seo_copy' );
$mobile_compact_mode = (bool) get_field( 'filter_sidebar_mobile_compact_mode' );
?>

<main id="main" class="site-main page-all-materials">
    <!-- All Materials Filter & Grid -->
    <section class="all-materials-page bg-gray-50" data-material-library x-data="{ filtersOpen: false }">
        <div class="all-materials-shell container mx-auto px-4 py-8" data-mobile-compact-mode="<?php echo esc_attr( $mobile_compact_mode ? '1' : '0' ); ?>">

            <?php if ( $seo_copy ) : ?>
                <div class="all-materials-seo mb-8" data-seo-copy>
                    <?php echo wp_kses_post( $seo_copy ); ?>
                </div>
            <?php endif; ?>

            <div class="lg:hidden flex items-center justify-between mb-4">
                <button type="button" class="inline-flex items-center gap-2 rounded-button border border-border bg-white px-4 py-2.5 text-[13px] font-bold text-heading" @click="filtersOpen = true">
                    <svg class="w-4 h-4 text-muted" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2a1 1 0 01-.293.707L14 13.414V20a1 1 0 01-1.447.894l-4-2A1 1 0 018 18v-4.586L3.293 6.707A1 1 0 013 6V4z"/></svg>
                    <span>Filters</span>
                </button>
                <div class="text-[11px] font-mono text-muted tracking-wide">
                    <?php echo esc_html( number_format_i18n( $material_count ) ); ?> Materials
                </div>
            </div>

            <div class="all-materials-layout lg:grid lg:grid-cols-12 lg:gap-8 items-start">

                <!-- 
                  II. 筛选侧边栏 (Filter Sidebar) 
                  这是一个独立的 Block，负责展示过滤选项
                -->
                <div class="lg:col-span-3 lg:sticky lg:top-24 self-start lg:z-30">
                    <?php
                    // 将数量传给 Sidebar 显示
                    set_query_var( 'material_count', $material_count );
                    ?>
                    <div class="hidden lg:block">
                        <?php _3dp_render_block( 'blocks/global/filter-sidebar/render', array() ); ?>
                    </div>
                    <div class="lg:hidden fixed inset-0 z-50" x-show="filtersOpen" x-cloak>
                        <div class="absolute inset-0 bg-black/40" @click="filtersOpen = false"></div>
                        <div class="absolute inset-y-0 left-0 w-[88%] max-w-sm bg-white border-r border-border overflow-y-auto">
                            <div class="h-20 px-4 flex items-center justify-between border-b border-border">
                                <div class="text-[13px] font-bold text-heading">Filters</div>
                                <button type="button" class="w-10 h-10 inline-flex items-center justify-center rounded-button border border-border bg-white text-heading" @click="filtersOpen = false" aria-label="Close filters"><span class="text-lg leading-none">×</span></button>
                            </div>
                            <div class="p-4">
                                <?php _3dp_render_block( 'blocks/global/filter-sidebar/render', array() ); ?>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- 
                  III. 材料网格 (Material Grid) 
                  负责循环输出材料卡片和分页
                -->
                <div class="materials-grid-area lg:col-span-9" data-materials-grid>
                    <?php if ( $material_query->have_posts() ) : ?>
                        <div class="materials-grid grid grid-cols-2 md:grid-cols-2 lg:grid-cols-3 gap-4 md:gap-6">
                            <?php while ( $material_query->have_posts() ) : $material_query->the_post(); ?>

                                <!-- Material Card Module -->
                                <?php _3dp_render_block( 'blocks/global/material-card/render', array() ); ?>

                            <?php endwhile; ?>
                        </div>

                        <!-- 
                          IV. 分页组件 (Pagination)
                          将查询对象传递给分页模板
                        -->
                        <?php 
                        // 使用 include 以便传递 $material_query 给分页模板
                        // 注意：get_template_part 默认不能直接传复杂对象，除非用全局变量或 set_query_var
                        // 这里我们使用 set_query_var 更稳妥
                        set_query_var( 'material_query', $material_query );
                        get_template_part( 'template-parts/components/pagination', null, array( 'query' => $material_query ) ); 
                        ?>

                    <?php else : ?>
                        <p class="materials-empty">No materials found.</p>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </section>
</main>

<?php
wp_reset_postdata();
get_footer();
?>
