<?php
/**
 * Template Name: Thank You (Success)
 * ==========================================================================
 * 文件作用:
 * 用户提交表单（如联系我们、获取报价）后的成功反馈页面。
 * 
 * 视觉风格:
 * 遵循 Industrial 4.0 审美，保持精密、专业、可信。
 * 
 * 核心组件:
 * 1. 成功状态指示器 (Success Icon)
 * 2. 核心确认文案 (Title & Description)
 * 3. 引导操作 (Call to Action Buttons)
 * 4. 底部支持入口 (Support Contact)
 * ==========================================================================
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly.
}

// 获取 ACF 字段数据
$title         = get_field( 'thank_you_title' ) ?: 'Submission Successful';
$desc          = get_field( 'thank_you_desc' ) ?: 'Thank you for reaching out to us. Your inquiry has been received and logged into our system. One of our technical experts will review your requirements and get back to you within 24 HOURS (business days).';
$cta_primary   = get_field( 'thank_you_cta_primary' );
$cta_secondary = get_field( 'thank_you_cta_secondary' );
$support_label = get_field( 'thank_you_support_label' ) ?: 'Need Immediate Assistance?';
$support_email = get_field( 'thank_you_support_email' ) ?: 'support@example.com';
$support_hours = get_field( 'thank_you_support_hours' ) ?: 'Mon - Fri: 9:00 - 18:00';

get_header();
?>

<main id="main" class="site-main bg-white">
    <section class="thank-you-section relative overflow-hidden py-24 sm:py-32">
        <!-- 装饰性背景元素 (Industrial Pattern) -->
        <div class="absolute inset-0 z-0 opacity-[0.03] pointer-events-none">
            <svg class="h-full w-full" fill="none" viewBox="0 0 100 100" preserveAspectRatio="none">
                <defs>
                    <pattern id="grid" width="40" height="40" patternUnits="userSpaceOnUse">
                        <path d="M 40 0 L 0 0 0 40" fill="none" stroke="#1D2938" stroke-width="0.5"/>
                    </pattern>
                </defs>
                <rect width="100%" height="100%" fill="url(#grid)" />
            </svg>
        </div>

        <div class="container mx-auto px-4 relative z-10">
            <div class="max-w-2xl mx-auto text-center">
                <!-- 成功图标: 物理锁定感与精密读数风格 -->
                <div class="mb-8 inline-flex items-center justify-center">
                    <div class="relative">
                        <!-- 外圈装饰 -->
                        <div class="absolute inset-0 rounded-full border border-[#0047AB]/20 animate-pulse"></div>
                        <!-- 核心圆环 -->
                        <div class="relative h-20 w-20 rounded-full bg-white border-[3px] border-[#0047AB] flex items-center justify-center shadow-[0_0_20px_rgba(0,71,171,0.1)]">
                            <svg class="h-10 w-10 text-[#0047AB]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7" />
                            </svg>
                        </div>
                    </div>
                </div>

                <!-- 标题与描述: tracking-tight & font-mono -->
                <h1 class="text-4xl sm:text-5xl font-bold text-[#1D2938] tracking-tight mb-6">
                    <?php echo esc_html( $title ); ?>
                </h1>
                
                <div class="text-lg text-slate-600 leading-relaxed mb-14">
                    <?php echo wp_kses_post( $desc ); ?>
                </div>

                <!-- 引导按钮: 工业级别物理感 -->
                <div class="flex flex-col sm:flex-row items-center justify-center gap-4">
                    <?php if ( $cta_primary ) : ?>
                        <a href="<?php echo esc_url( $cta_primary['url'] ); ?>" 
                           target="<?php echo esc_attr( $cta_primary['target'] ?: '_self' ); ?>"
                           class="w-full sm:w-auto inline-flex items-center justify-center rounded-[12px] bg-[#0047AB] px-8 py-4 text-sm font-bold text-white shadow-lg hover:bg-[#003d96] transition-all active:scale-[0.98]">
                            <?php echo esc_html( $cta_primary['title'] ); ?>
                        </a>
                    <?php else : ?>
                        <a href="<?php echo esc_url( home_url( '/' ) ); ?>" 
                           class="w-full sm:w-auto inline-flex items-center justify-center rounded-[12px] bg-[#0047AB] px-8 py-4 text-sm font-bold text-white shadow-lg hover:bg-[#003d96] transition-all active:scale-[0.98]">
                            Return to Home
                        </a>
                    <?php endif; ?>

                    <?php if ( $cta_secondary ) : ?>
                        <a href="<?php echo esc_url( $cta_secondary['url'] ); ?>" 
                           target="<?php echo esc_attr( $cta_secondary['target'] ?: '_self' ); ?>"
                           class="w-full sm:w-auto inline-flex items-center justify-center rounded-[12px] border-2 border-[#E4E7EC] bg-white px-8 py-4 text-sm font-bold text-[#1D2938] hover:bg-slate-50 transition-all">
                            <?php echo esc_html( $cta_secondary['title'] ); ?>
                        </a>
                    <?php else : ?>
                        <a href="<?php echo esc_url( home_url( '/all-materials/' ) ); ?>" 
                           class="w-full sm:w-auto inline-flex items-center justify-center rounded-[12px] border-2 border-[#E4E7EC] bg-white px-8 py-4 text-sm font-bold text-[#1D2938] hover:bg-slate-50 transition-all">
                            Explore Materials
                        </a>
                    <?php endif; ?>
                </div>

                <!-- 底部补充信息 -->
                <div class="mt-16 pt-10 border-t border-[#E4E7EC]">
                    <div class="text-[11px] font-bold text-slate-400 tracking-widest uppercase mb-4">
                        <?php echo esc_html( $support_label ); ?>
                    </div>
                    <div class="flex flex-wrap justify-center gap-x-8 gap-y-3">
                        <a href="mailto:<?php echo antispambot( $support_email ); ?>" class="flex items-center gap-2 text-[13px] font-mono text-[#1D2938] hover:text-[#0047AB] transition-colors">
                            <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" /></svg>
                            <?php echo esc_html( $support_email ); ?>
                        </a>
                        <div class="flex items-center gap-2 text-[13px] font-mono text-[#1D2938]">
                            <svg class="h-4 w-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                            <?php echo esc_html( $support_hours ); ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</main>

<?php
get_footer();
