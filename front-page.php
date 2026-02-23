<?php
/**
 * Front Page Template (首页模板)
 * ==========================================================================
 * 文件作用:
 * 专门用于渲染网站首页（Homepage）。
 * 无论后台设置哪个页面为首页，只要此文件存在，WordPress 都会优先使用它。
 *
 * 核心逻辑:
 * 1. 作为一个 "调度器" (Dispatcher)，按顺序加载各个通过 ACF 定义的 Gutenberg Blocks。
 * 2. 不包含复杂的 PHP 逻辑，仅负责按视觉顺序调用 `_3dp_render_block`。
 * 3. 数据源：通常对应后台 ID 为 `home` 的页面的 ACF 字段，或者 Global Options（取决于 Block 内部实现）。
 *
 * 架构角色:
 * 在 WordPress 模板层级中，`front-page.php` 拥有最高优先级。
 * 它实现了 "代码即配置" (Configuration as Code) 的一部分，确保首页布局的稳定性，
 * 防止用户在后台错误地更换模板导致首页崩溃。
 *
 * 🚨 避坑指南:
 * 1. 不要在此文件中编写复杂的业务逻辑，请封装到 Block 的 render.php 或 functions.php 中。
 * 2. 如果需要修改首页的某个板块，请找到对应的 `blocks/global/xxx/render.php`。
 * 3. 注意 `prefix` 参数，它必须与 ACF Field Group 中的字段前缀一致，否则无法获取数据。
 * ==========================================================================
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly.
}

get_header(); ?>

<main id="main" class="site-main page-home">
    
    <?php 
    /**
     * I. 首屏区域 (Hero Section)
     * ==========================================================================
     */
    _3dp_render_block( 'blocks/global/hero-banner/render', array( 'id' => 'home-hero', 'prefix' => 'home_hero_' ) ); 
    ?>

    <?php 
    /**
     * II. 信任背书 (Social Proof)
     * ==========================================================================
     */
    _3dp_render_block( 'blocks/global/trusted-by/render', array( 'id' => 'home-trusted-by' ) ); 
    ?>
    
    <?php 
    /**
     * III. 核心能力 (Core Capabilities)
     * ==========================================================================
     */
    _3dp_render_block( 'blocks/global/capability-list/render', array( 'id' => 'home-capability-list', 'prefix' => 'home_cap_' ) ); 
    ?>

    <?php 
    /**
     * IV. 价值主张 (Value Proposition)
     * ==========================================================================
     */
    _3dp_render_block( 'blocks/global/why-choose-us/render', array( 'id' => 'home-why-choose-us' ) ); 
    ?>

    <?php 
    /* 
     * 备用模块：行业滑块 
     * _3dp_render_block( 'blocks/global/industry-slider/render', array( 'id' => 'home-industry-slider' ) ); 
     */ 
    ?>

    <?php 
    /**
     * V. 客户评价 (Reviews)
     * ==========================================================================
     * 注意：设置了背景色 #f8f9fb
     */
    _3dp_render_block( 'blocks/global/review-grid/render', array( 'id' => 'home-review-grid', 'prefix' => 'home_rev_', 'bg_color' => '#f8f9fb' ) ); 
    ?>

    <?php 
    /**
     * VI. 订购流程 (Order Process)
     * ==========================================================================
     */
    _3dp_render_block( 'blocks/global/order-process/render', array( 'id' => 'home-order-process' ) ); 
    ?>

    <?php 
    /**
     * VII. 行动号召 (CTA)
     * ==========================================================================
     */
    _3dp_render_block( 'blocks/global/cta/render', array( 'id' => 'home-cta' ) ); 
    ?>

    <?php 
    /* 
     * 备用模块：相关博客
     * _3dp_render_block( 'blocks/global/related-blog/render', array( 'id' => 'home-related-blog', 'prefix' => 'home_blog_' ) ); 
     */ 
    ?>

</main>

<?php get_footer(); ?>