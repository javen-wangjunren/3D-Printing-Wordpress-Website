<?php
/**
 * Assets Enqueue
 * 
 * 负责加载：
 * 1. Alpine.js (交互核心)
 * 2. Tailwind CSS (开发模式下的 JIT 编译器与配置)
 * 3. Google Fonts (Inter + JetBrains Mono)
 * 4. 主题自定义 JS/CSS
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

add_action( 'wp_enqueue_scripts', function() {

    // 1. Google Fonts (Inter + JetBrains Mono)
    wp_enqueue_style( 
        'google-fonts', 
        'https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=JetBrains+Mono:wght@400;500;600&display=swap', 
        array(), 
        null 
    );

    // 2. Alpine.js (Defer loading) - 使用 cdnjs 替代 unpkg 以提高稳定性
    wp_enqueue_script( 
        'alpine-js', 
        'https://cdnjs.cloudflare.com/ajax/libs/alpinejs/3.13.3/cdn.min.js', 
        array(), 
        '3.13.3', 
        array( 'strategy' => 'defer' ) 
    );

    // 3. Tailwind CSS (Compiled)
    // 加载本地编译后的 Tailwind CSS，使用 filemtime 自动清除缓存
    // 开发阶段优先加载未压缩的 style.css 以便于调试
    $tailwind_css_files = array(
        'assets/css/style.css',
        'assets/css/style.min.css',
    );

    foreach ( $tailwind_css_files as $tailwind_css_file ) {
        $tailwind_css_path = get_stylesheet_directory() . '/' . $tailwind_css_file;
        $tailwind_css_uri = get_stylesheet_directory_uri() . '/' . $tailwind_css_file;

        if ( file_exists( $tailwind_css_path ) ) {
            wp_enqueue_style(
                'tdp-tailwind',
                $tailwind_css_uri,
                array( 'generatepress-style' ),
                filemtime( $tailwind_css_path )
            );
            break;
        }
    }

    // 4. 自定义 JS (如果有)
    // wp_enqueue_script( 'tdp-main', get_stylesheet_directory_uri() . '/assets/js/main.js', array('alpine-js'), TDP_VERSION, true );

} );
