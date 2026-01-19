<?php
// 1. 获取必要的元数据 (用于 JS 筛选)
$post_id = get_the_ID();
$card_id = 'material-card-' . (string) $post_id;

// Process
$process_slugs = array();
$process_terms = get_the_terms( $post_id, 'material_process' );
if ( $process_terms && ! is_wp_error( $process_terms ) ) {
    foreach ( $process_terms as $t ) $process_slugs[] = $t->slug;
} else {
    // Fallback: ACF Field
    $p_val = (string) get_field( 'material_process' );
    if ( $p_val ) $process_slugs[] = $p_val;
}

// Type
$type_slugs = array();
$type_terms = get_the_terms( $post_id, 'material_type' );
if ( $type_terms && ! is_wp_error( $type_terms ) ) {
    foreach ( $type_terms as $t ) $type_slugs[] = $t->slug;
} else {
    // Fallback: ACF Field
    $t_val = (string) get_field( 'material_type' );
    if ( $t_val ) $type_slugs[] = $t_val;
}

// Characteristic
$char_slugs = array();
$char_terms = get_the_terms( $post_id, 'material_characteristic' );
if ( $char_terms && ! is_wp_error( $char_terms ) ) {
    foreach ( $char_terms as $t ) $char_slugs[] = $t->slug;
}

// Basic Fields
$cost_level = (string) ( get_field( 'material_cost_level' ) ?: '' );
$lead_time  = (string) ( get_field( 'material_lead_time' ) ?: '' );
$title_raw  = get_the_title();
$title_attr = function_exists( 'mb_strtolower' ) ? mb_strtolower( $title_raw ) : strtolower( $title_raw );

// Display Labels
$primary_process = ! empty( $process_slugs ) ? $process_terms[0]->name : ( get_field( 'material_process' ) ?: '' );
$primary_type    = ! empty( $type_slugs ) ? $type_terms[0]->name : ( get_field( 'material_type' ) ?: '' );

?>
<article id="<?php echo esc_attr( $card_id ); ?>" 
     class="material-card group relative bg-white border border-border rounded-card overflow-hidden transition-all duration-300 ease-out hover:-translate-y-1 hover:border-primary hover:shadow-lg"
     data-material-card
     data-material-id="<?php echo esc_attr( (string) $post_id ); ?>"
     data-title="<?php echo esc_attr( $title_attr ); ?>"
     data-process="<?php echo esc_attr( implode( ' ', array_unique( array_filter( $process_slugs ) ) ) ); ?>"
     data-type="<?php echo esc_attr( implode( ' ', array_unique( array_filter( $type_slugs ) ) ) ); ?>"
     data-cost="<?php echo esc_attr( $cost_level ); ?>"
     data-lead-time="<?php echo esc_attr( $lead_time ); ?>"
     data-characteristic="<?php echo esc_attr( implode( ' ', array_unique( array_filter( $char_slugs ) ) ) ); ?>">

    <a class="material-card-link absolute inset-0 z-10" href="<?php echo esc_url( get_permalink() ); ?>" aria-label="<?php echo esc_attr( $title_raw ); ?>"></a>

    <div class="relative aspect-[4/3] bg-bg-section flex items-center justify-center p-4">
        <?php if ( $primary_process ) : ?>
            <span class="material-card-tag material-card-tag-process absolute top-4 left-4 inline-flex items-center rounded px-2.5 py-1 text-[10px] font-bold uppercase tracking-[0.08em] bg-heading text-white" data-tag="process">
                <?php echo esc_html( $primary_process ); ?>
            </span>
        <?php endif; ?>

        <?php if ( $primary_type ) : ?>
            <span class="material-card-tag material-card-tag-type absolute top-4 right-4 inline-flex items-center rounded border border-border bg-white px-2.5 py-1 text-[10px] font-bold uppercase tracking-[0.08em] text-heading" data-tag="type">
                <?php echo esc_html( $primary_type ); ?>
            </span>
        <?php endif; ?>

        <?php if ( has_post_thumbnail() ) : ?>
            <?php echo get_the_post_thumbnail( null, 'medium_large', array( 'class' => 'material-card-image h-full w-full object-contain mix-blend-multiply' ) ); ?>
        <?php endif; ?>
    </div>

    <div class="material-card-body p-6">
        <h3 class="material-card-title mb-4 text-h4 text-heading tracking-tight">
            <?php the_title(); ?>
        </h3>

        <?php if ( $cost_level || $lead_time ) : ?>
            <div class="material-card-badges flex gap-2.5">
                <?php if ( $cost_level ) : ?>
                    <div class="material-card-badge flex flex-1 flex-col rounded-md border border-primary/15 bg-primary/5 px-3 py-2" data-badge="cost">
                        <span class="material-card-badge-label mb-0.5 text-[9px] font-bold uppercase tracking-[0.12em] text-primary/70">COST</span>
                        <span class="material-card-badge-value font-mono text-sm font-bold text-primary">
                            <?php echo esc_html( $cost_level ); ?>
                        </span>
                    </div>
                <?php endif; ?>

                <?php if ( $lead_time ) : ?>
                    <div class="material-card-badge flex flex-1 flex-col rounded-md border border-primary/15 bg-primary/5 px-3 py-2" data-badge="lead_time">
                        <span class="material-card-badge-label mb-0.5 text-[9px] font-bold uppercase tracking-[0.12em] text-primary/70">LEAD TIME</span>
                        <span class="material-card-badge-value font-mono text-sm font-bold text-primary">
                            <?php echo esc_html( $lead_time ); ?>
                        </span>
                    </div>
                <?php endif; ?>
            </div>
        <?php endif; ?>
    </div>
</article>
