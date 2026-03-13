<?php
/**
 * Component: Pagination (通用分页组件)
 * ==========================================================================
 * 文件作用:
 * 渲染列表页面的分页导航。
 * 
 * 核心逻辑:
 * 1. 使用 paginate_links 生成标准分页。
 * 2. 提供统一的 UI 样式 (工业风方块样式)，适用于 Materials, Blog 等所有列表。
 * 
 * 参数:
 * - $query (WP_Query): 必需。当前的查询对象。
 * ==========================================================================
 */

// 接收外部传入的 Query 对象，如果是 include 方式，需要确保变量名一致
// 建议使用 set_query_var 或 locate_template 传参，或者直接假设 $query 存在
// 这里做一个简单的兼容性检查
$query = isset( $args['query'] ) ? $args['query'] : ( isset( $material_query ) ? $material_query : get_query_var( 'material_query', null ) );

if ( ! $query || ! $query instanceof WP_Query ) {
    return;
}

$pagination_links = paginate_links( array(
    'base'      => str_replace( 999999999, '%#%', esc_url( get_pagenum_link( 999999999 ) ) ),
    'format'    => '?paged=%#%',
    'current'   => max( 1, get_query_var( 'paged' ) ),
    'total'     => $query->max_num_pages,
    'prev_text' => '<svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path></svg>',
    'next_text' => '<svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>',
    'type'      => 'array',
) );

if ( empty( $pagination_links ) ) {
    return;
}
?>

<div class="site-pagination mt-12 flex justify-center">
    <nav class="flex items-center space-x-2" aria-label="Pagination">
        <?php foreach ( $pagination_links as $link ) : ?>
            <?php
            // Base industrial classes: Mono font, fixed size square, rounded corners
            $base_classes = 'flex items-center justify-center w-10 h-10 rounded-md border text-sm font-mono transition-all duration-200 no-underline';
            
            if ( strpos( $link, 'current' ) !== false ) {
                // Active: Brand Blue Border + Text, Slight Background
                $link = str_replace( 'class="', 'class="' . $base_classes . ' border-[#0047AB] text-[#0047AB] font-bold bg-[#0047AB]/5 ', $link );
            } elseif ( strpos( $link, 'dots' ) !== false ) {
                // Dots: No border, lighter text
                $link = str_replace( 'class="', 'class="flex items-center justify-center w-10 h-10 text-gray-400 font-mono ', $link );
            } else {
                // Default Link: Gray Border, Hover Brand Blue
                $link = str_replace( 'class="', 'class="' . $base_classes . ' border-gray-200 text-gray-600 hover:border-[#0047AB] hover:text-[#0047AB] bg-white ', $link );
            }
            
            echo $link;
            ?>
        <?php endforeach; ?>
    </nav>
</div>
