<?php
/**
 * Template Name: All Capabilities
 *
 * Template for All Capabilities page
 *
 * @package 3D Printing
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

get_header();
?>

<main id="main" class="site-main page-all-capabilities">
    <?php

    // Hero Banner
    _3dp_render_block( 'blocks/global/hero-banner/render', array( 'id' => 'overview', 'prefix' => 'all_caps_hero_' ) );

// Capability List
_3dp_render_block( 'blocks/global/capability-list/render', array( 'id' => 'list', 'prefix' => 'allcaps_capability_list_' ) );

// Comparison Table
_3dp_render_block( 'blocks/global/comparison-table/render', array( 'id' => 'comparison', 'prefix' => 'allcaps_comparison_' ) );

// Material List
_3dp_render_block( 'blocks/global/material-list/render', array( 'id' => 'materials', 'prefix' => 'allcaps_material_list_' ) );

// Surface Finish
_3dp_render_block( 'blocks/global/surface-finish/render', array( 'id' => 'finishes', 'prefix' => 'allcaps_surface_finish_' ) );

// Why Choose Us (Global Options)
if ( have_rows( 'why_choose_us', 'option' ) ) {
    $wcu_index = 0;
    while ( have_rows( 'why_choose_us', 'option' ) ) {
        the_row();
        $wcu_index++;
        _3dp_render_block( 'blocks/global/why-choose-us/render', array( 'id' => 'why-us-' . $wcu_index ) );
    }
}

// CTA (Global Options)
if ( have_rows( 'cta', 'option' ) ) {
    $cta_index = 0;
    while ( have_rows( 'cta', 'option' ) ) {
        the_row();
        $cta_index++;
        _3dp_render_block( 'blocks/global/cta/render', array( 'id' => 'cta-' . $cta_index ) );
    }
}

// Related Blog (Current Page with manual selection)
_3dp_render_block( 'blocks/global/related-blog/render', array( 
    'id'     => 'related-stories',
    'prefix' => 'allcaps_related_blog_' 
) );
?>
</main>
<?php
get_footer();
