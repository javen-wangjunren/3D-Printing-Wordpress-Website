<?php
/**
 * Why Choose Us Block 的渲染模板
 * 
 * 展示选择我们的理由，支持自动化内容填充
 */

// 尝试获取缓存数据
$transient_key = 'why_choose_us_all';
$why_data = get_transient( $transient_key );

// 如果没有缓存或缓存过期，重新生成数据
if ( false === $why_data ) {
    
    // 获取全局模块数据
    $global_why = get_field( 'global_why_choose_us', 'option' ) ?: array();
    
    // 提取数据
    $title = $global_why['title'] ?? 'Why Choose Us';
    $features_list = $global_why['features_list'] ?? array();
    
    // 缓存数据，有效期1小时
    $why_data = array(
        'title' => $title,
        'features_list' => $features_list,
        'has_features' => ! empty( $features_list )
    );
    
    set_transient( $transient_key, $why_data, HOUR_IN_SECONDS );
}

// 从缓存数据中提取变量
$title = $why_data['title'];
$features_list = $why_data['features_list'];
$has_features = $why_data['has_features'];

// 如果没有功能列表，不显示模块
if ( ! $has_features ) {
    return;
}
?>

<section class="why-choose-us-block">
    <?php if ( $title ) : ?>
        <h2 class="why-choose-us-title"><?php echo esc_html( $title ); ?></h2>
    <?php endif; ?>

    <div class="why-choose-us-features">
        <?php foreach ( $features_list as $feature ) : ?>
            <?php 
            $feature_title = $feature['title'] ?? '';
            $feature_description = $feature['description'] ?? '';
            
            if ( ! $feature_title ) continue;
            ?>
            
            <div class="why-choose-us-feature">
                <div class="feature-content">
                    <h3 class="feature-title"><?php echo esc_html( $feature_title ); ?></h3>
                    <?php if ( $feature_description ) : ?>
                        <p class="feature-description"><?php echo esc_html( $feature_description ); ?></p>
                    <?php endif; ?>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</section>