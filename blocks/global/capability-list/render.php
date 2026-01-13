<?php
/**
 * Capability List Block 的渲染模板
 * 
 * 展示所有制造工艺，支持标签切换，显示工艺详情和可用材料
 */

// 获取当前模块的ACF字段数据
$section_title = get_field('section_title') ?: 'Manufacturing Capabilities';
$section_description = get_field('section_description') ?: 'Six industrial technologies optimized for prototyping and scalable production.';
$capabilities = get_field('capabilities') ?: array();
$bg_color = get_field('bg_color') ?: '#ffffff';
$text_color = get_field('text_color') ?: '#667085';
$accent_color = get_field('accent_color') ?: '#0047AB';
$anchor_id = get_field('anchor_id') ? 'id="' . esc_attr(get_field('anchor_id')) . '"' : '';

// 如果没有工艺数据，不显示模块
if (empty($capabilities)) {
    return;
}

// 计算第一个工艺的ID，用于默认显示
$first_capability_id = $capabilities[0]['capability_id'] ?? '';
?>

<section <?php echo $anchor_id; ?> class="capability-list-block" style="background-color: <?php echo esc_attr($bg_color); ?>; color: <?php echo esc_attr($text_color); ?>">
    <div class="container">
        <div class="section-header">
            <h2 class="h2" style="color: var(--heading);"><?php echo esc_html($section_title); ?></h2>
            <p class="section-desc" style="color: <?php echo esc_attr($text_color); ?>"><?php echo esc_html($section_description); ?></p>
        </div>

        <div class="tabs-nav">
            <?php foreach ($capabilities as $capability) : ?>
                <?php 
                $capability_id = $capability['capability_id'] ?? '';
                $capability_name = $capability['name'] ?? '';
                $capability_short = $capability['short_name'] ?? '';
                $is_active = ($capability_id === $first_capability_id) ? 'active' : '';
                
                if (empty($capability_id) || empty($capability_name)) continue;
                ?>
                <button class="tab-btn <?php echo esc_attr($is_active); ?>" onclick="showCapabilityTab('<?php echo esc_attr($capability_id); ?>')" style="--accent-color: <?php echo esc_attr($accent_color); ?>">
                    <?php echo esc_html($capability_name); ?><?php if (!empty($capability_short)) : ?> (<?php echo esc_html($capability_short); ?>)<?php endif; ?>
                </button>
            <?php endforeach; ?>
        </div>

        <?php foreach ($capabilities as $capability) : ?>
            <?php 
            $capability_id = $capability['capability_id'] ?? '';
            $capability_name = $capability['name'] ?? '';
            $capability_desc = $capability['description'] ?? '';
            $capability_specs = $capability['specs'] ?? array();
            $capability_materials = $capability['materials'] ?? array();
            $capability_equipment = $capability['equipment'] ?? '';
            $capability_image = $capability['image'] ?? '';
            $capability_quote_link = $capability['quote_link'] ?? array();
            $capability_detail_link = $capability['detail_link'] ?? array();
            $is_active = ($capability_id === $first_capability_id) ? 'active' : '';
            
            if (empty($capability_id) || empty($capability_name)) continue;
            ?>

            <div id="<?php echo esc_attr($capability_id); ?>" class="capability-panel <?php echo esc_attr($is_active); ?>">
                <div class="info-col">
                    <h3 class="h3" style="color: var(--heading);"><?php echo esc_html($capability_name); ?></h3>
                    <p class="desc" style="color: <?php echo esc_attr($text_color); ?>"><?php echo esc_html($capability_desc); ?></p>
                    
                    <?php if (!empty($capability_specs)) : ?>
                        <div class="specs-grid">
                            <?php if (!empty($capability_specs['build_volume'])) : ?>
                                <div class="spec-item">
                                    <span class="spec-label">Build Volume</span>
                                    <span class="spec-value" style="color: var(--heading);"><?php echo esc_html($capability_specs['build_volume']); ?></span>
                                </div>
                            <?php endif; ?>
                            <?php if (!empty($capability_specs['layer_height'])) : ?>
                                <div class="spec-item">
                                    <span class="spec-label">Layer Height</span>
                                    <span class="spec-value" style="color: var(--heading);"><?php echo esc_html($capability_specs['layer_height']); ?></span>
                                </div>
                            <?php endif; ?>
                            <?php if (!empty($capability_specs['tolerance'])) : ?>
                                <div class="spec-item">
                                    <span class="spec-label">Tolerance</span>
                                    <span class="spec-value" style="color: var(--heading);"><?php echo esc_html($capability_specs['tolerance']); ?></span>
                                </div>
                            <?php endif; ?>
                            <?php if (!empty($capability_specs['lead_time'])) : ?>
                                <div class="spec-item">
                                    <span class="spec-label">Lead Time</span>
                                    <span class="spec-value" style="color: var(--heading);"><?php echo esc_html($capability_specs['lead_time']); ?></span>
                                </div>
                            <?php endif; ?>
                        </div>
                    <?php endif; ?>

                    <?php if (!empty($capability_materials)) : ?>
                        <div class="materials-box">
                            <div class="tag-title">Available Materials</div>
                            <div class="tags-wrapper">
                                <?php foreach ($capability_materials as $material) : ?>
                                    <?php if ($material instanceof WP_Post) : ?>
                                        <a href="<?php echo esc_url(get_permalink($material->ID)); ?>" class="material-tag" style="color: var(--heading);">
                                            <?php echo esc_html(get_the_title($material->ID)); ?>
                                        </a>
                                    <?php endif; ?>
                                <?php endforeach; ?>
                            </div>
                        </div>
                    <?php endif; ?>

                    <div class="btn-group">
                        <?php if (!empty($capability_quote_link['url'])) : ?>
                            <a href="<?php echo esc_url($capability_quote_link['url']); ?>" 
                               class="btn btn-primary" 
                               style="background-color: <?php echo esc_attr($accent_color); ?>;" 
                               <?php if (!empty($capability_quote_link['target'])) : ?>target="<?php echo esc_attr($capability_quote_link['target']); ?>"<?php endif; ?>>
                                <?php echo esc_html($capability_quote_link['title']); ?>
                            </a>
                        <?php endif; ?>
                        <?php if (!empty($capability_detail_link['url'])) : ?>
                            <a href="<?php echo esc_url($capability_detail_link['url']); ?>" 
                               class="btn btn-outline" 
                               style="color: var(--heading); border-color: var(--border);" 
                               <?php if (!empty($capability_detail_link['target'])) : ?>target="<?php echo esc_attr($capability_detail_link['target']); ?>"<?php endif; ?>>
                                <?php echo esc_html($capability_detail_link['title']); ?>
                            </a>
                        <?php endif; ?>
                    </div>
                </div>
                
                <div class="visual-col">
                    <?php if (!empty($capability_image)) : ?>
                        <?php echo wp_get_attachment_image($capability_image, 'large', false, array('alt' => esc_attr($capability_name))); ?>
                    <?php else : ?>
                        <div class="placeholder-image" style="background-color: #F2F4F7; width: 100%; height: 500px; display: flex; align-items: center; justify-content: center; color: #1D2939; font-size: 18px; font-weight: bold;">
                            <?php echo esc_html($capability_name); ?>
                        </div>
                    <?php endif; ?>
                    <?php if (!empty($capability_equipment)) : ?>
                        <div class="machine-label">EQUIPMENT: <?php echo esc_html($capability_equipment); ?></div>
                    <?php endif; ?>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</section>

<style>
    /* --- 变量注入 --- */
    :root {
        --primary: <?php echo esc_attr($accent_color); ?>;
        --heading: #1D2938;
        --body: <?php echo esc_attr($text_color); ?>;
        --border: #E4E7EC;
        --bg-section: #F2F4F7;
        --radius-card: 12px;
        --radius-btn: 8px;
        --container-max: 1280px;
    }

    /* --- 基础样式 --- */
    .capability-list-block {
        padding: 96px 0;
    }
    .container {
        max-width: var(--container-max);
        margin: 0 auto;
        padding: 0 24px;
        box-sizing: border-box;
    }

    .section-header {
        text-align: center;
        margin-bottom: 48px;
    }
    .h2 {
        font-size: 36px;
        font-weight: 700;
        margin: 0 0 16px 0;
        letter-spacing: -0.5px;
    }
    .section-desc {
        font-size: 16px;
        line-height: 1.6;
        margin: 0;
    }

    /* --- Tab 切换器逻辑 --- */
    .tabs-nav {
        display: flex;
        justify-content: center;
        gap: 12px;
        margin-bottom: 40px;
        overflow-x: auto;
        padding-bottom: 8px;
        scrollbar-width: none;
    }
    .tabs-nav::-webkit-scrollbar { display: none; }

    .tab-btn {
        padding: 10px 24px;
        background: var(--bg-section);
        border: 1px solid transparent;
        border-radius: 30px;
        color: var(--body);
        font-size: 14px;
        font-weight: 600;
        cursor: pointer;
        white-space: nowrap;
        transition: all 0.2s;
    }
    .tab-btn.active {
        background: var(--primary);
        color: #fff;
        border-color: var(--primary);
    }

    /* --- 主面板容器 --- */
    .capability-panel {
        display: none;
        grid-template-columns: 1.2fr 1fr;
        gap: 64px;
        align-items: center;
        animation: fadeUp 0.4s ease-out;
    }
    .capability-panel.active { display: grid; }

    /* 左侧内容区 */
    .info-col { display: flex; flex-direction: column; }
    .h3 { font-size: 28px; margin: 0 0 20px 0; font-weight: 700; }
    .desc { font-size: 16px; line-height: 1.6; margin-bottom: 32px; }

    /* 参数仪表盘 (Metrics Grid) */
    .specs-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 24px;
        margin-bottom: 40px;
        padding-top: 32px;
        border-top: 1px solid var(--border);
    }
    .spec-item { display: flex; flex-direction: column; }
    .spec-label { font-size: 12px; color: var(--body); text-transform: uppercase; letter-spacing: 1px; margin-bottom: 4px; }
    .spec-value {
        font-family: 'JetBrains Mono', monospace;
        font-size: 18px;
        font-weight: 700;
    }

    /* 材料标签云 */
    .materials-box { margin-bottom: 40px; }
    .tag-title { font-size: 11px; font-weight: 700; color: var(--body); text-transform: uppercase; margin-bottom: 12px; }
    .tags-wrapper { display: flex; flex-wrap: wrap; gap: 8px; }
    .material-tag {
        background: var(--bg-section);
        padding: 4px 12px;
        border-radius: 4px;
        font-size: 12px;
        font-weight: 600;
        text-decoration: none;
        transition: all 0.2s;
    }
    .material-tag:hover {
        background: var(--primary);
        color: #fff !important;
    }

    /* 按钮组 */
    .btn-group { display: flex; gap: 16px; }
    .btn {
        padding: 14px 28px;
        border-radius: var(--radius-btn);
        font-size: 15px;
        font-weight: 600;
        text-decoration: none;
        transition: all 0.2s;
        display: inline-block;
        border: none;
        cursor: pointer;
        text-align: center;
    }
    .btn-primary:hover {
        opacity: 0.9;
    }
    .btn-outline {
        background-color: transparent;
        transition: all 0.2s;
    }
    .btn-outline:hover {
        border-color: var(--primary) !important;
        color: var(--primary) !important;
    }

    /* 右侧视觉区 */
    .visual-col { position: relative; border-radius: var(--radius-card); overflow: hidden; background: var(--bg-section); }
    .visual-col img { width: 100%; height: auto; display: block; }
    .machine-label {
        position: absolute; bottom: 20px; right: 20px;
        background: rgba(255,255,255,0.8); backdrop-filter: blur(4px);
        padding: 6px 12px; border-radius: 4px; font-size: 11px; font-weight: 700;
        color: var(--heading); border: 1px solid var(--border);
    }

    /* 动画 */
    @keyframes fadeUp { from { opacity: 0; transform: translateY(20px); } to { opacity: 1; transform: translateY(0); } }

    /* --- 移动端自适应 --- */
    @media (max-width: 900px) {
        .capability-panel { grid-template-columns: 1fr; gap: 40px; }
        .tabs-nav { justify-content: flex-start; padding-left: 0; }
        .visual-col { order: -1; }
        .btn-group { flex-direction: column; }
        .btn { text-align: center; }
    }
</style>

<script>
    function showCapabilityTab(id) {
        // 移除所有按钮的 active 类
        document.querySelectorAll('.capability-list-block .tab-btn').forEach(btn => btn.classList.remove('active'));
        // 隐藏所有面板
        document.querySelectorAll('.capability-list-block .capability-panel').forEach(panel => panel.classList.remove('active'));
        
        // 激活当前按钮和面板
        const eventTarget = event.currentTarget;
        if (eventTarget) {
            eventTarget.classList.add('active');
        } else {
            // 如果没有eventTarget（比如通过其他方式调用），找到对应按钮
            const activeBtn = document.querySelector('.capability-list-block .tab-btn[onclick*="' + id + '"]');
            if (activeBtn) {
                activeBtn.classList.add('active');
            }
        }
        const activePanel = document.getElementById(id);
        if (activePanel) {
            activePanel.classList.add('active');
        }
    }
</script>
