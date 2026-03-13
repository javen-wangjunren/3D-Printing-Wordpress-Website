<?php
/**
 * Template Name: All Surface Finish
 * Description: The template for displaying a single Surface Finish CPT.
 * 
 * ==========================================================================
 * 文件作用:
 * Surface Finish 汇总页面的模板文件。负责调度和渲染各个 UI 模块。
 *
 * 核心逻辑:
 * 1. 英雄区 (Hero Banner): 使用 ACF Clone 字段 (asf_hero_*) 渲染页面头部。
 * 2. 对比表 (Comparison Table): 渲染核心交互式表格，数据源为 surface-finish CPT。
 * 3. 全局 CTA: 渲染页面底部的行动号召模块，使用全局默认配置。
 *
 * 架构角色:
 * [Controller]
 * 本文件作为控制器，不包含具体的 HTML 结构，而是通过 _3dp_render_block 
 * 调度 blocks/global/ 下的各个原子模块。
 *
 * 🚨 避坑指南:
 * - ACF 字段前缀需与 inc/acf/pages/page-all-surface-finish.php 中的配置保持一致。
 * - Surface Finish Table 目前在 render.php 中硬编码了字段名，修改时需同步。
 * ==========================================================================
 * 
 * @package 3D_Printing
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

get_header();

// ==========================================================================
// I. 页面头部 (Hero Banner)
// ==========================================================================
/**
 * 渲染 Hero Banner 模块
 * 
 * 数据源: 当前页面的 ACF Clone 字段 (group_hero_banner)
 * 前缀: asf_hero_ (由 inc/acf/pages/page-all-surface-finish.php 定义)
 */
if ( function_exists( '_3dp_render_block' ) ) {
	_3dp_render_block( 'blocks/global/hero-banner/render', array(
		'prefix' => 'asf_hero_',
	) );
}

// ==========================================================================
// II. 核心对比表 (Surface Finish Table)
// ==========================================================================
/**
 * 渲染 Surface Finish Comparison Table
 * 
 * 数据源: 
 * 1. 页面标题/描述: 当前页面的 ACF 字段 (asf_table_title, asf_table_desc)
 * 2. 表格内容: 自动抓取所有 surface-finish CPT 数据
 * 
 * 注意: prefix 参数目前主要用于标识意图，render.php 内部直接读取了特定字段名。
 */
if ( function_exists( '_3dp_render_block' ) ) {
	_3dp_render_block( 'blocks/global/surface-finish-table/render', array(
		'prefix' => 'asf_table_',
	) );
}

// ==========================================================================
// III. 底部行动号召 (Global CTA)
// ==========================================================================
/**
 * 渲染全局 CTA 模块
 * 
 * 数据源: Theme Options (全局设置)
 * 逻辑: 不传递 prefix 参数，触发 CTA 模块的 "Global Fallback" 模式。
 */
if ( function_exists( '_3dp_render_block' ) ) {
	_3dp_render_block( 'blocks/global/cta/render', array( 
		'id' => 'cta' // 用于生成 HTML ID: #cta-cta
	) );
}

get_footer();
