<?php
/**
 * Industry Slider Block 的渲染模板
 * 
 * 展示行业应用案例，支持基于当前工艺的自动内容筛选
 */
// Prefix Support
$pfx = isset($block['prefix']) ? $block['prefix'] : '';


$block = isset( $block ) ? $block : array();
$block_id = _3dp_get_safe_block_id( $block, 'industry-slider' );

// 从全局变量获取当前工艺信息
$current_capability = isset( $GLOBALS['current_capability'] ) ? $GLOBALS['current_capability'] : null;

// 万能取数逻辑
// 确定克隆名
$clone_name = rtrim($pfx, '_');

// Init variables
$industries = array();
$section_title = '';
$section_desc = '';
$pc_cols = 'grid-cols-4';
$mb_hide_teaser = false;
$has_industries = false;

if ( ! empty( $pfx ) ) {
    // Local / Page Builder Mode
    $section_title = get_field_value('title', $block, $clone_name, $pfx, '');
    $section_desc = get_field_value('desc', $block, $clone_name, $pfx, '');
    $industries = get_field_value('items', $block, $clone_name, $pfx, array());
    
    $pc_cols = get_field_value('pc_cols', $block, $clone_name, $pfx, 'grid-cols-4');
    $mb_hide_teaser = get_field_value('mb_hide_teaser', $block, $clone_name, $pfx, false);
} else {
    // Global Settings Mode
    $global_data = get_field('global_industry_slider', 'option');
    if ( $global_data ) {
        // Get the cloned fields from is_clone subarray
        $is_data = isset($global_data['is_clone']) ? $global_data['is_clone'] : $global_data;
        
        $section_title = isset($is_data['title']) ? $is_data['title'] : '';
        $section_desc = isset($is_data['desc']) ? $is_data['desc'] : '';
        
        $industries = isset($is_data['items']) ? $is_data['items'] : array();
        
        $pc_cols = isset($is_data['pc_cols']) ? $is_data['pc_cols'] : 4;
        $mb_hide_teaser = isset($is_data['mb_hide_teaser']) ? (bool)$is_data['mb_hide_teaser'] : false;
    }
}

// Fallback: If no industries found (Local or Global), try CPT
if ( empty( $industries ) ) {
    // 获取行业列表数据
    $args = array(
        'post_type' => 'industry',
        'posts_per_page' => -1,
        'orderby' => 'title',
        'order' => 'ASC'
    );
    
    $industry_query = new WP_Query( $args );
    
    if ( $industry_query->have_posts() ) {
        $industries = $industry_query->posts;
    } else {
        // Static Default Data (Last Resort)
        $industries = array(
            array(
                'name' => 'Aerospace',
                'image' => '',
                'tags' => array(
                    array('text' => 'End-use Parts', 'type' => 'blue'),
                    array('text' => 'Lightweight', 'type' => 'green')
                ),
                'teaser' => 'Production of complex internal ducting and UAV structural parts that require optimized strength-to-weight ratios.',
                'link' => array('url' => '#', 'title' => 'View Solution')
            ),
            array(
                'name' => 'Medical & Healthcare',
                'image' => '',
                'tags' => array(
                    array('text' => 'Custom Devices', 'type' => 'blue'),
                    array('text' => 'Biocompatible', 'type' => 'green')
                ),
                'teaser' => 'Biocompatible Nylon (PA12) solutions for customized prosthetics, surgical guides, and wearable orthotics.',
                'link' => array('url' => '#', 'title' => 'View Solution')
            ),
            array(
                'name' => 'Automotive Engineering',
                'image' => '',
                'tags' => array(
                    array('text' => 'Functional Protos', 'type' => 'blue'),
                    array('text' => 'Heat Resist', 'type' => 'green')
                ),
                'teaser' => 'High-impact functional testing prototypes and customized interior components with high thermal stability.',
                'link' => array('url' => '#', 'title' => 'View Solution')
            ),
            array(
                'name' => 'Industrial Tooling',
                'image' => '',
                'tags' => array(
                    array('text' => 'Production Tooling', 'type' => 'blue'),
                    array('text' => 'Durable', 'type' => 'green')
                ),
                'teaser' => 'On-demand production of jigs, fixtures, and end-of-arm tooling with integrated internal cooling channels.',
                'link' => array('url' => '#', 'title' => 'View Solution')
            ),
            array(
                'name' => 'Consumer Goods',
                'image' => '',
                'tags' => array(
                    array('text' => 'Batch Production', 'type' => 'blue'),
                    array('text' => 'Complex Geometry', 'type' => 'green')
                ),
                'teaser' => 'Mass customization for eyewear, sports equipment, and high-end lifestyle products with unique textures.',
                'link' => array('url' => '#', 'title' => 'View Solution')
            )
        );
    }
    wp_reset_postdata();
}

$has_industries = ! empty( $industries );

// 如果没有行业数据，不显示模块
if ( ! $has_industries ) {
    return;
} ?>

<style>
    /* --- 基于 Tailwind Config 的变量映射 --- */
    :root {
        --primary: #0047AB;
        --primary-hover: #003A8C;
        --heading: #1D2938;
        --body: #667085;
        --bg-section: #F2F4F7;
        --border: #E4E7EC;
        --radius-card: 12px;
        --radius-btn: 8px;
        --container-max: 1280px;
    }

    /* --- 头部布局：标题 + 描述 + 导航按钮 --- */
    .header-row {
        display: flex;
        justify-content: space-between;
        align-items: flex-end;
        margin-bottom: 48px;
    }
    .header-content { max-width: 720px; }
    .h2 { font-size: 36px; color: var(--heading); font-weight: 600; margin: 0 0 16px 0; }
    .section-desc { font-size: 18px; margin: 0; color: var(--body); }

    /* 滑动控制按钮 */
    .slider-nav { display: flex; gap: 12px; }
    .nav-btn {
        width: 48px;
        height: 48px;
        border-radius: 50%;
        border: 1px solid var(--border);
        background: #fff;
        color: var(--heading);
        cursor: pointer;
        display: flex;
        align-items: center;
        justify-content: center;
        transition: all 0.2s;
    }
    .nav-btn:hover { border-color: var(--primary); color: var(--primary); background: #F9FAFB; }

    /* --- Slider 核心容器 --- */
    .slider-wrapper { margin: 0 -12px; overflow: hidden; }
    .slider-track {
        display: flex;
        gap: 24px;
        overflow-x: auto;
        padding: 10px 12px 40px 12px;
        scroll-behavior: smooth;
        scrollbar-width: none; /* 隐藏滚动条 */
        scroll-snap-type: x mandatory;
    }
    .slider-track::-webkit-scrollbar { display: none; }

    /* --- 行业卡片 (Application Card) --- */
    .app-card {
        flex: 0 0 calc(25% - 18px); /* 默认一屏显示4个 */
        min-width: 300px;
        scroll-snap-align: start;
        background: #fff;
        border: 1px solid var(--border);
        border-radius: var(--radius-card);
        text-decoration: none;
        color: inherit;
        display: flex;
        flex-direction: column;
        transition: all 0.3s ease;
    }
    .app-card:hover {
        transform: translateY(-8px);
        box-shadow: 0 12px 24px rgba(16, 24, 40, 0.08);
        border-color: var(--primary);
    }

    /* 图片视觉区 */
    .app-visual { 
        height: 220px; 
        background-color: var(--bg-section); 
        overflow: hidden;
        border-top-left-radius: var(--radius-card);
        border-top-right-radius: var(--radius-card);
    }
    .app-visual img { width: 100%; height: 100%; object-fit: cover; transition: transform 0.5s ease; }
    .app-card:hover .app-visual img { transform: scale(1.05); }

    /* 内容区 */
    .app-body { padding: 32px; flex-grow: 1; display: flex; flex-direction: column; }

    /* 技术标签 (Tags) - 增强专业感 */
    .tag-row { display: flex; gap: 8px; margin-bottom: 16px; }
    .tag {
        font-size: 11px;
        font-weight: 700;
        padding: 4px 10px;
        border-radius: 4px;
        text-transform: uppercase;
    }
    .tag-usage { background: #E0EAFF; color: #0047AB; } /* 用途标签 */
    .tag-feature { background: #ECFDF3; color: #027A48; } /* 性能标签 */

    .h4 { font-size: 20px; color: var(--heading); margin: 0 0 12px 0; font-weight: 600; }
    .app-desc { font-size: 15px; line-height: 1.6; color: var(--body); margin-bottom: 24px; flex-grow: 1; }

    /* 转化链接 */
    .app-link {
        font-size: 14px;
        font-weight: 600;
        color: var(--primary);
        display: inline-flex;
        align-items: center;
    }
    .app-link::after { content: ' →'; margin-left: 4px; transition: margin 0.2s; }
    .app-card:hover .app-link::after { margin-left: 8px; }

    /* 响应式调整 */
    @media (max-width: 1024px) {
        .app-card {
            flex: 0 0 calc(33.333% - 16px); /* 平板显示3个 */
        }
    }
    
    @media (max-width: 768px) {
        .app-card {
            flex: 0 0 calc(50% - 12px); /* 手机显示2个 */
        }
        
        .header-row {
            flex-direction: column;
            align-items: flex-start;
            gap: 24px;
        }
        
        .slider-nav {
            align-self: flex-end;
        }
    }
    
    @media (max-width: 480px) {
        .app-card {
            flex: 0 0 100%; /* 小屏幕显示1个 */
        }
    }
</style>

<section class="industry-slider-block py-[96px]">
    <div class="max-w-[1280px] mx-auto px-6 lg:px-[24px]">
        <div class="header-row">
            <div class="header-content">
                <?php if ( $section_title ) : ?>
                    <h2 class="h2"><?php echo esc_html( $section_title ); ?></h2>
                <?php endif; ?>
                <?php if ( $section_desc ) : ?>
                    <p class="section-desc"><?php echo esc_html( $section_desc ); ?></p>
                <?php endif; ?>
            </div>
            <div class="slider-nav">
                <button class="nav-btn" onclick="document.querySelector('.slider-track').scrollBy({left: -320, behavior: 'smooth'})">❮</button>
                <button class="nav-btn" onclick="document.querySelector('.slider-track').scrollBy({left: 320, behavior: 'smooth'})">❯</button>
            </div>
        </div>

        <div class="slider-wrapper">
            <div class="slider-track">
                <?php foreach ( $industries as $industry ) : ?>
                    <?php 
                    // 处理不同数据结构
                    if ( is_array( $industry ) ) {
                        // 数组结构（默认数据或选项页数据）
                        $industry_name = isset( $industry['name'] ) ? $industry['name'] : '';
                        $industry_image = isset( $industry['image'] ) ? $industry['image'] : '';
                        $industry_tags = isset( $industry['tags'] ) ? $industry['tags'] : array();
                        $industry_teaser = isset( $industry['teaser'] ) ? $industry['teaser'] : '';
                        $industry_link = isset( $industry['link'] ) ? $industry['link'] : array('url' => '#', 'title' => 'View Solution');
                    } else {
                        // CPT结构
                        $industry_id = $industry->ID;
                        $industry_name = get_the_title( $industry_id );
                        $industry_image = get_field($pfx . 'industry_image', $industry_id );
                        $industry_tags = get_field($pfx . 'industry_tags', $industry_id ) ?: array();
                        $industry_teaser = get_field($pfx . 'industry_teaser', $industry_id ) ?: '';
                        $industry_link = get_field($pfx . 'industry_link', $industry_id ) ?: array('url' => get_permalink( $industry_id ), 'title' => 'View Solution');
                    }
                    
                    // 如果是当前工艺相关的行业，添加高亮类
                    $is_current_industry = false;
                    if ( $current_capability && ! empty( $current_capability['title'] ) ) {
                        // 可以在这里添加更复杂的匹配逻辑
                    }
                    
                    // 获取链接URL和标题
                    $link_url = isset( $industry_link['url'] ) ? $industry_link['url'] : '#';
                    $link_title = isset( $industry_link['title'] ) ? $industry_link['title'] : 'View Solution';
                    $link_target = isset( $industry_link['target'] ) ? $industry_link['target'] : '';
                    ?>
                    
                    <a href="<?php echo esc_url( $link_url ); ?>" 
                       class="app-card <?php if ( $is_current_industry ) echo 'current-industry'; ?>"
                       <?php if ( $link_target ) echo 'target="' . esc_attr( $link_target ) . '"'; ?>>
                        <?php if ( $industry_image ) : ?>
                            <div class="app-visual">
                                <?php echo wp_get_attachment_image( $industry_image, 'medium', false, array('class' => 'w-full h-full object-cover') ); ?>
                            </div>
                        <?php else : ?>
                            <div class="app-visual">
                                <img src="https://placehold.co/600x400/F2F4F7/1D2939?text=<?php echo urlencode( $industry_name ); ?>" alt="<?php echo esc_attr( $industry_name ); ?>">
                            </div>
                        <?php endif; ?>
                        
                        <div class="app-body">
                            <?php if ( ! empty( $industry_tags ) ) : ?>
                                <div class="tag-row">
                                    <?php foreach ( $industry_tags as $tag ) : ?>
                                        <?php 
                                        $tag_text = is_array( $tag ) ? ( isset( $tag['text'] ) ? $tag['text'] : '' ) : $tag->text;
                                        $tag_type = is_array( $tag ) ? ( isset( $tag['type'] ) ? $tag['type'] : 'usage' ) : $tag->type;
                                        $tag_class = $tag_type === 'green' ? 'tag-feature' : 'tag-usage';
                                        ?>
                                        <span class="tag <?php echo esc_attr( $tag_class ); ?>">
                                            <?php echo esc_html( $tag_text ); ?>
                                        </span>
                                    <?php endforeach; ?>
                                </div>
                            <?php endif; ?>
                            
                            <h4 class="h4"><?php echo esc_html( $industry_name ); ?></h4>
                            
                            <?php if ( $industry_teaser && ! $mb_hide_teaser ) : ?>
                                <p class="app-desc"><?php echo esc_html( $industry_teaser ); ?></p>
                            <?php endif; ?>
                            
                            <span class="app-link"><?php echo esc_html( $link_title ); ?></span>
                        </div>
                    </a>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
</section>