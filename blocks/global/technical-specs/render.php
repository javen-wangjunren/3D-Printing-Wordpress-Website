<?php
/**
 * Technical Specs Block Template.
 *
 * @param   array $block The block settings and attributes.
 * @param   string $content The block inner HTML (empty).
 * @param   bool $is_preview True during AJAX preview.
 * @param   (int|string) $post_id The post ID this block is saved to.
 */

// 1. 获取基础数据
$block = isset( $block ) ? $block : array();
$block_id = _3dp_get_safe_block_id( $block, 'technical-specs' );
$classes = get_field('technical_specs_css_class') ?: '';
$material_label = get_field('technical_specs_material_label');
$intro = get_field('technical_specs_intro');
$tabs = get_field('technical_specs_tabs') ?: [];
$use_mono = get_field('technical_specs_use_mono_font');
$hide_table_mobile = get_field('technical_specs_hide_table_mobile');
$table_scrollable = get_field('technical_specs_table_scrollable');

// 2. 数据校验
if (empty($tabs)) {
    if (is_admin()) {
        echo '<div class="p-4 bg-gray-100 text-gray-500 text-center font-mono text-sm">Please add at least one property tab in the block settings.</div>';
    }
    return;
}

// 3. 提取首个 Tab Key 用于初始化 Alpine.js 状态
$first_tab_key = $tabs[0]['tab_key'] ?? 'tab-0';
?>

<section 
    id="<?php echo esc_attr($anchor); ?>" 
    class="py-10 lg:py-16 <?php echo esc_attr($classes); ?>"
    x-data="{ activeTab: '<?php echo esc_attr($first_tab_key); ?>' }"
>
    <div class="max-w-[1280px] mx-auto px-5 lg:px-8">
        
        <!-- Header Section -->
        <header class="mb-6 lg:mb-8">
            <h2 class="text-[26px] lg:text-[36px] font-bold text-heading mb-3 tracking-[-0.5px]">
                Technical Performance: 
                <?php if ($material_label): ?>
                    <span class="text-primary"><?php echo esc_html($material_label); ?></span>
                <?php endif; ?>
            </h2>
            <?php if ($intro): ?>
                <p class="text-[14px] lg:text-[15px] max-w-2xl leading-relaxed opacity-90 text-body">
                    <?php echo esc_html($intro); ?>
                </p>
            <?php endif; ?>
        </header>

        <!-- Tab Navigation -->
        <div class="flex flex-nowrap gap-1 border-b border-border mb-6 lg:mb-8 overflow-x-auto no-scrollbar [&::-webkit-scrollbar]:hidden [-ms-overflow-style:'none'] [scrollbar-width:'none']">
            <?php foreach ($tabs as $tab): 
                $key = $tab['tab_key'] ?: sanitize_title($tab['tab_title']);
                $title = $tab['tab_title'];
                $short_title = $tab['tab_short_title'];
            ?>
                <button 
                    @click.prevent="activeTab = '<?php echo esc_attr($key); ?>'"
                    :class="activeTab === '<?php echo esc_attr($key); ?>' ? 'active text-primary border-b-2 border-primary' : 'text-body hover:text-primary'"
                    class="whitespace-nowrap px-3 py-3 text-[12px] lg:text-[13px] lg:px-4 font-bold transition-colors duration-200"
                >
                    <?php if ($short_title): ?>
                        <span class="lg:hidden"><?php echo esc_html($short_title); ?></span>
                        <span class="hidden lg:inline"><?php echo esc_html($title); ?></span>
                    <?php else: ?>
                        <?php echo esc_html($title); ?>
                    <?php endif; ?>
                </button>
            <?php endforeach; ?>
        </div>

        <!-- Highlights Grid (Alpine Controlled) -->
        <div class="flex overflow-x-auto gap-2 pb-1 snap-x snap-mandatory [&::-webkit-scrollbar]:hidden [-ms-overflow-style:'none'] [scrollbar-width:'none'] md:grid md:grid-cols-3 md:gap-5 md:pb-0 mb-8 lg:mb-12">
            <?php foreach ($tabs as $tab): 
                $key = $tab['tab_key'] ?: sanitize_title($tab['tab_title']);
                $highlights = $tab['tab_highlights'] ?: [];
                $tag = $tab['tab_tag'] ?: $tab['tab_title'];
            ?>
                <!-- Wrapper using display: contents to let children participate in grid/flex directly -->
                <div x-show="activeTab === '<?php echo esc_attr($key); ?>'" class="contents">
                    <?php foreach ($highlights as $card): ?>
                        <div class="flex-[0_0_40%] min-w-0 snap-start md:flex-auto p-3 lg:p-8 border border-border rounded-card bg-white hover:border-primary/50 transition-all flex flex-col justify-between h-full group">
                            <span class="text-[8px] lg:text-[9px] font-bold text-primary uppercase tracking-widest opacity-80 truncate w-full block">
                                <?php echo esc_html($tag); ?>
                            </span>
                            <h3 class="text-[12px] lg:text-[17px] font-bold text-heading mt-1 mb-1 lg:mb-3 leading-tight h-[2.5em] lg:h-auto overflow-hidden text-ellipsis line-clamp-2">
                                <?php echo esc_html($card['highlight_title']); ?>
                            </h3>
                            <div class="<?php echo $use_mono ? 'font-mono' : 'font-sans'; ?> text-[18px] lg:text-[32px] font-bold text-heading leading-none mt-auto">
                                <?php echo esc_html($card['highlight_value']); ?>
                                <span class="text-[10px] lg:text-[12px] font-medium text-muted ml-0.5 block lg:inline font-sans">
                                    <?php echo esc_html($card['highlight_unit']); ?>
                                </span>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php endforeach; ?>
        </div>

        <!-- Full Property Table -->
        <div class="table-area <?php echo $hide_table_mobile ? 'hidden md:block' : ''; ?>">
            <h3 class="text-[10px] font-bold text-muted uppercase tracking-[2px] mb-4">Full Property Data</h3>
            <div class="border border-border rounded-card overflow-hidden shadow-sm <?php echo $table_scrollable ? 'overflow-x-auto' : ''; ?>">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-bg-subtle border-b border-border text-[11px] font-bold text-heading uppercase">
                            <th class="px-5 lg:px-8 py-3.5 whitespace-nowrap">Measurement</th>
                            <th class="px-5 lg:px-8 py-3.5 whitespace-nowrap">Value</th>
                            <th class="px-5 lg:px-8 py-3.5 hidden md:table-cell whitespace-nowrap">Standard</th>
                        </tr>
                    </thead>
                    <?php foreach ($tabs as $tab): 
                        $key = $tab['tab_key'] ?: sanitize_title($tab['tab_title']);
                        $rows = $tab['tab_table_rows'] ?: [];
                    ?>
                        <tbody x-show="activeTab === '<?php echo esc_attr($key); ?>'" class="text-[13px] lg:text-[14px]">
                            <?php foreach ($rows as $row): ?>
                                <tr class="border-b border-border/50 hover:bg-bg-subtle/50 transition-colors last:border-0">
                                    <td class="px-5 lg:px-8 py-3 font-semibold text-heading">
                                        <?php echo esc_html($row['row_label']); ?>
                                    </td>
                                    <td class="px-5 lg:px-8 py-3 <?php echo $use_mono ? 'font-mono' : ''; ?> text-primary font-bold">
                                        <?php echo esc_html($row['row_value']); ?>
                                    </td>
                                    <td class="px-5 lg:px-8 py-3 text-muted hidden md:table-cell">
                                        <?php echo esc_html($row['row_standard']); ?>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    <?php endforeach; ?>
                </table>
            </div>
        </div>

    </div>
</section>
