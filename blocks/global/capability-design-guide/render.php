<?php
/**
 * Capability Design Guide Block 的渲染模板
 * 
 * 展示特定工艺的设计指南，支持自动化内容填充
 */

// 从全局变量获取当前工艺信息
$current_capability = isset( $GLOBALS['current_capability'] ) ? $GLOBALS['current_capability'] : null;

// 尝试获取缓存数据
$transient_key = 'capability_design_guide_' . ( $current_capability ? $current_capability['id'] : 'all' );
$design_data = get_transient( $transient_key );

// 如果没有缓存或缓存过期，重新生成数据
if ( false === $design_data ) {
    
    // 获取设计指南数据
    $design_sections = array();
    $section_title = '';
    $section_desc = '';
    
    // 如果有当前工艺，尝试获取该工艺的设计指南
    if ( $current_capability && ! empty( $current_capability['id'] ) ) {
        $design_sections = get_field( 'capability_design_sections', $current_capability['id'] ) ?: array();
        $section_title = get_field( 'capability_design_title', $current_capability['id'] ) ?: $current_capability['title'] . ' Design Guide';
        $section_desc = get_field( 'capability_design_description', $current_capability['id'] ) ?: 'Design guidelines specific to ' . $current_capability['title'] . ' 3D printing technology';
    }
    
    // 如果没有特定工艺的设计指南，使用全局设计指南
    if ( empty( $design_sections ) ) {
        $design_sections = get_field( 'global_design_guide_sections', 'option' ) ?: array();
        $section_title = get_field( 'global_design_guide_title', 'option' ) ?: '3D Printing Design Guide';
        $section_desc = get_field( 'global_design_guide_description', 'option' ) ?: 'General design guidelines for 3D printing technologies';
    }
    
    // 缓存数据，有效期1小时
    $design_data = array(
        'design_sections' => $design_sections,
        'section_title' => $section_title,
        'section_desc' => $section_desc,
        'has_sections' => ! empty( $design_sections )
    );
    
    set_transient( $transient_key, $design_data, HOUR_IN_SECONDS );
}

// 从缓存数据中提取变量
$design_sections = $design_data['design_sections'];
$section_title = $design_data['section_title'];
$section_desc = $design_data['section_desc'];
$has_sections = $design_data['has_sections'];

// 如果没有设计指南数据，不显示模块
if ( ! $has_sections ) {
    return;
}
?>

<section class="capability-design-guide-block">
    <div class="design-guide-header">
        <?php if ( $section_title ) : ?>
            <h2 class="design-guide-title"><?php echo esc_html( $section_title ); ?></h2>
        <?php endif; ?>
        
        <?php if ( $section_desc ) : ?>
            <p class="design-guide-description"><?php echo esc_html( $section_desc ); ?></p>
        <?php endif; ?>
    </div>

    <div class="design-guide-content">
        <?php foreach ( $design_sections as $section ) : ?>
            <?php 
            $section_heading = $section['section_heading'] ?? '';
            $section_content = $section['section_content'] ?? '';
            $section_image = $section['section_image'] ?? '';
            $section_tips = $section['section_tips'] ?? array();
            
            if ( ! $section_heading ) continue;
            ?>
            
            <div class="design-guide-section">
                <?php if ( $section_heading ) : ?>
                    <h3 class="design-guide-section-title"><?php echo esc_html( $section_heading ); ?></h3>
                <?php endif; ?>
                
                <div class="design-guide-section-content">
                    <?php if ( $section_content ) : ?>
                        <div class="design-guide-text">
                            <?php echo wpautop( $section_content ); ?>
                        </div>
                    <?php endif; ?>
                    
                    <?php if ( $section_image ) : ?>
                        <div class="design-guide-image">
                            <?php echo wp_get_attachment_image( $section_image, 'large' ); ?>
                        </div>
                    <?php endif; ?>
                    
                    <?php if ( ! empty( $section_tips ) ) : ?>
                        <div class="design-guide-tips">
                            <h4 class="design-guide-tips-title">Key Tips:</h4>
                            <ul class="design-guide-tips-list">
                                <?php foreach ( $section_tips as $tip ) : ?>
                                    <li class="design-guide-tip-item">
                                        <?php echo esc_html( $tip['tip_text'] ?? '' ); ?>
                                    </li>
                                <?php endforeach; ?>
                            </ul>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</section>