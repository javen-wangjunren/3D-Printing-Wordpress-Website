<?php
/**
 * Industry Slider Block 的渲染模板
 * 
 * 展示行业应用案例，支持基于当前工艺的自动内容筛选
 */

$block = isset( $block ) ? $block : array();
$block_id = _3dp_get_safe_block_id( $block, 'industry-slider' );

// 从全局变量获取当前工艺信息
$current_capability = isset( $GLOBALS['current_capability'] ) ? $GLOBALS['current_capability'] : null;

// 尝试获取缓存数据
$transient_key = 'industry_slider_' . ( $current_capability ? $current_capability['id'] : 'all' );
$industry_data = get_transient( $transient_key );

// 如果没有缓存或缓存过期，重新生成数据
if ( false === $industry_data ) {
    
    // 获取行业列表数据
    $args = array(
        'post_type' => 'industry',
        'posts_per_page' => -1,
        'orderby' => 'title',
        'order' => 'ASC'
    );
    
    $industry_query = new WP_Query( $args );
    $industries = $industry_query->posts;
    
    // 如果没有Industry CPT，使用默认数据结构
    if ( ! $industry_query->have_posts() ) {
        // 尝试从全局选项获取行业数据
        $industry_items = get_field( 'industry_items', 'option' );
        
        if ( $industry_items ) {
            $industries = $industry_items;
        } else {
            // 使用静态默认数据
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
                array(
                    'name' => 'Automotive',
                    'image' => '',
                    'tags' => array(
                        array('text' => 'Prototyping', 'type' => 'blue'),
                        array('text' => 'Custom Parts', 'type' => 'blue')
                    ),
                    'teaser' => 'Rapid prototyping and custom automotive parts production with advanced materials.',
                    'link' => array('url' => '#', 'title' => 'Learn More')
                ),
                array(
                    'name' => 'Medical',
                    'image' => '',
                    'tags' => array(
                        array('text' => 'Biocompatible', 'type' => 'green'),
                        array('text' => 'Custom Implants', 'type' => 'blue')
                    ),
                    'teaser' => 'Custom medical devices and implants with FDA-approved materials.',
                    'link' => array('url' => '#', 'title' => 'Learn More')
                ),
                array(
                    'name' => 'Consumer Products',
                    'image' => '',
                    'tags' => array(
                        array('text' => 'Mass Customization', 'type' => 'blue'),
                        array('text' => 'Rapid Manufacturing', 'type' => 'blue')
                    ),
                    'teaser' => 'Custom consumer products with unique designs and fast production times.',
                    'link' => array('url' => '#', 'title' => 'Learn More')
                )
            );
        }
    }
    
    // 根据当前工艺过滤行业数据（如果需要）
    if ( $current_capability ) {
        // 这里可以添加基于当前工艺的过滤逻辑
        // 例如，如果有特定的行业与工艺关联
    }
    
    // 获取滑块设置
    $section_title = get_field( 'section_title', 'option' ) ?: 'Industry Applications';
    $section_desc = get_field( 'section_description', 'option' ) ?: 'Discover how our 3D printing technology is transforming various industries.';
    $pc_cols = get_field( 'pc_cols', 'option' ) ?: 'grid-cols-4';
    $mb_hide_teaser = get_field( 'mb_hide_teaser', 'option' ) ?: false;
    
    // 缓存数据，有效期1小时
    $industry_data = array(
        'industries' => $industries,
        'section_title' => $section_title,
        'section_desc' => $section_desc,
        'pc_cols' => $pc_cols,
        'mb_hide_teaser' => $mb_hide_teaser,
        'has_industries' => ! empty( $industries )
    );
    
    set_transient( $transient_key, $industry_data, HOUR_IN_SECONDS );
    
    // 重置查询
    wp_reset_postdata();
}

// 从缓存数据中提取变量
$industries = $industry_data['industries'];
$section_title = $industry_data['section_title'];
$section_desc = $industry_data['section_desc'];
$pc_cols = $industry_data['pc_cols'];
$mb_hide_teaser = $industry_data['mb_hide_teaser'];
$has_industries = $industry_data['has_industries'];

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
                    $industry_image = get_field( 'industry_image', $industry_id );
                    $industry_tags = get_field( 'industry_tags', $industry_id ) ?: array();
                    $industry_teaser = get_field( 'industry_teaser', $industry_id ) ?: '';
                    $industry_link = get_field( 'industry_link', $industry_id ) ?: array('url' => get_permalink( $industry_id ), 'title' => 'Learn More');
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