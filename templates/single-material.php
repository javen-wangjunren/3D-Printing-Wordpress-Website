<?php
/**
 * Template Name: Single Material
 * Post Type: material
 * 
 * 渲染逻辑：
 * 1. Hero Banner (数据来源：Current CPT)
 * 2. Manufacturing Showcase (数据来源：Current CPT)
 * 3. Technical Specs (数据来源：Current CPT)
 * 4. Manufacturing Capabilities (数据来源：Current CPT)
 * 5. CTA (全局模块)
 */

get_header();
?>

<main id="site-content" class="site-main">
    <?php while ( have_posts() ) : the_post(); ?>

        <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
            
            <?php
            /**
             * 1. Hero Banner
             */
            $hero_template = locate_template( 'blocks/global/hero-banner/render.php' );
            if ( $hero_template ) {
                include $hero_template;
            }

            /**
             * 2. Manufacturing Showcase
             */
            $showcase_template = locate_template( 'blocks/global/manufacturing-showcase/render.php' );
            if ( $showcase_template ) {
                include $showcase_template;
            }

            /**
             * 3. Technical Specs
             */
            $specs_template = locate_template( 'blocks/global/technical-specs/render.php' );
            if ( $specs_template ) {
                include $specs_template;
            }

            /**
             * 4. Manufacturing Capabilities
             * 
             * 由于该模块较为复杂且尚未有通用的render.php，此处直接实现渲染逻辑。
             * 数据字段：manufacturing_capabilities_title, manufacturing_capabilities_intro, manufacturing_capabilities_tabs
             */
            $mcap_title = get_field('manufacturing_capabilities_title');
            $mcap_intro = get_field('manufacturing_capabilities_intro');
            $mcap_tabs = get_field('manufacturing_capabilities_tabs');
            $mcap_mobile_compact = get_field('manufacturing_capabilities_mobile_compact_mode');
            $mcap_use_mono = get_field('manufacturing_capabilities_use_mono_font');
            $mcap_show_tabs = get_field('manufacturing_capabilities_show_tabs');
            $mcap_anchor = get_field('manufacturing_capabilities_anchor_id');
            $mcap_class = get_field('manufacturing_capabilities_css_class');
            
            $container_class = 'manufacturing-capabilities-block ' . esc_attr($mcap_class);
            $container_id = $mcap_anchor ? 'id="' . esc_attr($mcap_anchor) . '"' : '';
            ?>
            
            <?php if ( $mcap_tabs ) : ?>
            <section class="<?php echo $container_class; ?>" <?php echo $container_id; ?>>
                <div class="mcap-container">
                    
                    <!-- Header -->
                    <?php if ( $mcap_title || $mcap_intro ) : ?>
                    <div class="mcap-header">
                        <?php if ( $mcap_title ) : ?>
                            <h2 class="mcap-title"><?php echo esc_html($mcap_title); ?></h2>
                        <?php endif; ?>
                        <?php if ( $mcap_intro ) : ?>
                            <div class="mcap-intro"><?php echo wpautop($mcap_intro); ?></div>
                        <?php endif; ?>
                    </div>
                    <?php endif; ?>

                    <!-- Tabs Navigation -->
                    <?php if ( $mcap_show_tabs && count($mcap_tabs) > 1 ) : ?>
                    <div class="mcap-tabs-nav">
                        <?php foreach ( $mcap_tabs as $index => $tab ) : 
                            $is_active = $index === 0 ? 'active' : '';
                        ?>
                            <button class="mcap-tab-btn <?php echo $is_active; ?>" data-tab="<?php echo esc_attr($index); ?>">
                                <?php echo esc_html($tab['tab_title']); ?>
                            </button>
                        <?php endforeach; ?>
                    </div>
                    <?php endif; ?>

                    <!-- Tabs Content -->
                    <div class="mcap-tabs-content">
                        <?php foreach ( $mcap_tabs as $index => $tab ) : 
                            $is_active = $index === 0 ? 'active' : '';
                            $machine_model = $tab['machine_model'];
                            $hub_title = $tab['hub_title'];
                            $hub_desc = $tab['hub_desc'];
                            $highlights = $tab['highlights'];
                            $finishing_tags = $tab['finishing_tags'];
                            $cta_link = $tab['cta_link'];
                            $image_id = $tab['image'];
                            $mobile_image_id = $tab['mobile_image'];
                        ?>
                        <div class="mcap-tab-pane <?php echo $is_active; ?>" data-tab="<?php echo esc_attr($index); ?>">
                            <div class="mcap-grid">
                                
                                <!-- Left: Hub Info -->
                                <div class="mcap-info">
                                    <?php if ( $hub_title ) : ?>
                                        <h3 class="mcap-hub-title"><?php echo esc_html($hub_title); ?></h3>
                                    <?php endif; ?>
                                    
                                    <?php if ( $hub_desc ) : ?>
                                        <div class="mcap-hub-desc"><?php echo wpautop($hub_desc); ?></div>
                                    <?php endif; ?>

                                    <!-- Highlights Grid -->
                                    <?php if ( $highlights ) : ?>
                                    <div class="mcap-highlights">
                                        <?php foreach ( $highlights as $hl ) : ?>
                                            <div class="mcap-card">
                                                <?php if ( $hl['tag'] ) : ?>
                                                    <span class="mcap-card-tag"><?php echo esc_html($hl['tag']); ?></span>
                                                <?php endif; ?>
                                                <div class="mcap-card-title"><?php echo esc_html($hl['title']); ?></div>
                                                <div class="mcap-card-value <?php echo $mcap_use_mono ? 'font-mono' : ''; ?>">
                                                    <?php echo esc_html($hl['value']); ?>
                                                    <?php if ( $hl['unit'] ) : ?>
                                                        <span class="unit"><?php echo esc_html($hl['unit']); ?></span>
                                                    <?php endif; ?>
                                                </div>
                                            </div>
                                        <?php endforeach; ?>
                                    </div>
                                    <?php endif; ?>

                                    <!-- Tags -->
                                    <?php if ( $finishing_tags ) : ?>
                                    <div class="mcap-tags">
                                        <?php foreach ( $finishing_tags as $tag ) : ?>
                                            <span class="mcap-tag"><?php echo esc_html($tag['text']); ?></span>
                                        <?php endif; ?>
                                    </div>
                                    <?php endif; ?>

                                    <!-- CTA -->
                                    <?php if ( $cta_link ) : ?>
                                        <a href="<?php echo esc_url($cta_link['url']); ?>" class="mcap-cta-btn" target="<?php echo esc_attr($cta_link['target'] ? $cta_link['target'] : '_self'); ?>">
                                            <?php echo esc_html($cta_link['title']); ?>
                                        </a>
                                    <?php endif; ?>
                                </div>

                                <!-- Right: Visual -->
                                <div class="mcap-visual">
                                    <?php if ( $image_id ) : ?>
                                        <picture>
                                            <?php if ( $mobile_image_id ) : ?>
                                                <source media="(max-width: 767px)" srcset="<?php echo wp_get_attachment_image_url($mobile_image_id, 'medium_large'); ?>">
                                            <?php endif; ?>
                                            <?php echo wp_get_attachment_image($image_id, 'large', false, array('class' => 'mcap-main-img')); ?>
                                        </picture>
                                    <?php endif; ?>
                                    
                                    <?php if ( $machine_model ) : ?>
                                        <div class="mcap-machine-tag">
                                            <span class="icon">⚙️</span>
                                            <span class="model"><?php echo esc_html($machine_model); ?></span>
                                        </div>
                                    <?php endif; ?>
                                </div>

                            </div>
                        </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            </section>
            <?php endif; ?>

            <?php
            /**
             * 5. CTA (Global)
             */
            $cta_template = locate_template( 'blocks/global/cta/render.php' );
            if ( $cta_template ) {
                include $cta_template;
            }
            ?>

        </article>

    <?php endwhile; ?>
</main>

<?php
get_footer();
