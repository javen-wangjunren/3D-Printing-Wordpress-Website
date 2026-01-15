#1/13 上午修改：

所有功能已实现完成，现在总结工作成果。已成功完成single-capability.php模板的优化和所有自动化功能的实现。主要工作包括：

1. 优化single-capability.php模板

- 实现了模块的条件显示和数据传递机制
- 添加了缓存支持，提高页面加载性能
- 统一了数据结构，便于维护和扩展
2. 实现核心自动化功能

- Comparison Table智能高亮 ：基于当前工艺标题自动匹配并高亮对应的数据行
- Material List智能筛选 ：基于当前工艺ID自动显示关联材料，支持单工艺和多工艺模式
- Industry Slider自动内容填充 ：支持CPT和选项页两种数据来源，可扩展为工艺相关行业过滤
- Related Blog自动匹配 ：基于当前工艺的标签或分类自动关联相关博客文章
3. 更新模块render.php文件

- hero-banner：支持响应式图片和全局选项填充
- trusted-by：基于全局选项的客户列表展示
- how-it-works：工作流程步骤的自动化填充
- capability-design-guide：工艺特定的设计指南内容
- why-choose-us：全局配置的选择理由
- order-process：全局配置的订单流程
- cta：全局配置的呼叫行动模块
4. 技术特点

- 所有模块支持缓存，提高性能
- 遵循WordPress和ACF最佳实践
- 实现了数据的自动回退机制，确保即使没有特定数据也能正常显示
- 支持响应式设计和移动端优化
所有文件已通过语法检查，确保了代码的质量和稳定性。

#1/13 下午修改：

- 修复 All Capabilities 页面 ACF Tabs 不显示的问题

- 原因是字段组 location 的 page_template 路径写错（ template/ vs 实际 templates/ ）。
- 修复文件： page-all-capabilities.php
- 修复 Related Blog 手动挑选博文不生效

- 让 render.php 优先读取模板注入的 related_blog_posts （relationship 结果），没传则走原来的自动匹配查询逻辑。
- 解释并处理 Page 默认出现古腾堡编辑器的原因

- Page 默认支持 editor ，WP 5+ 默认用 Gutenberg 编辑支持 editor 的内容类型。
- Capability CPT 因为 supports 通常不含 editor ，所以更“干净”。
- 针对 Page 增加“是否启用内容编辑器”的页面级开关（一劳永逸）

- 新增页面字段组（侧边栏单一开关）： page-editor-settings.php
- setup 里读取该开关决定启用/禁用 Gutenberg + editor support： setup.php
- 修复 setup.php 把代码当文本输出导致页面报错

- 原因是 inc/setup.php 缺少 <?php 开头。
- 已补齐并加了 ABSPATH 防直连保护： setup.php
- 优化 all-capabilities 后台“空荡荡无边框”的观感

- 字段组从 style => seamless 改为 style => default ，恢复 metabox 边框： page-all-capabilities.php
- 移除 Page 编辑页的 Slug 元框（你截图那块）

- 在后台编辑 Page 的 screen 上移除 slugdiv metabox： setup.php