<?php
/**
 * Comparison Table Block 的渲染模板
 * 
 * 展示3D打印技术对比表格
 */

// 检查是否有数据
if ( ! have_rows( 'comparison_rows' ) ) {
    return;
}

// 获取字段值
$table_title = get_field( 'table_title' );
$highlight_row = get_field( 'highlight_row' );
?>

<section class="comparison-table-block">
    <?php if ( $table_title ) : ?>
        <h2 class="comparison-table-title"><?php echo esc_html( $table_title ); ?></h2>
    <?php endif; ?>

    <div class="comparison-table-wrapper">
        <table class="comparison-table">
            <thead>
                <tr>
                    <th>Technology</th>
                    <th>Dimensional accuracy</th>
                    <th>Strengths</th>
                    <th>Build volume</th>
                    <th>Layer thickness</th>
                    <th>Min. feature size</th>
                </tr>
            </thead>
            <tbody>
                <?php 
                $row_index = 0;
                while ( have_rows( 'comparison_rows' ) ) : the_row();
                    $row_index++;
                    $tech_name = get_sub_field( 'tech_name' );
                    $accuracy = get_sub_field( 'accuracy' );
                    $strengths = get_sub_field( 'strengths' );
                    $build_volume = get_sub_field( 'build_volume' );
                    $layer_thickness = get_sub_field( 'layer_thickness' );
                    $min_feature = get_sub_field( 'min_feature' );
                    
                    // 检查当前行是否需要高亮
                    $is_highlighted = ( $highlight_row == $row_index );
                ?>
                    <tr <?php if ( $is_highlighted ) echo 'class="highlighted"'; ?>>
                        <td><?php echo esc_html( $tech_name ); ?></td>
                        <td><?php echo esc_html( $accuracy ); ?></td>
                        <td><?php echo esc_html( $strengths ); ?></td>
                        <td><?php echo esc_html( $build_volume ); ?></td>
                        <td><?php echo esc_html( $layer_thickness ); ?></td>
                        <td><?php echo esc_html( $min_feature ); ?></td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>
</section>
