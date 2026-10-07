<?php
// Les aides du gabarit restent séparées de ses fichiers HTML.
require_once get_stylesheet_directory() . '/inc/layout.php';
require_once get_stylesheet_directory() . '/inc/elementor-compat.php';

/** Affiche le gabarit d'accueil même si son format Elementor est pleine largeur. */
function bbq_run_front_page_template( $template ) {
	if ( is_front_page() && ! is_home() ) {
		return get_stylesheet_directory() . '/front-page.php';
	}
	return $template;
}
add_filter( 'template_include', 'bbq_run_front_page_template', 100 );

/** Charge les styles du thème enfant après ceux du thème parent et du constructeur de pages. */
function bbq_run_enqueue_styles() {
	wp_enqueue_style(
		'bbq-run-style',
		get_stylesheet_uri(),
		array( 'astra-theme-css' ),
		(string) filemtime( get_stylesheet_directory() . '/style.css' )
	);
	wp_enqueue_style(
		'bbq-run-theme',
		get_stylesheet_directory_uri() . '/assets/css/theme.css',
		array( 'bbq-run-style' ),
		(string) filemtime( get_stylesheet_directory() . '/assets/css/theme.css' )
	);
	wp_enqueue_style(
		'bbq-run-layout',
		get_stylesheet_directory_uri() . '/assets/css/layout.css',
		array( 'bbq-run-theme' ),
		(string) filemtime( get_stylesheet_directory() . '/assets/css/layout.css' )
	);
	wp_enqueue_script(
		'bbq-run-layout',
		get_stylesheet_directory_uri() . '/assets/js/layout.js',
		array(),
		(string) filemtime( get_stylesheet_directory() . '/assets/js/layout.js' ),
		true // Les détails natifs fonctionnent sans script ; celui-ci améliore le clavier.
	);

	if ( is_front_page() && file_exists( get_stylesheet_directory() . '/assets/css/home.css' ) ) {
		// Le hero possède ses styles pour rester facile à modifier.
		wp_enqueue_style(
			'bbq-run-home',
			get_stylesheet_directory_uri() . '/assets/css/home.css',
			array( 'bbq-run-layout' ),
			(string) filemtime( get_stylesheet_directory() . '/assets/css/home.css' )
		);
	}

	// Les fichiers de la page 404 ne sont chargés que si cette page s'affiche.
	if ( is_404() ) {
		// Les versions basées sur la date de modification évitent de conserver les anciens fichiers en cache.
		$bbq_404_css = get_stylesheet_directory() . '/assets/css/404.css';
		$bbq_404_js  = get_stylesheet_directory() . '/assets/js/404.js';

		wp_enqueue_style(
			'bbq-run-404',
			get_stylesheet_directory_uri() . '/assets/css/404.css',
			array( 'bbq-run-theme' ),
			file_exists( $bbq_404_css ) ? (string) filemtime( $bbq_404_css ) : null
		);
		wp_enqueue_script(
			'bbq-run-404',
			get_stylesheet_directory_uri() . '/assets/js/404.js',
			array(),
			file_exists( $bbq_404_js ) ? (string) filemtime( $bbq_404_js ) : null,
			true // Charge le script dans le pied de page pour ne pas bloquer l'affichage initial.
		);
	}
}
// La priorité 99 place ces styles après ceux enregistrés plus tôt par les extensions.
add_action( 'wp_enqueue_scripts', 'bbq_run_enqueue_styles', 99 );

/** Enregistre un emplacement éditable pour les liens secondaires du pied de page. */
function bbq_run_register_menus() {
	register_nav_menus(
		array(
			'bbq-footer' => __( 'Menu du pied de page', 'bbq-run' ),
		)
	);
}
add_action( 'after_setup_theme', 'bbq_run_register_menus', 20 );

/**
 * Fournit une navigation de secours quand aucun menu principal n'est attribué.
 * Les liens vers la boutique et les pages ne sont ajoutés que s'ils existent.
 *
 * @param array $args Arguments de wp_nav_menu().
 * @return string
 */
function bbq_run_primary_menu_fallback( $args ) {
	$bbq_links = array(
		'<li class="menu-item"><a href="' . esc_url( home_url( '/' ) ) . '">' . esc_html__( 'Accueil', 'bbq-run' ) . '</a></li>',
	);

	$bbq_shop_url = bbq_run_woo_page_url( 'shop' );
	if ( $bbq_shop_url ) {
		$bbq_links[] = '<li class="menu-item"><a href="' . esc_url( $bbq_shop_url ) . '">' . esc_html__( 'Boutique', 'bbq-run' ) . '</a></li>';
	}

	$bbq_pages = get_pages(
		array(
			'sort_column' => 'menu_order,post_title',
			'number'      => 5,
		)
	);
	foreach ( $bbq_pages as $bbq_page ) {
		$bbq_excluded_page_ids = array_filter(
			array(
				'page' === get_option( 'show_on_front' ) ? (int) get_option( 'page_on_front' ) : 0,
				function_exists( 'wc_get_page_id' ) ? (int) wc_get_page_id( 'shop' ) : 0,
				function_exists( 'wc_get_page_id' ) ? (int) wc_get_page_id( 'cart' ) : 0,
				function_exists( 'wc_get_page_id' ) ? (int) wc_get_page_id( 'checkout' ) : 0,
				function_exists( 'wc_get_page_id' ) ? (int) wc_get_page_id( 'myaccount' ) : 0,
			)
		);
		if ( in_array( (int) $bbq_page->ID, $bbq_excluded_page_ids, true ) ) {
			continue;
		}
		$bbq_links[] = '<li class="menu-item"><a href="' . esc_url( get_permalink( $bbq_page ) ) . '">' . esc_html( get_the_title( $bbq_page ) ) . '</a></li>';
	}

	echo '<ul class="' . esc_attr( isset( $args['menu_class'] ) ? $args['menu_class'] : 'bbq-menu' ) . '">' . implode( '', $bbq_links ) . '</ul>';
	return '';
}

/** Navigation de secours du pied de page, composée de pages publiées réelles. */
function bbq_run_footer_menu_fallback( $args ) {
	$bbq_pages = get_pages(
		array(
			'sort_column' => 'menu_order,post_title',
			'number'      => 6,
		)
	);
	$bbq_links = array();
	foreach ( $bbq_pages as $bbq_page ) {
		$bbq_links[] = '<li><a href="' . esc_url( get_permalink( $bbq_page ) ) . '">' . esc_html( get_the_title( $bbq_page ) ) . '</a></li>';
	}

	if ( ! $bbq_links ) {
		return '';
	}
	$bbq_class = isset( $args['menu_class'] ) ? $args['menu_class'] : 'bbq-footer__list';
	echo '<ul class="' . esc_attr( $bbq_class ) . '">' . implode( '', $bbq_links ) . '</ul>';
	return '';
}

/** Ajoute le lien Boutique au menu primaire si WooCommerce la fournit déjà. */
function bbq_run_add_shop_to_primary_menu( $items, $args ) {
	if ( empty( $args->theme_location ) || 'primary' !== $args->theme_location ) {
		return $items;
	}

	$bbq_shop_url = bbq_run_woo_page_url( 'shop' );
	if ( ! $bbq_shop_url ) {
		return $items;
	}
	if ( false !== strpos( $items, esc_url( $bbq_shop_url ) ) ) {
		return $items;
	}

	return $items . '<li class="menu-item menu-item-type-post_type bbq-menu-shop"><a href="' . esc_url( $bbq_shop_url ) . '">' . esc_html__( 'Boutique', 'bbq-run' ) . '</a></li>';
}
add_filter( 'wp_nav_menu_items', 'bbq_run_add_shop_to_primary_menu', 10, 2 );

/** Empêche Astra et Elementor de charger les polices Google depuis un serveur distant. */
add_filter( 'astra_google_fonts', '__return_empty_array' );
add_filter( 'elementor/frontend/print_google_fonts', '__return_false' );
