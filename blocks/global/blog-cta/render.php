<?php
/**
 * Block: Blog CTA (Global Module)
 * Location: blocks/global/blog-cta/render.php
 * 
 * Logic:
 * 1. Check if module is enabled via ACF options.
 * 2. Fetch data from ACF options page (Group: global_blog_cta -> Clone: blog_cta_clone).
 * 3. Fallback to default values if not set.
 */

// 1. Get Data Source (Global Options)
$group = get_field( 'global_blog_cta', 'option' );
$data  = isset( $group['blog_cta_clone'] ) && is_array( $group['blog_cta_clone'] ) ? $group['blog_cta_clone'] : ( is_array( $group ) ? $group : array() );

// 2. Check Enabled Status
$is_enabled = isset( $data['blog_cta_enabled'] ) ? $data['blog_cta_enabled'] : true;
if ( ! $is_enabled ) {
	return;
}

// 3. Extract Data with Defaults
$eyebrow     = ! empty( $data['blog_cta_eyebrow'] ) ? $data['blog_cta_eyebrow'] : 'Industrial Service';
$title       = ! empty( $data['blog_cta_title'] ) ? $data['blog_cta_title'] : 'Ready to Scale Your Production?';
$btn_text    = ! empty( $data['blog_cta_button_text'] ) ? $data['blog_cta_button_text'] : 'Get A Quote';
$btn_link_id = ! empty( $data['blog_cta_button_link'] ) ? $data['blog_cta_button_link'] : '';

// 4. Resolve Link URL
$btn_url = '#';
if ( ! empty( $btn_link_id ) ) {
	if ( is_array( $btn_link_id ) && isset( $btn_link_id['url'] ) ) {
		$btn_url = $btn_link_id['url']; // If return format is array (Link field)
	} elseif ( is_numeric( $btn_link_id ) ) {
		$btn_url = get_permalink( $btn_link_id ); // If return format is ID (Post Object)
	} else {
		$btn_url = $btn_link_id; // Fallback string
	}
}
?>

<div class="border border-border rounded-card p-6 bg-white">
	<div class="font-mono text-[11px] tracking-wider text-body/70 mb-3 uppercase">
		<?php echo esc_html( $eyebrow ); ?>
	</div>
	<h5 class="text-[18px] font-extrabold tracking-[-0.5px] mb-4 text-heading">
		<?php echo esc_html( $title ); ?>
	</h5>
	<a href="<?php echo esc_url( $btn_url ); ?>" class="block w-full bg-primary text-white py-3.5 rounded-button font-bold text-[12px] tracking-wider hover:bg-primary-hover transition-colors text-center uppercase">
		<?php echo esc_html( $btn_text ); ?>
	</a>
</div>
