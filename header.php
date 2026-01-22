<?php
/**
 * The template for displaying the header.
 *
 * @package GeneratePress
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

?><!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	
	<!-- Preconnect & Preload -->
	<link rel="preconnect" href="https://fonts.googleapis.com">
	<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
	<!-- Future CDN: <link rel="preconnect" href="https://cdn.yourdomain.com"> -->

	<?php wp_head(); ?>
</head>

<body <?php body_class(); ?> <?php generate_do_microdata( 'body' ); ?>>
	<?php
	do_action( 'wp_body_open' );

	// Fetch ACF Data
	$header_brand = function_exists( 'get_field' ) ? get_field( 'header_brand_global', 'option' ) : null;
	$header_logo_id = is_array( $header_brand ) && isset( $header_brand['logo_image'] ) ? (int) $header_brand['logo_image'] : 0;
	$header_logo_width = is_array( $header_brand ) && isset( $header_brand['logo_width'] ) ? (int) $header_brand['logo_width'] : 0;
	$header_logo_width_mobile = is_array( $header_brand ) && isset( $header_brand['logo_width_mobile'] ) ? (int) $header_brand['logo_width_mobile'] : 0;
	$header_cta = is_array( $header_brand ) && isset( $header_brand['cta_button'] ) ? $header_brand['cta_button'] : null;
	
	$header_capabilities = function_exists( 'get_field' ) ? get_field( 'header_capabilities_items', 'option' ) : null;
	$header_material_columns = function_exists( 'get_field' ) ? get_field( 'header_material_columns', 'option' ) : null;
	$header_company_items = function_exists( 'get_field' ) ? get_field( 'header_company_items', 'option' ) : null;
	?>

	<!-- Responsive Logo Styles -->
	<?php if ( $header_logo_width > 0 || $header_logo_width_mobile > 0 ) : ?>
		<style>
			.site-logo-img {
				width: <?php echo $header_logo_width_mobile > 0 ? $header_logo_width_mobile : 'auto'; ?>px;
				height: auto;
				max-width: 100%; /* Prevent overflow on small screens */
			}
			@media (min-width: 1024px) {
				.site-logo-img {
					width: <?php echo $header_logo_width > 0 ? $header_logo_width : 'auto'; ?>px;
				}
			}
		</style>
	<?php endif; ?>

	<header x-data="{ openMenu: null, mobileOpen: false }" @mouseleave="openMenu = null" class="relative z-40 bg-white border-b border-border">
		<div class="mx-auto max-w-container px-container">
			<div class="flex h-20 items-center justify-between">
				<!-- Logo -->
				<div class="flex items-center gap-4">
					<a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="flex items-center">
						<span class="inline-flex items-center">
							<?php if ( $header_logo_id ) : ?>
								<?php
									// 优化 Logo 加载：添加 lazy=eager 确保 LCP 性能
									$logo_attrs = array(
										'class' => 'block site-logo-img',
										'loading' => 'eager', // 关键优化：首屏资源禁止懒加载
									);
									echo wp_get_attachment_image( $header_logo_id, 'full', false, $logo_attrs );
								?>
							<?php else : ?>
								<span class="inline-flex items-center justify-center rounded-lg bg-primary px-2 py-1 text-xs font-mono font-semibold text-white">LOGO</span>
							<?php endif; ?>
						</span>
					</a>
				</div>

				<!-- Desktop Navigation -->
				<nav class="hidden items-center gap-10 lg:flex">
					<!-- Capabilities Dropdown -->
					<div class="relative group" @mouseenter="openMenu = 'capabilities'">
						<button type="button" class="bg-transparent border-none relative flex items-center gap-1 py-2 text-sm font-semibold tracking-[-0.01em] text-heading hover:text-primary" :class="{ 'text-primary': openMenu === 'capabilities' }">
							<span>Capabilities</span>
							<svg class="h-4 w-4 opacity-50 transition-transform duration-200" :class="{ 'rotate-180': openMenu === 'capabilities' }" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
								<path d="M19 9l-7 7-7-7" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
							</svg>
							<span class="absolute bottom-0 left-0 h-0.5 bg-primary transition-all duration-200" :class="openMenu === 'capabilities' ? 'w-full' : 'w-0'"></span>
						</button>
					</div>

					<!-- Materials Dropdown -->
					<div class="relative group" @mouseenter="openMenu = 'materials'">
						<button type="button" class="bg-transparent border-none relative flex items-center gap-1 py-2 text-sm font-semibold tracking-[-0.01em] text-heading hover:text-primary" :class="{ 'text-primary': openMenu === 'materials' }">
							<span>Materials</span>
							<svg class="h-4 w-4 opacity-50 transition-transform duration-200" :class="{ 'rotate-180': openMenu === 'materials' }" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
								<path d="M19 9l-7 7-7-7" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
							</svg>
							<span class="absolute bottom-0 left-0 h-0.5 bg-primary transition-all duration-200" :class="openMenu === 'materials' ? 'w-full' : 'w-0'"></span>
						</button>
					</div>

					<!-- Blog Link (Direct) -->
					<a href="<?php echo esc_url( home_url( '/blog' ) ); ?>" class="nav-link-hover relative text-sm font-semibold text-heading hover:text-primary">Blog</a>

					<!-- Company Dropdown -->
					<div class="relative group" @mouseenter="openMenu = 'company'">
						<button type="button" class="bg-transparent border-none relative flex items-center gap-1 py-2 text-sm font-semibold tracking-[-0.01em] text-heading hover:text-primary" :class="{ 'text-primary': openMenu === 'company' }">
							<span>Company</span>
							<svg class="h-4 w-4 opacity-50 transition-transform duration-200" :class="{ 'rotate-180': openMenu === 'company' }" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
								<path d="M19 9l-7 7-7-7" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
							</svg>
							<span class="absolute bottom-0 left-0 h-0.5 bg-primary transition-all duration-200" :class="openMenu === 'company' ? 'w-full' : 'w-0'"></span>
						</button>
					</div>
				</nav>

				<!-- Desktop CTA -->
				<div class="hidden lg:block">
					<?php if ( is_array( $header_cta ) && ! empty( $header_cta['url'] ) ) : ?>
						<?php
							$cta_url = $header_cta['url'];
							$cta_title = isset( $header_cta['title'] ) ? esc_html( $header_cta['title'] ) : '';
							$cta_target = isset( $header_cta['target'] ) && $header_cta['target'] ? esc_attr( $header_cta['target'] ) : '_self';
						?>
						<a href="<?php echo esc_url( $cta_url ); ?>" target="<?php echo $cta_target; ?>" class="inline-flex items-center gap-2 rounded-lg bg-primary px-6 py-3 text-sm font-bold text-white border border-[#E4E7EC] transition hover:bg-primary-hover">
							<span><?php echo $cta_title ? $cta_title : esc_html__( 'Get Instant Quote', 'generatepress' ); ?></span>
							<svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
								<path d="M17 8l4 4m0 0-4 4m4-4H3" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
							</svg>
						</a>
					<?php endif; ?>
				</div>

				<!-- Mobile Toggle -->
				<button type="button" class="lg:hidden bg-transparent border-none p-0 focus:outline-none" @click="mobileOpen = ! mobileOpen" aria-label="Toggle navigation">
					<svg class="h-6 w-6 text-heading" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
						<path x-show="!mobileOpen" d="M4 6h16M4 12h16M4 18h16" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
						<path x-show="mobileOpen" x-cloak d="M6 18L18 6M6 6l12 12" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
					</svg>
				</button>
			</div>
		</div>

		<!-- Mobile Menu Overlay -->
		<div x-show="mobileOpen" x-cloak
			 x-transition:enter="transition ease-out duration-200"
			 x-transition:enter-start="opacity-0 -translate-y-2"
			 x-transition:enter-end="opacity-100 translate-y-0"
			 x-transition:leave="transition ease-in duration-150"
			 x-transition:leave-start="opacity-100 translate-y-0"
			 x-transition:leave-end="opacity-0 -translate-y-2"
			 class="absolute top-full left-0 w-full bg-white border-t border-border lg:hidden max-h-[calc(100vh-80px)] overflow-y-auto">
			<div class="px-container py-6 space-y-6">
				<!-- Mobile: Capabilities -->
				<div>
					<h3 class="mb-3 text-xs font-semibold tracking-[-0.01em] text-muted">Capabilities</h3>
					<div class="grid gap-2">
						<?php if ( ! empty( $header_capabilities ) && is_array( $header_capabilities ) ) : ?>
							<?php foreach ( $header_capabilities as $item ) : ?>
								<?php
									$tech_name = isset( $item['tech_name'] ) ? $item['tech_name'] : '';
									$link = isset( $item['link'] ) ? $item['link'] : null;
									$link_url = is_array( $link ) && ! empty( $link['url'] ) ? $link['url'] : '#';
								?>
								<a href="<?php echo esc_url( $link_url ); ?>" class="block rounded-lg px-3 py-2 text-sm font-semibold text-heading hover:bg-gray-50 hover:text-primary">
									<?php echo esc_html( $tech_name ); ?>
								</a>
							<?php endforeach; ?>
						<?php endif; ?>
					</div>
				</div>

				<!-- Mobile: Materials -->
				<div>
					<h3 class="mb-3 text-xs font-semibold tracking-[-0.01em] text-muted">Materials</h3>
					<div class="space-y-4">
						<?php if ( ! empty( $header_material_columns ) && is_array( $header_material_columns ) ) : ?>
							<?php foreach ( $header_material_columns as $column ) : ?>
								<?php
									$column_title = isset( $column['title'] ) ? $column['title'] : '';
									$links = isset( $column['links'] ) ? $column['links'] : null;
								?>
								<div>
									<div class="mb-2 text-[11px] font-bold text-gray-400 pl-3"><?php echo esc_html( $column_title ); ?></div>
									<?php if ( ! empty( $links ) && is_array( $links ) ) : ?>
										<div class="grid gap-1 border-l-2 border-gray-100 ml-3 pl-3">
											<?php foreach ( $links as $link_item ) : ?>
												<?php
													$label = isset( $link_item['label'] ) ? $link_item['label'] : '';
													$url = isset( $link_item['url'] ) ? $link_item['url'] : '';
												?>
												<a href="<?php echo esc_url( $url ); ?>" class="block py-1 text-sm text-heading hover:text-primary"><?php echo esc_html( $label ); ?></a>
											<?php endforeach; ?>
										</div>
									<?php endif; ?>
								</div>
							<?php endforeach; ?>
						<?php endif; ?>
					</div>
				</div>

				<!-- Mobile: Company & Blog -->
				<div>
					<h3 class="mb-3 text-xs font-semibold tracking-[-0.01em] text-muted">Company</h3>
					<div class="grid gap-2">
						<a href="<?php echo esc_url( home_url( '/blog' ) ); ?>" class="block rounded-lg px-3 py-2 text-sm font-semibold text-heading hover:bg-gray-50 hover:text-primary">Blog</a>
						<?php if ( ! empty( $header_company_items ) && is_array( $header_company_items ) ) : ?>
							<?php foreach ( $header_company_items as $item ) : ?>
								<?php
									$title = isset( $item['title'] ) ? $item['title'] : '';
									$link = isset( $item['link'] ) ? $item['link'] : null;
									$link_url = is_array( $link ) && ! empty( $link['url'] ) ? $link['url'] : '#';
								?>
								<a href="<?php echo esc_url( $link_url ); ?>" class="block rounded-lg px-3 py-2 text-sm font-semibold text-heading hover:bg-gray-50 hover:text-primary"><?php echo esc_html( $title ); ?></a>
							<?php endforeach; ?>
						<?php endif; ?>
					</div>
				</div>

				<!-- Mobile: CTA -->
				<?php if ( is_array( $header_cta ) && ! empty( $header_cta['url'] ) ) : ?>
					<div class="pt-4 border-t border-gray-100">
						<?php
							$cta_url = $header_cta['url'];
							$cta_title = isset( $header_cta['title'] ) ? esc_html( $header_cta['title'] ) : '';
						?>
						<a href="<?php echo esc_url( $cta_url ); ?>" class="flex w-full items-center justify-center gap-2 rounded-lg bg-primary px-6 py-3 text-sm font-bold text-white transition hover:bg-primary-hover">
							<span><?php echo $cta_title ? $cta_title : esc_html__( 'Get Instant Quote', 'generatepress' ); ?></span>
						</a>
					</div>
				<?php endif; ?>
			</div>
		</div>

		<!-- Dropdown: Capabilities (Desktop) -->
		<?php if ( ! empty( $header_capabilities ) && is_array( $header_capabilities ) ) : ?>
			<div x-show="openMenu === 'capabilities'" x-cloak 
				 @mouseenter="openMenu = 'capabilities'" 
				 @mouseleave="openMenu = null"
				 x-transition:enter="transition ease-out duration-200" 
				 x-transition:enter-start="opacity-0 -translate-y-2" 
				 x-transition:enter-end="opacity-100 translate-y-0" 
				 x-transition:leave="transition ease-in duration-150" 
				 x-transition:leave-start="opacity-100 translate-y-0" 
				 x-transition:leave-end="opacity-0 -translate-y-2" 
				 class="absolute left-0 w-full bg-white border-b border-border z-50">
				<div class="mx-auto max-w-container px-container py-8 lg:py-10">
					<div class="grid gap-y-6 gap-x-12 lg:grid-cols-3">
						<?php foreach ( $header_capabilities as $item ) : ?>
							<?php
								$tech_name = isset( $item['tech_name'] ) ? $item['tech_name'] : '';
								$subtitle = isset( $item['subtitle'] ) ? $item['subtitle'] : '';
								$tag = isset( $item['tag'] ) ? $item['tag'] : '';
								$link = isset( $item['link'] ) ? $item['link'] : null;
								$link_url = is_array( $link ) && ! empty( $link['url'] ) ? $link['url'] : '#';
							?>
							<a href="<?php echo esc_url( $link_url ); ?>" class="group flex flex-col gap-1 rounded-xl p-4 transition duration-200 hover:bg-gray-50 border border-transparent hover:border-gray-100">
								<div class="flex items-center gap-3">
									<span class="text-sm font-bold text-heading group-hover:text-primary transition-colors"><?php echo esc_html( $tech_name ); ?></span>
								<?php if ( $tag ) : ?>
									<span class="rounded px-1.5 py-0.5 text-[10px] tracking-[-0.01em] font-semibold text-muted bg-gray-100 group-hover:bg-white group-hover:text-primary transition-all"><?php echo esc_html( $tag ); ?></span>
								<?php endif; ?>
								</div>
								<?php if ( $subtitle ) : ?>
									<span class="text-xs text-body/80 group-hover:text-body/100 transition-colors"><?php echo esc_html( $subtitle ); ?></span>
								<?php endif; ?>
							</a>
						<?php endforeach; ?>
					</div>
				</div>
			</div>
		<?php endif; ?>

		<!-- Dropdown: Materials (Desktop) -->
		<?php if ( ! empty( $header_material_columns ) && is_array( $header_material_columns ) ) : ?>
			<div x-show="openMenu === 'materials'" x-cloak 
				 @mouseenter="openMenu = 'materials'" 
				 @mouseleave="openMenu = null"
				 x-transition:enter="transition ease-out duration-200" 
				 x-transition:enter-start="opacity-0 -translate-y-2" 
				 x-transition:enter-end="opacity-100 translate-y-0" 
				 x-transition:leave="transition ease-in duration-150" 
				 x-transition:leave-start="opacity-100 translate-y-0" 
				 x-transition:leave-end="opacity-0 -translate-y-2" 
				 class="absolute left-0 w-full bg-white border-b border-border z-50">
				<div class="mx-auto max-w-container px-container py-8 lg:py-10">
					<div class="grid gap-8 lg:grid-cols-4">
						<?php foreach ( $header_material_columns as $column ) : ?>
							<?php
								$column_title = isset( $column['title'] ) ? $column['title'] : '';
								$links = isset( $column['links'] ) ? $column['links'] : null;
							?>
							<div>
								<?php if ( $column_title ) : ?>
									<h3 class="material-column-heading mb-4 text-[11px] font-semibold tracking-[-0.01em] text-muted border-b border-border pb-2"><?php echo esc_html( $column_title ); ?></h3>
								<?php endif; ?>
								<?php if ( ! empty( $links ) && is_array( $links ) ) : ?>
									<ul class="space-y-2 list-none m-0 p-0">
										<?php foreach ( $links as $link_item ) : ?>
											<?php
												$label = isset( $link_item['label'] ) ? $link_item['label'] : '';
												$url = isset( $link_item['url'] ) ? $link_item['url'] : '';
											?>
											<li>
												<?php if ( $url ) : ?>
													<a href="<?php echo esc_url( $url ); ?>" class="block py-1 text-sm text-heading hover:text-primary hover:translate-x-1 transition-transform duration-200"><?php echo esc_html( $label ); ?></a>
												<?php else : ?>
													<span class="text-sm text-heading"><?php echo esc_html( $label ); ?></span>
												<?php endif; ?>
											</li>
										<?php endforeach; ?>
									</ul>
								<?php endif; ?>
								<?php
									$view_all = isset( $column['view_all_link'] ) ? $column['view_all_link'] : null;
									if ( is_array( $view_all ) && ! empty( $view_all['url'] ) ) :
								?>
									<a href="<?php echo esc_url( $view_all['url'] ); ?>" class="block mt-2 py-1 text-sm font-bold text-primary hover:translate-x-1 transition-transform duration-200">
										<?php echo esc_html( $view_all['title'] ); ?> →
									</a>
								<?php endif; ?>
							</div>
						<?php endforeach; ?>
					</div>
				</div>
			</div>
		<?php endif; ?>

		<!-- Dropdown: Company (Desktop) -->
		<?php if ( ! empty( $header_company_items ) && is_array( $header_company_items ) ) : ?>
			<div x-show="openMenu === 'company'" x-cloak 
				 @mouseenter="openMenu = 'company'" 
				 @mouseleave="openMenu = null"
				 x-transition:enter="transition ease-out duration-200" 
				 x-transition:enter-start="opacity-0 -translate-y-2" 
				 x-transition:enter-end="opacity-100 translate-y-0" 
				 x-transition:leave="transition ease-in duration-150" 
				 x-transition:leave-start="opacity-100 translate-y-0" 
				 x-transition:leave-end="opacity-0 -translate-y-2" 
				 class="absolute left-0 w-full border-b border-border bg-white z-50">
				<div class="mx-auto flex max-w-container justify-center gap-12 px-container py-8">
					<?php foreach ( $header_company_items as $item ) : ?>
						<?php
							$title = isset( $item['title'] ) ? $item['title'] : '';
							$desc = isset( $item['description'] ) ? $item['description'] : '';
							$link = isset( $item['link'] ) ? $item['link'] : null;
							$link_url = is_array( $link ) && ! empty( $link['url'] ) ? $link['url'] : '#';
						?>
						<a href="<?php echo esc_url( $link_url ); ?>" class="group flex items-center gap-3 rounded-lg p-3 hover:bg-gray-50 transition">
							<div class="flex h-10 w-10 items-center justify-center rounded-full bg-primary/10 text-primary group-hover:bg-primary group-hover:text-white transition">
								<?php if ( stripos( $title, 'Contact' ) !== false ) : ?>
									<!-- Envelope Icon for Contact Us -->
									<svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
								<?php else : ?>
									<!-- Info Icon for About Us / Others -->
									<svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
								<?php endif; ?>
							</div>
							<div>
								<span class="block text-sm font-bold text-heading"><?php echo esc_html( $title ); ?></span>
								<?php if ( $desc ) : ?>
									<span class="text-xs text-body"><?php echo esc_html( $desc ); ?></span>
								<?php endif; ?>
							</div>
						</a>
					<?php endforeach; ?>
				</div>
			</div>
		<?php endif; ?>

	</header>

	<div <?php generate_do_attr( 'page' ); ?>>
		<?php
		/**
		 * generate_inside_site_container hook.
		 *
		 * @since 2.4
		 */
		do_action( 'generate_inside_site_container' );
		?>
		<div id="content" class="site-content">
			<?php
			/**
			 * generate_inside_container hook.
			 *
			 * @since 0.1
			 */
			do_action( 'generate_inside_container' );
