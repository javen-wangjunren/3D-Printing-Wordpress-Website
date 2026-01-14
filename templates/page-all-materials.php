<?php
/* Template Name: All Materials */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

get_header();

get_template_part( 'blocks/global/hero-banner/render' );

global $wpdb;

$include_empty_terms = (bool) get_field( 'all_materials_include_empty_terms' );

$show_process = (bool) get_field( 'filter_sidebar_show_process' );
$show_type = (bool) get_field( 'filter_sidebar_show_type' );
$show_cost = (bool) get_field( 'filter_sidebar_show_cost' );
$show_lead_time = (bool) get_field( 'all_materials_show_lead_time' );

$sidebar_title = (string) ( get_field( 'filter_sidebar_title' ) ?: '' );
$sidebar_subtitle_template = (string) ( get_field( 'filter_sidebar_subtitle' ) ?: '' );
$search_placeholder = (string) ( get_field( 'filter_sidebar_search_placeholder' ) ?: '' );

$default_process_ids = (array) ( get_field( 'all_materials_default_processes' ) ?: array() );
$default_type_ids = (array) ( get_field( 'all_materials_default_types' ) ?: array() );
$default_cost_levels = (array) ( get_field( 'all_materials_default_cost_levels' ) ?: array() );
$default_lead_times = (array) ( get_field( 'all_materials_default_lead_times' ) ?: array() );

$posts_per_page = (int) ( get_field( 'all_materials_posts_per_page' ) ?: 60 );
$orderby = (string) ( get_field( 'all_materials_orderby' ) ?: 'title' );
$order = (string) ( get_field( 'all_materials_order' ) ?: 'ASC' );

$material_query = new WP_Query( array(
    'post_type' => 'material',
    'post_status' => 'publish',
    'posts_per_page' => $posts_per_page,
    'orderby' => $orderby,
    'order' => $order,
    'no_found_rows' => false,
) );

$material_count = (int) $material_query->found_posts;
$sidebar_subtitle = $sidebar_subtitle_template ? str_replace( '{count}', (string) $material_count, $sidebar_subtitle_template ) : '';

$terms_hide_empty = $include_empty_terms ? false : true;

$process_terms = $show_process ? get_terms( array(
    'taxonomy' => 'material_process',
    'hide_empty' => $terms_hide_empty,
) ) : array();

$type_terms = $show_type ? get_terms( array(
    'taxonomy' => 'material_type',
    'hide_empty' => $terms_hide_empty,
) ) : array();

$cost_levels = array();
if ( $show_cost ) {
    $cost_levels = $wpdb->get_col(
        "SELECT DISTINCT pm.meta_value\n" .
        "FROM {$wpdb->postmeta} pm\n" .
        "INNER JOIN {$wpdb->posts} p ON p.ID = pm.post_id\n" .
        "WHERE pm.meta_key = 'material_cost_level'\n" .
        "AND p.post_type = 'material'\n" .
        "AND p.post_status = 'publish'\n" .
        "AND pm.meta_value <> ''\n" .
        "ORDER BY pm.meta_value ASC"
    );
    $cost_levels = array_values( array_unique( array_filter( array_map( 'strval', (array) $cost_levels ) ) ) );
}

$lead_times = array();
if ( $show_lead_time ) {
    $lead_times = $wpdb->get_col(
        "SELECT DISTINCT pm.meta_value\n" .
        "FROM {$wpdb->postmeta} pm\n" .
        "INNER JOIN {$wpdb->posts} p ON p.ID = pm.post_id\n" .
        "WHERE pm.meta_key = 'material_lead_time'\n" .
        "AND p.post_type = 'material'\n" .
        "AND p.post_status = 'publish'\n" .
        "AND pm.meta_value <> ''\n" .
        "ORDER BY pm.meta_value ASC"
    );
    $lead_times = array_values( array_unique( array_filter( array_map( 'strval', (array) $lead_times ) ) ) );
}

$default_process_slugs = array();
if ( ! empty( $default_process_ids ) ) {
    $default_process_terms = get_terms( array(
        'taxonomy' => 'material_process',
        'include' => array_map( 'intval', $default_process_ids ),
        'hide_empty' => false,
    ) );
    if ( ! is_wp_error( $default_process_terms ) ) {
        foreach ( $default_process_terms as $t ) {
            $default_process_slugs[] = $t->slug;
        }
    }
}

$default_type_slugs = array();
if ( ! empty( $default_type_ids ) ) {
    $default_type_terms = get_terms( array(
        'taxonomy' => 'material_type',
        'include' => array_map( 'intval', $default_type_ids ),
        'hide_empty' => false,
    ) );
    if ( ! is_wp_error( $default_type_terms ) ) {
        foreach ( $default_type_terms as $t ) {
            $default_type_slugs[] = $t->slug;
        }
    }
}

$seo_copy = get_field( 'all_materials_seo_copy' );

$sidebar_bg_style = (string) ( get_field( 'filter_sidebar_bg_style' ) ?: 'bg-page' );
$mobile_compact_mode = (bool) get_field( 'filter_sidebar_mobile_compact_mode' );
$mobile_hide_subtitle = (bool) get_field( 'filter_sidebar_mobile_hide_subtitle' );

?>

<section class="all-materials-page" data-material-library>
    <div class="all-materials-shell" data-mobile-compact-mode="<?php echo esc_attr( $mobile_compact_mode ? '1' : '0' ); ?>">

        <?php if ( $seo_copy ) : ?>
            <div class="all-materials-seo" data-seo-copy>
                <?php echo wp_kses_post( $seo_copy ); ?>
            </div>
        <?php endif; ?>

        <div class="all-materials-layout">

            <aside class="materials-filter-sidebar <?php echo esc_attr( $sidebar_bg_style ); ?>" data-filter-sidebar
                   data-default-process="<?php echo esc_attr( implode( ' ', array_unique( array_filter( $default_process_slugs ) ) ) ); ?>"
                   data-default-type="<?php echo esc_attr( implode( ' ', array_unique( array_filter( $default_type_slugs ) ) ) ); ?>"
                   data-default-cost="<?php echo esc_attr( implode( ' ', array_unique( array_filter( array_map( 'strval', $default_cost_levels ) ) ) ) ); ?>"
                   data-default-lead-time="<?php echo esc_attr( implode( ' | ', array_unique( array_filter( array_map( 'strval', $default_lead_times ) ) ) ) ); ?>">

                <header class="filter-sidebar-header">
                    <?php if ( $sidebar_title ) : ?>
                        <h2 class="filter-sidebar-title"><?php echo esc_html( $sidebar_title ); ?></h2>
                    <?php endif; ?>

                    <?php if ( $sidebar_subtitle && ! $mobile_hide_subtitle ) : ?>
                        <p class="filter-sidebar-subtitle"><?php echo esc_html( $sidebar_subtitle ); ?></p>
                    <?php endif; ?>
                </header>

                <div class="filter-sidebar-search">
                    <input type="search" class="filter-search-input" data-filter-search placeholder="<?php echo esc_attr( $search_placeholder ); ?>" />
                </div>

                <?php if ( $show_process && ! is_wp_error( $process_terms ) && ! empty( $process_terms ) ) : ?>
                    <div class="filter-group" data-filter-group="process">
                        <h4 class="filter-title"><?php echo esc_html( (string) ( get_field( 'filter_sidebar_process_label' ) ?: 'Process' ) ); ?></h4>
                        <?php foreach ( $process_terms as $term ) : ?>
                            <label class="checkbox-item">
                                <input type="checkbox" data-filter="process" value="<?php echo esc_attr( $term->slug ); ?>">
                                <?php echo esc_html( $term->name ); ?>
                            </label>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>

                <?php if ( $show_type && ! is_wp_error( $type_terms ) && ! empty( $type_terms ) ) : ?>
                    <div class="filter-group" data-filter-group="type">
                        <h4 class="filter-title"><?php echo esc_html( (string) ( get_field( 'filter_sidebar_type_label' ) ?: 'Type' ) ); ?></h4>
                        <?php foreach ( $type_terms as $term ) : ?>
                            <label class="checkbox-item">
                                <input type="checkbox" data-filter="type" value="<?php echo esc_attr( $term->slug ); ?>">
                                <?php echo esc_html( $term->name ); ?>
                            </label>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>

                <?php if ( $show_cost && ! empty( $cost_levels ) ) : ?>
                    <div class="filter-group" data-filter-group="cost">
                        <h4 class="filter-title"><?php echo esc_html( (string) ( get_field( 'filter_sidebar_cost_label' ) ?: 'Cost' ) ); ?></h4>
                        <?php foreach ( $cost_levels as $cost ) : ?>
                            <label class="checkbox-item">
                                <input type="checkbox" data-filter="cost" value="<?php echo esc_attr( $cost ); ?>">
                                <?php echo esc_html( $cost ); ?>
                            </label>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>

                <?php if ( $show_lead_time && ! empty( $lead_times ) ) : ?>
                    <div class="filter-group" data-filter-group="lead_time">
                        <h4 class="filter-title"><?php echo esc_html( 'Lead Time' ); ?></h4>
                        <?php foreach ( $lead_times as $lt ) : ?>
                            <label class="checkbox-item">
                                <input type="checkbox" data-filter="lead_time" value="<?php echo esc_attr( $lt ); ?>">
                                <?php echo esc_html( $lt ); ?>
                            </label>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>
            </aside>

            <main class="materials-grid-area" data-materials-grid>
                <?php if ( $material_query->have_posts() ) : ?>
                    <div class="materials-grid">
                        <?php while ( $material_query->have_posts() ) : $material_query->the_post(); ?>
                            <?php
                            $material_id = get_the_ID();
                            $permalink = get_permalink( $material_id );

                            $process_slugs = array();
                            $process_terms_for_post = wp_get_post_terms( $material_id, 'material_process' );
                            if ( ! is_wp_error( $process_terms_for_post ) && ! empty( $process_terms_for_post ) ) {
                                foreach ( $process_terms_for_post as $t ) {
                                    $process_slugs[] = $t->slug;
                                }
                            } else {
                                $process_value = (string) ( get_field( 'material_process', $material_id ) ?: '' );
                                if ( $process_value ) {
                                    $process_slugs[] = $process_value;
                                }
                            }

                            $type_slugs = array();
                            $type_terms_for_post = wp_get_post_terms( $material_id, 'material_type' );
                            if ( ! is_wp_error( $type_terms_for_post ) && ! empty( $type_terms_for_post ) ) {
                                foreach ( $type_terms_for_post as $t ) {
                                    $type_slugs[] = $t->slug;
                                }
                            } else {
                                $type_value = (string) ( get_field( 'material_type', $material_id ) ?: '' );
                                if ( $type_value ) {
                                    $type_slugs[] = $type_value;
                                }
                            }

                            $characteristic_slugs = array();
                            $char_terms_for_post = wp_get_post_terms( $material_id, 'material_characteristic' );
                            if ( ! is_wp_error( $char_terms_for_post ) && ! empty( $char_terms_for_post ) ) {
                                foreach ( $char_terms_for_post as $t ) {
                                    $characteristic_slugs[] = $t->slug;
                                }
                            }

                            $cost_level = (string) ( get_field( 'material_cost_level', $material_id ) ?: '' );
                            $lead_time = (string) ( get_field( 'material_lead_time', $material_id ) ?: '' );

                            $thumb_id = (int) get_post_thumbnail_id( $material_id );
                            if ( ! $thumb_id ) {
                                $thumb_id = (int) ( get_field( 'hero_image', $material_id ) ?: 0 );
                            }

                            $primary_process = ! empty( $process_slugs ) ? $process_slugs[0] : '';
                            $primary_type = ! empty( $type_slugs ) ? $type_slugs[0] : '';
                            ?>

                            <article class="material-card"
                                     data-material-card
                                     data-material-id="<?php echo esc_attr( (string) $material_id ); ?>"
                                     data-title="<?php $t = (string) get_the_title( $material_id ); echo esc_attr( function_exists( 'mb_strtolower' ) ? mb_strtolower( $t ) : strtolower( $t ) ); ?>"
                                     data-process="<?php echo esc_attr( implode( ' ', array_unique( array_filter( $process_slugs ) ) ) ); ?>"
                                     data-type="<?php echo esc_attr( implode( ' ', array_unique( array_filter( $type_slugs ) ) ) ); ?>"
                                     data-cost="<?php echo esc_attr( $cost_level ); ?>"
                                     data-lead-time="<?php echo esc_attr( $lead_time ); ?>"
                                     data-characteristic="<?php echo esc_attr( implode( ' ', array_unique( array_filter( $characteristic_slugs ) ) ) ); ?>">

                                <a class="material-card-link" href="<?php echo esc_url( $permalink ); ?>">
                                    <div class="material-card-media">
                                        <?php if ( $thumb_id ) : ?>
                                            <?php echo wp_get_attachment_image( $thumb_id, 'medium_large', false, array( 'class' => 'material-card-image' ) ); ?>
                                        <?php endif; ?>

                                        <?php if ( $primary_process ) : ?>
                                            <span class="material-card-tag material-card-tag-process" data-tag="process"><?php echo esc_html( $primary_process ); ?></span>
                                        <?php endif; ?>

                                        <?php if ( $primary_type ) : ?>
                                            <span class="material-card-tag material-card-tag-type" data-tag="type"><?php echo esc_html( $primary_type ); ?></span>
                                        <?php endif; ?>
                                    </div>

                                    <div class="material-card-body">
                                        <h3 class="material-card-title"><?php the_title(); ?></h3>

                                        <div class="material-card-badges">
                                            <?php if ( $cost_level ) : ?>
                                                <div class="material-card-badge" data-badge="cost">
                                                    <span class="material-card-badge-label">COST</span>
                                                    <span class="material-card-badge-value"><?php echo esc_html( $cost_level ); ?></span>
                                                </div>
                                            <?php endif; ?>

                                            <?php if ( $lead_time ) : ?>
                                                <div class="material-card-badge" data-badge="lead_time">
                                                    <span class="material-card-badge-label">LEAD TIME</span>
                                                    <span class="material-card-badge-value"><?php echo esc_html( $lead_time ); ?></span>
                                                </div>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                </a>
                            </article>
                        <?php endwhile; ?>
                    </div>
                <?php else : ?>
                    <p class="materials-empty">No materials found.</p>
                <?php endif; ?>
            </main>
        </div>
    </div>
</section>

<?php
wp_reset_postdata();
get_footer();
