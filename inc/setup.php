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
