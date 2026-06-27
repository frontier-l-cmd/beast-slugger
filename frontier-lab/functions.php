<?php
/**
 * FRONTIER LAB. — theme bootstrap
 *
 * 仕様書（frontierlabspec.md）§8 に基づき、ブロックテーマ（FSE）の最小限の
 * PHP 配線のみを行う。デザインは theme.json と style.css が正本。
 *
 * @package frontier-lab
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! function_exists( 'frontier_lab_setup' ) ) {
	/**
	 * テーマ基本サポート。
	 */
	function frontier_lab_setup() {
		add_theme_support( 'wp-block-styles' );
		add_theme_support( 'responsive-embeds' );
		add_theme_support( 'editor-styles' );
		add_theme_support( 'title-tag' );
		add_theme_support( 'html5', array( 'style', 'script' ) );

		// ブロックエディタにも本文スタイルを反映（編集中も実物に近づける）。
		add_editor_style( 'style.css' );

		load_theme_textdomain( 'frontier-lab', get_template_directory() . '/languages' );
	}
}
add_action( 'after_setup_theme', 'frontier_lab_setup' );

if ( ! function_exists( 'frontier_lab_assets' ) ) {
	/**
	 * フォントと本体スタイルの読み込み。
	 * 書体：Shippori Mincho B1 / Newsreader / Zen Kaku Gothic New / JetBrains Mono。
	 */
	function frontier_lab_assets() {
		// Google Fonts（preconnect で初期表示を詰める）。
		wp_enqueue_style(
			'frontier-lab-google-fonts',
			'https://fonts.googleapis.com/css2?family=Newsreader:ital,opsz,wght@0,6..72,400;0,6..72,500;1,6..72,400&family=Shippori+Mincho+B1:wght@400;500;600&family=Zen+Kaku+Gothic+New:wght@400;500&family=JetBrains+Mono:wght@400;500&display=swap',
			array(),
			null
		);

		// テーマ本体（style.css のヘッダー＋補助コンポーネント）。
		wp_enqueue_style(
			'frontier-lab-style',
			get_stylesheet_uri(),
			array( 'frontier-lab-google-fonts' ),
			wp_get_theme()->get( 'Version' )
		);
	}
}
add_action( 'wp_enqueue_scripts', 'frontier_lab_assets' );

if ( ! function_exists( 'frontier_lab_preconnect' ) ) {
	/**
	 * Google Fonts への preconnect。
	 */
	function frontier_lab_preconnect( $urls, $relation_type ) {
		if ( 'preconnect' === $relation_type ) {
			$urls[] = array( 'href' => 'https://fonts.googleapis.com' );
			$urls[] = array(
				'href'        => 'https://fonts.gstatic.com',
				'crossorigin' => 'anonymous',
			);
		}
		return $urls;
	}
}
add_filter( 'wp_resource_hints', 'frontier_lab_preconnect', 10, 2 );

if ( ! function_exists( 'frontier_lab_pattern_category' ) ) {
	/**
	 * 図版3型・導線パターンをまとめるカテゴリ。
	 */
	function frontier_lab_pattern_category() {
		register_block_pattern_category(
			'frontier-lab',
			array( 'label' => __( 'FRONTIER LAB.', 'frontier-lab' ) )
		);
	}
}
add_action( 'init', 'frontier_lab_pattern_category' );

if ( ! function_exists( 'frontier_lab_ogp' ) ) {
	/**
	 * OGP（X共有カード）。仕様書 §7：白地＋記事タイトルの抑えた定型カード。
	 * 顔・大コピー・煽りサムネは出さない。画像は同梱の og-default.svg/png を使う。
	 */
	function frontier_lab_ogp() {
		$site_name = get_bloginfo( 'name' );

		if ( is_singular() ) {
			$title = get_the_title();
			$url   = get_permalink();
			$desc  = wp_strip_all_tags( get_the_excerpt() );
			$type  = 'article';
		} else {
			$title = $site_name;
			$url   = home_url( '/' );
			$desc  = get_bloginfo( 'description' );
			$type  = 'website';
		}

		$image = get_template_directory_uri() . '/assets/og-default.png';

		printf( "\n<meta property=\"og:type\" content=\"%s\">\n", esc_attr( $type ) );
		printf( "<meta property=\"og:site_name\" content=\"%s\">\n", esc_attr( $site_name ) );
		printf( "<meta property=\"og:title\" content=\"%s\">\n", esc_attr( $title ) );
		printf( "<meta property=\"og:description\" content=\"%s\">\n", esc_attr( $desc ) );
		printf( "<meta property=\"og:url\" content=\"%s\">\n", esc_url( $url ) );
		printf( "<meta property=\"og:image\" content=\"%s\">\n", esc_url( $image ) );
		printf( "<meta name=\"twitter:card\" content=\"%s\">\n", 'summary_large_image' );
		printf( "<meta name=\"twitter:title\" content=\"%s\">\n", esc_attr( $title ) );
		printf( "<meta name=\"twitter:description\" content=\"%s\">\n", esc_attr( $desc ) );
		printf( "<meta name=\"twitter:image\" content=\"%s\">\n", esc_url( $image ) );
	}
}
add_action( 'wp_head', 'frontier_lab_ogp', 5 );

if ( ! function_exists( 'frontier_lab_excerpt_more' ) ) {
	/**
	 * 抜粋の「[…]」を控えめな三点に。煽らない。
	 */
	function frontier_lab_excerpt_more() {
		return '…';
	}
}
add_filter( 'excerpt_more', 'frontier_lab_excerpt_more' );

if ( ! function_exists( 'frontier_lab_excerpt_length' ) ) {
	/**
	 * 編集リストの抜粋は短く（2行程度）。
	 */
	function frontier_lab_excerpt_length() {
		return 60;
	}
}
add_filter( 'excerpt_length', 'frontier_lab_excerpt_length', 999 );
