<?php
/**
 * Template Name: Contact
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

get_header();

/**
 * 1. Render Hero Banner
 * 
 * We use the global _3dp_render_block helper.
 * Since the fields are registered on this page (via ACF Clone),
 * the get_field() calls inside the render file will automatically
 * pull data from the current post object.
 */
_3dp_render_block( 'blocks/global/hero-banner/render', array( 
    'id' => 'contact-hero' 
) );

/**
 * 2. Render Contact Form Section
 */
$form_title     = get_field( 'contact_form_title' );
$form_shortcode = get_field( 'contact_form_shortcode' );

// Default fallback if field is empty but page is active (safety net)
if ( ! $form_shortcode ) {
    $form_shortcode = '[fluentform id="1"]';
}
?>

<section class="section-contact-form relative z-10 -mt-8 lg:-mt-16 mb-20">
    <!-- Container: Industrial Precision (No heavy shadows, just clean borders) -->
    <div class="container mx-auto px-4 max-w-[1200px]">
        <div class="bg-white rounded-xl border border-[#E4E7EC] overflow-hidden">
            <div class="grid grid-cols-1 lg:grid-cols-12">
                
                <!-- Left: Form Area (8 cols) -->
                <div class="lg:col-span-8 p-6 lg:p-12 order-2 lg:order-1">
                    <?php if ( $form_title ) : ?>
                        <h2 class="text-h3 lg:text-h2 text-heading mb-8 font-bold tracking-tight">
                            <?php echo esc_html( $form_title ); ?>
                        </h2>
                    <?php endif; ?>

                    <div class="contact-form-wrapper">
                        <?php echo do_shortcode( $form_shortcode ); ?>
                    </div>
                </div>

                <!-- Right: Technical Support (4 cols) -->
                <div class="lg:col-span-4 bg-[#F9FAFB] p-6 lg:p-12 border-l border-[#E4E7EC] order-1 lg:order-2 flex flex-col justify-center">
                    <div class="prose prose-sm text-body">
                        <h3 class="text-heading text-lg font-bold mb-4 tracking-tight">Technical Support</h3>
                        <p class="mb-6 text-gray-500">
                            Our engineering team is ready to assist with your inquiries.
                        </p>
                        
                        <div class="space-y-6">
                            <!-- Contact Item -->
                            <div class="flex items-start gap-3">
                                <span class="text-primary mt-0.5">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                                </span>
                                <div>
                                    <span class="block font-bold text-heading text-xs uppercase tracking-wider mb-1">Email Channel</span>
                                    <a href="mailto:support@example.com" class="text-primary hover:underline font-mono text-sm">support@example.com</a>
                                </div>
                            </div>
                            
                            <!-- Additional Info (Mockup) -->
                            <div class="flex items-start gap-3">
                                <span class="text-primary mt-0.5">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                </span>
                                <div>
                                    <span class="block font-bold text-heading text-xs uppercase tracking-wider mb-1">Response Time</span>
                                    <span class="block font-mono text-sm text-body">Within 24 Hours</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</section>

<?php
get_footer();
