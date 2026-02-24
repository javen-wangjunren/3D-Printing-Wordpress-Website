/**
 * PostCSS 配置文件
 * ==========================================================================
 * 文件作用:
 * 配置 PostCSS 的插件链，这是 Tailwind CSS 编译流程的核心环节。
 *
 * 核心逻辑:
 * 1. tailwindcss: 调用 Tailwind 引擎，解析 `input.css` 并生成实用类。
 * 2. autoprefixer: 自动为 CSS 属性添加浏览器前缀 (如 -webkit-, -moz-)，确保兼容性。
 *
 * 架构角色:
 * 它是前端构建工具链 (npm run watch/build) 的必要组成部分。
 * 如果删除此文件，Tailwind CLI 将无法正常工作，CSS 无法编译。
 *
 * 🚨 避坑指南:
 * - 保持 `tailwindcss` 和 `autoprefixer` 的顺序（Tailwind 在前）。
 * - 除非引入了新的 PostCSS 插件（如 nesting），否则无需修改此文件。
 * ==========================================================================
 */

module.exports = {
  plugins: {
    // 第一道工序：裁剪与缝制
    // 作用：识别 input.css 里的 @tailwind 指令，把你写的 class="bg-blue-500" 变成真正的 CSS 代码。
    tailwindcss: {},
    // 第二道工序：熨烫与加前缀
    // 作用：给 CSS 属性添加浏览器前缀，确保在不同浏览器上都能正常显示。
    autoprefixer: {},
  },
}
