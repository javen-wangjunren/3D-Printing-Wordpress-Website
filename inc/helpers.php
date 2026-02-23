<?php
/**
 * 辅助函数库 (Helpers)
 * ==========================================================================
 * 文件作用:
 * 提供全站通用的辅助函数，主要用于解决 ACF 字段获取、Block ID 生成以及模版渲染隔离等问题。
 *
 * 核心逻辑:
 * 1. 智能字段获取 (get_field_value): 统一处理 ACF Group 嵌套、直接字段和数据库回退三种情况。
 * 2. 安全 ID 生成 (_3dp_get_safe_block_id): 为 HTML 元素生成唯一且稳定的 ID，优先使用锚点。
 * 3. 模版隔离渲染 (_3dp_render_block): 类似于 get_template_part，但支持传递局部变量，避免全局污染。
 *
 * 架构角色:
 * 作为 GeneratePress Child 主题的基础设施层，支撑 blocks/ 目录下所有模块的逻辑实现。
 * 它是连接 ACF 数据与前端模版的桥梁。
 *
 * 🚨 避坑指南:
 * - 修改 get_field_value 时需谨慎，确保兼容旧数据的读取方式（特别是 clone 字段）。
 * - 环境兜底函数 (get_post_type 等) 仅用于静态分析或特殊非 WP 环境，勿随意删除。
 * ==========================================================================
 */

// ==========================================================================
// I. 环境兼容性 (Environment Compatibility)
// ==========================================================================

/**
 * 环境兜底：get_post_type
 * 作用：防止在非 WordPress 环境或静态代码分析工具中报错。
 */
if ( ! function_exists( 'get_post_type' ) ) {
    function get_post_type( $post = null ) { return ''; }
}

/**
 * 环境兜底：wp_set_object_terms
 * 作用：同上，提供函数声明存根。
 */
if ( ! function_exists( 'wp_set_object_terms' ) ) {
    function wp_set_object_terms( $object_id, $terms, $taxonomy, $append = false ) { return array(); }
}

// ==========================================================================
// II. ACF 与 Block 工具 (ACF & Block Utilities)
// ==========================================================================

/**
 * 获取安全的 Block ID
 * 
 * 逻辑优先级：
 * 1. 固定 ID (Fixed ID): 模板调用时强制指定，优先级最高。
 * 2. 锚点 ID (Anchor): 用户在编辑器侧边栏手动输入的 HTML 锚点。
 * 3. 自动 ID (Block ID): ACF 自动生成的唯一 ID。
 * 4. 随机 ID (Uniqid): 最后的兜底方案。
 *
 * @param array|null $block    ACF Block 数据数组
 * @param string     $prefix   ID 前缀 (默认 'block')
 * @param string     $fixed_id [可选] 强制使用的固定 ID
 * @return string
 */
function _3dp_get_safe_block_id( $block = null, $prefix = 'block', $fixed_id = '' ) {
    // 1. 优先使用传入的固定 ID
    if ( $fixed_id !== '' ) {
        return $prefix . '-' . $fixed_id;
    }

    // 2. 其次使用编辑器设置的锚点 (Anchor)
    if ( is_array( $block ) && ! empty( $block['anchor'] ) ) {
        return $block['anchor'];
    }

    // 3. 再次使用 Block 自带的 ID
    if ( is_array( $block ) && ! empty( $block['id'] ) ) {
        return $prefix . '-' . $block['id'];
    }

    // 4. 生成随机 ID 兜底
    return $prefix . '-' . uniqid();
}

/**
 * 万能字段获取函数 (Smart Field Getter)
 * 
 * 作用：解决 ACF Clone 字段在不同上下文（Group 嵌套 vs 独立字段）中的取值差异。
 * 
 * 优先级说明：
 * A. 嵌套模式: 字段在 clone group 数组内部 ($block[$clone_name]['field'])。
 * B. 扁平模式: 字段直接在 block 根层级 ($block['field'])。
 * C. 数据库模式: 直接查库 (get_field)，用于某些极端情况或非 Block 上下文。
 * 
 * @param string $field_name 目标字段名 (不带前缀)
 * @param array  $block      当前 Block 数据对象
 * @param string $clone_name Clone Group 的名称 (用于优先级 A)
 * @param string $prefix     字段前缀 (用于优先级 C)
 * @param mixed  $default    默认值
 * @return mixed
 */
function get_field_value( $field_name, $block, $clone_name, $prefix, $default = null ) {
    // 优先级 A: 检查是否在 Clone Group 嵌套数组中
    if ( isset( $block[ $clone_name ] ) && isset( $block[ $clone_name ][ $field_name ] ) ) {
        return $block[ $clone_name ][ $field_name ];
    }

    // 优先级 B: 检查是否直接存在于 Block 根数组中
    if ( isset( $block[ $field_name ] ) ) {
        return $block[ $field_name ];
    }

    // 优先级 C: 尝试从数据库直接读取 (最后的手段)
    // 注意：需要从 block 上下文中获取 post_id，否则默认当前页面
    $post_id = isset( $block['_context_post_id'] ) ? $block['_context_post_id'] : false;
    $acf_value = get_field( $prefix . $field_name, $post_id );

    return $acf_value !== null ? $acf_value : $default;
}

// ==========================================================================
// III. 模版渲染 (Template Rendering)
// ==========================================================================

/**
 * 模块独立渲染函数 (Scoped Renderer)
 * 
 * 核心价值：
 * 1. 作用域隔离: 通过 include 引入模版，确保 $block 变量只在当前模版生效，不污染全局。
 * 2. 参数传递: 显式传递 $block_data，使模版逻辑更纯粹。
 * 3. 路径简化: 自动补全文件后缀。
 * 
 * @param string $template_path 模块相对路径 (例如 'blocks/global/hero/render')
 * @param array  $block_data    传递给模版的数据数组 (在模版中通过 $block 访问)
 */
function _3dp_render_block( $template_path, $block_data = array() ) {
    // 将数据赋值给 $block 变量，这是模版中约定的标准变量名
    $block = $block_data;
    
    // 自动补全文件后缀
    if ( substr( $template_path, -4 ) !== '.php' ) {
        $template_path .= '.php';
    }

    // 定位并加载模版
    $located = locate_template( $template_path );

    if ( $located ) {
        include $located;
    }
}
