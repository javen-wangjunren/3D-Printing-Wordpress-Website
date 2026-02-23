<?php
/**
 * Template Name: Contact (联系我们)
 * ==========================================================================
 * 文件作用:
 * 渲染 Contact 页面。
 * 
 * 核心逻辑:
 * 1. 调度 Hero Banner (Block)。
 * 2. 调度 Contact Form (Component)。
 * 
 * 架构角色:
 * 作为一个调度器，它将页面拆分为可复用的模块。
 * ==========================================================================
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly.
}

get_header(); ?>

<main id="main" class="site-main page-contact pb-16 lg:pb-[100px]">

    <?php
    /**
     * I. Render Hero Banner
     * --------------------------------------------------
     * 使用 Block 渲染器加载 Hero Banner。
     * 数据源：本页面的 ACF 字段 (Clone Group)。
     */
    _3dp_render_block( 'blocks/global/hero-banner/render', array( 
        'id'     => 'contact-hero',
        'prefix' => 'contact_hero_clone_'
    ) );
    ?>

    <?php
    /**
     * II. Render Contact Form Section
     * --------------------------------------------------
     * 使用 Template Part 加载通用的联系表单组件。
     * 数据源：本页面的 ACF 字段。
     */
    $form_title     = get_field( 'contact_form_title' );
    $form_shortcode = get_field( 'contact_form_shortcode' );
    
    // 将数据传递给组件 (Component)
    set_query_var( 'title', $form_title );
    set_query_var( 'shortcode', $form_shortcode );
    
    get_template_part( 'template-parts/components/contact-section' );
    ?>

</main>

<?php get_footer(); ?>