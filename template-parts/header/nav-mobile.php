<?php
/**
 * Template part for displaying the mobile navigation (drawer).
 *
 * @package GeneratePress
 */

// Fetch ACF Data
$header_capabilities_parent_link = function_exists( 'get_field' ) ? get_field( 'header_capabilities_link', 'option' ) : null;
$header_materials_parent_link = function_exists( 'get_field' ) ? get_field( 'header_materials_link', 'option' ) : null;
$header_industry_parent_link = function_exists( 'get_field' ) ? get_field( 'header_industry_link', 'option' ) : null;
$header_resources_parent_link = function_exists( 'get_field' ) ? get_field( 'header_resources_link', 'option' ) : null;

$header_capabilities = function_exists( 'get_field' ) ? get_field( 'header_capabilities_items', 'option' ) : null;
$header_material_columns = function_exists( 'get_field' ) ? get_field( 'header_material_columns', 'option' ) : null;
$header_industry_items = function_exists( 'get_field' ) ? get_field( 'header_industry_items', 'option' ) : null;
$header_resources_items = function_exists( 'get_field' ) ? get_field( 'header_resources_items', 'option' ) : null;
$header_company_items = function_exists( 'get_field' ) ? get_field( 'header_company_items', 'option' ) : null;
$header_cta = function_exists( 'get_field' ) ? get_field( 'header_brand_global', 'option' )['cta_button'] ?? null : null;

?>

<!-- 4. Mobile Menu Toggle (Hamburger) -->
<button type="button" class="lg:hidden bg-transparent border-none p-0 focus:outline-none" @click="mobileOpen = ! mobileOpen; if (mobileOpen) { mobilePanel = 'root' }" aria-label="Toggle navigation">
	<svg class="h-6 w-6 text-heading" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
		<path x-show="!mobileOpen" d="M4 6h16M4 12h16M4 18h16" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
		<path x-show="mobileOpen" x-cloak d="M6 18L18 6M6 6l12 12" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
	</svg>
</button>

<!-- ==========================================================================
		IV. 移动端菜单 (Mobile Menu Drawer)
		========================================================================== -->
<div x-show="mobileOpen" x-cloak
		x-transition:enter="transition ease-out duration-200"
		x-transition:enter-start="opacity-0 -translate-y-2"
		x-transition:enter-end="opacity-100 translate-y-0"
		x-transition:leave="transition ease-in duration-150"
		x-transition:leave-start="opacity-100 translate-y-0"
		x-transition:leave-end="opacity-0 -translate-y-2"
		class="absolute top-full left-0 w-full bg-white border-t border-border shadow-[0_10px_30px_-25px_rgba(29,41,56,0.55)] lg:hidden max-h-[calc(100vh-80px)] overflow-y-auto"
		x-effect="if (!mobileOpen) { mobilePanel = 'root' }">
	<div class="px-container py-5">
		<?php
		$cap_parent_url    = is_array( $header_capabilities_parent_link ) && ! empty( $header_capabilities_parent_link['url'] ) ? (string) $header_capabilities_parent_link['url'] : '';
		$cap_parent_target = is_array( $header_capabilities_parent_link ) && ! empty( $header_capabilities_parent_link['target'] ) ? (string) $header_capabilities_parent_link['target'] : '_self';

		$mat_parent_url    = is_array( $header_materials_parent_link ) && ! empty( $header_materials_parent_link['url'] ) ? (string) $header_materials_parent_link['url'] : '';
		$mat_parent_target = is_array( $header_materials_parent_link ) && ! empty( $header_materials_parent_link['target'] ) ? (string) $header_materials_parent_link['target'] : '_self';

		$ind_parent_url    = is_array( $header_industry_parent_link ) && ! empty( $header_industry_parent_link['url'] ) ? (string) $header_industry_parent_link['url'] : '';
		$ind_parent_target = is_array( $header_industry_parent_link ) && ! empty( $header_industry_parent_link['target'] ) ? (string) $header_industry_parent_link['target'] : '_self';

		$res_parent_url    = is_array( $header_resources_parent_link ) && ! empty( $header_resources_parent_link['url'] ) ? (string) $header_resources_parent_link['url'] : '';
		$res_parent_target = is_array( $header_resources_parent_link ) && ! empty( $header_resources_parent_link['target'] ) ? (string) $header_resources_parent_link['target'] : '_self';
		?>

		<div x-show="mobilePanel === 'root'" class="space-y-3">
			<div class="rounded-card border border-border overflow-hidden">
				<div class="divide-y divide-border">
					<div class="flex items-center">
						<?php if ( $cap_parent_url ) : ?>
							<a href="<?php echo esc_url( $cap_parent_url ); ?>" target="<?php echo esc_attr( $cap_parent_target ); ?>" @click="mobileOpen = false; mobilePanel = 'root'" class="flex-1 px-4 py-4 text-[14px] font-semibold text-heading hover:text-primary transition-colors">Capabilities</a>
						<?php else : ?>
							<button type="button" class="flex-1 px-4 py-4 text-left text-[14px] font-semibold text-heading" @click="mobilePanel = 'capabilities'">Capabilities</button>
						<?php endif; ?>
						<?php if ( ! empty( $header_capabilities ) && is_array( $header_capabilities ) ) : ?>
							<button type="button" class="px-4 py-4 text-muted hover:text-primary transition-colors" @click="mobilePanel = 'capabilities'" aria-label="Open Capabilities">
								<svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
									<path d="M9 5l7 7-7 7" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"></path>
								</svg>
							</button>
						<?php endif; ?>
					</div>

					<div class="flex items-center">
						<?php if ( $mat_parent_url ) : ?>
							<a href="<?php echo esc_url( $mat_parent_url ); ?>" target="<?php echo esc_attr( $mat_parent_target ); ?>" @click="mobileOpen = false; mobilePanel = 'root'" class="flex-1 px-4 py-4 text-[14px] font-semibold text-heading hover:text-primary transition-colors">Materials</a>
						<?php else : ?>
							<button type="button" class="flex-1 px-4 py-4 text-left text-[14px] font-semibold text-heading" @click="mobilePanel = 'materials'">Materials</button>
						<?php endif; ?>
						<?php if ( ! empty( $header_material_columns ) && is_array( $header_material_columns ) ) : ?>
							<button type="button" class="px-4 py-4 text-muted hover:text-primary transition-colors" @click="mobilePanel = 'materials'" aria-label="Open Materials">
								<svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
									<path d="M9 5l7 7-7 7" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"></path>
								</svg>
							</button>
						<?php endif; ?>
					</div>

					<div class="flex items-center">
						<?php if ( $ind_parent_url ) : ?>
							<a href="<?php echo esc_url( $ind_parent_url ); ?>" target="<?php echo esc_attr( $ind_parent_target ); ?>" @click="mobileOpen = false; mobilePanel = 'root'" class="flex-1 px-4 py-4 text-[14px] font-semibold text-heading hover:text-primary transition-colors">Industry</a>
						<?php else : ?>
							<button type="button" class="flex-1 px-4 py-4 text-left text-[14px] font-semibold text-heading" @click="mobilePanel = 'industry'">Industry</button>
						<?php endif; ?>
						<?php if ( ! empty( $header_industry_items ) && is_array( $header_industry_items ) ) : ?>
							<button type="button" class="px-4 py-4 text-muted hover:text-primary transition-colors" @click="mobilePanel = 'industry'" aria-label="Open Industry">
								<svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
									<path d="M9 5l7 7-7 7" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"></path>
								</svg>
							</button>
						<?php endif; ?>
					</div>

					<div class="flex items-center">
						<?php if ( $res_parent_url ) : ?>
							<a href="<?php echo esc_url( $res_parent_url ); ?>" target="<?php echo esc_attr( $res_parent_target ); ?>" @click="mobileOpen = false; mobilePanel = 'root'" class="flex-1 px-4 py-4 text-[14px] font-semibold text-heading hover:text-primary transition-colors">Resources</a>
						<?php else : ?>
							<button type="button" class="flex-1 px-4 py-4 text-left text-[14px] font-semibold text-heading" @click="mobilePanel = 'resources'">Resources</button>
						<?php endif; ?>
						<?php if ( ! empty( $header_resources_items ) && is_array( $header_resources_items ) ) : ?>
							<button type="button" class="px-4 py-4 text-muted hover:text-primary transition-colors" @click="mobilePanel = 'resources'" aria-label="Open Resources">
								<svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
									<path d="M9 5l7 7-7 7" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"></path>
								</svg>
							</button>
						<?php endif; ?>
					</div>

					<div class="flex items-center">
						<button type="button" class="flex-1 px-4 py-4 text-left text-[14px] font-semibold text-heading" @click="mobilePanel = 'company'">Company</button>
						<?php if ( ! empty( $header_company_items ) && is_array( $header_company_items ) ) : ?>
							<button type="button" class="px-4 py-4 text-muted hover:text-primary transition-colors" @click="mobilePanel = 'company'" aria-label="Open Company">
								<svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
									<path d="M9 5l7 7-7 7" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"></path>
								</svg>
							</button>
						<?php endif; ?>
					</div>
				</div>
			</div>

			<?php if ( is_array( $header_cta ) && ! empty( $header_cta['url'] ) ) : ?>
				<?php
				$cta_url = $header_cta['url'];
				$cta_title = isset( $header_cta['title'] ) ? esc_html( $header_cta['title'] ) : '';
				?>
				<a href="<?php echo esc_url( $cta_url ); ?>" @click="mobileOpen = false; mobilePanel = 'root'" class="flex w-full items-center justify-center gap-2 rounded-button bg-primary px-6 py-3 text-[13px] font-bold text-white border border-border transition hover:bg-primary-hover">
					<span><?php echo $cta_title ? $cta_title : 'Get Instant Quote'; ?></span>
				</a>
			<?php endif; ?>
		</div>

		<div x-show="mobilePanel === 'capabilities'" x-cloak class="space-y-3">
			<div class="flex items-center justify-between">
				<button type="button" class="inline-flex items-center gap-2 text-[13px] font-semibold text-heading" @click="mobilePanel = 'root'">
					<svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
						<path d="M15 19l-7-7 7-7" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"></path>
					</svg>
					<span>Menu</span>
				</button>
				<?php if ( $cap_parent_url ) : ?>
					<a href="<?php echo esc_url( $cap_parent_url ); ?>" target="<?php echo esc_attr( $cap_parent_target ); ?>" @click="mobileOpen = false; mobilePanel = 'root'" class="text-[12px] font-bold text-primary">View All Capabilities</a>
				<?php endif; ?>
			</div>

			<?php if ( ! empty( $header_capabilities ) && is_array( $header_capabilities ) ) : ?>
				<div class="grid grid-cols-2 gap-2">
					<?php foreach ( $header_capabilities as $item ) : ?>
						<?php
						$tech_name = isset( $item['tech_name'] ) ? $item['tech_name'] : '';
						$link = isset( $item['link'] ) ? $item['link'] : null;
						$link_url = is_array( $link ) && ! empty( $link['url'] ) ? $link['url'] : '#';
						$link_target = is_array( $link ) && ! empty( $link['target'] ) ? $link['target'] : '_self';
						?>
						<a href="<?php echo esc_url( $link_url ); ?>" target="<?php echo esc_attr( $link_target ); ?>" @click="mobileOpen = false; mobilePanel = 'root'" class="rounded-button border border-border bg-white px-3 py-2 text-[13px] font-semibold text-heading hover:border-primary transition-colors">
							<?php echo esc_html( $tech_name ); ?>
						</a>
					<?php endforeach; ?>
				</div>
			<?php endif; ?>
		</div>

		<div x-show="mobilePanel === 'materials'" x-cloak class="space-y-4">
			<div class="flex items-center justify-between">
				<button type="button" class="inline-flex items-center gap-2 text-[13px] font-semibold text-heading" @click="mobilePanel = 'root'">
					<svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
						<path d="M15 19l-7-7 7-7" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"></path>
					</svg>
					<span>Menu</span>
				</button>
				<?php if ( $mat_parent_url ) : ?>
					<a href="<?php echo esc_url( $mat_parent_url ); ?>" target="<?php echo esc_attr( $mat_parent_target ); ?>" @click="mobileOpen = false; mobilePanel = 'root'" class="text-[12px] font-bold text-primary">View All Materials</a>
				<?php endif; ?>
			</div>

			<?php if ( ! empty( $header_material_columns ) && is_array( $header_material_columns ) ) : ?>
				<?php foreach ( $header_material_columns as $column ) : ?>
					<?php
					$column_title = isset( $column['title'] ) ? $column['title'] : '';
					$links = isset( $column['links'] ) ? $column['links'] : null;
					?>
					<div class="space-y-2">
						<?php if ( $column_title ) : ?>
							<div class="text-[11px] font-bold text-muted tracking-wide"><?php echo esc_html( $column_title ); ?></div>
						<?php endif; ?>
						<?php if ( ! empty( $links ) && is_array( $links ) ) : ?>
							<div class="grid grid-cols-2 gap-2">
								<?php foreach ( $links as $link_item ) : ?>
									<?php
									$material_id = isset( $link_item['material_id'] ) ? $link_item['material_id'] : null;
									$label = ! empty( $link_item['label'] ) ? $link_item['label'] : ( $material_id ? get_the_title( $material_id ) : '' );
									$url = $material_id ? get_permalink( $material_id ) : '';
									?>
									<?php if ( $url ) : ?>
										<a href="<?php echo esc_url( $url ); ?>" @click="mobileOpen = false; mobilePanel = 'root'" class="rounded-button border border-border bg-white px-3 py-2 text-[13px] font-semibold text-heading hover:border-primary transition-colors">
											<?php echo esc_html( $label ); ?>
										</a>
									<?php else : ?>
										<span class="rounded-button border border-border bg-white px-3 py-2 text-[13px] font-semibold text-heading">
											<?php echo esc_html( $label ); ?>
										</span>
									<?php endif; ?>
								<?php endforeach; ?>
							</div>
						<?php endif; ?>
					</div>
				<?php endforeach; ?>
			<?php endif; ?>
		</div>

		<div x-show="mobilePanel === 'industry'" x-cloak class="space-y-3">
			<div class="flex items-center justify-between">
				<button type="button" class="inline-flex items-center gap-2 text-[13px] font-semibold text-heading" @click="mobilePanel = 'root'">
					<svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
						<path d="M15 19l-7-7 7-7" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"></path>
					</svg>
					<span>Menu</span>
				</button>
				<?php if ( $ind_parent_url ) : ?>
					<a href="<?php echo esc_url( $ind_parent_url ); ?>" target="<?php echo esc_attr( $ind_parent_target ); ?>" @click="mobileOpen = false; mobilePanel = 'root'" class="text-[12px] font-bold text-primary">All Industry</a>
				<?php endif; ?>
			</div>

			<?php if ( ! empty( $header_industry_items ) && is_array( $header_industry_items ) ) : ?>
				<div class="rounded-card border border-border overflow-hidden divide-y divide-border">
					<?php foreach ( $header_industry_items as $item ) : ?>
						<?php
						$title = isset( $item['title'] ) ? $item['title'] : '';
						$link = isset( $item['link'] ) ? $item['link'] : null;
						$link_url = is_array( $link ) && ! empty( $link['url'] ) ? $link['url'] : '#';
						$target = is_array( $link ) && ! empty( $link['target'] ) ? $link['target'] : '_self';
						?>
						<a href="<?php echo esc_url( $link_url ); ?>" target="<?php echo esc_attr( $target ); ?>" @click="mobileOpen = false; mobilePanel = 'root'" class="block px-4 py-3 text-[13px] font-semibold text-heading hover:text-primary transition-colors">
							<?php echo esc_html( $title ); ?>
						</a>
					<?php endforeach; ?>
				</div>
			<?php endif; ?>
		</div>

		<div x-show="mobilePanel === 'resources'" x-cloak class="space-y-3">
			<div class="flex items-center justify-between">
				<button type="button" class="inline-flex items-center gap-2 text-[13px] font-semibold text-heading" @click="mobilePanel = 'root'">
					<svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
						<path d="M15 19l-7-7 7-7" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"></path>
					</svg>
					<span>Menu</span>
				</button>
				<?php if ( $res_parent_url ) : ?>
					<a href="<?php echo esc_url( $res_parent_url ); ?>" target="<?php echo esc_attr( $res_parent_target ); ?>" @click="mobileOpen = false; mobilePanel = 'root'" class="text-[12px] font-bold text-primary">All Resources</a>
				<?php endif; ?>
			</div>

			<?php if ( ! empty( $header_resources_items ) && is_array( $header_resources_items ) ) : ?>
				<div class="rounded-card border border-border overflow-hidden divide-y divide-border">
					<?php foreach ( $header_resources_items as $item ) : ?>
						<?php
						$title = isset( $item['title'] ) ? $item['title'] : '';
						$link = isset( $item['link'] ) ? $item['link'] : null;
						$link_url = is_array( $link ) && ! empty( $link['url'] ) ? $link['url'] : '#';
						$target = is_array( $link ) && ! empty( $link['target'] ) ? $link['target'] : '_self';
						?>
						<a href="<?php echo esc_url( $link_url ); ?>" target="<?php echo esc_attr( $target ); ?>" @click="mobileOpen = false; mobilePanel = 'root'" class="block px-4 py-3 text-[13px] font-semibold text-heading hover:text-primary transition-colors">
							<?php echo esc_html( $title ); ?>
						</a>
					<?php endforeach; ?>
				</div>
			<?php endif; ?>
		</div>

		<div x-show="mobilePanel === 'company'" x-cloak class="space-y-3">
			<div class="flex items-center justify-between">
				<button type="button" class="inline-flex items-center gap-2 text-[13px] font-semibold text-heading" @click="mobilePanel = 'root'">
					<svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
						<path d="M15 19l-7-7 7-7" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"></path>
					</svg>
					<span>Menu</span>
				</button>
			</div>

			<?php if ( ! empty( $header_company_items ) && is_array( $header_company_items ) ) : ?>
				<div class="rounded-card border border-border overflow-hidden divide-y divide-border">
					<?php foreach ( $header_company_items as $item ) : ?>
						<?php
						$title = isset( $item['title'] ) ? $item['title'] : '';
						$link = isset( $item['link'] ) ? $item['link'] : null;
						$link_url = is_array( $link ) && ! empty( $link['url'] ) ? $link['url'] : '#';
						$link_target = is_array( $link ) && ! empty( $link['target'] ) ? $link['target'] : '_self';
						?>
						<a href="<?php echo esc_url( $link_url ); ?>" target="<?php echo esc_attr( $link_target ); ?>" @click="mobileOpen = false; mobilePanel = 'root'" class="block px-4 py-3 text-[13px] font-semibold text-heading hover:text-primary transition-colors">
							<?php echo esc_html( $title ); ?>
						</a>
					<?php endforeach; ?>
				</div>
			<?php endif; ?>
		</div>
	</div>
</div>
