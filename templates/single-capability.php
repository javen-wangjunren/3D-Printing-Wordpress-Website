<?php
/**
 * Single Capability Template (单个工艺详情页模板)
 * ==========================================================================
 * 文件作用:
 * 负责渲染单个工艺（Capability）详情页的布局和内容。
 * 作为一个 "Dispatcher" (调度器)，它不直接包含HTML结构，而是按顺序调用
 * 各个 ACF Block 或 Template Part 来组装页面。
 *
 * 核心逻辑:
 * 1. 上下文设置: 获取当前文章ID、标题等信息，存入全局变量供子模块使用。
 * 2. 布局钩子: 保持 GeneratePress 的标准钩子 (before/after main content)。
 * 3. 模块调度: 按设计稿顺序渲染各个区块 (Hero, Trusted By, Process, etc.)。
 * 4. 数据源区分: 明确区分哪些模块使用当前文章的 ACF 字段 (Local)，哪些使用全局选项 (Global)。
 *
 * 架构角色:
 * [View Layer - Template]
 * 它是 WordPress Template Hierarchy 中的 `single-{post_type}.php`。
 * 遵循 "Fat Model, Skinny Controller" (这里 Template 充当 Controller/View 混合体)，
 * 尽量保持轻量，只负责调度。
 *
 * 🚨 避坑指南:
 * 1. Global Variable: `$current_capability` 被用于向子模块传递上下文，不要随意删除。
 * 2. Block Prefix: 注意 `_3dp_render_block` 中的 `prefix` 参数，必须与 ACF 字段定义一致，
 *    否则无法正确获取数据。
 * ==========================================================================
 * 
 * @package GeneratePress
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly.
}

// ==========================================================================
// I. 初始化与上下文设置
// ==========================================================================

// 获取当前工艺的核心信息
$current_capability = array(
    'id'    => get_the_ID(),
    'title' => get_the_title(),
    'slug'  => get_post_field( 'post_name' )
);

// 设置全局变量，供子模块 (Blocks/Template Parts) 读取
// 这样子模块就不需要重复调用 get_the_ID()，且能明确知道自己处于哪个 Context
$GLOBALS['current_capability'] = $current_capability;

get_header(); ?>

<main id="main" class="site-main single-capability">
    <?php
    /**
     * generate_before_main_content hook.
     * 输出 GP 的容器包裹层等
     *
     * @since 0.1
     */
    do_action( 'generate_before_main_content' );

    // ==========================================================================
    // II. 内容调度 (Content Dispatcher)
    // ==========================================================================
    
    if ( generate_has_default_loop() ) {
        while ( have_posts() ) :
            the_post();
            
            // --- 1. Hero Banner Module (Local Data) ---
            // 数据源: 当前文章 ACF 字段 (prefix: cap_hero_)
            _3dp_render_block( 'blocks/global/hero-banner/render', array( 
                'id'     => 'overview', 
                'prefix' => 'cap_hero_' 
            ) );

            // --- 2. Trusted By Module (Global Data) ---
            // 数据源: Theme Options (Global)
            _3dp_render_block( 'blocks/global/trusted-by/render', array( 
                'id' => 'trusted-partners' 
            ) );

            // --- 3. How It Works Module (Local Data) ---
            // 数据源: 当前文章 ACF 字段 (prefix: cap_process_)
            /*
            _3dp_render_block( 'blocks/global/how-it-works/render', array( 
                'id'     => 'process', 
                'prefix' => 'cap_process_' 
            ) );
             */

            // --- 4. Industry Slider Module (Global Data) ---
            // 数据源: Theme Options (Global)
            // 状态: [暂时禁用] 第一阶段不放这个内容
            /*
            _3dp_render_block( 'blocks/global/industry-slider/render', array( 
                'id' => 'applications' 
            ) );
            */

            // --- 5. Capability Design Guide Module (Local Data) ---
            // 数据源: 当前文章 ACF 字段 (prefix: cap_design_guide_)
            _3dp_render_block( 'blocks/global/capability-design-guide/render', array( 
                'id'     => 'design-guide', 
                'prefix' => 'cap_design_guide_' 
            ) );

            // --- 6. Material List Module (Local Data) ---
            // 数据源: 当前文章 ACF 字段 (prefix: cap_material_list_)
            _3dp_render_block( 'blocks/global/material-list/render', array( 
                'id'     => 'materials', 
                'prefix' => 'cap_material_list_' 
            ) );

            // --- 7. Comparison Table Module (Local Data) ---
            // 数据源: 当前文章 ACF 字段 (prefix: cap_comparison_)
            _3dp_render_block( 'blocks/global/comparison-table/render', array( 
                'id'     => 'comparison', 
                'prefix' => 'cap_comparison_' 
            ) );

            // --- 8. Order Process Module (Global Data) ---
            // 数据源: Theme Options (Global)
            _3dp_render_block( 'blocks/global/order-process/render', array( 
                'id' => 'order-process' 
            ) );

            // --- 9. Why Choose Us Module (Global Data) ---
            // 数据源: Theme Options (Global)
            // 状态: [暂时禁用]
            /*
            _3dp_render_block( 'blocks/global/why-choose-us/render', array( 
                'id' => 'why-us' 
            ) );
            */

            // --- 10. CTA Module (Global Data) ---
            // 数据源: Theme Options (Global)
            _3dp_render_block( 'blocks/global/cta/render', array( 
                'id' => 'cta' 
            ) );

            // --- 11. Related Blog Module (Auto Tag Match) ---
            // 数据源: 根据 Tags 自动匹配
            // 状态: [暂时禁用] 暂时先不放，没有那么多博客
            /*
            _3dp_render_block( 'blocks/global/related-blog/render', array( 
                'id'                 => 'related-stories',
                'prefix'             => 'cap_related_blog_',
                'current_capability' => $current_capability
            ) );
            */

        endwhile;
    }

    /**
     * generate_after_main_content hook.
     * 输出 GP 的容器闭合标签等
     *
     * @since 0.1
     */
    do_action( 'generate_after_main_content' );
    ?>
</main>

<?php
get_footer();
