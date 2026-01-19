<?php
/**
 * Template Name: Single Material
 * Post Type: material
 * 
 * 渲染逻辑：
 * 1. Hero Banner (数据来源：Current CPT)
 * 2. Manufacturing Showcase (数据来源：Current CPT)
 * 3. Technical Specs (数据来源：Current CPT)
 * 4. Manufacturing Capabilities (数据来源：Current CPT)
 * 5. CTA (全局模块)
 */

get_header();
?>

<main id="site-content" class="site-main">
    <?php while ( have_posts() ) : the_post(); ?>

        <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
            
            <?php
            /**
             * 1. Hero Banner
             */
            _3dp_render_block( 'blocks/global/hero-banner/render', array( 'id' => 'overview' ) );

            /**
             * 2. Manufacturing Showcase
             */
            _3dp_render_block( 'blocks/global/manufacturing-showcase/render', array( 'id' => 'gallery' ) );

            /**
             * 3. Technical Specs
             */
            _3dp_render_block( 'blocks/global/technical-specs/render', array( 'id' => 'specifications' ) );

            /**
             * 4. Manufacturing Capabilities
             */
            _3dp_render_block( 'blocks/global/manufacturing-capabilities/render', array( 'id' => 'capabilities' ) );

            /**
             * 5. CTA (Global)
             */
            _3dp_render_block( 'blocks/global/cta/render', array( 'id' => 'cta' ) );

            /**
             * 6. Related Blog
             */
            _3dp_render_block( 'blocks/global/related-blog/render', array( 'id' => 'related-stories' ) );
            ?>

        </article>

    <?php endwhile; ?>
</main>

<?php
get_footer();
