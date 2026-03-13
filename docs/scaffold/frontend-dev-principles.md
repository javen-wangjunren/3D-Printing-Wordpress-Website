# 前端开发核心原则与脚手架规范 (Frontend Development Principles & Scaffold Standards)

本文档定义了在 WordPress 前端开发（特别是基于 GeneratePress Child + Tailwind CSS + ACF 架构）中必须遵守的 **“视觉优先” (Visual First)** 开发原则和代码规范。

## 0. 核心设计哲学 (Core Design Philosophy)

### 0.1 关注点分离 (Separation of Concerns - SoC)
**理念**：将复杂的系统拆分为职责单一的模块。
*   **调度者 (Dispatcher)**：`header.php`, `footer.php`。只负责宏观布局（“这里放 Logo，那里放菜单”），不负责具体实现。
*   **执行者 (Worker)**：`template-parts/**/*.php`。负责具体的 HTML 渲染和逻辑。
*   **收益**：修改一个模块（如移动端菜单）绝不会意外破坏另一个模块（如桌面端菜单）。

### 0.2 组件化思维 (Componentization)
**理念**：将 UI 拆解为可复用的原子组件。
*   **实践**：不要在 `page-home.php` 里写 500 行 HTML。将其拆解为 `hero.php`, `features.php`, `cta.php`，然后通过 `_starter_render_block` 进行组装。

---

## 1. 核心理念 (Core Philosophy)

### 1.1 视觉优先 (Visual First)
**原则**：一切开发始于视觉还原，终于数据绑定。
*   **流程**：Static HTML/Tailwind -> Component Extraction -> PHP Integration。
*   **红线**：禁止在没有完美还原设计稿的情况下直接写 PHP 逻辑。

### 1.2 零干扰集成 (Zero-Interference Integration)
**原则**：PHP 代码不应破坏 HTML 结构或引入额外的 DOM 层级。
*   **手段**：使用专门设计的辅助函数 (`get_flat_field`) 和渲染引擎 (`_starter_render_block`) 来保持模板的纯净。

---

## 2. 数据获取与绑定 (Data Binding)

### 2.1 极简字段获取 (`get_flat_field`)
**规范**：前端模板中**严禁**直接使用 `get_field()` 进行复杂的判空逻辑。必须统一使用 `get_flat_field`。

*   **函数签名**：`get_flat_field( $field_name, $block, $default )`
*   **优势**：
    1.  **自带兜底**：自动处理 `null`, `false`, `''`，直接返回默认值。
    2.  **上下文智能**：自动识别是在 Block 还是 Page Template 环境中运行。
    3.  **代码整洁**：消灭 90% 的 `if ( ! empty(...) )` 代码。

*   **❌ 错误写法 (Old Way)**:
    ```php
    $title = get_field('hero_title');
    if ( ! $title ) {
        $title = 'Default Title';
    }
    ```

*   **✅ 正确写法 (Scaffold Way)**:
    ```php
    $title = get_flat_field('hero_title', $block, 'Default Title');
    ```

### 2.2 附录：核心函数参考实现 (Reference Implementation)
为了避免“智能判断”成为黑盒，以下是 `get_flat_field` 和 `_starter_render_block` 的标准实现逻辑。在排查数据获取问题时，请优先检查此逻辑。

```php
/**
 * 极简字段获取函数 (get_flat_field)
 * 逻辑：优先从 $block 数组取值 -> 其次尝试取 _context_post_id -> 最后兜底取当前页 ID
 */
function get_flat_field( $field_name, $block = array(), $default = null ) { 
    // 1. 优先: 直接从 Block 数组拿 (性能最高，不查数据库) 
    if ( isset( $block[ $field_name ] ) && $block[ $field_name ] !== '' ) { 
        return $block[ $field_name ]; 
    } 

    // 2. 其次: 检查是否有显式传递的上下文 ID
    $post_id = isset( $block['_context_post_id'] ) ? $block['_context_post_id'] : false; 
    
    // 3. 兜底: 如果没有上下文 ID，尝试获取当前页面 ID
    if ( ! $post_id ) {
        $post_id = get_the_ID();
    }

    // 查库获取
    $value = get_field( $field_name, $post_id ); 

    // 4. 返回: 真实值或默认值
    return ( $value !== null && $value !== false && $value !== '' ) ? $value : $default; 
}

/**
 * 模块独立渲染函数 (_starter_render_block)
 * 逻辑：加载模板文件，并利用 PHP 函数作用域隔离特性，确保变量不污染全局。
 */
function _starter_render_block( $template_path, $block_data = array() ) {
    // 将数据赋值给 $block 变量，这是模版中约定的标准变量名
    $block = $block_data;
    
    // 自动补全文件后缀
    if ( substr( $template_path, -4 ) !== '.php' ) {
        $template_path .= '.php';
    }

    // 定位并加载模版
    // 使用 locate_template 允许子主题覆盖
    $located = locate_template( $template_path );

    if ( $located ) {
        include $located;
    } else {
        // 开发环境下提示缺失模版
        if ( defined( 'WP_DEBUG' ) && WP_DEBUG ) {
            echo "<!-- Template not found: {$template_path} -->";
        }
    }
}
```

### 2.3 模块化渲染 (`_starter_render_block`)
**规范**：页面模板 (Page Template) 禁止直接编写 HTML 结构，必须通过“组装”模块来实现。

*   **函数签名**：`_starter_render_block( $template_path, $data = array() )`
*   **作用域机制**：
    1.  **隔离**：`$data` 数组会被赋值给模板内的局部变量 `$block`。模板内无法访问父级作用域的变量（除非是 `global`），确保了真正的隔离。
    2.  **传递**：如果未传递 `$data`，模板内的 `$block` 将为空数组。此时 `get_flat_field` 会自动回退到使用 `get_the_ID()` 获取当前页面的字段。

*   **示例 A：默认上下文 (Default Context)**
    *   场景：渲染当前页面（如 Home Page）的 Hero 模块，数据直接从当前页面获取。
    ```php
    // page-home.php
    _starter_render_block( 'blocks/global/hero/render' ); 
    // render.php 内部: $block 为空，get_flat_field 自动取当前页 ID
    ```

*   **示例 B：显式数据传递 (Explicit Data Passing)**
    *   场景：在 Home Page 渲染“关于我们”页面的 Hero，或者在循环中渲染 Card。
    ```php
    // page-home.php
    $about_page_id = 123;
    _starter_render_block( 'blocks/global/hero/render', array(
        '_context_post_id' => $about_page_id, // 告诉 get_flat_field 去取哪个页面的数据
        'custom_title'     => 'Override Title', // 传递自定义数据
    ));
    // render.php 内部: $block 包含上述数据
    ```

### 2.4 循环中的上下文陷阱 (Context in Loops)
**红线**：在 `WP_Query` 或 `foreach` 循环中调用 `_starter_render_block` 时，**必须**显式传递 `_context_post_id`。
*   **理由**：`get_flat_field` 默认使用的 `get_the_ID()` 依赖于全局 `$post`。在自定义循环中，如果未严格设置 `setup_postdata`，极易取到错误的（父级页面）ID。
*   **正确示例**：
    ```php
    // 在 Custom Loop 中
    while ( $query->have_posts() ) : $query->the_post();
        _starter_render_block( 'blocks/card', array(
            '_context_post_id' => get_the_ID() // 👈 必须显式传递！
        ));
    endwhile;
    ```

---

## 3. 模板结构规范 (Template Structure)

### 3.1 渲染模版标准结构 (Render Template Anatomy)
每个模块的 `render.php` 必须遵循以下三段式结构：

1.  **初始化 (Initialization)**: 获取数据。
2.  **预处理 (Preprocessing)**: 处理复杂的逻辑或数组（可选）。
3.  **视图渲染 (View Rendering)**: 纯净的 HTML + PHP 输出。

```php
<?php
// I. 初始化
// 确保 $block 存在 (兼容非 Block 环境)
$block = isset($block) ? $block : [];

// 获取数据 (使用 get_flat_field)
$title = get_flat_field('hero_title', $block, 'Welcome');
$img   = get_flat_field('hero_image', $block);

// II. 预处理
$bg_url = $img ? wp_get_attachment_image_url($img, 'full') : '...placeholder...';
?>

<!-- III. 视图渲染 -->
<section class="relative">
    <h1><?php echo esc_html($title); ?></h1>
    <img src="<?php echo esc_url($bg_url); ?>">
</section>
```

### 3.2 预处理的红线 (Preprocessing Boundaries)
**原则**：`render.php` 是视图层，不是控制器。
*   **✅ 允许的操作**：
    *   **格式转换**：Image ID -> URL, Timestamp -> Date String。
    *   **简单的判空**：设置默认图片或文本。
    *   **数组重组**：将 ACF Repeater 数据映射为更简单的 Key-Value 数组。
*   **❌ 禁止的操作**：
    *   **数据库查询**：严禁 `WP_Query` 或 `get_posts`（应在 Controller 或 Helper 中完成）。
    *   **复杂逻辑**：禁止嵌套超过 2 层的 `if/foreach` 逻辑。
    *   **业务计算**：如价格计算、库存检查等（应封装为 Helper 函数）。

### 3.3 变量命名约定
*   **$block**: 模块数据的标准容器变量名（由 `_starter_render_block` 自动注入）。
*   **无前缀变量**: 在 `render.php` 内部，变量名应简洁直接（如 `$title`, `$images`），不要带模块前缀（如 `$hero_title`），因为作用域已隔离。

---

## 4. 最佳实践 (Best Practices)

### 4.1 默认值策略
**原则**：所有文本类字段都必须提供合理的默认值。
*   **理由**：避免客户在未填写内容时看到空白页面，同时方便开发阶段预览效果。

### 4.2 图片处理
**原则**：图片字段获取的是 ID，必须转换为 URL 或 `srcset`。
*   **兜底**：必须提供 Unsplash 或本地占位图作为图片兜底。
*   **防御性编程**：虽然要求后端配置为 "Return ID"，但前端最好在使用 `wp_get_attachment_image_url` 前做一个简单的类型检查 (`is_numeric`)，防止因配置错误（返回了数组或 URL）导致 PHP 报错。

### 4.3 交互逻辑分层 (Interaction Layering)
**原则**：根据交互复杂度选择合适的技术栈，避免“一把梭”。
*   **Alpine.js (推荐)**：适用于**组件内**的轻量级状态管理。
    *   ✅ **适用场景**：Mobile Menu, Dropdown, Modal, Tabs, Accordion。
    *   ❌ **不适用场景**：复杂的 DOM 操作（如拖拽排序）、高性能动画（如 GSAP ScrollTrigger）、跨组件状态同步。
*   **Vanilla JS / 专用库**：对于复杂场景，应编写独立的 JS 模块或引入专用库（如 Swiper, GSAP）。
*   **禁止**：为了简单的 UI 交互引入 jQuery。
