<?php
/**
 * Template Name: All Capabilities (核心能力总览)
 * ==========================================================================
 * 文件作用:
 * 渲染 "All Capabilities" 页面。
 * 展示 3D 打印服务的所有核心能力、精选材料和对比表格。
 *
 * 核心逻辑:
 * 1. 作为一个 "调度器" (Dispatcher)，按顺序加载各个板块。
 * 2. 大部分板块通过 Block 系统 (`_3dp_render_block`) 加载。
 * 3. 特殊板块 "Featured Materials" 通过 `get_template_part` 加载局部模板。
 *
 * 架构角色:
 * 自定义页面模板。
 *
 * 🚨 避坑指南:
 * 1. "Featured Materials" 的逻辑较复杂，已抽离到 template-parts 中，修改请移步该文件。
 * 2. 部分板块（如 Surface Finish）目前被注释隐藏，是业务需求（Phase 1 暂不展示）。
 * ==========================================================================
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly.
}

get_header(); ?>

<main id="main" class="site-main page-all-capabilities">
    
    <?php
    /**
     * I. 首屏区域 (Hero Banner)
     * ==========================================================================
     */
    _3dp_render_block( 'blocks/global/hero-banner/render', array( 'id' => 'overview', 'prefix' => 'all_caps_hero_' ) );
    ?>

    <?php
    /**
     * II. 能力列表 (Capability List)
     * ==========================================================================
     */
    _3dp_render_block( 'blocks/global/capability-list/render', array( 'id' => 'list', 'prefix' => 'allcaps_capability_list_' ) );
    ?>

    <?php
    /**
     * III. 精选材料 (Featured Materials)
     * ==========================================================================
     * 这是一个自定义实现的复杂板块，不使用 Block 系统。
     * 逻辑位于: template-parts/page-all-capabilities/featured-materials.php
     */
    get_template_part( 'template-parts/page-all-capabilities/featured-materials' );
    ?>

    <?php
    /**
     * IV. 表面处理 (Surface Finish)
     * ==========================================================================
     * Phase 1 暂时隐藏
     */
    // _3dp_render_block( 'blocks/global/surface-finish/render', array( 'id' => 'finishes', 'prefix' => 'allcaps_surface_finish_' ) );
    ?>
    
    <?php
    /**
     * V. 参数对比表 (Comparison Table)
     * ==========================================================================
     */
    _3dp_render_block( 'blocks/global/comparison-table/render', array( 'id' => 'comparison', 'prefix' => 'allcaps_comparison_' ) );
    ?>

    <?php
    /**
     * VI. 为什么选择我们 (Why Choose Us)
     * ==========================================================================
     * 使用 Global Options 数据，不依赖当前页面字段。
     */
    //_3dp_render_block( 'blocks/global/why-choose-us/render', array( 'id' => 'why-us-global' ) );
    ?>

    <?php
    /**
     * VII. 行动号召 (CTA)
     * ==========================================================================
     * 使用 Global Options 数据。
     */
    _3dp_render_block( 'blocks/global/cta/render', array( 'id' => 'global-cta' ) );
    ?>

    <?php
    /*
     * 备用：相关博客
    _3dp_render_block( 'blocks/global/related-blog/render', array( 
        'id'     => 'related-stories',
        'prefix' => 'allcaps_related_blog_' 
    ) );
    */
    ?>

</main>

<?php get_footer(); ?>