<?php
/**
 * The template for displaying the footer.
 *
 * Contains the closing of the #content div and all content after.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package GeneratePress_Child
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

 $left_info = get_field( 'footer_left_info', 'option' );
 $social_links = get_field( 'footer_social_links', 'option' );
 $copyright_text = get_field( 'footer_copyright', 'option' );

 $logo_id = 0;
 $description = '';
 $address = '';

 if ( is_array( $left_info ) ) {
	 $logo_id = isset( $left_info['logo_image'] ) ? (int) $left_info['logo_image'] : 0;
	 $description = isset( $left_info['description'] ) ? $left_info['description'] : '';
	 $address = isset( $left_info['address'] ) ? $left_info['address'] : '';
 }

?>

	</div><!-- #content -->
</div><!-- #page -->

<!-- 
    Site Footer 
    基于 design-preview/footer.html 重构
    Tailwind 类保持原样，逻辑部分替换为 WordPress 动态数据
-->
<footer class="bg-white border-t border-border mt-20 tdp-site-footer">
	<div class="mx-auto max-w-container px-container py-section-y-small lg:py-section-y">
        
        <div class="xl:grid xl:grid-cols-3 xl:gap-8">
            
			<div class="space-y-8">
				<div class="flex items-center gap-2">
					<?php if ( $logo_id ) : ?>
						<?php echo wp_get_attachment_image( $logo_id, 'full', false, array( 'class' => 'h-8 w-auto' ) ); ?>
					<?php else : ?>
						<span class="text-heading font-bold text-xl tracking-tighter uppercase"><?php echo esc_html( get_bloginfo( 'name' ) ); ?></span>
					<?php endif; ?>
				</div>
                
				<?php if ( $description ) : ?>
				<p class="text-body text-small leading-6 max-w-xs">
					<?php echo nl2br( esc_html( $description ) ); ?>
				</p>
				<?php endif; ?>

				<?php if ( $address ) : ?>
				<p class="text-muted text-xs leading-5 max-w-xs mt-4 font-mono">
					<?php echo nl2br( esc_html( $address ) ); ?>
				</p>
				<?php endif; ?>

                <!-- Social Links -->
                <?php if ( $social_links ) : ?>
                <div class="flex gap-x-6">
                    <?php foreach ( $social_links as $link ) : 
                        $url = $link['url'];
                        $icon = $link['icon_svg'];
                        $name = $link['name'];
                        if ( ! $url ) continue;
                    ?>
                    <a href="<?php echo esc_url( $url ); ?>" class="text-muted hover:text-primary transition-colors" aria-label="<?php echo esc_attr( $name ); ?>">
                        <?php 
                            // 输出 SVG (允许原生 HTML - 仅管理员可编辑 ACF 选项)
                            if ( $icon ) {
                                echo $icon; 
                            } else {
                                // Fallback icon (Generic Link)
                                echo '<svg class="h-6 w-6" fill="currentColor" viewBox="0 0 24 24"><path d="M12 0c-6.627 0-12 5.373-12 12s5.373 12 12 12 12-5.373 12-12-5.373-12-12-12zm0 22c-5.523 0-10-4.477-10-10s4.477-10 10-10 10 4.477 10 10-4.477 10-10 10z"/></svg>';
                            }
                        ?>
                    </a>
                    <?php endforeach; ?>
                </div>
                <?php endif; ?>
            </div>

            <!-- 右侧菜单区域 (Right Columns) -->
            <div class="mt-16 grid grid-cols-2 gap-8 xl:col-span-2 xl:mt-0">
                
                <!-- Group 1: Capabilities & Materials -->
                <div class="md:grid md:grid-cols-2 md:gap-8">
                    
                    <!-- Capabilities Menu -->
                    <div>
                        <h3 class="text-[11px] font-bold text-heading uppercase tracking-[1.5px] mb-6">Capabilities</h3>
					<?php
					wp_nav_menu( array(
						'theme_location' => 'footer_capabilities',
						'container'      => false,
						'menu_class'     => 'space-y-4 text-small',
						'items_wrap'     => '<ul id="%1$s" class="%2$s" role="list">%3$s</ul>',
						'fallback_cb'    => false,
					) );
					?>
                    </div>

                    <!-- Materials Menu -->
                    <div class="mt-10 md:mt-0">
                        <h3 class="text-[11px] font-bold text-heading uppercase tracking-[1.5px] mb-6">Materials</h3>
					<?php
					wp_nav_menu( array(
						'theme_location' => 'footer_materials',
						'container'      => false,
						'menu_class'     => 'space-y-4 text-small',
						'items_wrap'     => '<ul id="%1$s" class="%2$s" role="list">%3$s</ul>',
						'fallback_cb'    => false,
					) );
					?>
                    </div>
                </div>

                <!-- Group 2: Resources & Company -->
                <div class="md:grid md:grid-cols-2 md:gap-8">
                    
                    <!-- Resources Menu -->
                    <div>
                        <h3 class="text-[11px] font-bold text-heading uppercase tracking-[1.5px] mb-6">Resources</h3>
					<?php
					wp_nav_menu( array(
						'theme_location' => 'footer_resources',
						'container'      => false,
						'menu_class'     => 'space-y-4 text-small',
						'items_wrap'     => '<ul id="%1$s" class="%2$s" role="list">%3$s</ul>',
						'fallback_cb'    => false,
					) );
					?>
                    </div>

                    <!-- Company Menu -->
                    <div class="mt-10 md:mt-0">
                        <h3 class="text-[11px] font-bold text-heading uppercase tracking-[1.5px] mb-6">Company</h3>
					<?php
					wp_nav_menu( array(
						'theme_location' => 'footer_company',
						'container'      => false,
						'menu_class'     => 'space-y-4 text-small',
						'items_wrap'     => '<ul id="%1$s" class="%2$s" role="list">%3$s</ul>',
						'fallback_cb'    => false,
					) );
					?>
                    </div>
                </div>

            </div>
        </div>

        <!-- 底部版权 (Bottom Bar) -->
        <div class="mt-16 border-t border-border pt-8 lg:mt-24">
            <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
                <p class="text-[12px] font-mono text-muted tracking-tight"> 
                    <?php 
                        if ( $copyright_text ) {
                            // 支持 {year} 占位符
                            $copyright_text = str_replace( '{year}', date( 'Y' ), $copyright_text );
                            echo esc_html( $copyright_text );
                        } else {
                            echo '&copy; ' . date('Y') . ' ' . get_bloginfo( 'name' ) . '. ALL RIGHTS RESERVED.';
                        }
                    ?>
                </p>
                <!-- 预留：如果有底部额外链接（隐私政策等），可以再开一个 Menu 位置，或者直接写死 -->
            </div>
        </div>
    </div>
</footer>

<?php wp_footer(); ?>
</body>
</html>
