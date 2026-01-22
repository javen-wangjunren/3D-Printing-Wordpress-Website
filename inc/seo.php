<?php
/**
 * SEO & Metadata Enhancements
 * 
 * Handles breadcrumbs, meta tags adjustments, and other SEO-related logic.
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/**
 * ==============================================================================
 * Breadcrumbs Implementation (Industrial Utility Bar)
 * ==============================================================================
 * 
 * Logic:
 * 1. Detects SEOPress, Yoast SEO or RankMath breadcrumbs.
 * 2. Renders them in a dedicated "Utility Bar" below the header.
 * 3. Uses 'max-w-container' to align with the rest of the site content.
 * 4. Applies 'font-mono' for that technical/industrial look.
 * 
 * @hook generate_after_header
 */
add_action( 'generate_after_header', function() {
    // 1. Never show on Front Page
    if ( is_front_page() ) {
        return;
    }

    // 2. Check for SEOPress (Priority)
    if ( function_exists( 'seopress_display_breadcrumbs' ) ) {
        echo '<div class="w-full bg-bg-page border-b border-border">';
        echo '<div class="max-w-container mx-auto px-container py-2 lg:py-3">';
        // Wrap in a div to enforce industrial typography
        echo '<div class="text-[11px] lg:text-xs font-mono text-muted uppercase tracking-wider leading-none [&_a]:text-muted [&_a:hover]:text-primary [&_.sep]:px-2">';
        seopress_display_breadcrumbs();
        echo '</div>';
        echo '</div>';
        echo '</div>';
        return;
    }

    // 3. Check for Yoast SEO
    if ( function_exists( 'yoast_breadcrumb' ) ) {
        echo '<div class="w-full bg-bg-page border-b border-border">';
        echo '<div class="max-w-container mx-auto px-container py-2 lg:py-3">';
        yoast_breadcrumb( 
            '<p id="breadcrumbs" class="text-[11px] lg:text-xs font-mono text-muted uppercase tracking-wider leading-none">',
            '</p>' 
        );
        echo '</div>';
        echo '</div>';
        return;
    }

    // 4. Check for RankMath (Fallback)
    if ( function_exists( 'rank_math_the_breadcrumbs' ) ) {
        echo '<div class="w-full bg-bg-page border-b border-border">';
        echo '<div class="max-w-container mx-auto px-container py-2 lg:py-3">';
        // RankMath usually outputs its own wrapper, but we wrap it to constrain width
        rank_math_the_breadcrumbs();
        echo '</div>';
        echo '</div>';
    }
}, 20 );

/**
 * ==============================================================================
 * H1 Safety Check (Optional Helper)
 * ==============================================================================
 * 
 * If a page has no Hero Banner block, we might miss an H1.
 * This filter allows us to forcefully enable the default GP Title if needed,
 * but for now we assume the Editor handles it via blocks.
 */
// add_filter( 'generate_show_title', 'tdp_control_content_title' );
