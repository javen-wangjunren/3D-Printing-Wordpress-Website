<?php
/**
 * 集中加载所有模块的字段定义
 * 位置: /inc/acf/fields.php
 * 作用：
 * - 集中入口：把主题里所有“字段定义文件”一次性加载进来，让 ACF 在后台显示对应的字段组
 * - 自动扫描：按目录自动找到并引入 .php（模块字段/自定义文章类型字段/页面专属字段），不用你手动一个个 require
 * - 安全护栏：只有在 ACF 可用时才加载，避免非 ACF 环境报错
 */

if ( function_exists( 'acf_add_local_field_group' ) ) {
    
    // 获取字段定义文件夹的路径
    $fields_dir = get_stylesheet_directory() . '/inc/acf/field/';
    $cpt_fields_dir = get_stylesheet_directory() . '/inc/acf/cpt/';
    $pages_fields_dir = get_stylesheet_directory() . '/inc/acf/pages/';

    // 模式 A：自动加载（推荐）
    // 自动扫描文件夹下所有的 .php 文件，省去手动 require 的麻烦
    foreach ( glob( $fields_dir . "*.php" ) as $filename ) {
        require_once $filename;
    }
    
    // 加载自定义文章类型的字段定义
    foreach ( glob( $cpt_fields_dir . "*.php" ) as $filename ) {
        require_once $filename;
    }
    
    // 加载页面特定的字段定义
    foreach ( glob( $pages_fields_dir . "*.php" ) as $filename ) {
        require_once $filename;
    }

    /* // 模式 B：手动加载（你目前的模式，如果想保留手动控制，就用这个）
    if ( file_exists( $fields_path . 'hero-banner.php' ) ) {
        require_once $fields_path . 'hero-banner.php';
    }
    */
}