<?php
/**
 * SEO & Metadata Enhancements (SEO 增强与面包屑管理)
 * ==========================================================================
 * 文件作用:
 * 负责全站的 SEO 相关辅助逻辑，最主要的功能是**统一渲染面包屑导航**。
 * 它作为一个“胶水层”，适配不同的 SEO 插件（SEOPress, Yoast, RankMath），
 * 并强制应用主题统一的工业风样式。
 *
 * 核心逻辑:
 * 1. 挂载到 `generate_after_header` 钩子，自动在 Header 下方输出。
 * 2. 检测当前激活的 SEO 插件（优先级: SEOPress > Yoast > RankMath）。
 * 3. 使用 Tailwind CSS 统一包裹容器和文字样式，确保视觉一致性。
 *
 * 架构角色:
 * [View Layer - Component Adapter]
 * 它将第三方插件的输出（数据）适配到当前主题的 UI 系统（视图）中。
 * 
 * 🚨 避坑指南:
 * 1. 样式冲突: 如果 SEO 插件本身开启了“添加样式”，请在插件设置中关闭，完全交由本文件控制 CSS。
 * 2. 首页隐藏: 逻辑中已包含 `is_front_page()` 判断，首页不会显示面包屑。
 * ==========================================================================
 * 
 * @package GeneratePress
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/**
 * ==============================================================================
 * Breadcrumbs Implementation (面包屑导航 - 工业风 Utility Bar)
 * ==============================================================================
 * 
 * 逻辑:
 * 1. 排除首页。
 * 2. 依次检查 SEOPress, Yoast, RankMath 是否存在。
 * 3. 如果存在，输出统一的 HTML 容器 wrapper。
 * 4. 调用插件函数输出面包屑 HTML。
 * 
 * @hook generate_after_header (Priority 20: 确保在 Header 之后，Main Content 之前)
 */
add_action( 'generate_after_header', function() {
    
    // 1. Never show on Front Page (首页不显示面包屑)
    if ( is_front_page() ) {
        return;
    }

    // 定义统一的容器样式 (Utility Bar Style)
    // - w-full bg-bg-page border-b: 全宽背景带下划线
    // - max-w-container: 内容居中对齐
    // - font-mono uppercase: 工业风字体
    $wrapper_start = '<div class="w-full bg-bg-page border-b border-border">';
    $wrapper_inner = '<div class="max-w-container mx-auto px-container py-2 lg:py-3">';
    $wrapper_end   = '</div></div>';
    
    // 定义统一的文字排版样式
    // - text-[11px]: 小号字体
    // - text-muted: 弱化颜色
    // - [&_a:hover]:text-primary: 链接悬停高亮
    $typography_class = 'text-[11px] lg:text-xs font-mono text-muted uppercase tracking-wider leading-none [&_a]:text-muted [&_a:hover]:text-primary [&_.sep]:px-2';

    // 2. Check for SEOPress (Priority 1)
    if ( function_exists( 'seopress_display_breadcrumbs' ) ) {
        echo $wrapper_start . $wrapper_inner;
        echo '<div class="' . $typography_class . '">';
        seopress_display_breadcrumbs();
        echo '</div>';
        echo $wrapper_end;
        return;
    }

    // 3. Check for Yoast SEO (Priority 2)
    if ( function_exists( 'yoast_breadcrumb' ) ) {
        echo $wrapper_start . $wrapper_inner;
        yoast_breadcrumb( 
            '<p id="breadcrumbs" class="' . $typography_class . '">',
            '</p>' 
        );
        echo $wrapper_end;
        return;
    }

    // 4. Check for RankMath (Priority 3)
    if ( function_exists( 'rank_math_the_breadcrumbs' ) ) {
        echo $wrapper_start . $wrapper_inner;
        // RankMath 自带 wrapper，但我们可以在外面再包一层来控制布局
        echo '<div class="' . $typography_class . '">';
        rank_math_the_breadcrumbs();
        echo '</div>';
        echo $wrapper_end;
    }

}, 20 );

/**
 * ==============================================================================
 * H1 Safety Check (H1 安全检查 - 备用)
 * ==============================================================================
 * 
 * 如果页面没有 Hero Banner 模块，可能会导致页面缺少 H1 标签。
 * 下面的过滤器可以强制开启 GeneratePress 默认的标题输出。
 * 目前暂时注释掉，假设所有页面都由 Editor 正确配置了 Hero 模块。
 */
// add_filter( 'generate_show_title', 'tdp_control_content_title' );
