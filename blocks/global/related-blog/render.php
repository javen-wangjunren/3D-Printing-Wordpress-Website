<?php
/**
 * Related Blog Block 的渲染模板
 * 
 * 展示与当前工艺相关的博客文章，基于标签或分类自动匹配
 */

// 从查询变量获取当前工艺信息
$current_capability = get_query_var( 'current_capability' );

$manual_related_posts = get_query_var( 'related_blog_posts' );

if ( $manual_related_posts && is_array( $manual_related_posts ) ) {
    $related_posts = array();
    foreach ( $manual_related_posts as $maybe_post ) {
        if ( $maybe_post instanceof WP_Post ) {
            $related_posts[] = $maybe_post;
            continue;
        }

        $post_obj = get_post( $maybe_post );
        if ( $post_obj instanceof WP_Post ) {
            $related_posts[] = $post_obj;
        }
    }

    $section_title = get_field( 'related_blog_title' ) ?: ( get_field( 'related_blog_title', 'option' ) ?: 'Related Blog Posts' );
    $section_desc = get_field( 'related_blog_description' ) ?: ( get_field( 'related_blog_description', 'option' ) ?: 'Stay updated with the latest news and insights about 3D printing technology.' );
    $cta_text = get_field( 'related_blog_cta_text', 'option' ) ?: 'View All Blog Posts';
    $cta_link = get_field( 'related_blog_cta_link', 'option' ) ?: array( 'url' => get_permalink( get_option( 'page_for_posts' ) ), 'title' => 'View All Blog Posts' );
    $has_posts = ! empty( $related_posts );
} else {
    // 尝试获取缓存数据
    $transient_key = 'related_blog_' . ( $current_capability ? $current_capability['id'] : 'all' );
    $blog_data = get_transient( $transient_key );

    // 如果没有缓存或缓存过期，重新生成数据
    if ( false === $blog_data ) {

        // 初始化查询参数
        $args = array(
            'post_type' => 'post',
            'posts_per_page' => 3,
            'orderby' => 'date',
            'order' => 'DESC',
            'post_status' => 'publish'
        );

        // 如果有当前工艺信息，尝试根据标签或分类筛选相关博客
        if ( $current_capability && ! empty( $current_capability['id'] ) ) {
            // 尝试获取当前工艺的标签
            $capability_tags = wp_get_post_tags( $current_capability['id'] );
            $capability_categories = wp_get_post_categories( $current_capability['id'] );

            // 如果有标签，使用标签查询相关博客
            if ( ! empty( $capability_tags ) ) {
                $tag_ids = array();
                foreach ( $capability_tags as $tag ) {
                    $tag_ids[] = $tag->term_id;
                }

                $args['tax_query'] = array(
                    array(
                        'taxonomy' => 'post_tag',
                        'field' => 'id',
                        'terms' => $tag_ids
                    )
                );
            }
            // 如果没有标签但有分类，使用分类查询相关博客
            elseif ( ! empty( $capability_categories ) ) {
                $args['category__in'] = $capability_categories;
            }
            // 如果没有标签和分类，尝试使用工艺标题作为关键词搜索
            elseif ( ! empty( $current_capability['title'] ) ) {
                $args['s'] = $current_capability['title'];
            }
        }

        $blog_query = new WP_Query( $args );
        $related_posts = $blog_query->posts;

        // 获取模块设置
        $section_title = get_field( 'related_blog_title' ) ?: ( get_field( 'related_blog_title', 'option' ) ?: 'Related Blog Posts' );
        $section_desc = get_field( 'related_blog_description' ) ?: ( get_field( 'related_blog_description', 'option' ) ?: 'Stay updated with the latest news and insights about 3D printing technology.' );
        $cta_text = get_field( 'related_blog_cta_text', 'option' ) ?: 'View All Blog Posts';
        $cta_link = get_field( 'related_blog_cta_link', 'option' ) ?: array( 'url' => get_permalink( get_option( 'page_for_posts' ) ), 'title' => 'View All Blog Posts' );

        // 缓存数据，有效期1小时
        $blog_data = array(
            'related_posts' => $related_posts,
            'section_title' => $section_title,
            'section_desc' => $section_desc,
            'cta_text' => $cta_text,
            'cta_link' => $cta_link,
            'has_posts' => $blog_query->have_posts()
        );

        set_transient( $transient_key, $blog_data, HOUR_IN_SECONDS );

        // 重置查询
        wp_reset_postdata();
    }

    // 从缓存数据中提取变量
    $related_posts = $blog_data['related_posts'];
    $section_title = $blog_data['section_title'];
    $section_desc = $blog_data['section_desc'];
    $cta_text = $blog_data['cta_text'];
    $cta_link = $blog_data['cta_link'];
    $has_posts = $blog_data['has_posts'];
}

// 如果没有相关博客，不显示模块
if ( ! $has_posts ) {
    return;
}
?>

<section class="related-blog-block">
    <?php if ( $section_title ) : ?>
        <h2 class="related-blog-title"><?php echo esc_html( $section_title ); ?></h2>
    <?php endif; ?>
    
    <?php if ( $section_desc ) : ?>
        <p class="related-blog-description"><?php echo esc_html( $section_desc ); ?></p>
    <?php endif; ?>

    <div class="related-blog-wrapper">
        <?php foreach ( $related_posts as $post ) : setup_postdata( $post ); ?>
            <div class="related-blog-item">
                <?php if ( has_post_thumbnail() ) : ?>
                    <div class="related-blog-image">
                        <a href="<?php echo get_permalink(); ?>">
                            <?php the_post_thumbnail( 'medium' ); ?>
                        </a>
                    </div>
                <?php endif; ?>
                
                <div class="related-blog-content">
                    <div class="related-blog-meta">
                        <span class="related-blog-date"><?php echo get_the_date(); ?></span>
                    </div>
                    
                    <h3 class="related-blog-post-title">
                        <a href="<?php echo get_permalink(); ?>">
                            <?php the_title(); ?>
                        </a>
                    </h3>
                    
                    <div class="related-blog-excerpt">
                        <?php the_excerpt(); ?>
                    </div>
                    
                    <div class="related-blog-read-more">
                        <a href="<?php echo get_permalink(); ?>" class="read-more-link">
                            Read More
                        </a>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
        <?php wp_reset_postdata(); ?>
    </div>
    
    <?php if ( $cta_link && isset( $cta_link['url'] ) && isset( $cta_link['title'] ) ) : ?>
        <div class="related-blog-cta">
            <a href="<?php echo esc_url( $cta_link['url'] ); ?>" 
               class="cta-button" 
               <?php if ( isset( $cta_link['target'] ) ) echo 'target="' . esc_attr( $cta_link['target'] ) . '"'; ?>>
                <?php echo esc_html( $cta_link['title'] ); ?>
            </a>
        </div>
    <?php endif; ?>
</section>
