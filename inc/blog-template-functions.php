<?php
/**
 * Blog Template Functions (文章模板辅助函数)
 * ==========================================================================
 * 文件作用:
 * 专门处理单篇文章 (Single Blog) 的内容解析与增强逻辑。
 * 目前的核心职责是实现文章目录 (TOC - Table of Contents) 的生成与锚点注入。
 *
 * 核心逻辑:
 * 1. 内容聚合 (_3dp_get_builder_content): 统一获取文章原始内容（支持古腾堡）。
 * 2. 目录提取 (_3dp_get_post_toc): 解析 HTML 标签生成 TOC 数据数组。
 * 3. 锚点注入 (_3dp_add_ids_to_h2): 通过正则在文章内容中动态插入 H2 锚点 ID。
 *
 * 架构角色:
 * 在 [Single Blog Architecture] 中，该文件作为数据解析层，为侧边栏的 
 * Table of Contents 模块提供数据，并确保前端渲染的内容与 TOC 锚点完全一致。
 *
 * 🚨 避坑指南:
 * - ❌ 不要直接在文章保存时持久化 ID，应保持内容纯净，通过 `the_content` 滤镜动态注入。
 * - ✅ 确保 `_3dp_get_post_toc` 和 `_3dp_add_ids_to_h2` 使用相同的 ID 生成算法（sanitize_title）。
 * ==========================================================================
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * ==================================================
 * I. 内容获取逻辑 (Content Retrieval)
 * ==================================================
 */

if ( ! function_exists( '_3dp_get_builder_content' ) ) {
	/**
	 * 获取文章原始内容
	 * 用于 TOC 生成前的文本扫描。
	 *
	 * @param int|null $post_id 文章 ID
	 * @return string 原始 HTML 内容
	 */
	function _3dp_get_builder_content( $post_id = null ) {
		$post_id = $post_id ?: get_the_ID();
		
		// 统一返回古腾堡编辑器的原始内容
		// 备注：如果未来引入新的 Builder，只需在此扩展内容获取逻辑
		return (string) get_post_field( 'post_content', $post_id );
	}
}

/**
 * ==================================================
 * II. TOC 数据解析 (TOC Data Parsing)
 * ==================================================
 */

if ( ! function_exists( '_3dp_get_post_toc' ) ) {
	/**
	 * 从 HTML 内容中解析 H2 标签并生成 TOC 数组
	 * 
	 * @param string $content 需要解析的 HTML 内容
	 * @return array 包含 ID 和标题的 TOC 数组
	 */
	function _3dp_get_post_toc( $content ) {
		$content = (string) $content;
		$toc     = array();
		$used    = array(); // 用于处理重复 ID 的计数器

		// 仅抓取 H2 标签，保持侧边栏目录简洁（不抓取 H3/H4）
		if ( preg_match_all( '/<h2\b[^>]*>(.*?)<\/h2>/is', $content, $matches ) ) {
			foreach ( $matches[1] as $heading_html ) {
				// 清理 HTML 标签，仅保留纯文本作为标题
				$title = trim( wp_strip_all_tags( $heading_html ) );
				if ( $title === '' ) {
					continue;
				}

				// 生成标准化的锚点 ID
				$base = sanitize_title( $title );
				if ( $base === '' ) {
					$base = 'section';
				}

				// 逻辑：如果页面有多个相同的 H2 标题，自动添加序号后缀防止冲突
				$id = $base;
				$i  = 2;
				while ( isset( $used[ $id ] ) ) {
					$id = $base . '-' . $i;
					$i++;
				}
				$used[ $id ] = true;

				$toc[] = array(
					'id'    => $id,
					'title' => $title,
				);
			}
		}

		return $toc;
	}
}

/**
 * ==================================================
 * III. 锚点注入滤镜 (Anchor Injection Filter)
 * ==================================================
 */

if ( ! function_exists( '_3dp_add_ids_to_h2' ) ) {
	/**
	 * 动态为文章内容的 H2 标签添加 ID 属性
	 * 挂载在 `the_content` 滤镜上，确保前端跳转可用。
	 * 
	 * @param string $content 原始文章内容
	 * @return string 带有锚点 ID 的增强版内容
	 */
	function _3dp_add_ids_to_h2( $content ) {
		// 仅在单篇文章详情页执行，避免在列表页造成额外开销
		if ( ! is_singular( 'post' ) ) {
			return $content;
		}

		$used = array();

		return preg_replace_callback(
			'/<h2\b([^>]*)>(.*?)<\/h2>/is',
			function( $m ) use ( &$used ) {
				$attrs = (string) $m[1];
				$inner = (string) $m[2];

				// 如果内容中已经带有 ID（比如用户手动插入的），则跳过处理
				if ( preg_match( '/\bid\s*=\s*("|\')(.*?)\1/i', $attrs ) ) {
					return '<h2' . $attrs . '>' . $inner . '</h2>';
				}

				// 使用与 TOC 算法一致的 ID 生成逻辑
				$title = trim( wp_strip_all_tags( $inner ) );
				$base  = sanitize_title( $title );
				if ( $base === '' ) {
					$base = 'section';
				}

				$id = $base;
				$i  = 2;
				while ( isset( $used[ $id ] ) ) {
					$id = $base . '-' . $i;
					$i++;
				}
				$used[ $id ] = true;

				// 注入 ID 属性，同时保留原有的 Class 或其他属性
				return '<h2 id="' . esc_attr( $id ) . '"' . $attrs . '>' . $inner . '</h2>';
			},
			$content
		);
	}
	
	/**
	 * 优先级设置为 20，确保在标准内容清理滤镜之后执行
	 */
	add_filter( 'the_content', '_3dp_add_ids_to_h2', 20 );
}
