<?php
/** Petites aides partagées par les gabarits d'en-tête et de pied de page. */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/** Affiche le menu principal avec les mêmes réglages sur ordinateur et mobile. */
function bbq_run_primary_menu( $menu_id, $menu_class ) {
	wp_nav_menu(
		array(
			'theme_location' => 'primary',
			'menu_id'        => $menu_id,
			'menu_class'     => $menu_class,
			'container'      => false,
			'fallback_cb'    => 'bbq_run_primary_menu_fallback',
			'depth'          => 2,
		)
	);
}

/** Retourne l'URL d'une page WooCommerce uniquement si elle est publiée. */
function bbq_run_woo_page_url( $page ) {
	if ( ! function_exists( 'wc_get_page_id' ) || ! function_exists( 'wc_get_page_permalink' ) ) {
		return '';
	}

	$page_id = wc_get_page_id( $page );
	return $page_id > 0 && 'publish' === get_post_status( $page_id ) ? wc_get_page_permalink( $page ) : '';
}

/** Renvoie l'icône de recherche SVG réutilisée dans les deux commandes de recherche. */
function bbq_run_search_icon() {
	return '<svg viewBox="0 0 24 24" aria-hidden="true" focusable="false"><circle cx="10.8" cy="10.8" r="6.8"></circle><path d="m16 16 5 5"></path></svg>';
}

/** Prépare une fois les pages publiées repérées pour le pied de page. */
function bbq_run_footer_pages() {
	$pages = get_pages( array( 'sort_column' => 'menu_order,post_title' ) );
	$data  = array( 'contact' => null, 'legal' => array() );

	foreach ( $pages as $page ) {
		$key = remove_accents( strtolower( $page->post_name . ' ' . $page->post_title ) );
		if ( ! $data['contact'] && preg_match( '/conta[ct]+/', $key ) ) {
			$data['contact'] = $page;
		}
		if ( preg_match( '/privacy|confidential|mention|legal|terms|condition|refund|retour|livraison|shipping/', $key ) ) {
			$data['legal'][] = $page;
		}
	}

	return $data;
}
