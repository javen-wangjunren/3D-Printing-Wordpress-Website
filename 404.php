<?php
/**
 * 404 Error Page Template (页面未找到)
 * ==========================================================================
 * 文件作用:
 * 当用户访问不存在的 URL 时，WordPress 自动加载此模板。
 * 提供一个友好的错误提示界面，并引导用户返回首页。
 *
 * 核心逻辑:
 * 1. 采用全屏居中布局 (Flexbox)。
 * 2. 视觉设计遵循 "工业风格" (Industrial Style)，文案使用 "Component Not Found" 和 "Return to Factory"。
 * 3. 包含巨大的 404 背景字样和清晰的行动号召按钮 (CTA)。
 *
 * 架构角色:
 * 覆盖 GeneratePress 父主题的默认 404 模板，确保错误页面的视觉风格与全站保持一致（Tailwind CSS）。
 *
 * 🚨 避坑指南:
 * 1. 保持 `min-h-[60vh]` 或类似的高度设置，防止在短屏幕上 Footer 上浮遮挡内容。
 * 2. 所有的文本内容都使用了 `esc_html_e` 进行转义和国际化准备。
 * ==========================================================================
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly.
}

get_header(); ?>

<!-- 
  I. 404 页面主容器 
  使用 min-h-[60vh] 确保在内容较少时也能撑开足够的高度，避免 Footer 贴上来
-->
<div class="w-full bg-bg-page min-h-[60vh] flex items-center justify-center py-20 lg:py-32">
    <div class="max-w-container mx-auto px-container text-center">
        
        <!-- 
          II. 视觉主体: 巨大的 404 背景字
          text-primary/10 让它呈现为淡淡的水印效果，不抢主视觉
        -->
        <h1 class="text-[120px] lg:text-[180px] font-bold font-mono text-primary/10 leading-none select-none">
            404
        </h1>

        <!-- 
          III. 错误信息与操作区域
          使用负 margin (-mt) 让内容部分向上重叠在 404 背景字上，增加层次感
        -->
        <div class="relative -mt-12 lg:-mt-16 z-10 space-y-6">
            
            <!-- 标题: Component Not Found (工业风文案) -->
            <h2 class="text-h2 font-bold text-heading">
                <?php esc_html_e( 'Component Not Found', 'generatepress' ); ?>
            </h2>
            
            <!-- 描述信息 -->
            <p class="text-body text-lg max-w-md mx-auto">
                <?php esc_html_e( 'The page you are looking for might have been removed, had its name changed, or is temporarily unavailable.', 'generatepress' ); ?>
            </p>

            <!-- 
              IV. 行动号召 (CTA): 返回首页
              文案: Return to Factory
            -->
            <div class="pt-6">
                <a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="inline-flex items-center gap-2 bg-primary hover:bg-primary-hover text-white px-8 py-3 rounded-button font-bold text-sm transition-colors shadow-lg shadow-primary/20">
                    <!-- SVG Icon: Arrow Left -->
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                    </svg>
                    <?php esc_html_e( 'Return to Factory', 'generatepress' ); ?>
                </a>
            </div>

        </div>

    </div>
</div>

<?php get_footer(); ?>