# Brand Design Guide

**Industry:** 3D Printing / Digital Manufacturing  
**Style Direction:** Industrial · SaaS · Trust-first · Conversion-oriented

---

## 1. Color System

### Primary Brand Color
用于 CTA、主行动按钮、关键链接

```css
--color-primary: #0047AB;
--color-primary-hover: #003A8C;
--color-primary-active: #002E6E;
```

**Usage**
- Get Instant Quote
- 表单提交按钮
- 主导航高亮
- 核心可点击文字

---

### Text Colors

```css
--color-heading: #1D2938;
--color-body: #667085;
--color-muted: #98A2B3;
--color-inverse: #FFFFFF;
```

| Token | Usage |
|------|------|
| Heading | H1–H4、核心标题 |
| Body | 正文段落 |
| Muted | 辅助说明、注释 |
| Inverse | 深色背景文字 |

> 不使用纯黑色，确保工业 SaaS 的专业与耐读性

---

### Background Colors

```css
--color-bg-page: #FFFFFF;
--color-bg-section: #F2F4F7;
--color-bg-dark: #1D2939;
```

**Usage**
- 页面主背景：`#FFFFFF`
- 卡片 / Feature 区块：`#F2F4F7`
- Newsletter / 强转化区：`#1D2939`

---

### Border & Divider

```css
--color-border: #E4E7EC;
--color-border-strong: #D0D5DD;
```

---

## 2. Typography System

### Font Family

```css
font-family: Inter, system-ui, -apple-system, BlinkMacSystemFont, "Segoe UI", sans-serif;
```

**Rationale**
- 屏幕阅读友好
- 工程 / 参数 / 数字清晰
- 国际 B2B SaaS 标准选择

---

### Font Size Scale

```css
--text-h1: 48px;
--text-h2: 36px;
--text-h3: 28px;
--text-h4: 20px;
--text-body: 16px;
--text-small: 14px;
```

---

### Font Weight

```css
--weight-regular: 400;
--weight-medium: 500;
--weight-semibold: 600;
--weight-bold: 700;
```

---

### Typography Usage

| Type | Size | Weight | Color |
|----|----|----|----|
| H1 | 48px | 700 | Heading |
| H2 | 36px | 600 | Heading |
| H3 | 28px | 600 | Heading |
| H4 | 20px | 600 | Heading |
| Body | 16px | 400 | Body |
| Small | 14px | 400 | Muted |

```css
line-height: 1.5; /* body */
line-height: 1.2; /* headings */
```

---

## 3. Layout & Spacing

### Page Container

```css
--container-max-width: 1280px;
--container-padding: 24px;
```

---

### Section Spacing

```css
--section-padding-y: 96px;
--section-padding-y-small: 64px;
```

---

### Card Style

```css
--card-padding: 32px;
--card-radius: 12px;
```

---

## 4. Components

### Primary Button

```css
.button-primary {
  background: var(--color-primary);
  color: #FFFFFF;
  border-radius: 8px;
  padding: 12px 20px;
  font-weight: 600;
}

.button-primary:hover {
  background: var(--color-primary-hover);
}
```

---

### Card Component

```css
.card {
  background: var(--color-bg-section);
  border-radius: 12px;
  padding: 32px;
}
```

---

### Text Link

```css
a {
  color: var(--color-primary);
  font-weight: 500;
}

a:hover {
  text-decoration: underline;
}
```

---

## 5. Icon & Image Style

### Icons
- Outline / Line icons
- 统一 stroke（1.5–2px）
- 单色（灰或品牌蓝）

### Images
- 白色或浅灰背景
- 工业产品、零件特写
- 避免强滤镜与夸张阴影

---

## 6. Tone & Visual Language

**Keywords**
- Reliable
- Precise
- Engineering-first
- Scalable

**Avoid**
- 过度渐变
- 强装饰阴影
- 花哨动画

---

## 7. Design Tokens (Global)

```css
:root {
  --color-primary: #0047AB;
  --color-primary-hover: #003A8C;

  --color-heading: #1D2938;
  --color-body: #667085;
  --color-muted: #98A2B3;

  --color-bg-page: #FFFFFF;
  --color-bg-section: #F2F4F7;
  --color-bg-dark: #1D2939;

  --text-h1: 48px;
  --text-h2: 36px;
  --text-h3: 28px;
  --text-h4: 20px;
  --text-body: 16px;
}
```

---

## Design Philosophy

该设计系统基于成熟的工业级 SaaS 视觉语言构建，强调：
- 信任感优先于视觉炫技
- 转化与可扩展性优先
- 为工程师、采购与产品经理服务

适用于：
- 3D Printing Service
- CNC / Digital Manufacturing
- 工业 B2B 平台

