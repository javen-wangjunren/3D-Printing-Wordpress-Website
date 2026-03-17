<?php
if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly.
}

get_header();
?>

<main id="main" class="site-main single-solution">
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
            get_template_part( 'template-parts/application/hero' );
            get_template_part( 'template-parts/application/technical-strength' );
            get_template_part( 'template-parts/application/showcase' );
            get_template_part( 'template-parts/application/recommendation' );
            get_template_part( 'template-parts/application/certification' );
            
            // --- FAQ Module (Local Clone Data) ---
            get_template_part( 'template-parts/components/faq', null, array(
                'prefix' => 'solution_faq'
            ));

            // --- Global CTA Module ---
            if ( function_exists( '_3dp_render_block' ) ) {
                _3dp_render_block( 'blocks/global/cta/render', array( 
                    'id' => 'cta' 
                ) );
            }

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
