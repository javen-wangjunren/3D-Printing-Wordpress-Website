<?php
/**
 * Hero Banner Block 的渲染模板
 * 
 * 展示页面的主横幅，支持响应式图片和自动化内容
 */

// 从全局变量获取当前工艺信息
$current_capability = isset( $GLOBALS['current_capability'] ) ? $GLOBALS['current_capability'] : null;

// 尝试获取缓存数据
$transient_key = 'hero_banner_' . ( $current_capability ? $current_capability['id'] : 'all' );
$hero_data = get_transient( $transient_key );

// 如果没有缓存或缓存过期，重新生成数据
if ( false === $hero_data ) {
    
    // 获取当前页面的Hero数据，如果没有则使用全局选项
    $hero_title = get_field( 'hero_title' ) ?: ( $current_capability ? $current_capability['title'] : '3D Printing Solutions' );
    $hero_subtitle = get_field( 'hero_subtitle' ) ?: get_field( 'global_hero_subtitle', 'option' ) ?: 'Advanced additive manufacturing technology for your business needs';
    $hero_content = get_field( 'hero_content' ) ?: get_field( 'global_hero_content', 'option' ) ?: '';
    $hero_image = get_field( 'hero_image' ) ?: get_field( 'global_hero_image', 'option' ) ?: '';
    $hero_mobile_image = get_field( 'hero_mobile_image' ) ?: get_field( 'global_hero_mobile_image', 'option' ) ?: $hero_image;
    $hero_cta_button = get_field( 'hero_cta_button' ) ?: get_field( 'global_hero_cta_button', 'option' ) ?: array('url' => '#', 'title' => 'Get Started');
    $hero_secondary_button = get_field( 'hero_secondary_button' ) ?: get_field( 'global_hero_secondary_button', 'option' ) ?: array();
    
    // 缓存数据，有效期1小时
    $hero_data = array(
        'hero_title' => $hero_title,
        'hero_subtitle' => $hero_subtitle,
        'hero_content' => $hero_content,
        'hero_image' => $hero_image,
        'hero_mobile_image' => $hero_mobile_image,
        'hero_cta_button' => $hero_cta_button,
        'hero_secondary_button' => $hero_secondary_button
    );
    
    set_transient( $transient_key, $hero_data, HOUR_IN_SECONDS );
}

// 从缓存数据中提取变量
$hero_title = $hero_data['hero_title'];
$hero_subtitle = $hero_data['hero_subtitle'];
$hero_content = $hero_data['hero_content'];
$hero_image = $hero_data['hero_image'];
$hero_mobile_image = $hero_data['hero_mobile_image'];
$hero_cta_button = $hero_data['hero_cta_button'];
$hero_secondary_button = $hero_data['hero_secondary_button'];
?>

<section class="hero-banner-block">
    <div class="hero-content">
        <?php if ( $hero_title ) : ?>
            <h1 class="hero-title"><?php echo esc_html( $hero_title ); ?></h1>
        <?php endif; ?>
        
        <?php if ( $hero_subtitle ) : ?>
            <h2 class="hero-subtitle"><?php echo esc_html( $hero_subtitle ); ?></h2>
        <?php endif; ?>
        
        <?php if ( $hero_content ) : ?>
            <div class="hero-text">
                <?php echo wpautop( $hero_content ); ?>
            </div>
        <?php endif; ?>
        
        <div class="hero-buttons">
            <?php if ( $hero_cta_button && isset( $hero_cta_button['url'] ) && isset( $hero_cta_button['title'] ) ) : ?>
                <a href="<?php echo esc_url( $hero_cta_button['url'] ); ?>" 
                   class="hero-cta-button" 
                   <?php if ( isset( $hero_cta_button['target'] ) ) echo 'target="' . esc_attr( $hero_cta_button['target'] ) . '"'; ?>>
                    <?php echo esc_html( $hero_cta_button['title'] ); ?>
                </a>
            <?php endif; ?>
            
            <?php if ( $hero_secondary_button && isset( $hero_secondary_button['url'] ) && isset( $hero_secondary_button['title'] ) ) : ?>
                <a href="<?php echo esc_url( $hero_secondary_button['url'] ); ?>" 
                   class="hero-secondary-button" 
                   <?php if ( isset( $hero_secondary_button['target'] ) ) echo 'target="' . esc_attr( $hero_secondary_button['target'] ) . '"'; ?>>
                    <?php echo esc_html( $hero_secondary_button['title'] ); ?>
                </a>
            <?php endif; ?>
        </div>
    </div>
    
    <?php if ( $hero_image ) : ?>
        <div class="hero-image">
            <picture>
                <?php if ( $hero_mobile_image && $hero_mobile_image !== $hero_image ) : ?>
                    <source media="(max-width: 767px)" srcset="<?php echo wp_get_attachment_image_url( $hero_mobile_image, 'medium_large' ); ?>">
                <?php endif; ?>
                <img src="<?php echo wp_get_attachment_image_url( $hero_image, 'large' ); ?>" alt="<?php echo esc_attr( $hero_title ); ?>">
            </picture>
        </div>
    <?php endif; ?>
</section>