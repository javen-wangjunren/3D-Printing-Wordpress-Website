<?php
/**
 * Theme Assets Management (前端资源加载)
 * ==========================================================================
 * 文件作用:
 * 负责管理 WordPress 前端页面的资源加载 (Enqueue Scripts & Styles)。
 * 核心任务是引入 Tailwind 编译后的 CSS、Google Fonts 以及交互库 (Alpine.js)。
 *
 * 核心逻辑:
 * 1. 加载字体 (Google Fonts: Inter + JetBrains Mono)。
 * 2. 加载交互库 (Alpine.js, Swiper)。
 * 3. 加载样式表 (Tailwind Compiled CSS)。
 * 4. 资源瘦身 (Dequeue unused scripts): 移除不用的 GP 原生脚本和 Emoji 脚本。
 *
 * 架构角色:
 * [Asset Controller]
 * 它是连接 "开发环境" (Tailwind CLI) 和 "运行环境" (WordPress Frontend) 的桥梁。
 * 这里的 `assets/css/style.css` 就是 Tailwind CLI 编译输出的目标文件。
 *
 * 🚨 避坑指南:
 * 1. Tailwind 路径: 必须确保 `assets/css/style.css` 存在，这是 `npx tailwindcss` 的输出目标。
 * 2. 缓存清除: 使用 `filemtime()` 作为版本号，每次 CSS 文件修改后自动刷新浏览器缓存。
 * 3. 依赖关系: Tailwind CSS 依赖于 `generatepress-style`，确保覆盖 GP 原生样式。
 * ==========================================================================
 * 
 * @package GeneratePress_Child
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly.
}

add_action( 'wp_enqueue_scripts', function() {

    // ==========================================================================
    // I. 基础资源 (Fonts & Libraries)
    // ==========================================================================

    // 1. Google Fonts
    // Inter (正文) + JetBrains Mono (代码/数据)
    wp_enqueue_style( 
        'google-fonts', 
        'https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=JetBrains+Mono:wght@400;500;600&display=swap', 
        array(), 
        null 
    );

    // 2. Alpine.js (Lightweight Reactivity)
    // 使用 cdnjs 替代 unpkg 以提高国内/全球访问稳定性
    // 策略: defer 加载，避免阻塞渲染
    wp_enqueue_script( 
        'alpine-js', 
        'https://cdnjs.cloudflare.com/ajax/libs/alpinejs/3.13.3/cdn.min.js', 
        array(), 
        '3.13.3', 
        array( 'strategy' => 'defer' ) 
    );

    // 3. Swiper (Slider Component)
    // 用于 Industry Slider, Trusted By 等轮播模块
    wp_enqueue_style( 
        'swiper-css', 
        'https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css', 
        array(), 
        '11.0.0' 
    );
    
    wp_enqueue_script( 
        'swiper-js', 
        'https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js', 
        array(), 
        '11.0.0', 
        true // 在 footer 加载
    );

    // ==========================================================================
    // II. 核心样式表 (Tailwind CSS)
    // ==========================================================================

    /**
     * 加载本地编译后的 Tailwind CSS
     * 
     * 编译链路: 
     * src/input.css -> (Tailwind CLI) -> assets/css/style.css -> (WordPress Enqueue)
     */
    $tailwind_css_file = 'assets/css/style.css';
    $tailwind_css_path = get_stylesheet_directory() . '/' . $tailwind_css_file;
    $tailwind_css_uri  = get_stylesheet_directory_uri() . '/' . $tailwind_css_file;

    if ( file_exists( $tailwind_css_path ) ) {
        wp_enqueue_style(
            'tdp-tailwind', // Handle Name
            $tailwind_css_uri,
            array( 'generatepress-style' ), // 依赖: 确保在 GP 样式之后加载，以便覆盖
            filemtime( $tailwind_css_path ) // 版本号: 使用文件修改时间，实现自动缓存清除 (Cache Busting)
        );
    }

    // ==========================================================================
    // III. 资源瘦身 (Performance Optimization)
    // ==========================================================================

    // 1. 禁用未使用的 GP 原生脚本
    // 我们完全接管了 Header 和 Navigation (使用 Alpine.js)，不需要 GP 的 jQuery 脚本
    wp_dequeue_script( 'generate-menu' );
    wp_dequeue_script( 'generate-navigation' );
    
    // 2. 禁用评论脚本 (本站不开放评论)
    if ( ! is_single() || ! comments_open() ) {
        wp_dequeue_script( 'comment-reply' );
    }
    
    // 3. 禁用 WordPress Emoji 脚本 (减少 HTTP 请求)
    remove_action( 'wp_head', 'print_emoji_detection_script', 7 );
    remove_action( 'wp_print_styles', 'print_emoji_styles' );

} );
