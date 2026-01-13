<?php
/**
 * How It Works Block 的渲染模板
 * 
 * 展示工作流程步骤，仅支持工艺特定数据
 */

// 检查是否有通过模板变量传递的工艺特定数据
$process_steps = get_query_var( 'process_steps' );
$process_title = get_query_var( 'process_title' );
$process_description = get_query_var( 'process_description' );

// 如果没有工艺特定数据，不显示模块
if ( ! $process_steps || empty( $process_steps ) ) {
    return;
}

// 使用工艺特定数据
$work_steps = $process_steps;
$section_title = $process_title ?: 'How It Works';
$section_desc = $process_description ?: '';
$show_numbers = true;
$show_icons = false;
$has_steps = true;

// 如果没有步骤数据，不显示模块
if ( ! $has_steps ) {
    return;
}
?>

<section class="how-it-works-block">
    <div class="how-it-works-header">
        <?php if ( $section_title ) : ?>
            <h2 class="how-it-works-title"><?php echo esc_html( $section_title ); ?></h2>
        <?php endif; ?>
        
        <?php if ( $section_desc ) : ?>
            <p class="how-it-works-description"><?php echo esc_html( $section_desc ); ?></p>
        <?php endif; ?>
    </div>

    <div class="how-it-works-steps">
        <?php foreach ( $work_steps as $index => $step ) : ?>
            <?php 
            $qc_label = $step['qc_label'] ?? '';
            $step_title = $step['title'] ?? '';
            $step_image = $step['image'] ?? '';
            $step_description = $step['description'] ?? '';
            $step_data_grid = $step['data_grid'] ?? array();
            $step_pro_tip = $step['pro_tip'] ?? '';
            
            if ( ! $step_title ) continue;
            ?>
            
            <div class="how-it-works-step-item">
                <div class="step-item-header">
                    <?php if ( $show_numbers ) : ?>
                        <div class="step-number">
                            <?php echo $index + 1; ?>
                        </div>
                    <?php endif; ?>
                    
                    <div class="step-title-container">
                        <?php if ( $qc_label ) : ?>
                            <span class="step-qc-label"><?php echo esc_html( $qc_label ); ?></span>
                        <?php endif; ?>
                        <h3 class="step-title"><?php echo esc_html( $step_title ); ?></h3>
                    </div>
                </div>
                
                <?php if ( $step_image ) : ?>
                    <div class="step-image">
                        <?php echo wp_get_attachment_image( $step_image, 'large' ); ?>
                    </div>
                <?php endif; ?>
                
                <?php if ( $step_description ) : ?>
                    <div class="step-description">
                        <?php echo wpautop( $step_description ); ?>
                    </div>
                <?php endif; ?>
                
                <?php if ( $step_data_grid && ! empty( $step_data_grid ) ) : ?>
                    <div class="step-data-grid">
                        <?php foreach ( $step_data_grid as $data_item ) : ?>
                            <?php if ( $data_item['label'] && $data_item['value'] ) : ?>
                                <div class="data-item">
                                    <span class="data-label"><?php echo esc_html( $data_item['label'] ); ?></span>
                                    <span class="data-value"><?php echo esc_html( $data_item['value'] ); ?></span>
                                </div>
                            <?php endif; ?>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>
                
                <?php if ( $step_pro_tip ) : ?>
                    <div class="step-pro-tip">
                        <strong>Pro Tip:</strong> <?php echo esc_html( $step_pro_tip ); ?>
                    </div>
                <?php endif; ?>
            </div>
        <?php endforeach; ?>
    </div>
</section>