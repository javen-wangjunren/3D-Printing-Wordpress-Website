<?php
/* Template Name: All Materials */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

get_header();

// 1. Hero Banner Module
$hero_data = get_field( 'hero_section' );
if ( ! $hero_data ) {
    $hero_data = array();
}
$hero_data['id'] = 'hero';
_3dp_render_block( 'blocks/global/hero-banner/render', $hero_data );

// 2. Main Query for Material List
$posts_per_page = (int) ( get_field( 'all_materials_posts_per_page' ) ?: 60 );
$orderby        = (string) ( get_field( 'all_materials_orderby' ) ?: 'title' );
$order          = (string) ( get_field( 'all_materials_order' ) ?: 'ASC' );

$material_query = new WP_Query( array(
    'post_type'      => 'material',
    'post_status'    => 'publish',
    'posts_per_page' => $posts_per_page,
    'orderby'        => $orderby,
    'order'          => $order,
    'no_found_rows'  => false,
) );

$material_count      = (int) $material_query->found_posts;
$seo_copy            = get_field( 'all_materials_seo_copy' );
$mobile_compact_mode = (bool) get_field( 'filter_sidebar_mobile_compact_mode' );

?>

<main id="main" class="site-main page-all-materials">
    <section class="all-materials-page" data-material-library>
        <div class="all-materials-shell" data-mobile-compact-mode="<?php echo esc_attr( $mobile_compact_mode ? '1' : '0' ); ?>">

            <?php if ( $seo_copy ) : ?>
                <div class="all-materials-seo" data-seo-copy>
                    <?php echo wp_kses_post( $seo_copy ); ?>
                </div>
            <?php endif; ?>

            <div class="all-materials-layout">

                <!-- 3. Filter Sidebar Module -->
                <?php
                set_query_var( 'material_count', $material_count );
                get_template_part( 'blocks/global/filter-sidebar/render' );
                ?>

                <div class="materials-grid-area" data-materials-grid>
                    <?php if ( $material_query->have_posts() ) : ?>
                        <div class="materials-grid">
                            <?php while ( $material_query->have_posts() ) : $material_query->the_post(); ?>

                                <!-- 4. Material Card Module -->
                                <?php get_template_part( 'blocks/global/material-card/render' ); ?>

                            <?php endwhile; ?>
                        </div>
                    <?php else : ?>
                        <p class="materials-empty">No materials found.</p>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </section>
</main>

<?php
wp_reset_postdata();
get_footer();
