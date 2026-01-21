<div
    <?php
    
// Prefix Support
$pfx = isset($block['prefix']) ? $block['prefix'] : '';
global $wpdb;

    $material_count = (int) get_query_var( 'material_count', 0 );

    // 万能取数逻辑
    // 确定克隆名
    $clone_name = rtrim($pfx, '_');

    // 定义万能取数字段函数的调用
    $include_empty_terms = (bool) get_field_value('all_materials_include_empty_terms', $block, $clone_name, $pfx, false);

    $show_process = (bool) get_field_value('filter_sidebar_show_process', $block, $clone_name, $pfx, true);
    $show_type = (bool) get_field_value('filter_sidebar_show_type', $block, $clone_name, $pfx, true);
    $show_cost = (bool) get_field_value('filter_sidebar_show_cost', $block, $clone_name, $pfx, true);

    $sidebar_title = (string) get_field_value('filter_sidebar_title', $block, $clone_name, $pfx, '');
    $sidebar_subtitle_template = (string) get_field_value('filter_sidebar_subtitle', $block, $clone_name, $pfx, '');
    $search_placeholder = (string) get_field_value('filter_sidebar_search_placeholder', $block, $clone_name, $pfx, '');
    $sidebar_subtitle = $sidebar_subtitle_template ? str_replace( '{count}', (string) $material_count, $sidebar_subtitle_template ) : '';

    $terms_hide_empty = $include_empty_terms ? false : true;

    $process_terms = $show_process ? get_terms( array(
        'taxonomy'   => 'material_process',
        'hide_empty' => $terms_hide_empty,
    ) ) : array();

    $type_terms = $show_type ? get_terms( array(
        'taxonomy'   => 'material_type',
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

    $default_process_ids   = (array) get_field_value('all_materials_default_processes', $block, $clone_name, $pfx, array());
    $default_type_ids      = (array) get_field_value('all_materials_default_types', $block, $clone_name, $pfx, array());
    $default_cost_levels   = (array) get_field_value('all_materials_default_cost_levels', $block, $clone_name, $pfx, array());
    $default_lead_times    = (array) get_field_value('all_materials_default_lead_times', $block, $clone_name, $pfx, array());

    $default_process_slugs = array();
    if ( ! empty( $default_process_ids ) ) {
        $default_process_terms = get_terms( array(
            'taxonomy'   => 'material_process',
            'include'    => array_map( 'intval', $default_process_ids ),
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
            'taxonomy'   => 'material_type',
            'include'    => array_map( 'intval', $default_type_ids ),
            'hide_empty' => false,
        ) );
        if ( ! is_wp_error( $default_type_terms ) ) {
            foreach ( $default_type_terms as $t ) {
                $default_type_slugs[] = $t->slug;
            }
        }
    }

    $sidebar_bg_color     = (string) get_field_value('filter_sidebar_bg_style', $block, $clone_name, $pfx, '#ffffff');
    $mobile_compact_mode  = (bool) get_field_value('filter_sidebar_mobile_compact_mode', $block, $clone_name, $pfx, false);
    $mobile_hide_subtitle = (bool) get_field_value('filter_sidebar_mobile_hide_subtitle', $block, $clone_name, $pfx, false);

    $anchor       = (string) get_field_value('filter_sidebar_anchor_id', $block, $clone_name, $pfx, '');
    $custom_class = (string) get_field_value('filter_sidebar_custom_class', $block, $clone_name, $pfx, '');

    $extra_filters = (array) get_field_value('filter_sidebar_extra_filters', $block, $clone_name, $pfx, array());

    // 使用动态背景样式
    $bg_style_attr = 'style="background-color: ' . esc_attr( $sidebar_bg_color ) . '"';

    $class_names = trim( implode( ' ', array(
        'materials-filter-sidebar',
        'rounded-card',
        'border',
        'border-border',
        'px-4',
        'py-6',
        'lg:px-6',
        'lg:py-8',
        $custom_class,
    ) ) );

    $default_process_str   = implode( ' ', array_unique( array_filter( $default_process_slugs ) ) );
    $default_type_str      = implode( ' ', array_unique( array_filter( $default_type_slugs ) ) );
    $default_cost_str      = implode( ' ', array_unique( array_filter( array_map( 'strval', $default_cost_levels ) ) ) );
    $default_lead_time_str = implode( ' | ', array_unique( array_filter( array_map( 'strval', $default_lead_times ) ) ) );
    ?>
    id="<?php echo esc_attr( $anchor ); ?>"
    class="<?php echo esc_attr( $class_names ); ?>"
    <?php echo $bg_style_attr; ?>
    data-filter-sidebar
    data-mobile-compact-mode="<?php echo esc_attr( $mobile_compact_mode ? '1' : '0' ); ?>"
    data-default-process="<?php echo esc_attr( $default_process_str ); ?>"
    data-default-type="<?php echo esc_attr( $default_type_str ); ?>"
    data-default-cost="<?php echo esc_attr( $default_cost_str ); ?>"
    data-default-lead-time="<?php echo esc_attr( $default_lead_time_str ); ?>"
>

    <header class="mb-6 space-y-1">
        <?php if ( $sidebar_title ) : ?>
            <h2 class="text-h2 text-heading font-semibold tracking-tight">
                <?php echo esc_html( $sidebar_title ); ?>
            </h2>
        <?php endif; ?>

        <?php if ( $sidebar_subtitle && ! $mobile_hide_subtitle ) : ?>
            <p class="text-small text-muted">
                <?php echo esc_html( $sidebar_subtitle ); ?>
            </p>
        <?php endif; ?>
    </header>

    <div class="mb-8">
        <div class="relative">
            <input
                type="search"
                class="block w-full rounded-lg border border-border bg-white px-3 py-2 text-sm text-body placeholder:text-muted focus:border-primary focus:outline-none focus:ring-1 focus:ring-primary"
                data-filter-search
                placeholder="<?php echo esc_attr( $search_placeholder ); ?>"
            />
        </div>
    </div>

    <div class="space-y-6">
        <?php if ( $show_process && ! is_wp_error( $process_terms ) && ! empty( $process_terms ) ) : ?>
            <div class="space-y-3" data-filter-group="process">
                <h4 class="text-[11px] font-semibold uppercase tracking-[0.12em] text-muted">
                    <?php echo esc_html( (string) get_field_value('filter_sidebar_process_label', $block, $clone_name, $pfx, 'Process' ) ); ?>
                </h4>
                <div class="space-y-2">
                    <?php foreach ( $process_terms as $term ) : ?>
                        <label class="flex cursor-pointer items-center gap-2.5 text-sm text-body hover:text-primary">
                            <input
                                type="checkbox"
                                class="h-4 w-4 rounded border-border text-primary focus:ring-primary"
                                data-filter="process"
                                value="<?php echo esc_attr( $term->slug ); ?>"
                            />
                            <span><?php echo esc_html( $term->name ); ?></span>
                        </label>
                    <?php endforeach; ?>
                </div>
            </div>
        <?php endif; ?>

        <?php if ( $show_type && ! is_wp_error( $type_terms ) && ! empty( $type_terms ) ) : ?>
            <div class="space-y-3" data-filter-group="type">
                <h4 class="text-[11px] font-semibold uppercase tracking-[0.12em] text-muted">
                    <?php echo esc_html( (string) get_field_value('filter_sidebar_type_label', $block, $clone_name, $pfx, 'Type' ) ); ?>
                </h4>
                <div class="space-y-2">
                    <?php foreach ( $type_terms as $term ) : ?>
                        <label class="flex cursor-pointer items-center gap-2.5 text-sm text-body hover:text-primary">
                            <input
                                type="checkbox"
                                class="h-4 w-4 rounded border-border text-primary focus:ring-primary"
                                data-filter="type"
                                value="<?php echo esc_attr( $term->slug ); ?>"
                            />
                            <span><?php echo esc_html( $term->name ); ?></span>
                        </label>
                    <?php endforeach; ?>
                </div>
            </div>
        <?php endif; ?>

        <?php if ( $show_cost && ! empty( $cost_levels ) ) : ?>
            <div class="space-y-3" data-filter-group="cost">
                <h4 class="text-[11px] font-semibold uppercase tracking-[0.12em] text-muted">
                    <?php echo esc_html( (string) get_field_value('filter_sidebar_cost_label', $block, $clone_name, $pfx, 'Cost' ) ); ?>
                </h4>
                <div class="space-y-2">
                    <?php foreach ( $cost_levels as $cost ) : ?>
                        <label class="flex cursor-pointer items-center gap-2.5 text-sm text-body hover:text-primary">
                            <input
                                type="checkbox"
                                class="h-4 w-4 rounded border-border text-primary focus:ring-primary"
                                data-filter="cost"
                                value="<?php echo esc_attr( $cost ); ?>"
                            />
                            <span><?php echo esc_html( $cost ); ?></span>
                        </label>
                    <?php endforeach; ?>
                </div>
            </div>
        <?php endif; ?>

        <?php if ( ! empty( $extra_filters ) ) : ?>
            <?php foreach ( $extra_filters as $extra ) : ?>
                <?php
                $extra_label = isset( $extra['label'] ) ? (string) $extra['label'] : '';
                $extra_key   = isset( $extra['key'] ) ? (string) $extra['key'] : '';
                if ( ! $extra_label || ! $extra_key ) {
                    continue;
                }
                ?>
                <div class="space-y-3" data-filter-group="<?php echo esc_attr( $extra_key ); ?>">
                    <h4 class="text-[11px] font-semibold uppercase tracking-[0.12em] text-muted">
                        <?php echo esc_html( $extra_label ); ?>
                    </h4>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>
</div>
