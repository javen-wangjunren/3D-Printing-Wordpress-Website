/wp-content/themes/generatepress_child/
│
├── 📜 style.css
├── 📜 functions.php              # 入口：只负责 require inc/*
│── 📂 acf-json/                   # ACF 字段组 JSON 文件（版本控制）
│
├── ⚙️ tailwind.config.js         # WindPress / Tailwind 总配置
│
├── 📂 docs/                      # 📚 项目“知识中枢”
│   ├── 3dp-design-philosophy.md  # 设计理念
│   ├── 3dp-design-system.md      # 设计系统（颜色/字体/spacing/组件）
│   ├── content-model.md          # 内容模型（Capability / Material / Blog）
│   ├── daily-changelog.md        # 每日更新日志
│   ├── dry-principle.md          # DRY 原则实现
│   ├── file-structure.md         # 文件结构文档
│   └── seo-structure.md          # SEO & 内链规则（后期补）
│
├── 📂 design-preview/            # 🎨 设计预览HTML文件
│   │
│   ├── 📂 full-page-tempate/      # 全页模板演示 (Typo: tempate)
│   │   ├── all-capabilities-demo.html
│   │   ├── homepage-demo.html
│   │   ├── single-capability-demo.html
│   │   └── single-material-demo.html
│   │
│   ├── about-demo.html
│   ├── capability-design-guide.html
│   ├── capability-list.html
│   ├── capability-materia-list.html
│   ├── comparison-table.html
│   ├── cta.html
│   ├── factory-image.html
│   ├── footer.html
│   ├── header.html
│   ├── hero-banner-style1.html
│   ├── hero-banner-style2.html
│   ├── how-it-works.html
│   ├── industry-slider.html
│   ├── manufacturing-capabilities.html
│   ├── manufacturing-showcase.html
│   ├── material-card.html
│   ├── material-list.html
│   ├── misson.html
│   ├── order-process.html
│   ├── page-all-materials.html
│   ├── related-blog.html
│   ├── review.html
│   ├── surface-finish.html
│   ├── team.html
│   ├── technical-specs.html
│   ├── timeline.html
│   ├── trusted-by.html
│   └── why-choose-us.html
│
├── 📂 inc/ 
│   ├── 📂 acf                    # ACF 相关配置
│   │   ├── 📂 cpt                # 自定义文章类型ACF字段
│   │   │   ├── cpt-capability.php
│   │   │   └── cpt-material.php
│   │   ├── 📂 field              # Block相关ACF字段
│   │   │   ├── capability-design-guide.php
│   │   │   ├── capability-list.php
│   │   │   ├── comparison-table.php
│   │   │   ├── cta.php
│   │   │   ├── factory-image.php
│   │   │   ├── feature-grid.php
│   │   │   ├── filter-sidebar.php
│   │   │   ├── footer.php
│   │   │   ├── header.php
│   │   │   ├── hero-banner.php
│   │   │   ├── how-it-works.php
│   │   │   ├── industry-slider.php
│   │   │   ├── manufacturing-capabilities.php
│   │   │   ├── manufacturing-showcase.php
│   │   │   ├── material-card.php
│   │   │   ├── material-list.php
│   │   │   ├── mission.php
│   │   │   ├── order-process.php
│   │   │   ├── related-blog.php
│   │   │   ├── review-grid.php
│   │   │   ├── surface-finish.php
│   │   │   ├── team.php
│   │   │   ├── technical-specs.php
│   │   │   ├── timeline.php
│   │   │   ├── trusted-by.php
│   │   │   └── why-choose-us.php
│   │   ├── acf-pro-stubs.php     # ACF Pro 类型定义
│   │   ├── blocks.php            # 所有Block注册
│   │   └── fields.php            # 集中加载所有ACF字段
│   ├── options-page.php          # 全局设置页面注册
│   ├── setup.php                 # 主题支持 / 基础设置
│   ├── assets.php                # CSS / JS 资源加载
│   ├── post-types.php            # 自定义文章类型注册
│   ├── taxonomies.php            # 自定义分类法注册
│   ├── helpers.php               # 通用工具函数
│   ├── seo.php                   # SEO 增强
│   └── assert.php                # 断言工具函数
│
├── 📂 blocks/                    # 🧱 可复用 Block（原子 → 分子）
│   ├── global/                   # 全局通用模块
│   │   ├── capability-design-guide/
│   │   ├── capability-list/
│   │   ├── comparison-table/
│   │   ├── cta/
│   │   ├── factory-image/
│   │   ├── feature-grid/
│   │   ├── filter-sidebar/
│   │   ├── hero-banner/
│   │   ├── how-it-works/
│   │   ├── industry-slider/
│   │   ├── manufacturing-capabilities/
│   │   ├── manufacturing-showcase/
│   │   ├── material-card/
│   │   ├── material-comparison/
│   │   ├── material-list/
│   │   ├── mission/
│   │   ├── order-process/
│   │   ├── related-blog/
│   │   ├── review-grid/
│   │   ├── surface-finish/
│   │   ├── team/
│   │   ├── technical-specs/
│   │   ├── timeline/
│   │   ├── trusted-by/
│   │   └── why-choose-us/
│   │       └── render.php (每个目录下都有 render.php)
│
├── 📂 templates/                 # 📄 页面结构模板
│   ├── page-home.php
│   ├── page-about.php
│   ├── page-contact.php
│   ├── archive-capability.php
│   ├── single-capability.php
│   ├── archive-material.php
│   ├── single-material.php
│   ├── archive.php               # Blog Archive（ahrefs 风格）
│   └── single.php                # Blog Single（ahrefs 风格）
│
├── 📂 parts/                     # 🧩 模板片段（可选但强烈推荐）
│   ├── header-hero.php
│   ├── post-meta.php
│   ├── pagination.php
│   └── related-posts.php
│
└── 📂 assets/
    ├── js/
    │   ├── toc.js
    │   ├── filter.js
    │   └── tabs.js
    └── icons/


一个Block的开发顺序：

假设开发的block的名称是：hero-banner
1. 在 `inc/acf/field/` 目录下创建 `hero-banner.php` 文件，定义该模块的ACF字段组
2. 在 `inc/acf/blocks.php` 文件中注册这个积木模块，使用 `acf_register_block_type()` 函数
3. 在 `blocks/global/hero-banner/` 目录下创建 `render.php` 文件，实现模块的渲染逻辑

示例代码结构：

**1. 字段定义 (inc/acf/field/hero-banner.php)**
```php
if ( function_exists( 'acf_add_local_field_group' ) ) {
    add_action( 'acf/init', function() {
        acf_add_local_field_group( array(
            'key' => 'group_3dp_hero_banner',
            'title' => 'Hero Banner',
            'fields' => array(
                // 字段定义...
            ),
            'location' => array(
                array(
                    array(
                        'param' => 'block',
                        'operator' => '==',
                        'value' => 'acf/hero-banner',
                    ),
                ),
            ),
        ) );
    });
}
```

**2. Block注册 (inc/acf/blocks.php)**
```php
if ( function_exists( 'acf_register_block_type' ) ) {
    function _3dp_register_hero_block() {
        acf_register_block_type( array(
            'name'              => 'hero-banner',
            'title'             => __( 'Hero Banner', '3d-printing' ),
            'description'       => __( '3D打印服务的Hero Banner模块', '3d-printing' ),
            'render_template'   => 'blocks/global/hero-banner/render.php',
            'category'          => 'layout',
            'icon'              => 'cover-image',
            'keywords'          => array( 'hero', 'banner', '3d printing', 'header' ),
            'mode'              => 'preview',
            'align'             => 'full',
            'supports'          => array(
                'align'     => array( 'full' ),
                'mode'      => true,
                'jsx'       => true,
            ),
        ) );
    }
    add_action( 'acf/init', '_3dp_register_hero_block' );
}
```

**3. 渲染模板 (blocks/global/hero-banner/render.php)**
```php
<?php
// 获取块数据
$block = $args['block'];
$block_id = $block['id'];
$block_class = $block['className'] ?? '';
$anchor = $block['anchor'] ?? '';

// 获取字段数据
$title = get_field('hero_title') ?? '';
$subtitle = get_field('hero_subtitle') ?? '';
// ... 其他字段

// 渲染HTML
?>
<div id="<?php echo esc_attr($anchor); ?>" class="hero-banner <?php echo esc_attr($block_class); ?>">
    <!-- 渲染内容 -->
</div>
```


关于什么时候创建和注册block, 什么时候不创建

### 应该创建Block的情况

1. **需要复用的组件**：当一个内容结构需要在多个页面或文章中重复使用时，应该创建为Block

2. **需要灵活排列的模块**：当用户需要在页面编辑器中灵活地添加、删除或重新排列内容模块时，应该使用Block

3. **非技术人员需要编辑的内容**：当内容需要由非技术人员通过WordPress后台编辑器进行管理时，应该创建带ACF字段的Block

4. **需要条件渲染或动态内容的模块**：当内容需要根据特定条件显示或包含动态生成的内容时，适合使用Block

5. **响应式设计要求高的模块**：当模块需要在不同设备上有不同的显示效果，且需要在后台进行配置时，应该创建Block

### 不应该创建Block的情况

1. **页面中固定不变的内容**：对于网站中固定位置、固定内容的部分（如页脚信息、固定的导航元素），不需要创建为Block

2. **只在单一页面使用的内容**：如果一个内容结构只在一个特定页面使用，且不需要用户编辑，可以直接在页面模板中实现

3. **完全由开发人员控制的内容**：对于需要严格控制HTML结构和样式的内容，直接在模板中编写可能更合适

4. **性能要求极高的关键内容**：对于网站性能至关重要的内容（如首页关键区域），直接在模板中实现可以避免Block渲染带来的额外开销

5. **过于简单或临时性的内容**：对于非常简单的内容（如一段固定的文本）或临时性的内容，不需要创建为Block

