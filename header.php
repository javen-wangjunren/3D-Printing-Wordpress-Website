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
	<?php wp_head(); ?>
</head>

<body <?php body_class(); ?> <?php generate_do_microdata( 'body' ); ?>>
	<?php
	do_action( 'wp_body_open' );

	$header_brand = function_exists( 'get_field' ) ? get_field( 'header_brand_global', 'option' ) : null;
	$header_logo_id = is_array( $header_brand ) && isset( $header_brand['logo_image'] ) ? (int) $header_brand['logo_image'] : 0;
	$header_logo_width = is_array( $header_brand ) && isset( $header_brand['logo_width'] ) ? (int) $header_brand['logo_width'] : 0;
	$header_cta = is_array( $header_brand ) && isset( $header_brand['cta_button'] ) ? $header_brand['cta_button'] : null;
	$header_capabilities = function_exists( 'get_field' ) ? get_field( 'header_capabilities_items', 'option' ) : null;
	$header_material_columns = function_exists( 'get_field' ) ? get_field( 'header_material_columns', 'option' ) : null;
	?>

	<header x-data="{ openMenu: null, mobileOpen: false }" @mouseleave="openMenu = null" class="relative z-40 bg-white border-b border-border">
		<div class="mx-auto max-w-container px-container">
			<div class="flex h-20 items-center justify-between">
				<div class="flex items-center gap-4">
					<a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="flex items-center">
						<span class="inline-flex items-center">
							<?php if ( $header_logo_id ) : ?>
								<?php
									$logo_attrs = array(
										'class' => 'block h-8 w-auto',
									);
									if ( $header_logo_width > 0 ) {
										$logo_attrs['style'] = 'width:' . $header_logo_width . 'px';
									}
									echo wp_get_attachment_image( $header_logo_id, 'full', false, $logo_attrs );
								?>
							<?php else : ?>
								<span class="inline-flex items-center justify-center rounded-lg bg-primary px-2 py-1 text-xs font-mono font-semibold text-white">LOGO</span>
							<?php endif; ?>
						</span>
					</a>
				</div>

				<nav class="hidden items-center gap-10 lg:flex">
					<div class="relative" @mouseenter="openMenu = 'capabilities'">
						<button type="button" class="nav-link-hover relative flex items-center gap-1 py-2 text-sm font-semibold text-heading">
							<span>Capabilities</span>
							<svg class="h-4 w-4 opacity-50" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
								<path d="M19 9l-7 7-7-7" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
							</svg>
						</button>
					</div>

					<div class="relative" @mouseenter="openMenu = 'materials'">
						<button type="button" class="nav-link-hover relative flex items-center gap-1 py-2 text-sm font-semibold text-heading">
							<span>Materials</span>
							<svg class="h-4 w-4 opacity-50" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
								<path d="M19 9l-7 7-7-7" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
							</svg>
						</button>
					</div>

					<a href="<?php echo esc_url( home_url( '/blog' ) ); ?>" class="nav-link-hover relative text-sm font-semibold text-heading">Blog</a>

					<div class="relative" @mouseenter="openMenu = 'company'">
						<button type="button" class="nav-link-hover relative flex items-center gap-1 py-2 text-sm font-semibold text-heading">
							<span>Company</span>
							<svg class="h-4 w-4 opacity-50" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
								<path d="M19 9l-7 7-7-7" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
							</svg>
						</button>
					</div>
				</nav>

				<div class="hidden lg:block">
					<?php if ( is_array( $header_cta ) && ! empty( $header_cta['url'] ) ) : ?>
						<?php
							$cta_url = esc_url( $header_cta['url'] );
							$cta_title = isset( $header_cta['title'] ) ? esc_html( $header_cta['title'] ) : '';
							$cta_target = isset( $header_cta['target'] ) && $header_cta['target'] ? esc_attr( $header_cta['target'] ) : '_self';
						?>
						<a href="<?php echo $cta_url; ?>" target="<?php echo $cta_target; ?>" class="inline-flex items-center gap-2 rounded-lg bg-primary px-6 py-3 text-sm font-bold text-white transition hover:bg-primary-hover">
							<span><?php echo $cta_title ? $cta_title : esc_html__( 'Get Instant Quote', 'generatepress' ); ?></span>
							<svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
								<path d="M17 8l4 4m0 0-4 4m4-4H3" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
							</svg>
						</a>
					<?php endif; ?>
				</div>

				<button type="button" class="lg:hidden" @click="mobileOpen = ! mobileOpen" aria-label="Toggle navigation">
					<svg class="h-6 w-6 text-heading" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
						<path d="M4 6h16M4 12h16M4 18h16" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
					</svg>
				</button>
			</div>
		</div>

		<?php if ( ! empty( $header_capabilities ) && is_array( $header_capabilities ) ) : ?>
			<div x-show="openMenu === 'capabilities'" x-cloak x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 -translate-y-2" x-transition:enter-end="opacity-100 translate-y-0" class="absolute left-0 w-full bg-white shadow-sm border-b border-border">
				<div class="mx-auto max-w-container px-container py-8 lg:py-10">
					<div class="grid gap-y-6 gap-x-12 lg:grid-cols-3">
						<?php foreach ( $header_capabilities as $item ) : ?>
							<?php
								$tech_name = isset( $item['tech_name'] ) ? $item['tech_name'] : '';
								$subtitle = isset( $item['subtitle'] ) ? $item['subtitle'] : '';
								$tag = isset( $item['tag'] ) ? $item['tag'] : '';
								$link = isset( $item['link'] ) ? $item['link'] : null;
								$link_url = is_array( $link ) && ! empty( $link['url'] ) ? esc_url( $link['url'] ) : '#';
							?>
							<a href="<?php echo $link_url; ?>" class="group -m-4 flex flex-col gap-1 rounded-xl p-4 transition hover:bg-bg-section">
								<div class="flex items-center gap-3">
									<span class="text-sm font-bold text-heading group-hover:text-primary"><?php echo esc_html( $tech_name ); ?></span>
									<?php if ( $tag ) : ?>
										<span class="rounded px-1.5 py-0.5 text-[9px] font-mono font-bold text-muted bg-border"><?php echo esc_html( $tag ); ?></span>
									<?php endif; ?>
								</div>
								<?php if ( $subtitle ) : ?>
									<span class="text-xs text-body"><?php echo esc_html( $subtitle ); ?></span>
								<?php endif; ?>
							</a>
						<?php endforeach; ?>
					</div>
				</div>
			</div>
		<?php endif; ?>

		<?php if ( ! empty( $header_material_columns ) && is_array( $header_material_columns ) ) : ?>
			<div x-show="openMenu === 'materials'" x-cloak x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 -translate-y-2" x-transition:enter-end="opacity-100 translate-y-0" class="absolute left-0 w-full bg-white shadow-sm border-b border-border">
				<div class="mx-auto max-w-container px-container py-8 lg:py-10">
					<div class="grid gap-8 lg:grid-cols-4">
						<?php foreach ( $header_material_columns as $column ) : ?>
							<?php
								$column_title = isset( $column['title'] ) ? $column['title'] : '';
								$links = isset( $column['links'] ) ? $column['links'] : null;
							?>
							<div>
								<?php if ( $column_title ) : ?>
									<h3 class="mb-4 text-[11px] font-bold uppercase tracking-[1.5px] text-muted"><?php echo esc_html( $column_title ); ?></h3>
								<?php endif; ?>
								<?php if ( ! empty( $links ) && is_array( $links ) ) : ?>
									<ul class="space-y-3">
										<?php foreach ( $links as $link_item ) : ?>
											<?php
												$label = isset( $link_item['label'] ) ? $link_item['label'] : '';
												$url = isset( $link_item['url'] ) ? $link_item['url'] : '';
											?>
											<li>
												<?php if ( $url ) : ?>
													<a href="<?php echo esc_url( $url ); ?>" class="text-sm text-heading hover:text-primary"><?php echo esc_html( $label ); ?></a>
												<?php else : ?>
													<span class="text-sm text-heading"><?php echo esc_html( $label ); ?></span>
												<?php endif; ?>
											</li>
										<?php endforeach; ?>
									</ul>
								<?php endif; ?>
							</div>
						<?php endforeach; ?>
					</div>
				</div>
			</div>
		<?php endif; ?>

		<div x-show="openMenu === 'company'" x-cloak x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 -translate-y-2" x-transition:enter-end="opacity-100 translate-y-0" class="absolute left-0 w-full border-b border-border bg-white shadow-sm">
			<div class="mx-auto flex max-w-container justify-center gap-8 px-container py-6">
				<a href="<?php echo esc_url( home_url( '/about' ) ); ?>" class="text-sm font-semibold text-heading hover:text-primary">About Us</a>
				<a href="<?php echo esc_url( home_url( '/contact' ) ); ?>" class="text-sm font-semibold text-heading hover:text-primary">Contact Us</a>
			</div>
		</div>
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
		<div <?php generate_do_attr( 'site-content' ); ?>>
			<?php
			/**
			 * generate_inside_container hook.
			 *
			 * @since 0.1
			 */
			do_action( 'generate_inside_container' );
