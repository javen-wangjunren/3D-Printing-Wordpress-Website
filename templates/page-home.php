<?php
/* Template Name: Home */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

get_header();
?>

<main class="page-home">
    <?php _3dp_render_block( 'blocks/global/hero-banner/render', array( 'id' => 'home-hero' ) ); ?>
    <?php _3dp_render_block( 'blocks/global/trusted-by/render', array( 'id' => 'home-trusted-by' ) ); ?>
    <?php _3dp_render_block( 'blocks/global/capability-list/render', array( 'id' => 'home-capability-list' ) ); ?>
    <?php _3dp_render_block( 'blocks/global/why-choose-us/render', array( 'id' => 'home-why-choose-us' ) ); ?>
    <?php _3dp_render_block( 'blocks/global/industry-slider/render', array( 'id' => 'home-industry-slider' ) ); ?>
    <?php _3dp_render_block( 'blocks/global/review-grid/render', array( 'id' => 'home-review-grid' ) ); ?>
    <?php _3dp_render_block( 'blocks/global/order-process/render', array( 'id' => 'home-order-process' ) ); ?>
    <?php _3dp_render_block( 'blocks/global/cta/render', array( 'id' => 'home-cta' ) ); ?>
    <?php _3dp_render_block( 'blocks/global/related-blog/render', array( 'id' => 'home-related-blog' ) ); ?>
</main>

<?php
get_footer();

