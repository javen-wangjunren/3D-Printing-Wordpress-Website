<?php
/**
 * Template Part: FAQ Module
 * --------------------------------------------------------------------------
 * Path: template-parts/components/faq.php
 * Style: Industrial 4.0 Aesthetic
 * Data: ACF Clone (Seamless)
 * --------------------------------------------------------------------------
 */

// 1. 数据解构 (Data Scope)
// 注意：由于是作为 Clone 使用，外部调用时会传入 $args['prefix']
$prefix = isset($args['prefix']) ? $args['prefix'] : '';
$data   = get_field($prefix);

// 如果没有数据或 Repeater 为空，则不渲染模块 (空状态判断)
if ( empty($data) || empty($data['faq_items']) ) {
    return;
}

// 提取变量
$title = isset($data['faq_title']) ? $data['faq_title'] : '';
$desc  = isset($data['faq_desc']) ? $data['faq_desc'] : '';
$link  = isset($data['faq_link']) ? $data['faq_link'] : null;
$items = $data['faq_items'];
?>

<!-- FAQ Section -->
<section class="py-24 px-6 md:px-12 lg:px-24 max-w-7xl mx-auto overflow-hidden bg-[#f3f4f7]">
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-16 items-start">
        
        <!-- Left Column: Intro -->
        <div class="lg:col-span-4 space-y-8">
            <div class="space-y-4">
                <?php if ( $title ) : ?>
                    <h2 class="text-4xl md:text-5xl font-bold text-industrial leading-[1.1] tracking-tight">
                        <?php echo wp_kses_post( $title ); ?>
                    </h2>
                <?php endif; ?>
            </div>
            
            <div class="pt-6 border-t border-border">
                <?php if ( $desc ) : ?>
                    <p class="text-lg text-body leading-relaxed mb-8">
                        <?php echo wp_kses_post( $desc ); ?>
                    </p>
                <?php endif; ?>
                
                <?php if ( $link ) : ?>
                    <a href="<?php echo esc_url( $link['url'] ); ?>" 
                       target="<?php echo esc_attr( $link['target'] ?: '_self' ); ?>"
                       class="inline-flex items-center space-x-3 px-8 py-4 bg-industrial text-white rounded-full hover:bg-primary transition-all duration-300 group">
                        <span class="font-medium"><?php echo esc_html( $link['title'] ); ?></span>
                        <svg class="w-5 h-5 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path>
                        </svg>
                    </a>
                <?php endif; ?>
            </div>
        </div>

        <!-- Right Column: Accordion Matrix -->
        <div class="lg:col-span-8 space-y-4" x-data="{ active: 1 }">
            
            <?php foreach ( $items as $index => $item ) : 
                $i = $index + 1; // 用于 Alpine.js 的索引
                $q = $item['question'];
                $a = $item['answer'];
                if ( empty($q) || empty($a) ) continue;
            ?>
                <!-- FAQ Item <?php echo $i; ?> -->
                <div class="faq-accordion-item group border bg-white rounded-card transition-all duration-500"
                    :class="active === <?php echo $i; ?> ? 'border-primary border-[3px] shadow-lg ring-1 ring-primary/10' : 'border-border hover:border-border-strong shadow-sm'">
                    
                    <button @click="active = (active === <?php echo $i; ?> ? null : <?php echo $i; ?>)" 
                            class="w-full flex items-center justify-between p-6 md:p-8 text-left focus:outline-none"
                            aria-expanded="active === <?php echo $i; ?>">
                        <span class="text-xl font-bold text-heading tracking-tight">
                            <?php echo esc_html( $q ); ?>
                        </span>
                        <div class="flex-shrink-0 ml-4">
                            <div class="w-10 h-10 rounded-full bg-slate-50 flex items-center justify-center border border-border group-hover:border-primary/30 transition-colors"
                                 :class="active === <?php echo $i; ?> ? 'bg-primary/5 border-primary/20' : ''">
                                <svg class="w-5 h-5 text-industrial transition-transform duration-500" 
                                     :class="active === <?php echo $i; ?> ? 'rotate-45 text-primary' : ''"
                                     fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 6v12M6 12h12"></path>
                                </svg>
                            </div>
                        </div>
                    </button>

                    <div x-show="active === <?php echo $i; ?>" 
                         x-collapse.duration.500ms
                         x-cloak
                         class="px-6 md:px-8 pb-8">
                        <div class="text-body leading-relaxed max-w-2xl text-lg">
                            <?php echo wp_kses_post( $a ); ?>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>

        </div>
    </div>
</section>

<style>
    /* 
     * 针对手风琴展开时的物理反馈微调 
     * 虽然 Tailwind 可以处理大部分，但这里确保 cubic-bezier 阻尼感一致
     */
    .faq-accordion-item {
        transition-timing-function: cubic-bezier(0.4, 0, 0.2, 1);
    }
</style>
