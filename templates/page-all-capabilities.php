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
get_template_part( 'blocks/global/hero-banner/render' );

// Capability List
get_template_part( 'blocks/global/capability-list/render' );

// Comparison Table
get_template_part( 'blocks/global/comparison-table/render' );

// Material List
get_template_part( 'blocks/global/material-list/render' );

// Surface Finish
get_template_part( 'blocks/global/surface-finish/render' );

// Why Choose Us (Global Options)
if ( have_rows( 'why_choose_us', 'option' ) ) {
    while ( have_rows( 'why_choose_us', 'option' ) ) {
        the_row();
        get_template_part( 'blocks/global/why-choose-us/render' );
    }
}

// CTA (Global Options)
if ( have_rows( 'cta', 'option' ) ) {
    while ( have_rows( 'cta', 'option' ) ) {
        the_row();
        get_template_part( 'blocks/global/cta/render' );
    }
}

// Related Blog (Current Page with manual selection)
$related_blog_posts = get_field( 'related_blog_posts' );
if ( $related_blog_posts && ! empty( $related_blog_posts ) ) {
    // Set the related posts as a query variable for the render template
    set_query_var( 'related_blog_posts', $related_blog_posts );
    get_template_part( 'blocks/global/related-blog/render' );
}

get_footer();
