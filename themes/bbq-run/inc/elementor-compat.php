<?php
/** Compatibilité avec les documents WooCommerce temporaires de PRO Elements. */
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Retire uniquement le chargement de scripts des documents sans article associé.
 * PRO Elements crée ces objets pour ses conditions d'affichage ; sur une 404,
 * leur méthode enqueue_scripts() tente de lire l'identifiant d'un article nul.
 * Les vrais modèles Elementor conservent leur chargement habituel.
 */
function bbq_run_skip_empty_product_archive_scripts() {
	global $wp_filter;

	if ( empty( $wp_filter['wp_enqueue_scripts'] ) ) {
		return;
	}

	foreach ( $wp_filter['wp_enqueue_scripts']->callbacks as $priority => $callbacks ) {
		foreach ( $callbacks as $callback ) {
			$handler = $callback['function'];
			if ( ! is_array( $handler ) || 'enqueue_scripts' !== $handler[1] ) {
				continue;
			}
			$document = $handler[0];
			if ( ( $document instanceof \ElementorPro\Modules\Woocommerce\Documents\Product_Archive
				|| $document instanceof \ElementorPro\Modules\Woocommerce\Documents\Product )
				&& ! ( $document->get_post() instanceof WP_Post ) ) {
				remove_action( 'wp_enqueue_scripts', $handler, $priority );
			}
		}
	}
}
// Les documents sont déjà créés, mais leurs scripts ne sont pas encore chargés.
add_action( 'wp_enqueue_scripts', 'bbq_run_skip_empty_product_archive_scripts', 10 );
