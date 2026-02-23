<?php
/**
 * Admin Filters & Columns (后台列表页增强)
 * ==========================================================================
 * 文件作用:
 * 定制 WordPress 后台文章列表页 (Admin List Table) 的功能。
 * 包括：增加自定义筛选器、添加自定义列、批量操作等。
 *
 * 核心逻辑:
 * 1. Material 列表: 增加 "批量发布" 功能。
 * 2. Material 列表: 增加 Process 和 Type 的分类筛选器。
 * 3. Surface Finish 列表: 增加 "Related Capabilities" 列。
 * 4. Surface Finish 列表: 增加 "按 Capability 筛选" 的功能。
 * 5. 通用: 移除不必要的 "日期筛选" (Disable Months Dropdown)。
 *
 * 架构角色:
 * [Admin Infrastructure]
 * 这个文件只影响 WP Admin 后台的体验，不影响前端页面渲染。
 * 它属于 "基础设施" 代码，旨在提高内容管理员 (Content Editor) 的工作效率。
 *
 * 🚨 避坑指南:
 * 1. `pre_get_posts` 钩子极其强大但也危险，必须严格限定 `is_admin()`, `is_main_query()` 以及 `post_type`，
 *    否则可能导致前端页面崩溃或数据混乱。
 * 2. ACF Relationship 字段存储的是序列化数组，因此 Meta Query 只能用 `LIKE` 进行模糊匹配。
 * ==========================================================================
 * 
 * @package GeneratePress_Child
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

// ==========================================================================
// I. 批量操作 (Bulk Actions)
// ==========================================================================

/**
 * Material 列表页: 增加 "Publish" 批量操作
 * 方便管理员一次性发布多个草稿状态的材料
 */
add_filter( 'bulk_actions-edit-material', function( $bulk_actions ) {
    $bulk_actions['publish_posts'] = __( 'Publish', '3d-printing' );
    return $bulk_actions;
} );

add_filter( 'handle_bulk_actions-edit-material', function( $redirect_to, $action, $post_ids ) {
    if ( 'publish_posts' !== $action ) {
        return $redirect_to;
    }

    $published_count = 0;
    foreach ( $post_ids as $post_id ) {
        $post = get_post( $post_id );
        // 仅处理未发布的 material
        if ( 'material' === $post->post_type && 'publish' !== $post->post_status ) {
            wp_update_post( array(
                'ID'          => $post_id,
                'post_status' => 'publish',
            ) );
            $published_count++;
        }
    }

    // 重定向并携带处理数量参数
    return add_query_arg( 'bulk_published_posts', $published_count, $redirect_to );
}, 10, 3 );

// 显示批量发布成功的提示信息
add_action( 'admin_notices', function() {
    if ( ! empty( $_REQUEST['bulk_published_posts'] ) ) {
        $count = intval( $_REQUEST['bulk_published_posts'] );
        $message = sprintf( _n( '%s material published.', '%s materials published.', $count, '3d-printing' ), $count );
        echo '<div id="message" class="updated notice is-dismissible"><p>' . esc_html( $message ) . '</p></div>';
    }
} );

// ==========================================================================
// II. 通用筛选器优化 (General Filters)
// ==========================================================================

/**
 * 在 Material 和 Surface Finish 列表页移除 "All dates" 筛选器
 * 这里的文章通常是长青内容，按日期筛选没有意义
 */
add_filter( 'disable_months_dropdown', '_3dp_disable_months_dropdown', 10, 2 );

function _3dp_disable_months_dropdown( $disable, $post_type ) {
    if ( 'material' === $post_type || 'surface-finish' === $post_type ) {
        return true;
    }
    return $disable;
}

// ==========================================================================
// III. Material 列表增强 (Taxonomy Filters)
// ==========================================================================

/**
 * 在 Material 列表页增加 Material Process 和 Material Type 筛选器
 */
add_action( 'restrict_manage_posts', '_3dp_add_material_taxonomy_filters' );

function _3dp_add_material_taxonomy_filters( $post_type ) {
    // 仅针对 material 类型
    if ( 'material' !== $post_type ) {
        return;
    }

    // 定义要显示的分类法
    $taxonomies = array( 'material_process', 'material_type' );

    foreach ( $taxonomies as $taxonomy_slug ) {
        $taxonomy = get_taxonomy( $taxonomy_slug );
        if ( ! $taxonomy ) {
            continue;
        }

        // 获取当前选中的值
        $selected = isset( $_GET[ $taxonomy_slug ] ) ? $_GET[ $taxonomy_slug ] : '';

        wp_dropdown_categories( array(
            'show_option_all' => sprintf( __( 'All %s', '3d-printing' ), $taxonomy->label ),
            'taxonomy'        => $taxonomy_slug,
            'name'            => $taxonomy_slug, // name 属性必须匹配 query var
            'orderby'         => 'name',
            'selected'        => $selected,
            'show_count'      => false, // 隐藏数量（因默认仅统计 Published，会导致 Draft 计数为 0 产生误导）
            'hide_empty'      => false, // 即使为空也显示（可选，方便调试）
            'value_field'     => 'slug', // 使用 slug 作为 value，以便 URL 参数更友好
            'hierarchical'    => true,
        ) );
    }
}

// ==========================================================================
// IV. Surface Finish 列表增强 (Columns & Meta Filters)
// ==========================================================================

/**
 * 1. 自定义列: Related Capabilities
 */
add_filter( 'manage_surface-finish_posts_columns', function( $columns ) {
    // 将新列插入到 Date 之前，或者直接追加
    // 这里选择插入到 title 之后
    $new_columns = array();
    foreach ( $columns as $key => $value ) {
        $new_columns[ $key ] = $value;
        if ( 'title' === $key ) {
            $new_columns['related_capabilities'] = __( 'Related Capabilities', '3d-printing' );
        }
    }
    return $new_columns;
} );

add_action( 'manage_surface-finish_posts_custom_column', function( $column, $post_id ) {
    if ( 'related_capabilities' === $column ) {
        // 获取 ACF 关联字段对象
        $related = get_field( 'related_capabilities', $post_id );
        
        if ( $related ) {
            $links = array();
            foreach ( $related as $p ) {
                // 生成带链接的标题，方便点击跳转查看
                $links[] = sprintf(
                    '<a href="%s">%s</a>',
                    get_edit_post_link( $p->ID ),
                    esc_html( $p->post_title )
                );
            }
            echo implode( ', ', $links );
        } else {
            echo '<span aria-hidden="true">—</span>';
        }
    }
}, 10, 2 );

/**
 * 2. 增加按 Capability 筛选的下拉框
 * Surface Finish 与 Capability 是通过 ACF 关联的，不是标准的 Taxonomy，
 * 所以需要手动构建筛选器和查询逻辑。
 */
add_action( 'restrict_manage_posts', '_3dp_add_surface_finish_filters' );

function _3dp_add_surface_finish_filters( $post_type ) {
    if ( 'surface-finish' !== $post_type ) {
        return;
    }

    $selected = isset( $_GET['filter_capability'] ) ? $_GET['filter_capability'] : '';

    // 获取所有 Capability
    $capabilities = get_posts( array(
        'post_type'      => 'capability',
        'posts_per_page' => -1,
        'orderby'        => 'title',
        'order'          => 'ASC',
        'post_status'    => 'publish', // 只显示已发布的
    ) );

    echo '<select name="filter_capability" id="filter_capability">';
    echo '<option value="">' . __( 'All Capabilities', '3d-printing' ) . '</option>';
    
    foreach ( $capabilities as $cap ) {
        printf(
            '<option value="%s" %s>%s</option>',
            esc_attr( $cap->ID ),
            selected( $selected, $cap->ID, false ),
            esc_html( $cap->post_title )
        );
    }
    
    echo '</select>';
}

/**
 * 3. 处理 Capability 筛选逻辑 (修改主查询)
 */
add_action( 'pre_get_posts', '_3dp_filter_surface_finish_by_capability' );

function _3dp_filter_surface_finish_by_capability( $query ) {
    global $pagenow;
    
    // 卫语句: 确保是在后台、列表页、主查询
    if ( ! is_admin() || 'edit.php' !== $pagenow || ! $query->is_main_query() ) {
        return;
    }

    // 确保是 surface-finish 类型
    if ( 'surface-finish' !== $query->get( 'post_type' ) ) {
        return;
    }

    // 检查是否有筛选参数
    if ( ! empty( $_GET['filter_capability'] ) ) {
        $cap_id = sanitize_text_field( $_GET['filter_capability'] );
        
        $meta_query = $query->get( 'meta_query' );
        if ( ! is_array( $meta_query ) ) {
            $meta_query = array();
        }

        // ACF Relationship 字段在数据库中存储为序列化数组 (e.g., a:2:{i:0;s:2:"10";i:1;s:2:"25";})
        // 因此使用 LIKE 查询包含 ID 的字符串 (e.g., "10")
        // 注意：ACF 存储 ID 是带双引号的字符串
        $meta_query[] = array(
            'key'     => 'related_capabilities',
            'value'   => '"' . $cap_id . '"',
            'compare' => 'LIKE',
        );

        $query->set( 'meta_query', $meta_query );
    }
}
