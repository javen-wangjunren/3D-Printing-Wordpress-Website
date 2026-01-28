<?php

/**
 * 为了让后台看起来不乱：下拉选项始终来源于标准术语，避免编辑时出现重复或拼写混乱
 * 为了方便你以后在手机上改：单选/下拉的录入更轻量，保存后自动打上分类标签，列表筛选马上好用
 * 与 taxonomies.php 协同：那边注册术语，这里把术语喂给 ACF，并在保存时回写 taxonomy，形成闭环
 * 主要作用：
 * -为 ACF 表单自动填充“工艺”和“材料类型”下拉选项，来源于已注册的分类法术语
 * -在你保存“材料（material）”内容时，把 ACF 选择的值同步到对应的分类法，保持标签与字段一致
 * -提供少量函数的安全兜底（仅在非 WordPress 环境或静态分析时避免报错）
 */


if ( ! function_exists( 'get_post_type' ) ) {
    function get_post_type( $post = null ) { return ''; }
}

if ( ! function_exists( 'wp_set_object_terms' ) ) {
    function wp_set_object_terms( $object_id, $terms, $taxonomy, $append = false ) { return array(); }
}


// 自动同步 ACF 字段到分类法的逻辑已移除，因为现在直接使用原生的分类法 Meta Box


/**
 * 获取安全的 Block ID
 *
 * @param array|null $block    ACF Block 数组
 * @param string     $prefix   ID 前缀
 * @param string     $fixed_id [可选] 模板调用时使用的固定 ID（优先级最高）
 * @return string
 */
function _3dp_get_safe_block_id( $block = null, $prefix = 'block', $fixed_id = '' ) {
    if ( $fixed_id !== '' ) {
        return $prefix . '-' . $fixed_id;
    }

    if ( is_array( $block ) && ! empty( $block['anchor'] ) ) {
        return $block['anchor'];
    }

    if ( is_array( $block ) && ! empty( $block['id'] ) ) {
        return $prefix . '-' . $block['id'];
    }

    return $prefix . '-' . uniqid();
}

/**
 * 万能取数字段函数
 * 
 * 按照以下优先级获取字段值：
 * 优先级 A: Group 模式嵌套 - $block[$clone_name]['field_name']
 * 优先级 B: 直接存在于 block 中 - $block['field_name']
 * 优先级 C: 从数据库读取 - get_field( $pfx . 'field_name' )
 * 
 * @param string $field_name 字段名
 * @param array  $block      Block 数据
 * @param string $clone_name 克隆名
 * @param string $pfx        字段前缀
 * @param mixed  $default    默认值
 * @return mixed 字段值
 */
function get_field_value($field_name, $block, $clone_name, $pfx, $default = null) {
    // 优先级 A: Group 模式嵌套
    if (isset($block[$clone_name]) && isset($block[$clone_name][$field_name])) {
        return $block[$clone_name][$field_name];
    }
    // 优先级 B: 直接存在于 block 中
    if (isset($block[$field_name])) {
        return $block[$field_name];
    }
    // 优先级 C: 从数据库读取
    $acf_value = get_field($pfx . $field_name);
    return $acf_value !== null ? $acf_value : $default;
}

/**
 * 模板专用模块渲染函数 (View Renderer)
 * 
 * 作用：
 * 1. 显式传递 $block 数据，不污染全局 Query
 * 2. 局部作用域 include，变量不泄露
 * 3. 统一模块调用入口
 * 
 * @param string $template_path 模块相对路径 (如 'blocks/global/hero/render.php')
 * @param array  $block_data    模拟的 $block 数据 (如 array('id' => 'overview'))
 */
function _3dp_render_block( $template_path, $block_data = array() ) {
    // 确保 $block 变量在 include 的文件中可用
    $block = $block_data;
    
    // 如果路径不包含 .php，自动补全（兼容习惯）
    if ( substr( $template_path, -4 ) !== '.php' ) {
        $template_path .= '.php';
    }

    $located = locate_template( $template_path );

    if ( $located ) {
        include $located;
    }
}
