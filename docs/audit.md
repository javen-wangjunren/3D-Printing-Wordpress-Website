# 🚀 System Audit & Performance Optimization Report

> **Date:** 2026-01-22  
> **Scope:** Theme Optimization, Performance, SEO, Security  
> **Theme:** GeneratePress Child (Headless-like Architecture)

---

## 1. 性能优化架构 (Performance)

### 🖼️ 图片加载策略 (Image Loading Strategy)
我们实施了严格的分级加载策略，以平衡 LCP (Largest Contentful Paint) 与带宽消耗。

*   **首屏 (Above-the-Fold):**
    *   **策略:** 强制使用 `loading="eager"`。
    *   **实现:** Logo (`header.php`) 和 Hero Banner (`blocks/global/hero-banner/render.php`) 中的主图已硬编码此属性。
    *   **目的:** 消除首屏图片的加载延迟，显著提升 LCP 分数。
*   **非首屏 (Below-the-Fold):**
    *   **策略:** 全面应用 `loading="lazy"`。
    *   **实现:** 审计了 `blocks/global/` 下的所有 `render.php`，确保所有非首屏 `<img>` 标签及 `wp_get_attachment_image()` 调用均包含此属性。

### 🧹 资源按需加载 (Asset Debloating)
为了实现极致的加载速度，我们对 WordPress 核心资源进行了外科手术式的精简 (`inc/setup.php`)。

*   **Gutenberg CSS (`wp-block-library`):**
    *   **逻辑:** 在全定制页面模板 (如 `page-home.php`, `single-capability.php`) 中**彻底移除**。仅在普通 Blog Post 中保留以确保兼容性。
*   **Global Styles (`global-styles`):**
    *   **逻辑:** 移除 `theme.json` 生成的内联样式与 SVG 预设，完全依赖 Tailwind CSS。
*   **Emoji 脚本:**
    *   **逻辑:** 在 `inc/assets.php` 中完全禁用 (`print_emoji_detection_script`)，减少无用的 JS 执行。

### ⚡ 预连接与字体优化 (Preconnect & Fonts)
*   **Preconnect:** 在 `header.php` 中配置了 `<link rel="preconnect">` 指向 `fonts.googleapis.com` 和 `fonts.gstatic.com`，加速字体握手。
    *   *CDN 预留:* 已在代码注释中预留了 `<link rel="preconnect" href="https://cdn.yourdomain.com">` 位置。
*   **Font Display:** 加载 Google Fonts (Inter + JetBrains Mono) 时强制添加 `&display=swap` 参数 (`inc/assets.php`)，防止文字隐形 (FOIT)。

---

## 2. SEO 与安全性 (SEO & Security)

### 🛡️ 安全性过滤
*   **链接安全:** 所有输出到 href 的 URL 严格使用 `esc_url()` 转义。
*   **HTML 输出:** 动态文本使用 `esc_html()` 或 `wp_kses_post()` (针对富文本)。

### 📏 CLS 优化 (Cumulative Layout Shift)
*   **强制尺寸:** 所有动态图片必须包含 `width` 和 `height` 属性。
*   **实现机制:**
    *   ACF 图片字段必须返回 **Image ID** 或 **Image Array**。
    *   使用 `wp_get_attachment_image_src()` 获取精确的物理尺寸数据。
    *   严禁使用仅返回 URL 的方式，这会导致浏览器无法预留布局空间。

### 🔍 SEO 结构
*   **H1 唯一性:** 禁用了 GeneratePress 默认标题 (`generate_show_title` filter)，由各个 Block (Hero Banner) 独立控制 H1，确保页面有且仅有一个 H1。
*   **Meta Viewport:** 标准化配置 `<meta name="viewport" content="width=device-width, initial-scale=1">` 确保移动端渲染正确。
*   **SEOPress 集成:** 
    *   标准化 `wp_head()` 挂载点。
    *   在 `inc/seo.php` 中集成了 Breadcrumbs (面包屑) 逻辑，自动适配 SEOPress/Yoast/RankMath。

---

## 3. 代码规范与维护 (Maintenance)

### 🛠️ 核心助手函数: `get_field_value`
位于 `inc/helpers.php`，用于统一处理 ACF 数据的读取，解决了 Block 与 Clone Field 的数据层级混乱问题。

**处理规则 (优先级从高到低):**
1.  **Group 嵌套:** `$block[$clone_name]['field_name']` (ACF Clone Group 模式)
2.  **直接属性:** `$block['field_name']` (非 Clone 模式)
3.  **数据库回退:** `get_field($pfx . 'field_name')` (标准 Post Meta)

**前缀 ($pfx) 规范:**
*   所有 Clone Field 建议设置 `prefix_name => 1`。
*   调用时传入 `$pfx` (如 `hero_`) 以避免元数据键名冲突 (如多个模块都有 `title` 字段)。

### 🤖 自动化审计脚本
我们编写了 Python 脚本用于批量扫描代码库中的潜在问题。

*   **脚本名称:** `verify_img_attributes.py`
*   **用途:** 扫描 `blocks/global/*/render.php`，查找缺失 `width` 或 `height` 属性的 `<img>` 标签。
*   **运行方式:**
    ```bash
    python3 verify_img_attributes.py
    ```

---

## 4. 待办事项 (Next Steps)

*   [ ] **CDN 上线配置:** 
    *   一旦有了 CDN 域名，需在 `header.php` 中启用预连接注释。
    *   配置图片处理服务 (如 Cloudflare Images 或 Imgproxy) 以接管 `wp_get_attachment_image_src` 的 URL 生成。
*   [ ] **视觉对齐:**
    *   持续监控 404 页面与搜索结果页 (Search Results) 的布局，确保其 `max-w-container` 与主站保持一致。

---

## 5. 交互组件与响应式细节 (Deep Dive)

### 🧩 Alpine.js 数据水合 (Data Hydration)
对于使用 Alpine.js 驱动的动态交互组件（如 **Manufacturing Capabilities** 的 Tabs 切换、**How It Works** 的步骤演示），单纯的 HTML 属性不足以完全解决 CLS 问题。我们制定了以下数据注入标准：

*   **问题:** JS 切换图片时，如果数据源中缺乏尺寸信息，DOM 更新会导致瞬间的布局重排。
*   **解决方案:** 在 PHP 端预处理数据时，强制通过 `wp_get_attachment_image_src` 获取 `width` 和 `height`，并将其打包进 JSON 对象。
*   **实现模式:**
    ```php
    // 1. PHP Data Preparation
    $tab_data[] = array(
        'image_url' => $src[0],
        'width'     => $src[1],  // 关键：传递物理宽度
        'height'    => $src[2],  // 关键：传递物理高度
    );

    // 2. Alpine Binding
    // <img :src="item.image_url" :width="item.width" :height="item.height">
    ```

### 📱 响应式艺术指导 (Art Direction)
针对 **Hero Banner** 等对首屏体验至关重要的模块，我们没有使用 CSS `display: none` 来隐藏桌面/手机图片（这会导致双重下载），而是采用了标准的 `<picture>` 标签切换策略。

*   **逻辑:** 使用 `<source media="(max-width: 767px)">` 指定手机专用图片源。
*   **尺寸锁定:** 即使是 `<source>` 标签内的手机图，也通过 PHP 动态获取了其专属的宽高属性，确保在移动端网络波动时，页面骨架依然稳定，实现 **Mobile-First CLS 0**。

### 🔍 验证脚本的误报处理
关于 `verify_img_attributes.py` 的补充说明：
*   **误报机制:** 脚本基于正则匹配静态字符串。当 `<img>` 标签的属性完全由 PHP 变量动态生成时（例如 `width="<?php echo $w; ?>"`），脚本可能会误报为 "Missing Attributes"。
*   **人工复核:** 我们已对 **Mission**, **Manufacturing Showcase** 等模块进行了人工代码审计，确认这些“误报”实际上已包含了正确的动态属性。
