<?php
/**
 * Component: Contact Form Section (通用联系表单板块)
 * ==========================================================================
 * 文件作用:
 * 渲染一个带有左侧表单、右侧技术支持信息的双栏联系板块。
 * 
 * 核心逻辑:
 * 1. 接收外部传入的标题和 Shortcode。
 * 2. 如果未传入，尝试从当前页面 ACF 获取。
 * 3. 渲染 FluentForm 短代码。
 * 
 * 参数 (通过 set_query_var 传入):
 * - $title (string): 表单标题
 * - $shortcode (string): FluentForm 短代码
 * ==========================================================================
 */

// 1. 获取参数 (优先使用传入参数，其次尝试读取 ACF，最后使用默认值)
$title = isset( $title ) ? $title : get_field( 'contact_form_title' );
$shortcode = isset( $shortcode ) ? $shortcode : get_field( 'contact_form_shortcode' );
$support_title = isset( $support_title ) ? $support_title : get_field( 'contact_support_title' );
$support_desc = isset( $support_desc ) ? $support_desc : get_field( 'contact_support_desc' );
$support_items = isset( $support_items ) ? $support_items : get_field( 'contact_support_items' );

$support_title = $support_title ? (string) $support_title : 'Technical Support';
$support_desc = $support_desc ? (string) $support_desc : 'Our engineering team is ready to assist with your inquiries.';
$support_items = is_array( $support_items ) ? $support_items : array();

// 安全兜底
if ( ! $shortcode ) {
    $shortcode = '[fluentform id="1"]';
}

$allowed_svg = array(
    'svg' => array(
        'xmlns' => true,
        'viewbox' => true,
        'width' => true,
        'height' => true,
        'fill' => true,
        'stroke' => true,
        'stroke-width' => true,
        'stroke-linecap' => true,
        'stroke-linejoin' => true,
        'class' => true,
        'aria-hidden' => true,
        'role' => true,
        'focusable' => true,
    ),
    'g' => array(
        'fill' => true,
        'stroke' => true,
        'stroke-width' => true,
        'stroke-linecap' => true,
        'stroke-linejoin' => true,
        'transform' => true,
    ),
    'path' => array(
        'd' => true,
        'fill' => true,
        'stroke' => true,
        'stroke-width' => true,
        'stroke-linecap' => true,
        'stroke-linejoin' => true,
        'transform' => true,
    ),
    'circle' => array(
        'cx' => true,
        'cy' => true,
        'r' => true,
        'fill' => true,
        'stroke' => true,
        'stroke-width' => true,
    ),
    'rect' => array(
        'x' => true,
        'y' => true,
        'width' => true,
        'height' => true,
        'rx' => true,
        'ry' => true,
        'fill' => true,
        'stroke' => true,
        'stroke-width' => true,
    ),
    'line' => array(
        'x1' => true,
        'y1' => true,
        'x2' => true,
        'y2' => true,
        'stroke' => true,
        'stroke-width' => true,
        'stroke-linecap' => true,
    ),
    'polyline' => array(
        'points' => true,
        'fill' => true,
        'stroke' => true,
        'stroke-width' => true,
        'stroke-linecap' => true,
        'stroke-linejoin' => true,
    ),
    'polygon' => array(
        'points' => true,
        'fill' => true,
        'stroke' => true,
        'stroke-width' => true,
        'stroke-linecap' => true,
        'stroke-linejoin' => true,
    ),
);

if ( empty( $support_items ) ) {
    $support_items = array(
        array(
            'item_icon' => '<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>',
            'item_title' => 'Email Channel',
            'item_value' => 'info@now3dp.com',
        ),
        array(
            'item_icon' => '<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>',
            'item_title' => 'Response Time',
            'item_value' => 'Within 24 Hours',
        ),
    );
}
?>

<section class="section-contact-form relative z-10 -mt-8 lg:-mt-16">
    <!-- Container: Industrial Precision (No heavy shadows, just clean borders) -->
    <div class="container mx-auto px-4 max-w-[1200px]">
        <div class="bg-white rounded-xl border border-[#E4E7EC] overflow-hidden">
            <div class="grid grid-cols-1 lg:grid-cols-12">
                
                <!-- Left: Form Area (8 cols) -->
                <div class="lg:col-span-8 p-6 lg:p-12 order-2 lg:order-1">
                    <?php if ( $title ) : ?>
                        <h2 class="text-h3 lg:text-h2 text-heading mb-8 font-bold tracking-tight">
                            <?php echo esc_html( $title ); ?>
                        </h2>
                    <?php endif; ?>

                    <div class="contact-form-wrapper">
                        <?php echo do_shortcode( $shortcode ); ?>
                    </div>
                </div>

                <!-- Right: Technical Support (4 cols) -->
                <div class="lg:col-span-4 bg-[#F9FAFB] p-6 lg:p-12 border-t border-[#E4E7EC] lg:border-t-0 lg:border-l order-1 lg:order-2 flex flex-col justify-center">
                    <div class="space-y-6">
                        <div>
                            <h3 class="text-heading text-lg font-bold tracking-tight">
                                <?php echo esc_html( $support_title ); ?>
                            </h3>
                            <p class="mt-2 text-sm text-gray-500 leading-relaxed">
                                <?php echo esc_html( $support_desc ); ?>
                            </p>
                        </div>

                        <div class="rounded-xl border border-[#E4E7EC] bg-white overflow-hidden">
                            <div class="divide-y divide-[#E4E7EC]">
                                <?php foreach ( $support_items as $item ) : ?>
                                    <?php
                                    $item_icon  = isset( $item['item_icon'] ) ? (string) $item['item_icon'] : '';
                                    $item_title = isset( $item['item_title'] ) ? (string) $item['item_title'] : '';
                                    $item_value = isset( $item['item_value'] ) ? (string) $item['item_value'] : '';
                                    if ( '' === trim( $item_title ) && '' === trim( $item_value ) ) {
                                        continue;
                                    }

                                    $value_render = esc_html( $item_value );
                                    $value_href   = '';
                                    $is_email     = ( '' !== $item_value && false !== strpos( $item_value, '@' ) && false === strpos( $item_value, ' ' ) );
                                    $is_url       = ( '' !== $item_value && ( 0 === strpos( $item_value, 'http://' ) || 0 === strpos( $item_value, 'https://' ) ) );
                                    if ( $is_email ) {
                                        $email = sanitize_email( $item_value );
                                        if ( $email ) {
                                            $value_href = 'mailto:' . $email;
                                            $value_render = esc_html( $email );
                                        }
                                    } elseif ( $is_url ) {
                                        $value_href = esc_url( $item_value );
                                    }
                                    ?>
                                    <div class="p-4">
                                        <div class="flex items-start gap-3">
                                            <span class="shrink-0 w-9 h-9 rounded-lg border border-[#E4E7EC] bg-[#F9FAFB] flex items-center justify-center text-[#0047AB]">
                                                <?php
                                                if ( $item_icon ) {
                                                    echo wp_kses( $item_icon, $allowed_svg );
                                                }
                                                ?>
                                            </span>
                                            <div class="min-w-0">
                                                <?php if ( $item_title ) : ?>
                                                    <div class="text-[11px] font-bold tracking-widest text-[#1D2938]">
                                                        <?php echo esc_html( $item_title ); ?>
                                                    </div>
                                                <?php endif; ?>
                                                <?php if ( $item_value ) : ?>
                                                    <?php if ( $value_href ) : ?>
                                                        <a href="<?php echo esc_url( $value_href ); ?>" class="mt-1 block font-mono text-sm text-[#0047AB] break-all hover:underline">
                                                            <?php echo $value_render; ?>
                                                        </a>
                                                    <?php else : ?>
                                                        <div class="mt-1 font-mono text-sm text-[#1D2938] break-all">
                                                            <?php echo $value_render; ?>
                                                        </div>
                                                    <?php endif; ?>
                                                <?php endif; ?>
                                            </div>
                                        </div>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
</section>
