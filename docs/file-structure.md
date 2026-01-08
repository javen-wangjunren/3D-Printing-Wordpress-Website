/wp-content/themes/generatepress-child/
│
├── 📜 style.css
├── 📜 functions.php              # 入口：只负责 require inc/*
│── 📂 acf-json/                   # ACF 字段组 JSON 文件（版本控制）
│
├── ⚙️ tailwind.config.js         # WindPress / Tailwind 总配置
├── ⚙️ postcss.config.js          # （可选）如果后期编译 Tailwind
│
├── 📂 docs/                      # 📚 项目“知识中枢”
│   ├── 3dp-design-system.md      # 设计系统（颜色/字体/spacing/组件）
│   ├── content-model.md          # 内容模型（Capability / Material / Blog）
│   └── seo-structure.md          # SEO & 内链规则（后期补）
│
├── 📂 inc/ 
│   ├── 📂 acf
│   │   ├── specific-field
│   │   │    ├──hero-banner.php   # 注册特定的ACF模块,避免在一个文件下，导致代码过长
│   │   ├── load-all-fields.php       # 中转站，集中加载所有定义的ACF模块
│   │   ├── register-all-blocks.php   # 注册 Block，管理所有的积木名单
│   │
│   ├── setup.php                 # enqueue / theme support
│   ├── assets.php                # CSS / JS 加载（建议拆出来）
│   ├── post-types.php            # Capability / Material
│   ├── taxonomies.php            # Industry / Material Category
│   ├── helpers.php               # 通用函数（excerpt / reading time 等）
│   └── seo.php                   # （后期）结构化数据 / TOC / schema
│
├── 📂 blocks/                    # 🧱 可复用 Block（原子 → 分子），存放所有积木模块的
│   ├── global/
│   │   ├── hero-banner/
│   │   │   ├── render.php
│   │   ├── cta/
│   │   ├── feature-grid/
│   │   ├── logo-cloud/
│   │   └── faq/
│   │
│   ├── capability/
│   │   ├── process-steps/
│   │   ├── machine-list/
│   │   └── tolerance-table/
│   │
│   ├── material/
│   │   ├── material-specs/
│   │   ├── properties-table/
│   │   └── finishing-options/
│   │
│   └── blog/
│       ├── post-cta/
│       ├── toc/
│       └── pros-cons/
│
├── 📂 templates/                 # 📄 页面结构模板（以 Query + Block 为主）
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

假设开发的block的名称是：hero
1. 在 `acf-blocks.php` 文件中注册这个积木模块，例如 `register_block_type( 'hero' );`
2. 在 `acf-fields.php` 文件中定义这个积木模块的字段，例如 `acf_add_local_field_group( array(
    'key' => 'group_hero',
    'title' => 'Hero',
    'fields' => array(
        array(
            'key' => 'field_hero_title',
            'label' => 'Title',
            'name' => 'title',
            'type' => 'text',
        ),
    ),
) );`
3. 在blocks/global/hero 目录下创建 render.php 文件，这就是积木模块的 HTML 代码+Tailwind 代码.


关于什么时候创建和注册block, 什么时候不创建

