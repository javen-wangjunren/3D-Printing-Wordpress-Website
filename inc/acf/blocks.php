<?php
/**
 * ACF Blocks Registration (ACF 积木注册)
 * ==========================================================================
 * 文件作用:
 * 负责注册所有自定义的 ACF Block。
 * 每一个 Block 都对应一个 `acf_register_block_type` 调用，定义了 Block 的
 * 名称、标题、描述、图标、关键词以及渲染模板路径。
 *
 * 核心逻辑:
 * 1. 注册 Hero Banner, CTA, Feature Grid 等基础布局 Block。
 * 2. 注册 Industry Slider, Trusted By 等动态内容 Block。
 * 3. 注册 Material List, Comparison Table 等复杂业务 Block。
 * 
 * 架构角色:
 * [Block Registry]
 * 这个文件是连接 "ACF 字段定义" (Schema) 和 "前端渲染模板" (Renderer) 的纽带。
 * 它告诉 WordPress："嘿，我有一个叫 'hero-banner' 的积木，它的设置字段在哪里（由 fields.php 加载），
 * 它的渲染代码在 'blocks/global/hero-banner/render.php'。"
 *
 * 🚨 避坑指南:
 * 1. 唯一性: `name` 属性必须是唯一的，且只能包含小写字母和连字符。
 * 2. 路径准确: `render_template` 必须指向存在的 PHP 文件，否则前台会报错。
 * 3. 图标选择: 尽量使用 Dashicons 图标，以保持后台风格统一。
 * ==========================================================================
 * 
 * @package GeneratePress_Child
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

// 仅在 ACF Pro 激活且支持 Block API 时执行
if ( function_exists( 'acf_register_block_type' ) ) {

    add_action( 'acf/init', function() {

        // ==========================================================================
        // I. 基础布局类 (Layout Blocks)
        // ==========================================================================

        // 1. Hero Banner
        acf_register_block_type( array(
            'name'              => 'hero-banner',
            'title'             => __( 'Hero Banner', '3d-printing' ),
            'description'       => __( '3D打印服务的Hero Banner模块', '3d-printing' ),
            'render_template'   => 'blocks/global/hero-banner/render.php',
            'category'          => 'layout',
            'icon'              => 'cover-image',
            'keywords'          => array( 'hero', 'banner', '3d printing', 'header' ),
            'mode'              => 'preview',
            'align'             => 'full',
            'supports'          => array( 'align' => array( 'full' ), 'mode' => true, 'jsx' => true ),
        ) );

        // 2. CTA (Call to Action)
        acf_register_block_type( array(
            'name'              => 'cta',
            'title'             => __( 'CTA', '3d-printing' ),
            'description'       => __( '号召性用语模块，包含标题、描述、图片和按钮', '3d-printing' ),
            'render_template'   => 'blocks/global/cta/render.php',
            'category'          => 'layout',
            'icon'              => 'megaphone',
            'keywords'          => array( 'cta', 'call to action', 'banner', 'promotion' ),
            'mode'              => 'preview',
            'align'             => 'full',
            'supports'          => array( 'align' => array( 'full' ), 'mode' => true, 'jsx' => true ),
        ) );

        // 3. Feature Grid
        acf_register_block_type( array(
            'name'              => 'feature-grid',
            'title'             => __( 'Feature Grid', '3d-printing' ),
            'description'       => __( '展示3D打印工艺的功能网格模块', '3d-printing' ),
            'render_template'   => 'blocks/global/feature-grid/render.php',
            'category'          => 'layout',
            'icon'              => 'grid-view',
            'keywords'          => array( 'feature', 'grid', '3d printing', 'processes' ),
            'mode'              => 'preview',
            'align'             => 'full',
            'supports'          => array( 'align' => array( 'full' ), 'mode' => true, 'jsx' => true ),
        ) );

        // 4. Why Choose Us
        acf_register_block_type( array(
            'name'              => 'why-choose-us',
            'title'             => __( 'Why Choose Us', '3d-printing' ),
            'description'       => __( '展示选择理由的区块，包含左侧图片和右侧多个理由项', '3d-printing' ),
            'render_template'   => 'blocks/global/why-choose-us/render.php',
            'category'          => 'layout',
            'icon'              => 'thumbs-up',
            'keywords'          => array( 'why choose us', 'reasons', 'advantages', 'benefits' ),
            'mode'              => 'preview',
            'align'             => 'full',
            'supports'          => array( 'align' => array( 'full' ), 'mode' => true, 'jsx' => true ),
        ) );

        // ==========================================================================
        // II. 动态内容类 (Dynamic Content Blocks)
        // ==========================================================================

        // 5. Trusted By (Logos)
        acf_register_block_type( array(
            'name'              => 'trusted-by',
            'title'             => __( 'Trusted By', '3d-printing' ),
            'description'       => __( '展示合作伙伴或客户Logo的区块', '3d-printing' ),
            'render_template'   => 'blocks/global/trusted-by/render.php',
            'category'          => 'layout',
            'icon'              => 'groups',
            'keywords'          => array( 'trusted by', 'clients', 'partners', 'logos' ),
            'mode'              => 'preview',
            'align'             => 'full',
            'supports'          => array( 'align' => array( 'full' ), 'mode' => true, 'jsx' => true ),
        ) );

        // 6. Industry Slider
        acf_register_block_type( array(
            'name'              => 'industry-slider',
            'title'             => __( 'Industry Slider', '3d-printing' ),
            'description'       => __( '展示服务行业的滑块模块，包含行业图片、名称和链接', '3d-printing' ),
            'render_template'   => 'blocks/global/industry-slider/render.php',
            'category'          => 'layout',
            'icon'              => 'images-alt',
            'keywords'          => array( 'industry', 'slider', 'services', 'industries we serve' ),
            'mode'              => 'preview',
            'align'             => 'full',
            'supports'          => array( 'align' => array( 'full' ), 'mode' => true, 'jsx' => true ),
        ) );

        // 7. Review Grid
        acf_register_block_type( array(
            'name'              => 'review-grid',
            'title'             => __( 'Review Grid', '3d-printing' ),
            'description'       => __( '客户评价网格模块，展示多个客户评价', '3d-printing' ),
            'render_template'   => 'blocks/global/review-grid/render.php',
            'category'          => 'layout',
            'icon'              => 'testimonial',
            'keywords'          => array( 'review', 'testimonial', 'customer', 'feedback' ),
            'mode'              => 'preview',
            'align'             => 'full',
            'supports'          => array( 'align' => array( 'full' ), 'mode' => true, 'jsx' => true ),
        ) );

        // 8. Related Blog
        acf_register_block_type( array(
            'name'              => 'related-blog',
            'title'             => __( 'Related Blog', '3d-printing' ),
            'description'       => __( '相关博客文章展示模块，支持最新、分类或手动选择文章', '3d-printing' ),
            'render_template'   => 'blocks/global/related-blog/render.php',
            'category'          => 'layout',
            'icon'              => 'format-aside',
            'keywords'          => array( 'blog', 'article', 'related', 'post' ),
            'mode'              => 'preview',
            'align'             => 'full',
            'supports'          => array( 'align' => array( 'full' ), 'mode' => true, 'jsx' => true ),
        ) );

        // ==========================================================================
        // III. 业务组件类 (Business Logic Blocks)
        // ==========================================================================

        // 9. Comparison Table
        acf_register_block_type( array(
            'name'              => 'comparison-table',
            'title'             => __( 'Comparison Table', '3d-printing' ),
            'description'       => __( '3D打印技术对比表格模块，展示不同技术的参数对比', '3d-printing' ),
            'render_template'   => 'blocks/global/comparison-table/render.php',
            'category'          => 'layout',
            'icon'              => 'table-row-after',
            'keywords'          => array( 'comparison', 'table', '3d printing', 'tech' ),
            'mode'              => 'auto',
            'align'             => 'full',
            'supports'          => array( 'align' => array( 'full' ), 'mode' => true, 'jsx' => true ),
        ) );

        // 10. Material List
        acf_register_block_type( array(
            'name'              => 'material-list',
            'title'             => __( 'Material List', '3d-printing' ),
            'description'       => __( '3D打印材料列表模块，按工艺分类展示材料信息和参数', '3d-printing' ),
            'render_template'   => 'blocks/global/material-list/render.php',
            'category'          => 'layout',
            'icon'              => 'list-view',
            'keywords'          => array( 'material', 'list', '3d printing', 'materials', 'processes' ),
            'mode'              => 'auto',
            'align'             => 'full',
            'supports'          => array( 'align' => array( 'full' ), 'mode' => true, 'jsx' => true ),
        ) );

        // 11. Manufacturing Showcase
        acf_register_block_type( array(
            'name'              => 'manufacturing-showcase',
            'title'             => __( 'Manufacturing Showcase', '3d-printing' ),
            'description'       => __( '展示真实生产案例的滑块模块，包含图片与简要说明。', '3d-printing' ),
            'render_template'   => 'blocks/global/manufacturing-showcase/render.php',
            'category'          => 'layout',
            'icon'              => 'format-gallery',
            'keywords'          => array( 'manufacturing', 'showcase', 'examples', 'slider', 'production' ),
            'mode'              => 'auto',
            'align'             => 'full',
            'supports'          => array( 'align' => array( 'full' ), 'anchor' => true, 'mode' => true, 'jsx' => true ),
        ) );

        // 12. Technical Specs
        acf_register_block_type( array(
            'name'              => 'technical-specs',
            'title'             => __( 'Technical Specs', '3d-printing' ),
            'description'       => __( '用于展示材料关键性能指标卡片和完整参数表的技术规格模块。', '3d-printing' ),
            'render_template'   => 'blocks/global/technical-specs/render.php',
            'category'          => 'layout',
            'icon'              => 'analytics',
            'keywords'          => array( 'technical', 'specs', 'performance', 'properties', 'material' ),
            'mode'              => 'auto',
            'align'             => 'full',
            'supports'          => array( 'align' => array( 'full' ), 'anchor' => true, 'mode' => true, 'jsx' => true ),
        ) );

        // 13. Material Card Grid
        acf_register_block_type( array(
            'name'              => 'material-card',
            'title'             => __( 'Material Card Grid', '3d-printing' ),
            'description'       => __( '材料卡片网格模块：顶部浮动工艺/材料标签与底部决策勋章。', '3d-printing' ),
            'render_template'   => 'blocks/global/material-card/render.php',
            'category'          => 'layout',
            'icon'              => 'index-card',
            'keywords'          => array( 'material', 'card', 'grid', 'cost', 'lead time' ),
            'mode'              => 'auto',
            'align'             => 'full',
            'supports'          => array( 'align' => array( 'full' ), 'anchor' => true, 'mode' => true, 'jsx' => true ),
        ) );

        // 14. Manufacturing Capabilities
        acf_register_block_type( array(
            'name'              => 'manufacturing-capabilities',
            'title'             => __( 'Manufacturing Capabilities', '3d-printing' ),
            'description'       => __( '制造能力枢纽模块：顶部Tabs、左侧信息卡片网格与标签、右侧设备大图。', '3d-printing' ),
            'render_template'   => 'blocks/global/manufacturing-capabilities/render.php',
            'category'          => 'layout',
            'icon'              => 'hammer',
            'keywords'          => array( 'manufacturing', 'capabilities', 'hub', 'tabs', 'specs' ),
            'mode'              => 'auto',
            'align'             => 'full',
            'supports'          => array( 'align' => array( 'full' ), 'anchor' => true, 'mode' => true, 'jsx' => true ),
        ) );

        // 15. Surface Finish Gallery
        acf_register_block_type( array(
            'name'              => 'surface-finish',
            'title'             => __( 'Surface Finish Gallery', '3d-printing' ),
            'description'       => __( '展示 3D 打印表面处理工艺，支持多重筛选、视觉对比及参数网格。', '3d-printing' ),
            'render_template'   => 'blocks/global/surface-finish/render.php',
            'category'          => 'layout',
            'icon'              => 'admin-appearance',
            'keywords'          => array( 'surface', 'finish', 'post-processing', 'gallery', '3d printing' ),
            'mode'              => 'auto',
            'align'             => 'full',
            'supports'          => array( 'align' => array( 'full' ), 'mode' => true, 'jsx' => true, 'anchor' => true ),
        ) );

        // 16. How It Works
        acf_register_block_type( array(
            'name'              => 'how-it-works',
            'title'             => __( 'How It Works (Step Module)', '3d-printing' ),
            'description'       => __( '展示工艺生产流程的交互式步骤模块，包含沉浸式大图、数据指标及专家提示。', '3d-printing' ),
            'render_template'   => 'blocks/global/how-it-works/render.php',
            'category'          => 'layout',
            'icon'              => 'media-interactive',
            'keywords'          => array( 'process', 'steps', 'how it works', 'manufacturing', 'sls' ),
            'mode'              => 'auto',
            'align'             => 'full',
            'supports'          => array( 'align' => array( 'full' ), 'anchor' => true, 'mode' => true, 'jsx' => true ),
        ) );

        // 17. Capability Design Guide
        acf_register_block_type( array(
            'name'              => 'capability-design-guide',
            'title'             => __( 'Capability Design Guide', '3d-printing' ),
            'description'       => __( '展示工艺参数核心指标网格、规格列表及专家设计指南建议。', '3d-printing' ),
            'render_template'   => 'blocks/global/capability-design-guide/render.php',
            'category'          => 'layout',
            'icon'              => 'media-spreadsheet',
            'keywords'          => array( 'capability', 'design', 'specs', 'guide' ),
            'mode'              => 'auto',
            'align'             => 'full',
            'supports'          => array( 'align' => array( 'full' ), 'anchor' => true, 'mode' => true ),
        ) );

        // 18. Order Process
        acf_register_block_type( array(
            'name'              => 'order-process',
            'title'             => __( 'Order Process', '3d-printing' ),
            'description'       => __( '展示订单流程的线性步骤模块，包含工业风格的步骤节点和进度轨道。', '3d-printing' ),
            'render_template'   => 'blocks/global/order-process/render.php',
            'category'          => 'layout',
            'icon'              => 'list-view',
            'keywords'          => array( 'order', 'process', 'steps', 'workflow', 'manufacturing' ),
            'mode'              => 'auto',
            'align'             => 'full',
            'supports'          => array( 'align' => array( 'full' ), 'anchor' => true, 'mode' => true ),
        ) );

        // 19. Material Comparison (New)
        acf_register_block_type( array(
            'name'              => 'material-comparison',
            'title'             => __( 'Material Comparison', '3d-printing' ),
            'description'       => __( '展示材料对比的交互式模块，包含顶部导航标签、材料列表和属性对比表。', '3d-printing' ),
            'render_template'   => 'blocks/global/material-comparison/render.php',
            'category'          => 'layout',
            'icon'              => 'table-row-after',
            'keywords'          => array( 'material', 'comparison', 'table', '3d printing', 'materials' ),
            'mode'              => 'auto',
            'align'             => 'full',
            'supports'          => array( 'align' => array( 'full' ), 'anchor' => true, 'mode' => true ),
        ) );

        // 20. Capability List
        acf_register_block_type( array(
            'name'              => 'capability-list',
            'title'             => __( 'Capability List', '3d-printing' ),
            'description'       => __( '展示所有制造工艺的列表模块，支持标签切换，显示工艺详情和可用材料。', '3d-printing' ),
            'render_template'   => 'blocks/global/capability-list/render.php',
            'category'          => 'layout',
            'icon'              => 'grid-view',
            'keywords'          => array( 'capability', 'list', 'manufacturing', '3d printing', 'processes' ),
            'mode'              => 'auto',
            'align'             => 'full',
            'supports'          => array( 'align' => array( 'full' ), 'anchor' => true, 'mode' => true ),
        ) );

        // 21. Filter Sidebar
        acf_register_block_type( array(
            'name'              => 'filter-sidebar',
            'title'             => __( 'Filter Sidebar', '3d-printing' ),
            'description'       => __( '材料库侧边筛选模块：包含标题、搜索框和多维过滤组。', '3d-printing' ),
            'render_template'   => 'blocks/global/filter-sidebar/render.php',
            'category'          => 'layout',
            'icon'              => 'filter',
            'keywords'          => array( 'filter', 'sidebar', 'materials', 'library' ),
            'mode'              => 'auto',
            'align'             => 'full',
            'supports'          => array( 'align' => array( 'full' ), 'anchor' => true, 'mode' => true ),
        ) );

    }); // End add_action 'acf/init'
}
