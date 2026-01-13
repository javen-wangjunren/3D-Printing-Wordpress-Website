<?php
/**
 * Order Process Block 的渲染模板
 * 
 * 展示订单流程步骤，支持自动化内容填充
 */

// 尝试获取缓存数据
$transient_key = 'order_process_all';
$order_data = get_transient( $transient_key );

// 如果没有缓存或缓存过期，重新生成数据
if ( false === $order_data ) {
    
    // 获取全局模块数据
    $global_order = get_field( 'global_order_process', 'option' ) ?: array();
    
    // 提取数据
    $title = $global_order['title'] ?? 'Order Process';
    $steps = $global_order['steps'] ?? array();
    $cta_button = $global_order['cta_button'] ?? array();
    
    // 缓存数据，有效期1小时
    $order_data = array(
        'title' => $title,
        'steps' => $steps,
        'cta_button' => $cta_button,
        'has_steps' => ! empty( $steps )
    );
    
    set_transient( $transient_key, $order_data, HOUR_IN_SECONDS );
}

// 从缓存数据中提取变量
$title = $order_data['title'];
$steps = $order_data['steps'];
$cta_button = $order_data['cta_button'];
$has_steps = $order_data['has_steps'];

// 如果没有步骤，不显示模块
if ( ! $has_steps ) {
    return;
}
?>

<section class="order-process-block">
    <?php if ( $title ) : ?>
        <h2 class="order-process-title"><?php echo esc_html( $title ); ?></h2>
    <?php endif; ?>

    <div class="order-process-steps">
        <?php foreach ( $steps as $index => $step ) : ?>
            <?php 
            $step_title = $step['title'] ?? '';
            $step_description = $step['description'] ?? '';
            $step_icon = $step['icon'] ?? '';
            
            if ( ! $step_title ) continue;
            ?>
            
            <div class="order-process-step">
                <div class="step-number"><?php echo $index + 1; ?></div>
                
                <div class="step-content">
                    <?php if ( $step_icon ) : ?>
                        <div class="step-icon">
                            <?php echo $step_icon; ?>
                        </div>
                    <?php endif; ?>
                    
                    <h3 class="step-title"><?php echo esc_html( $step_title ); ?></h3>
                    
                    <?php if ( $step_description ) : ?>
                        <p class="step-description"><?php echo esc_html( $step_description ); ?></p>
                    <?php endif; ?>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
    
    <?php if ( $cta_button && isset( $cta_button['url'] ) && isset( $cta_button['title'] ) ) : ?>
        <div class="order-process-cta">
            <a href="<?php echo esc_url( $cta_button['url'] ); ?>" 
               class="cta-button" 
               <?php if ( isset( $cta_button['target'] ) ) echo 'target="' . esc_attr( $cta_button['target'] ) . '"'; ?>>
                <?php echo esc_html( $cta_button['title'] ); ?>
            </a>
        </div>
    <?php endif; ?>
</section>