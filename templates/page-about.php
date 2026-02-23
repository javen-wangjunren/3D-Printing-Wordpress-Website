<?php
/**
 * Template Name: About Us (关于我们模板)
 * ==========================================================================
 * 文件作用:
 * 专门用于渲染 "About Us" 页面。
 * 通过在 WordPress 后台 Page 属性中选择 "Template: About Us" 来激活此模板。
 *
 * 核心逻辑:
 * 1. 作为一个 "调度器" (Dispatcher)，按顺序加载关于我们页面的各个 Gutenberg Blocks。
 * 2. 依次展示：Hero -> 使命愿景 -> 发展历程 -> 团队介绍 -> 工厂实景 -> CTA。
 * 3. 数据源：对应后台当前页面的 ACF 字段（前缀通常为 `about_`）。
 *
 * 架构角色:
 * 属于 WordPress 的自定义页面模板 (Custom Page Template)。
 * 允许管理员为特定的 "About" 页面指定这套独特的布局结构，区别于默认的 `page.php`。
 *
 * 🚨 避坑指南:
 * 1. 确保后台页面的 ACF 字段前缀与代码中的 `prefix` 参数一致 (e.g., `about_hero_`)。
 * 2. 如果新增了关于页面的板块，请在此处添加对应的 `_3dp_render_block` 调用。
 * ==========================================================================
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly.
}

get_header(); ?>

<main id="main" class="site-main page-about">
    
    <?php 
    /**
     * I. 首屏区域 (Hero Section)
     * ==========================================================================
     */
    _3dp_render_block( 'blocks/global/hero-banner/render', array( 'id' => 'about-hero', 'prefix' => 'about_hero_' ) ); 
    ?>

    <?php 
    /**
     * II. 企业使命 (Mission & Vision)
     * ==========================================================================
     */
    _3dp_render_block( 'blocks/global/mission/render', array( 'id' => 'about-mission', 'prefix' => 'about_mission_' ) ); 
    ?>

    <?php 
    /**
     * III. 发展历程 (Company Timeline)
     * ==========================================================================
     */
    _3dp_render_block( 'blocks/global/timeline/render', array( 'id' => 'about-timeline', 'prefix' => 'about_timeline_' ) ); 
    ?>

    <?php 
    /**
     * IV. 核心团队 (Team Members)
     * ==========================================================================
     */
    _3dp_render_block( 'blocks/global/team/render', array( 'id' => 'about-team', 'prefix' => 'about_team_' ) ); 
    ?>

    <?php 
    /**
     * V. 工厂实景 (Factory Gallery)
     * ==========================================================================
     */
    _3dp_render_block( 'blocks/global/factory-image/render', array( 'id' => 'about-factory', 'prefix' => 'about_factory_' ) ); 
    ?>

    <?php 
    /**
     * VI. 行动号召 (CTA)
     * ==========================================================================
     */
    _3dp_render_block( 'blocks/global/cta/render', array( 'id' => 'about-cta' ) ); 
    ?>

</main>

<?php get_footer(); ?>