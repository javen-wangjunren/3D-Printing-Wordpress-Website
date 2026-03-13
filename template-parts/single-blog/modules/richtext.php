<?php
/**
 * Module: Richtext
 */
$richtext = get_sub_field( 'richtext_content' );
// Apply filters to process shortcodes/embeds, but also our custom H2 ID injection
$richtext = apply_filters( 'the_content', $richtext );
?>
<div class="prose prose-lg max-w-none text-heading prose-p:text-heading prose-li:text-heading prose-strong:text-heading prose-em:text-heading prose-blockquote:text-heading prose-figcaption:text-heading prose-code:text-heading prose-headings:text-heading prose-headings:font-extrabold prose-headings:tracking-tight prose-a:text-primary prose-a:no-underline hover:prose-a:underline prose-img:rounded-card prose-img:border prose-img:border-border">
	<?php echo $richtext; ?>
</div>
