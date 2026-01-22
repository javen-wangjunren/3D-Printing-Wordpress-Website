<?php

/**
 * 1) 作为主题入口的“基础配置层”
 * - functions.php 会 require_once inc/setup.php，所以它会在主题加载时最早执行。
 * - 适合放 add_action / add_filter 这类“全局规则”，例如编辑器策略、后台 UI 精简等。
 *
 * 2) 目前这个文件具体做了什么
 * - 控制 Page 是否启用内容编辑器（古腾堡/经典编辑器）
 *   - 读取页面级 ACF 开关 page_enable_content_editor
 *   - 若关闭：禁用 Gutenberg，并移除 editor 支持（后台不再显示内容编辑区）
 * - 精简 Page 编辑页 UI
 *   - 移除 “Slug” 元框
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

add_action( 'after_setup_theme', function() {
	register_nav_menus( array(
		'footer_capabilities' => 'Footer – Capabilities',
		'footer_materials'    => 'Footer – Materials',
		'footer_resources'    => 'Footer – Resources',
		'footer_company'      => 'Footer – Company',
	) );
} );

add_filter( 'use_block_editor_for_post', function( $use_block_editor, $post ) {
    if ( ! $post || 'page' !== $post->post_type ) {
        return $use_block_editor;
    }

    $template = get_page_template_slug( $post );

    $meta_value = get_post_meta( $post->ID, 'page_enable_content_editor', true );
    if ( '' === $meta_value && in_array( $template, array( 'templates/page-all-capabilities.php' ), true ) ) {
        $meta_value = '0';
    }

    $content_editor_enabled = '' === $meta_value ? true : ( '1' === (string) $meta_value );
    if ( ! $content_editor_enabled ) {
        return false;
    }

    return $use_block_editor;
}, 10, 2 );

add_action( 'current_screen', function( $screen ) {
    if ( ! is_admin() ) {
        return;
    }

    if ( ! $screen || 'post' !== $screen->base || 'page' !== $screen->post_type ) {
        return;
    }

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
 * 🛠️ GeneratePress 默认样式/布局覆盖
 * 
 * 为了让 Tailwind CSS 完全接管设计，我们需要禁用或强制覆盖 GP 的部分默认行为。
 * 这样可以减少 Customizer 设置对开发的影响。
 */

// 1. 强制全局 "无侧边栏" (No Sidebar)
// 我们使用 Tailwind Grid/Flex 自己控制布局，不需要 GP 的侧边栏逻辑
// 确保 404 和 搜索结果页 也遵循此规则
add_filter( 'generate_sidebar_layout', function( $layout ) {
    return 'no-sidebar';
}, 999 );

// 强制 404 和 搜索页 使用全宽容器
// 配合 generate_container_width 过滤器，确保这些页面没有 max-width 限制
add_filter( 'generate_container_width', function( $width ) {
    return '2000'; // 足够大的值，实际上配合 CSS 的 max-w-full
} );

// 2. 禁用 GP 默认的 H1 标题输出
// 我们会在 Block 或 Template 中自己写 H1
add_filter( 'generate_show_title', '__return_false' );

// 3. 强制页面容器为 "全宽" (Full Width)
// 这样 #content 容器不会有默认的 max-width 限制，方便我们用 Tailwind 的 max-w-container 控制
add_filter( 'generate_container_width', function( $width ) {
    return '2000'; // 设置一个足够大的值，或者配合 CSS 让它 100%
} );

// 4. 清理 WindPress 旧配置 (已废弃，改用本地编译)
// (原 WindPress 配置代码已移除)

/**
 * 🛠️ 自定义模板加载逻辑 (Template Loader)
 * 
 * 强制将 CPT (Capability, Material) 的单页模板指向 templates/ 目录
 * 避免文件散落在根目录，保持结构整洁
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

    return $template;
} );

/**
 * 🚀 性能优化：按需加载 Gutenberg 样式 (Block Library CSS)
 * 
 * 逻辑：
 * 1. 全定制模板 (templates/ 目录下的页面) -> 彻底移除 wp-block-library，实现 0 CSS 冗余
 * 2. 普通文章 (Single Post) -> 保留，确保兼容性
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

    // B: 是否为全定制 CPT (Capability / Material)
    // 这些 CPT 在上方 template_include 中已被强制指向 templates/ 目录
    $is_custom_cpt = is_singular( array( 'capability', 'material' ) );

    // 3. 执行移除
    if ( $is_custom_page || $is_custom_cpt ) {
        wp_dequeue_style( 'wp-block-library' );
        wp_dequeue_style( 'wp-block-library-theme' );
        wp_dequeue_style( 'global-styles' ); // 移除 theme.json 生成的内联样式 (SVG 预设等)
    }
}, 100 );

