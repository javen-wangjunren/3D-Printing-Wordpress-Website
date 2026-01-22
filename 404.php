<?php
/**
 * The template for displaying 404 pages (not found)
 * 
 * 工业风格 404 页面
 * 布局：全宽容器 + 居中内容
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

get_header(); 
?>

<div class="w-full bg-bg-page min-h-[60vh] flex items-center justify-center py-20 lg:py-32">
    <div class="max-w-container mx-auto px-container text-center">
        
        <!-- Error Code -->
        <h1 class="text-[120px] lg:text-[180px] font-bold font-mono text-primary/10 leading-none select-none">
            404
        </h1>

        <div class="relative -mt-12 lg:-mt-16 z-10 space-y-6">
            <!-- Message -->
            <h2 class="text-h2 font-bold text-heading">
                <?php esc_html_e( 'Component Not Found', 'generatepress' ); ?>
            </h2>
            
            <p class="text-body text-lg max-w-md mx-auto">
                <?php esc_html_e( 'The page you are looking for might have been removed, had its name changed, or is temporarily unavailable.', 'generatepress' ); ?>
            </p>

            <!-- Action -->
            <div class="pt-6">
                <a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="inline-flex items-center gap-2 bg-primary hover:bg-primary-hover text-white px-8 py-3 rounded-button font-bold text-sm transition-colors shadow-lg shadow-primary/20">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
                    <?php esc_html_e( 'Return to Factory', 'generatepress' ); ?>
                </a>
            </div>
        </div>

    </div>
</div>

<?php 
get_footer(); 
