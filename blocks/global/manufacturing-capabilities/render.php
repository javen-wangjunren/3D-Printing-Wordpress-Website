<?php
$section_title  = get_field( 'manufacturing_capabilities_title' );
$section_title  = $section_title ? $section_title : 'Manufacturing Capabilities';
$section_intro  = get_field( 'manufacturing_capabilities_intro' );
$tabs_raw       = get_field( 'manufacturing_capabilities_tabs' );
$tabs_raw       = is_array( $tabs_raw ) ? $tabs_raw : array();
$mobile_compact = (bool) get_field( 'manufacturing_capabilities_mobile_compact_mode' );
$use_mono       = (bool) get_field( 'manufacturing_capabilities_use_mono_font' );
$show_tabs      = (bool) get_field( 'manufacturing_capabilities_show_tabs' );
$anchor_id      = get_field( 'manufacturing_capabilities_anchor_id' );
$extra_class    = get_field( 'manufacturing_capabilities_css_class' );

$tabs = array();
foreach ( $tabs_raw as $tab ) {
    $highlights = array();
    if ( ! empty( $tab['highlights'] ) && is_array( $tab['highlights'] ) ) {
        foreach ( $tab['highlights'] as $hl ) {
            $highlights[] = array(
                'title' => isset( $hl['title'] ) ? (string) $hl['title'] : '',
                'value' => isset( $hl['value'] ) ? (string) $hl['value'] : '',
                'unit'  => isset( $hl['unit'] ) ? (string) $hl['unit'] : '',
                'tag'   => isset( $hl['tag'] ) ? (string) $hl['tag'] : '',
            );
        }
    }

    $finishing_tags = array();
    if ( ! empty( $tab['finishing_tags'] ) && is_array( $tab['finishing_tags'] ) ) {
        foreach ( $tab['finishing_tags'] as $ft ) {
            if ( isset( $ft['text'] ) && $ft['text'] !== '' ) {
                $finishing_tags[] = (string) $ft['text'];
            }
        }
    }

    $cta = array(
        'url'    => '',
        'label'  => '',
        'target' => '',
    );
    if ( ! empty( $tab['cta_link'] ) && is_array( $tab['cta_link'] ) ) {
        $cta['url']    = isset( $tab['cta_link']['url'] ) ? (string) $tab['cta_link']['url'] : '';
        $cta['label']  = isset( $tab['cta_link']['title'] ) ? (string) $tab['cta_link']['title'] : '';
        $cta['target'] = isset( $tab['cta_link']['target'] ) ? (string) $tab['cta_link']['target'] : '';
    }

    $image_id        = isset( $tab['image'] ) ? (int) $tab['image'] : 0;
    $mobile_image_id = isset( $tab['mobile_image'] ) ? (int) $tab['mobile_image'] : 0;
    $image_url       = $image_id ? wp_get_attachment_image_url( $image_id, 'large' ) : '';
    $mobile_url      = $mobile_image_id ? wp_get_attachment_image_url( $mobile_image_id, 'large' ) : '';

    $tabs[] = array(
        'title'          => isset( $tab['tab_title'] ) ? (string) $tab['tab_title'] : '',
        'key'            => isset( $tab['tab_key'] ) ? (string) $tab['tab_key'] : '',
        'machine'        => isset( $tab['machine_model'] ) ? (string) $tab['machine_model'] : '',
        'hub_title'      => isset( $tab['hub_title'] ) ? (string) $tab['hub_title'] : '',
        'hub_desc'       => isset( $tab['hub_desc'] ) ? (string) $tab['hub_desc'] : '',
        'highlights'     => $highlights,
        'finishing_tags' => $finishing_tags,
        'cta'            => $cta,
        'image'          => array(
            'desktop' => $image_url ? $image_url : '',
            'mobile'  => $mobile_url ? $mobile_url : $image_url,
        ),
    );
}

$config = array(
    'active'   => 0,
    'tabs'     => $tabs,
    'useMono'  => $use_mono,
    'showTabs' => $show_tabs,
);

$json_config = wp_json_encode( $config );

$root_id = $anchor_id ? $anchor_id : 'manufacturing-capabilities-' . ( isset( $block['id'] ) ? $block['id'] : uniqid() );

$root_class = 'section-py';
if ( $mobile_compact ) {
    $root_class .= ' mcap-mobile-compact';
}
if ( ! empty( $block['className'] ) ) {
    $root_class .= ' ' . $block['className'];
}
if ( $extra_class ) {
    $root_class .= ' ' . $extra_class;
}
?>

<section id="<?php echo esc_attr( $root_id ); ?>" class="<?php echo esc_attr( $root_class ); ?>">
    <div class="container" x-data='<?php echo $json_config ? $json_config : wp_json_encode( array( 'active' => 0, 'tabs' => array(), 'useMono' => false, 'showTabs' => false ) ); ?>'>
        <header class="header-stack">
            <h2 class="h2"><?php echo esc_html( $section_title ); ?></h2>
            <?php if ( $section_intro ) : ?>
                <p class="hub-desc">
                    <?php echo esc_html( $section_intro ); ?>
                </p>
            <?php endif; ?>
            <div class="tabs-nav" x-show="showTabs && tabs && tabs.length > 1">
                <template x-for="(tab, index) in tabs" :key="tab.key || index">
                    <button type="button" class="tab-btn" :class="index === active ? 'active' : ''" @click="active = index" x-text="tab.title"></button>
                </template>
            </div>
        </header>

        <div class="hub-grid" x-show="tabs && tabs.length" x-cloak>
            <div class="hub-info">
                <div class="fade-in" x-show="tabs[active]">
                    <h3 class="hub-h3" x-text="tabs[active] ? tabs[active].hub_title : ''"></h3>
                    <p class="hub-desc" x-text="tabs[active] ? tabs[active].hub_desc : ''"></p>

                    <div class="perf-grid">
                        <template x-for="(item, index) in tabs[active] ? tabs[active].highlights : []" :key="index">
                            <div class="perf-card">
                                <span class="perf-tag" x-text="item.tag"></span>
                                <h3 class="perf-title" x-text="item.title"></h3>
                                <div class="perf-value" :class="useMono ? 'font-mono' : ''">
                                    <span x-text="item.value"></span>
                                    <span class="unit" x-text="item.unit"></span>
                                </div>
                            </div>
                        </template>
                    </div>

                    <div style="margin-top: 24px;" x-show="tabs[active] && tabs[active].finishing_tags && tabs[active].finishing_tags.length">
                        <span style="font-size: 10px; font-weight: 700; color: var(--muted); text-transform: uppercase; letter-spacing: 1.5px; display: block; margin-bottom: 12px;">Available Finishing</span>
                        <div class="tags-row">
                            <template x-for="(tag, index) in tabs[active] ? tabs[active].finishing_tags : []" :key="index">
                                <span class="t-item" x-text="tag"></span>
                            </template>
                        </div>
                    </div>
                </div>

                <div>
                    <template x-if="tabs[active] && tabs[active].cta && tabs[active].cta.url">
                        <a :href="tabs[active].cta.url" :target="tabs[active].cta.target || '_self'" class="btn-tech-service">
                            <span x-text="tabs[active].cta.label || 'Technical Service Details'"></span>
                            <svg style="width: 16px; height: 16px;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"/></svg>
                        </a>
                    </template>
                </div>
            </div>

            <div class="hub-visual" x-show="tabs[active]">
                <div class="img-frame">
                    <template x-if="tabs[active] && tabs[active].image && (tabs[active].image.desktop || tabs[active].image.mobile)">
                        <img :src="tabs[active].image.desktop || tabs[active].image.mobile" alt="" />
                    </template>
                    <div class="frame-tag" x-text="tabs[active] ? tabs[active].machine : ''"></div>
                </div>
            </div>
        </div>
    </div>
</section>
