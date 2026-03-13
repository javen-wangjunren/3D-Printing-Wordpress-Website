<?php
/**
 * ACF Field Loader (ACF 字段定义加载器)
 * ==========================================================================
 * 文件作用:
 * 集中加载所有模块的 ACF 字段定义文件。
 * 
 * 核心逻辑:
 * 1. 扫描 `inc/acf/field/` 目录：加载通用 Block 字段。
 * 2. 扫描 `inc/acf/cpt/` 目录：加载自定义文章类型 (CPT) 字段。
 * 3. 扫描 `inc/acf/pages/` 目录：加载特定页面 (Page Template) 字段。
 * 4. 扫描 `inc/acf/taxonomy/` 目录：加载分类法 (Taxonomy) 字段。
 *
 * 架构角色:
 * [Configuration Loader]
 * 这个文件是 ACF 字段配置的"总入口"。
 * 它确保了所有的 PHP 字段定义文件被 WordPress 识别并执行。
 * 使用 `glob()` 自动扫描机制，避免了每增加一个文件就要手动写一行 `require` 的麻烦。
 *
 * 🚨 避坑指南:
 * 1. 文件命名: 确保目录下的文件都是 `.php` 后缀。
 * 2. 加载顺序: 如果字段组之间有依赖（比如 Clone），加载顺序可能重要，但通常 ACF 会处理好。
 *    目前的加载顺序是: Fields -> CPT -> Pages -> Taxonomy。
 * ==========================================================================
 * 
 * @package GeneratePress_Child
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

// 仅在 ACF 插件激活且可用时执行
if ( function_exists( 'acf_add_local_field_group' ) ) {
    
    // 定义各类型字段的目录路径
    $base_dir = get_stylesheet_directory() . '/inc/acf/';
    
    $directories = array(
        'field'    => $base_dir . 'field/',    // 通用 Block 字段
        'cpt'      => $base_dir . 'cpt/',      // CPT 专属字段 (如 Material, Capability)
        'pages'    => $base_dir . 'pages/',    // 页面模板字段 (如 Home, Contact)
        'taxonomy' => $base_dir . 'taxonomy/', // 分类法字段 (如 Material Process)
    );

    // 遍历目录并加载文件（支持子目录）
    foreach ( $directories as $type => $path ) {
        if ( ! is_dir( $path ) ) {
            continue;
        }

        $php_files = array();
        $iterator  = new RecursiveIteratorIterator(
            new RecursiveDirectoryIterator( $path, FilesystemIterator::SKIP_DOTS )
        );

        foreach ( $iterator as $file ) {
            if ( ! $file->isFile() ) {
                continue;
            }

            if ( strtolower( $file->getExtension() ) !== 'php' ) {
                continue;
            }

            $php_files[] = $file->getPathname();
        }

        sort( $php_files );

        foreach ( $php_files as $filename ) {
            require_once $filename;
        }
    }

    /* 
    // [Legacy Mode] 手动加载示例
    // 如果某个文件需要特定顺序加载，可以在这里单独 require
    if ( file_exists( $directories['field'] . 'hero-banner.php' ) ) {
        require_once $directories['field'] . 'hero-banner.php';
    }
    */
}
