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
├── 📂 inc/                       # 🧠 后端逻辑层（稳定后很少改）
│   ├── setup.php                 # enqueue / theme support
│   ├── assets.php                # CSS / JS 加载（建议拆出来）
│   ├── post-types.php            # Capability / Material
│   ├── taxonomies.php            # Industry / Material Category
│   ├── acf-fields.php            # 所有 ACF 字段（集中管理）
│   ├── acf-blocks.php            # 注册 Block
│   ├── helpers.php               # 通用函数（excerpt / reading time 等）
│   └── seo.php                   # （后期）结构化数据 / TOC / schema
│
├── 📂 blocks/                    # 🧱 可复用 Block（原子 → 分子）
│   ├── global/
│   │   ├── hero/
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
