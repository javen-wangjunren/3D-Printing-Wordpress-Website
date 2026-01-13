<?php
/**
 * CTA Block 的渲染模板
 * 
 * 展示呼叫行动模块，支持自动化内容填充
 */

// 尝试获取缓存数据
$transient_key = 'cta_all';
$cta_data = get_transient( $transient_key );

// 如果没有缓存或缓存过期，重新生成数据
if ( false === $cta_data ) {
    
    // 获取全局模块数据
    $global_cta = get_field( 'global_cta', 'option' ) ?: array();
    
    // 提取数据
    $title = $global_cta['title'] ?? 'Ready to Get Started?';
    $description = $global_cta['description'] ?? 'Contact us today to learn how our 3D printing solutions can help your business';
    $button = $global_cta['button'] ?? array();
    $background_image = $global_cta['background_image'] ?? '';
    
    // 缓存数据，有效期1小时
    $cta_data = array(
        'title' => $title,
        'description' => $description,
        'button' => $button,
        'background_image' => $background_image,
        'has_content' => ! empty( $title ) || ! empty( $description ) || ! empty( $button )
    );
    
    set_transient( $transient_key, $cta_data, HOUR_IN_SECONDS );
}

// 从缓存数据中提取变量
$title = $cta_data['title'];
$description = $cta_data['description'];
$button = $cta_data['button'];
$background_image = $cta_data['background_image'];
$has_content = $cta_data['has_content'];

// 如果没有内容，不显示模块
if ( ! $has_content ) {
    return;
}
?>

<section class="cta-block">
    <?php if ( $background_image ) : ?>
        <div class="cta-background">
            <?php echo wp_get_attachment_image( $background_image, 'large' ); ?>
        </div>
    <?php endif; ?>
    
    <div class="cta-content">
        <?php if ( $title ) : ?>
            <h2 class="cta-title"><?php echo esc_html( $title ); ?></h2>
        <?php endif; ?>
        
        <?php if ( $description ) : ?>
            <p class="cta-description"><?php echo esc_html( $description ); ?></p>
        <?php endif; ?>
        
        <?php if ( $button && isset( $button['url'] ) && isset( $button['title'] ) ) : ?>
            <div class="cta-button-wrapper">
                <a href="<?php echo esc_url( $button['url'] ); ?>" 
                   class="cta-button" 
                   <?php if ( isset( $button['target'] ) ) echo 'target="' . esc_attr( $button['target'] ) . '"'; ?>>
                    <?php echo esc_html( $button['title'] ); ?>
                </a>
            </div>
        <?php endif; ?>
    </div>
</section>