<?php
/* Template Name: About Us */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

get_header();
?>

<main id="main" class="site-main page-about">
    <?php _3dp_render_block( 'blocks/global/hero-banner/render', array( 'id' => 'about-hero', 'prefix' => 'about_hero_' ) ); ?>
    <?php _3dp_render_block( 'blocks/global/mission/render', array( 'id' => 'about-mission', 'prefix' => 'about_mission_' ) ); ?>
    <?php _3dp_render_block( 'blocks/global/timeline/render', array( 'id' => 'about-timeline', 'prefix' => 'about_timeline_' ) ); ?>
    <?php _3dp_render_block( 'blocks/global/team/render', array( 'id' => 'about-team', 'prefix' => 'about_team_' ) ); ?>
    <?php _3dp_render_block( 'blocks/global/factory-image/render', array( 'id' => 'about-factory', 'prefix' => 'about_factory_' ) ); ?>
    <?php _3dp_render_block( 'blocks/global/cta/render', array( 'id' => 'about-cta' ) ); ?>
</main>

<?php
get_footer();
