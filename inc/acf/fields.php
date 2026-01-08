<?php
/**
 * 集中加载所有模块的字段定义
 * 位置: /inc/acf/fields.php
 */

if ( function_exists( 'acf_add_local_field_group' ) ) {
    
    // 获取具体字段定义文件夹的路径
    $fields_dir = get_stylesheet_directory() . '/inc/acf/field/';

    // 模式 A：自动加载（推荐）
    // 自动扫描文件夹下所有的 .php 文件，省去手动 require 的麻烦
    foreach ( glob( $fields_dir . "*.php" ) as $filename ) {
        require_once $filename;
    }

    /* // 模式 B：手动加载（你目前的模式，如果想保留手动控制，就用这个）
    if ( file_exists( $fields_path . 'hero-banner.php' ) ) {
        require_once $fields_path . 'hero-banner.php';
    }
    */
}