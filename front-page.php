<?php
/**
 * Front Page Template
 *
 * 作用：物理锁定首页渲染逻辑，无需后台手动指定模板。
 * 对应源：templates/page-home.php (已固化到此文件)
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

get_header();
?>

<main class="page-home">
    <?php _3dp_render_block( 'blocks/global/hero-banner/render', array( 'id' => 'home-hero', 'prefix' => 'home_hero_' ) ); ?>
    <?php _3dp_render_block( 'blocks/global/trusted-by/render', array( 'id' => 'home-trusted-by' ) ); ?>
    <?php _3dp_render_block( 'blocks/global/capability-list/render', array( 'id' => 'home-capability-list', 'prefix' => 'home_cap_' ) ); ?>
    <?php _3dp_render_block( 'blocks/global/why-choose-us/render', array( 'id' => 'home-why-choose-us' ) ); ?>
    <?php _3dp_render_block( 'blocks/global/industry-slider/render', array( 'id' => 'home-industry-slider' ) ); ?>
    <?php _3dp_render_block( 'blocks/global/review-grid/render', array( 'id' => 'home-review-grid', 'prefix' => 'home_rev_' ) ); ?>
    <?php _3dp_render_block( 'blocks/global/order-process/render', array( 'id' => 'home-order-process' ) ); ?>
    <?php _3dp_render_block( 'blocks/global/cta/render', array( 'id' => 'home-cta' ) ); ?>
    <?php _3dp_render_block( 'blocks/global/related-blog/render', array( 'id' => 'home-related-blog', 'prefix' => 'home_blog_' ) ); ?>
</main>

<?php
get_footer();
