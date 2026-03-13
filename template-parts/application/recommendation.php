<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$title    = get_field( 'recommendation_title' );
$subtitle = get_field( 'recommendation_subtitle' );
$rows     = get_field( 'recommendation_rows' );

if ( ! is_array( $rows ) ) {
	$rows = array();
}

$icon_external = '<svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/></svg>';

?>

<section class="py-16 lg:py-24 bg-bg-subtle overflow-hidden">
	<div class="w-[90%] lg:w-[1280px] mx-auto px-6">
		<div class="mb-12 lg:mb-16 text-center">
			<?php if ( $title ) : ?>
				<h2 class="industrial-h2 text-heading text-[28px] lg:text-[36px] font-bold mb-3">
					<?php echo wp_kses_post( $title ); ?>
				</h2>
			<?php endif; ?>
			<?php if ( $subtitle ) : ?>
				<p class="text-body text-[15px] max-w-2xl mx-auto">
					<?php echo esc_html( $subtitle ); ?>
				</p>
			<?php endif; ?>
		</div>
		<div class="overflow-hidden rounded-[12px] border border-border bg-white">
			<table class="w-full m-0 border-collapse">
				<thead>
					<tr class="bg-panel border-b border-border">
						<th class="text-left px-6 py-4 font-semibold text-[13px] text-heading uppercase tracking-wider">Application</th>
						<th class="text-left px-6 py-4 font-semibold text-[13px] text-heading uppercase tracking-wider">Recommended Process</th>
						<th class="text-left px-6 py-4 font-semibold text-[13px] text-heading uppercase tracking-wider">Key Material</th>
						<th class="text-left px-6 py-4 font-semibold text-[13px] text-heading uppercase tracking-wider">Primary Benefit</th>
					</tr>
				</thead>
				<tbody class="divide-y divide-border">
					<?php foreach ( $rows as $row ) : ?>
						<?php
						$ap_image_id = isset( $row['recommend_ap_image'] ) ? (int) $row['recommend_ap_image'] : 0;
						$ap_name     = isset( $row['recommend_ap_name'] ) ? $row['recommend_ap_name'] : '';
						$benefit     = isset( $row['recommend_benefit'] ) ? $row['recommend_benefit'] : '';

						$process_ids  = isset( $row['recommend_process'] ) ? $row['recommend_process'] : array();
						$material_ids = isset( $row['recommend_material'] ) ? $row['recommend_material'] : array();

						if ( ! is_array( $process_ids ) ) {
							$process_ids = array( $process_ids );
						}

						if ( ! is_array( $material_ids ) ) {
							$material_ids = array( $material_ids );
						}

						$ap_image_url = $ap_image_id ? wp_get_attachment_image_url( $ap_image_id, 'thumbnail' ) : '';
						$post_meta_fn = function_exists( 'get_post_meta' ) ? 'get_post_meta' : null;
						$ap_image_alt = ( $ap_image_id && $post_meta_fn ) ? $post_meta_fn( $ap_image_id, '_wp_attachment_image_alt', true ) : '';
						?>
						<tr class="hover:bg-panel/50 transition-colors duration-200">
							<td class="px-6 py-4">
								<div class="flex items-center gap-4">
									<div class="w-14 h-14 rounded-[8px] overflow-hidden bg-panel border border-border flex-shrink-0">
										<?php if ( $ap_image_url ) : ?>
											<img loading="lazy" src="<?php echo esc_url( $ap_image_url ); ?>" class="w-full h-full object-cover" alt="<?php echo esc_attr( $ap_image_alt ); ?>" sizes="(min-width: 1024px) 800px, 100vw">										<?php endif; ?>
									</div>
									<span class="font-semibold text-heading text-[15px]"><?php echo esc_html( $ap_name ); ?></span>
								</div>
							</td>
							<td class="px-6 py-4">
								<?php foreach ( $process_ids as $process_id ) : ?>
									<?php
									$process_id = (int) $process_id;
									if ( ! $process_id ) {
										continue;
									}
									$process_title = get_the_title( $process_id );
									$process_url   = get_permalink( $process_id );
									if ( ! $process_title || ! $process_url ) {
										continue;
									}
									?>
									<a href="<?php echo esc_url( $process_url ); ?>" class="inline-flex items-center gap-1 px-3 py-1.5 bg-primary/5 text-primary border border-primary/20 rounded-[6px] font-mono text-[11px] font-semibold transition-colors hover:bg-primary hover:text-white hover:border-primary">
										<?php echo esc_html( $process_title ); ?>
										<?php echo wp_kses_post( $icon_external ); ?>
									</a>
								<?php endforeach; ?>
							</td>
							<td class="px-6 py-4">
								<?php foreach ( $material_ids as $material_id ) : ?>
									<?php
									$material_id = (int) $material_id;
									if ( ! $material_id ) {
										continue;
									}
									$material_title = get_the_title( $material_id );
									$material_url   = get_permalink( $material_id );
									if ( ! $material_title || ! $material_url ) {
										continue;
									}
									?>
									<a href="<?php echo esc_url( $material_url ); ?>" class="inline-flex items-center gap-1 px-3 py-1.5 bg-primary/5 text-primary border border-primary/20 rounded-[6px] font-mono text-[11px] font-semibold transition-colors hover:bg-primary hover:text-white hover:border-primary">
										<?php echo esc_html( $material_title ); ?>
										<?php echo wp_kses_post( $icon_external ); ?>
									</a>
								<?php endforeach; ?>
							</td>
							<td class="px-6 py-4">
								<span class="text-body text-[14px]"><?php echo esc_html( $benefit ); ?></span>
							</td>
						</tr>
					<?php endforeach; ?>
				</tbody>
			</table>
		</div>
	</div>
</section>
