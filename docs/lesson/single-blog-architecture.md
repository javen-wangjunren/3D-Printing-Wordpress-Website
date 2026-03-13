# Single Blog 页面架构与渲染流程

本文档对 Single Blog 页面（单篇文章）的前后端结构与数据流进行整理，涵盖模板组织、ACF Builder 模块化渲染、全局模块复用，以及 TOC/阅读时长的辅助逻辑。并附带 Mermaid 数据流图帮助整体把握。

## 目标与原则

- 保持“CMS-First”与干净 HTML：用 ACF Flexible Content 约束结构，避免 Gutenberg 粘贴产生的内联样式污染。
- 视觉优先：Tailwind 原子类在模板中固定，后端只替换数据，不改 DOM 结构与样式。
- 模块化渲染：每个内容模块有独立模板文件，降低耦合、便于维护与扩展。
- 全局模块复用：Related Blog、Blog CTA、Author Profile 通过统一渲染入口按需调用，支持 Options Fallback。

## 文件结构与职责

- 入口模板：[single.php](file:///Users/javen/Local%20Sites/3d-printing/app/public/wp-content/themes/generatepress_child/single.php)
  - 负责页面骨架：Header、Main（内容+侧栏）、Related Posts 区域
  - 从当前文章类别计算参数，调用 Related Blog 全局模块
- 头部区块：[header.php](file:///Users/javen/Local%20Sites/3d-printing/app/public/wp-content/themes/generatepress_child/template-parts/single-blog/header.php)
  - 展示面包屑、分类、日期、阅读时长、标题
- 内容分发：[content.php](file:///Users/javen/Local%20Sites/3d-printing/app/public/wp-content/themes/generatepress_child/template-parts/single-blog/content.php)
  - 根据 ACF `post_use_builder` 决定渲染路径（Builder 模式 / Gutenberg Fallback）
  - Builder 模式：循环 `post_body`，按 layout 名加载同名模块模板
  - 页面底部渲染“作者卡片（footer 变体）”
- 侧栏区块：[sidebar.php](file:///Users/javen/Local%20Sites/3d-printing/app/public/wp-content/themes/generatepress_child/template-parts/single-blog/sidebar.php)
  - 上部作者卡片（sidebar 变体），下部 sticky 容器：TOC + Blog CTA
- 模块模板（Builder）：  
  - 富文本：[richtext.php](file:///Users/javen/Local%20Sites/3d-printing/app/public/wp-content/themes/generatepress_child/template-parts/single-blog/modules/richtext.php)
  - 表格：[table.php](file:///Users/javen/Local%20Sites/3d-printing/app/public/wp-content/themes/generatepress_child/template-parts/single-blog/modules/table.php)
  - CTA：[cta.php](file:///Users/javen/Local%20Sites/3d-printing/app/public/wp-content/themes/generatepress_child/template-parts/single-blog/modules/cta.php)
  - 图片：[image.php](file:///Users/javen/Local%20Sites/3d-printing/app/public/wp-content/themes/generatepress_child/template-parts/single-blog/modules/image.php)
  - Callout：[callout.php](file:///Users/javen/Local%20Sites/3d-printing/app/public/wp-content/themes/generatepress_child/template-parts/single-blog/modules/callout.php)
- 字段定义与辅助：
  - ACF Builder 字段：[single-post.php](file:///Users/javen/Local%20Sites/3d-printing/app/public/wp-content/themes/generatepress_child/inc/acf/cpt/single-post.php)
  - 模板辅助函数：[blog-template-functions.php](file:///Users/javen/Local%20Sites/3d-printing/app/public/wp-content/themes/generatepress_child/inc/blog-template-functions.php)
    - `_3dp_get_builder_content()`：聚合 Builder 模块文本用于 TOC/阅读时长
    - `_3dp_get_read_time()`：统一计算阅读时长（兼容 Builder/Gutenberg）
    - `_3dp_get_post_toc()` / `_3dp_add_ids_to_h2()`：提取 H2 生成目录并注入锚点
- 全局模块（复用）：
  - Author Profile：[render.php](file:///Users/javen/Local%20Sites/3d-printing/app/public/wp-content/themes/generatepress_child/blocks/global/author-profile/render.php)
  - Blog CTA：[render.php](file:///Users/javen/Local%20Sites/3d-printing/app/public/wp-content/themes/generatepress_child/blocks/global/blog-cta/render.php)
  - Related Blog：[render.php](file:///Users/javen/Local%20Sites/3d-printing/app/public/wp-content/themes/generatepress_child/blocks/global/related-blog/render.php)

## 渲染流程（文字版）

- 进入 single.php：输出 Header、主栅格（内容 + 侧栏）、底部 Related 区域
- Header：读取分类、日期、阅读时长，输出标题
- Content：
  - 若 `post_use_builder` 为 true：循环 ACF `post_body`，按 layout 名调用对应模块模板
  - 若为 false：作为 Gutenberg Fallback，渲染 `the_content()`（含 H2 锚点注入）
  - 内容底部渲染作者卡片（footer 变体）
- Sidebar：
  - 顶部作者卡片（compact）
  - Sticky：TOC（基于聚合内容的 H2）+ Blog CTA（全局）
- Related Blog：
  - 从当前文章获取第一分类 ID，按“category 模式”调用模块，渲染相关文章
  - 无分类时走默认/空集处理

## 数据来源与约束

- 文章数据：`wp_posts` 正文 + ACF Builder 字段（post_body）
- 分类数据：`wp_terms`（用于相关博客模块的过滤）
- 全局配置：`wp_options`（Blog CTA 等全局内容作为回退）
- 命名契约：ACF 布局 `name` 与模块模板文件名保持一致（richtext/table/cta/image/callout）
- 表格模块：使用 Repeater 强约束结构与样式，避免内联样式污染

## Mermaid 数据流图

```mermaid
graph LR
    %% Actors
    User(("User"))

    %% Frontend (Theme Templates)
    subgraph Frontend [Frontend (Theme Templates)]
        Single["single.php"]
        Header["header.php"]
        Content["content.php"]
        Sidebar["sidebar.php"]
        Modules["modules/* (richtext/table/cta/image/callout)"]
    end

    %% ACF Builder
    subgraph ACF [ACF Builder]
        Toggle{"post_use_builder == true?"}
        Flex["Flexible Content: post_body"]
    end

    %% Helpers
    subgraph Helpers [Template Helpers]
        ReadTime["_3dp_get_read_time"]
        BuilderContent["_3dp_get_builder_content"]
        TOCGen["_3dp_get_post_toc / _3dp_add_ids_to_h2"]
    end

    %% WordPress Core
    subgraph WP ["WordPress Core"]
        PostsDB[("wp_posts")]
        TermsDB[("wp_terms")]
        OptionsDB[("wp_options")]
    end

    %% Global Blocks
    subgraph Global ["Global Blocks"]
        Author["Author Profile (render.php)"]
        CTA["Blog CTA (render.php)"]
        Related["Related Blog (render.php)"]
    end

    %% Flow
    User --"请求 Single Post 页面"--> Single
    Single --"加载 Header/Content/Sidebar"--> Header
    Single --"加载 Header/Content/Sidebar"--> Content
    Single --"加载 Header/Content/Sidebar"--> Sidebar
    Single --"渲染 Related 区域"--> Related

    %% Content path
    Content --"判断"--> Toggle
    Toggle --"Yes (Builder 模式)"--> Flex
    Flex --"按 layout 逐个渲染"--> Modules
    Toggle --"No (Gutenberg Fallback)"--> PostsDB

    %% Helpers usage
    Content --"聚合内容用于 TOC/阅读时长"--> BuilderContent
    BuilderContent --"文本聚合"--> ReadTime
    BuilderContent --"解析 H2 生成 TOC"--> TOCGen
    Sidebar --"渲染 TOC"--> TOCGen

    %% Global blocks
    Sidebar --"渲染 Author/CTA"--> Author
    Sidebar --"渲染 Author/CTA"--> CTA
    Related --"按分类过滤"--> TermsDB
    CTA --"全局回退 get_field(...,'option')"--> OptionsDB
    Author --"读取用户字段/头像"--> PostsDB

    %% Styling (optional)
    style User fill:#fff9c4,stroke:#fbc02d
    style Frontend fill:#e1f5fe,stroke:#01579b
    style ACF fill:#e8f5fe,stroke:#0277bd
    style Helpers fill:#f3e5f5,stroke:#6a1b9a
    style WP fill:#e8f5e9,stroke:#2e7d32
    style Global fill:#fff3e0,stroke:#ef6c00
```

## 关键约定与防错

- 布局名称 = 模板文件名，避免名称映射错误导致渲染失败
- 模块模板仅负责数据替换，不调整结构与样式（遵守视觉优先）
- 表格使用 Repeater，以数据结构换取维护性与一致性
- 侧栏 TOC/阅读时长一律通过 `_3dp_get_builder_content()` 聚合文本，兼容两种模式
- 全局模块优先使用局部数据，缺省时回退 `get_field('field', 'option')`

## 扩展建议

- 图片模块补充 `loading="lazy"` 与尺寸限制，优化首屏体验
- `_3dp_get_builder_content()` 可引入对象缓存提升重复使用场景性能
- 为 Builder 空内容但开关开启的情况增加运营日志，便于发现后台未配置的文章
