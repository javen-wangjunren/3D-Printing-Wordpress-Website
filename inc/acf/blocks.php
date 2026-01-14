<?php
/**
 * ACF Blocks 注册文件
 * 负责注册所有自定义的ACF Block
 */

// 确保函数在ACF可用时才执行
if ( function_exists( 'acf_register_block_type' ) ) 
{
    // 注册Hero Banner Block
    function _3dp_register_hero_block() 
    {
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
            'supports'          => array(
                'align'     => array( 'full' ),
                'mode'      => true,
                'jsx'       => true,
            ),
        ) );
    }
    add_action( 'acf/init', '_3dp_register_hero_block' );
    
    // 注册Trusted By Block
    function _3dp_register_trusted_by_block() 
    {
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
            'supports'          => array(
                'align'     => array( 'full' ),
                'mode'      => true,
                'jsx'       => true,
            ),
        ) );
    }
    add_action( 'acf/init', '_3dp_register_trusted_by_block' );
    
    // 注册Feature Grid Block
    function _3dp_register_feature_grid_block() 
    {
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
            'supports'          => array(
                'align'     => array( 'full' ),
                'mode'      => true,
                'jsx'       => true,
            ),
        ) );
    }
    add_action( 'acf/init', '_3dp_register_feature_grid_block' );
    
    // 注册Why Choose Us Block
    function _3dp_register_why_choose_us_block() 
    {
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
            'supports'          => array(
                'align'     => array( 'full' ),
                'mode'      => true,
                'jsx'       => true,
            ),
        ) );
    }
    add_action( 'acf/init', '_3dp_register_why_choose_us_block' );
    
    // 注册Industry Slider Block
    function _3dp_register_industry_slider_block() 
    {
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
            'supports'          => array(
                'align'     => array( 'full' ),
                'mode'      => true,
                'jsx'       => true,
            ),
        ) );
    }
    add_action( 'acf/init', '_3dp_register_industry_slider_block' );
    
    // 注册Review Grid Block
    function _3dp_register_review_grid_block() 
    {
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
            'supports'          => array(
                'align'     => array( 'full' ),
                'mode'      => true,
                'jsx'       => true,
            ),
        ) );
    }
    add_action( 'acf/init', '_3dp_register_review_grid_block' );
    
    // 注册Related Blog Block
    function _3dp_register_related_blog_block() 
    {
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
            'supports'          => array(
                'align'     => array( 'full' ),
                'mode'      => true,
                'jsx'       => true,
            ),
        ) );
    }
    add_action( 'acf/init', '_3dp_register_related_blog_block' );
    
    // 注册CTA Block
    function _3dp_register_cta_block() 
    {
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
            'supports'          => array(
                'align'     => array( 'full' ),
                'mode'      => true,
                'jsx'       => true,
            ),
        ) );
    }
    add_action( 'acf/init', '_3dp_register_cta_block' );
    
    // 注册Comparison Table Block
    function _3dp_register_comparison_table_block() 
    {
        acf_register_block_type( array(
            'name'              => 'comparison-table',
            'title'             => __( 'Comparison Table', '3d-printing' ),
            'description'       => __( '3D打印技术对比表格模块，展示不同技术的参数对比', '3d-printing' ),
            'render_template'   => 'blocks/global/comparison-table/render.php',
            'category'          => 'layout',
            'icon'              => 'table-row-after',
            'keywords'          => array( 'comparison', 'table', '3d printing', 'tech', 'comparison table' ),
            'mode'              => 'auto', // 设置为auto模式，允许在内容区域直接编辑
            'align'             => 'full',
            'supports'          => array(
                'align'     => array( 'full' ),
                'mode'      => true,
                'jsx'       => true,
            ),
        ) );
    }
    add_action( 'acf/init', '_3dp_register_comparison_table_block' );
    
    // 注册Material List Block
    function _3dp_register_material_list_block() 
    {
        acf_register_block_type( array(
            'name'              => 'material-list',
            'title'             => __( 'Material List', '3d-printing' ),
            'description'       => __( '3D打印材料列表模块，按工艺分类展示材料信息和参数', '3d-printing' ),
            'render_template'   => 'blocks/global/material-list/render.php',
            'category'          => 'layout',
            'icon'              => 'list-view',
            'keywords'          => array( 'material', 'list', '3d printing', 'materials', 'processes' ),
            'mode'              => 'auto', // 设置为auto模式，允许在内容区域直接编辑
            'align'             => 'full',
            'supports'          => array(
                'align'     => array( 'full' ),
                'mode'      => true,
                'jsx'       => true,
            ),
        ) );
    }
    add_action( 'acf/init', '_3dp_register_material_list_block' );

    // 注册Manufacturing Showcase Block
    function _3dp_register_manufacturing_showcase_block() 
    {
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
            'supports'          => array(
                'align'     => array( 'full' ),
                'anchor'    => true,
                'mode'      => true,
                'jsx'       => true,
            ),
        ) );
    }
    add_action( 'acf/init', '_3dp_register_manufacturing_showcase_block' );

    // 注册Technical Specs Block
    function _3dp_register_technical_specs_block() 
    {
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
            'supports'          => array(
                'align'     => array( 'full' ),
                'anchor'    => true,
                'mode'      => true,
                'jsx'       => true,
            ),
        ) );
    }
    add_action( 'acf/init', '_3dp_register_technical_specs_block' );

        // 注册材料卡片网格模块

    function _3dp_register_material_card_block() 
    {
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
            'supports'          => array(
                'align'     => array( 'full' ),
                'anchor'    => true,
                'mode'      => true,
                'jsx'       => true,
            ),
        ) );
    }
    add_action( 'acf/init', '_3dp_register_material_card_block' );

    // 注册Manufacturing Capabilities Block
    function _3dp_register_manufacturing_capabilities_block() 
    {
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
            'supports'          => array(
                'align'     => array( 'full' ),
                'anchor'    => true,
                'mode'      => true,
                'jsx'       => true,
            ),
        ) );
    }
    add_action( 'acf/init', '_3dp_register_manufacturing_capabilities_block' );
}



// 注册 Surface Finish Gallery
if ( function_exists( 'acf_register_block_type' ) ) {

    function _3dp_register_surface_finish_block() 
    {
        acf_register_block_type( array(
            'name'              => 'surface-finish',
            'title'             => __( 'Surface Finish Gallery', '3d-printing' ),
            'description'       => __( '展示 3D 打印表面处理工艺，支持多重筛选、视觉对比及参数网格。', '3d-printing' ),
            'render_template'   => 'blocks/global/surface-finish/render.php',
            'category'          => 'layout', // 保持与 Material List 一致
            'icon'              => 'admin-appearance', // 艺术/视觉相关的图标
            'keywords'          => array( 'surface', 'finish', 'post-processing', 'gallery', '3d printing' ),
            
            // 核心交互设置
            'mode'              => 'auto',  // 允许在内容区域直接编辑，避开拥挤的侧边栏
            'align'             => 'full',
            
            // 响应式与功能支持
            'supports'          => array(
                'align'     => array( 'full' ), // 强制支持全宽布局，适配瀑布流设计
                'mode'      => true,            // 允许用户切换编辑/预览模式
                'jsx'       => true,            // 支持内部嵌套积木（如需要）
                'anchor'    => true,            // 支持 HTML 锚点，方便从导航跳转
            ),
            
            // 示例数据 (用于后台积木预览)
            'example'           => array(
                'attributes' => array(
                    'mode' => 'preview',
                    'data' => array(
                        'is_preview' => true
                    )
                )
            ),
        ) );
    }

    // 挂载到 acf/init 钩子，确保安全性
    add_action( 'acf/init', '_3dp_register_surface_finish_block' );
}
/**
 * 推荐文件路径：inc/acf/blocks.php
 * 注册 How It Works (工艺流程步骤) 积木
 */

if ( function_exists( 'acf_register_block_type' ) ) {

    function _3dp_register_how_it_works_block() 
    {
        acf_register_block_type( array(
            'name'              => 'how-it-works',
            'title'             => __( 'How It Works (Step Module)', '3d-printing' ),
            'description'       => __( '展示工艺生产流程的交互式步骤模块，包含沉浸式大图、数据指标及专家提示。', '3d-printing' ),
            'render_template'   => 'blocks/global/how-it-works/render.php',
            'category'          => 'layout',
            'icon'              => 'media-interactive', // 使用具有交互感和多媒体感的图标
            'keywords'          => array( 'process', 'steps', 'how it works', 'manufacturing', 'sls' ),
            
            // 核心交互设置
            'mode'              => 'auto',  // 允许在内容区域直接编辑，提供沉浸式建模体验
            'align'             => 'full',  // 默认支持全宽布局，以匹配深色工业面板的设计
            
            // 功能支持
            'supports'          => array(
                'align'     => array( 'full' ), // 强制支持全宽，确保视觉冲击力
                'anchor'    => true,            // 支持 SEO 锚点，方便从页面导航直接跳转到流程介绍
                'mode'      => true,            // 允许手动切换编辑和预览模式
                'jsx'       => true,            // 预留内部积木嵌套能力
            ),

            // 示例数据（用于积木选择器中的预览）
            'example'           => array(
                'attributes' => array(
                    'mode' => 'preview',
                    'data' => array(
                        'is_preview' => true
                    )
                )
            ),
        ) );
    }

    // 挂载到 acf/init 钩子，确保安全性
    add_action( 'acf/init', '_3dp_register_how_it_works_block' );
}

/**
 * 注册 Capability Design Guide 积木身份
 * 挂载于 acf/init 钩子中
 */
if ( function_exists( 'acf_register_block_type' ) ) {
    function _3dp_register_capability_design_guide_block() {
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
            'supports'          => array(
                'align'     => array( 'full' ),
                'anchor'    => true,
                'mode'      => true,
            ),
        ) );
    }
    add_action( 'acf/init', '_3dp_register_capability_design_guide_block' );
}

/**
 * 注册 Order Process Block
 * 挂载于 acf/init 钩子中
 */
if ( function_exists( 'acf_register_block_type' ) ) {
    function _3dp_register_order_process_block() {
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
            'supports'          => array(
                'align'     => array( 'full' ),
                'anchor'    => true,
                'mode'      => true,
            ),
        ) );
    }
    add_action( 'acf/init', '_3dp_register_order_process_block' );
}

/**
 * 注册 Material Comparison Block
 * 挂载于 acf/init 钩子中
 */
if ( function_exists( 'acf_register_block_type' ) ) {
    function _3dp_register_material_comparison_block() {
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
            'supports'          => array(
                'align'     => array( 'full' ),
                'anchor'    => true,
                'mode'      => true,
            ),
        ) );
    }
    add_action( 'acf/init', '_3dp_register_material_comparison_block' );
}

/**
 * 注册 Capability List Block
 * 挂载于 acf/init 钩子中
 */
if ( function_exists( 'acf_register_block_type' ) ) {
    function _3dp_register_capability_list_block() {
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
            'supports'          => array(
                'align'     => array( 'full' ),
                'anchor'    => true,
                'mode'      => true,
            ),
        ) );
    }
    add_action( 'acf/init', '_3dp_register_capability_list_block' );
}

if ( function_exists( 'acf_register_block_type' ) ) {
    add_action( 'acf/init', function() {
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
            'supports'          => array(
                'align'     => array( 'full' ),
                'anchor'    => true,
                'mode'      => true,
            ),
        ) );
    } );
}
