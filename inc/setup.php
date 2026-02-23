<?php

/**
 * 1) 作为主题入口的“基础配置层”
 * - functions.php 会 require_once inc/setup.php，所以它会在主题加载时最早执行。
 * - 适合放 add_action / add_filter 这类“全局规则”，例如编辑器策略、后台 UI 精简等。
 *
 * 2) 目录结构
 * - I. 基础主题支持与初始化
 * - II. 布局与样式强制覆盖 (GeneratePress 核心)
 * - III. 内容编辑器控制 (古腾堡/经典)
 * - IV. 模板加载逻辑 (CPT 路由)
 * - V. 资源优化 (Gutenberg 样式清理)
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/**
 * ==================================================
 * I. 基础主题支持与初始化
 * ==================================================
 */

add_action( 'after_setup_theme', function() {
	// 注册自定义菜单位置
	register_nav_menus( array(
		'footer_capabilities' => 'Footer – Capabilities',
		'footer_materials'    => 'Footer – Materials',
		'footer_resources'    => 'Footer – Resources',
		'footer_company'      => 'Footer – Company',
	) );
} );


/**
 * ==================================================
 * II. 布局与样式强制覆盖 (GeneratePress 核心)
 * ==================================================
 * 
 * 🚨 核心：接管布局控制权
 * 经验总结：
 * 1. GP 的 Customizer 设置在全定制模板下不可靠，必须用 PHP 过滤器强制覆盖。
 * 2. Sidebar 必须用 add_filter('generate_sidebar_layout', 'no-sidebar') 禁用。
 * 3. 这确保了 Tailwind 全宽布局不会被主题默认逻辑破坏。
 */

// 1. 强制全局 "无侧边栏" (No Sidebar)
add_filter( 'generate_sidebar_layout', function( $layout ) {
    return 'no-sidebar';
}, 999 );

// 2. 强制页面容器为 "全宽" (Full Width)
add_filter( 'generate_container_width', function( $width ) {
    return '2000'; // 足够大的值，配合 CSS 的 max-w-full 撑开布局
} );

// 3. 禁用 GP 默认的 H1 标题输出 (我们会在 Block 中自己写)
add_filter( 'generate_show_title', '__return_false' );


/**
 * ==================================================
 * III. 内容编辑器控制 (古腾堡/经典)
 * ==================================================
 */

// 1. 前端/数据层：根据 ACF 开关决定是否启用 Gutenberg
add_filter( 'use_block_editor_for_post', function( $use_block_editor, $post ) {
    if ( ! $post || 'page' !== $post->post_type ) {
        return $use_block_editor;
    }

    $template = get_page_template_slug( $post );
    $meta_value = get_post_meta( $post->ID, 'page_enable_content_editor', true );

    // 默认值处理：All Capabilities 页面默认关闭编辑器
    if ( '' === $meta_value && in_array( $template, array( 'templates/page-all-capabilities.php' ), true ) ) {
        $meta_value = '0';
    }

    $content_editor_enabled = '' === $meta_value ? true : ( '1' === (string) $meta_value );
    if ( ! $content_editor_enabled ) {
        return false;
    }

    return $use_block_editor;
}, 10, 2 );

// 2. 后台 UI 层：根据开关移除编辑器支持和 Slug 元框
add_action( 'current_screen', function( $screen ) {
    if ( ! is_admin() ) {
        return;
    }

    if ( ! $screen || 'post' !== $screen->base || 'page' !== $screen->post_type ) {
        return;
    }

    // 始终移除 Slug 元框，保持界面整洁
    remove_meta_box( 'slugdiv', 'page', 'normal' );

    $post_id = 0;
    if ( isset( $_GET['post'] ) ) {
        $post_id = (int) $_GET['post'];
    } elseif ( isset( $_POST['post_ID'] ) ) {
        $post_id = (int) $_POST['post_ID'];
    }

    if ( ! $post_id ) {
        return;
    }

    $template = get_page_template_slug( $post_id );
    $meta_value = get_post_meta( $post_id, 'page_enable_content_editor', true );

    if ( '' === $meta_value && in_array( $template, array( 'templates/page-all-capabilities.php'), true ) ) {
        $meta_value = '0';
    }

    $content_editor_enabled = '' === $meta_value ? true : ( '1' === (string) $meta_value );
    if ( $content_editor_enabled ) {
        add_post_type_support( 'page', 'editor' );
    } else {
        remove_post_type_support( 'page', 'editor' );
    }
} );


/**
 * ==================================================
 * IV. 模板加载逻辑 (CPT 路由)
 * ==================================================
 * 
 * 强制将 CPT (Capability, Material, Solution) 的单页模板指向 templates/ 目录
 * 避免文件散落在主题根目录
 */

add_filter( 'template_include', function( $template ) {
    // 1. Single Capability
    if ( is_singular( 'capability' ) ) {
        $custom_template = locate_template( 'templates/single-capability.php' );
        if ( $custom_template ) {
            return $custom_template;
        }
    }

    // 2. Single Material
    if ( is_singular( 'material' ) ) {
        $custom_template = locate_template( 'templates/single-material.php' );
        if ( $custom_template ) {
            return $custom_template;
        }
    }

    // 3. Single Solution
    if ( is_singular( 'solution' ) ) {
        $custom_template = locate_template( 'templates/single-solution.php' );
        if ( $custom_template ) {
            return $custom_template;
        }
    }

    return $template;
} );


/**
 * ==================================================
 * V. 资源优化 (Gutenberg 样式清理)
 * ==================================================
 * 
 * 逻辑：全定制模板页面移除 wp-block-library，实现 0 CSS 冗余。single post 保留
 */

add_action( 'wp_enqueue_scripts', function() {
    // 1. 定义全定制页面模板列表 (相对于主题根目录)
    $custom_templates = array(
        'templates/page-home.php',
        'templates/page-about.php',
        'templates/page-contact.php',
        'templates/page-all-capabilities.php',
        'templates/page-all-materials.php',
    );

    // 2. 检查条件
    // A: 是否使用了上述 Page Templates
    $is_custom_page = is_page_template( $custom_templates );

    // B: 是否为全定制 CPT (Capability / Material / Solution)
    // 这些 CPT 在上方 template_include 中已被强制指向 templates/ 目录
    $is_custom_cpt = is_singular( array( 'capability', 'material', 'solution' ) );

    // 3. 执行移除
    if ( $is_custom_page || $is_custom_cpt ) {
        wp_dequeue_style( 'wp-block-library' );
        wp_dequeue_style( 'wp-block-library-theme' );
        wp_dequeue_style( 'global-styles' ); // 移除 theme.json 生成的内联样式 (SVG 预设等)
    }
}, 100 );

