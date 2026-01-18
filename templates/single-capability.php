<?php
/**
 * Single Capability Template
 * 单个工艺详情页模板
 * 
 * @package GeneratePress
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly.
}

// 获取当前工艺的标题和ID
$current_capability = array(
    'id' => get_the_ID(),
    'title' => get_the_title(),
    'slug' => get_post_field( 'post_name' )
);

// 设置全局变量，供子模块使用
$GLOBALS['current_capability'] = $current_capability;

get_header(); ?>

<div <?php generate_do_attr( 'content' ); ?>>
    <main <?php generate_do_attr( 'main' ); ?>>
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
                // 1. Hero Banner Module (Current CPT)
                // ==========================================
                get_template_part( 'blocks/global/hero-banner/render' );

                // ==========================================
                // 2. Trusted By Module (Global)
                // ==========================================
                get_template_part( 'blocks/global/trusted-by/render' );

                // ==========================================
                // 3. How It Works Module (Current CPT Fields)
                // ==========================================
                get_template_part( 'blocks/global/how-it-works/render' );

                // ==========================================
                // 4. Industry Slider Module (Global Options)
                // ==========================================
                get_template_part( 'blocks/global/industry-slider/render' );

                // ==========================================
                // 5. Capability Design Guide Module (Current CPT Specs)
                // ==========================================
                get_template_part( 'blocks/global/capability-design-guide/render' );

                // ==========================================
                // 6. Material List Module (Current CPT)
                // ==========================================
                get_template_part( 'blocks/global/material-list/render' );

                // ==========================================
                // 7. Comparison Table Module (Current CPT)
                // ==========================================
                get_template_part( 'blocks/global/comparison-table/render' );

                // ==========================================
                // 8. Why Choose Us Module (Global Options)
                // ==========================================
                get_template_part( 'blocks/global/why-choose-us/render' );

                // ==========================================
                // 9. Order Process Module (Global Options)
                // ==========================================
                get_template_part( 'blocks/global/order-process/render' );

                // ==========================================
                // 10. CTA Module (Global Options)
                // ==========================================
                get_template_part( 'blocks/global/cta/render' );

                // ==========================================
                // 11. Related Blog Module (Auto Tag Match)
                // ==========================================
                // 传递当前工艺信息给博客相关模块
                set_query_var( 'current_capability', $current_capability );
                get_template_part( 'blocks/global/related-blog/render' );

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
</div>

<?php
/**
 * generate_after_primary_content_area hook.
 *
 * @since 2.0
 */
do_action( 'generate_after_primary_content_area' );

generate_construct_sidebars();

get_footer();
