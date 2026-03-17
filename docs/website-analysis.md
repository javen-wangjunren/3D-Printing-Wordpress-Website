# Website Analysis – 3D Printing (GeneratePress Child Theme)

## 执行摘要
- 当前站点采用 GeneratePress 子主题 + Tailwind + ACF（PHP 本地字段）作为核心技术栈，页面渲染以 Template Parts 为主，CPT 完全 ACF 驱动，文章（post）保留 Gutenberg。
- 已完成的关键治理：禁用除 post 外的所有古腾堡编辑器；非文章页面移除 Gutenberg 样式；统一标题类名为 `text-heading`；Solution CPT 通过 ACF Clone 组装五大模块；Application 模块前端已落地。
- 主要问题：早期 Block 与 Template Parts 并存、SEO 基础缺失（meta/OG/schema/breadcrumbs）、图片与可访问性策略不完善、部分旧模块契约不统一。
- 建议路线：先统一渲染范式与字段契约，再补齐 SEO 与性能基线，随后治理可访问性与工程化工具链。

## 架构快照
- 技术栈
  - 主题：GeneratePress Child（布局与路由由 inc/setup.php 接管）
  - 数据：ACF Local PHP（字段在 `inc/acf/field/`、CPT 字段在 `inc/acf/cpt/`）
  - 渲染：Template Parts（`template-parts/**`），早期部分 Block 仍在使用
  - CPT：capability / material / surface-finish / solution（均路由到 `templates/single-*.php`）
- 关键策略
  - 编辑器策略：仅 post 使用 Gutenberg；其他 post type 禁用（inc/setup.php）
  - 样式策略：非文章页面移除 `wp-block-library*` 与 `global-styles`（inc/setup.php）
  - 路由策略：CPT 单页模板强制指向 `templates/`（inc/setup.php）
  - 排版约定：所有 h1–h6 添加 `text-heading`，由 GP 统一接管

参考文件：
- Setup 总控：[inc/setup.php](file:///Users/javen/Local%20Sites/3d-printing/app/public/wp-content/themes/generatepress_child/inc/setup.php)
- Solution 单页模板：[templates/single-solution.php](file:///Users/javen/Local%20Sites/3d-printing/app/public/wp-content/themes/generatepress_child/templates/single-solution.php)
- Application 模块：
  - [hero.php](file:///Users/javen/Local%20Sites/3d-printing/app/public/wp-content/themes/generatepress_child/template-parts/application/hero.php)
  - [technical-strength.php](file:///Users/javen/Local%20Sites/3d-printing/app/public/wp-content/themes/generatepress_child/template-parts/application/technical-strength.php)
  - [showcase.php](file:///Users/javen/Local%20Sites/3d-printing/app/public/wp-content/themes/generatepress_child/template-parts/application/showcase.php)
  - [recommendation.php](file:///Users/javen/Local%20Sites/3d-printing/app/public/wp-content/themes/generatepress_child/template-parts/application/recommendation.php)
  - [certification.php](file:///Users/javen/Local%20Sites/3d-printing/app/public/wp-content/themes/generatepress_child/template-parts/application/certification.php)

## 复杂度评估
- 结构复杂度：**中等偏高**。包含 4 个核心 CPT（Capability、Material、Surface Finish、Solution），通过 ACF 关系字段和分类法形成复杂的关联网络。Solution CPT 尤其复杂，通过 Clone 字段整合了 5 个 Application 模块，形成多层次的数据结构。
- 认知复杂度：**中等偏高**。
  - 范式混用：历史 Block 与新 Template Parts 并存，需要理解两套实现逻辑的边界和迁移路径。
  - 数据关系：CPT 之间存在多对多关联（如 Material 与 Capability 的适配关系、Surface Finish 与 Material 的兼容关系），增加了理解成本。
  - 模板依赖：Template Parts 之间存在层级依赖，如 Solution 单页模板依赖多个 Application 模块。
- 运维复杂度：**中等偏高**。
  - ACF 复杂度：广泛使用 Repeater、Clone、Relationship 等高级字段，后台录入友好但需要注意性能边界。
  - 命名规范：需要维护统一的字段命名规范（如 `sol_`、`mat_`、`sf_` 前缀），避免命名冲突。
  - 数据一致性：CPT 之间的关联需要手动维护，存在数据不一致的风险（如 Material 与 Capability 的适配关系变更）。
- 数据流转复杂度：**中等**。从 ACF 字段获取 → Template Parts 渲染 → 前端 Alpine.js 交互，形成完整的数据流转链路，需要确保各环节数据格式的一致性。

## 做得好的点
- 渲染范式清晰：Template Parts 三段式（初始化→预处理→视图）落地到位。
- 字段契约稳健：ACF 均返回 ID、字段命名语义明确且扁平（利于前端直接取值）。
- 编辑器与样式治理：仅 post 用 Gutenberg，其余禁用；非文章移除 Gutenberg 样式，减小 CSS 冗余。
- 路由统一：CPT 单页模板集中于 `templates/`，避免文件分散。
- 视觉约定统一：标题统一 `text-heading`，后续全局调色/字号更方便。
- 安全输出：文本 esc、URL esc_url、HTML 片段 wp_kses_post；Alpine x-data 使用 JSON + esc_attr。

## 不足与问题
- 范式混用：早期 Block 未清理，可能导致同类模块存在两套实现，维护成本上升。
- SEO 基线缺失：未配置 meta title/description、Open Graph/Twitter、canonical、Breadcrumbs（未放入 hero）。
- 图片与性能：
  - 多处使用 `wp_get_attachment_image_url()`，缺少 `srcset/sizes`，未统一 `loading="lazy"` 与尺寸选择。
  - 占位图使用 Unsplash（生产可替换为自有占位或可复用媒体）。
- 可访问性（a11y）：
  - 图片 alt 获取不一致（部分为空或依赖媒体库），标题层级与对比度需二次审视。
- 工程化与质量保障：未见 PHPCS/PHPStan 规则、CI、统一命令约定（可在 `.trae/rules` 中固化）。
- 文档偏历史：从 Block → Template Parts 的迁移已在进行，但旧文档/示例仍有 Block 痕迹，易误导新人。

## 潜在风险
- **范式混用风险**：长期并存两套模块范式（Block 与 Template Parts）会造成双重心智负担与不必要的兼容逻辑，增加维护成本。
- **CPT 关联复杂度风险**：
  - 数据一致性风险：CPT 之间的多对多关联（如 Material ↔ Capability、Surface Finish ↔ Material）需要手动维护，容易出现数据不一致。
  - 性能风险：多选关系字段规模扩大后，后台加载和前端渲染可能出现性能瓶颈。
- **ACF 复杂度风险**：
  - Repeater 过大或多层嵌套（如 Solution 的 5 个 Clone 模块）导致后台性能下降，尤其是图片预览与多选关系字段。
  - 字段命名冲突：不同 CPT 之间的字段前缀需要严格管理，避免命名冲突。
- **模板依赖风险**：Template Parts 之间的层级依赖（如 Solution 依赖 Application 模块）可能导致修改一处影响多处，增加回归风险。
- **占位图依赖风险**：占位图外链依赖第三方（Unsplash），可能遇到访问稳定性或合规问题。

## 推荐路线图（分阶段）
### Phase 1：范式统一与契约固化（短期）
- 盘点现存 Block 使用位置：决定保留给内容型页面（如 post/通用页），其余功能模块全部迁移为 Template Parts。
- 为 Template Parts 补充统一渲染规范文档：数据获取、图片处理（ID→`wp_get_attachment_image`）、安全输出、标题类名。
- 扩大 `text-heading` 扫描范围到 `template-parts/**` 其他目录，确保一致性。

### Phase 2：SEO 基础与面包屑（短期）
- 方案 A：接入成熟 SEO 插件（Yoast/RankMath），禁用无关模块，仅启用 meta/OG/面包屑；在 hero 顶部渲染面包屑（CPT 单页）。
- 方案 B：自研轻量 SEO partial：基于 `wp_head` 输出 meta title/desc、OG/Twitter、canonical，并实现 `BreadcrumbList` schema。
- 在 Solution/Capability/Material/Surface Finish 的 hero 中插入 breadcrumbs（置于标题上方）。

### Phase 3：图片与性能（中期）
- 将 `wp_get_attachment_image_url()` 替换为 `wp_get_attachment_image()`（含 `sizes/srcset`），统一 `loading="lazy"`。
- 规范图片尺寸：卡片、横幅等定义固定尺寸别名，避免 full 原图。
- Tailwind 产物体积治理：确保启用 Purge/Content 配置，持续监控包体。

### Phase 4：可访问性与设计一致性（中期）
- 图片 alt 策略：优先字段 alt → 媒体库 alt → 名称 fallback；为关键按钮与链接补充 aria-label。
- 审核对比度与键盘可达性；确保焦点样式清晰。

### Phase 5：工程化（中期）
- 引入 PHPCS（PSR-12 + WordPressVIP 基线）与简单 CI；将常用命令记录在 `.trae/rules/project_rules.md`。
- 增加“模板自检清单”脚本或文档，用于 review：字段命名、输出安全、标题类、图片 API、SEO 钩子。

## 快速落地清单（Quick Wins）
- 在 hero 模块顶部加入 breadcrumbs partial，并在 `single-*.php` 的模板中加载。
- 新建 `inc/seo/meta.php` + `inc/seo/breadcrumbs.php`（或接入插件）：集中 SEO 逻辑。
- 统一图片工具函数：包一层 `3dp_image($id, $size, $attrs)`，内部调用 `wp_get_attachment_image()`。
- 将 Application 模块中的图片调用改为尺寸化 + lazy。
- 为 `template-parts/**` 一次性全站扫描 `h1–h6` 类，确认 `text-heading` 已覆盖。

## 结语
站点当前基础稳定、架构清晰，Template Parts 转型路线明确。建议优先完成范式统一与 SEO 基础，再推进图片与可访问性层面的优化。随着内容规模扩大，工程化与性能治理的收益将逐步显现。

