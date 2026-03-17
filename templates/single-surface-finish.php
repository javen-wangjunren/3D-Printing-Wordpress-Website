<?php
/**
 * Single Surface Finish Template
 * Description: The template for displaying a single Surface Finish CPT.
 * 
 * @package 3D_Printing
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// DEBUG START
// echo '<h1>DEBUG: Template Loaded Successfully</h1>';
// $hero_data = get_field('hero_section');
// echo '<pre>Hero Data: '; print_r($hero_data); echo '</pre>';
// $visual_data = get_field('visual_comparison');
// echo '<pre>Visual Data: '; print_r($visual_data); echo '</pre>';
// DEBUG END

get_header();

// ==========================================
// 1. Hero Banner (Global Clone)
// ==========================================
// We use the helper function to isolate scope and pass the prefix.
// The ACF Clone field is named 'hero_section' with prefix_name=1, so fields are 'hero_title', etc.
// The block expects 'hero_' prefix.
if ( function_exists( '_3dp_render_block' ) ) {
	_3dp_render_block( 'blocks/global/hero-banner/render', array(
		'prefix' => 'sf_hero_',
	) );
}

// ==========================================
// 2. Visual Comparison (Render Block)
// ==========================================
// Renders the visual comparison module from blocks/global.
// Fields are flattened on the post, so no prefix needed.
if ( function_exists( '_3dp_render_block' ) ) {
	_3dp_render_block( 'blocks/global/visual-comparison/render', array(
		'prefix' => 'sf_visual_',
	) );
}

// ==========================================
// 3. Technical Compatibility (Render Block)
// ==========================================
// Renders the technical compatibility module (Processes & Materials).
// Uses 'sf_compat_' prefix for module-specific fields.
if ( function_exists( '_3dp_render_block' ) ) {
	_3dp_render_block( 'blocks/global/surface-finish-compatibility/render', array(
		'prefix' => 'sf_compat_',
	) );
}

// ==========================================
// 4. Design Guide (Render Block)
// ==========================================
// Renders the design guide module (Best/Bad Practices).
// Uses 'sf_guide_' prefix for module-specific fields.
if ( function_exists( '_3dp_render_block' ) ) {
	_3dp_render_block( 'blocks/global/surface-finish-design-guide/render', array(
		'prefix' => 'sf_guide_',
	) );
}

// ==========================================
// 5. Commercial Parameters (Render Block)
// ==========================================
// Renders the commercial parameters module (Value/Yield/Cost).
// Uses 'sf_cp_' prefix for module-specific fields.
if ( function_exists( '_3dp_render_block' ) ) {
	_3dp_render_block( 'blocks/global/surface-finish-commercial-parameters/render', array(
		'prefix' => 'sf_cp_',
	) );
}

// ==========================================
// 6. FAQ Module (Local Clone Data)
// ==========================================
get_template_part('template-parts/components/faq', null, array(
	'prefix' => 'sf_faq_'
));

// ==========================================
// 7. Global CTA (Render Block)
// ==========================================
// Renders the global CTA module from Theme Options.
if ( function_exists( '_3dp_render_block' ) ) {
	_3dp_render_block( 'blocks/global/cta/render', array( 
		'id' => 'cta' 
	) );
}

get_footer();
