<?php
/**
 * Comparison Table - 纯净手动版
 */

// 直接获取当前页面的 ACF Table 字段
$table_data = get_field('capability_comparison_table');

// 如果没填或缺少必要数据，直接关掉模块
if ( ! $table_data || empty($table_data['comparison_rows']) ) {
    return;
}

// 提取必要的数据
$table_title = $table_data['table_title'] ?? '';
$table_headers = $table_data['headers'] ?? array();
$comparison_rows = $table_data['comparison_rows'];
$use_mono = $table_data['use_mono'] ?? false;

// 过滤掉空的表头
$filtered_headers = array_filter($table_headers);

// 过滤掉空的数据行
$filtered_rows = array_filter($comparison_rows, function($row) {
    return array_filter($row);
});

// 如果没有过滤后的数据行，直接关掉模块
if (empty($filtered_rows)) {
    return;
}
?>

<section class="comparison-table-block">
    <?php if ( $table_title ) : ?>
        <h2 class="comparison-table-title"><?php echo esc_html( $table_title ); ?></h2>
    <?php endif; ?>

    <div class="comparison-table-wrapper">
        <table class="comparison-table<?php if ( $use_mono ) echo ' use-mono'; ?>">
            <?php if ( !empty($filtered_headers) ) : ?>
                <thead>
                    <tr>
                        <?php 
                        // 动态渲染表头
                        foreach ( $filtered_headers as $header ) {
                            if ( $header ) {
                                echo '<th>' . esc_html( $header ) . '</th>';
                            }
                        }
                        ?>
                    </tr>
                </thead>
            <?php endif; ?>
            <tbody>
                <?php 
                // 动态渲染数据行
                foreach ( $filtered_rows as $row ) :
                    // 获取当前行的所有值
                    $row_values = array_values(array_filter($row));
                    if (empty($row_values)) continue;
                ?>
                    <tr>
                        <?php 
                        // 动态渲染数据列
                        foreach ( $row_values as $value ) :
                            echo '<td>' . esc_html( $value ) . '</td>';
                        endforeach;
                        ?>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</section>