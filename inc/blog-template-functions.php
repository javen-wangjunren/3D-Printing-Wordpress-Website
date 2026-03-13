<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! function_exists( '_3dp_get_builder_content' ) ) {
	/**
	 * Retrieve the full content of a post, handling both Standard and Builder modes.
	 * Useful for Read Time calculation and TOC generation.
	 *
	 * @param int|null $post_id Post ID.
	 * @return string Full HTML content.
	 */
	function _3dp_get_builder_content( $post_id = null ) {
		$post_id = $post_id ?: get_the_ID();
		
		// Check if Builder Mode is active
		$use_builder = get_field( 'post_use_builder', $post_id );

		if ( ! $use_builder ) {
			return (string) get_post_field( 'post_content', $post_id );
		}

		// Builder Mode: Aggregate content from ACF fields
		$content = '';
		if ( have_rows( 'post_body', $post_id ) ) {
			while ( have_rows( 'post_body', $post_id ) ) {
				the_row();
				$layout = get_row_layout();

				if ( $layout == 'richtext' ) {
 					$content .= get_sub_field( 'richtext_content' );
 				} elseif ( $layout == 'table' ) {
					$content .= ' ' . get_sub_field( 'table_caption' );
					$csv_data = get_sub_field( 'table_data' );
					if ( $csv_data ) {
						$content .= ' ' . $csv_data;
					}
 				} elseif ( $layout == 'callout' ) {
 					$content .= ' ' . get_sub_field( 'callout_title' ) . ' ' . get_sub_field( 'callout_content' );
 				} elseif ( $layout == 'cta' && get_sub_field( 'cta_type' ) == 'card' ) {
 					$content .= ' ' . get_sub_field( 'cta_title' );
 				} elseif ( $layout == 'image' ) {
 					$content .= ' ' . get_sub_field( 'image_caption' );
 				}
			}
		}

		return $content;
	}
}


if ( ! function_exists( '_3dp_get_post_toc' ) ) {
	function _3dp_get_post_toc( $content ) {
		$content = (string) $content;
		$toc     = array();
		$used    = array();

		if ( preg_match_all( '/<h2\b[^>]*>(.*?)<\/h2>/is', $content, $matches ) ) {
			foreach ( $matches[1] as $heading_html ) {
				$title = trim( wp_strip_all_tags( $heading_html ) );
				if ( $title === '' ) {
					continue;
				}

				$base = sanitize_title( $title );
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

				$toc[] = array(
					'id'    => $id,
					'title' => $title,
				);
			}
		}

		return $toc;
	}
}

if ( ! function_exists( '_3dp_add_ids_to_h2' ) ) {
	function _3dp_add_ids_to_h2( $content ) {
		if ( ! is_singular( 'post' ) ) {
			return $content;
		}

		$used = array();

		return preg_replace_callback(
			'/<h2\b([^>]*)>(.*?)<\/h2>/is',
			function( $m ) use ( &$used ) {
				$attrs = (string) $m[1];
				$inner = (string) $m[2];

				if ( preg_match( '/\bid\s*=\s*("|\')(.*?)\1/i', $attrs ) ) {
					return '<h2' . $attrs . '>' . $inner . '</h2>';
				}

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

				return '<h2 id="' . esc_attr( $id ) . '"' . $attrs . '>' . $inner . '</h2>';
			},
			$content
		);
	}
	add_filter( 'the_content', '_3dp_add_ids_to_h2', 20 );
}
