<?php
/**
 * Industry Slider Block 的渲染模板
 * 
 * 展示行业应用案例，支持基于当前工艺的自动内容筛选
 */
// Prefix Support
$pfx = isset($block['prefix']) ? $block['prefix'] : '';


$block = isset( $block ) ? $block : array();
$block_id = _3dp_get_safe_block_id( $block, 'industry-slider' );

// 从全局变量获取当前工艺信息
$current_capability = isset( $GLOBALS['current_capability'] ) ? $GLOBALS['current_capability'] : null;

// Init variables
$industries = array();
$section_title = '';
$section_desc = '';
$pc_cols = 'grid-cols-4';
$mb_hide_teaser = false;
$has_industries = false;

if ( ! empty( $pfx ) ) {
    // Local / Page Builder Mode
    $section_title = get_field($pfx . 'title');
    $section_desc = get_field($pfx . 'desc');
    $industries = get_field($pfx . 'items') ?: array();
    
    $pc_cols = get_field($pfx . 'pc_cols') ?: 'grid-cols-4';
    $mb_hide_teaser = get_field($pfx . 'mb_hide_teaser');
} else {
    // Global Settings Mode
    $global_data = get_field('global_industry_slider', 'option');
    if ( $global_data ) {
        $section_title = isset($global_data['title']) ? $global_data['title'] : '';
        $section_desc = isset($global_data['desc']) ? $global_data['desc'] : '';
        
        $industries = isset($global_data['items']) ? $global_data['items'] : array();
        
        $pc_cols = isset($global_data['pc_cols']) ? $global_data['pc_cols'] : 4;
        $mb_hide_teaser = isset($global_data['mb_hide_teaser']) ? (bool)$global_data['mb_hide_teaser'] : false;
    }
}

// Fallback: If no industries found (Local or Global), try CPT
if ( empty( $industries ) ) {
    // 获取行业列表数据
    $args = array(
        'post_type' => 'industry',
        'posts_per_page' => -1,
        'orderby' => 'title',
        'order' => 'ASC'
    );
    
    $industry_query = new WP_Query( $args );
    
    if ( $industry_query->have_posts() ) {
        $industries = $industry_query->posts;
    } else {
        // Static Default Data (Last Resort)
        $industries = array(
            array(
                'name' => 'Aerospace',
                'image' => '',
                'tags' => array(
                    array('text' => 'Lightweight', 'type' => 'green'),
                    array('text' => 'High Strength', 'type' => 'green')
                ),
                'teaser' => 'Aerospace components require precision and reliability that our 3D printing technology delivers.',
                'link' => array('url' => '#', 'title' => 'Learn More')
            ),
            // ... (Other static items omitted for brevity, but could be added if needed)
        );
    }
    wp_reset_postdata();
}

$has_industries = ! empty( $industries );

// 如果没有行业数据，不显示模块
if ( ! $has_industries ) {
    return;
}
?>

<section class="industry-slider-block">
    <?php if ( $section_title ) : ?>
        <h2 class="industry-slider-title"><?php echo esc_html( $section_title ); ?></h2>
    <?php endif; ?>
    
    <?php if ( $section_desc ) : ?>
        <p class="industry-slider-description"><?php echo esc_html( $section_desc ); ?></p>
    <?php endif; ?>

    <div class="industry-slider-wrapper">
        <div class="industry-grid <?php echo esc_attr( $pc_cols ); ?>">
            <?php foreach ( $industries as $industry ) : ?>
                <?php 
                // 处理不同数据结构
                if ( is_array( $industry ) ) {
                    // 数组结构（默认数据或选项页数据）
                    $industry_name = isset( $industry['name'] ) ? $industry['name'] : '';
                    $industry_image = isset( $industry['image'] ) ? $industry['image'] : '';
                    $industry_tags = isset( $industry['tags'] ) ? $industry['tags'] : array();
                    $industry_teaser = isset( $industry['teaser'] ) ? $industry['teaser'] : '';
                    $industry_link = isset( $industry['link'] ) ? $industry['link'] : array('url' => '#', 'title' => 'Learn More');
                } else {
                    // CPT结构
                    $industry_id = $industry->ID;
                    $industry_name = get_the_title( $industry_id );
                    $industry_image = get_field($pfx . 'industry_image', $industry_id );
                    $industry_tags = get_field($pfx . 'industry_tags', $industry_id ) ?: array();
                    $industry_teaser = get_field($pfx . 'industry_teaser', $industry_id ) ?: '';
                    $industry_link = get_field($pfx . 'industry_link', $industry_id ) ?: array('url' => get_permalink( $industry_id ), 'title' => 'Learn More');
                }
                
                // 如果是当前工艺相关的行业，添加高亮类
                $is_current_industry = false;
                if ( $current_capability && ! empty( $current_capability['title'] ) ) {
                    // 可以在这里添加更复杂的匹配逻辑
                }
                ?>
                
                <div class="industry-item <?php if ( $is_current_industry ) echo 'current-industry'; ?>">
                    <?php if ( $industry_image ) : ?>
                        <div class="industry-item-image">
                            <?php echo wp_get_attachment_image( $industry_image, 'medium' ); ?>
                        </div>
                    <?php endif; ?>
                    
                    <div class="industry-item-content">
                        <h3 class="industry-item-name"><?php echo esc_html( $industry_name ); ?></h3>
                        
                        <?php if ( ! empty( $industry_tags ) ) : ?>
                            <div class="industry-item-tags">
                                <?php foreach ( $industry_tags as $tag ) : ?>
                                    <?php 
                                    $tag_text = is_array( $tag ) ? ( isset( $tag['text'] ) ? $tag['text'] : '' ) : $tag->text;
                                    $tag_type = is_array( $tag ) ? ( isset( $tag['type'] ) ? $tag['type'] : 'blue' ) : $tag->type;
                                    ?>
                                    <span class="industry-tag tag-<?php echo esc_attr( $tag_type ); ?>">
                                        <?php echo esc_html( $tag_text ); ?>
                                    </span>
                                <?php endforeach; ?>
                            </div>
                        <?php endif; ?>
                        
                        <?php if ( $industry_teaser && ! $mb_hide_teaser ) : ?>
                            <p class="industry-item-teaser"><?php echo esc_html( $industry_teaser ); ?></p>
                        <?php endif; ?>
                        
                        <?php if ( $industry_link && isset( $industry_link['url'] ) && isset( $industry_link['title'] ) ) : ?>
                            <a href="<?php echo esc_url( $industry_link['url'] ); ?>" 
                               class="industry-item-link" 
                               <?php if ( isset( $industry_link['target'] ) ) echo 'target="' . esc_attr( $industry_link['target'] ) . '"'; ?>>
                                <?php echo esc_html( $industry_link['title'] ); ?>
                            </a>
                        <?php endif; ?>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>