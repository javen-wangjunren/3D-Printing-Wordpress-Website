<div
    <?php
    
// Prefix Support
$pfx = isset($block['prefix']) ? $block['prefix'] : '';
global $wpdb;

    // 万能取数逻辑
    // 确定克隆名
    $clone_name = rtrim($pfx, '_');

    $material_count = (int) get_query_var( 'material_count', 0 );

    // Get current filters from URL (or Default if empty)
    $url_process = isset($_GET['process']) ? explode(',', sanitize_text_field($_GET['process'])) : array();
    $url_type = isset($_GET['type']) ? explode(',', sanitize_text_field($_GET['type'])) : array();
    $url_cost = isset($_GET['cost']) ? explode(',', sanitize_text_field($_GET['cost'])) : array();

    // Default Filters (ACF) - Slugs
    $default_process_ids   = (array) get_field_value('all_materials_default_processes', $block, $clone_name, $pfx, array());
    $default_type_ids      = (array) get_field_value('all_materials_default_types', $block, $clone_name, $pfx, array());
    $default_cost_levels   = (array) get_field_value('all_materials_default_cost_levels', $block, $clone_name, $pfx, array());
    
    // Convert IDs to Slugs
    $default_process_slugs = array();
    if ( ! empty( $default_process_ids ) ) {
        $terms = get_terms( array( 'taxonomy' => 'material_process', 'include' => $default_process_ids, 'hide_empty' => false ) );
        if ( ! is_wp_error( $terms ) ) foreach ( $terms as $t ) $default_process_slugs[] = $t->slug;
    }
    
    $default_type_slugs = array();
    if ( ! empty( $default_type_ids ) ) {
        $terms = get_terms( array( 'taxonomy' => 'material_type', 'include' => $default_type_ids, 'hide_empty' => false ) );
        if ( ! is_wp_error( $terms ) ) foreach ( $terms as $t ) $default_type_slugs[] = $t->slug;
    }

    // Determine Active Filters (Merge URL and Defaults)
    // If URL param is set (even empty string), use URL. If not set at all, use Default.
    // However, in our JS logic, clearing filters removes the param. So if param is missing, we use default.
    $current_process = isset($_GET['process']) ? $url_process : $default_process_slugs;
    $current_type    = isset($_GET['type'])    ? $url_type    : $default_type_slugs;
    $current_cost    = isset($_GET['cost'])    ? $url_cost    : $default_cost_levels;

    // 定义万能取数字段函数的调用
    $include_empty_terms = (bool) get_field_value('all_materials_include_empty_terms', $block, $clone_name, $pfx, false);
    
    $show_process = (bool) get_field_value('filter_sidebar_show_process', $block, $clone_name, $pfx, true);
    $show_type = (bool) get_field_value('filter_sidebar_show_type', $block, $clone_name, $pfx, true);
    $show_cost = (bool) get_field_value('filter_sidebar_show_cost', $block, $clone_name, $pfx, true);

    $sidebar_title = (string) get_field_value('filter_sidebar_title', $block, $clone_name, $pfx, '');
    $sidebar_subtitle_template = (string) get_field_value('filter_sidebar_subtitle', $block, $clone_name, $pfx, '');
    $search_placeholder = (string) get_field_value('filter_sidebar_search_placeholder', $block, $clone_name, $pfx, '');
    $sidebar_subtitle = $sidebar_subtitle_template ? str_replace( '{count}', (string) $material_count, $sidebar_subtitle_template ) : '';
    $current_search = isset( $_GET['q'] ) ? trim( sanitize_text_field( (string) $_GET['q'] ) ) : '';

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

    $default_lead_times    = (array) get_field_value('all_materials_default_lead_times', $block, $clone_name, $pfx, array());

    $mobile_compact_mode  = (bool) get_field_value('filter_sidebar_mobile_compact_mode', $block, $clone_name, $pfx, false);
    $mobile_hide_subtitle = (bool) get_field_value('filter_sidebar_mobile_hide_subtitle', $block, $clone_name, $pfx, false);

    $anchor       = (string) get_field_value('filter_sidebar_anchor_id', $block, $clone_name, $pfx, '');
    $custom_class = (string) get_field_value('filter_sidebar_custom_class', $block, $clone_name, $pfx, '');

    $extra_filters = (array) get_field_value('filter_sidebar_extra_filters', $block, $clone_name, $pfx, array());

    $sidebar_bg_color     = (string) get_field_value('filter_sidebar_bg_style', $block, $clone_name, $pfx, '#ffffff');

    // 使用动态背景样式 - 强制覆盖为白色以确保卡片感
    $sidebar_bg_color = '#ffffff';
    $bg_style_attr = 'style="background-color: ' . esc_attr( $sidebar_bg_color ) . '"';

    $class_names = trim( implode( ' ', array(
        'materials-filter-sidebar',
        'rounded-xl', // 12px
        'border',
        'border-border',
        'bg-white',
        'shadow-sm',
        'p-6',
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
            <h3 class="text-xl text-heading font-bold tracking-tight mb-1">
                <?php echo esc_html( $sidebar_title ); ?>
            </h3>
        <?php endif; ?>

        <?php if ( $sidebar_subtitle && ! $mobile_hide_subtitle ) : ?>
            <p class="text-sm text-body font-medium">
                <?php echo esc_html( $sidebar_subtitle ); ?>
            </p>
        <?php endif; ?>
    </header>

    <div class="mb-8">
        <div class="relative">
            <input
                type="search"
                class="block w-full rounded-lg border border-border bg-gray-50/50 pl-3 pr-12 py-2.5 text-sm text-heading placeholder:text-muted/80 focus:border-primary focus:bg-white focus:outline-none focus:ring-1 focus:ring-primary transition-all duration-200"
                data-filter-search
                value="<?php echo esc_attr( $current_search ); ?>"
                placeholder="<?php echo esc_attr( $search_placeholder ); ?>"
            />
            <button type="button" class="absolute inset-y-0 right-0 flex items-center pr-3 text-muted hover:text-primary transition-colors" data-filter-search-submit aria-label="Search">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M21 21l-5.2-5.2m1.2-4.3a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
            </button>
        </div>
    </div>

    <div class="space-y-6">
        <?php if ( $show_process && ! is_wp_error( $process_terms ) && ! empty( $process_terms ) ) : ?>
            <div class="space-y-3" data-filter-group="process">
                <h4 class="flex items-center text-[10px] font-bold uppercase tracking-[0.1em] text-muted mb-0">
                    <span class="bg-gray-100 px-1.5 py-0.5 rounded text-gray-500"><?php echo esc_html( (string) get_field_value('filter_sidebar_process_label', $block, $clone_name, $pfx, 'Process' ) ); ?></span>
                    <span class="flex-1 h-px bg-border ml-2"></span>
                </h4>
                <div class="space-y-1">
                    <?php foreach ( $process_terms as $term ) : 
                        $checked = in_array( $term->slug, $current_process ) ? 'checked' : '';
                        $active_class = $checked ? 'bg-primary/5 text-primary font-medium' : 'text-body hover:bg-gray-50 hover:text-heading';
                    ?>
                        <label class="group flex cursor-pointer items-center justify-between rounded-md px-2 py-1.5 transition-colors duration-200 <?php echo $active_class; ?>">
                            <div class="flex items-center gap-2.5">
                                <input
                                    type="checkbox"
                                    class="h-4 w-4 rounded border-border text-primary focus:ring-primary focus:ring-offset-0"
                                    data-filter="process"
                                    value="<?php echo esc_attr( $term->slug ); ?>"
                                    <?php echo $checked; ?>
                                />
                                <span class="text-sm"><?php echo esc_html( $term->name ); ?></span>
                            </div>
                        </label>
                    <?php endforeach; ?>
                </div>
            </div>
        <?php endif; ?>

        <?php if ( $show_type && ! is_wp_error( $type_terms ) && ! empty( $type_terms ) ) : ?>
            <div class="space-y-3" data-filter-group="type">
                <h4 class="flex items-center text-[10px] font-bold uppercase tracking-[0.1em] text-muted mb-0">
                    <span class="bg-gray-100 px-1.5 py-0.5 rounded text-gray-500"><?php echo esc_html( (string) get_field_value('filter_sidebar_type_label', $block, $clone_name, $pfx, 'Type' ) ); ?></span>
                    <span class="flex-1 h-px bg-border ml-2"></span>
                </h4>
                <div class="space-y-1">
                    <?php foreach ( $type_terms as $term ) : 
                        $checked = in_array( $term->slug, $current_type ) ? 'checked' : '';
                        $active_class = $checked ? 'bg-primary/5 text-primary font-medium' : 'text-body hover:bg-gray-50 hover:text-heading';
                    ?>
                        <label class="group flex cursor-pointer items-center justify-between rounded-md px-2 py-1.5 transition-colors duration-200 <?php echo $active_class; ?>">
                            <div class="flex items-center gap-2.5">
                                <input
                                    type="checkbox"
                                    class="h-4 w-4 rounded border-border text-primary focus:ring-primary focus:ring-offset-0"
                                    data-filter="type"
                                    value="<?php echo esc_attr( $term->slug ); ?>"
                                    <?php echo $checked; ?>
                                />
                                <span class="text-sm"><?php echo esc_html( $term->name ); ?></span>
                            </div>
                        </label>
                    <?php endforeach; ?>
                </div>
            </div>
        <?php endif; ?>

        <?php if ( $show_cost && ! empty( $cost_levels ) ) : ?>
            <div class="space-y-3" data-filter-group="cost">
                <h4 class="flex items-center text-[10px] font-bold uppercase tracking-[0.1em] text-muted mb-0">
                    <span class="bg-gray-100 px-1.5 py-0.5 rounded text-gray-500"><?php echo esc_html( (string) get_field_value('filter_sidebar_cost_label', $block, $clone_name, $pfx, 'Cost' ) ); ?></span>
                    <span class="flex-1 h-px bg-border ml-2"></span>
                </h4>
                <div class="space-y-1">
                    <?php foreach ( $cost_levels as $cost ) : 
                        $checked = in_array( $cost, $current_cost ) ? 'checked' : '';
                        $active_class = $checked ? 'bg-primary/5 text-primary font-medium' : 'text-body hover:bg-gray-50 hover:text-heading';
                    ?>
                        <label class="group flex cursor-pointer items-center justify-between rounded-md px-2 py-1.5 transition-colors duration-200 <?php echo $active_class; ?>">
                            <div class="flex items-center gap-2.5">
                                <input
                                    type="checkbox"
                                    class="h-4 w-4 rounded border-border text-primary focus:ring-primary focus:ring-offset-0"
                                    data-filter="cost"
                                    value="<?php echo esc_attr( $cost ); ?>"
                                    <?php echo $checked; ?>
                                />
                                <span class="text-sm"><?php echo esc_html( $cost ); ?></span>
                            </div>
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
                    <h4 class="text-[11px] font-semibold uppercase tracking-[0.12em] text-muted mb-0">
                        <?php echo esc_html( $extra_label ); ?>
                    </h4>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>
    
    <script>
    document.addEventListener('DOMContentLoaded', function() {
        const sidebars = document.querySelectorAll('[data-filter-sidebar]');
        if (!sidebars.length) return;

        sidebars.forEach(sidebar => {
            const checkboxes = sidebar.querySelectorAll('input[type="checkbox"]');
            const searchInput = sidebar.querySelector('[data-filter-search]');
            const searchSubmit = sidebar.querySelector('[data-filter-search-submit]');

            function updateFilters() {
                const params = new URLSearchParams(window.location.search);
                params.delete('paged');

                const q = searchInput ? (searchInput.value || '').trim() : '';
                if (q) {
                    params.set('q', q);
                } else {
                    params.delete('q');
                }

                const groups = ['process', 'type', 'cost'];
                groups.forEach(group => {
                    const checked = Array.from(sidebar.querySelectorAll(`input[data-filter="${group}"]:checked`)).map(cb => cb.value);
                    if (checked.length > 0) {
                        params.set(group, checked.join(','));
                    } else {
                        params.delete(group);
                    }
                });

                window.location.search = params.toString();
            }

            checkboxes.forEach(cb => {
                cb.addEventListener('change', updateFilters);
            });

            if (searchInput) {
                searchInput.addEventListener('keydown', (e) => {
                    if (e.key !== 'Enter') return;
                    e.preventDefault();
                    updateFilters();
                });
            }

            if (searchSubmit) {
                searchSubmit.addEventListener('click', () => {
                    updateFilters();
                });
            }
        });
    });
    </script>
</div>
