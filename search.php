<?php
/**
 * 搜索结果页模板 (Search Results Template)
 * ==========================================================================
 * 文件作用:
 * 覆盖 GeneratePress 默认的搜索结果页，提供基于 Tailwind CSS 的全定制工业风格展示。
 *
 * 核心逻辑:
 * 1. 头部区域: 显示当前的搜索关键词 (Query)。
 * 2. 结果循环: 遍历搜索结果 (Post/Page)，以网格卡片形式展示。
 * 3. 网格布局: 使用 Grid 系统自适应排列结果，包含缩略图、标题、摘要。
 * 4. 空状态: 当无结果时，显示友好的提示信息和重新搜索框。
 *
 * 架构角色:
 * 这是 WordPress 模板层级中的 `search.php`。即使当前网站暂未启用全站搜索功能，
 * 保留此文件可以防止意外访问搜索 URL (`/?s=xxx`) 时出现布局崩坏或回退到默认丑陋样式。
 *
 * 🚨 避坑指南:
 * - 依赖 `inc/setup.php` 中的 `no-sidebar` 过滤器来保证全宽布局。
 * - 使用了 `max-w-container` 来限制内容宽度，避免在大屏上过于拉伸。
 * ==========================================================================
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

get_header(); 
?>

<!-- 
  I. 主布局容器 (Main Layout Container)
  全宽背景 + 内容宽度限制
-->
<div class="w-full bg-bg-page py-16 lg:py-24">
    <div class="max-w-container mx-auto px-container">

        <!-- II. 搜索头部 (Search Header) -->
        <header class="mb-12 lg:mb-16 border-b border-border pb-8">
            <span class="block text-xs font-mono font-bold text-primary uppercase tracking-widest mb-2">
                <?php esc_html_e( 'Search Results', 'generatepress' ); ?>
            </span>
            <h1 class="text-h2 font-bold text-heading">
                <?php 
                printf( 
                    /* translators: %s: search query. */
                    esc_html__( 'Query: "%s"', 'generatepress' ), 
                    '<span class="text-primary">' . get_search_query() . '</span>' 
                ); 
                ?>
            </h1>
        </header>

        <!-- III. 结果循环 (Results Loop) -->
        <?php if ( have_posts() ) : ?>
            
            <!-- 网格布局 (Grid Layout) -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 lg:gap-8">
                <?php while ( have_posts() ) : the_post(); ?>
                    
                    <!-- 结果卡片 (Result Card) -->
                    <article id="post-<?php the_ID(); ?>" <?php post_class( 'flex flex-col bg-white border border-border rounded-card overflow-hidden hover:border-primary/50 transition-colors group' ); ?>>
                        
                        <!-- 卡片: 缩略图 -->
                        <?php if ( has_post_thumbnail() ) : ?>
                            <div class="h-48 overflow-hidden bg-bg-section">
                                <?php the_post_thumbnail( 'medium', array( 'class' => 'w-full h-full object-cover group-hover:scale-105 transition-transform duration-500' ) ); ?>
                            </div>
                        <?php endif; ?>

                        <!-- 卡片: 内容区域 -->
                        <div class="p-6 flex-1 flex flex-col">
                            <!-- Meta: 类型/日期 -->
                            <div class="mb-3">
                                <span class="text-[11px] font-mono text-muted uppercase tracking-wider">
                                    <?php echo get_post_type() === 'page' ? 'Page' : get_the_date(); ?>
                                </span>
                            </div>
                            
                            <!-- 标题 -->
                            <h2 class="text-lg font-bold text-heading mb-3 group-hover:text-primary transition-colors">
                                <a href="<?php the_permalink(); ?>" class="block">
                                    <?php the_title(); ?>
                                </a>
                            </h2>
                            
                            <!-- 摘要 -->
                            <div class="text-sm text-body line-clamp-3 mb-6 flex-1">
                                <?php the_excerpt(); ?>
                            </div>

                            <!-- 底部: 链接 -->
                            <div class="mt-auto pt-4 border-t border-border">
                                <a href="<?php the_permalink(); ?>" class="inline-flex items-center text-xs font-bold text-primary uppercase tracking-wider hover:text-primary-hover">
                                    <?php esc_html_e( 'View Detail', 'generatepress' ); ?>
                                    <svg class="w-3 h-3 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                                </a>
                            </div>
                        </div>
                    </article>

                <?php endwhile; ?>
            </div>

            <!-- IV. 分页导航 (Pagination) -->
            <div class="mt-12 lg:mt-16 pt-8 border-t border-border">
                <?php
                the_posts_pagination( array(
                    'mid_size'  => 2,
                    'prev_text' => __( '&larr; Previous', 'generatepress' ),
                    'next_text' => __( 'Next &rarr;', 'generatepress' ),
                    'class'     => 'flex justify-center gap-2 font-mono text-sm font-bold',
                ) );
                ?>
            </div>

        <?php else : ?>

            <!-- V. 空状态 (Empty State) -->
            <div class="bg-white border border-border rounded-card p-12 text-center">
                <div class="inline-flex items-center justify-center w-16 h-16 rounded-full bg-bg-section mb-6 text-muted">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                </div>
                <h2 class="text-xl font-bold text-heading mb-2"><?php esc_html_e( 'No results found', 'generatepress' ); ?></h2>
                <p class="text-body text-sm mb-6"><?php esc_html_e( 'Sorry, but nothing matched your search terms. Please try again with some different keywords.', 'generatepress' ); ?></p>
                
                <div class="max-w-md mx-auto">
                    <?php get_search_form(); ?>
                </div>
            </div>

        <?php endif; ?>

    </div>
</div>

<?php 
get_footer(); 
