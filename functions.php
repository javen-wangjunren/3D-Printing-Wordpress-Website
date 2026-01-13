<?php
/**
 * Theme Name: 3D Printing Child Theme
 * Description: GeneratePress 子主题（开发阶段）
 * Author: Your Name
 * Template: generatepress
 * Version: 0.1.0
 */

// 🚫 防止直接访问
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/**
 * ==================================================
 * 1️⃣ 主题常量（开发阶段）
 * ==================================================
 */
define( 'TDP_VERSION', '0.1.0' );
define( 'TDP_THEME_DIR', get_stylesheet_directory() );
define( 'TDP_THEME_URI', get_stylesheet_directory_uri() );
define( 'TDP_INC_DIR', TDP_THEME_DIR . '/inc' );

/**
 * ==================================================
 * 2️⃣ 加载 inc/ 核心文件（只做结构，不做业务）
 * ==================================================
 *
 * ⚠️ 原则：
 * - functions.php 只负责「加载」
 * - 所有 add_action / add_filter 写在 inc/ 中
 */

$tdp_inc_files = [
    'setup.php',        // 主题支持 / 基础设置
    'assets.php',       // CSS / JS 资源加载（可先空）
    'options-page.php', // ACF 选项页注册
    'post-types.php',   // CPT：Capability / Material
    'taxonomies.php',   // 自定义分类法
    'acf/fields.php',   // ACF 字段组
    'acf/blocks.php',   // ACF Blocks 注册
    'helpers.php',      // 通用工具函数
    'seo.php',          // SEO 增强（开发阶段可为空）
];

foreach ( $tdp_inc_files as $file ) {
    $path = TDP_INC_DIR . '/' . $file;

    if ( file_exists( $path ) ) {
        require_once $path;
    } else {
        // 开发环境下提示缺失文件
        if ( defined( 'WP_DEBUG' ) && WP_DEBUG ) {
            error_log( "❌ 3DP Theme: inc 文件缺失 - {$file}" );
        }
    }
}

/**
 * ==================================================
 * 3️⃣ 加载父主题 & 子主题样式（GeneratePress 标准）
 * ==================================================
 */
add_action( 'wp_enqueue_scripts', function () {

    // 父主题样式
    wp_enqueue_style(
        'generatepress-style',
        get_template_directory_uri() . '/style.css',
        [],
        wp_get_theme()->parent()->get( 'Version' )
    );

    // 子主题样式
    wp_enqueue_style(
        'tdp-child-style',
        get_stylesheet_uri(),
        [ 'generatepress-style' ],
        TDP_VERSION
    );

}, 10 );

/**
 * ==================================================
 * 4️⃣ ACF JSON 同步（开发 & 版本控制友好）
 * ==================================================
 */

add_filter( 'acf/settings/save_json', function () {
    return TDP_THEME_DIR . '/acf-json';
} );

add_filter( 'acf/settings/load_json', function ( $paths ) {
    unset( $paths[0] );
    $paths[] = TDP_THEME_DIR . '/acf-json';
    return $paths;
} );

/**
 * ==================================================
 * 🎯 开发阶段说明
 * ==================================================
 *
 * ❌ 这里不放：
 * - SEO schema
 * - 性能优化
 * - 安全硬化
 * - rewrite / permalink 操作
 *
 * ✅ 所有功能请放入 inc/ 中对应文件
 */
