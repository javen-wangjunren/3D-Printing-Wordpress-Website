<?php
/* Template Name: About Us */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

get_header();
?>

<main class="page-about">
    <?php _3dp_render_block( 'blocks/global/hero-banner/render', array( 'id' => 'about-hero' ) ); ?>
    <?php _3dp_render_block( 'blocks/global/mission/render', array( 'id' => 'about-mission' ) ); ?>
    <?php _3dp_render_block( 'blocks/global/timeline/render', array( 'id' => 'about-timeline' ) ); ?>
    <?php _3dp_render_block( 'blocks/global/team/render', array( 'id' => 'about-team' ) ); ?>
    <?php _3dp_render_block( 'blocks/global/factory-image/render', array( 'id' => 'about-factory' ) ); ?>
    <?php _3dp_render_block( 'blocks/global/cta/render', array( 'id' => 'about-cta' ) ); ?>
</main>

<?php
get_footer();
