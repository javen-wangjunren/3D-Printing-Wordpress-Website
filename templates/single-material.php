<?php
/**
 * Single Material Template (单个材料详情页模板)
 * ==========================================================================
 * 文件作用:
 * 负责渲染单个材料（Material）详情页的布局和内容。
 * 作为一个 "Dispatcher" (调度器)，它不直接包含HTML结构，而是按顺序调用
 * 各个 ACF Block 或 Template Part 来组装页面。
 *
 * 核心逻辑:
 * 1. 上下文设置: 获取当前文章ID、标题等信息，存入全局变量供子模块使用。
 * 2. 布局钩子: 保持 GeneratePress 的标准钩子 (before/after main content)。
 * 3. 模块调度: 按设计稿顺序渲染各个区块 (Hero, Showcase, Specs, etc.)。
 * 4. 动态关联: 使用 `get_material_linked_capability()` 自动获取关联工艺数据。
 *
 * 架构角色:
 * [View Layer - Template]
 * 它是 WordPress Template Hierarchy 中的 `single-material.php`。
 * 遵循 "Fat Model, Skinny Controller" (这里 Template 充当 Controller/View 混合体)，
 * 尽量保持轻量，只负责调度。
 *
 * 🚨 避坑指南:
 * 1. Global Variable: `$current_material` 被用于向子模块传递上下文，不要随意删除。
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

// 获取当前材料的核心信息
$current_material = array(
    'id'    => get_the_ID(),
    'title' => get_the_title(),
    'slug'  => get_post_field( 'post_name' )
);

// 设置全局变量，供子模块 (Blocks/Template Parts) 读取
// 这样子模块就不需要重复调用 get_the_ID()，且能明确知道自己处于哪个 Context
$GLOBALS['current_material'] = $current_material;

get_header(); ?>

<main id="main" class="site-main single-material">
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
            
            // --- 1. Hero Banner Module ---
            // 数据源: 当前文章 ACF 字段 (prefix: mat_hero_)
            _3dp_render_block( 'blocks/global/hero-banner/render', array( 
                'id'     => 'overview', 
                'prefix' => 'mat_hero_' 
            ) );

            // --- 2. Manufacturing Showcase Module ---
            // 数据源: 当前文章 ACF 字段 (prefix: mat_showcase_)
            _3dp_render_block( 'blocks/global/manufacturing-showcase/render', array( 
                'id'     => 'gallery', 
                'prefix' => 'mat_showcase_' 
            ) );

            // --- 3. Technical Specs Module ---
            // 数据源: 当前文章 ACF 字段 (prefix: mat_tech_specs_)
            _3dp_render_block( 'blocks/global/technical-specs/render', array( 
                'id'     => 'specifications', 
                'prefix' => 'mat_tech_specs_',
                'background_color' => '#f8f9fb'
            ) );

            // --- 4. Manufacturing Capabilities Module ---
            // 数据源: 自动获取关联工艺数据 (来自 material_process 分类)
            // 逻辑: 调用 inc/template-functions.php 中的业务函数
            $linked_cap_data_override = get_material_linked_capability( get_the_ID() );

            _3dp_render_block( 'blocks/global/manufacturing-capabilities/render', array( 
                'id'            => 'capabilities', 
                'prefix'        => 'mat_capabilities_',
                'tabs_override' => $linked_cap_data_override
            ) );

            // --- 5. CTA Module (Global) ---
            // 数据源: Theme Options (Global)
            _3dp_render_block( 'blocks/global/cta/render', array( 
                'id' => 'cta' 
            ) );

            // --- 6. Related Blog Module ---
            // 数据源: 根据 Tags 自动匹配
            // 状态: 传入当前 material 上下文，供模块内部查询使用
            /*
            _3dp_render_block( 'blocks/global/related-blog/render', array( 
                'id'               => 'related-stories', 
                'prefix'           => 'mat_related_blog_',
                'current_material' => $current_material // Explicitly pass context
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
