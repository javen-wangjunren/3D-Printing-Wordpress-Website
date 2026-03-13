<?php
/**
 * Template Part: Single Blog Content
 * Location: template-parts/single-blog/content.php
 * 
 * Logic:
 * 1. Check if Builder Mode is active (ACF: post_use_builder).
 * 2. If active, render Flexible Content modules (Richtext, Table, CTA, etc.).
 * 3. If inactive, fallback to standard the_content().
 */

$use_builder = get_field( 'post_use_builder' );

// Common prose classes for consistency
$prose_class = 'prose prose-lg max-w-none text-heading prose-p:text-heading prose-li:text-heading prose-strong:text-heading prose-em:text-heading prose-blockquote:text-heading prose-figcaption:text-heading prose-code:text-heading prose-headings:text-heading prose-headings:font-extrabold prose-headings:tracking-tight prose-a:text-primary prose-a:no-underline hover:prose-a:underline prose-img:rounded-card prose-img:border prose-img:border-border';

?>

<article class="lg:col-span-8 text-heading">
	
	<!-- Intro / Excerpt (Use WP Excerpt as Lead) -->
	<?php if ( has_excerpt() ) : ?>
		<p class="text-[18px] lg:text-[20px] leading-relaxed font-medium text-heading mb-10 border-l-4 border-primary pl-6">
			<?php echo get_the_excerpt(); ?>
		</p>
	<?php endif; ?>

	<!-- Main Content Area -->
	<div class="content-body space-y-8">
		<?php
		if ( $use_builder ) :
			// --- Builder Mode ---
			if ( have_rows( 'post_body' ) ) :
				while ( have_rows( 'post_body' ) ) : the_row();
					
					// Load module template dynamically based on layout name
					// (richtext, table, cta, image, callout)
					get_template_part( 'template-parts/single-blog/modules/' . get_row_layout() );

				endwhile;
			else :
				// Fallback if builder is on but empty
				echo '<p class="text-heading italic">Content is being built...</p>';
			endif;

		else :
			// --- Standard Mode (Gutenberg Fallback) ---
			$content = get_the_content();
			// Add IDs to H2 tags for TOC linking
			$content = apply_filters( 'the_content', $content );
			?>
			<div class="<?php echo esc_attr( $prose_class ); ?>">
				<?php echo $content; ?>
			</div>
			<?php
		endif;
		?>

		<!-- Footer Author Card (Landscape) -->
		<div class="mt-16 pt-10 border-t border-border">
			<?php 
			_3dp_render_block( 'blocks/global/author-profile/render', array(
				'variant' => 'footer',
			) ); 
			?>
		</div>

	</div>

</article>
