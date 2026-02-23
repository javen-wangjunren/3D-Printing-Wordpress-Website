---
name: optimize-file
description: "Optimizes code files for readability and structure. Invoke when user wants to refactor or improve code organization."
---

# Code Optimization Skill

This skill helps optimize code files by improving structure, readability, and adding detailed comments.

## Usage

When the user asks to "optimize file", "improve structure", or "add comments", invoke this skill.

## Optimization Guidelines

Apply the following rules to the target file:

1.  **Structure Refactoring**:
    - Organize code into logical blocks (e.g., `I. 初始化`, `II. 核心逻辑`, `III. 辅助函数`).
    - Use clear separator comments to divide sections.

2.  **Header Comments (Must use Chinese)**:
    - Add a detailed file header comment (PHPDoc/JSDoc style).
    - Include:
        - **文件作用 (Purpose)**: What does this file do?
        - **核心逻辑 (Core Logic)**: Key functionalities.
        - **架构角色 (Architecture Role)**: Why is this file needed in the project architecture (GeneratePress + Tailwind + ACF)?
        - **避坑指南 (Critical Notes)**: Any critical warnings or "do not touch" areas.

3.  **Code Cleanup**:
    - Remove unused or commented-out code (unless it's for documentation).
    - Fix indentation and formatting.
    - Rename variables for better semantic clarity if needed.

4.  **Inline Comments (Must use Chinese)**:
    - Add Chinese comments for key logic points.
    - Explain "why" the code is written this way, not just "what" it does.

## Example Header Format

```php
/**
 * [文件名称]
 * ==========================================================================
 * 文件作用:
 * [描述文件功能]
 *
 * 核心逻辑:
 * 1. [逻辑点 A]
 * 2. [逻辑点 B]
 *
 * 架构角色:
 * [解释文件在项目中的位置和必要性]
 *
 * 🚨 避坑指南:
 * [警告事项]
 * ==========================================================================
 */
```
