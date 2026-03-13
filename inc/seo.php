<?php
/**
 * SEO & Metadata Enhancements (SEO 增强与面包屑管理)
 * ==========================================================================
 * 文件作用:
 * 统一输出主题级面包屑导航（含 JSON-LD BreadcrumbList），用于替代 SEO 插件的面包屑。
 * 当前项目采用 Hub & Spoke 信息架构：CPT 单页 → 对应 Hub 列表页（非 taxonomy archive）。
 *
 * 核心逻辑:
 * 1. custom_breadcrumbs()：按页面类型生成 crumbs，并渲染 nav（Tailwind 样式可传参覆盖）。
 * 2. 自动注入 BreadcrumbList JSON-LD（同一请求只输出一次，避免重复 schema）。
 *
 * 架构角色:
 * [View Layer - SEO Utility]
 * 将导航路径结构化（可视 + 机器可读），与 Tailwind 设计系统对齐，减少插件依赖与样式冲突。
 * 
 * 🚨 避坑指南:
 * 1. 不做 taxonomy archive：面包屑不要输出分类页链接（例如 blog category）。
 * 2. Hub 链接优先动态解析（get_page_by_path），仅在明确要求时才写固定 path。
 * 3. 若在同一页面多处调用 custom_breadcrumbs()，schema 只会输出一次。
 * ==========================================================================
 * 
 * @package GeneratePress
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/**
 * I. 辅助函数（内部使用）
 * - 仅做轻量计算与 permalink 解析，严禁查询大规模数据
 */
function _3dp_breadcrumbs_resolve_page_url_by_paths( $paths ) {
	static $cache = array();

	foreach ( (array) $paths as $path ) {
		$path = is_string( $path ) ? trim( $path ) : '';
		if ( '' === $path ) {
			continue;
		}

		if ( array_key_exists( $path, $cache ) ) {
			if ( $cache[ $path ] ) {
				return $cache[ $path ];
			}
			continue;
		}

		$page = get_page_by_path( $path );
		$cache[ $path ] = $page ? get_permalink( $page->ID ) : '';

		if ( $cache[ $path ] ) {
			return $cache[ $path ];
		}
	}

	return '';
}

function _3dp_breadcrumbs_current_url() {
	$request_uri = isset( $_SERVER['REQUEST_URI'] ) ? wp_unslash( $_SERVER['REQUEST_URI'] ) : '/';
	$request_uri = strtok( $request_uri, '?' );
	return home_url( $request_uri ? $request_uri : '/' );
}

function _3dp_breadcrumbs_build_crumbs( $home_label ) {
	$crumbs = array(
		array(
			'label' => (string) $home_label,
			'url'   => home_url( '/' ),
		),
	);

	if ( is_singular( 'material' ) ) {
		$crumbs[] = array(
			'label' => 'All Materials',
			'url'   => _3dp_breadcrumbs_resolve_page_url_by_paths( array( 'all-materials' ) ),
		);
		$crumbs[] = array( 'label' => get_the_title(), 'url' => '' );
		return $crumbs;
	}

	if ( is_singular( 'capability' ) ) {
		$crumbs[] = array(
			'label' => 'All Capabilities',
			'url'   => _3dp_breadcrumbs_resolve_page_url_by_paths( array( 'all-capabilities' ) ),
		);
		$crumbs[] = array( 'label' => get_the_title(), 'url' => '' );
		return $crumbs;
	}

	if ( is_singular( 'surface-finish' ) ) {
		$crumbs[] = array(
			'label' => 'All Surface Finishes',
			'url'   => _3dp_breadcrumbs_resolve_page_url_by_paths( array( 'all-surface-finish', 'all-surface-finishes' ) ),
		);
		$crumbs[] = array( 'label' => get_the_title(), 'url' => '' );
		return $crumbs;
	}

	if ( is_singular( 'solution' ) ) {
		$crumbs[] = array(
			'label' => 'All Solutions',
			'url'   => _3dp_breadcrumbs_resolve_page_url_by_paths( array( 'all-solutions', 'solutions' ) ),
		);
		$crumbs[] = array( 'label' => get_the_title(), 'url' => '' );
		return $crumbs;
	}

	if ( is_singular( 'post' ) ) {
		$crumbs[] = array(
			'label' => 'All Blogs',
			'url'   => home_url( '/blogs/' ),
		);
		$crumbs[] = array( 'label' => get_the_title(), 'url' => '' );
		return $crumbs;
	}

	if ( is_home() ) {
		$crumbs[] = array( 'label' => 'All Blogs', 'url' => '' );
		return $crumbs;
	}

	if ( is_page() ) {
		$crumbs[] = array( 'label' => get_the_title(), 'url' => '' );
		return $crumbs;
	}

	$crumbs[] = array( 'label' => get_the_title(), 'url' => '' );
	return $crumbs;
}

function _3dp_breadcrumbs_render_schema_once( $crumbs ) {
	static $schema_printed = false;
	if ( $schema_printed ) {
		return;
	}
	$schema_printed = true;

	$schema_items = array();
	$position     = 1;
	$current_url  = _3dp_breadcrumbs_current_url();

	foreach ( $crumbs as $item ) {
		$label = isset( $item['label'] ) ? (string) $item['label'] : '';
		$url   = ! empty( $item['url'] ) ? (string) $item['url'] : $current_url;

		if ( '' === $label ) {
			continue;
		}

		$schema_items[] = array(
			'@type'    => 'ListItem',
			'position' => $position,
			'name'     => $label,
			'item'     => $url,
		);
		$position++;
	}

	$schema_data = array(
		'@context'        => 'https://schema.org',
		'@type'           => 'BreadcrumbList',
		'itemListElement' => $schema_items,
	);

	echo "\n" . '<script type="application/ld+json">' . wp_json_encode( $schema_data, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE ) . '</script>' . "\n";
}

/**
 * II. 对外函数（模板调用）
 */
function custom_breadcrumbs( $args = array() ) {
	if ( is_front_page() ) {
		return;
	}

	$args = wp_parse_args( $args, array(
		'nav_class'     => 'text-small text-muted mb-4 leading-snug flex items-center flex-wrap gap-2',
		'link_class'    => 'text-muted hover:text-primary transition-colors',
		'current_class' => 'text-heading font-medium',
		'sep_html'      => '<span class="text-muted/60">/</span>',
		'home_label'    => 'Home',
	) );

	$crumbs = _3dp_breadcrumbs_build_crumbs( (string) $args['home_label'] );

	echo '<nav aria-label="breadcrumb" class="' . esc_attr( $args['nav_class'] ) . '">';

	$total = count( $crumbs );
	foreach ( $crumbs as $index => $item ) {
		$is_last = ( $index === $total - 1 );
		$label   = isset( $item['label'] ) ? (string) $item['label'] : '';
		$url     = isset( $item['url'] ) ? (string) $item['url'] : '';

		if ( '' === $label ) {
			continue;
		}

		if ( $index > 0 ) {
			echo $args['sep_html'];
		}

		if ( $is_last ) {
			echo '<span class="' . esc_attr( $args['current_class'] ) . '">' . esc_html( $label ) . '</span>';
			continue;
		}

		if ( $url ) {
			echo '<a href="' . esc_url( $url ) . '" class="' . esc_attr( $args['link_class'] ) . '">' . esc_html( $label ) . '</a>';
		} else {
			echo '<span class="' . esc_attr( $args['link_class'] ) . '">' . esc_html( $label ) . '</span>';
		}
	}

	echo '</nav>';

	_3dp_breadcrumbs_render_schema_once( $crumbs );
}

/**
 * ==============================================================================
 * H1 Safety Check (H1 安全检查 - 备用)
 * ==============================================================================
 * 
 * 如果页面没有 Hero Banner 模块，可能会导致页面缺少 H1 标签。
 * 下面的过滤器可以强制开启 GeneratePress 默认的标题输出。
 * 目前暂时注释掉，假设所有页面都由 Editor 正确配置了 Hero 模块。
 */
// add_filter( 'generate_show_title', 'tdp_control_content_title' );
