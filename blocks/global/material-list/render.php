<?php
/**
 * Material List Block 的渲染模板
 * 
 * 展示与当前工艺关联的材料列表，支持单工艺和多工艺模式
 */

// 从查询变量获取当前工艺ID和显示模式
$current_capability_id = get_query_var( 'current_capability_id' );
$material_display_mode = get_query_var( 'material_display_mode' ) ?: 'single';

// 尝试获取缓存数据
$transient_key = 'material_list_' . $current_capability_id . '_' . $material_display_mode;
$materials_data = get_transient( $transient_key );

// 如果没有缓存或缓存过期，重新生成数据
if ( false === $materials_data ) {
    
    if ( 'single' === $material_display_mode && $current_capability_id ) {
        // 单工艺模式：仅显示与当前工艺关联的材料
        $args = array(
            'post_type' => 'material',
            'posts_per_page' => -1,
            'meta_query' => array(
                array(
                    'key' => 'related_capability',
                    'value' => $current_capability_id,
                    'compare' => 'LIKE'
                )
            ),
            'orderby' => 'title',
            'order' => 'ASC'
        );
    } else {
        // 多工艺模式：显示所有材料
        $args = array(
            'post_type' => 'material',
            'posts_per_page' => -1,
            'orderby' => 'title',
            'order' => 'ASC'
        );
    }
    
    $materials_query = new WP_Query( $args );
    $materials = $materials_query->posts;
    
    // 缓存数据，有效期1小时
    $materials_data = array(
        'materials' => $materials,
        'has_materials' => $materials_query->have_posts()
    );
    
    set_transient( $transient_key, $materials_data, HOUR_IN_SECONDS );
    
    // 重置查询
    wp_reset_postdata();
}

// 从缓存数据中提取变量
$materials = $materials_data['materials'];
$has_materials = $materials_data['has_materials'];

// 如果没有材料，显示提示信息
if ( ! $has_materials ) {
    echo '<div class="material-list-empty">';
    echo '<p>No materials found for this process.</p>';
    echo '</div>';
    return;
}
?>

<section class="material-list-block">
    <?php if ( 'single' === $material_display_mode ) : ?>
        <h2 class="material-list-title">Materials for <?php echo get_the_title( $current_capability_id ); ?></h2>
    <?php else : ?>
        <h2 class="material-list-title">All Materials</h2>
    <?php endif; ?>

    <div class="material-list-wrapper">
        <?php foreach ( $materials as $material ) : ?>
            <div class="material-list-item">
                <?php 
                // 获取材料信息
                $material_id = $material->ID;
                $material_title = get_the_title( $material_id );
                $material_badge = get_field( 'badge', $material_id );
                $material_image_id = get_field( 'image', $material_id );
                $material_description = get_field( 'description', $material_id );
                
                // 获取材料的技术参数
                $technical_specs = get_field( 'technical_specs', $material_id );
                
                // 获取材料关联的工艺
                $related_capabilities = get_field( 'related_capability', $material_id );
                ?>
                
                <div class="material-item-header">
                    <?php if ( $material_image_id ) : ?>
                        <div class="material-item-image">
                            <?php echo wp_get_attachment_image( $material_image_id, 'medium' ); ?>
                        </div>
                    <?php endif; ?>
                    
                    <div class="material-item-info">
                        <h3 class="material-item-title"><?php echo esc_html( $material_title ); ?></h3>
                        <?php if ( $material_badge ) : ?>
                            <span class="material-item-badge"><?php echo esc_html( $material_badge ); ?></span>
                        <?php endif; ?>
                        
                        <?php if ( $related_capabilities ) : ?>
                            <div class="material-item-capabilities">
                                <?php foreach ( $related_capabilities as $capability ) : ?>
                                    <span class="material-capability-tag">
                                        <?php echo esc_html( get_the_title( $capability->ID ) ); ?>
                                    </span>
                                <?php endforeach; ?>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
                
                <?php if ( $technical_specs ) : ?>
                    <div class="material-item-specs">
                        <table class="material-specs-table">
                            <?php foreach ( $technical_specs as $spec ) : ?>
                                <tr>
                                    <td class="spec-label"><?php echo esc_html( $spec['label'] ); ?></td>
                                    <td class="spec-value">
                                        <?php echo esc_html( $spec['value'] ); ?>
                                        <?php if ( $spec['unit'] ) : ?>
                                            <span class="spec-unit"><?php echo esc_html( $spec['unit'] ); ?></span>
                                        <?php endif; ?>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </table>
                    </div>
                <?php endif; ?>
                
                <?php if ( $material_description ) : ?>
                    <div class="material-item-description">
                        <?php echo wpautop( $material_description ); ?>
                    </div>
                <?php endif; ?>
                
                <div class="material-item-actions">
                    <a href="<?php echo get_permalink( $material_id ); ?>" class="material-item-link">
                        Learn More
                    </a>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</section>