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
$title          = get_field_value( 'title', $block, $clone_name, $pfx, 'Technical Specifications' );
$material_label = get_field_value( 'material_label', $block, $clone_name, $pfx );
$specs_groups   = get_field_value( 'specs_groups', $block, $clone_name, $pfx ); // Repeater

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
		$tabs[] = array(
			'id'    => 'tab-' . $index,
			'label' => $group['category'],
			'data'  => $group['specs'],
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
	<div class="max-w-container mx-auto px-5 lg:px-8">
		
		<!-- Header -->
		<div class="mb-10 lg:mb-12 border-b border-border pb-6 flex flex-col lg:flex-row lg:items-end justify-between gap-6">
			<div>
				<h2 class="text-3xl lg:text-4xl font-bold text-heading mb-3 tracking-tight">
					<?php echo esc_html( $title ); ?>: 
					<?php if ( $material_label ) : ?>
						<span class="text-primary"><?php echo esc_html( $material_label ); ?></span>
					<?php endif; ?>
				</h2>
				<p class="text-body/70">Standardized testing data (ISO/ASTM)</p>
			</div>

			<!-- Tab Nav -->
			<?php if ( count( $tabs ) > 1 ) : ?>
				<div class="flex flex-wrap gap-2">
					<?php foreach ( $tabs as $tab ) : ?>
						<button 
							@click="activeTab = '<?php echo esc_attr( $tab['id'] ); ?>'"
							:class="activeTab === '<?php echo esc_attr( $tab['id'] ); ?>' ? 'bg-primary text-white border-primary' : 'bg-white text-body border-border hover:border-primary'"
							class="px-5 py-2.5 rounded-lg text-sm font-bold border-[3px] transition-all"
						>
							<?php echo esc_html( $tab['label'] ); ?>
						</button>
					<?php endforeach; ?>
				</div>
			<?php endif; ?>
		</div>

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
					<div class="grid grid-cols-1 md:grid-cols-2 gap-x-12 gap-y-0">
						<?php if ( ! empty( $tab['data'] ) ) : ?>
							<?php foreach ( $tab['data'] as $spec ) : ?>
								<div class="flex items-center justify-between py-4 border-b border-border hover:bg-gray-50 transition-colors px-2">
									<span class="text-body font-medium"><?php echo esc_html( $spec['label'] ); ?></span>
									<div class="text-right">
										<span class="text-heading font-bold font-mono text-lg"><?php echo esc_html( $spec['value'] ); ?></span>
										<?php if ( ! empty( $spec['unit'] ) ) : ?>
											<span class="text-sm text-body/60 ml-1"><?php echo esc_html( $spec['unit'] ); ?></span>
										<?php endif; ?>
									</div>
								</div>
							<?php endforeach; ?>
						<?php endif; ?>
					</div>
				</div>
			<?php endforeach; ?>
		</div>

	</div>
</section>
