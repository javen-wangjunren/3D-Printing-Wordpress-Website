<?php
if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly.
}

// 获取当前材料的标题和ID (Context Setup)
$current_material = array(
    'id'    => get_the_ID(),
    'title' => get_the_title(),
    'slug'  => get_post_field( 'post_name' )
);

// 设置全局变量，供子模块使用 (如果需要反向查询)
$GLOBALS['current_material'] = $current_material;

get_header();
?>

<main id="main" class="site-main single-material">
    <?php
    /**
     * generate_before_main_content hook.
     *
     * @since 0.1
     */
    do_action( 'generate_before_main_content' );

    if ( generate_has_default_loop() ) {
        while ( have_posts() ) :

            the_post();
            
            // ==========================================
            // 1. Hero Banner
            // ==========================================
            _3dp_render_block( 'blocks/global/hero-banner/render', array( 'id' => 'overview', 'prefix' => 'mat_hero_' ) );

            // ==========================================
            // 2. Manufacturing Showcase
            // ==========================================
            _3dp_render_block( 'blocks/global/manufacturing-showcase/render', array( 'id' => 'gallery', 'prefix' => 'mat_showcase_' ) );

            // ==========================================
            // 3. Technical Specs
            // ==========================================
            _3dp_render_block( 'blocks/global/technical-specs/render', array( 'id' => 'specifications', 'prefix' => 'mat_tech_specs_' ) );

            // ==========================================
            // 4. Manufacturing Capabilities
            // ==========================================
            _3dp_render_block( 'blocks/global/manufacturing-capabilities/render', array( 'id' => 'capabilities', 'prefix' => 'mat_capabilities_' ) );

            // ==========================================
            // 5. CTA (Global)
            // ==========================================
            _3dp_render_block( 'blocks/global/cta/render', array( 'id' => 'cta' ) );

            // ==========================================
            // 6. Related Blog
            // ==========================================
            _3dp_render_block( 'blocks/global/related-blog/render', array( 
                'id'               => 'related-stories', 
                'prefix'           => 'mat_related_blog_',
                'current_material' => $current_material // Explicitly pass context
            ) );

        endwhile;
    }

    /**
     * generate_after_main_content hook.
     *
     * @since 0.1
     */
    do_action( 'generate_after_main_content' );
    ?>
</main>

<?php
get_footer();
