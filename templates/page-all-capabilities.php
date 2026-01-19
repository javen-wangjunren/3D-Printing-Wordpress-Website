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

// Hero Banner
_3dp_render_block( 'blocks/global/hero-banner/render', array( 'id' => 'overview' ) );

// Capability List
_3dp_render_block( 'blocks/global/capability-list/render', array( 'id' => 'list' ) );

// Comparison Table
_3dp_render_block( 'blocks/global/comparison-table/render', array( 'id' => 'comparison' ) );

// Material List
_3dp_render_block( 'blocks/global/material-list/render', array( 'id' => 'materials' ) );

// Surface Finish
_3dp_render_block( 'blocks/global/surface-finish/render', array( 'id' => 'finishes' ) );

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
$related_blog_posts = get_field( 'related_blog_posts' );
if ( $related_blog_posts && ! empty( $related_blog_posts ) ) {
    // 显式传递数据给模块，不再使用 set_query_var
    _3dp_render_block( 'blocks/global/related-blog/render', array( 
        'id'                 => 'related-stories',
        'related_blog_posts' => $related_blog_posts 
    ) );
}

get_footer();
