<?php
/**
 * Trusted By Block 的渲染模板
 * 
 * 展示信任的客户或合作伙伴列表，支持自动化内容填充
 */

// 尝试获取缓存数据
$transient_key = 'trusted_by_all';
$trusted_data = get_transient( $transient_key );

// 如果没有缓存或缓存过期，重新生成数据
if ( false === $trusted_data ) {
    
    // 获取信任的客户/合作伙伴数据
    $trusted_logos = get_field( 'trusted_by_logos', 'option' ) ?: array();
    $section_title = get_field( 'trusted_by_title', 'option' ) ?: 'Trusted By';
    $section_desc = get_field( 'trusted_by_description', 'option' ) ?: 'We partner with leading companies across various industries';
    $show_title = get_field( 'trusted_by_show_title', 'option' ) !== false;
    $show_desc = get_field( 'trusted_by_show_description', 'option' ) !== false;
    
    // 缓存数据，有效期1小时
    $trusted_data = array(
        'trusted_logos' => $trusted_logos,
        'section_title' => $section_title,
        'section_desc' => $section_desc,
        'show_title' => $show_title,
        'show_desc' => $show_desc,
        'has_logos' => ! empty( $trusted_logos )
    );
    
    set_transient( $transient_key, $trusted_data, HOUR_IN_SECONDS );
}

// 从缓存数据中提取变量
$trusted_logos = $trusted_data['trusted_logos'];
$section_title = $trusted_data['section_title'];
$section_desc = $trusted_data['section_desc'];
$show_title = $trusted_data['show_title'];
$show_desc = $trusted_data['show_desc'];
$has_logos = $trusted_data['has_logos'];

// 如果没有logo数据，不显示模块
if ( ! $has_logos ) {
    return;
}
?>

<section class="trusted-by-block">
    <?php if ( $show_title || $show_desc ) : ?>
        <div class="trusted-by-header">
            <?php if ( $show_title && $section_title ) : ?>
                <h2 class="trusted-by-title"><?php echo esc_html( $section_title ); ?></h2>
            <?php endif; ?>
            
            <?php if ( $show_desc && $section_desc ) : ?>
                <p class="trusted-by-description"><?php echo esc_html( $section_desc ); ?></p>
            <?php endif; ?>
        </div>
    <?php endif; ?>

    <div class="trusted-by-logos">
        <?php foreach ( $trusted_logos as $logo ) : ?>
            <?php 
            $logo_image = $logo['logo_image'] ?? '';
            $logo_link = $logo['logo_link'] ?? array();
            $logo_alt_text = $logo['logo_alt_text'] ?? '';
            
            if ( ! $logo_image ) continue;
            ?>
            
            <div class="trusted-by-logo-item">
                <?php if ( $logo_link && isset( $logo_link['url'] ) && isset( $logo_link['title'] ) ) : ?>
                    <a href="<?php echo esc_url( $logo_link['url'] ); ?>" 
                       class="trusted-by-logo-link" 
                       target="<?php echo isset( $logo_link['target'] ) ? esc_attr( $logo_link['target'] ) : '_blank'; ?>" 
                       title="<?php echo esc_attr( $logo_link['title'] ); ?>">
                        <?php echo wp_get_attachment_image( $logo_image, 'medium', false, array( 'alt' => $logo_alt_text ) ); ?>
                    </a>
                <?php else : ?>
                    <div class="trusted-by-logo">
                        <?php echo wp_get_attachment_image( $logo_image, 'medium', false, array( 'alt' => $logo_alt_text ) ); ?>
                    </div>
                <?php endif; ?>
            </div>
        <?php endforeach; ?>
    </div>
</section>