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

            // Placeholder for Solution content
            echo '<div class="container mx-auto py-20 px-4">';
            echo '<h1 class="text-4xl font-bold mb-4">' . get_the_title() . '</h1>';
            echo '<div class="prose max-w-none">';
            the_content();
            echo '</div>';
            echo '</div>';

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
