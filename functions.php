<?php
/**
 * 3D Printing Child Theme - 主控文件
 * ==========================================================================
 * 文件作用:
 * 这个文件是整个主题的"总指挥部" (Bootstrap Loader)。
 * 它只负责定义常量、加载模块文件和核心资源，严格遵循"关注点分离"原则，
 * 不直接包含具体的业务逻辑代码。
 *
 * 核心逻辑:
 * 1. 初始化: 定义主题版本、路径等常量。
 * 2. 模块加载: 自动加载 `inc/` 目录下的功能模块 (ACF, CPT, Helpers 等)。
 * 3. 样式加载: 按 GeneratePress 规范加载父主题样式 (子主题样式由 Tailwind 处理)。
 * 4. SVG 支持: 允许上传 SVG 文件 (这是唯一的例外逻辑，因为比较简短)。
 *
 * 架构角色:
 * 它是 WordPress 启动主题时的入口。在 GeneratePress + Tailwind + ACF 架构中，
 * 它确保所有积木 (模块) 被正确组装。
 *
 * 🚨 避坑指南:
 * - ❌ 不要在这里写具体的 `add_action` 或 `add_filter` 逻辑 (SVG 除外)。
 * - ✅ 新功能请在 `inc/` 目录下新建文件，然后在这里的 `$tdp_inc_files` 数组注册。
 * - 样式加载顺序：父主题 -> 子主题 (Tailwind)。
 * ==========================================================================
 */

// 🚫 防止直接访问
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/**
 * ==================================================
 * I. 主题常量定义 (Constants)
 * ==================================================
 */
define( 'TDP_VERSION', '0.1.0' );
define( 'TDP_THEME_DIR', get_stylesheet_directory() );
define( 'TDP_THEME_URI', get_stylesheet_directory_uri() );
define( 'TDP_INC_DIR', TDP_THEME_DIR . '/inc' );

/**
 * ==================================================
 * II. 核心模块加载 (Module Loading)
 * ==================================================
 * 
 * ⚠️ 架构原则：
 * - functions.php 只负责「加载」
 * - 具体业务逻辑请移步至 inc/ 目录
 */

$tdp_inc_files = [
    'setup.php',             // 主题初始化 / 基础支持 (Theme Support)
    'assets.php',            // 资源加载 (CSS/JS)
    'options-page.php',      // ACF 全局选项页 (Theme Options)
    'post-types.php',        // 自定义文章类型 (CPT: Capability, Material...)
    'taxonomies.php',        // 自定义分类法 (Taxonomies)
    'acf/fields.php',        // ACF 字段定义 (PHP 导出)
    'acf/blocks.php',        // ACF Blocks 注册
    'helpers.php',           // 全局工具函数 (Helper Functions)
    'template-functions.php',// 模板专用业务逻辑 (Template Logic)
    'blog-template-functions.php', // Blog 模板逻辑 (TOC / Read Time)
    'duplicate.php',         // 文章复制功能 (Post Duplication)
    'admin-filters.php',     // 后台列表筛选增强
    'disable-comments.php',  // 禁用评论功能
    'seo.php',               // SEO 相关逻辑 (Meta Tags, Sitemap)
    'tracking.php',          // 跟踪代码注入 (GTM, Google Analytics)
];

// 1. 自动加载 ACF 字段文件 (inc/acf/field/*.php)
foreach ( glob( TDP_INC_DIR . '/acf/field/*.php' ) as $field_file ) {
    require_once $field_file;
}

// 2. 加载核心功能模块
foreach ( $tdp_inc_files as $file ) {
    $path = TDP_INC_DIR . '/' . $file;

    if ( file_exists( $path ) ) {
        require_once $path;
    } else {
        // 开发环境下提示缺失文件，方便调试
        if ( defined( 'WP_DEBUG' ) && WP_DEBUG ) {
            error_log( "❌ 3DP Theme Error: 核心文件缺失 - {$file}" );
        }
    }
}

/**
 * ==================================================
 * III. 样式与资源加载 (Styles & Assets)
 * ==================================================
 */
add_action( 'wp_enqueue_scripts', function () {

    // 1. 加载父主题样式 (GeneratePress)
    // 必须优先加载，以便子主题可以覆盖它
    wp_enqueue_style(
        'generatepress-style',
        get_template_directory_uri() . '/style.css',
        [],
        wp_get_theme()->parent()->get( 'Version' )
    );

    // 2. 子主题样式
    // 注意：实际的样式通过 Tailwind 编译在 inc/assets.php 中加载
    // 这里的 style.css 仅作为 WordPress 主题识别文件，不包含实际样式
    
}, 10 );

/**
 * ==================================================
 * IV. 辅助功能 (Utilities)
 * ==================================================
 * 这里的代码比较简短，暂时保留在此，如果变长建议移入 inc/helpers.php
 */

/** 
 * 允许 WordPress 上传 SVG 文件 
 * 
 * 核心逻辑:
 * 1. 扩展 upload_mimes 允许 svg 类型。
 * 2. 修正 wp_check_filetype_and_ext 防止安全检查误杀。
 */ 
add_filter( 'upload_mimes', function( $mimes ) { 
    $mimes['svg'] = 'image/svg+xml'; 
    return $mimes; 
} ); 

add_filter( 'wp_check_filetype_and_ext', function( $data, $file, $filename, $mimes ) { 
    $filetype = wp_check_filetype( $filename, $mimes ); 
    return [ 
        'ext'             => $filetype['ext'], 
        'type'            => $filetype['type'], 
        'proper_filename' => $data['proper_filename'] 
    ]; 
}, 10, 4 );

/**
 * ==================================================
 * 🎯 开发规范备忘
 * ==================================================
 * 
 * 新增功能时，请思考：
 * 1. 这是一个 CPT 吗？ -> inc/post-types.php
 * 2. 这是一个 ACF 字段吗？ -> inc/acf/fields.php
 * 3. 这是一个通用函数吗？ -> inc/helpers.php
 * 4. 这是一个只针对后台的修改吗？ -> inc/admin-filters.php
 * 5. 这是一个模板逻辑吗？ -> inc/template-functions.php
 * 
 * 保持 functions.php 干净整洁！
 */
