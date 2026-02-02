<?php
/**
 * Theme Name: 3D Printing Child Theme
 * Description: GeneratePress 子主题（开发阶段）
 * Author: Javen
 * Template: generatepress
 * Version: 1.0
 * 说明：
 * 这个文件是整个主题的总控台，只负责加载各种文件，不在这个文件里写业务逻辑
 * - 定义主题常量：版本、主题目录/URL、inc 目录入口
 * - 集中加载模块：把 inc/ 里的各功能文件一次性引入（主题设置、资源、ACF 字段/区块、CPT/Taxonomy、工具函数等）
 * - 加载样式：按 GeneratePress 规范，先加载父主题 CSS，再加载子主题 CSS
 * - ACF JSON 同步：把字段组的 JSON 存到主题内并在加载时优先使用，方便版本控制与多人协作
 * - 样式加载顺序固定：父主题先、子主题后，避免样式覆盖异常 （这个就得看怎么调整了，因为GP默认了很多样式了，我需要用子主题覆盖
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
    'duplicate.php',    // 文章复制功能
    'admin-filters.php',// 后台筛选增强
    'seo.php',          // SEO 增强（开发阶段可为空）
];

// 自动加载 inc/acf/field/ 目录下的所有字段文件
foreach ( glob( TDP_INC_DIR . '/acf/field/*.php' ) as $field_file ) {
    require_once $field_file;
}

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

    // 子主题样式 (已在 inc/assets.php 中通过 Tailwind 加载，此处不再重复加载以避免冲突)
    // 子主题样式
    // ⚠️ 注意：所有样式已迁移至 Tailwind (src/input.css -> assets/css/style.css)
    // 根目录 style.css 仅保留头部信息供 WordPress 识别，不再作为样式表加载
    /*
    wp_enqueue_style(
        'tdp-child-style',
        get_stylesheet_uri(),
        [ 'generatepress-style' ],
        TDP_VERSION
    );
    */

}, 10 );

/**
 * ==================================================
 * 4️⃣ ACF JSON 同步（开发 & 版本控制友好）
 * ==================================================
 */

// add_filter( 'acf/settings/save_json', function () {
//     return TDP_THEME_DIR . '/acf-json';
// } );

// add_filter( 'acf/settings/load_json', function ( $paths ) {
//     unset( $paths[0] );
//     $paths[] = TDP_THEME_DIR . '/acf-json';
//     return $paths;
// } );


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

/** 
 * 允许 WordPress 上传 SVG 文件 
 */ 
// 1. 添加 SVG 到允许上传的文件类型列表 
add_filter( 'upload_mimes', function( $mimes ) { 
    $mimes['svg'] = 'image/svg+xml'; 
    return $mimes; 
} ); 

// 2. 修正 WordPress 对文件类型检查的逻辑（确保不因扩展名冲突被拦截） 
add_filter( 'wp_check_filetype_and_ext', function( $data, $file, $filename, $mimes ) { 
    $filetype = wp_check_filetype( $filename, $mimes ); 
    return [ 
        'ext'             => $filetype['ext'], 
        'type'            => $filetype['type'], 
        'proper_filename' => $data['proper_filename'] 
    ]; 
}, 10, 4 );
