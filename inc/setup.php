<?php

/**
 * Setup 引导层（GeneratePress 子主题）
 * ==========================================================================
 * 文件作用:
 * - 作为主题入口的“基础配置层”，由 functions.php 最先加载
 * - 统一管理：布局接管、编辑器策略、模板路由、Gutenberg 样式清理
 *
 * 核心逻辑:
 * 1. 布局策略：强制无侧边栏 + 全宽容器，确保 Tailwind 视觉一致性
 * 2. 编辑器策略：仅文章(post)使用 Gutenberg；其余内容类型禁用 Gutenberg
 * 3. 模板路由：CPT 单页强制指向 templates/ 下的规范模板
 * 4. 样式清理：非文章页面移除 Gutenberg 样式，消除冗余 CSS
 *
 * 架构角色:
 * - 与 GeneratePress 协同，接管布局与编辑器行为，为 ACF 驱动的模板提供稳定运行环境
 *
 * 🚨 避坑指南:
 * - 禁止在此处做数据库查询或复杂业务逻辑，仅做全局性策略控制
 * - 若需在 Page 上启用经典编辑器，请在「后台 UI 层」按页面级开关控制
 * ==========================================================================
 */

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
	// 1. 注册自定义菜单位置
	register_nav_menus( array(
		'footer_capabilities' => 'Footer – Capabilities',
		'footer_materials'    => 'Footer – Materials',
		'footer_resources'    => 'Footer – Resources',
		'footer_company'      => 'Footer – Company',
	) );

    // 2. 启用古腾堡编辑器宽度支持 (Content Width)
    // 配合下面的 CSS 注入，确保编辑器不会溢出
    add_theme_support( 'align-wide' );
    add_theme_support( 'editor-styles' );
} );

/**
 * 注入古腾堡编辑器专用样式 (Admin Only)
 * 强制限制文章编辑区域宽度为 800px，并匹配前端 prose 风格
 */
add_action( 'enqueue_block_editor_assets', function() {
    $custom_css = "
        /* 限制编辑器主容器宽度 */
        .interface-interface-skeleton__content .wp-block-post-title,
        .interface-interface-skeleton__content .block-editor-block-list__layout {
            max-width: 800px !important;
            margin-left: auto !important;
            margin-right: auto !important;
        }
        /* 针对不同版本的 WordPress/Gutenberg 选择器适配 */
        .edit-post-visual-editor__content-area .wp-block {
            max-width: 800px !important;
        }
        /* 确保全宽/宽幅块依然能工作但受到 800px 约束（如果需要） */
        .wp-block[data-align='wide'] { max-width: 1000px !important; }
        .wp-block[data-align='full'] { max-width: none !important; }
    ";
    wp_add_inline_style( 'wp-edit-post', $custom_css );
}, 100 );


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
// 统一去掉 Sidebar，避免 GP 默认布局影响 Tailwind 设计
add_filter( 'generate_sidebar_layout', function( $layout ) {
    return 'no-sidebar';
}, 999 );

// 2. 强制页面容器逻辑 (GeneratePress 核心)
// - 页面 (Page) 保持 2000px 全宽，由 Tailwind 接管布局
// - 文章 (Post) 及其他内容类型恢复正常宽度 (如 800px) 以优化编辑器体验
add_filter( 'generate_container_width', function( $width ) {
    if ( is_singular( 'page' ) || ( is_admin() && isset( $_GET['post'] ) && 'page' === get_post_type( $_GET['post'] ) ) ) {
        return '2000';
    }
    return '800'; // 文章详情页建议阅读宽度
} );



/**
 * ==================================================
 * III. 内容编辑器控制 (古腾堡/经典)
 * ==================================================
 */

// 1. 编辑器策略：仅保留文章(post)使用 Gutenberg，其余全部禁用
// 说明：避免 Page/CPT 出现古腾堡 + ACF 的“双编辑器冲突”
add_filter( 'use_block_editor_for_post_type', function( $use_block_editor, $post_type ) {
	return ( 'post' === $post_type ) ? $use_block_editor : false;
}, 10, 2 );

// 2. 后台 UI 层：根据开关移除编辑器支持和 Slug 元框
// 说明：在 Page 维度保留开关，便于极端场景启用/禁用“经典编辑器”区域
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
 * 强制将 CPT (Capability, Material, Solution, Surface Finish) 的单页模板指向 templates/ 目录
 * 避免文件散落在主题根目录，确保路由一致性
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

    // 4. Single Surface Finish
    if ( is_singular( 'surface-finish' ) ) {
        $custom_template = locate_template( 'templates/single-surface-finish.php' );
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
 * 逻辑：非文章页面移除 Gutenberg 样式，实现 0 CSS 冗余；文章保留用于块编辑器渲染
 */

add_action( 'wp_enqueue_scripts', function() {
	// 除了文章(post)之外，其他页面统一移除 Gutenberg 样式
	if ( ! is_singular( 'post' ) ) {
		wp_dequeue_style( 'wp-block-library' );
		wp_dequeue_style( 'wp-block-library-theme' );
		wp_dequeue_style( 'global-styles' );
	}
}, 100 );

add_action( 'wp_head', function() {
	if ( is_singular( 'post' ) ) {
		echo '<style>.wp-block-image{margin-bottom:1.25rem}.wp-block-heading{margin-bottom:1.875rem}</style>';
	}
}, 5 );
