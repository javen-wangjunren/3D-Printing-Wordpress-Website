<?php
/**
 * Technical Specs Block Template
 *
 * @package 3D_Printing
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// Prefix Support
$pfx = isset($block['prefix']) ? $block['prefix'] : '';
$block = isset( $block ) ? $block : array();
$clone_name = rtrim($pfx, '_');

// 1. Data Scope
$title          = get_field_value( 'technical_specs_title', $block, $clone_name, $pfx, 'Technical Specifications' );
$material_label = get_field_value( 'technical_specs_material_label', $block, $clone_name, $pfx );
$intro          = get_field_value( 'technical_specs_intro', $block, $clone_name, $pfx );
$specs_groups   = get_field_value( 'technical_specs_tabs', $block, $clone_name, $pfx ); // Repeater

// 2. Visual Mapping
$bg_color = get_field_value( 'background_color', $block, $clone_name, $pfx, '#ffffff' );

// Dynamic Spacing Logic
$prev_bg  = isset( $GLOBALS['3dp_last_bg'] ) ? $GLOBALS['3dp_last_bg'] : '';
$section_spacing = ( $bg_color === $prev_bg ) ? 'pt-0 pb-16 lg:pb-24' : 'py-16 lg:py-24';

// Update Global State
$GLOBALS['3dp_last_bg'] = $bg_color;

$block_id = 'tech-specs-' . $block['id'];
if ( ! empty( $block['anchor'] ) ) {
	$block_id = $block['anchor'];
}

// Prepare Tabs Data
$tabs = array();
if ( $specs_groups ) {
	foreach ( $specs_groups as $index => $group ) {
        // Process Table Rows
        $rows = isset($group['tab_table_rows']) ? $group['tab_table_rows'] : array();
        $mapped_rows = array();
        
        if ( is_array($rows) ) {
            foreach ( $rows as $r ) {
                if ( empty( $r['row_label'] ) && empty( $r['row_value'] ) ) {
                    continue;
                }
                $mapped_rows[] = array(
                    'label' => isset($r['row_label']) ? $r['row_label'] : '',
                    'value' => isset($r['row_value']) ? $r['row_value'] : '',
                    'unit'  => isset($r['row_standard']) ? $r['row_standard'] : '', // Using standard as unit/context
                );
            }
        }

        // Process Highlight Cards
        $highlights = isset($group['tab_highlights']) ? $group['tab_highlights'] : array();
        $mapped_highlights = array();
        if ( is_array($highlights) ) {
            foreach ( $highlights as $h ) {
                $mapped_highlights[] = array(
                    'title' => isset($h['highlight_title']) ? $h['highlight_title'] : '',
                    'value' => isset($h['highlight_value']) ? $h['highlight_value'] : '',
                    'unit'  => isset($h['highlight_unit']) ? $h['highlight_unit'] : '',
                );
            }
        }

		$tabs[] = array(
			'id'         => 'tab-' . $index,
			'label'      => isset($group['tab_title']) ? $group['tab_title'] : '',
            'tag'        => isset($group['tab_tag']) ? $group['tab_tag'] : '',
            'highlights' => $mapped_highlights,
			'data'       => $mapped_rows,
		);
	}
}

$first_tab_key = ! empty( $tabs ) ? $tabs[0]['id'] : '';
?>

<section 
	id="<?php echo esc_attr( $block_id ); ?>" 
	class="w-full <?php echo esc_attr( $section_spacing ); ?>"
	style="background-color: <?php echo esc_attr($bg_color); ?>;"
	x-data="{ activeTab: '<?php echo esc_attr( $first_tab_key ); ?>' }"
>
	<div class="max-w-[1280px] mx-auto px-5 lg:px-8">
		
		<!-- Header -->
		<header class="mb-6 lg:mb-8">
			<h2 class="text-[26px] lg:text-[36px] font-bold text-heading mb-3 tracking-tight">
				<?php echo esc_html( $title ); ?>: 
				<?php if ( $material_label ) : ?>
					<span class="text-primary"><?php echo esc_html( $material_label ); ?></span>
				<?php endif; ?>
			</h2>
			<p class="text-[14px] lg:text-[15px] max-w-2xl leading-relaxed opacity-90"><?php echo $intro ? esc_html($intro) : 'Standardized testing data (ISO/ASTM)'; ?></p>
		</header>

        <!-- Tab Nav -->
        <?php if ( count( $tabs ) > 1 ) : ?>
            <div class="flex flex-nowrap gap-1 border-b border-border mb-6 lg:mb-8 overflow-x-auto no-scrollbar">
                <?php foreach ( $tabs as $tab ) : ?>
                    <button 
                        @click="activeTab = '<?php echo esc_attr( $tab['id'] ); ?>'"
                        :class="activeTab === '<?php echo esc_attr( $tab['id'] ); ?>' ? 'active text-primary' : 'text-gray-500 hover:text-primary'"
                        class="whitespace-nowrap px-4 py-3 text-[13px] font-bold transition-colors bg-transparent appearance-none focus:outline-none"
                    >
                        <?php echo esc_html( $tab['label'] ); ?>
                    </button>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>

		<!-- Content -->
		<div class="relative min-h-[400px]">
			<?php foreach ( $tabs as $tab ) : ?>
				<div 
					x-show="activeTab === '<?php echo esc_attr( $tab['id'] ); ?>'"
					x-transition:enter="transition ease-out duration-300"
					x-transition:enter-start="opacity-0 translate-y-4"
					x-transition:enter-end="opacity-100 translate-y-0"
					class="w-full"
				>
                    <!-- Highlight Cards -->
                    <?php if ( ! empty( $tab['highlights'] ) ) : ?>
                        <div class="flex overflow-x-auto gap-4 lg:grid lg:grid-cols-3 lg:gap-5 mb-8 lg:mb-12 pb-4 lg:pb-0 snap-x snap-mandatory no-scrollbar">
                            <?php foreach ( $tab['highlights'] as $card ) : ?>
                                <div class="snap-start flex-none w-[40%] lg:w-auto p-4 lg:p-8 border border-border rounded-card bg-white hover:border-primary/50 transition-all flex flex-col justify-between h-full">
                                    <span class="text-[8px] lg:text-[9px] font-bold text-primary uppercase tracking-widest opacity-80 truncate w-full block mb-2"><?php echo esc_html( $tab['tag'] ?: $tab['label'] ); ?></span>
                                    <h3 class="text-[11px] lg:text-[17px] font-bold text-heading mt-1 mb-1 lg:mb-3 leading-tight h-[2.5em] lg:h-auto overflow-hidden text-ellipsis line-clamp-2"><?php echo esc_html( $card['title'] ); ?></h3>
                                    <div class="font-mono text-[16px] lg:text-[32px] font-bold text-heading leading-none mt-auto">
                                        <?php echo esc_html( $card['value'] ); ?><span class="text-[10px] lg:text-[12px] font-normal text-heading ml-0.5 block lg:inline"><?php echo esc_html( $card['unit'] ); ?></span>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    <?php endif; ?>

                    <!-- Full Property Data Table -->
                    <?php if ( ! empty( $tab['data'] ) ) : ?>
                        <div class="table-area">
                            <h3 class="text-[10px] font-bold text-body/60 uppercase tracking-[2px] mb-4">Full Property Data</h3>
                            <div class="border border-border rounded-card overflow-hidden shadow-sm bg-white">
                                <table class="w-full text-left border-collapse mb-0">
                                    <thead>
                                        <tr class="bg-gray-50 border-b border-border text-[11px] font-bold text-heading uppercase">
                                            <th class="px-5 lg:px-8 py-3.5">Measurement</th>
                                            <th class="px-5 lg:px-8 py-3.5">Value</th>
                                            <th class="px-5 lg:px-8 py-3.5 hidden md:table-cell">Standard</th>
                                        </tr>
                                    </thead>
                                    <tbody class="text-[13px] lg:text-[14px]">
                                        <?php foreach ( $tab['data'] as $spec ) : ?>
                                            <tr class="border-b border-border/50 hover:bg-gray-50/50 transition-colors last:border-0">
                                                <td class="px-5 lg:px-8 py-3 font-semibold text-heading"><?php echo esc_html( $spec['label'] ); ?></td>
                                                <td class="px-5 lg:px-8 py-3 font-mono text-primary font-bold"><?php echo esc_html( $spec['value'] ); ?></td>
                                                <td class="px-5 lg:px-8 py-3 text-body/70 hidden md:table-cell"><?php echo esc_html( $spec['unit'] ); ?></td>
                                            </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
					<?php endif; ?>
				</div>
			<?php endforeach; ?>
		</div>

	</div>
</section>
