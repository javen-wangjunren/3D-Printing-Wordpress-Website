<?php
/**
 * SEO & Metadata Enhancements (SEO 增强与结构化数据)
 * ==========================================================================
 * 文件作用:
 * 1. 提供主题级面包屑导航 (Visual Breadcrumbs + JSON-LD BreadcrumbList)。
 * 2. 动态生成 FAQ 结构化数据 (JSON-LD FAQPage)，基于 ACF 字段。
 *
 * 核心逻辑:
 * 1. custom_breadcrumbs(): 模板函数，根据当前页面层级生成导航路径。
 * 2. inject_custom_faq_schema(): Hook 函数，自动读取 ACF Repeater 生成 Schema。
 * 3. 辅助函数: 处理 URL 解析、JSON 编码和单次渲染逻辑。
 *
 * 架构角色:
 * [View Layer - SEO Utility]
 * 替代传统 SEO 插件的部分功能，实现更轻量、更贴合 Tailwind 设计系统的 SEO 解决方案。
 * 
 * 🚨 避坑指南:
 * 1. 路径解析: 使用 get_page_by_path() 时需注意性能，已通过 static $cache 优化。
 * 2. Schema 冲突: 确保同一页面不重复输出 BreadcrumbList，使用 static 变量控制。
 * 3. ACF 依赖: FAQ Schema 强依赖 `inc/acf/field/faq.php` 定义的字段结构 (Repeater)。
 * ==========================================================================
 * 
 * @package GeneratePress_Child
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/**
 * I. 面包屑导航核心逻辑 (Breadcrumbs System)
 * --------------------------------------------------------------------------
 * 负责生成可视化的面包屑 HTML 结构，并自动注入对应的 JSON-LD Schema。
 * --------------------------------------------------------------------------
 */

/**
 * [Helper] 根据路径解析页面 URL (带缓存)
 * 
 * @param array|string $paths 页面路径数组 (如 ['all-materials'])
 * @return string 页面 URL 或空字符串
 */
function _3dp_breadcrumbs_resolve_page_url_by_paths( $paths ) {
    static $cache = array();

    foreach ( (array) $paths as $path ) {
        $path = is_string( $path ) ? trim( $path ) : '';
        if ( '' === $path ) {
            continue;
        }

        // 命中缓存直接返回
        if ( array_key_exists( $path, $cache ) ) {
            if ( $cache[ $path ] ) {
                return $cache[ $path ];
            }
            continue;
        }

        // 动态查询页面对象
        $page = get_page_by_path( $path );
        $cache[ $path ] = $page ? get_permalink( $page->ID ) : '';

        if ( $cache[ $path ] ) {
            return $cache[ $path ];
        }
    }

    return '';
}

/**
 * [Helper] 获取当前页面完整 URL
 * 
 * @return string 清除 query string 后的当前 URL
 */
function _3dp_breadcrumbs_current_url() {
    $request_uri = isset( $_SERVER['REQUEST_URI'] ) ? wp_unslash( $_SERVER['REQUEST_URI'] ) : '/';
    $request_uri = strtok( $request_uri, '?' );
    return home_url( $request_uri ? $request_uri : '/' );
}

/**
 * [Builder] 构建面包屑数组结构
 * 
 * 根据当前页面类型 (CPT, Page, Post) 构建层级数组。
 * 
 * @param string $home_label 首页显示的文本
 * @return array 面包屑数组 [['label' => 'Home', 'url' => '...'], ...]
 */
function _3dp_breadcrumbs_build_crumbs( $home_label ) {
    $crumbs = array(
        array(
            'label' => (string) $home_label,
            'url'   => home_url( '/' ),
        ),
    );

    // CPT: Material (材料详情页 -> All Materials)
    if ( is_singular( 'material' ) ) {
        $crumbs[] = array(
            'label' => 'All Materials',
            'url'   => _3dp_breadcrumbs_resolve_page_url_by_paths( array( 'all-materials' ) ),
        );
        $crumbs[] = array( 'label' => get_the_title(), 'url' => '' );
        return $crumbs;
    }

    // CPT: Capability (能力详情页 -> All Capabilities)
    if ( is_singular( 'capability' ) ) {
        $crumbs[] = array(
            'label' => 'All Capabilities',
            'url'   => _3dp_breadcrumbs_resolve_page_url_by_paths( array( 'all-capabilities' ) ),
        );
        $crumbs[] = array( 'label' => get_the_title(), 'url' => '' );
        return $crumbs;
    }

    // CPT: Surface Finish (表面处理详情页 -> All Surface Finishes)
    if ( is_singular( 'surface-finish' ) ) {
        $crumbs[] = array(
            'label' => 'All Surface Finishes',
            'url'   => _3dp_breadcrumbs_resolve_page_url_by_paths( array( 'all-surface-finish', 'all-surface-finishes' ) ),
        );
        $crumbs[] = array( 'label' => get_the_title(), 'url' => '' );
        return $crumbs;
    }

    // CPT: Solution (解决方案详情页 -> All Solutions)
    if ( is_singular( 'solution' ) ) {
        $crumbs[] = array(
            'label' => 'All Solutions',
            'url'   => _3dp_breadcrumbs_resolve_page_url_by_paths( array( 'all-solutions', 'solutions' ) ),
        );
        $crumbs[] = array( 'label' => get_the_title(), 'url' => '' );
        return $crumbs;
    }

    // Standard Post (博客文章 -> All Blogs)
    if ( is_singular( 'post' ) ) {
        $crumbs[] = array(
            'label' => 'All Blogs',
            'url'   => home_url( '/blogs/' ),
        );
        $crumbs[] = array( 'label' => get_the_title(), 'url' => '' );
        return $crumbs;
    }

    // Blog Archive (博客列表页)
    if ( is_home() ) {
        $crumbs[] = array( 'label' => 'All Blogs', 'url' => '' );
        return $crumbs;
    }

    // Standard Page (普通页面)
    if ( is_page() ) {
        $crumbs[] = array( 'label' => get_the_title(), 'url' => '' );
        return $crumbs;
    }

    // Default Fallback
    $crumbs[] = array( 'label' => get_the_title(), 'url' => '' );
    return $crumbs;
}

/**
 * [Renderer] 输出 JSON-LD Schema (单次执行)
 * 
 * 自动在页面中注入 BreadcrumbList 结构化数据，这对 SEO 至关重要。
 * 使用 static 变量确保同一请求周期内只输出一次。
 * 
 * @param array $crumbs 面包屑数组
 */
function _3dp_breadcrumbs_render_schema_once( $crumbs ) {
    static $schema_printed = false;
    if ( $schema_printed ) {
        return;
    }
    $schema_printed = true;

    $schema_items = array();
    $position     = 1;
    $current_url  = _3dp_breadcrumbs_current_url();

    foreach ( $crumbs as $item ) {
        $label = isset( $item['label'] ) ? (string) $item['label'] : '';
        $url   = ! empty( $item['url'] ) ? (string) $item['url'] : $current_url;

        if ( '' === $label ) {
            continue;
        }

        $schema_items[] = array(
            '@type'    => 'ListItem',
            'position' => $position,
            'name'     => $label,
            'item'     => $url,
        );
        $position++;
    }

    $schema_data = array(
        '@context'        => 'https://schema.org',
        '@type'           => 'BreadcrumbList',
        'itemListElement' => $schema_items,
    );

    echo "\n" . '<script type="application/ld+json">' . wp_json_encode( $schema_data, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE ) . '</script>' . "\n";
}

/**
 * [Public] 模板调用主函数
 * 
 * 在主题模板文件中调用此函数以渲染面包屑。
 * 
 * @param array $args 配置参数 (nav_class, link_class, home_label 等)
 */
function custom_breadcrumbs( $args = array() ) {
    if ( is_front_page() ) {
        return;
    }

    $args = wp_parse_args( $args, array(
        'nav_class'     => 'text-small text-muted mb-4 leading-snug flex items-center flex-wrap gap-2',
        'link_class'    => 'text-muted hover:text-primary transition-colors',
        'current_class' => 'text-heading font-medium',
        'sep_html'      => '<span class="text-muted/60">/</span>',
        'home_label'    => 'Home',
    ) );

    // 1. 构建数据
    $crumbs = _3dp_breadcrumbs_build_crumbs( (string) $args['home_label'] );

    // 2. 渲染 HTML (Visual)
    echo '<nav aria-label="breadcrumb" class="' . esc_attr( $args['nav_class'] ) . '">';

    $total = count( $crumbs );
    foreach ( $crumbs as $index => $item ) {
        $is_last = ( $index === $total - 1 );
        $label   = isset( $item['label'] ) ? (string) $item['label'] : '';
        $url     = isset( $item['url'] ) ? (string) $item['url'] : '';

        if ( '' === $label ) {
            continue;
        }

        if ( $index > 0 ) {
            echo $args['sep_html'];
        }

        if ( $is_last ) {
            echo '<span class="' . esc_attr( $args['current_class'] ) . '">' . esc_html( $label ) . '</span>';
            continue;
        }

        if ( $url ) {
            echo '<a href="' . esc_url( $url ) . '" class="' . esc_attr( $args['link_class'] ) . '">' . esc_html( $label ) . '</a>';
        } else {
            echo '<span class="' . esc_attr( $args['link_class'] ) . '">' . esc_html( $label ) . '</span>';
        }
    }

    echo '</nav>';

    // 3. 渲染 Schema (Metadata)
    _3dp_breadcrumbs_render_schema_once( $crumbs );
}


/**
 * II. FAQ 结构化数据 (Schema.org FAQPage)
 * --------------------------------------------------------------------------
 * 自动检测当前页面是否包含 FAQ 模块，并生成对应的 JSON-LD 数据。
 * --------------------------------------------------------------------------
 */

/**
 * [Action] 注入 FAQ Schema 到 <head>
 * 
 * 逻辑说明：
 * 1. 判断页面类型 (CPT 或 首页)。
 * 2. 确定 ACF Clone 字段的前缀 (prefix)。
 * 3. 读取 Repeater 数据并构建 JSON-LD。
 */
add_action('wp_head', 'inject_custom_faq_schema');

function inject_custom_faq_schema() {
    // 1. 范围检查：只在特定的 CPT 详情页或首页执行
    // 避免在无关页面运行，节省性能
    if ( ! is_singular( array( 'capability', 'material', 'surface-finish', 'solution' ) ) && ! is_front_page() ) {
        return;
    }

    // 2. 前缀映射：根据当前 Post Type 确定 ACF 字段前缀
    // 必须与 inc/acf/cpt/xxx.php 中定义的 prefix_name 保持一致
    $prefix = '';
    if ( is_front_page() ) {
        $prefix = 'home_faq_';
    } elseif ( is_singular( 'solution' ) ) {
        $prefix = 'solution_faq_';
    } elseif ( is_singular( 'material' ) ) {
        $prefix = 'mat_faq_';
    } elseif ( is_singular( 'capability' ) ) {
        $prefix = 'cap_faq_';
    } elseif ( is_singular( 'surface-finish' ) ) {
        $prefix = 'sf_faq_';
    }

    if ( empty( $prefix ) ) {
        return;
    }

    // 3. 数据获取：拼接完整的字段名 (如 'home_faq_faq_items')
    // 字段定义参考: inc/acf/field/faq.php
    $repeater_name = $prefix . 'faq_items';
    $faqs = get_field( $repeater_name );

    // 4. 空值检查：如果没有填写 FAQ，直接退出，不生成空 Schema
    if ( empty( $faqs ) ) {
        return;
    }

    // 5. 构建 Schema 对象
    $schema = array(
        '@context'   => 'https://schema.org',
        '@type'      => 'FAQPage',
        'mainEntity' => array()
    );

    // 6. 遍历并清洗数据
    foreach ( $faqs as $faq ) {
        // 确保问题和答案都不为空
        if ( empty( $faq['question'] ) || empty( $faq['answer'] ) ) {
            continue;
        }

        $schema['mainEntity'][] = array(
            '@type' => 'Question',
            'name'  => wp_strip_all_tags( $faq['question'] ), // 清除 HTML 标签，保证纯文本
            'acceptedAnswer' => array(
                '@type' => 'Answer',
                'text'  => wp_strip_all_tags( $faq['answer'] )
            )
        );
    }

    // 7. 二次检查：如果有效问答数为 0，退出
    if ( empty( $schema['mainEntity'] ) ) {
        return;
    }

    // 8. 输出 JSON-LD 代码块
    echo "\n" . '<script type="application/ld+json">' . wp_json_encode( $schema, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES ) . '</script>' . "\n";
}
