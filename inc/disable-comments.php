<?php
/**
 * 3D Printing Theme - Disable Comments
 * ==========================================================================
 * 文件作用:
 * 完全禁用 WordPress 的评论功能，包括后台菜单、顶栏链接、
 * 现有文章的评论开关以及前端评论框。
 *
 * 架构角色:
 * 管理全局功能的「功能开关」模块。
 * ==========================================================================
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/**
 * 1. 禁用现有文章类型的评论支持
 */
add_action( 'admin_init', function () {
    // 禁用所有文章类型的评论和 trackbacks 支持
    $post_types = get_post_types();
    foreach ( $post_types as $post_type ) {
        if ( post_type_supports( $post_type, 'comments' ) ) {
            remove_post_type_support( $post_type, 'comments' );
            remove_post_type_support( $post_type, 'trackbacks' );
        }
    }
} );

/**
 * 2. 关闭前端评论 (通过过滤器)
 */
add_filter( 'comments_open', '__return_false', 20, 2 );
add_filter( 'pings_open', '__return_false', 20, 2 );

/**
 * 3. 隐藏现有评论 (防止直接访问已存在的评论)
 */
add_filter( 'comments_array', '__return_empty_array', 10, 2 );

/**
 * 4. 从后台侧边栏移除 "评论" 菜单
 */
add_action( 'admin_menu', function () {
    remove_menu_page( 'edit-comments.php' );
} );

/**
 * 5. 如果有人直接访问评论页面，重定向到仪表盘
 */
add_action( 'admin_init', function () {
    global $pagenow;
    if ( $pagenow === 'edit-comments.php' ) {
        wp_safe_redirect( admin_url() );
        exit;
    }
} );

/**
 * 6. 从顶栏 (Admin Bar) 移除评论链接
 */
add_action( 'wp_before_admin_bar_render', function () {
    global $wp_admin_bar;
    $wp_admin_bar->remove_menu( 'comments' );
} );

/**
 * 7. 禁用 Dashboard 中的 "近期评论" 小部件
 */
add_action( 'wp_dashboard_setup', function () {
    remove_meta_box( 'dashboard_recent_comments', 'dashboard', 'normal' );
} );

/**
 * 8. 禁用评论相关的设置页面中的选项 (可选，主要是为了干净)
 */
add_action( 'admin_init', function () {
    // 隐藏讨论设置中的某些选项 (如果需要更彻底的隐藏，可以继续添加)
} );
