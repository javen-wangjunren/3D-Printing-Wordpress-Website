<?php
/**
 * 快速复制文章功能
 * 为 Material CPT 添加 "Duplicate" 按钮，方便快速新建相似材料
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/**
 * 1. 在文章列表的操作行添加 "Duplicate" 链接
 */
add_filter( 'post_row_actions', '_3dp_duplicate_post_link', 10, 2 );
add_filter( 'page_row_actions', '_3dp_duplicate_post_link', 10, 2 );

function _3dp_duplicate_post_link( $actions, $post ) {
    // 仅针对 material 和 capability 类型开启
    if ( ! in_array( $post->post_type, array( 'material', 'capability' ) ) ) {
        return $actions;
    }

    if ( ! current_user_can( 'edit_posts' ) ) {
        return $actions;
    }

    $url = wp_nonce_url(
        add_query_arg(
            array(
                'action' => '_3dp_duplicate_post_as_draft',
                'post'   => $post->ID,
            ),
            admin_url( 'admin.php' )
        ),
        basename( __FILE__ ),
        'duplicate_nonce'
    );

    $actions['duplicate'] = '<a href="' . esc_url( $url ) . '" title="Duplicate this item" rel="permalink">Duplicate</a>';

    return $actions;
}

/**
 * 2. 处理复制逻辑
 */
add_action( 'admin_action__3dp_duplicate_post_as_draft', '_3dp_duplicate_post_as_draft' );

function _3dp_duplicate_post_as_draft() {
    // 安全检查
    if ( ! ( isset( $_GET['post'] ) || isset( $_POST['post'] ) ) || ( isset( $_REQUEST['action'] ) && '_3dp_duplicate_post_as_draft' != $_REQUEST['action'] ) ) {
        wp_die( 'No post to duplicate has been supplied!' );
    }

    if ( ! isset( $_GET['duplicate_nonce'] ) || ! wp_verify_nonce( $_GET['duplicate_nonce'], basename( __FILE__ ) ) ) {
        return;
    }

    // 获取原始文章数据
    $post_id = ( isset( $_GET['post'] ) ? absint( $_GET['post'] ) : absint( $_POST['post'] ) );
    $post    = get_post( $post_id );

    // 准备新文章数据
    $current_user = wp_get_current_user();
    $new_post_author = $current_user->ID;

    if ( isset( $post ) && $post != null ) {

        $args = array(
            'comment_status' => $post->comment_status,
            'ping_status'    => $post->ping_status,
            'post_author'    => $new_post_author,
            'post_content'   => $post->post_content,
            'post_excerpt'   => $post->post_excerpt,
            'post_name'      => '', // 让 WordPress 自动生成新的 slug
            'post_parent'    => $post->post_parent,
            'post_password'  => $post->post_password,
            'post_status'    => 'draft', // 默认为草稿
            'post_title'     => $post->post_title . ' (Copy)',
            'post_type'      => $post->post_type,
            'to_ping'        => $post->to_ping,
            'menu_order'     => $post->menu_order
        );

        // 插入新文章
        $new_post_id = wp_insert_post( $args );

        // 复制分类 (Taxonomies)
        $taxonomies = get_object_taxonomies( $post->post_type );
        foreach ( $taxonomies as $taxonomy ) {
            $post_terms = wp_get_object_terms( $post_id, $taxonomy, array( 'fields' => 'slugs' ) );
            wp_set_object_terms( $new_post_id, $post_terms, $taxonomy, false );
        }

        // 复制 Meta 字段 (包括 ACF)
        $post_meta_infos = get_post_meta( $post_id );
        if ( count( $post_meta_infos ) != 0 ) {
            foreach ( $post_meta_infos as $meta_key => $meta_values ) {
                foreach ( $meta_values as $meta_value ) {
                    // 使用 add_post_meta 而不是 update_post_meta 以支持多个同名 meta key
                    // 使用 wp_slash 处理反斜杠问题
                    add_post_meta( $new_post_id, $meta_key, wp_slash( $meta_value ) );
                }
            }
        }

        // 跳转到新文章的编辑页面
        wp_redirect( admin_url( 'post.php?action=edit&post=' . $new_post_id ) );
        exit;
    } else {
        wp_die( 'Post creation failed, could not find original post: ' . $post_id );
    }
}
