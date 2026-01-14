<div class="group relative bg-white border border-border rounded-card overflow-hidden transition-all duration-300 ease-out hover:-translate-y-1 hover:border-primary hover:shadow-lg"
     data-process="<?php echo esc_attr( (string) ( get_field( 'material_process' ) ?: '' ) ); ?>"
     data-type="<?php echo esc_attr( (string) ( get_field( 'material_type' ) ?: '' ) ); ?>"
     data-cost="<?php echo esc_attr( (string) ( get_field( 'material_cost_level' ) ?: '' ) ); ?>"
     data-lead-time="<?php echo esc_attr( (string) ( get_field( 'material_lead_time' ) ?: '' ) ); ?>">

    <div class="relative aspect-[4/3] bg-bg-section flex items-center justify-center">
        <?php $process_value = (string) ( get_field( 'material_process' ) ?: '' ); ?>
        <?php if ( $process_value ) : ?>
            <span class="absolute top-4 left-4 inline-flex items-center rounded px-2.5 py-1 text-[10px] font-bold uppercase tracking-[0.08em] bg-heading text-white">
                <?php echo esc_html( $process_value ); ?>
            </span>
        <?php endif; ?>

        <?php $type_value = (string) ( get_field( 'material_type' ) ?: '' ); ?>
        <?php if ( $type_value ) : ?>
            <span class="absolute top-4 right-4 inline-flex items-center rounded border border-border bg-white px-2.5 py-1 text-[10px] font-bold uppercase tracking-[0.08em] text-heading">
                <?php echo esc_html( $type_value ); ?>
            </span>
        <?php endif; ?>

        <?php if ( has_post_thumbnail() ) : ?>
            <?php echo get_the_post_thumbnail( null, 'medium_large', array( 'class' => 'h-full w-full object-contain mix-blend-multiply' ) ); ?>
        <?php endif; ?>
    </div>

    <div class="p-6">
        <h3 class="mb-4 text-h4 text-heading tracking-tight">
            <?php the_title(); ?>
        </h3>

        <?php $cost_level = (string) ( get_field( 'material_cost_level' ) ?: '' ); ?>
        <?php $lead_time = (string) ( get_field( 'material_lead_time' ) ?: '' ); ?>

        <?php if ( $cost_level || $lead_time ) : ?>
            <div class="flex gap-2.5">
                <?php if ( $cost_level ) : ?>
                    <div class="flex flex-1 flex-col rounded-md border border-primary/15 bg-primary/5 px-3 py-2">
                        <span class="mb-0.5 text-[9px] font-bold uppercase tracking-[0.12em] text-primary/70">COST</span>
                        <span class="font-mono text-sm font-bold text-primary">
                            <?php echo esc_html( $cost_level ); ?>
                        </span>
                    </div>
                <?php endif; ?>

                <?php if ( $lead_time ) : ?>
                    <div class="flex flex-1 flex-col rounded-md border border-primary/15 bg-primary/5 px-3 py-2">
                        <span class="mb-0.5 text-[9px] font-bold uppercase tracking-[0.12em] text-primary/70">LEAD TIME</span>
                        <span class="font-mono text-sm font-bold text-primary">
                            <?php echo esc_html( $lead_time ); ?>
                        </span>
                    </div>
                <?php endif; ?>
            </div>
        <?php endif; ?>
    </div>

    <a href="<?php echo esc_url( get_permalink() ); ?>" class="absolute inset-0 z-10" aria-label="<?php echo esc_attr( get_the_title() ); ?>"></a>
</div>
