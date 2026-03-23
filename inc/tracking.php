<?php
/**
 * 注入 GTM (Google Tag Manager) 代码
 * ==========================================================================
 * 保持代码纯净，通过原生 Hook 直接输出，拒绝第三方插件产生的数据库查询。
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/**
 * 核心配置：GTM ID
 * ==========================================================================
 * 将 ID 提取为常量，方便在不同环境或不同 Hook 中统一调用。
 */
if ( ! defined( 'TDP_GTM_ID' ) ) {
    define( 'TDP_GTM_ID', 'GTM-PGBVJZCG' );
}

// 1. 注入到 <head> 标签内 (尽可能靠前)
add_action( 'wp_head', '_3dp_inject_gtm_head_code', 1 ); // 优先级设为 1，确保最先加载
function _3dp_inject_gtm_head_code() {
    if ( empty( TDP_GTM_ID ) ) return;
    ?>
    <!-- Google Tag Manager -->
    <script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
    new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
    j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
    'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
    })(window,document,'script','dataLayer','<?php echo TDP_GTM_ID; ?>');</script>
    <!-- End Google Tag Manager -->
    <?php
}

// 2. 注入到 <body> 标签紧接着的后面
add_action( 'wp_body_open', '_3dp_inject_gtm_body_code', 1 );
function _3dp_inject_gtm_body_code() {
    if ( empty( TDP_GTM_ID ) ) return;
    ?>
    <!-- Google Tag Manager (noscript) -->
    <noscript><iframe src="https://www.googletagmanager.com/ns.html?id=<?php echo TDP_GTM_ID; ?>"
    height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
    <!-- End Google Tag Manager (noscript) -->
    <?php
}