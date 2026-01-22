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

<main id="main" class="site-main single-capability">
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
                _3dp_render_block( 'blocks/global/hero-banner/render', array( 'id' => 'overview', 'prefix' => 'cap_hero_' ) );

                // ==========================================
                // 2. Trusted By Module (Global)
                // ==========================================
                _3dp_render_block( 'blocks/global/trusted-by/render', array( 'id' => 'trusted-partners' ) );

                // ==========================================
                // 3. How It Works Module (Current CPT Fields)
                // ==========================================
                _3dp_render_block( 'blocks/global/how-it-works/render', array( 'id' => 'process', 'prefix' => 'cap_process_' ) );

                // ==========================================
                // 4. Industry Slider Module (Global Options)-第一阶段不放这个内容
                // ==========================================
                _3dp_render_block( 'blocks/global/industry-slider/render', array( 'id' => 'applications' ) );

                // ==========================================
                // 5. Capability Design Guide Module (Current CPT Specs)
                // ==========================================
                _3dp_render_block( 'blocks/global/capability-design-guide/render', array( 'id' => 'design-guide', 'prefix' => 'cap_design_guide_' ) );

                // ==========================================
                // 6. Material List Module (Current CPT)
                // ==========================================
                _3dp_render_block( 'blocks/global/material-list/render', array( 'id' => 'materials', 'prefix' => 'cap_material_list_' ) );

                // ==========================================
                // 7. Comparison Table Module (Current CPT)
                // ==========================================
                _3dp_render_block( 'blocks/global/comparison-table/render', array( 'id' => 'comparison', 'prefix' => 'cap_comparison_' ) );

                // ==========================================
                // 8. Why Choose Us Module (Global Options)
                // ==========================================
                _3dp_render_block( 'blocks/global/why-choose-us/render', array( 'id' => 'why-us' ) );

                // ==========================================
                // 9. Order Process Module (Global Options)
                // ==========================================
                _3dp_render_block( 'blocks/global/order-process/render', array( 'id' => 'order-process' ) );

                // ==========================================
                // 10. CTA Module (Global Options)
                // ==========================================
                _3dp_render_block( 'blocks/global/cta/render', array( 'id' => 'cta' ) );

                // ==========================================
                // 11. Related Blog Module (Auto Tag Match)
                // ==========================================
                // 显式传递当前工艺信息
                _3dp_render_block( 'blocks/global/related-blog/render', array( 
                    'id'                 => 'related-stories',
                    'prefix'             => 'cap_related_blog_',
                    'current_capability' => $current_capability
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
